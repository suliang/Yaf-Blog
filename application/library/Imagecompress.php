<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * 压缩图片类库，把大图片压缩成小图片
用的是resizeimage方法
参数5个（源图片完整路径）, （缩略图宽度）, （缩略图高度）, （是否剪裁，0为不裁剪，1为裁剪））, （新图片完整路径）
例：
$thumbnail = new Imagecompress();实例化
$thumbnail->resizeimage("./d.jpg", "180", "180", 0, "./ddd.jpg");

 */
class Imagecompress {

    //图片类型
    var $type;

    //实际宽度
    var $width;

    //实际高度
    var $height;

    //改变后的宽度
    var $resize_width;

    //改变后的高度
    var $resize_height;

    //是否裁图
    var $cut;

    //源图象
    var $srcimg;

    //目标图象地址
    var $dstimg;

    //临时创建的图象
    var $im;

    public function resizeimage($img, $wid, $hei,$c,$dstpath) {
        $this->srcimg = $img;
        $this->resize_width = $wid;
        $this->resize_height = $hei;
        $this->cut = $c;

        //图片的类型
        $this->type = strtolower(substr(strrchr($this->srcimg,"."),1));

        //初始化图象
        $this->initi_img();

        //目标图象地址
        $this -> dst_img($dstpath);

        //--
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);

        //生成图象
        $this->newimg();

        ImageDestroy ($this->im);
    }

    private function newimg() {

        //改变后的图象的比例
        $resize_ratio = ($this->resize_width)/($this->resize_height);

        //实际图象的比例
        $ratio = ($this->width)/($this->height);

        if(($this->cut)=="1") {
            //裁图 高度优先
            if($ratio>=$resize_ratio){
                $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
                ImageJpeg ($newimg,$this->dstimg);
            }

            //裁图 宽度优先
            if($ratio<$resize_ratio) {
                $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
                ImageJpeg ($newimg,$this->dstimg);
            }
        } else {
            //不裁图
            if($ratio>=$resize_ratio) {
                $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
                ImageJpeg ($newimg,$this->dstimg);
            }
            if($ratio<$resize_ratio) {
                $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
                imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
                ImageJpeg ($newimg,$this->dstimg);
            }
        }
    }

    //初始化图象
    private function initi_img() {
        if($this->type=="jpg") {
            $this->im = imagecreatefromjpeg($this->srcimg);
        }

        if($this->type=="gif") {
            $this->im = imagecreatefromgif($this->srcimg);
        }

        if($this->type=="png") {
            $this->im = imagecreatefrompng($this->srcimg);
        }
    }

    //图象目标地址
    private function dst_img($dstpath) {
        $full_length  = strlen($this->srcimg);
        $type_length  = strlen($this->type);
        $name_length  = $full_length-$type_length;
        $name = substr($this->srcimg,0,$name_length-1);
        $this->dstimg = $dstpath;
    }


}