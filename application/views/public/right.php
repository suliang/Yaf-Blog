<div id="side">
            <div class="side" style=" padding-bottom: 2px; ">
                <p class="side_title" style="float: left;margin-top: 20px;">搜索</p>
                <div style=" margin-left: 50px; margin-top: 18px; ">
                        <input type="text" name="word" value="" placeholder="输入关键词 回车" class="side-search" />
                </div>
            </div>
            <div class="side">
                <span class="side_title side_title2" >博客分类</span>
                <?php foreach($types as $key=>$value):?>
                    <div class="typelist">
                        <span class="parenttype"><a href="<?=BASE_URL?>index/index/?typeid=<?=$key?>"><?=$value['name']?></a></span>
                        <?php if(array_key_exists('child',$value)){?>
                            <?php foreach($value['child'] as $k=>$v){
                                ?>
                                <span class="childtype"><br>-----<a href="<?=BASE_URL?>index/index/?typeid=<?=$k?>"><?=$v?></a></span>
                            <?php
                            }
                        }?>
                    </div>
                <?php endforeach;?>

            </div>
            <div class="side">
                <p class="side_title" style="float: left;">热门标签</p>
                <div class="clear"></div>
                <div class="tags">
                    <?php foreach($tags as $key=>$value):?>
                        <a href="<?=BASE_URL?>index/index/?tagid=<?=$key?>"><?=$value?></a>
                    <?php endforeach;?>
                </div>

            </div>

            <div class="side" id="friendlinks">
                <p class="side_title" style="float: left;">友情链接</p>
                <a href="<?=BASE_URL?>index/link"  class="side-for-more">申请友链 》》</a>
                <div class="clear"></div>
                <ul class="links">
                    <?php foreach($links as $value):?>
                        <li ><a href="<?=$value['url']?>" class="links_li" target="_blank"><?=$value['title']?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>