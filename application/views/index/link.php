<?php require_once('./application/views/public/head.php');?>

<div class="col-md-10 " style="background-color: white;">
    <div id="blog">
        <h2>
            申请友链，要懂规矩。。先把本站链接挂上再申请
        </h2>
        <h3>
            本站链接：<?=$siteurl?><br>
            本站名称：<?=$blogtitle?>
        </h3>
        <br>
        <div>

            站点名称：   <input type="text" id="sitetitle" placeholder="例：程序喵博客" class="form-control">
            站点URL：  <input type="text" id="siteurl" placeholder="例：www.programcat.com" class="form-control">
            <br>
            <button id="addlink" class="btn btn-primary" >提交申请</button>
        </div>
    </div>
</div>
<?php require_once('./application/views/public/foot.php');?>