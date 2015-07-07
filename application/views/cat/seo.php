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
        $("button").on('click',function(){
            var id = $(this).attr('id')
            var value = $(this).parent().parent().prev().prev().children().children().val()

            $.post(
                "<?=BASE_URL?>cat/ajax_update",
                { "id": id, "value": value},
                function(data){
                    if(data.status == 1)
                    { 
                        alert(data.info.content);
                    }
                    else
                    {
                        alert(data.info.content)
                        location.reload()
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
        <td width="1101" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><img src="<?=BASE_URL?>public/images/admin/311.gif" width="16" height="16" /> <span class="STYLE4">网站信息</span></td>
        <td width="281" background="<?=BASE_URL?>public/images/admin/tab_05.gif"><table border="0" align="right" cellpadding="0" cellspacing="0">

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
            <td width="15%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">注释</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">name</div></td>
            <td width="55%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">value</div></td>
            <td width="10%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">ext</div></td>
            <td width="8%" height="18" background="<?=BASE_URL?>public/images/admin/tab_14.gif" class="STYLE1"><div align="center" class="STYLE2 STYLE1">操作</div></td>
            
          </tr>
          <?php foreach($list as $value):?>
          <tr>
            <td height="18" bgcolor="#FFFFFF">
              <div align="center" class="STYLE1">
                <input name="checkbox" type="checkbox" class="STYLE2" value="checkbox" />
              </div>
            </td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['comment']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['name']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><input style="width:99%" type="text" value="<?=$value['value']?>"></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><?=$value['ext']?></div></td>
            <td height="18" bgcolor="#FFFFFF"><div align="center" class="STYLE2 STYLE1"><button id="<?=$value['id']?>">修改</button></div></td>
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