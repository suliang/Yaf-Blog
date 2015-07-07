$(function() {
    //手机浏览器
    if($(window).width()<=1000){
        $("#nav").remove();
        $("header").remove();
        $("footer").remove();
        $("#content").css({"padding-top":"0"});
        $(".copyright").find("small").css({"padding-top": "25px","display":"block","line-height":"25px"});
        //文章图片的大小修改
        $("img").css("max-width",($(".content").width() -10));
        $(".link_postdate").css({"clear":"both","float":"left"});
        $(".link_view").css({"float":"left"});
        $(".article_manage").remove();
        $("#side").remove();
        $(".blogtype").remove();
        $(".createtime").remove();
        $(".lookcount").remove();
        $(".side_title").remove();
        $(".toptitle").remove();
        $(".toplook").remove();
        $(".infotype").remove();

        $(".list_view").css('line-height','128px')
        $(".blogtitle").css("font-size",'64px')
        $("#wrap").css("width",'100%')
        $("#wrap").css('padding','0px')
        $("#main").css("width","100%")
        $(".pages").css('font-size','36px')
        $("h1").before("<a style='color:blue;' href='"+BASE_URL+"'><h1>回首页</h1></a>");
    }
    else
    {
        //电脑浏览器
        $(".pages").css('font-size','15px')
    	//$("#content").css("min-height",800);//为了footer贴边
    	$("body").css("min-width",1280)
    	$("header").css("min-width",1000)
    }

	//当分辨率比较低的时候 去掉program.cat 不然管理员模式会溢出
	if($(window).width()<=1601){
		$("#top2").remove()
	}
	if($("#blog").height()<=521){
		$("#blog").height(521)
	}
	var commentwidth = $("#blog").width()-21;
	$("#comment").width(commentwidth)
	var saywidth = $("#header").width()-252;
	$("#say").width(saywidth)
	var saycontentwidth = $(".commentlist").width()-150
	$(".saycontent").width(saycontentwidth)

	
    //修复手机浏览器下顶部不贴边
    $(document).bind('scroll',function(){
        $("#header").css("top","0");
    })
    //控制台隐藏
    $("a[name='consoleHide']").click( function(){
        var ele = $(this);
        if(parseInt($("#console").css("right"))>0){
            $("#console").animate({
                right:"-96px"
            },function(){
                ele.text("《《").removeClass('xx').addClass('showConsole');
            });
        }else{
            $("#console").animate({
                right:"16px"
            },function(){
                ele.removeClass('showConsole').addClass('xx').text("X");
            });
        }
    });

    //顶部效果 CSS3
    $(window).scroll(function() {
        if($(window).scrollTop() <= 90){
            $(".header").removeClass("public-transparency");
            $("#header").removeClass("small-header");
        }else{
            $(".header").addClass("public-transparency");
            $("#header").addClass("small-header");
        }
    })

    //footer吸底效果
    var _wh = $(window).height();           //浏览器完整窗口高度
    var heightr = _wh-205
    $(".main").css("min-height",heightr+"px")

    //ajax登录
    //显示登录框
    $("img[name='login']").click( function(){

        $("#login").fadeIn('slow');
        var _w = $('#loginBox').width();
        var _h = $('#loginBox').height();
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
    

    $(".loginActive").click(function(){
        loginpost();
    });
    $("input[name='password']").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            loginpost();
        }
    });

    //回车搜索
    $("input[name='word']").bind('keydown', function(e) {
        var key = e.which;
        if(key == 13) {
            var word = $(".side-search").val()
            
            window.location.href=BASE_URL+"index/search/word/"+word;
        }
    });

    //返回操作
    $(".closeLoginBox").click(function(){
        $('.loginBox').fadeOut('slow',function(){
            $("#login").hide();
        });
    })
	
	//关闭说说大图片
    $(".popbackground,#sayimgfloorBox").click(function(){
        $('#sayimgfloorBox').fadeOut('slow',function(){
            $("#sayimgfloor").hide();
			$(".innerpopbox:last").empty()
			$("#sayimgfloorBox a").remove()
        });
    })

    //回到顶部
	var $backToTopTxt = "返回顶部", $backToTopEle = $('<div class="backToTop"></div>').appendTo($("#footer"))
		.text($backToTopTxt).attr("title", $backToTopTxt).click(function() {
			$("html, body").animate({ scrollTop: 0 }, 120);
	}), $backToTopFun = function() {
		var st = $(document).scrollTop(), winh = $(window).height();
		(st > 100)? $backToTopEle.show(): $backToTopEle.hide();	
		//IE6下的定位
		if (!window.XMLHttpRequest) {
			$backToTopEle.css("top", st + winh - 166);	
		}
	};
	$(window).bind("scroll", $backToTopFun);
	$(function() { $backToTopFun(); });

    if(admin)
    {
      $(".admin").show();  
    }

    $("#logout").on('click',function(){
        $.get(
        	BASE_URL+"admin/logout",
			function(){
				location.reload()
			}
		);
    })
	
	$(".reply_the_comment").on('click',function(){
		var floorid = $(this).parent().prev().text()
		$('html,body').animate({scrollTop:$('#commentform').offset().top}, 1000);
		$("textarea").val("回复 "+floorid+" 楼 ：")
		$("textarea").focus()
	})
	
	$("#post_comment").on('click',function(){
		var content = $("#comment_textarea").val()
		var nickname = $("#nickname").val()
		var blogid = $("#blogid").val()
		var lastfloor = $(".floor:last").text()
		if(!lastfloor)
			lastfloor = 0;
		if(!content || !nickname)
		{
			alert('内容和昵称不能为空')
			return false;
		}
		$.post(
			BASE_URL+"comment/ajax_addcomment", 
			{ "blogid": blogid, "content":content, "nickname":nickname },
			function(data){
				if(data.status == 1)
				{
					newfloor = parseInt(lastfloor) + parseInt(1)
					$("form").before("<div class='commentlist' style='border-bottom:1.5px solid RGB(188,188,188)'><div><span name='floor'>"+newfloor+"</span> 楼 "+nickname+" 就在刚才</div>"+content+"</div>")
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

function loginpost()
{
    var password = $("input[name='password']").val()
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
                $("#login").hide();
            }
        }, 
        "json"
    );
}
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