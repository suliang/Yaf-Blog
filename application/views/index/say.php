<?php require_once('./application/views/public/head.php');?>

<div class="col-md-10 " style="background-color: white;">
    <div id="content" class="row">
        <div class="col-md-12" id="say">
            <h2 class="text-center">生活不止眼前的苟且，还有诗和远方。</h2>
            <form class="admin" enctype="multipart/form-data" id="upimgsay" action="" method="post">
                <div style="">
                    <textarea name="comment" id="comment_textarea" placeholder="别废话，别煽情" class="form-control"></textarea>
                </div>
                <span class="btn btn-success btn-file">
                    选择图片<input type="file" name="upfile" id="upfile" value=""/>
                </span>
                <button id="sendsay" class="btn btn-primary" type="button" >发表</button><br>
                <input class="img" type="hidden" id="img1" name="img1" value="">
                <input class="img" type="hidden" id="img2" name="img2" value="">
                <input class="img" type="hidden" id="img3" name="img3" value="">
                <span id="imgs">
                </span>
            </form>
            <br />
            <?php foreach($list as $value):?>
                <div class="commentlist" style="margin-bottom: 10px;border-bottom: solid 1px beige">
                    <h4><?=$value['content']?></h4>
                    <?php if($value['imgs']):?>
                        <div class="sayimgs">
                            <?php foreach(json_decode($value['imgs'],true) as $v){?>
                                <img class="sayimg" data="<?php echo BASE_URL.$v;?>" info="<?php echo resizeimgurl(BASE_URL.$v,"middle");?>" src="<?php echo resizeimgurl(BASE_URL.$v);?>">
                            <?php }?>
                        </div>
                    <?php endif;?>
                    <div class="saytime" style="margin-top:5px;"><?=$value['createtime']?></div>
                </div>
            <?php endforeach;?>

        </div>
        <div class="col-md-12">
            <div class="center-block text-center pages"><?=$page?></div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="sayimage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <h5 class="text-center"><a target="_blank" href="">查看原图</a></h5>
            <img class="center-block" src="">
        </div>
    </div>
</div>
<?php require_once('./application/views/public/foot.php');?>
