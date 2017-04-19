<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>

<link href="<?=BASE_URL;?>public/css/skin.css" rel="stylesheet" type="text/css" />
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="<?=BASE_URL;?>public/images/admin/mail_leftbg.gif"><img src="<?=BASE_URL;?>public/images/admin/left-top-right.gif" width="17" height="29" /></td>
    <td width="935" height="29" valign="top" background="<?=BASE_URL;?>public/images/admin/content-bg.gif"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
      <tr>
        <td height="31"><div class="titlebt">基本设置</div></td>
      </tr>
    </table></td>
    <td width="16" valign="top" background="<?=BASE_URL;?>public/images/admin/mail_rightbg.gif"><img src="<?=BASE_URL;?>public/images/admin/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="71" valign="middle" background="<?=BASE_URL;?>public/images/admin/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%" height="138" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="13" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="left_txt">当前位置：基本设置</td>
          </tr>
          <tr>
            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" height="55" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="10%" height="55" valign="middle"><img src="<?=BASE_URL;?>public/images/admin/title.gif" width="54" height="55"></td>
                <td width="90%" valign="top"><span class="left_txt2">在这里，您可以根据您的网站要求，修改设置网站的</span><span class="left_txt3">基本参数</span><span class="left_txt2">！</span><br>
                          <span class="left_txt2">包括</span><span class="left_txt3">网站名称，网址，网站备案号，联系方式，网站公告，关键词，风格</span><span class="left_txt2">等以及网站</span><span class="left_txt3">会员及等级积分设置</span><span class="left_txt2">。 </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable">
              <tr>
                <td class="left_bt2">&nbsp;&nbsp;&nbsp;&nbsp;系统参数设置</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<form name="form1" method="POST" action="admintitlechk.asp">
              <tr>
                <td width="20%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">设定网站名称：</td>
                <td width="3%" bgcolor="#f2f2f2">&nbsp;</td>
                <td width="32%" height="30" bgcolor="#f2f2f2"><input name="title" type="text" id="title" size="30" /></td>
                <td width="45%" height="30" bgcolor="#f2f2f2" class="left_txt">网站名称</td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">网站访问地址：</td>
                <td>&nbsp;</td>
                <td height="30"><input type="text" name="web" size="30" /></td>
                <td height="30" class="left_txt">网站的网址</td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">网站备案证号：</td>
                <td bgcolor="#f2f2f2">&nbsp;</td>
                <td height="30" bgcolor="#f2f2f2"><input type="text" name="logo" size="25" /></td>
                <td height="30" bgcolor="#f2f2f2" class="left_txt">信息产业部备案号</td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">联系电话信息： </td>
                <td>&nbsp;</td>
                <td height="30"><input type="text" name="tel" size="30" /></td>
                <td height="30" class="left_txt">设置网站联系电话</td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">网站客服QQ：</td>
                <td bgcolor="#f2f2f2">&nbsp;</td>
                <td height="30" bgcolor="#f2f2f2"><input type="text" name="myqq" size="30" /></td>
                <td height="30" bgcolor="#f2f2f2" class="left_txt">设置网站客服QQ号</td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#F7F8F9" class="left_txt2">网站客服QQ2：</td>
                <td bgcolor="#F7F8F9">&nbsp;</td>
                <td height="30" bgcolor="#F7F8F9"><input type="text" name="myqq2" size="30" /></td>
                <td height="30" bgcolor="#F7F8F9" class="left_txt">设置网站客服QQ2号</td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#F2F2F2" class="left_txt2">管理员邮箱：</td>
                <td bgcolor="#F2F2F2">&nbsp;</td>
                <td height="30" bgcolor="#F2F2F2"><input name="mymail" type="text" id="mymail" size="30" /></td>
                <td height="30" bgcolor="#F2F2F2"><span class="left_txt">设置网站客服Email</span></td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">网站滚动通知：</td>
                <td>&nbsp;</td>
                <td height="30"><input type="text" name="addinfo" size="30" /></td>
                <td height="30"><span class="left_txt">设置网站滚动公告内容，支持HTML</span></td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">关键词设置为： </td>
                <td bgcolor="#f2f2f2">&nbsp;</td>
                <td height="30" bgcolor="#f2f2f2"><input type="text" name="ci" size="30" /></td>
                <td height="30" bgcolor="#f2f2f2"><span class="left_txt">设置网站的关键词，更容易被搜索引挚找到。</span></td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">是否开启复制功能：</td>
                <td>&nbsp;</td>
                <td height="30"><input type="text" name="kkk" size="4" /></td>
                <td height="30" class="left_txt">是否禁止外部复制功能 0关闭，1开启</td>
              </tr>
              <tr>
                <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">网站风格设置：</td>
                <td bgcolor="#f2f2f2">&nbsp;</td>
                <td height="30" bgcolor="#f2f2f2"><input type="text" name="css" size="24" /></td>
                <td height="30" bgcolor="#f2f2f2" class="left_txt">尾部加/ CSS样式定义内容用</td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">程序授权注册码：</td>
                <td>&nbsp;</td>
                <td height="30"><input name="zhengban" type="text" id="zhengban" size="24" /></td>
                <td height="30" class="left_txt">网站正版授权注册码！</td>
              </tr>
              
              <tr>
                <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt2">51LA网站统计ID：</td>
                <td bgcolor="#f2f2f2">&nbsp;</td>
                <td height="30" bgcolor="#f2f2f2"><input name="tongj" type="text" id="tongj" size="15" /></td>
                <td height="30" bgcolor="#f2f2f2" class="left_txt">51la统计ID，换成您的统计ID号即可 （<a href="http://www.51.la/reg.asp" target="_blank">免费注册51la统计</a>）</td>
              </tr>
              <tr>
                <td height="30" align="right" class="left_txt2">后台管理文件夹：</td>
                <td>&nbsp;</td>
                <td height="30"><input type="text" name="foxa" size="24" /></td>
                <td height="30" class="left_txt">加强安全性，修改后请将后台管理文件夹改为此名</td>
              </tr>
              <tr>
                <td height="17" colspan="4" align="right" >&nbsp;</td>
              </tr>
              <tr>
                <td height="30" colspan="4" align="right" class="left_txt2"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable">
                  <tr>
                    <td class="left_bt2">&nbsp;&nbsp;&nbsp;&nbsp;会员类型及属性</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="30" colspan="4" class="left_txt2"><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="20%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt">①
                      <input type="text"  name="aname" size="10" class="button01" />
                      会员 </td>
                    <td width="20%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt">有效期：
                      
                      天</td>
                    <td width="60%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="right" class="left_txt">②
                      <input type="text"  name="bname" size="10" class="button01" />
                      会员</td>
                    <td height="30" align="right" class="left_txt">转换率：</td>
                    <td height="30" align="right" class="left_txt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">③
                      <input type="text" s name="cname" size="10" class="button01" />
                      会员</td>
                    <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">有效期：
                      <input type="text"  name="dqsjc" size="5" class="button01" />
                      <input type="text"  name="dqsja" size="5" class="button01" />
                      天</td>
                    <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="16" colspan="3" align="right">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable">
                      <tr>
                        <td class="left_bt2">&nbsp;&nbsp;&nbsp;&nbsp;设&nbsp; 置</td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="30" colspan="4" class="left_txt"><table width="100%" height="90" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="27%" align="center" bgcolor="#f2f2f2" class="left_txt">会员升会员需：</td>
                    <td width="27%" bgcolor="#f2f2f2" class="left_txt"><input type="text" style="color=red" name="asb" value="<%=asb%>" size="2" class="button01" /></td>
                    <td width="24%" bgcolor="#f2f2f2" class="left_txt">　会员升会员需</td>
                    <td width="22%" bgcolor="#f2f2f2" class="left_txt"><input type="text" style="color=red" name="bsc" value="<%=bsc%>" size="2" class="button01" /></td>
                  </tr>
                  <tr>
                    <td align="center" class="left_txt">注册会员送：</td>
                    <td class="left_txt"><input type="text" style="color=red" name="dxb" value="<%=dxb%>" size="2" class="button01" /></td>
                    <td class="left_txt">发布信息商品消耗：</td>
                    <td class="left_txt"><input type="text" style="color=red" name="hxb" value="<%=hxb%>" size="2" class="button01" />
                      /次</td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#f2f2f2" class="left_txt">发布图片信息需：</td>
                    <td bgcolor="#f2f2f2" class="left_txt"><input type="text" style="color=red" name="tdxb" value="<%=tdxb%>" size="2" class="button01" />
                      /次</td>
                    <td bgcolor="#f2f2f2" class="left_txt">申请网上店铺需：</td>
                    <td bgcolor="#f2f2f2" class="left_txt"><input type="text" style="color=red" name="ddxb" value="<%=ddxb%>" size="2" class="button01" /></td>
                  </tr>
                </table></td>
                </tr>
            </table></td>
          </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="3"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable">
                <tr>
                  <td class="left_bt2">&nbsp;&nbsp;&nbsp;&nbsp;功能分或转换或消耗</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="30" colspan="3"><table width="100%" height="89" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="30" align="center" bgcolor="#f2f2f2" class="left_txt">会员登陆1次积：
                    <input name="dlf" type="text" class="button01" id="dlf" style="color=red" value="<%=dlf%>" size="2" />
