<?php
/**
 * @name TagController
 * @author root
 * @desc 标签控制器
 */
class TagController extends Yaf_Controller_Abstract {


	public function init()
	{
        if(!loginstatus())
        {
            $this->redirect(BASE_URL);
        }
		$this->blogmodel = new BlogModel();
		$this->tagmodel = new TagModel();

	}

	public function taglistAction()
	{

		$list = $this->tagmodel->alltags();
		foreach($list as $key=>$value)
		{
			$list[$key]['count'] = $this->tagmodel->tagcount($value['id']);
		}
		$this->getView()->assign("list", $list);
		return true;
	}

    public function ajax_updatetagAction()
    {
        $name = $this->getRequest()->getpost("name");
        $id = $this->getRequest()->getpost("tagid");
        if($name && $id>0)
        {
            $result = $this->tagmodel->updatetag($id,$name);
            if($result)
            {
                $data = array('status'=>1,'info'=>array('content'=>'修改成功'));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'修改失败，标签已存在'));
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
        $id = $this->getRequest()->getpost("tagid");
        $join = $this->getRequest()->getpost("type");
        $result = $this->tagmodel->delete($id,$join);
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


    public function tagjoinAction($tagid)
    {

        $arr = $this->tagmodel->tagjoin($tagid);
        $tag = [];
        $blogs = [];
        if($arr)
        {
            $blogids = [];
            foreach($arr as $value)
            {
                $blogids[] = $value['blogid'];
            }
            $blogs = $this->blogmodel->getblogs($blogids);
        }
        $tag['name'] = $this->tagmodel->tagname($tagid);
        $tag['id'] = $tagid;
        $this->getView()->assign("blogs", $blogs);
        $this->getView()->assign("tag", $tag);

        return true;


    }

    public function ajax_deletejoinAction()
    {
        $tagid = $this->getRequest()->getpost("tagid");
        $blogid = $this->getRequest()->getpost("blogid");

        $result = $this->tagmodel->deletejoin($tagid,$blogid);
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
