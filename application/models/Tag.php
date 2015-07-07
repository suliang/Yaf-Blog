<?php
/**
 * @name TagModel
 * @desc 标签模型
 * @author root
 */
class TagModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }


    /**
     * 获取文章的标签
     */
    public function blogtotags($blogid,$admin = false)
    {
        $blogid = (int)$blogid;
        $key = cachekey(__FUNCTION__,$blogid);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data) || $admin)
        {
            $sql = "select tagid from blogtag where blogid = {$blogid}";
            $arr = $this->db->get_all($sql);
            foreach($arr as $value)
            {
                $sql = "select * from tag where id = {$value['tagid']}";
                $row = $this->db->get_one($sql);
                if($admin)
                {
                    $tags = '';
                    $tags .= $row['name'].',';
                }
                else
                {
                    $tags[] = $row;
                }
            }
            if($admin && $tags)
            {
                $tags = substr($tags,0,-1);         //去掉末尾的逗号
            }
            $data = $tags;
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    /**
     * 查出五个最热门的标签
     * 热门标签
     */
    public function hottags($num = 5)
    {
        $key = cachekey(__FUNCTION__,$num);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = array();
            $sql = "SELECT tagid  from blogtag GROUP BY tagid order by count(*) desc limit ".$num;          //找出了这五个的tagid
            $arr = $this->db->get_all($sql);
            foreach($arr as $value)
            {
                $data[$value['tagid']] = $this->tagname($value['tagid']);
            }
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    /**
     * 获取tag的名称
     * @param $tagid
     */
    public function tagname($tagid)
    {
        $alltags = $this->alltags();
        return $alltags[$tagid]['name'];
    }

    /**
     * 检测tag是否存在
     * 如果存在则返回id
     * @param $name
     */
    public function existstag($name)
    {
        $sql = "select count(*) as c from tag where name ='{$name}'";
        $c = $this->db->get_one($sql,'c');
        if($c > 0)
        {
            $sql = "select id from tag where name = '{$name}'";
            $id = $this->db->get_one($sql,'id');
            return $id;
        }
        else
        {
            return 0;
        }
    }



    /**
     * 新增博客标签关联表的tags
     * @param $tags
     */
    public function addblogtags($tags,$blogid)
    {
        if(!$tags)
        {
            return false;
        }
        $tagarr = explode(',',$tags);

        foreach($tagarr as $value)
        {
            $tagid = $this->existstag($value);
            //tag已存在
            if($tagid > 0)
            {
                $exists = $this->existstagblog($blogid,$tagid);
                if($exists > 0)
                {
                    continue;
                }
                else
                {
                    $this->addblogtag($tagid,$blogid);
                }
            }
            else        //tag不存在
            {
                $tagid = $this->addtag($value);
                $this->addblogtag($tagid,$blogid);
            }
        }
        $this->redis->remove(__CLASS__);
    }



    /**
     * 检测tag和blogid是否关联过
     * @param $blogid
     * @param $tag
     */
    public function existstagblog($blogid,$tagid)
    {
        $sql = "select count(*) as c from blogtag where blogid = {$blogid} and tagid = {$tagid}";
        return $this->db->get_one($sql,'c');
    }

    /**
     * 获取所有标签和id
     * @return mixed
     */
    public function alltags()
    {
        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = [];
            $sql = "select * from tag";
            $arr = $this->db->get_all($sql);
            foreach($arr as $value)
            {
                $data[$value['id']] = $value;
            }
            $this->redis->hset(__CLASS__,$key,$data);
        }
        return $data;
    }

    /**
     * 标签被使用过的次数
     * @param $tagid
     * @return mixed
     */
    public function tagcount($tagid)
    {
        $sql = "select count(*) as c from blogtag where tagid = {$tagid}";
        $c = $this->db->get_one($sql,'c');
        return $c;
    }

    public function updatetag($tagid,$name)
    {
        $exists = $this->existstag($name);
        if(!$exists)
        {
            return $this->db->update('tag',['name'=>$name],'id = '.$tagid);
        }
        else
        {
            return false;
        }
    }


    /**
     * @param $tagid
     * @param 0 or 1 $join 是否删除所有关联
     * @return bool
     */
    public function delete($tagid,$join)
    {
        $this->redis->remove(__CLASS__);
        if($join > 0)
        {

            $result = $this->db->delete('blogtag','tagid ='.$tagid);
            if($result)
            {
                return $this->db->delete('tag','id = '.$tagid);
            }
            else
            {
                return $result;
            }

        }
        else
        {
           return $this->db->delete('tag','id = '.$tagid);
        }
    }

    public function tagjoin($tagid)
    {
        $sql = "select blogid from blogtag where tagid = {$tagid} group by blogid";
        $arr = $this->db->get_all($sql);
        return $arr;
    }


    public function deletejoin($tagid,$blogid)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->delete('blogtag',"tagid = {$tagid} and blogid = {$blogid}");
    }

    /**
     * 新增标签
     * @param $name
     * @return mixed
     */
    private function addtag($name)
    {
        $this->db->insert('tag',['name'=>$name]);
        return $this->db->insert_id();
    }

    private function addblogtag($tagid,$blogid)
    {
        $this->db->insert('blogtag',['tagid'=>$tagid,'blogid'=>$blogid]);
    }
}
