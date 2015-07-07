<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>完整demo</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/ueditor.all.min.js"> </script>
	<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
	<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
	<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/ueditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/js/jquery-1.10.2.min.js"></script>


	<style type="text/css">
		div{
			width:100%;
		}
	</style>
</head>
<body>
<div>
    <div style="margin-bottom: 5px">
        标题：<input id="title" style="width:300px;height:20px;" type="text" name="title" value="<?=$blog['title']?>">
    </div>
	<script id="editor" type="text/plain" ></script>
</div>
<div style="margin-bottom: 10px;height:66px;padding: 10px;">
	<span style="padding:6px;">
	类型选择：<select style="width:130px;" id="type">
		<?php foreach($types as $key => $value):?>
			<option <?php if($blog['type']['id'] == $key){echo 'selected';}?> value="<?=$key?>"><?=$value['name']?></option>
			<?php if(array_key_exists('child',$value)){
				foreach($value['child'] as $k=>$v)
				{
				?>
					<option <?php if($blog['type']['id'] == $k){echo 'selected';}?> value="<?=$k?>"><?php echo $value['name'],'--->',$v?></option>
				<?php
				}
			}?>
		<?php endforeach;?>
	</select>
	<button type="button" name="addfutype" class="addtype">添加父类型</button>
    <button type="button" name="addzitype" class="addtype">添加子类型</button>

	<span class="addfutype" style="display:none">
    父类型<input style="width:100px;" type="text" id="futype">
	<button type="button" id="addfutype">增加</button>
	</span>

    <span class="addzitype" style="display:none">
    子类型
    <select style="width:100px;" id="futypes">
	    <?php foreach($types as $key => $value):?>
		    <option value="<?=$key?>"><?=$value['name']?></option>
	    <?php endforeach;?>
    </select>

    <input style="width:100px;" type="text" id="zitype">
	<button type="button" id="addzitype">增加</button>
	</span>

	&nbsp;&nbsp;
	<span>
		当前标签<input type="text" id="tags" value="<?=$blog['tags']?>" style="width: 200px;">
		热门标签
		<?php foreach($hottags as $value):?>
			<button type="button" class="button"><?=$value?></button>
		<?php endforeach;?>
	</span>
</div>
<div id="btns"  style="display: inline;">
	<div>

		<button type="button" id="submit" style="width:100px">发表</button>
		<button type="button" id="caogao" style="width:100px">存草稿</button>

	</div>

</div>

<script type="text/javascript">

    var framewidth = $(window).width();
    var frameheight = $(window).height();
    var ue = UE.getEditor('editor',{initialFrameWidth:framewidth-20,initialFrameHeight:frameheight-170,autoHeightEnabled:false});

	$(function(){

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




		ue.ready(function() {

            var content = <?php echo json_encode($blog['content']);?>;
			ue.setContent(content)


		});


		$("#submit").on("click",function(){
			var content = getcontent();
			var title = $("#title").val();
			var type = $("#type").val()
			var tags = $("#tags").val()
			$.post(
				"<?=BASE_URL?>blog/ajax_update",
				{ "blogid": <?=$blog['id']?>, "title":title, "content":content,"type":type,"tags":tags },
				function(data){
					if(data.status == 1)
					{
						alert(data.info.content);
						window.open("<?=BASE_URL?>index/info/id/"+data.info.id)
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
		arr.push(ue.getContent());
		var result = arr.join("\n");
		return result;
	}

	//获取草稿箱内容
	function getLocalData () {
		alert(ue.execCommand( "getlocaldata" ));
	}
	//清空草稿箱
	function clearLocalData () {
		ue.execCommand( "clearlocaldata" );
		alert("已清空草稿箱")
	}



</script>
</body>
</html>