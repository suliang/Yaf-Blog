<html>
<head>
<title>后台</title>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/js/jquery-1.10.2.min.js"></script>
<script>
    $(function(){
        var frameheight = $(window).height();

        $("#frame").attr('rows',(frameheight-50)+",*")
    })

</script>
</head>
<frameset rows="64,*"  frameborder="NO" border="0" framespacing="0">
	<frame src="top" noresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
	<frameset id="frame" cols="200,*"  rows="700,*" id="frame">
		<frame src="left" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" target="main" />
		<frame src="right" name="main" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto" target="_self" />
	</frameset>
</frameset>
<noframes>
  <body></body>
    </noframes>
</html>
