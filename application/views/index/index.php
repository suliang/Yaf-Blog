<?php require_once('./application/views/public/head.php');?>
<div id="content">

    <div id="wrap">
        <?php require_once('./application/views/public/right.php');?>
        <div id="main">
            <div class="main">
                <span class="side_title">所属类别</span>
                <span class="side_title toptitle">博文标题</span>
                <div class="side_title toplook">
                    <span>评论/阅读数&nbsp;&nbsp;</span>
                    <span>&nbsp;&nbsp;发表时间</span>

                </div>
                <?php foreach($list as $value):?>
                <div class="list_item list_view" blogId="<?=$value['id']?>">
                    <div class="article_title left blogtype">
                        <span class="blogtype">
                            <?php if(array_key_exists(1,$value['typearr'])):?>
                                <a href="<?=BASE_URL?>index/index/?typeid=<?=$value['typearr'][0]['topid']?>"><?=$value['typearr'][1]['name']?></a> -
                            <?php endif;?>
                            <a href="<?=BASE_URL?>index/index/?typeid=<?=$value['type']?>"><?=$value['typearr'][0]['name']?></a>
                        </span>
                    </div>
                    <div class="blogtitle">
                        <a href="<?=BASE_URL?>index/info/id/<?=$value['id']?>"><span class="blogtitle">&nbsp;<?php if($value['status']==2){echo "<span style='color:deepskyblue'>↑↑↑</span>";}echo $value['title'];?></span></a>
                    </div>

                    <div class="createtime">
                        <?=$value['createtime']?>
                    </div>
                    <div class="lookcount">
                        <?=$value['comments']?> / <?=$value['look']?>
                    </div>
                </div>
                <?php endforeach;?>

                <div class="pages"><?=$page?></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php require_once('./application/views/public/foot.php');?>