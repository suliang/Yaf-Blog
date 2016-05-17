<?php require_once('./application/views/public/head.php');?>
<div id="content">

    <div id="wrap">
        <?php require_once('./application/views/public/right.php');?>
        <div id="blog">
            <div class="list_item">
                <div class="title">
                    <h1><?=$blog['title']?></h1>
                    <div class="share">
                    <wb:share-button addition="simple" type="button" language="zh_cn" picture_search="false"></wb:share-button>
                    </div>
                </div>
                <div class="article_manage">
                    <span class="link_postdate"><?=$blog['createtime']?></span>
                    <span class="link_comments" title="评论次数">评论(<?=$commentnums?>)</span>
                    <span class="link_view" title="阅读次数">阅读(<?=$blog['look']?>)</span>
                </div>
                <div class="infotype">
                    <?php
                    if($blog['type'] != 0){echo "类型：";}
                    if(array_key_exists(1,$blogtype)){
                        echo "<a href='".BASE_URL."?typeid={$blogtype[0]['topid']}'>".$blogtype[1]['name']."</a>";
                        echo "---<a href='".BASE_URL."?typeid={$blog['type']}'>".$blogtype[0]['name']."</a>";
                    }else{
                        echo "<a href='".BASE_URL."?typeid={$blog['type']}'>".$blogtype[0]['name']."</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="content">
                <div class="tags">
                    <?php
                    if($blogtag){echo "标签：";}
                    foreach($blogtag as $value){
                        echo "<a href='".BASE_URL."?tagid={$value['id']}'>{$value['name']}</a>";
                    }
                    ?>
                </div>
                <?=$blog['content']?>

            </div>
        </div>
		<div id="comment">
			<?php 
			$i=1;
			foreach($comments as $key=>$value){
					
				?>
            <div class="commentlist">
				<div>
					<span class="floor" name="floor"><?=$i?></span> 楼 <?php echo $value['nickname'],' ',$value['createtime'];?>
					<div style="float:right"><a href="javascript:void(0)" class="reply_the_comment">回复</a></div>
				</div>
				
				<?php echo $value['content'];
				if(array_key_exists('reply',$value)){
					echo "<div style='border-top:1px dashed  RGB(214,214,214);color:#66C8FF'>管理员回复：";
					foreach($value['reply'] as $value){
						echo $value['content'],'<br>';
					}
					echo "</div>";
				} ?>
				
			</div>
			<?php $i++;}?>
            <form name="comment" id="commentform">
                <div style=" margin-top: 10px;padding-right: 10px; ">
                    <input type="hidden" id="blogid" value="<?=$blog['id']?>">
                    <textarea name="comment" id="comment_textarea" placeholder="畅所欲言" class="comment_textarea"></textarea>
                </div>
                <div style=" margin:5px 0; ">
                    昵称→<input type="text" id="nickname" placeholder="您叫什么" class="comment_input">
                    邮箱→<input type="text" id="email" placeholder="邮箱-回复您的评论" class="comment_input">
                    <a href="javascript:void(0)" id="post_comment" >提交</a>
                </div>

            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php require_once('./application/views/public/foot.php');?>