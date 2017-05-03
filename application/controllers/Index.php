<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 */
class IndexController extends Yaf_Controller_Abstract {



	public function init()
	{
		$this->blogmodel = new BlogModel();
		$this->tagmodel = new TagModel();
		$this->blogtypemodel = new BlogtypeModel();
		$this->commentmodel = new CommentModel();
		$this->tagmodel = new TagModel();
        $this->linkmodel = new LinkModel();
	}


	public function indexAction()
	{

        $typeid = (int)$this->getRequest()->get("typeid");
        $tagid = (int)$this->getRequest()->get("tagid");
        $status = '';
        if($typeid > 0)
        {
            $status = 'typeid='.$typeid;
        }
        else
        {
            $typeid = 0;
        }

        if($tagid > 0)
        {
            $status = 'tagid='.$tagid;
        }
        else
        {
            $tagid = 0;
        }

        $page = (int)$this->getRequest()->get("page");
        $page = $page > 0 ? $page : 1;
        $url = BASE_URL.'index/index/';
        $offset = 16;
        $limit = ($page-1) * $offset;

        if($tagid > 0)
        {
            $blogs = $this->tagmodel->tagjoin($tagid);

            $count = count($blogs);
            $list = [];
            $blogs = array_slice($blogs,$limit,$offset);
            foreach($blogs as $value)
            {
                $list[] = $this->blogmodel->bloginfo($value['blogid'],false);
            }
        }
        else
        {
            $childtypes = $this->blogtypemodel->getchildbyparent($typeid);

            $count = $this->blogmodel->blogcount($typeid,$childtypes);
            $list = $this->blogmodel->bloglist($offset,$limit,$typeid,$childtypes);
        }

        $pagehtml = page($url,$page,$count,$offset,$status);

        foreach($list as $key => $value)
        {
            $list[$key]['comments'] = $this->commentmodel->countcomment($value['id']);
            $list[$key]['typearr'] = $this->blogtypemodel->getblogtype($value['type']);
            $list[$key]['look'] = $list[$key]['look'] + $this->blogmodel->getlook($value['id']);
        }

        $this->rightpublic();
        $this->getView()->assign("list", $list);
        $this->getView()->assign("page", $pagehtml);


        return true;
	}

	/**
	 * 获取blog详情
	 * @param int $id
	 * @return bool
	 */
	public function infoAction($id = 0)
	{
        $id = (int)$id;
		$blog = $this->blogmodel->bloginfo($id);

        $exists = $this->blogmodel->trueblog($id);
        if(!$exists && !loginstatus())
        {
            $this->redirect(BASE_URL);
        }
        $arr = array();
        $commentlist = $this->commentmodel->blogcomments($id);
        foreach($commentlist as $value)
        {
            if( $value['replyid'] <=0 )
            {
                $arr[$value['id']] = $value;
            }
            else
            {
                $arr[$value['replyid']]['reply'][] = $value;
            }
        }
        $this->blogmodel->setlook($id);
        $blogtag = $this->tagmodel->blogtotags($id);
        $commentnums = $this->commentmodel->countcomment($id);
        $blogtype = $this->blogtypemodel->getblogtype($blog['type']);
        $blog['look'] = $blog['look'] + $this->blogmodel->getlook($id);
        $this->rightpublic();

        $this->getView()->assign("blogtype", $blogtype);
        $this->getView()->assign("blogtag", $blogtag);
        $this->getView()->assign("commentnums", $commentnums);
        $this->getView()->assign("comments", $arr);
		$this->getView()->assign("blog", $blog);
		$this->getView()->assign("codecss", true);
        $this->getView()->assign("title", $blog['title']);
		return true;
	}



    /**
     * 搜索
     * @param  $word string
     * @return bool
     */
    public function searchAction($word = '')
    {

        $this->searchmodel = new SearchModel();
        $ids = $this->searchmodel->search_ids(urldecode($word));

        if(!empty($ids))
        {
            $list = $this->blogmodel->getblogs($ids);
        }
        else
        {
            $list = array();
        }

        foreach($list as $key => $value)
        {
            $list[$key]['comments'] = $this->commentmodel->countcomment($value['id']);
            $list[$key]['typearr'] = $this->blogtypemodel->getblogtype($value['type']);
        }

        $this->rightpublic();
        $this->getView()->assign("list", $list);
        $this->display('index');
        return false;

    }


    public function linkAction()
    {
        $this->rightpublic();
        return true;
    }

    public function linkaddAction()
    {
        $isajax = $this->getRequest()->isXmlHttpRequest();
        if(!$isajax)
        {
            return false;
        }
        $title = htmlspecialchars($this->getRequest()->getpost("title"));
        $url = htmlspecialchars($this->getRequest()->getpost("url"));
        if(strpos($url,"http") === false)
        {
            $url = "http://".$url;
        }
        $result = $this->linkmodel->linkadd($title,$url);
        if($result)
        {
            $this->linkmodel->push_link_email_list($title,$url);

            $data = array('status'=>1,'info'=>array('content'=>'申请成功，请等待站长添加'));
        }
        else
        {
            $data = array('status'=>0,'info'=>array('content'=>'申请失败'));
        }
        echojson($data);
        return false;

    }


    /**
     * 自我介绍页
     */
    public function catAction()
    {
        $this->redirect(BASE_URL.'index/info/id/1');
        return false;
    }

    public function sayAction()
    {
        $this->saymodel = new SayModel();
        $page = $this->getRequest()->get("page");
        $page = $page?$page:1;
        $url = BASE_URL.'index/say/';
        $offset = 15;
        $count = $this->saymodel->saycount();
        $pagehtml = page($url,$page,$count,$offset);
        $limit = ($page-1) * $offset;
        $list = $this->saymodel->saylist($offset,$limit);
        $this->rightpublic();
        $this->getView()->assign("list", $list);
        $this->getView()->assign("page", $pagehtml);
        return true;
    }

    /**
     * 右侧公共三栏输出
     */
    private function rightpublic()
    {
        $types = $this->blogtypemodel->alltypes();
        $tags = $this->tagmodel->hottags(10);
        $links = $this->linkmodel->linklist();
        if(loginstatus())
        {
            $this->getView()->assign("admin", true);
        }
        $this->getView()->assign("links", $links);
        $this->getView()->assign("tags", $tags);
        $this->getView()->assign("types", $types);

        //加载seo信息，凡事需要调右侧栏的，都是给用户看的页面，都是可以被搜索引擎抓取的，都需要seo
        $this->seopublic();
    }


    /**
     * 网站seo
     */
    private function seopublic()
    {
        $this->catmodel = new CatModel();
        $siteinfo = $this->catmodel->siteinfo();
        $this->getView()->assign("title", $siteinfo['site_title']['value']);
        $this->getView()->assign("keywords", $siteinfo['site_keywords']['value']);
        $this->getView()->assign("description", $siteinfo['site_description']['value']);
        $this->getView()->assign("back", $siteinfo['site_back']['value']);              //备案号
        $this->getView()->assign("blogtitle", $siteinfo['blog_title']['value']);
        $this->getView()->assign("siteurl", $siteinfo['site_url']['value']);
    }

}
