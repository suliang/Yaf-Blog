<h1>Yaf博客系统</h1>
<h4>由最快的PHP框架--Yaf打造而成的更快的----程序喵的博客</h4>
<hr>
<h4>为什么要写这个项目？</h4>
起先，我的博客放在CSDN上，那里面技术博客众多，可是后来感觉CSDN的服务器太卡，有时候打开一个博客要半分钟。
简直不能忍啊。于是改投博客园，博客园服务器还算稳定，但是在博客园上写博客，感觉他后台的功能用着不顺手，比较反人类，遂决定自己搭一个博客系统。
<h4>为什么不用WordPress？</h4>
太卡（里面很多地方调google的文件，要 一 一 替换掉，不然卡死你），然后太大太臃肿，很多功能我都用不到，这不符合我喜欢DIY的性格。
<h4>为什么选择Yaf框架？</h4>
到底是用最近火热的Laravel或者Symfony，亦或是鸟哥的Yaf，还是用我最熟悉的CodeIgniter，前三者都有学习成本，最后想了想，这次追求的是快，那就用最快的PHP框架-----Yaf，来搭建一个更快的Blog系统。
<br>开始用Yaf以后，才发现，它就是我要的那个框架！他不喜欢慢！他快如闪电。他没有臃肿的类库与功能，他简约而不简单。Yaf，简直就是为本博客量身打造的。更多Yaf优点详见Yaf优点
<br><br>第一次学习Yaf框架，很多功能都是摸索着来的，所以此项目必有纰漏。
第一次用github提交（之前都是浏览别人的项目），所以github的功能也是摸索着来的。
<hr>
<h3>涉及的插件、技术</h3>
<h5>前端</h5>
<li>详情页使用代码高亮插件--Prism</li>
<li>后台新增博客的页面，改造富文本编辑器Ueditor使其代码格式和Prism一致</li>
<li>碎片（说说）页面，ajaxform插件用于不刷新传图</li>
<h5>后端</h5>
<li>全站搜索模块用的是Sphinx-coreseek</li>
<li>缓存层用的Redis</li>
<h5>目录结构</h5>
<pre>
+ public
  |- index.php //入口文件
  |- index_forp.php //性能测试入库
  |- .htaccess //重写规则
  |- favicon.jpg
  |+ css
  |+ images
  |+ js
+ conf
  |- application.ini //配置文件
+ application
  |+ controllers
     |- Index.php //默认控制器
  |+ views    
     |+ index   //控制器
     |- index.phtml //默认视图
  |- Bootstrap.php //项目的全局配置,包括路由和memcached的配置等
  |- yaf_classes.php //yaf框架的函数列表,方便补全
+ modules //其他模块
+ library //本地类库
+ models  //model目录
+ plugins //插件目录
+ tests   //测试目录
+ globals   //插件目录和全局配置
  |+ cache  //模板生成的缓存文件
  |+ composer         //composer下载的lib
     |- composer.json //composer的依赖配置
	 </pre>