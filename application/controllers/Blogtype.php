<?php
/**
 * @name BlogtypeController
 * @author root
 * @desc 博客类型控制器
 */
class BlogtypeController extends Yaf_Controller_Abstract {


	public function init()
	{
        if(!loginstatus())
        {
            $this->redirect(BASE_URL);
        }
		$this->blogmodel = new BlogModel();
		$this->tagmodel = new TagModel();
		$this->blogtypemodel = new BlogtypeModel();
	}


	public function ajax_addfutypeACTION()
	{
		$name = $this->getRequest()->getpost("name");

		if($name)
		{
            $exists = $this->blogtypemodel->existstype($name);
            if(!$exists)
            {
                $topid = $this->blogtypemodel->addfutype($name);
                $data = array('status'=>1,'info'=>array('id'=>$topid));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'类型已存在'));
            }

		}
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'类型不能为空'));
        }

		echojson($data);
		return false;
	}

    public function ajax_addzitypeACTION()
    {
        $name = $this->getRequest()->getpost("name");
        $topid = $this->getRequest()->getpost("topid");
        if($name)
        {
            $exists = $this->blogtypemodel->existstype($name);
            if(!$exists)
            {
                $id = $this->blogtypemodel->addzitype($topid,$name);
                $data = array('status'=>1,'info'=>array('id'=>$id));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'类型已存在'));
            }

        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'类型不能为空'));
        }

        echojson($data);
        return false;
    }


    public function typelistAction()
    {

        $alltypes = $this->blogtypemodel->alltypes();
        $futypes = $this->blogtypemodel->allfutype();
        $this->getView()->assign("types", $alltypes);
        $this->getView()->assign("futypes", $futypes);

        return true;
    }

    public function ajax_updatetypeAction()
    {

        $name = $this->getRequest()->getpost("name");
        $typeid = $this->getRequest()->getpost("typeid");

        $result = $this->blogtypemodel->updatetype($typeid,['name' => $name]);
        if($result)
        {
            $data = array('status'=>1,'info'=>array('content'=>'修改成功'));
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'修改失败'));
        }
        echojson($data);
        return false;
    }

    /**
     * 删除类型
     * 删除父类型需要他下面没子类型 且没有blog属于这个类型
     * 删除子类型无条件要求，若下面有文章则自动并入父类型
     * @return bool
     */
    public function ajax_deletetypeAction()
    {

        $typeid = $this->getRequest()->getpost("typeid");
        $result = $this->blogtypemodel->deletetype($typeid);


        if($result)
        {
            $data = array('status'=>1,'info'=>array('content'=>'修改成功'));
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'修改失败'));
        }
        echojson($data);
        return false;
    }

    public function ajax_addtypeAction()
    {
        $topid = $this->getRequest()->getpost("topid");
        $name = $this->getRequest()->getpost("name");
        $result = $this->blogtypemodel->addtype($topid,$name);
        if($result > 0)
        {
            $data = array('status'=>1,'info'=>array('content'=>'添加成功'));
        }
        else
        {
            if($result == 0)
            {
                $data = array('status'=>0,'info'=>array('content'=>'添加失败'));
            }
            else
            {
                $data = array('status'=>0,'info'=>array('content'=>'类型已存在'));
            }

        }
        echojson($data);
        return false;
    }

}
