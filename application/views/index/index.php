<?php require_once('./application/views/public/head.php');?>

    <div class="col-md-10 " style="background-color: white;">
        <div class="row" style="margin: 10px;">
            <div class="row hidden-xs hidden-sm">
                <h5 class="col-md-2 text-muted" >所属类别</h5>
                <h5 class="col-md-7 text-muted">博文标题</h5>
                <h5 class="col-md-1 text-muted">评论/浏览</h5>
                <h5 class="col-md-2 text-muted">发表时间</h5>
            </div>
<?php foreach($list as $value):?>
                <div class="row detail">
                    <h5 class="col-md-2 hidden-sm hidden-xs">
                        <?php if(array_key_exists(1,$value['typearr'])):?>
                            <a href="<?=BASE_URL?>index/index/?typeid=<?=$value['typearr'][0]['topid']?>"><?=$value['typearr'][1]['name']?></a> -
                        <?php endif;?>
                        <a href="<?=BASE_URL?>index/index/?typeid=<?=$value['type']?>"><?=$value['typearr'][0]['name']?></a>

                    </h5>
                    <h5 class="col-md-7 " style="font-size: 18px;">
                        <a style="color:black"  href="<?=BASE_URL?>index/info/id/<?=$value['id']?>">&nbsp;<?php if($value['status']==2){echo "<span style='color:deepskyblue'>↑↑↑</span>";}echo $value['title'];?></a>
                    </h5>
                    <h5 class="col-md-1 hidden-sm hidden-xs"><?=$value['comments']?> / <?=$value['look']?></h5>
                    <h5 class="col-md-2 hidden-sm hidden-xs"><?=$value['createtime']?></h5>
                </div>
<?php endforeach;?>
            <div class="row">

                <div class="center-block text-center pages"><?=$page?></div>
            </div>
        </div>
    </div>
<?php require_once('./application/views/public/foot.php');?>