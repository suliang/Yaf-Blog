<?php
/**
 * @name LinkController
 * @author root
 * @desc 友情链接控制器
 */
class LinkController extends Yaf_Controller_Abstract {


	public function init()
	{
        if(!loginstatus())
        {
            $this->redirect(BASE_URL);
        }
        $this->linkmodel = new LinkModel();
	}

	public function linklistAction()
	{

		$list = $this->linkmodel->linklist(true);
		$this->getView()->assign("list", $list);
		return true;
	}

    public function ajax_updateAction()
    {
        $status = $this->getRequest()->getpost("status");
        $id = $this->getRequest()->getpost("id");
        if($status >= 0 && $id > 0)
        {
            $result = $this->linkmodel->updatestatus($id,$status);
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

    public function ajax_deleteAction()
    {
        $id = $this->getRequest()->getpost("id");
        $result = $this->linkmodel->deletelink($id);
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
