$(function() {

	//登录
    $("#loginpost").click(function(){
        loginpost();
    });
    $("#password").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            loginpost();
        }
    });
    function loginpost()
    {
        var password = $("#password").val()
        $.post(
            BASE_URL+"admin/login",
            { "password": password },
            function(data){
                if(data.status == 1)
                {
                    location.reload()
                }
                else
                {
                    $('#login_page').modal('hide')
                }
            },
            "json"
        );
    }
    //显示管理员后台链接
    if(admin)
    {
        $(".admin").attr('class','admin show');
    }
    else
    {
        $(".admin").attr('class','admin hidden');

    }
    //登出
    $("#logout").on('click',function(){
        $.get(
            BASE_URL+"admin/logout",
            function(){
                location.reload()
            }
        );
    })




    //回车搜索
    $("#word").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            var word = $("#word").val()
            window.location.href=BASE_URL+"index/search/word/"+word;
        }
    });
	//搜索
    $("#search").on('click',function(){
        var word = $("#word").val()
        window.location.href=BASE_URL+"index/search/word/"+word;
    })




    //关闭说说大图片
    $(".popbackground,#sayimgfloorBox").click(function(){
        $('#sayimgfloorBox').fadeOut('slow',function(){
            $("#sayimgfloor").hide();
			$(".innerpopbox:last").empty()
			$("#sayimgfloorBox a").remove()
        });
    })



	
	$(".reply_the_comment").on('click',function(){
		var floorid = $(this).parent().prev().text()
		$('html,body').animate({scrollTop:$('#commentform').offset().top}, 1000);
		$("textarea").val("回复 "+floorid+" 楼 ：")
		$("textarea").focus()
	})
	
	$("#post_comment").on('click',function(){
		var content = $("#comment_textarea").val()
        var email = $("#email").val()
		var blogid = $("#blogid").val()
		var lastfloor = $(".floor:last").text()
		if(!lastfloor)
			lastfloor = 0;
		if(!content )
		{
			alert('内容不能为空')
			return false;
		}
        if(!email || email.indexOf('@') < 0)
        {
            alert('请填写邮箱，用于管理员回复您的评论。邮箱不会出现在本页面')
            return false;
        }
		$.post(
			BASE_URL+"comment/ajax_addcomment", 
			{ "blogid": blogid, "content":content, "nickname":'test', "email":email },
			function(data){
				if(data.status == 1)
				{
					newfloor = parseInt(lastfloor) + parseInt(1)
					$("form").before("<div class='commentlist' style='border-bottom:1.5px solid RGB(188,188,188)'><div><span name='floor'>"+newfloor+"</span> 楼  就在刚才</div>"+content+"</div>")
				    $("#comment_textarea").val("")
				    $("#nickname").val("")
                }
				else
				{
					alert(data.info.content)
				}
			}, 
			"json"
		);
		
	})
	
	$("#upfile").on('change',function(){
		var img1 = $("#img1").val();
		var img2 = $("#img2").val();
		var img3 = $("#img3").val();
		if(img1 && img2 && img3)
		{
			alert('最多只能上传3张图片，请先删除再上传')
			return false;
		}
		var nowid = $(".img[value='']:first").attr('id');
		sky_upfiles(nowid)
	})

	$("#imgs").on('click','.delete',function(){

		var imgid = $(this).attr('name')
		var url = $("#"+imgid).val()
		$("#"+imgid).val('')
		$(this).parent().remove();
		$.post(BASE_URL+"say/ajax_deleteimage", { "url": url } );
	})

	$("#sendsay").on('click',function(){
		var img1 = $("#img1").val()
		var img2 = $("#img2").val()
		var img3 = $("#img3").val()
		var content = $("#comment_textarea").val()
		if(!content)
		{
			alert('请填写内容')
			return false;
		}
		$.post(
			BASE_URL+"say/ajax_addsay",
			{ "content":content,"img1": img1,"img2": img2,"img3": img3 },
			function(data){
				if(data.status == 1)
				{
					alert(data.info.content)
					$("#comment_textarea").val('')
					$("#imgs").empty()
					$(".img").val('')
					location.reload()
					
				}
			},
			"json"
		);
	})
		
	//说说中图预加载
	$(".sayimg").each(function(i){
		var url = $(this).attr('info');
		var imageclass = new Image()
		imageclass.src = url
		imageclass.onload = function () 
		{ 
			return true; 
		} 
	})

	//显示说说图片
    $(".sayimg").click( function(){
		var url = $(this).attr('info')
		var trueurl = $(this).attr('data')
		$(".innerpopbox:last").before("<a style='margin-left:50px;font-size:24px;background-color:RGB(219,233,233);' target='_blank' href='"+trueurl+"'>查看原图</a>")
		$(".innerpopbox:last").append("<img src="+url+">")	
		
        $("#sayimgfloor").fadeIn('slow');
        var _w = $('#sayimgfloorBox').width();
        var _h = $('#sayimgfloorBox').height();
        // 获取定位值
        var left = ($('body').width() - _w)/2 ;
        var top  = ($(window).height()-_h)/2;
        // 添加弹窗样式与动画效果（出现）
        $('.loginBox').css({
            position:'fixed',
            left:left + "px",
            top:top + "px",
            zIndex:998
        }).fadeIn("slow");
    })

	
	//发表说说的按钮宽度
	var textareawidth = $("#comment_textarea").width()
	var length = textareawidth/2 - 3
	$("#upfile").css("width",length+"px") 
	$("#sendsay").css("width",length+"px")
	var saytitlewidth = ($("#header").width()-400)/2
	$("#saytitle").css("margin-left",saytitlewidth+"px")


	$("#addlink").on('click',function(){
		var title = $("#sitetitle").val()
		var url = $("#siteurl").val()

		if(!title || !url)
		{
			alert('请填写内容')
			return false;
		}
		$.post(
			BASE_URL+"index/linkadd",
			{ "title":title,"url": url },
			function(data){
				if(data.status == 1)
				{
					alert(data.info.content)
					$("#addlink").remove() 
					
				}
				else
				{
					alert(data.info.content)
				}
			},
			"json"
		);
	})
});


function sky_upfiles(nowid){
	$("#upimgsay").ajaxSubmit({
		dataType:'json',
		type:'post',
		url: BASE_URL+"say/ajax_uploadimage/",
		beforeSubmit: function(){
			//alert("图片上传中")
		},
		success: function(data){
			if(data.status==1)
			{
				$("#"+nowid).val(data.info.url)
				add_imagedom(data.info.data,nowid)
				$("#upfile").val('')
			}
			else
			{
				alert(data.info.content)
			}
		},
		resetForm: false,
		clearForm: false
	});
}

function add_imagedom(url,imgid)
{
	var html = "<span><a target='_blank' href='"+BASE_URL+url+"'><img style='width:100px;height:100px' src='"+BASE_URL+url+"'/></a><a name='"+imgid+"' class='delete' href='javascript:void(0)'>删除</a></span>"
	
	
	$("#imgs").append(html);
}