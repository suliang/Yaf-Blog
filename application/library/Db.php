<?php

/**
 *
 * Class Db
 */
Class Db
{

	private $link;      //mysqli资源句柄
	private $trans;     //事务
    private $handle;    //日志文件资源句柄
    private $is_log;    //是否记录日志
    private $time;      //时间戳

	//构造函数
	public function __construct($db_config)
	{
		$this->time = $this->microtime_float();
		$this->connect($db_config["hostname"], $db_config["username"], $db_config["password"], $db_config["database"]);
		$this->is_log = $db_config["log"];
		if ($this->is_log)
		{
			$handle = fopen($db_config["logfilepath"] . "dblog.txt", "a+");
			$this->handle = $handle;
		}
	}

	//数据库连接
	public function connect($dbhost, $dbuser, $dbpw, $dbname, $charset = 'utf8')
	{

		$this->link = @mysqli_connect($dbhost, $dbuser, $dbpw, $dbname);

		if (!$this->link)
		{
			$this->halt("数据库连接失败:" . mysqli_connect_errno());
		}
		if (!@mysqli_select_db($this->link, $dbname))
		{
			$this->halt('数据库选择失败');
		}
		mysqli_query($this->link,"set names " . $charset);
	}


	//查询
	public function query($sql)
	{
		$this->write_log("查询 " . $sql);
		$query = mysqli_query($this->link, $sql);
		if (!$query)
		{
			if($this->trans)
			{
				$this->trans_rollback();
			}
			$this->halt('Query Error: ' . $sql);
		}
		return $query;
	}

	//获取一条记录
	public function get_one($sql,$ziduan = "")
	{
		$query = $this->query($sql . ' LIMIT 1');
		$rt = mysqli_fetch_assoc($query);
		$this->write_log("获取一条记录 ");
		if($ziduan && array_key_exists($ziduan, $rt))
		{
			$rt = $rt[$ziduan];
		}
		return $rt;
	}

	//获取全部记录
	//MYSQLI_ASSOC, MYSQLI_NUM, or MYSQLI_BOTH.

	public function get_all($sql, $result_type = MYSQLI_ASSOC)
	{
		$query = $this->query($sql);
		$i = 0;
		$rt = array();
		while ($row = mysqli_fetch_array($query, $result_type))
		{
			$rt[$i] = $row;
			$i++;
		}
		$this->write_log("获取全部记录 ");
		return $rt;
	}

	//插入
	public function insert($table, $dataArray)
	{
		$field = "";
		$value = "";
		if (!is_array($dataArray) || count($dataArray) <= 0)
		{
			$this->halt('没有要插入的数据');
			return false;
		}
		while (list($key, $val) = each($dataArray))
		{
			$field .= "`$key`,";
			$value .= "'$val',";
		}
		$field = substr($field, 0, -1);
		$value = substr($value, 0, -1);
		$sql = "insert into $table($field) values($value)";
		$this->write_log("插入");
		if (!$this->query($sql))
		{
			return false;
		}
		return true;
	}

	//安全插入
	public function safeinsert($table, $dataArray)
	{
		$field = "";
		$safeparam = "";
		$params = "";
		$paramarr = [];
		if (!is_array($dataArray) || count($dataArray) <= 0)
		{
			$this->halt('没有要插入的数据');
			return false;
		}
		$paramsnum = 0;
		while (list($key, $val) = each($dataArray))
		{
			$nowtype = is_string($val)?'s':'i';
			$paramarr[] = $val;
			$field .= "`$key`,";
			$safeparam .= "?,";
			$paramsnum++;
			$params .= $nowtype;         //之过滤字符串，int字形不用过滤
		}
		$field = substr($field, 0, -1);
		$safeparam = substr($safeparam, 0, -1);
		$sql = "insert into {$table}({$field}) values({$safeparam})";

		$stmt = mysqli_stmt_init($this->link);

		mysqli_stmt_prepare($stmt,$sql);
		array_unshift($paramarr,$stmt,$params);//把资源句柄和字符类型插入数组前两位

        //参数要传引用。具体见PHP手册mysqli_stmt_bind_param
        $parmlist = array();
        foreach($paramarr as $key => $value)
        {
            $parmlist[$key] = &$paramarr[$key];
        }

		call_user_func_array("mysqli_stmt_bind_param", $parmlist);
		$result = mysqli_stmt_execute($stmt);
		$this->write_log("安全插入");
		if (!$result)
		{
			return false;
		}
		return true;
	}


	//更新 自定义限制条件
	public function update($table, $dataArray, $condition = "")
	{
		if (!is_array($dataArray) || count($dataArray) <= 0)
		{
			$this->halt('没有要更新的数据');
			return false;
		}
		$value = "";
		while (list($key, $val) = each($dataArray))
		{
            $tmpkey = substr(trim($val),0,strlen($key));
            if($tmpkey == $key)
            {
                $tmpval = trim(str_replace($key,'',trim($val)));      //  + 10
                $value .= $key."=".$key.$tmpval.",";
            }
            else
            {
                $value .= "$key = '$val',";
            }
		}
		$value = substr($value, 0, -1);
		$sql = "update {$table} set {$value} where 1=1 and $condition";
		$this->write_log("更新 ");
		if (!$this->query($sql))
		{
			return false;
		}
		return true;
	}

	//删除 自定义限制条件
	public function delete($table, $condition = "")
	{
		if (empty($condition))
		{
			$this->halt('没有设置删除的条件');
			return false;
		}
		$sql = "delete from {$table} where 1=1 and $condition";
		$this->write_log("删除 " . $sql);
		if (!$this->query($sql))
		{
			return false;
		}
		return true;
	}

	//返回结果集
	public function fetch_array($query, $result_type = MYSQL_ASSOC)
	{
		$this->write_log("返回结果集");
		return mysqli_fetch_array($query, $result_type);
	}

	//获取记录条数
	public function num_rows($results)
	{
		if (!is_bool($results))
		{
			$num = mysqli_num_rows($results);
			$this->write_log("获取的记录条数为" . $num);
			return $num;
		}
		else
		{
			return 0;
		}
	}


	//释放结果集
	public function free_result()
	{
		$void = func_get_args();
		foreach ($void as $query)
		{
			if (is_resource($query) && get_resource_type($query) === 'mysqli result')
			{
				return mysqli_free_result($query);
			}
		}
		$this->write_log("释放结果集");
	}

	//获取最后插入的id
	public function insert_id()
	{
		$id = mysqli_insert_id($this->link);
		$this->write_log("最后插入的id为" . $id);
		return $id;
	}

	//事务
	/**
	 * 开启事务
	 */
	public function trans_start()
	{
		$this->write_log('开启事务');
		$this->trans = TRUE;
		mysqli_autocommit($this->link, FALSE);
	}

	/**
	 * 回滚事务
	 */
	public function trans_rollback()
	{
		$this->write_log('回滚事务');
		mysqli_rollback($this->link);
		mysqli_autocommit($this->link, TRUE);
		$this->trans = FALSE;
	}

	/**
	 * 结束事务
	 */
	public function trans_complete()
	{
		$this->write_log('提交事务');
		mysqli_commit($this->link);
		mysqli_autocommit($this->link, TRUE);
		$this->trans = FALSE;
	}


	//关闭数据库连接
	protected function close()
	{
		$this->write_log("已关闭数据库连接");
		return @mysqli_close($this->link);
	}

	//错误提示
	private function halt($msg = '')
	{
		$msg .= "\r\n" . mysqli_errno($this->link);
		$this->write_log($msg);
		die($msg);
	}

	//析构函数
	public function __destruct()
	{
		$this->free_result();
        $this->close();
		$use_time = substr(($this->microtime_float()) - ($this->time),0,6);
		$this->write_log("完成整个查询任务,所用时间为" . $use_time. "\n");
		if ($this->is_log)
		{
			fclose($this->handle);
		}
	}

	//写入日志文件
	public function write_log($msg = '')
	{
		if ($this->is_log)
		{
			$text = date("Y-m-d H:i:s") . " " . $msg . "\r\n";
			fwrite($this->handle, $text);
		}
	}

	//获取毫秒数
	public function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float) $usec + (float) $sec);
	}





}
 
