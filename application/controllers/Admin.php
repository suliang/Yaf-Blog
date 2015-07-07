<?php
/**
 * @name AdminController
 * @author root
 * @desc 后台控制器
 */
class AdminController extends Yaf_Controller_Abstract {

    public function init()
    {
        $this->catmodel = new CatModel();
        $this->session = Yaf_Session::getInstance();

        $actionname = $this->getRequest()->getActionName();
        if(!loginstatus() && !in_array($actionname,$this->nologin()))
        {
            $this->redirect(BASE_URL);
        }
    }

    /**
     * 允许未登录用户访问的方法名
     * @return array
     */
    private function nologin()
    {
        $nologin = ['login'];
        return $nologin;
    }

	public function loginAction()
	{
        $isajax = $this->getRequest()->isXmlHttpRequest();
        if(!$isajax)
        {
            return false;
        }
        //先redis判断IP是否被禁
        $ip = $_SERVER['REMOTE_ADDR'];
        $allow = $this->catmodel->allowiplogin($ip);

        if(!$allow)
        {
            $data = array('status'=>2);
        }
        else
        {
            $password = $this->getRequest()->getpost("password");
            $logininfo = $this->catmodel->siteinfo()['login'];
            $shadow = md5(md5($password).$logininfo['name']);
            if($shadow == $logininfo['value'])
            {
                $data = array('status'=>1);
                $this->session->admin = true;
            }
            else
            {
                $this->catmodel->faildlogin($ip);
                $data = array('status'=>0);
            }
        }


        echojson($data);
        return false;
	}

	public function logoutAction()
	{
        $this->session->del('admin');
        return false;
	}










	/** 
     *后台主页
     */
	public function indexAction()
    {
        return TRUE;
	}

	public function topAction()
	{
		return true;
	}
	public function leftAction()
	{
		return true;
	}
	public function rightAction()
	{
		return true;
	}

}
