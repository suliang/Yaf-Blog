                <div class="col-md-2  hidden-xs hidden-sm" >
                    <div class="row" style="padding-left:10px;">
                        <div class="col-md-12" style="background-color: white;padding-left: 5px;padding-top:10px">
                            <h4 class="text-muted">博客分类</h4>
                            <ul style="font-size: 16px;margin-bottom:0px;">
                                <?php foreach($types as $key=>$value):?>
                                    <li><a href="<?=BASE_URL?>index/index/?typeid=<?=$key?>"><?=$value['name']?></a></li>
                                    <?php if(array_key_exists('child',$value)){?>
                                        <ul>
                                            <?php foreach($value['child'] as $k=>$v){
                                                ?>
                                                <li>---<a href="<?=BASE_URL?>index/index/?typeid=<?=$k?>"><?=$v?></a></li>
                                            <?php } ?>
                                        </ul>
                                        <?php
                                    }
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px;margin-top:10px">
                        <div class="col-md-12" style="background-color: white;padding-left: 10px;padding-top:10px">
                            <h4 class="text-muted">热门标签</h4>
                            <?php foreach($tags as $key=>$value):?>
                                <a href="<?=BASE_URL?>index/index/?tagid=<?=$key?>"><button type="button" class="btn btn-info btn-sm" style="margin-bottom:8px"><?=$value?></button></a>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="row" style="padding-left:10px;margin-top:10px;">
                        <div class="col-md-12" style="background-color: white;padding-left: 10px;padding-top:10px">
                            <h4 class="text-muted">友情链接 <a href="<?=BASE_URL?>index/link" >申请友链 》》</a></h4>
                            <ul class="list-unstyled" style="padding-left: 10px">
                                <?php foreach($links as $value):?>
                                    <li style="padding: 2px"><a href="<?=$value['url']?>" class="links_li" target="_blank"><?=$value['title']?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container-fluid" style="background-color: #546673;margin-top: 20px">
                <p class="text-center " style="color: white">Copyright © 程序喵的博客 | <?=$back;?></p>
            </div>
        </footer>
                <!-- 登录窗口 -->
                <div class="modal fade" id="login_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">进入后台</h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control " id="password">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" id="loginpost">登录</button>
                            </div>
                        </div>
                    </div>
                </div>
    </body>
</html>