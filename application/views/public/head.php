<!DOCTYPE html>
<html>
<head lang="zh-cn">
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="description" content="<?=$description?>"/>
    <meta name="keywords" content="<?=$keywords?>" />
    <script type="text/javascript">
        var BASE_URL = "<?=BASE_URL?>"
        var admin = <?php if($admin){echo 'true';}else{echo 'false';}?>
    </script>
    <link rel="stylesheet" href="<?=STATIC_PUBLIC?>public/css/public.css" type="text/css">
    <!--<script type="text/javascript" src="<?=BASE_URL?>public/js/jquery-1.10.2.min.js"></script>-->
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?=STATIC_PUBLIC?>public/js/public.js"></script>
    <?php if($admin):?>
    <script type="text/javascript" src="<?=BASE_URL?>public/js/ajaxform.js"></script>
    <?php endif; 
    if($codecss):?>
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?=BASE_URL?>public/js/prism.js"></script>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/prism.css" type="text/css">
    <?php endif;?>
</head>
<body>
<header class="header">
    <div id="header">
        <img class="logimg" id="logout" src="<?=STATIC_PUBLIC?>public/images/logo.png" />
        <a href="<?=BASE_URL?>" id="top"><?=$blogtitle?></a>
        <img class="log2img" name="login" src="<?=STATIC_PUBLIC?>public/images/logo2.png" />
        <div id="nav">
            <ul>
                <li><a href="<?=BASE_URL?>" title="首页">博客</a></li>
                <li><a href="<?=BASE_URL?>index/say" title="碎片">碎片</a></li>
                <li><a href="<?=BASE_URL?>index/cat" title="关于喵~">关于喵~</a></li>
                <li class="admin"><a href="<?=BASE_URL?>blog/new" title="写博客">写博客</a></li>
                <li class="admin"><a href="<?=BASE_URL?>admin/index" title="后台">后台</a></li>
            </ul>
        </div>
        <a href="<?=BASE_URL?>" id="top2">ProgramCat.com</a>
        <div class="clear"></div>
    </div>
</header>