<?php

/**
 * @author suliang
 */
class Rdb
{
	// 服务器连接句柄
	private $handle;

	/**
	 * 构造函数
	 *
	 * @param boolean $isUseCluster 是否采用 M/S 方案
	 */
	public function __construct($config)
	{
		$this->connect($config);
	}

	/**
	 * 析构函数 释放资源
	 */
	public function __destruct()
	{
		$this->close();
	}

	/**
	 * 连接服务器,注意：这里使用长连接，提高效率，但不会自动关闭
	 *
	 * @param array $config Redis服务器配置
	 * @param boolean $isMaster 当前添加的服务器是否为 Master 服务器
	 * @return boolean
	 */
	private function connect($config)
	{
		// default port
		if (!isset($config['port']))
		{
			$config['port'] = 6379;
		}

		$this->handle = new Redis();
		$ret = $this->handle->connect($config['host'], $config['port']);

		return $ret;
	}

	/**
	 * 关闭连接
	 *
	 * @param int $flag 关闭选择 0:关闭 Master 1:关闭 Slave 2:关闭所有
	 * @return boolean
	 */
	public function close()
	{
		$this->handle->close();
		return true;
	}

	/**
	 * 得到 Redis 原始对象可以有更多的操作
	 *
	 * @param boolean $isMaster 返回服务器的类型 true:返回Master false:返回Slave
	 * @param boolean $slaveOne 返回的Slave选择 true:负载均衡随机返回一个Slave选择 false:返回所有的Slave选择
	 * @return redis object
	 */
	public function getRedis()
	{
		return $this->handle;
	}

	/**
	 * 写缓存
	 *
	 * @param string $key 组存KEY
	 * @param string $value 缓存值
	 * @param int $expire 过期时间， 0:表示无过期时间
	 */
	public function set($key, $value, $expire = 0)
	{
		// 永不超时
		if ($expire == 0)
		{
			$ret = $this->handle->set($key, $value);
		}
		else
		{
			$ret = $this->handle->setex($key, $expire, $value);
		}
		return $ret;
	}

	/**
	 * 读缓存
	 *
	 * @param string $key 缓存KEY,支持一次取多个 $key = array('key1','key2')
	 * @return string || boolean  失败返回 false, 成功返回字符串
	 */
	public function get($key)
	{
		// 是否一次取多个值
		$func = is_array($key) ? 'mGet' : 'get';
		return $this->handle->{$func}($key);
	}

	/**
	 * 条件形式设置缓存，如果 key 不存时就设置，存在时设置失败
	 *
	 * @param string $key 缓存KEY
	 * @param string $value 缓存值
	 * @return boolean
	 */
	public function setnx($key, $value)
	{
		return $this->handle->setnx($key, $value);
	}

	/**
	 * 删除缓存
	 *
	 * @param string || array $key 缓存KEY，支持单个健:"key1" 或多个健:array('key1','key2')
	 * @return int 删除的健的数量
	 */
	public function remove($key)
	{
		// $key => "key1" || array('key1','key2')
		return $this->handle->delete($key);
	}

	/**
	 * 值加加操作,类似 ++$i ,如果 key 不存在时自动设置为 0 后进行加加操作
	 *
	 * @param string $key 缓存KEY
	 * @param int $default 操作时的默认值
	 * @return int　操作后的值
	 */
	public function incr($key, $default = 1)
	{
		if ($default == 1)
		{
			return $this->handle->incr($key);
		}
		else
		{
			return $this->handle->incrBy($key, $default);
		}
	}

	/**
	 * 值减减操作,类似 --$i ,如果 key 不存在时自动设置为 0 后进行减减操作
	 *
	 * @param string $key 缓存KEY
	 * @param int $default 操作时的默认值
	 * @return int　操作后的值
	 */
	public function decr($key, $default = 1)
	{
		if ($default == 1)
		{
			return $this->handle->decr($key);
		}
		else
		{
			return $this->handle->decrBy($key, $default);
		}
	}

	/**
	 * 清空当前数据库
	 *
	 * @return boolean
	 */
	public function clear()
	{
		return $this->handle->flushDB();
	}

	/**
	 *    lpush
	 */
	public function lpush($key, $value)
	{
		return $this->handle->lpush($key, $value);
	}

	/**
	 *    add lpop
	 */
	public function lpop($key)
	{
		return $this->handle->lpop($key);
	}

	/**
	 * lrange
	 */
	public function lrange($key, $start, $end)
	{
		return $this->handle->lrange($key, $start, $end);
	}

	/**
	 *    set hash opeation
	 */
	public function hset($name, $key, $value)
	{
		if (is_array($value))
		{
            $value = json_encode($value);
		}
		return $this->handle->hset($name, $key, $value);

	}

	/**
	 *    get hash opeation
	 */
	public function hget($name, $key = null)
	{

		if ($key)
		{
            $data = $this->handle->hget($name, $key);
            $value = json_decode($data, true);
            if (is_null($value))
            {
                $value = $data;
            }
			return $value;
		}
		return $this->handle->hgetAll($name);
	}

	/**
	 *    delete hash opeation
	 */
	public function hdel($name, $key = null)
	{
		if ($key)
		{
			return $this->handle->hdel($name, $key);
		}
		return $this->handle->del($name);
	}

	/**
	 * 存普通数据
	 * @param $data string | int | array
	 */
	public function savedata($key = '', $data = '', $time = 0)
	{
		$result = false;
		if ($key != '' && $data != '')
		{
			if (is_array($data))
			{
				$data = json_encode($data);
			}
			$result = $this->set($key, $data, $time);
		}
		return $result;
	}

	/**
	 * 获取内容  只允许单个key，不允许数组
	 * @param $key string
	 * @return data
	 */
	public function getdata($key)
	{
		$key = (string) $key;
		$data = $this->get($key);
		$value = json_decode($data, true);
		if (is_null($value))
		{
			$value = $data;
		}
		return $value;
	}


}

class NoRedis
{
	public function getdata($key = NULL)
	{
		return FALSE;
	}

	public function savedata($key = NULL, $value = NULL, $expire = NULL)
	{

	}

	public function getRedis()
	{
		return $this;
	}

	public function __call($name, $arguments)
	{
		return FALSE;
	}
}