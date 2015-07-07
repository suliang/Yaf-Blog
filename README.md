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
- index.php             //入口文件 定义常量BASE_URL
- favicon.ico
+ public                //公共静态资源
  |- css
  |- images      
  |- js
  |- ueditor   
+ conf
  |- application.ini    //配置文件
+ application
  |+ controllers
     |- Index.php       //默认控制器
     |- Blog.php        
     |- Blogtype.php    
     |- Cat.php         //综合信息控制器
     |- Comment.php     
     |- Error.php       //错误处理控制器
     |- Admin.php       //后台控制器
     |- Link.php        
     |- Say.php         
     |- Tag.php         
     |- Test.php        //测试专用控制器
  |+ views    
     |+ index   
     ...... 
     |+ test   
     |+ public 
        |- 404.php   
        |- foot.php   
        |- head.php   
        |- right.php   
  |+ models    
     .......
     |- Search.php          //搜索引擎类   
  |+ library    
     |- Db.php              //数据库类 mysqli  
     |- Function.php        //方法类，里面继承了一些可以全局调用的方法  
     |- Imagecompress.php   //图片压缩类  
     |- Rdb.php             //Redis类   
  |- Bootstrap.php          //项目的全局启动文件，里面启动了redis mysql 加载方法类
- csft.php                  //Sphinx-coreseek配置文件
- vhost.conf                //nginx虚拟主机配置文件
- blog.sql                  //数据库文件

</pre>