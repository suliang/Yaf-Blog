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
		$(".edit").on('click',function(){
        var edit = $(this)
        var tagid = $(this).attr('name')
        var typeinput = $(this).parent().parent().prev().children().children()
            typeinput.attr('disabled',false)
            typeinput.focus()
          $(this).css('display','none')
          $(this).prev().css('display','inline')
          $(this).prev().prev().css('display','inline')
      })

        $(".cancel").on('click',function(){
            $(this).css('display','none')
            $(this).prev().css('display','none')
            $(this).next().css('display','inline')
            var typeinput = $(this).parent().parent().prev().children().children()
            typeinput.attr('disabled',true)
            var oldvalue = typeinput.attr('data')
            typeinput.val(oldvalue)
        })
		//修改名称
		$(".submit").on('click',function(){
            var button = $(this)
            var typeinput = $(this).parent().parent().prev().children().children()
            var oldvalue = typeinput.attr('data')
            var newvalue = typeinput.val()
            var typeid = $(this).attr('name')

            if(oldvalue == newvalue)
            {
              alert('新旧标签一样，未进行任何修改')
              return false
            }
            
            $.post(
                "<?=BASE_URL?>blogtype/ajax_updatetype",
                { "typeid": typeid, "name":newvalue},
                function(data){
                    if(data.status == 1)
                    { 
                        button.css('display','none')
                        button.next().css('display','none')
                        button.next().next().css('display','inline')
                        typeinput.attr('data',newvalue)
                        typeinput.attr('value',newvalue)
                        typeinput.attr('disabled',true)
                        alert(data.info.content);
                    }
                    else
                    {
                        alert(data.info.content)
                    }
                },
                "json"
            );

        })

      $(".del").on('click',function(){
            var typeid = $(this).attr('data')
            var dom = $(this).parent().parent().parent()
            $.post(
                "<?=BASE_URL?>blogtype/ajax_deletetype",
                { "typeid": typeid},
                function(data){
                    if(data.status == 1)
                    { 
                        dom.remove()
                        alert(data.info.content);
                    }
                    else
                    {
                        alert(data.info.content)
                    }
                },
                "json"
            );  
      })
        $("#add").on('click',function(){
			$(".css").css('display','inline')
			$(".select").css('display','inline')
		})
		$(".close").on('click',function(){
			$(".css").css('display','none')
			$(".select").css('display','none')
		})
		
		$(".add").on('click',function(){
			var type = $(this).attr('data')
			var name = $(this).prev().val()
			if(type == 'child')
			{
				var topid = $(this).prev().prev().val()
			}
			else
			{
				var topid = 0
			}
			$.post(
                "<?=BASE_URL?>blogtype/ajax_addtype",
                { "topid": topid,"name":name},
                function(data){
                    if(data.status == 1)
                    { 
						$(".css").css('display','none')
						$(".select").css('display','none')
                        alert(data.info.content);
						location.reload()   
                    }
                    else
                    {
                        alert(data.info.content)
                    }
                },
                "json"
            );
			
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
        <td width="1101" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><img src="<?=BASE_URL?>public/images/admin/311.gif" width="16" height="16" /> <span class="STYLE4"> 父类可以改名 子类可以改名和删除</span><button style="width:100px;" id="add">添加</button></td>
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
            <td width="3%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">标签id</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">类型名称</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">编辑</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">删除</div></td>
           </tr>
          <?php foreach($types as $key=>$value):?>
		  <tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$key?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><input type="text" name="<?=$key?>" disabled data="<?=$value['name']?>" value="<?=$value['name']?>"></div></td>
            <td height="18" bgcolor="#FFFFFF">
				<div align="center" class="STYLE2 STYLE1">
					<button class="submit" style="display:none;" name="<?=$key?>" type="button">提交</button>
                    <button class="cancel" style="display:none;" name="<?=$key?>" type="button">取消</button>
                    <button class="edit" name="<?=$key?>" type="button">修改名称</button>
				</div>
			</td>
			
		
			<td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><button data="<?=$key?>" type="button" class="del">删除</button></div></td>
          </tr>
		  <?php if(array_key_exists('child',$value)){
			  
			  foreach($value['child'] as $k=>$v){
			?>
			<tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$k?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---<input type="text" name="<?=$k?>" disabled data="<?=$v?>" value="<?=$v?>"></div></td>
            <td height="18" bgcolor="#FFFFFF">
				<div align="center" class="STYLE2 STYLE1">
					<button class="submit" style="display:none;" name="<?=$k?>" type="button">提交</button>
                    <button class="cancel" style="display:none;" name="<?=$k?>" type="button">取消</button>
                    <button class="edit" name="<?=$k?>" type="button">修改名称</button>
				</div>
			</td>
			
			
			<td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><button data="<?=$k?>" type="button" class="del">删除</button></div></td>
			</tr>	
					
			<?php
			  }
		  }?>
		  
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
<div class="css" style="display:none;position:absolute;top:0px;left:0px;width:100%;height:100%;background-color:grey;">
	&nbsp;
</div>
<div class="select" style="display:none;position:absolute;top:111px;left:211px;width:500px;height:200px;background-color:#FFFFFF;">&nbsp;
	<br>
	<span>添加顶级类：<input type="text" ><button data="parent" class="add" type="button">添加</button></span><br><br>
	<span>添加子类：
	<select>
	<?php foreach($futypes as $value):?>
		<option value="<?=$value['id']?>"><?=$value['name']?></option>
	<?php endforeach;?>
	</select>
	<input type="text" ><button type="button" data="child" class="add">添加</button></span><br><br>
	<button type="button" class="close">关闭窗口</button>
</div>
<style>
.css {
	filter:alpha(opacity=50);
	-moz-opacity:0.5;
	-khtml-opacity: 0.5;
	opacity: 0.5;
}

</style>
</body>
</html>