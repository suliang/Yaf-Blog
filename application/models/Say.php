<?php
/**
 * @name SayModel
 * @desc 说说模型
 * @author root
 */
class SayModel
{

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
        $this->redis = Yaf_Registry::get('redis');
    }

    /**
     * 获取博客的所有类型
     * 父可以没子 子不可没父
     */
    public function saylist($offset = 20,$limit = 0)
    {
        $key = cachekey(__FUNCTION__,[$offset,$limit]);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $limit = "limit ".$limit.','.$offset;
            $sql = "select * from say order by id desc ".$limit;
            $data = $this->db->get_all($sql);
            $this->redis->hset(__CLASS__,$key,$data);
        }

        return $data;
    }

    public function saycount()
    {
        $key = cachekey(__FUNCTION__);
        $data = $this->redis->hget(__CLASS__,$key);
        if(is_bool($data))
        {
            $sql = "select count(*) as c from say";
            $data = $this->db->get_one($sql,'c');
            $this->redis->hset(__CLASS__,$key,$data);
        }
        return $data;
    }

    public function addsay($content,$imgs)
    {
        $this->redis->remove(__CLASS__);
        $this->db->insert('say',['content'=>$content,'imgs'=>$imgs,'createtime'=>date("Y-m-d H:i:s")]);
        return $this->db->insert_id();
    }

    public function deleteimg($url)
    {
        unlink($url);
        unlink(resizeimgurl($url));
        unlink(resizeimgurl($url,'middle'));
        return true;
    }

    public function deletesay($id)
    {
        $this->redis->remove(__CLASS__);
        $sql = "select imgs from say where id = ".$id;
        $imgs = $this->db->get_one($sql,'imgs');
        if($imgs)
        {
            $imgarr = json_decode($imgs,true);
            foreach($imgarr as $value)
            {
                $this->deleteimg($value);
            }
        }

        return $this->db->delete('say','id = '.$id);
    }

    /**
     * 说说 上传图片
     * @param $file
     * @return string
     */
    public function uploadsayimage($file)
    {
        $imagedir = "upload/say/".date("Ymd")."/"; //上传照片路径

        if(!file_exists($imagedir))//检查照片目录是否存在
        {
            mkdir($imagedir, 0777, true);
        }

        $pinfo = pathinfo($file["name"]);
        $image_type = $pinfo['extension'];
        $filename = time().rand(1,100).".".$image_type;
        $newdir = $imagedir.$filename;                                          //以当前时间和7位随机数作为文件名，这里是上传的完整路径
        $newsmalldir = $imagedir."small_".$filename;
        $newmiddledir = $imagedir."middle_".$filename;
        $result = move_uploaded_file ($file['tmp_name'], $newdir);
        if($result)
        {
            $image = new Imagecompress();
            $image->resizeimage($newdir, "150", "150", 0, $newsmalldir);
            $imageinfo = getimagesize($newdir);
            if($imageinfo[0] > 800 || $imageinfo[1] > 600)
            {
                $image->resizeimage($newdir, "800", "600", 0, $newmiddledir);   //压图的时候不需要中图，显示的时候才要
            }

            return [$newdir,$newsmalldir];
        }
        else
        {
            return [];
        }
    }
}
