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
      $(".delete").on('click',function(){
         if(confirm("确定要删除吗"))
          {
            var type = $(this).attr('name')
            var tagid = $(this).attr('data')
            var tr = $(this).parent().parent().parent()

            $.post(
                "<?=BASE_URL?>tag/ajax_delete",
                { "tagid": tagid, "type":type},
                function(data){
                    if(data.status == 1)
                    { 
                       tr.remove()
                        alert(data.info.content)
                    }
                    else
                    {
                        alert(data.info.content)
                    }
                },
                "json"
            );
          }
          

      })



      
      $(".edit").on('click',function(){
        var edit = $(this)
        var tagid = $(this).attr('name')
        var taginput = $(this).parent().parent().prev().children().children()
            taginput.attr('disabled',false)
            taginput.focus()
          $(this).css('display','none')
          $(this).prev().css('display','inline')
          $(this).prev().prev().css('display','inline')

      })

        $(".cancel").on('click',function(){
            $(this).css('display','none')
            $(this).prev().css('display','none')
            $(this).next().css('display','inline')
            var taginput = $(this).parent().parent().prev().children().children()
            taginput.attr('disabled',true)
            var oldvalue = taginput.attr('data')
            taginput.val(oldvalue)
        })

        $(".submit").on('click',function(){
            var button = $(this)
            var taginput = $(this).parent().parent().prev().children().children()
            var oldvalue = taginput.attr('data')
            var newvalue = taginput.val()
            var tagid = $(this).attr('name')
            if(oldvalue == newvalue)
            {
                alert('新旧标签一样，未进行任何修改')
                return false
            }
            $.post(
                "<?=BASE_URL?>tag/ajax_updatetag",
                { "tagid": tagid, "name":newvalue},
                function(data){
                    if(data.status == 1)
                    { 
                        button.css('display','none')
                        button.next().css('display','none')
                        button.next().next().css('display','inline')
                        taginput.attr('data',newvalue)
                        taginput.attr('value',newvalue)
                        taginput.attr('disabled',true)
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
            <td width="3%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">标签id</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">标签名称</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">编辑</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">使用详情</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">使用次数</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">删除</div></td>
          </tr>
          <?php foreach($list as $value):?>
		  <tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>

            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['id']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><input type="text" name="<?=$value['id']?>" disabled data="<?=$value['name']?>" value="<?=$value['name']?>"></div></td>
            <td height="18" bgcolor="#FFFFFF">
                <div align="center" class="STYLE2 STYLE1">
                    <button class="submit" style="display:none;" name="<?=$value['id']?>" type="button">提交</button>
                    <button class="cancel" style="display:none;" name="<?=$value['id']?>" type="button">取消</button>
                    <button class="edit" name="<?=$value['id']?>" type="button">修改名称</button>
                </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><a href="<?=BASE_URL?>tag/tagjoin/tagid/<?=$value['id']?>">blog列表</a></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['count']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1">
                   <?php if($value['count'] == 0){
                       echo '<button class="delete" data="'.$value['id'].'" name="0" type="button">删除标签</button>';
                   }else{
                       echo '<button class="delete" data="'.$value['id'].'" name="1" style="color:red;" type="button">删除全部</button>';
                   }?>
                </div></td>


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
			
			<span class="STYLE1"></span>
			
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