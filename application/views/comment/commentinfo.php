<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" charset="utf-8" src="<?=BASE_URL;?>public/js/jquery-1.10.2.min.js"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE1 {font-size: 12px}
.STYLE4 {
	font-size: 12px;
	color: #1F4A65;
	font-weight: bold;
}

a:link {
	font-size: 12px;
	color: #06482a;
	text-decoration: none;

}
a:visited {
	font-size: 12px;
	color: #06482a;
	text-decoration: none;
}
a:hover {
	font-size: 12px;
	color: #FF0000;
	text-decoration: underline;
}
a:active {
	font-size: 12px;
	color: #FF0000;
	text-decoration: none;
}
.STYLE7 {font-size: 12px}

-->
</style>

<script>
    $(function(){
		$(".cancel").on('click',function(){
			$(this).css('display','none')
			$(this).prev().css('display','none')
			$(this).prev().prev().css('display','inline')
			$(this).prev().prev().prev().css('display','none')
			
		})
		$(".reply").on('click',function(){
			$(this).css('display','none')
			$(this).prev().css('display','inline')
			$(this).next().css('display','inline')
			$(this).next().next().css('display','inline')	
		})
		$(".submit").on('click',function(){
			var id = $(this).attr('name')
			var value = $(this).prev().prev().val()
			var type = $(this).attr('data')
			var blogid = $(this).attr('blogid')
			
			$.post(
				"<?=BASE_URL?>comment/ajax_addupdatecomment",
				{ "type": type,'id':id,'value':value,'blogid':blogid},
				function(data){
					if(data.status == 1)
					{ 
						alert(data.info.content);
						location.reload()
						
					}
					else
					{
						alert(data.info.content)
					}
				},
				"json"
           
			)
		})
		
		$(".del").on('click',function(){
			var id = $(this).attr('name')
			var tr = $(this).parent().parent().parent()
			$.post(
				"<?=BASE_URL?>comment/ajax_delete",
				{ "id": id},
				function(data){
					if(data.status == 1)
					{ 
						alert(data.info.content);
						tr.remove()
					}
					else
					{
						alert(data.info.content)
					}
				},
				"json"
           
			)
		})
    })
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="<?=BASE_URL?>public/images/admin/tab_03.gif" width="15" height="30" /></td>
        <td width="1101" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><img src="<?=BASE_URL?>public/images/admin/311.gif" width="16" height="16" /> <span class="STYLE4">浏览所有标签</span></td>
        <td width="281" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><table border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td width="60"><table width="87%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="STYLE1"><div align="center">
                        <input type="checkbox" name="checkbox62" value="checkbox" />
                    </div></td>
                    <td class="STYLE1"><div align="center">全选</div></td>
                  </tr>
              </table></td>
              <td width="60"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="STYLE1"><div align="center"><img src="<?=BASE_URL?>public/images/admin/001.gif" width="14" height="14" /></div></td>
                    <td class="STYLE1"><div align="center">新增</div></td>
                  </tr>
              </table></td>
              <td width="60"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="STYLE1"><div align="center"><img src="<?=BASE_URL?>public/images/admin/114.gif" width="14" height="14" /></div></td>
                    <td class="STYLE1"><div align="center">修改</div></td>
                  </tr>
              </table></td>
              <td width="52"><table width="88%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="STYLE1"><div align="center"><img src="<?=BASE_URL?>public/images/admin/083.gif" width="14" height="14" /></div></td>
                    <td class="STYLE1"><div align="center">删除</div></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="14"><img src="<?=BASE_URL?>public/images/admin/tab_07.gif" width="14" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="9" background="<?=BASE_URL?>public/images/admin/tab_12.gif">&nbsp;</td>
        <td bgcolor="#f3ffe3">
		<table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#c0de98">
          <tr>
            <td width="2%" height="26" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">选择</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">blog标题</div></td>
            <td width="45%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">评论内容</div></td>
            <td width="40%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">回复</div></td>
            <td width="3%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">删除</div></td>
          </tr>
          <?php foreach($list as $value):?>
		  <tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>

            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><a href="<?=BASE_URL?>index/info/id/<?=$value['blogid']?>" target="_blank"><?=$value['title']?></a></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['content']?></div></td>
            <td height="18" bgcolor="#FFFFFF">
                <div align="center" class="STYLE2 STYLE1">
					
					<?php if($value['replyid'] > 0){
					?>	
						<input type="text" name="content" style="display:none" value="<?=$value['content']?>">
						
						<button class="reply"  style="color:blue">修改</button>
						<button data="edit" style="display:none" blogid="<?=$value['blogid']?>" name="<?=$value['id']?>" class="submit">提交</button>
						<button style="display:none" class="cancel">取消</button>
					<?	
					}else{
						if($value['replyid'] == -1)
						{
							echo '已回复';
						}
						else
						{
						?>
						<input  style="display:none;" class="input" name="<?=$value['id']?>">
						<button class="reply" style="color:red" type="button">回复</button>
						<button data="add" blogid="<?=$value['blogid']?>" name="<?=$value['id']?>" style="display:none;" class="submit">提交</button>
						<button style="display:none;" class="cancel">取消</button>
					<?php
						}
					}?>
                    
                </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><button name="<?=$value['id']?>" class="del">删除</button></div></td>
          </tr>
          <?php endforeach;?>
		  </table>
		</td>
        <td width="9" background="<?=BASE_URL?>public/images/admin/tab_16.gif">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="29"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="29"><img src="<?=BASE_URL?>public/images/admin/tab_20.gif" width="15" height="29" /></td>
        <td background="<?=BASE_URL?>public/images/admin/tab_21.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%" height="29" nowrap="nowrap">
			
			<span class="STYLE1"><?=$page;?></span>
			
			</td>
          </tr>
        </table></td>
        <td width="14"><img src="<?=BASE_URL?>public/images/admin/tab_22.gif" width="14" height="29" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>