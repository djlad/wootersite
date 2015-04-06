<?php
if(!defined("LOCK")) die();

class DB
{
	/**
	 * DBH object var 
	 *
	 * @var object
	*/
	private $dbh;
	
	/**
	 * DBH object var 
	 *
	 * @var array
	*/	
	private static $_CONNECTIONS = array();
	
	private function __construct($instance)
	{
	
		global $CONFIG;

		try	{
		
			$driver 	= $CONFIG['DB'][ $instance ]['DRIVER'];
			$host 		= $CONFIG['DB'][ $instance ]['HOST'];
			$user 		= $CONFIG['DB'][ $instance ]['USER'];
			$pass 		= $CONFIG['DB'][ $instance ]['PASS'];
			$base 		= $CONFIG['DB'][ $instance ]['DATABASE'];
			$charset   	= 'utf8';
			
			$dbh = new PDO($driver . ":host=" . $host . ";dbname=" . $base . ";charset=" . $charset . "", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $charset . ""));
			
			if(!empty($dbh)) {
			
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->dbh = $dbh;
				
			}
			
		} catch(Exception $e) {
		
			throw new Exception($e->getMessage());
			
		}
		
	}

	/**
	 * DBH object var 
	 *
	 * @var array
     *
     * @return Db
	*/	
	public static function getInstance($instance = 'READ') 
	{
	
		switch($instance)
		{
			case 'READ':
				$instance = 'SLAVE';
				break;
			
			default:
			case 'WRITE':
				$instance = 'MASTER';
				break;
		}
		
		if(empty(self::$_CONNECTIONS[$instance])) {
		
			self::$_CONNECTIONS[$instance] = new DB($instance);
			
		}
		
		return self::$_CONNECTIONS[$instance];
		
	}


    /**
     * @param $query
     * @throws Exception
     *
     * @return PDO
     */
	public function query($query)
	{
	
		try {
		
			$sth = $this->dbh->prepare($query); 
			return $sth->execute();
			
		} catch(Exception $e) {
		
			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> ' . $query);
			
		}
		
	}

    /**
     * @param $query
     * @param array $bindParams
     * @param int $fetchMod
     * @return array|bool
     * @throws Exception
     */

	public function select($query, $bindParams=array(), $fetchMod = PDO::FETCH_ASSOC)
	{
	
		try	{
			
			$sth = $this->dbh->prepare($query);
			
			foreach($bindParams as $key=>$value) {

				$sth->bindValue(":$key", $value);
				
			}
			
			$sth->execute();
			return $sth->fetchAll($fetchMod);
			
		} catch(PDOException $e) {
		
			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> <pre>' . $query .'</pre>');
			return false;
			
		}
		
	}

    /**
     * @param string $query
     * @param array $bindParams
     * @return bool|mixed
     * @throws Exception
     */
    public function selectOne($query, $bindParams=array())
	{

		try	{

			$sth = $this->dbh->prepare($query);

			foreach($bindParams as $key=>$value) {

				$sth->bindValue(":$key", $value);

			}

			$sth->execute();
			return $sth->fetch();

		} catch(PDOException $e) {

			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> <pre>' . $query .'</pre>');
			return false;

		}

	}


    /**
     * @param $table
     * @param $data
     * @return bool
     * @throws Exception
     */
	public function insert($table, $data)
	{
	
        $fields = implode('`, `', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
       
		try
		{
			
			$query = "INSERT $table (`$fields`) VALUES ($values)";
			$sth = $this->dbh->prepare($query);
			
			foreach($data as $key => $value) {
			
				$sth->bindValue(":$key", $value);
				
			}
			
			return $sth->execute();
			
		}
		catch(PDOException $e) {
		
			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> ' . $query);
			return false;
			
		}
		
	}

    /**
     * @param $table
     * @param array $data
     * @param $where
     * @return bool
     * @throws Exception
     */
    public function update($table, $data=array(), $where)
	{
	
        $fields = '';
        foreach($data as $key=> $value) {
            $fields .= "`$key`=:$key,";
        }
        $fields = rtrim($fields, ',');

		try	{
		
			$query = "UPDATE $table SET $fields WHERE $where";

			$sth = $this->dbh->prepare($query);
			foreach ($data as $key => $value) {
				$sth->bindValue(":$key", $value);
			}
			return $sth->execute();
			
		} catch(PDOException $e) {
		
			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> ' . $query);
			return false;
			
		}
		
    }

    /**
     * @param $table
     * @param $where
     * @return bool|int
     * @throws Exception
     */
    public function delete($table, $where)
	{
	
		try	{
		
			$query = "DELETE FROM $table WHERE $where";
			return $this->dbh->exec($query);
			
		} catch(PDOException $e) {
		
			throw new Exception($e->getMessage() . '</div><div><strong>Query: </strong> ' . $query);
			return false;
			
		}
		
    }

    /**
     * @return string
     */
	public function lastInsertId() {
		
		return $this->dbh->lastInsertId();
	
	}

    /**
     * @param $table
     * @param $data
     * @param array $exclude
     * @param bool $mark
     * @return array
     * @throws Exception
     */
	public function getTableFields($table, $data, $exclude = array(), $mark = false) {
		
		$res = $this->select('SHOW COLUMNS FROM ' . $table);
		
		$fields = array();
		
		foreach($res As $key => $field) {
		
			if( !in_array($field['Field'], $exclude) ) {
			
				$fields[] = $field['Field'];
				
			}
			
		}
		
		if (!$mark) {
		
			$Data = array();
			foreach($fields As $key)
			{
				if( isset($data[$key]) ) {
					$Data[$key] = $data[$key];
				}
			}
			
			return $Data;
		
		} else {
		
			return $fields;
		
		}
	}
	
	public function __destruct()
	{
	
		$this->dbh = null;
		
	}
}