<?php
/**
 * @name LinkModel
 * @desc 友情链接模型
 * @author root
 */
class LinkModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获取所有通过申请的友情链接
     */
    public function linklist($admin = false)
    {

        $key = cachekey(__FUNCTION__,$admin);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            if(!$admin)
            {
                $where = 'where status = 1';
            }
            else
            {
                $where = '';
            }
            $sql = "select * from link ".$where;
            $data = $this->db->get_all($sql);
            $this->redis->hset(__CLASS__,$key,$data);
        }
        return $data;
    }

    public function linkadd($title,$url)
    {
        $this->redis->remove(__CLASS__);
        $data = ['title'=>$title,'url'=>$url,'createtime'=>date("Y-m-d H:i:s")];
        return $this->db->safeinsert('link',$data);
    }

    public function updatestatus($id,$status)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->update('link',['status'=>$status],'id = '.$id);
    }

    public function deletelink($id)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->delete('link','id = '.$id);
    }
}
