<?php
class Nadeb_ZendAuth_Adapter implements Zend_Auth_Adapter_Interface
{
	public $table = 'users';
	public $userColumn = 'email';
	public $passwordColumn = 'password';
	protected $authAdapter;
	
	/**
	* Sets username and password for authentication
	*
	* @return void
	*/
	public function __construct($username = null, $password = null)
	{
		if($username && $password)
		{
			$this->authAdapter = new Zend_Auth_Adapter_DbTable();
			$this->authAdapter->setTableName( $this->table );
			$this->authAdapter->setIdentityColumn( $this->userColumn );
			$this->authAdapter->setCredentialColumn( $this->passwordColumn );
			$this->authAdapter->setCredentialTreatment( 'AES_ENCRYPT(?, "'.$password.'")' );
			$this->authAdapter->setIdentity( $username );
			$this->authAdapter->setCredential( $password  );
		}
	}
	
	/**
	* Performs an authentication attempt
	*
	* @throws Zend_Auth_Adapter_Exception If authentication cannot
	*                                     be performed
	* @return Zend_Auth_Result
	*/
	public function authenticate()
	{
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($this->authAdapter);
		if($result->isValid())
		{
			$user = $this->authAdapter->getResultRowObject( null, $this->passwordColumn );
			
			$tb = new Application_Model_Db_Users();
	    	$rs = $tb->find( $user->idUser )->current();
	    	$dependent = $rs->findDependentRowset('Application_Model_Db_Groups')->toArray();
	    	
	    	$permissions = explode(',', $dependent[0]['permission']);
	    	$controllers = explode(',', $dependent[0]['controllers']);
	    	
	    	
	    	foreach ( $permissions as $key => $value )
	    	{
	    		if($value == 0 || substr($controllers[$key], 0,1) == 'x') unset( $controllers[$key] );
	    		else $permission[ $controllers[$key] ] = $value;
	    	}
	    	
	    	$objStorage = $this->authAdapter->getResultRowObject( null, $this->passwordColumn );
	    	$objStorage->groupName = $dependent[0]['name'];
	    	$objStorage->permission = $permission;
	    	$objStorage->controllers = implode(',', $controllers);
	    	
			$storage = $auth->getStorage();
			$storage->write( $objStorage );
		}
		
		return $result;
	}
	
	public function unAuthenticate()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
	}
}