分</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">介绍1位积：
                    <input name="jjf" type="text" class="button01" id="jjf" style="color=red" value="<%=jjf%>" size="2" />
分</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">回复1次积：
                    <input name="ddjf" type="text" class="button01" id="ddjf" style="color=red" value="<%=ddjf%>" size="2" />
分</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">积分
                    <input name="hjf" type="text" class="button01" id="hjf" style="color=red" value="<%=hjf%>" size="2" />
可换1</td>
                </tr>
                <tr>
                  <td height="30" align="center" class="left_txt">发布信息广告积：
                    <input name="xxjf" type="text" class="button01" id="xxjf" style="color=red" value="<%=xxjf%>" size="2" />
分</td>
                  <td height="30" class="left_txt">发布名片积：
                    <input name="mpjf" type="text" class="button01" id="mpjf" style="color=red" value="<%=mpjf%>" size="2" />
分</td>
                  <td height="30" class="left_txt">加入市场联盟积：
                    <input name="lmjf" type="text" class="button01" id="lmjf" style="color=red" value="<%=lmjf%>" size="2" />
分</td>
                  <td height="30" class="left_txt">发布商品积：
                    <input name="spjf" type="text" class="button01" id="spjf" style="color=red" value="<%=spjf%>" size="2" />
分</td>
                </tr>
                <tr>
                  <td height="30" align="center" bgcolor="#f2f2f2" class="left_txt"><input name="gghjf" type="text" class="button01" id="gghjf" style="color=red" value="<%=gghjf%>" size="2" />
                    换1置顶工具</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">改资料1次耗：
                    <input name="zlhjf" type="text" class="button01" id="zlhjf" style="color=red" value="<%=zlhjf%>" size="2" />
