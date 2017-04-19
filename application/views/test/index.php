<html>
<head>
	<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("button").on("click",function(){
				$.post(
					"http://www.programcat.com/test/test", 
					{ "func": "getNameAndTime" },
					function(data){
						alert(data)
					},
					"json"
				);
			
			})
		
			
		
		})
	</script>
</head>
<body>
<button>post</button>
</body>
</html>