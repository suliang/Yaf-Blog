<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="description" content="<?=$description?>"/>
    <meta name="keywords" content="<?=$keywords?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script type="text/javascript">
        var BASE_URL = "<?=BASE_URL?>"
        var admin = <?php if($admin){echo 'true';}else{echo 'false';}?>
    </script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <link href="<?=STATIC_PUBLIC?>public/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?=STATIC_PUBLIC?>public/css/public.css" type="text/css">

    <script type="text/javascript" src="<?=STATIC_PUBLIC?>public/js/public.js"></script>
    <?php if($admin):?>
    <script type="text/javascript" src="<?=BASE_URL?>public/js/ajaxform.js"></script>
    <?php endif;
    if($codecss):?>
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?=BASE_URL?>public/js/prism.js"></script>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/prism.css" type="text/css">
    <?php endif;?>

    <script>


    </script>

</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-default navbar-fixed-top container">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_mobile" aria-expanded="false">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" id="logout" href="javascript:void(0)">
                            <img alt="Brand" style="width:35px;height:35px;margin-top:-8px;" src="<?=STATIC_PUBLIC?>public/images/logo.png">
                        </a>
                        <a class="navbar-brand" href="<?=BASE_URL?>">程序喵的厨房</a>
                        <a class="navbar-brand" id="login" data-toggle="modal" data-target="#login_page">
                            <img alt="Brand" style="width:35px;height:35px;margin-top:-8px;" src="<?=STATIC_PUBLIC?>public/images/logo2.png">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar_mobile">
                        <ul class="nav navbar-nav">
                            <li role="presentation"><a href="<?=BASE_URL?>">博客</a></li>
                            <li role="presentation"><a href="<?=BASE_URL?>index/say">碎片</a></li>
                            <li role="presentation"><a href="<?=BASE_URL?>index/cat">关于喵～</a></li>
                            <li role="presentation" class="admin"><a href="<?=BASE_URL?>blog/new">写一篇</a></li>
                            <li role="presentation" class="admin"><a href="<?=BASE_URL?>admin/index">后台</a></li>
                        </ul>
                        <form class="navbar-form navbar-right">
                            <div class="form-group">
                                <input type="text" class="form-control" id="word" placeholder="Search" >
                            </div>
                            <button type="button" id="search" class="btn btn-default side-search">搜索</button>
                        </form>

                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-push-10" >
                <div class="row" style="padding-left:10px;">
                    <div class="col-md-12" style="background-color: white;padding-left: 5px;padding-top:10px">
                        <h4 class="text-muted">博客分类</h4>
                        <ul style="font-size: 16px;margin-bottom:0px;">
                            <?php foreach($types as $key=>$value):?>
                                <li><a href="<?=BASE_URL?>index/index/?typeid=<?=$key?>"><?=$value['name']?></a></li>
                                <?php if(array_key_exists('child',$value)){?>
                                    <ul>
                                    <?php foreach($value['child'] as $k=>$v){
                                        ?>
                                        <li>---<a href="<?=BASE_URL?>index/index/?typeid=<?=$k?>"><?=$v?></a></li>
                                    <?php } ?>
                                    </ul>
                                <?php
                                }
                               endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="row" style="padding-left:10px;margin-top:10px">
                    <div class="col-md-12" style="background-color: white;padding-left: 10px;padding-top:10px">
                        <h4 class="text-muted">热门标签</h4>
                        <?php foreach($tags as $key=>$value):?>
                        <a href="<?=BASE_URL?>index/index/?tagid=<?=$key?>"><button type="button" class="btn btn-info btn-sm" style="margin-bottom:8px"><?=$value?></button></a>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="row" style="padding-left:10px;margin-top:10px;">
                    <div class="col-md-12" style="background-color: white;padding-left: 10px;padding-top:10px">
                        <h4 class="text-muted">友情链接 <a href="<?=BASE_URL?>index/link" >申请友链 》》</a></h4>
                        <ul class="list-unstyled" style="padding-left: 10px">
                            <?php foreach($links as $value):?>
                                <li style="padding: 2px"><a href="<?=$value['url']?>" class="links_li" target="_blank"><?=$value['title']?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>