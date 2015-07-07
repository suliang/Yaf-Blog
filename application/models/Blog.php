<?php
/**
 * @name BlogModel
 * @desc 博客模型
 * @author root
 */
class BlogModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }



    /**
     * 获取博客列表 -1 删除 0 草稿 1 正常 2 置顶
     */
    public function bloglist($offset = 20, $limit = 0, $blogtype = 0, $childtypes = '')
    {
        $key = cachekey(__FUNCTION__,[$offset,$limit,$blogtype]);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $where = '';
            if($childtypes)
            {
                $where = "and type in ({$blogtype},{$childtypes})";
            }
            else
            {
                if($blogtype > 0)
                {
                    $where = "and type = ".$blogtype;
                }
            }
            $sql = "select * from blog
                where status > 0 and id > 1 {$where}
                order by status desc,id desc
                limit {$limit},{$offset}
                ";
            $data = $this->db->get_all($sql);

            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    public function blogcount($blogtype = 0,$childtypes = '')
    {
        $key = cachekey(__FUNCTION__,$blogtype);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $where = '';
            if($childtypes)
            {
                $where = "and type in ({$blogtype},{$childtypes})";
            }
            else
            {
                if($blogtype > 0)
                {
                    $where = "and type = ".$blogtype;
                }
            }
            $sql = "select count(*) as c from blog
                where status > 0 and id > 1 {$where}
                ";
            $data = $this->db->get_one($sql,'c');
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    /**
     * 后台 获取博客列表
     * @param $offset
     * @param $limit
     * @param string $sort 不论按哪种排序 最后都按id倒序   status
     */
    public function adminlist($offset = 20, $limit = 0, $where = '', $sort = '')
    {
        if($sort)
        {
            $order = $sort.',';
        }
        if($where)
        {

            $where = "where ".$where;
        }

        $sql = "select * from blog
                order by {$order}id desc
                {$where}
                limit {$limit},{$offset}
                ";
        $arr = $this->db->get_all($sql);
        return $arr;
    }

    /**
     * 后台列表博客总量
     * @param string $where
     * @return mixed
     */
    public function adminlistcount($where = '')
    {
        if($where)
        {

            $where = "where ".$where;
        }
        $sql = "select count(*) as c from blog {$where} ";
        return $this->db->get_one($sql,'c');
    }
    /**
     * 新增blog
     * 涉及到的表：blog content | blogtag tag
     * @param $data
     */
    public function add_blog($data)
    {
        $this->redis->remove(__CLASS__);
        $this->db->insert('blog', $data);
        return $this->db->insert_id();
    }

    /**
     * 后台 修改blog的状态
     */
    public function update_status($blogid,$status)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->update('blog',['status' => $status],"id = {$blogid}");
    }

    /**
     * 更改blog的基础信息
     * @param $blogid
     * @param $arr
     * @param $condit
     */
    public function update_blog($data)
    {
        $this->redis->remove(__CLASS__);
        $blog = $this->db->update('blog', $data['blog'], "id = {$data['blogid']}");
        $content = $this->db->update('content', $data['content'], "blogid = {$data['blogid']}");
        if($blog && $content)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * 新增博客的内容
     * @param $data
     */
    public function add_content($blogid, $content = '')
    {
        $this->redis->remove(__CLASS__);
        return $this->db->insert('content', ['blogid'=>$blogid,'content'=>$content]);
    }


    /**
     * 获取文章详情：标题 内容 等
     * @param $blogid
     */
    public function bloginfo($blogid,$content = true)
    {
        $blogid = (int)$blogid;
        $key = cachekey(__FUNCTION__,$blogid);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = $this->db->get_one("select * from blog where id = {$blogid}");
            $this->redis->hset(__CLASS__,$key,$data);
        }
        if($content)
        {
            $data['content'] = $this->blogcontent($blogid);
        }
        return $data;
    }

    private function blogcontent($blogid)
    {
        $key = cachekey(__FUNCTION__,$blogid);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = $this->db->get_one("select content from content where blogid = {$blogid}","content");
            $this->redis->hset(__CLASS__,$key,$data);
        }
        return $data;
    }


    public function getblogs($blogids)
    {
        $arr = [];

        foreach($blogids as $value)
        {
            $arr[] = $this->bloginfo($value,false);
        }
        return $arr;
    }

    /**
     * 是否是可以正常显示的博客
     * @return bool
     */

    public function trueblog($blogid)
    {

        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $sql = "select id from blog where status > 0";
            $arr = $this->db->get_all($sql);
            $data = [];
            foreach($arr as $value)
            {
                $data[$value['id']] = 1;
            }
            $this->redis->hset(__CLASS__,$key,$data);
        }

        if(array_key_exists($blogid,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 文章详情页更新阅读量
     * 阅读量逢10的倍数就改数据库 但是不删blog的缓存
     * @param $blogid
     */
    public function setlook($blogid)
    {
        $key = cachekey($blogid);
        $data = $this->redis->hget('bloglook',$key);
        if(is_bool($data))
        {
            $data = 1;
            $this->redis->hset('bloglook',$key,$data);
        }
        else
        {
            $this->redis->hset('bloglook',$key,$data+1);
            if(($data+1)%10 == 0)
            {
                $this->db->update('blog',['look'=>"look+10"],'id = '.$blogid);
            }

        }

    }

    /**
     * 除了数据库中的阅读量，又有多少阅读量
     * @param $blogid
     * @return int
     */
    public function getlook($blogid)
    {

        $key = cachekey($blogid);
        $data = $this->redis->hget('bloglook',$key);

        if(is_bool($data))
        {
            $data = 0;
            $this->redis->hset('bloglook',$key,$data);
        }
        return $data;
    }

}