分</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">修改发布耗：
                    <input name="xghjf" type="text" class="button01" id="xghjf" style="color=red" value="<%=xghjf%>" size="2" />
分</td>
                  <td height="30" bgcolor="#f2f2f2" class="left_txt">上传认证奖：
                    <input name="rzjf" type="text" class="button01" id="rzjf" style="color=red" value="<%=rzjf%>" size="2" />
分</td>
                </tr>
              </table></td>
            </tr>
            
            <tr>
              <td height="30" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="50%" height="30" align="right"><input type="submit" value="完成以上修改" name="B1" /></td>
              <td width="6%" height="30" align="right">&nbsp;</td>
              <td width="44%" height="30"><input type="reset" value="取消设置" name="B12" /></td>
            </tr>
            <tr>
              <td height="30" colspan="3">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table></td>
    <td background="<?=BASE_URL;?>public/images/admin/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="<?=BASE_URL;?>public/images/admin/mail_leftbg.gif"><img src="<?=BASE_URL;?>public/images/admin/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="<?=BASE_URL;?>public/images/admin/buttom_bgs.gif"><img src="<?=BASE_URL;?>public/images/admin/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="<?=BASE_URL;?>public/images/admin/mail_rightbg.gif"><img src="<?=BASE_URL;?>public/images/admin/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>

</body>
