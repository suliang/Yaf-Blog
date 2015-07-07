<?php
/**
 * @name CommentController
 * @author root
 * @desc 评论控制器
 */
class CommentController extends Yaf_Controller_Abstract {


	public function init()
	{
        $actionname = $this->getRequest()->getActionName();
        if(!loginstatus() && !in_array($actionname,$this->nologin()))
        {
            $this->redirect(BASE_URL);
        }
		$this->blogmodel = new BlogModel();
		$this->commentmodel = new CommentModel();
	}

    /**
     * 允许未登录用户访问的方法名
     * @return array
     */
    private function nologin()
    {
        $nologin = ['ajax_addcomment'];
        return $nologin;
    }

	public function commentlistAction()
	{

		$reply = $this->getRequest()->get("reply");
		$page = $this->getRequest()->get("page");
		$page = $page?$page:1;
		$url = BASE_URL.'comment/commentlist/';
		$offset = 20;
		$count = $this->commentmodel->commentcount($reply);
		$pagehtml = page($url,$page,$count,$offset);
		$limit = ($page-1) * $offset;

		$list = $this->commentmodel->commentlist($offset,$limit,$reply);
		foreach($list as $key => $value)
		{
			$bloginfo = $this->blogmodel->bloginfo($value['blogid']);
			$list[$key]['title'] = $bloginfo['title'];
		}

		$this->getView()->assign("list", $list);
		$this->getView()->assign("page", $pagehtml);


		return true;
	}

	public function ajax_addupdatecommentAction()
	{
		$id = $this->getRequest()->getpost("id");
		$type = $this->getRequest()->getpost("type");
		$content = $this->getRequest()->getpost("value");
		$blogid = $this->getRequest()->getpost("blogid");

		if($type == 'add')
		{
			$result = $this->commentmodel->addcomment($content,$blogid,$id);
		}
		else
		{
			$result = $this->commentmodel->updatecomment($content,$id);
		}
		if($result)
		{
			$data = array('status'=>1,'info'=>array('content'=>'成功'));
		}
		else
		{
			$data = array('status'=>0,'info'=>array('content'=>'失败'));
		}
		echojson($data);
		return false;
	}

	public function ajax_deleteAction()
	{
		$id = $this->getRequest()->getpost("id");

		$result = $this->commentmodel->delcomment($id);
		if($result)
		{
			$data = array('status'=>1,'info'=>array('content'=>'成功'));
		}
		else
		{
			$data = array('status'=>0,'info'=>array('content'=>'失败'));
		}
		echojson($data);
		return false;
	}

	/**
	 * 单个blog的所有评论
	 * @param int $blogid
	 * @return bool
	 */
	public function commentinfoAction($blogid = 0)
	{

		$list = $this->commentmodel->blogcomments($blogid,true);
		foreach($list as $key => $value)
		{
			$bloginfo = $this->blogmodel->bloginfo($value['blogid']);
			$list[$key]['title'] = $bloginfo['title'];
		}
		$this->getView()->assign("list", $list);
		return true;
	}

	public function ajax_addcommentAction()
	{
        $isajax = $this->getRequest()->isXmlHttpRequest();
        if(!$isajax)
        {
            return false;
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $allow = $this->commentmodel->allowcomment($ip);
        if(!$allow)
        {
            $data = array('status'=>0,'info'=>array('content'=>'说话太快，说慢点'));
        }
        else
        {
            $blogid = (int)$this->getRequest()->getpost("blogid");
            $content = $this->getRequest()->getpost("content");
            $nickname = $this->getRequest()->getpost("nickname");
            if($blogid >= 0 && $content && $nickname)
            {
                $content = htmlspecialchars($content);
                $nickname = htmlspecialchars($nickname);
                $result = $this->commentmodel->addcomment($content,$blogid,0,$nickname);
                if($result)
                {
                    $data = array('status'=>1,'info'=>array('content'=>'成功'));
                }
                else
                {
                    $data = array('status'=>0,'info'=>array('content'=>'失败'));
                }
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'请填写完整信息'));
            }
        }

        echojson($data);
        return false;

	}

}
