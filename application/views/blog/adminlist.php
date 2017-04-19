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
      $("td").css('height','29px')

      $("select").change(function(){
        var select = $(this)
        var blogid = select.attr('id');
        var status = select.val()
        $.post(
            "<?=BASE_URL?>blog/ajax_update_status",
            { "blogid": blogid, "status":status},
            function(data){
              if(data.status == 1)
              {
                select.attr('style','color:'+data.info.color)
                alert(data.info.content);
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
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="15" height="30"><img src="<?=BASE_URL?>public/images/admin/tab_03.gif" width="15" height="30" /></td>
        <td width="1101" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><img src="<?=BASE_URL?>public/images/admin/311.gif" width="16" height="16" /> <span class="STYLE4">浏览所有博客</span></td>
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
		<table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#c0de98" onmouseover="changeto()"  onmouseout="changeback()">
          <tr>
            <td width="2%" height="26" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">选择</div></td>
            <td width="15%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">标题</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">类型</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">编辑</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">状态</div></td>
			<td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">评论/阅读</div></td>
            <td width="5%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">新评论</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">创建时间</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2">最后修改时间</div></td>
          </tr>
          <?php foreach($list as $value):?>
		  <tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>
            <td height="18" bgcolor="#FFFFFF" class="STYLE2"><a href="<?=BASE_URL?>index/info/id/<?=$value['id']?>" target="_blank"><div align="center" class="STYLE2 STYLE1"><?=$value['title']?></div></a></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?php if(array_key_exists(1,$value['type'])){echo $value['type'][1]['name'].' --> ';}echo $value['type'][0]['name'];?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center"><img src="<?=BASE_URL?>public/images/admin/037.gif" width="9" height="9" /><span class="STYLE1"> [</span><a href="<?=BASE_URL?>blog/edit/id/<?=$value['id']?>">编辑</a><span class="STYLE1">]</span></div></td>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE2 STYLE1">
                <select style="color:<?=$status[$value['status']][1]?>" id="<?=$value['id']?>">
                  <?php foreach($status as $v):?>
                    <option <?php if($value['status']==$v[0]){echo 'selected';}?> style="color:<?=$v[1]?>" value="<?=$v[0]?>"><?=$v[2]?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['comments']?> / <?=$value['look']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><a href="<?=BASE_URL?>comment/commentinfo/blogid/<?=$value['id']?>"><font color="blue"><?php if(in_array($value['id'],$newcomments)){echo 'New!';}?></font></a></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['createtime']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['updatetime']?></div></td>

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