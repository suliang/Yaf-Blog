<?php
/**
 * @name CrontabController
 * @author root
 * @desc 定时任务控制器
 * @see
 */
class CrontabController extends Yaf_Controller_Abstract {

	public function init()
	{
        if($_SERVER['REMOTE_ADDR'] != IP)
        {
            return false;
        }
        $this->commentmodel = new CommentModel();
	}



    public function minuteAction()
    {

        $this->sendmail();

        return false;
    }

    public function hourAction()
    {

    }

    public function dayAction()
    {

    }

    /**
     * 发评论邮件
     */
    private function sendmail()
    {


        $maillist = $this->commentmodel->get_mail_tosend();

        if(!empty($maillist))
        {
            foreach($maillist as $value)
            {
                sendmail($value['email'],$value['title'],$value['content']);
            }
        }


    }



	
}
