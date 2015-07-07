<?php
/**
 * @name CommentModel
 * @desc 评论模型
 * @author root
 */
class CommentModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 检测哪些blog有新评论
     * @return array blogids
     */
    public function existsnewcomment()
    {
        $sql = "select blogid from comment where replyid = 0 group by blogid";
        $arr = $this->db->get_all($sql);
        $blogs = [];
        foreach($arr as $value)
        {
            $blogs[] = $value['blogid'];
        }
        return $blogs;
    }

    /**
     * 获取某篇博客的客户评论数量
     * @param $blogid
     * @return int
     */
    public function countcomment($blogid)
    {
        $key = cachekey(__FUNCTION__,$blogid);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $sql = "select count(*) as c from comment where blogid = {$blogid} and replyid <= 0";
            $data = $this->db->get_one($sql,'c');
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    /**
     * 评论列表
     * @param bool $reply 是否只列出未回复的
     * @return mixed
     */
    public function commentlist($offset = 20, $limit = 0,$reply = false)
    {
        if($reply)
        {
            $where = " where replyid = 0 ";
        }
        else
        {
            $where = "";
        }
        $sql = "select * from comment {$where}  order by id desc limit {$limit}, {$offset}";
        return $this->db->get_all($sql);
    }

    public function commentcount($reply = false)
    {
        if($reply)
        {
            $where = " where replyid = 0 ";
        }
        else
        {
            $where = "";
        }
        $sql = "select count(*) as c from comment {$where}";
        return $this->db->get_one($sql,'c');
    }

    public function addcomment($content,$blogid,$replyid = 0,$nickname = '')
    {
        $this->redis->remove(__CLASS__);
        if(!$nickname)
        {
            $this->db->update('comment',['replyid'=>-1],'id = '.$replyid);
            $data = ['replyid'=>$replyid,'content'=>$content,'blogid'=>$blogid];
            return $this->db->insert('comment',$data);
        }
        else
        {
            $data = ['replyid'=>$replyid,'content'=>$content,'nickname'=>$nickname,'blogid'=>$blogid];
            return $this->db->safeinsert('comment',$data);
        }

    }

    public function updatecomment($content,$id)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->update('comment',['content'=>$content],'id = '.$id);
    }

    public function delcomment($id)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->delete('comment','id = '.$id);
    }

    public function blogcomments($blogid,$admin = false)
    {
        $key = cachekey(__FUNCTION__,$blogid);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data) || $admin)
        {
            if($admin)
            {
                $where = "replyid <= 0 and ";
            }
            $sql = "select * from comment where {$where} blogid = ".$blogid;
            $data = $this->db->get_all($sql);
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    public function allowcomment($ip)
    {
        $key = cachekey('allow_comment',$ip);
        $data = $this->redis->get($key);
        if($data >= 2)
        {
            return false;
        }
        else
        {
            if($data > 0)
            {
                $this->redis->incr($key);
            }
            else
            {
                $this->redis->set($key,1,60);
            }
            return true;
        }
    }

}
