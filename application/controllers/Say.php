<?php
/**
 * @name SayController
 * @author root
 * @desc 碎片 说说控制器
 */
class SayController extends Yaf_Controller_Abstract {


	public function init()
	{
        if(!loginstatus())
        {
            $this->redirect(BASE_URL);
        }
		$this->blogmodel = new BlogModel();
		$this->saymodel = new SayModel();
		$this->tagmodel = new TagModel();
		$this->linkmodel = new LinkModel();
		$this->blogtypemodel = new BlogtypeModel();
	}

    public function saylistAction()
    {
        $page = $this->getRequest()->get("page");
        $page = $page?$page:1;
        $url = BASE_URL.'say/saylist/';
        $offset = 20;
        $count = $this->saymodel->saycount();
        $pagehtml = page($url,$page,$count,$offset);

        $limit = ($page-1) * $offset;
        $list = $this->saymodel->saylist($offset,$limit);



        $this->getView()->assign("list", $list);
        $this->getView()->assign("page", $pagehtml);
        return true;
    }


    public function ajax_addsayAction()
    {

        $content = $this->getRequest()->getpost("content");
        $img1 = $this->getRequest()->getpost("img1");
        $img2 = $this->getRequest()->getpost("img2");
        $img3 = $this->getRequest()->getpost("img3");
        $imgarr = [];

        $img1?$imgarr[]=$img1:'';
        $img2?$imgarr[]=$img2:'';
        $img3?$imgarr[]=$img3:'';

        $imgstr = empty($imgarr)?'':json_encode($imgarr);
        $sayid = $this->saymodel->addsay($content,$imgstr);

        if($sayid > 0)
        {
            $data = array('status'=>1,'info'=>array('content'=>'发表成功'));
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'发表成功'));
        }

        echojson($data);
        return false;
    }

    /**
     * 上传图片到服务器 返回json url
     *
     * 1:成功上传
     *-1:文件超过规定大小
     *-2:文件类型不符
     *-3:移动文件出错
     *
     */
    public function ajax_uploadimageAction()
    {

        $file = $this->getRequest()->getFiles("upfile");

        if($file)
        {
            $result = $this->saymodel->uploadsayimage($file);
            if(!empty($result))
            {
                $data = array('status'=>1,'info'=>array('url'=>$result[0],'data'=>$result[1]));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'上传失败'));
            }
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'上传失败'));
        }

        echojson($data);
        return false;
    }

    /**
     * 删除服务器上的说说图片 不需要返回值
     */
    public function ajax_deleteimageAction()
    {
        $url = $this->getRequest()->getpost("url");
        $this->saymodel->deleteimg($url);
        return false;
    }

    public function ajax_deleteAction()
    {
        $id = $this->getRequest()->getpost("id");
        $result = $this->saymodel->deletesay($id);
        if($result)
        {
            $data = array('status'=>1,'info'=>array('content'=>'删除成功'));
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'删除失败'));
        }
        echojson($data);
        return false;
    }
}
