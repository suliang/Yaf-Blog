<?php
/**
 * @name CatModel
 * @desc 综合模型
 * @author root
 */
class CatModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }



    public function siteinfo()
    {
        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $data = [];
            $sql = "select * from cat";
            $arr = $this->db->get_all($sql);
            foreach($arr as $value)
            {
                $data[$value['name']] = $value;
            }

            $this->redis->hset(__CLASS__,$key,$data);
        }
        return $data;
    }


    public function updateinfo($id,$value)
    {
        $this->redis->remove(__CLASS__);
        return $this->db->update('cat',['value'=>$value],'id = '.$id);
    }

    /**
     * 是否允许此IP发出登陆请求
     * @param $ip
     * @return bool
     */
    public function allowiplogin($ip)
    {
        $key = cachekey('allow_login',$ip);
        $data = $this->redis->get($key);
        if($data >= 3)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 登陆失败调用此方法
     * 1分钟之内只允许错3次 三次后不允许登陆
     * @param $ip
     */
    public function faildlogin($ip)
    {
        $key = cachekey('allow_login',$ip);
        $result = $this->redis->getRedis()->exists($key);

        if($result)
        {
            $this->redis->incr($key);
        }
        else
        {
            $this->redis->set($key,1,600);
        }

    }

}
