<?php require_once('./application/views/public/head.php');?>
<div id="content">

    <div id="wrap">
        <?php require_once('./application/views/public/right.php');?>
		<div id="say">
			<form class="admin" enctype="multipart/form-data" id="upimgsay" action="" method="post">
                <div style="">    
                    <textarea name="comment" id="comment_textarea" placeholder="别废话，别煽情" class="comment_textarea"></textarea>
                </div>
				<input name="upfile" id="upfile" type="file" />
				<button id="sendsay" type="button" >说出去的话，泼出去的水</button><br>
				<input class="img" type="hidden" id="img1" name="img1" value="">
				<input class="img" type="hidden" id="img2" name="img2" value="">
				<input class="img" type="hidden" id="img3" name="img3" value="">
				<span id="imgs">
				</span>
			</form>
			<div id="saytitle">点滴的技术，点滴的生活</div>
			<?php foreach($list as $value):?>
            <div class="commentlist">
				
					<p class="saycontent"><?=$value['content']?></p>
					<?php if($value['imgs']):?>
					<div class="sayimgs">
					<?php foreach(json_decode($value['imgs'],true) as $v){?>
                        <img class="sayimg" data="<?php echo BASE_URL.$v;?>" info="<?php echo resizeimgurl(BASE_URL.$v,"middle");?>" src="<?php echo resizeimgurl(BASE_URL.$v);?>">
					<?php }?>
					</div>
					<?php endif;?>
					<div class="saytime"><?=$value['createtime']?></div>
			</div>
			<?php endforeach;?>
            
        </div>

        <div class="clear"></div>
        <?=$page;?>
    </div>
</div>
<div class="clear"></div>
<?php require_once('./application/views/public/foot.php');?>