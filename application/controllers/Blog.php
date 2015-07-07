<?php
/**
 * @name BlogController
 * @author root
 * @desc 博客控制器
 */
class BlogController extends Yaf_Controller_Abstract {


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
	}

	/**
	 * 博客状态
	 * @var array
	 */
	public $status = array(1=>['1','green','正常'],2=>['2','blue','置顶'],0=>['0','gray','草稿'],-1=>['-1','red','已删除']);
	/**
	 * 加载发博客模板
	 * @return bool
	 */
	public function newAction()
    {

        $hottags = $this->tagmodel->hottags();
        $types = $this->blogtypemodel->alltypes();
        $this->getView()->assign("types", $types);
        $this->getView()->assign("hottags", $hottags);
        return TRUE;
	}

    public function editAction($id = 0)
    {
        $blog = $this->blogmodel->bloginfo($id);
        $blog['types'] = $this->blogtypemodel->getblogtype($blog['type']);
        $blog['tags'] = $this->tagmodel->blogtotags($id,true);

        $hottags = $this->tagmodel->hottags();
        $types = $this->blogtypemodel->alltypes();
        $blog['type'] = ['id'=>$blog['type'],'name'=>$blog['types'][0]['name']];

        $this->getView()->assign("blog", $blog);
        $this->getView()->assign("types", $types);
        $this->getView()->assign("hottags", $hottags);
        return true;
    }

	/**
	 * 新增文章
	 * @return bool
	 */
	public function ajax_addAction()
	{
		$title = $this->getRequest()->getpost("title");
		$content = $this->getRequest()->getpost("content");
		$type = $this->getRequest()->getpost("type");
		$tags = $this->getRequest()->getpost("tags");

		$blog['title'] = $title;
		$blog['status'] = 1;
		$blog['type'] = $type;
		$blog['updatetime'] = date("Y-m-d H:i:s",time());
		$inserid = $this->blogmodel->add_blog($blog);
		if($inserid > 0)
		{
			//add tags

			$this->tagmodel->addblogtags($tags,$inserid);
            $content = $this->precode($content);
			$result = $this->blogmodel->add_content($inserid, $content);
			if($result)
			{
				$data = array('status'=>1,'info'=>array('id'=>$inserid,'content'=>'提交成功'));
			}
			else
			{
				$data = array('status'=>0,'info'=>array('id'=>$inserid,'content'=>'内容提交失败'));
			}
		}
		else
		{
			$data = array('status'=>0,'info'=>array('content'=>'提交失败'));
		}
		echojson($data);
		return false;
	}

	/**
	 * 更新blog
	 *
	 * @return bool
	 */
	public function ajax_updateAction()
	{
		$data['blogid'] = $this->getRequest()->getpost("blogid");
		$data['blog']['title'] = $this->getRequest()->getpost("title");
		$data['blog']['type'] = $this->getRequest()->getpost("type");
		$data['blog']['updatetime'] = date("Y-m-d H:i:s",time());
		$tags = $this->getRequest()->getpost("tags");
		$data['content']['content'] = $this->precode($this->getRequest()->getpost("content"));


		$result = $this->blogmodel->update_blog($data);
		$this->tagmodel->addblogtags($tags,$data['blogid']);
		if($result)
		{
			$data = array('status'=>1,'info'=>array('id'=>$data['blogid'],'content'=>'修改成功'));
		}
		else
		{
			$data = array('status'=>0,'info'=>array('id'=>$data['blogid'],'content'=>'修改失败'));
		}

		echojson($data);
		return false;
	}

	public function ajax_update_statusACTION()
	{
		$blogid = $this->getRequest()->getpost("blogid");
		$status = $this->getRequest()->getpost("status");
		if($blogid > 0)
		{
			$result = $this->blogmodel->update_status($blogid,$status);
		}
		if($result)
		{
			$data = array('status'=>1,'info'=>array('color'=>$this->{status}[$status][1],'content'=>'修改成功'));
		}
		else
		{
			$data = array('status'=>0,'info'=>array('content'=>'修改失败'));
		}
		echojson($data);
		return false;
	}


	public function adminlistAction()
	{

        $page = $this->getRequest()->get("page");
        $url = BASE_URL.'blog/adminlist/';
        $offset = 20;
        $count = $this->blogmodel->adminlistcount();
        $pagehtml = page($url,$page,$count,$offset);
        $limit = ($page-1) * $offset;

		$list = $this->blogmodel->adminlist($offset,$limit);
		foreach($list as $key => $value)
		{
			$list[$key]['comments'] = $this->commentmodel->countcomment($value['id']);
			$list[$key]['type'] = $this->blogtypemodel->getblogtype($value['type']);
		}
		$newcomments = $this->commentmodel->existsnewcomment();
		$this->getView()->assign("list", $list);
		$this->getView()->assign("newcomments", $newcomments);
		$this->getView()->assign("page", $pagehtml);
       // echo $pagehtml;exit;

		$this->getView()->assign("status", $this->status);
		return true;
	}


    /**
     * 为了前台代码片段的格式显示，把pre标签里的换行br/换成\n
     * 替换两个br为一个 是为了代码片段结束时候的换行。
     * @param $content
     * @return mixed
     */
    private function precode($content)
    {
        $content = str_replace("<br/><br/>","",$content);
        $content = str_replace("<br/>","\n",$content);
        return $content;
    }


}
