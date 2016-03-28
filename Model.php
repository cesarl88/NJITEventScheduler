<?php
    
include_once 'EntityModel.php';

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
    
    class Events extends Entity{
    
    	public $ID;
    	public $Title;
    	public $startDate;
    	public $EndDate;
    	public $startTime;
    	public $EndTime;
    	public $Place;
    	public $Submitter;
    	public $UserID;
    	public $Organization;
    	public $EventName;
    	public $Image;
    	public $link;
    	public $Description;
    	public $Approved;
    
    	public $entity_table = 'Events';
    	public $entity_class = 'Events';
    	public $db_fields = array('ID','Title','startDate','EndDate','startTime','endTime','Place','Submitter','UserID','Organization','EventName','Image','link','Description','Approved');
    	public $primary_keys = array('ID');
    
    	function __construct($ID,$Title,$startDate,$EndDate,$startTime,$endDate,$Place,$Submitter,$UserID,$Organization,$Eventname,$Image,$link,$Description,$Approved)
    	{
    		$this->ID = $ID;
    		$this->Title = $Title;
    		$this->startDate = $startDate;
    		$this->EndDate = $EndDate;
    		$this->startTime = $startTime;
    		$this->EndTime = $endDate;
    		$this->Place = $Place;
    		$this->Submitter = $Submitter;
    		$this->UserID = $UserID;
    		$thi->Organization = $Organization;
    		$this->EventName = $Eventname;
    		$this->Image = $Image;
    		$this->link = $link;
    		$this->Description = $Description;
    		$this->Approved = $Approved;
    	}
    
    
    }
    /* class User{
     
     private $name;
     private $UserID;
     private $Role;
     public $UserName;
     public $Password;
     
     function __construct($userName, $Password){
     $this->userName = $userName;
     $this->Password = hash("sha256", $Password);;
     }
     
     
     } */
    
    

    
    #$user = new User('cls33','12345');
    #	echo $user->userName;
    #	echo '<br/>';
    #	echo $user->Password;
    ?>
