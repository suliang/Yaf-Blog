<?php require_once('./application/views/public/head.php');?>
<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="col-md-12 " style="background-color: white;">
    <div id="blog">
        <div>
            <div style="height:30px;font-size:20px;">
                <span>标题：</span><input style="height:25px;width:400px;font-size:20px;" id="title" type="text" name="title" >
            </div>
            <script id="editor" type="text/plain"></script>
        </div>
        <div style="height:26px;padding: 10px;">
			<span style="padding:6px;">
			类型选择：<select style="width:130px;" id="type">
					<?php foreach($types as $key => $value):?>
                        <option value="<?=$key?>"><?=$value['name']?></option>
						<?php if(array_key_exists('child',$value)){
                            foreach($value['child'] as $k=>$v)
                            {
                                ?>
                                <option value="<?=$k?>"><?php echo $value['name'],'--->',$v?></option>
                                <?php
                            }
                        }?>
                    <?php endforeach;?>
				</select>
			<button type="button" name="addfutype" class="addtype btn btn-primary">添加父类型</button>
			<button type="button" name="addzitype" class="addtype btn btn-primary">添加子类型</button>

			<span class="addfutype" style="display:none">
			父类型<input style="width:100px;" type="text" id="futype">
			<button type="button" id="addfutype" class="btn btn-primary">增加</button>
			</span>

			<span class="addzitype" style="display:none">
			子类型
			<select style="width:100px;" id="futypes">
				<?php foreach($types as $key => $value):?>
                    <option value="<?=$key?>"><?=$value['name']?></option>
                <?php endforeach;?>
			</select>

			<input style="width:100px;" type="text" id="zitype">
			<button type="button" class="btn" id="addzitype">增加</button>
			</span>

			&nbsp;&nbsp;
			<span>
				当前标签<input type="text" id="tags" style="width: 200px;">
				热门标签
                <?php foreach($hottags as $value):?>
                    <button type="button" class="button btn btn-primary"><?=$value?></button>
                <?php endforeach;?>
			</span>
			</span>
        </div>
        <div style="margin-top:20px;">
            <button type="button" class="btn btn-primary" id="submit">发表</button>
            <button type="button" class="btn btn-primary" id="caogao">存草稿</button>
        </div>
    </div>
</div>

<script type="text/javascript">

	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	$(function(){

        
        var frameheight = $(window).height();
		var width = $("#blog").width()
		
        var ue = UE.getEditor('editor',{initialFrameWidth:width,initialFrameHeight:frameheight,autoHeightEnabled:false});


        $(".addtype").on('click',function(){
            var classname = $(this).attr('name')
            $(".addtype").css('display','none')
            $("."+classname).css('display','inline')


        })

        $("#addfutype").on('click',function(){
            var futype = $("#futype").val()
            $.post(
                "<?=BASE_URL?>blogtype/ajax_addfutype",
                { "name": futype},
                function(data){
                    if(data.status == 1)
                    {
                        $("#type").append("<option value="+data.info.id+">"+futype+"</option>")
                        $("#futypes").append("<option value="+data.info.id+">"+futype+"</option>")
                        $(".addfutype").css("display",'none')
                        $(".addtype").css("display",'inline')
                    }
                    else
                    {
                        alert(data.info.content)
                        $(".addfutype").css("display",'none')
                        $(".addtype").css("display",'inline')
                    }
                },
                "json"
            );

        })

        $("#addzitype").on('click',function(){
            var zitype = $("#zitype").val()
            var topid = $("#futypes").val()
            var funame = $("#futypes option:selected").text()

            $.post(
                "<?=BASE_URL?>blogtype/ajax_addzitype",
                { "name": zitype,'topid':topid},
                function(data){
                    if(data.status == 1)
                    {
                        $("#type").append("<option value="+data.info.id+">"+funame+'--->'+zitype+"</option>")
                        $(".addzitype").css("display",'none')
                        $(".addtype").css("display",'inline')
                    }
                    else
                    {
                        alert(data.info.content)
                        $(".addzitype").css("display",'none')
                        $(".addtype").css("display",'inline')
                    }
                },
                "json"
            );

        })

        $(".button").on('click',function(){
            var tag = $(this).text()
            var nowtag = $("#tags").val();
            if(!nowtag)
            {
                $("#tags").val(tag)
            }
            else
            {
                if(nowtag.split(",")[4])
                {
                    alert("标签最多 5 个,请先删除原来的标签")
                }
                else
                {
                    $("#tags").val(nowtag+','+tag)
                }
            }
        })


        $("#tags").blur(function(){
            var nowtag = $("#tags").val();
            if(nowtag.split(",")[5])
            {
                alert("标签最多 5 个,请先删除原来的标签")
                $(this).focus()
            }
        });

		$("#submit").on("click",function(){
			var content = getcontent();
			var title = $("#title").val();
            var type = $("#type").val()
            var tags = $("#tags").val()
			
			$.post(
				"<?=BASE_URL?>blog/ajax_add",
				{ "title": title,"content":content,"type":type,"tags":tags },
				function(data){
					if(data.status == 1)
					{
						alert(data.info.content);
						window.location.href = "<?=BASE_URL?>index/info/id/"+data.info.id
					}
					else
					{
						alert(data.info)
					}
				},
				"json"
			);
		})

	})

	//获取textarea里的完整内容
	function getcontent()
	{
		var arr = [];
		arr.push(UE.getEditor('editor').getContent());
		var result = arr.join("\n");
		return result;
	}

	//获取草稿箱内容
	function getLocalData () {
		alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
	}
	//清空草稿箱
	function clearLocalData () {
		UE.getEditor('editor').execCommand( "clearlocaldata" );
		alert("已清空草稿箱")
	}
</script>
</body>
</html>