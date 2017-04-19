<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @author root
 */
class ErrorController extends Yaf_Controller_Abstract {

	//从2.1开始, errorAction支持直接通过参数获取异常
	public function errorAction($exception) {
        $this->display('../public/404');
        return false;
	}
}
