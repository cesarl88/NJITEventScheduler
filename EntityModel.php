<?php
/**
 * Cesar Salazar
 * This file implements the model for 
 * the event calendar
 */


/**
 * Handles the data base connection
 */
class Database{
	
	private $host      = "sql2.njit.edu";
	private $user      = "cls33";
	private $pass      = "J2nf0VWWc";
	private $dbname    = "cls33";
	private $dbtype    = "mysql";
	
	private $db_handler;
	public $error;
	private $statement;
	
	public function  __construct()
	{
		//set DSN
		$dsn = $this->dbtype.':host=' .$this->host. ';dbname='.$this->dbname;
		
		
		//set options
		
		$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
		);
		
		//Create New PDO Instance
		
		try{
			$this->db_handler = new PDO($dsn, $this->user, $this->pass, $options);
		}
		catch(PDOException $e){
			echo "<script>console.log( 'DebugError : ".$e->getMessage()."' );</script>";
				
			$this->error = $e->getMessage();	
				
		}
		
	}
	

	/*
	 * Prepares and return statement
	 */
	public function prepare($query)
	{
		#Log::d("Prepare statement");
		$this->statement = $this->db_handler->prepare($query);
	}
	
	/**
	 * Binds the values of the parameteres in the statement
	 */
	public function bind($param, $value, $type = null)
	{
		if(is_null($type)){
			switch(true)
			{
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}
		
		$this->statement->bindValue($param, $value, $type);
	}
	
	/**
	 * Execute the statement
	 */
	public function execute()
	{
		$this->statement->execute();
	}
	
	public function select($table, $where = '',$fields = '', $order = '', $limit = null, $offset = '')
	{
		$query = "SELECT $fields FROM $table "
				.($where ? " WHERE $where " : '')
				.($limit ? " LIMIT $limit " : '')
				.(($offset & $limit ? " OFFSET $offset " : ''))
				. ($order ? " ORDER BY $order" : '');

	#	Log::d("$query");
		$this->prepare($query);
	}
	
	/**
	 * Custom complex Queries
	 */
	public function CustomQuery($query)
	{
		#Log::d("CustomQuery");
		
		$this->prepare($query);
		$this->execute();
	}
	
	/**
	 * Insert data
	 */
	
	public function insert($table, $data)
	{
		#Log::d("Inside insert");
		
		
		ksort($data);	
		
		$fieldNames = implode(',', array_keys($data));
		$fieldValues = ':'.implode(', :', array_keys($data));
		
		$query = "INSERT INTO $table ($fieldNames) VALUES($fieldValues)";
		
		#Log::d($query);
		
		
		$this->prepare($query);
		
		
		foreach($data as $key => $value)
		{
			#Log::d($value);
							
			$this->bind(":$key",$value);
		}
		
		$this->execute();
	}
	
	/**
	 * Update data
	 */
	
	public function Update($table, array $data, $where = '')
	{
		ksort($data);
		#Log::d("Update");
		$fieldDetails = null;
		foreach($data as $key => $value)
		{
			$fieldDetails .= "$key = :$key,";
		}
		
		$fieldDetails = rtrim($fieldDetails,',');
		
		$query = "UPDATE $table SET $fieldDetails ".($where ? 'WHERE '.$where : '' );
	
		#Log::d($query);
		$this->prepare($query);
	
		foreach($data as $key => $value)
		{
			$this->bind(":$key",$value);
		}
	
	#	Log::d($query);
		
		$this->execute();
	}
	
	
	/**
	 * DElete data
	 */
	
	public function delete($table, $where, $limit = 1)
	{
		$this->prepare("DELETE FROM $table WHERE $where LIMIT $limit");
		$this->execute();
	}
	
	/**
	 * Return resultset as asociative array
	 */
	public function resultSet()
	{
		$this->execute();
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Return Single associiative array
	 */
	public function single()
	{
		$this->execute();
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Return Object Set
	 */
	public function ObjectSet($entityClass)
	{
		$this->execute();
		$this->statement->setFetchMode(PDO::FETCH_CLASS,$entityClass);
		return $this->statement->fetchAll();
	}
	
	/**
	 * Return Single Object
	 */
	public function singleObject($entityClass)
	{
		$this->execute();
		$this->statement->setFetchMode(PDO::FETCH_CLASS,$entityClass);
		return $this->statement->fetch();
	}
	
	public function rowCount()
	{
		return $this->statement->rowCount();
	}
	
	public function lastInsertId()
	{
		return $this->db_handler->lastInsertId();
	}
	
	public function beginTransaction()
	{
		return $this->db_handler->beginTransaction();
	}
	
	public function endTransaction()
	{
		return $this->db_handler->commit();
	}
	
	public function cancelTranscation()
	{
		return $this->db_handler->rollBack();
	}
	
	public function debugDumpParams()
	{
		return $this->statement->debugDumpParams();
	}
}

/**
 * Data mapping Layer
 */
class DBContext{
	
	private $db;
	private $entities = array();
	
	public function __construct() {
		$this->db = new Database();
	}
	
	public function find($entity, $conditions = array(), $fields = '*', $order = '', $limit = null, $offset = ''){
		#Log::d("Find");
		
		$where = '';
		foreach($conditions as $key => $value)
		{
			if(is_string($value))
			{
				$where .= ' '.$key.' = "'.$value.'"'." &&"; 
			}
			else{
				$where .= ' '.$key.' = '.$value." &&";
			}
		}
		
		$where = rtrim($where, '&');
		$this->db->select($entity->entity_table,$where,$fields,$order,$limit,$offset);
		return $this->db->singleObject($entity->entity_class);
		
	}
	
	public function findAll($entity, $conditions = array(), $fields = '*', $order = '', $limit = null, $offset = ''){
	
		$where = '';
		foreach($conditions as $key => $value)
		{
			if(is_string($value))
			{
				$where .= ' '.$key.' = "'.$value.'"'." &&";
			}
			else{
				$where .= ' '.$key.' = '.$value." &&";
			}
		}
	
		$where = rtrim($where, '&');
		$this->db->select($entity->entity_table,$where,$fields,$order,$limit,$offset);
		return $this->db->ObjectSet($entity->entity_class);
	}
	
	/**
	 * To insert custom queries
	 */
	public function findCustom($entity,$customQuery)
	{
		#Log::d("FindCustom");
		$this->db->CustomQuery($customQuery);
		return $this->db->ObjectSet($entity->entity_class);
	}
	
	/**
	 * Save all pending changes
	 */
	public function saveChanges()
	{
	#	echo "<script>console.log( 'Debug: saveChanges' );</script>";
		#Log::d("saveChanges()");
		foreach($this->entities as $entity)
		{
			#Log::d($entity->entity_state);
				
			#echo "<script>console.log( 'Debug: ".$entity->entity_state."' );</script>";
			#var_dump($entity->primary_keys);
			switch($entity->entity_state){
				
				#
				case EntityState::Created:
					
					foreach ($entity->db_fields as $key)
					{
						$data[$key] = $entity->$key;
					}
						
					$this->db->insert($entity->entity_table, $data);
					break;
					
				case EntityState::Modified:
					
					foreach($entity->db_fields as $key)
					{
						if(!is_null($entity->$key)){
							$data[$key] = $entity->$key;
						}
					}
					
					$where = ' ';
					
					foreach($entity->primary_keys as $key)
					{
						$where .=' '.$key. " = ".$entity->$key. " &&";
					}
					$where = rtrim($where,'&');
					$this -> db->Update($entity->entity_table, $data, $where);
					break;
					
				case EntityState::Deleted:
					#Log::d("EntityState::Deleted");
						
					$where = ' ';
					foreach($entity->primary_keys as $key)
					{
						#Log::d($key);
						$where .=' '.$key." = ".$entity->$key." &&";
					}
					#Log::d($where);
						
					$where = rtrim($where, ' &');
						
					$this->db->delete($entity->entity_table, $where);
					break;
				default:
					break;
			}
		}
		unset($this->entities);
	}
	
	public function add($entity)
	{
		
		$entity->entity_state = EntityState::Created;
		array_push($this->entities,$entity);
	}
	
	public function update($entity)
	{
		$entity->entity_state = EntityState::Modified;
		array_push($this->entities,$entity);
	}
	
	public function remove($entity)
	{
		$entity->entity_state = EntityState::Deleted;
		array_push($this->entities,$entity);
	}
	
	public function getLastInsertedID()
	{
		return $this->db->lastInsertId();
	}
	
}

/**
 * States for the modified, added or deleted objects from database
 */
final class EntityState{
	
	const Created = 1;
	const Modified = 2;
	const Deleted = 3;
}

class Entity
{
	private $db;
	
	public function __construct(){
		
		$this->db = new Database();
	}
	
	public function add()
	{
		foreach ($this->db_fields as $key){
			$data[$key] = $this->$key;
		}
		
		$this->db->insert($this->entity_class, $data);
	}
	
	public function update()
	{
		foreach($this->db_fields as $key){
			if(!is_null($this->$key)){
				$data[$key] = $this->$key;
			}
		}
		
		$where = ' ';
		
		foreach($this->primary_keys as $key)
		{
			$where .=' '.$key." = ".$this->$key." &&";
		}
		
		$where = rtrim($where,'&');
		$this->db->Update($this->entity_table, $data, $where);
	}
	
	public function remove()
	{
		$where = ' ';
		
		foreach ($this->primary_keys as $key){
			$where = ' '.$key." = ".$this->$key. " &&";
		}
		
		$where = rtrim($where,'&');
		$this->db->delete($this->entity_table, $where);
	}
	
}

class Log{
	
	public static function d($value)
	{
		echo "<script>console.log( 'Debug: ".$value."' );</script><br/>";
		
	}
}

/**
 * User model
 */
class User extends Entity{

	public $UserID;
	public $UserName;
	public $Password;
	public $Role;

	public $entity_table = 'User';
	public $entity_class = 'User';
	public $db_fields = array('Password','Role','UserID','UserName');
	public $primary_keys = array('UserID');

	function __construct($userName, $Password){
		$this->userName = $userName;
		$this->Password = hash("sha256", $Password);;
	}

	/* public function info()
	 {
	 return $this->UserName;
	 } */
}

/**
 * Role model
 */
class Role extends Entity{

	public $RoleID;
	public $Name;
	

	public $entity_table = 'Role';
	public $entity_class = 'Role';
	public $db_fields = array('Name','RoleID');
	public $primary_keys = array('RoleID');

	

	/* public function info()
	 {
	 return $this->UserName;
	 } */
}

/**
 * Events model
 */
class Events extends Entity{

	public $ID;
	public $Title;
	public $startDate;
	public $EndDate;
	public $startTime;
	public $endTime;
	public $Place;
	public $Submitter;
	public $UserID;
	public $Organization;
	public $EventName;
	public $Image;
	public $link;
	public $Description;
	public $Approved;
  public $addToGoogle;

	public $entity_table = 'Events';
	public $entity_class = 'Events';
	public $db_fields = array('ID','Title','startDate','EndDate','startTime','endTime','Place','Submitter','UserID','Organization','EventName','Image','link','Description','Approved','addToGoogle');
	public $primary_keys = array('ID');
	
	public function getJSON()
	{
		return json_encode( array('ID' => $this->ID,
								 'Title' => $this->Title,
								 'startDate' => $this->startDate,
								 'EndDate' => $this->EndDate,
								 'startTime' => $this->startTime,
								 'endTime' => $this->endTime,
								 'Place' => $this->Place,
								 'Submitter' => $this->Submitter,
								 'UserID' => $this->UserID,
								 'Organization' => $this->Organization,
								 'EventName' => $this->EventName,
								 'Image' => $this->Image,
								 'link' => $this->link,
								 'Description' => $this->Description,
								 'Approved' => $this->Approved,
                 'addToGoogle' => $this->addToGoogle),JSON_PRETTY_PRINT);  
	}

	


}

/**
 * Schedule model
 */
class Schedule extends Entity{

	public $UserID;
	public $EventID;
	public $dateModified;
	
	public $entity_table = 'Schedule';
	public $entity_class = 'Schedule';
	public $db_fields = array('EventID','UserID','dateModified');
	public $primary_keys = array('EventID','UserID');
	
	public function getJSON()
	{
		return json_encode( array('ID' => $this->UserID,
				'EventID' => $this->EventID),JSON_PRETTY_PRINT);
	}
}

/**
 * Schedule model
 */
class GoogleCalendar extends Entity{

	public $UserID;
	public $EventID;
	public $ModifiedDate;
	
	public $entity_table = 'GoogleCalendar';
	public $entity_class = 'GoogleCalendar';
	public $db_fields = array('EventID','UserID','ModifiedDate');
	public $primary_keys = array('EventID','UserID');
	
	public function getJSON()
	{
		return json_encode( array('ID' => $this->UserID,
				'EventID' => $this->EventID),JSON_PRETTY_PRINT);
	}
}
/* }
Log::d("Testing Entity");
$db = new DBContext();
/*$user = new User();
$user->UserName ='cesarl_88';
$user->Password = "cesarpassword";
$user->Role = 2;
$user->UserID = 0;
echo $user->info();

$db->add($user);

$db->saveChanges();

$user = $db->find(new User(),array('userName'=> 'cls33'));

#echo 'user Saved';

#var_dump($db->findAll(new User()));
 */


?>