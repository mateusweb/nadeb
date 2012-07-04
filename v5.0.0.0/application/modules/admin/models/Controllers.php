<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';

class Admin_Model_Controllers extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$this->tb = new Application_Model_Db_Controllers();
    	
    	parent::__construct();
	}
	
	public function get_all($_order = null)
	{
		$auth = Zend_Auth::getInstance();
		
		$where = ($auth->getStorage()->read()->groupName == 'Nadeb') ? null : 'idController IN('. $auth->getStorage()->read()->controllers .')';
		$fetchAll = $this->tb->fetchAll( $where, $_order )->toArray();
		
    	return $fetchAll;
	}
	
	public function get_links()
	{
		$data = false;
		$auth = Zend_Auth::getInstance();
		if( !$auth->hasIdentity() ) return false;
		
		$cache = NadebZend_DataCache::get_instance( 'adminMenuGrupo' . $auth->getStorage()->read()->idGroup );
		
		if( !$data = $cache->load() )
		{
		
			$where = ($auth->getStorage()->read()->groupName == 'Nadeb') ? null : 'idController IN('. $auth->getStorage()->read()->controllers .') ';
			$fetchAll = $this->tb->fetchAll( $where, 'order ASC' );

			foreach ($fetchAll as $obj)
			{
				$select = $this->tb->select()->where('idController = ?', $obj->idController)->where('taskType = ?', 'read');
				
				( isset( $auth->getStorage()->read()->permission[ $obj->idController ] ) && $auth->getStorage()->read()->permission[ $obj->idController ] == '2' ) || $auth->getStorage()->read()->groupName == 'Nadeb'
					? $select->orWhere('taskType = ?', 'write')
					: '';
		    	
				$select->order('order ASC')->order('name DESC');
				$dependent['dependent'] = $obj->findDependentRowset('Application_Model_Db_Actions',null, $select)->toArray();
				
				(  $obj->display ) ? $data[ $obj->display ][] = array_merge( $obj->toArray(), $dependent ) : '';
				
			}
			$cache->save($data);
		}
		
    	return $data;
	}
	
	public function get_controllers()
	{
		$i        = 0;
		$auth     = Zend_Auth::getInstance();
		$fetchAll = $this->tb->fetchAll()->toArray();
		
		$controllers = explode(',', $auth->getStorage()->read()->controllers);
		foreach ($fetchAll as $key => $value)
		{
			( in_array($value['idController'], $controllers) || $auth->getStorage()->read()->groupName == 'Nadeb' ) ? $data[$value['idController']] = $value['label'] : $data['x' . ++$i] = 0;
		}

		return $data;
	}
	
	public function check_controllPermission($controll, $controllers)
	{
		$auth = Zend_Auth::getInstance();
		$data = $this->tb->fetchAll( "name = '$controll'")->toArray();
		$controllers = explode(',', $controllers);
		foreach ( $controllers as $key => $value)
		{
			if( $value == $data[0]['idController']) 
			{
				if( $auth->getStorage()->read()->groupName != 'Nadeb' )
				{
					$permission = new Zend_Session_Namespace();
					$permission->permissionType = $data[0]['taskType'];
				}
				return true;
			}
		}
		
		return false;
	}
	
	public function data_grid()
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all( 'order ASC' );
		
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Controllers' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit') );
		$grid->setTools( new LinkTool('Editar Actions', __LINKS__ . 'admin/actions/list/rel', 'edit_rel') );
		$grid->setTools( new MoveTool('Mover', $modelPath . '/save-order') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Label' => 'tm150', 'Controller Name' => 'tm100', 'Tipo de Ação' => 'tm50', 'Exibir em' ) );
		$grid->setRows( array( 'label', 'name', 'taskType', 'display' ) );
		
		return $grid->get();
	}
	
	public function data_form($id = null, $post)
	{
		$data = $id ? $this->get_one($id) : null;
		
		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Controllers' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new InputText('name', 'Controller') );
		$form->add( new InputText('label', 'Nome') );
		$form->add( new RadioButton('display', 'Exibir em', $this->display_options(), 'sideBar') );
		$form->add( new Checkbox('taskType', 'Ação', $this->taskType_options()) );
		$form->fieldset('buttons');
		$form->add( new InputSubmit('btn_save', 'salvar') );
		$form->add( new InputButton('btn_cancel', 'cancelar') );
		
		if( $post )
		{
			$result = $this->save($id, $post, $form);
			if( $result['type'] == 'insert' )
				$this->insertSampleActions( $result['primary'], $post['name'] );
			
			return $result['message'];
		}
		else
		{
			return $form->get();
		}
	}
	
	private function taskType_options()
	{
		$array = Array(
			'read' => 'leitura',
			'write' => 'escrita'
		);
		
		return $array;
	}
	
	private function display_options()
	{
		$array = Array(
			'menu'    => 'Menu',
			'sideBar' => 'Side Bar',
			''        => 'Oculto'
		);
		
		return $array;
	}
	
	private function insertSampleActions($idController, $name)
	{
		$sampleAction = new Admin_Model_Actions();
		$sampleAction->insertSampleActions($idController, $name);
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
				'list' => array(
					'index' => 'home',
					'#' => 'Controllers'
			),
				'edit' => array(
					'' => 'home',
					'controllers/list' => 'Controllers',
					'#' => 'Formulário'
			)
		);
	
		return $bc[$action];
	}
}


















