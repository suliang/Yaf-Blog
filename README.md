<h1>Yaf博客系统</h1>
<h4>由最快的PHP框架--Yaf打造而成的更快的----<a target="_blank" href="http://www.programcat.com">程序喵的博客</a></h4> 
<hr>
<h6>本项目适合新手学习Yaf框架。老鸟请轻喷</h6>
<h3>为什么要写这个项目？</h3>
起先，我的博客放在CSDN上，那里面技术博客众多，可是后来感觉CSDN的服务器太卡，有时候打开一个博客要半分钟。
简直不能忍啊。于是改投博客园，博客园服务器还算稳定，但是在博客园上写博客，感觉他后台的功能用着不顺手，比较反人类，遂决定自己搭一个博客系统。
<h5>为什么不用WordPress？</h5>
太卡（里面很多地方调google的文件，要 一 一 替换掉，不然卡死你），然后太大太臃肿，很多功能我都用不到，这不符合我喜欢DIY的性格。
<h5>为什么选择Yaf框架？</h5>
到底是用最近火热的Laravel或者Symfony，亦或是鸟哥的Yaf，还是用我最熟悉的CodeIgniter，前三者都有学习成本，最后想了想，这次追求的是快，那就用最快的PHP框架-----Yaf，来搭建一个更快的Blog系统。
<br>开始用Yaf以后，才发现，它就是我要的那个框架！他不喜欢慢！他快如闪电。他没有臃肿的类库与功能，他简约而不简单。Yaf，简直就是为本博客量身打造的。<a target="_blank" href="http://www.laruence.com/manual/yaf.advantages.html">更多Yaf优点详见请点击。</a>
<br><br>第一次学习Yaf框架，很多功能都是摸索着来的，所以此项目必有纰漏。
第一次用Github提交（之前都是浏览别人的项目），所以Github的功能也是摸索着来的。
<hr>
<h3>涉及的插件、技术</h3>
<li>代码高亮插件--Prism</li>
<li>为Prism改造Ueditor</li>
<li>ajaxform</li>
<li>全站搜索Sphinx-coreseek</li>
<li>Redis</li>

<h3>项目特色</h3>
<h5>快如闪电和安全。</h5>
<h6>Yaf和Redis，为我们提供了快如闪电的访问体验，我前台也是能少加载文件，就少加载文件，能用CDN（比如jquery），就用CDN</h6>
<h6>用户add的地方有两处，发表评论和添加友链，都做了防XSS和防SQL注入。
全站搜索，用了sphinx也进一步加快了速度，并确保了防止sql注入。
评论做了基于Redis的IP时间限制，每60秒同一个IP的用户只能说两句话。
管理员登陆入口隐藏，并对登陆接口做了基于Redis的IP错误次数限制。每10分钟错3次禁止此IP登陆。
</h6>

<h3>快速开始</h3>
<pre>
1.请确保你的机器已经安装了PHP、Nginx、Mysql、Redis、Coreseek
2.导入sql文件blog.sql，替换Coreseek的配置文件csft.conf并修改数据库配置，替换虚拟主机文件vhost.conf并修改配置，
3.重启webserver
</pre>
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
     |- Db.php              //数据库类 我网上找的然后改造的mysqli  
     |- Function.php        //方法类，里面继承了一些可以全局调用的方法  
     |- Imagecompress.php   //图片压缩类 压缩说说里上传的图片 
     |- Rdb.php             //Redis类   
  |- Bootstrap.php          //项目的全局启动文件，里面启动了redis mysql 加载方法类
- csft.conf                 //Sphinx-coreseek配置文件
- vhost.conf                //nginx虚拟主机配置文件
- blog.sql                  //数据库文件

</pre>

<h3>TODO</h3>
为了使它更快，我后期还要做3件事
<li>首页和详情页做nginx的proxy_cache缓存</li>
<li>首页和详情页，生成静态html页面</li>
<li>URL重写，现在用的yaf的简单路由，回头把详情页的url简化下</li>

<h3>Last</h3>
感谢Yaf群里的群友在我用Yaf遇到问题时为我指点迷津
