<?php
class Admin_Model_Users extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$this->tb = new Application_Model_Db_Users();
    	
    	parent::__construct();
	}
	
	public function get_all()
	{
		$auth = Zend_Auth::getInstance();
		$storage = $auth->getStorage()->read();
		
		$db = $this->tb->getAdapter();
		$select = $db->select()
					 ->from( array('a' => $this->info['name']) )
					 ->join( array('b' => 'groups'), 'a.idGroup = b.idGroup', Array('nameGroup' => 'name') )
		;
		if($storage->groupName != "Nadeb")
			$select->where('b.name <> "Nadeb"');
		
		$data = $db->fetchAll( $select );
		
    	return $data;
	}
	
	public function data_grid($params = null)
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all( 'order ASC' );
		
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Usuários' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Nome','Email' ) );
		$grid->setRows( array( 'name', 'email' ) );
		
		return $grid->get();
	}
	
	public function data_form($id = null, $post)
	{
		$data = $id ? $this->get_one($id) : null;
		
		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Usuários' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new Select('idGroup','Grupo',$this->groups()) );
		$form->add( new InputText('name', 'Nome') );
		$form->add( new InputText('email', 'Email') );
		$form->add( new InputPassword('password', 'Senha') );
		$form->fieldset('buttons');
		$form->add( new InputSubmit('btn_save', 'salvar') );
		$form->add( new InputButton('btn_cancel', 'cancelar') );
		if( $post )
		{
			if( $post['password'] == '' ) unset( $post['password'] );
			else $post['password'] = new Zend_Db_Expr( "AES_ENCRYPT('{$post['password']}','{$post['password']}')" );
			
			
			$result = $this->save($id, $post, $form);
			return $result['message'];
		}
		else
		{
			return $form->get();
		}
	}
	
	private function groups()
	{
		$controllers = new Admin_Model_Groups();
		$array = $controllers->get_groups();
		
		return $array;
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
			'list' => array(
				'index' => 'home',
				'#' => 'Usuários'
			),
			'edit' => array(
				'' => 'home',
				'users/list' => 'Usuários',
				'#' => 'Formulário'
			)
		);
	
		return $bc[$action];
	}
	
}


















