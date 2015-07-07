<?php require_once('./application/views/public/head.php');?>
<div id="content">

    <div id="wrap">
        <?php require_once('./application/views/public/right.php');?>
        <div id="blog">
            <div  style=" margin-left:100px;margin-top:100px;">
            <h2>
                申请友链，要懂规矩。。先把本站链接挂上再申请
            </h2>
            <h3>
                本站链接：<?=$siteurl?><br>
                本站名称：<?=$blogtitle?>
            </h3>

                <div>

                    站点名称：   <input type="text" id="sitetitle" placeholder="例：程序喵博客" class="comment_input">
                    站点URL：  <input type="text" id="siteurl" placeholder="例：www.programcat.com" class="comment_input">
                    <button id="addlink" >提交申请</button>
                </div>

            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php require_once('./application/views/public/foot.php');?>