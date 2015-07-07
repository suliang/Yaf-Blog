<?php
/**
 * @name CatController
 * @author root
 * @desc 综合控制器
 * @see
 */
class CatController extends Yaf_Controller_Abstract {

	public function init()
	{
        if(!loginstatus())
        {
            $this->redirect(BASE_URL);
        }
		$this->blogmodel = new BlogModel();
		$this->tagmodel = new TagModel();
		$this->commentmodel = new CommentModel();
		$this->blogtypemodel = new BlogtypeModel();
		$this->linkmodel = new LinkModel();
		$this->catmodel = new CatModel();
	}
	/** 
     * 自我介绍页
     */
	public function indexAction()
    {


        return false;
	}



    public function seoAction()
    {

        $list = $this->catmodel->siteinfo();
        unset($list['login']);
        $this->getView()->assign("list", $list);
        return true;
    }

    public function ajax_updateAction()
    {
        $value = $this->getRequest()->getpost("value");
        $id = $this->getRequest()->getpost("id");
        if($value && $id > 0)
        {
            $result = $this->catmodel->updateinfo($id,$value);
            if($result)
            {
                $data = array('status'=>1,'info'=>array('content'=>'修改成功'));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'修改失败'));
            }

        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'修改失败，参数错误'));
        }

        echojson($data);
        return false;
    }


	
}
