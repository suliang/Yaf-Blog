<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

    public function _initConfig() {
		//把配置保存起来
		$this->arrConfig = Yaf_Application::app()->getConfig();
		Yaf_Registry::set('config', $this->arrConfig);
	}


	//载入方法库
	public function _initLibrary()
	{

		Yaf_Loader::import('Function.php');


	}
    //载入数据库
    public function _initDatabase()
    {
        $db_config['hostname'] = $this->arrConfig->db->hostname;
        $db_config['username'] = $this->arrConfig->db->username;
        $db_config['password'] = $this->arrConfig->db->password;
        $db_config['database'] = $this->arrConfig->db->database;
        $db_config['log']      = $this->arrConfig->db->log;
        $db_config['logfilepath']      = $this->arrConfig->db->logfilepath;

        Yaf_Registry::set('db', new Db($db_config));
    }
    //载入缓存类rEDIS
    public function _initCache()
    {
        $cache_config['port'] = $this->arrConfig->cache->port;
        $cache_config['host'] = $this->arrConfig->cache->host;
        Yaf_Registry::set('redis', new Rdb($cache_config));
    }

	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
		//注册一个插件
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(Yaf_Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
}
