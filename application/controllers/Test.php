<?php
/**
 * @name TestController
 * @author root
 * @desc 测试专用
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class TestController extends Yaf_Controller_Abstract {

	public function init()
	{
		$this->blogmodel = new BlogModel();
		$this->tagmodel = new TagModel();
		$this->commentmodel = new CommentModel();
		$this->blogtypemodel = new BlogtypeModel();
	}

    public function testAction()
    {


        return false;
    }

    public function indexAction()
    {
        return true;
    }


}
