<?php require_once('./application/views/public/head.php');?>

    <div class="col-md-10" style="">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12" style="background-color: white;">
                <div class="row" style="border-bottom: 1px #f2f2f2 solid;">
                    <div class="col-md-12 hidden-xs hidden-sm">
                        <h3 class=" text-muted" ><?=$blog['title']?></h3>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;border-bottom: 1px #f2f2f2 solid;">
                    <div class=" col-md-2" style="margin-top:5px;">
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
                    <div class="col-md-5 tags">
                        <?php
                        if($blogtag){echo "标签：";}
                        foreach($blogtag as $value)
                        {
                            ?>
                            <a href="<?=BASE_URL?>index/index/?tagid=<?php echo $value['id'];?>"><button type="button" class="btn btn-info btn-sm" style="margin-bottom:8px"><?php echo $value['name'];?></button></a>
                            <?
                        }
                        ?>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2"><wb:share-button addition="simple" type="button" language="zh_cn" picture_search="false"></wb:share-button></div>
                            <div class="col-md-4">评论 <?=$commentnums?> / 阅读 <?=$blog['look']?></div>
                            <div class="col-md-6">发表时间：<?=$blog['createtime']?></div>
                        </div>
                    </div>
                </div>
                <div class="row content"  style="margin: 10px;">
                    <?php echo $blog['content']?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="comment" style="background-color: white;">
                <div class="row" style="margin:10px">
                    <?php
                    $i=1;
                    foreach($comments as $key=>$value)
                    {?>
                        <div class="col-md-12" style="border-bottom: 1px solid gainsboro;">
                            <div class="row text-muted" style="padding: 5px;">
                                <span class="floor" name="floor"><?=$i?></span> 楼 <?php echo ' 评论时间：',$value['createtime'];?>
                                <div style="float:right"><a href="javascript:void(0)" class="reply_the_comment">回复</a></div>
                            </div>
                            <?php
                            echo $value['content'];
                            if(array_key_exists('reply',$value))
                            {
                                echo "<div class='text-primary' style='border-top:1px dashed RGB(214,214,214);padding: 5px'>管理员回复：";
                                echo $value['reply'][0]['content'],'<br>';
                                echo "</div>";
                            }
                            ?>

                        </div>
                        <?php $i++;
                    }
                    ?>
                    <div class="col-md-12">
                        <form name="comment" id="commentform">
                            <div style=" margin-top: 10px;">
                                <input type="hidden" id="blogid" value="<?=$blog['id']?>">
                                内容：<textarea name="comment" id="comment_textarea" placeholder="请发表您的评论" class="form-control"></textarea>
                                邮箱：<input type="text" id="email" placeholder="请输入您的邮箱，便于作者回复后通知您" class="form-control">
                                <button type="button" class="btn btn-primary" id="post_comment">发表</button>
                            </div>

                        </form>
                    </div>


                </div>

            </div>

        </div>





    </div>

<?php require_once('./application/views/public/foot.php');?>










