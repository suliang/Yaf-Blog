<?php
/**
 * @name BlogtypeModel
 * @desc 博客类型模型
 * @author root
 */
class BlogtypeModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获取博客的类型和父类型
     * @param $typeid
     * @return array 1 有父类型 0 无父类型
     */
    public function getblogtype($typeid)
    {
        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = [];
            $sql = "select * from blogtype";
            $arr = $this->db->get_all($sql);
            foreach($arr as $value)
            {
                $data[$value['id']]['name'] = $value['name'];
                $data[$value['id']]['topid'] = $value['topid'];
            }
            $this->redis->hset(__CLASS__,$key,$data);
        }
        $result[0] = $data[$typeid];
        if($result[0]['topid'] > 0)
        {
            $result[1] = $data[$result[0]['topid']];
        }
        return $result;
    }

    /**
     * 获取某篇博客的客户评论数量
     * @param $blogid
     * @return int
     */
    public function countcomment($blogid)
    {
        $sql = "select count(*) as c from comment where blogid = {$blogid} and replyid <= 0";
        return $this->db->get_one($sql,'c');
    }

    /**
     * 获取博客的所有类型
     * 父可以没子 子不可没父
     */
    public function alltypes()
    {
        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $sql = "select * from blogtype";
            $arr = $this->db->get_all($sql);

            $data = [];

            foreach($arr as $value)
            {

                if($value['topid'] == 0)
                {
                    $data[$value['id']] = ['name'=>$value['name']];
                }
                else
                {
                    $data[$value['topid']]['child'][$value['id']] = $value['name'];
                }
            }
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    public function allfutype()
    {
        $sql = "select id,name,topid from blogtype where topid = 0";
        $arr = $this->db->get_all($sql);
        return $arr;
    }

    public function addfutype($name)
    {
        $this->redis->remove(__CLASS__);
        $this->db->insert('blogtype',['name'=>$name]);
        return $this->db->insert_id();
    }

    public function addzitype($topid,$name)
    {
        $this->redis->remove(__CLASS__);
        $this->db->insert('blogtype',['name'=>$name,'topid'=>$topid]);
        return $this->db->insert_id();
    }
    public function existstype($name)
    {
        $sql = "select count(*) as c from blogtype where name = '{$name}'";
        return $this->db->get_one($sql,'c');
    }

    public function updatetype($typeid,$arr)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->update('blogtype',$arr,'id = '.$typeid);
    }
    public function addtype($topid,$name)
    {
        $result = $this->existstype($name);
        if($result > 0)
        {
            return -1;
        }
        else
        {
            $this->redis->remove(__CLASS__);
            $this->db->insert('blogtype',['topid'=>$topid,'name'=>$name]);
            return $this->db->insert_id();
        }

    }




    public function deletetype($typeid)
    {
        $this->redis->remove(__CLASS__);
        //查他是不是父类型 不是直接删 是的话继续查
        $sql = "select topid from blogtype where id = {$typeid}";
        $topid = $this->db->get_one($sql,'topid');
        if($topid == 0)     //父类型
        {
            $exists1 = $this->existschildtype($typeid);
            $exists2 = $this->existsjoinblog($typeid);
            if($exists1 > 0 || $exists2 > 0)
            {
                return false;
            }
            else
            {
                return $this->db->delete('blogtype','id = '.$typeid);
            }
        }
        else
        {
            $this->db->update('blog',['type'=>$topid],'type = '.$typeid);
            $this->db->delete('blogtype','id = '.$typeid);
            return true;
        }
    }

    private function existschildtype($typeid)
    {
        $sql = "select count(*) as c from blogtype where topid = ".$typeid;
        return $topid = $this->db->get_one($sql,'c');
    }

    private function existsjoinblog($typeid)
    {
        $sql = "select count(*) as c from blog where type = ".$typeid;
        return $this->db->get_one($sql,'c');
    }


    public function getblogtypeid($name)
    {
        $alltypes = $this->alltypes();
        foreach($alltypes as $key=>$value)
        {
            if($value['name'] == $name)
            {
                return $key;
            }
            else
            {
                if(array_key_exists('child',$value))
                {
                    foreach($value['child'] as $k=>$v)
                    {
                        if($v == $name)
                        {
                            return $k;
                        }
                    }
                }
            }

        }
        return 0;
    }

    public function getchildbyparent($typeid)
    {
        $arr = $this->alltypes();
        $childs = '';
        if(array_key_exists($typeid,$arr))
        {
            if(array_key_exists('child',$arr[$typeid]))
            {
                $childarr = array_keys($arr[$typeid]['child']);
                $childs = implode(',',$childarr);
            }
        }
        return $childs;
    }
}
