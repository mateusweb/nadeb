<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';
include_once '/HeaderController.php';
include_once '/JScontroller.php';

class Admin_Model_Groups extends NadebZend_Model_Crud
{
	private $storage;
	
	public function __construct()
	{
		$auth = Zend_Auth::getInstance();
		$this->storage = $auth->getStorage()->read();
		
    	$this->tb = new Application_Model_Db_Groups();
    	
    	parent::__construct();
	}
	
	public function get_groups()
	{
		$where = $this->storage->groupName != "Nadeb" ? 'name <> "Nadeb"' : null;
		$fetchAll = $this->tb->fetchAll( $where )->toArray();
		foreach ($fetchAll as $key => $value)
		{
			$data[$value['idGroup']] = $value['name'];
		}
		
		return $data;
	}
	
	public function get_all()
	{
		$where = $this->storage->groupName != "Nadeb" ? 'name <> "Nadeb"' : null;
		
		$data = $this->tb->fetchAll( $where )->toArray();
		
    	return $data;
	}
	
	
	
	public function get_one($id)
	{
		$data = $this->tb->find($id)->toArray();
		
		if( isset($data[0]) )
		{
			
			if($data[0]['name'] == "Nadeb" && $this->storage->groupName != "Nadeb")
				return false;
				
	    	return $data[0];
		}
	    else
	    {
	    	return false;
	    }
	}
	
	public function data_grid($params = null)
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all( 'order ASC' );
		
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Grupos' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Nome' ) );
		$grid->setRows( array( 'name' ) );
		
		return $grid->get();
	}
	
	public function data_form($id = null, $post)
	{
		$js             = JScontroller::get_instance();
		$js->JSInstance = "admin_PermissionControll";
		
		$data = $id ? $this->get_one($id) : null;
		
		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Grupos' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new InputHidden('permission') );
		$form->add( new InputText('name', 'Nome') );
		$form->add( new Checkbox('controllers', 'Controles', $this->controllers()) );
		$form->fieldset('buttons');
		$form->add( new InputSubmit('btn_save', 'salvar') );
		$form->add( new InputButton('btn_cancel', 'cancelar') );
		
		if( $post )
		{
			$result = $this->save($id, $post, $form);
			return $result['message'];
		}
		else
		{
			return $form->get();
		}
	}
	
	private function controllers()
	{
		$controllers = new Admin_Model_Controllers();
		$array = $controllers->get_controllers();
		
		return $array;
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
			'list' => array(
				'index' => 'home',
				'#' => 'Grupos'
			),
				'edit' => array(
					'' => 'home',
					'groups/list' => 'Grupos',
					'#' => 'Formulário'
			)
		);
	
		return $bc[$action];
	}
}


















