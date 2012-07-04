<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';

class Admin_Model_Actions extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$this->tb = new Application_Model_Db_Actions();
    	
    	parent::__construct();
	}
	
	
	public function get_all($_order = null)
	{
		$data = $this->tb->fetchAll( 'idController = ' . $this->_params->rel, $_order )->toArray();
		
    	return $data;
	}
	
	public function data_grid($params = null)
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all( 'order ASC' );
		
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Actions' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit/rel/' . $this->_params->rel ) );
		$grid->setTools( new MoveTool('Mover', $modelPath . '/save-order') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Nome' => 'tm150', 'Link' => 'tm100', 'taskType' ) );
		$grid->setRows( array( 'name', 'link', 'taskType' ) );
		
		return $grid->get();
	}
	
	public function data_form($id = null, $post)
	{
		$data = $id ? $this->get_one($id) : null;
		
		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Actions' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new InputHidden('idController', $this->_params->rel) );
		$form->add( new InputText('name', 'Nome') );
		$form->add( new InputText('link', 'Link', 'admin/'. $this->_params->controller .'/[ação]/') );
		$form->add( new Checkbox('taskType', 'Ação', $this->taskType_options()) );
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
	
	private function taskType_options()
	{
		$array = Array(
			'read' => 'leitura',
			'write' => 'escrita'
		);
		
		return $array;
	}
	
	public function insertSampleActions($idController, $name)
	{
		$data1 = Array
				(
					'idController' => $idController,
					'name'         => 'Listar',
					'link'         => 'admin/'.strtolower($name).'/list/',
					'taskType'     => 'read'
				);
		$data2 = Array
				(
					'idController' => $idController,
					'name'         => 'Inserir',
					'link'         => 'admin/'.strtolower($name).'/edit/',
					'taskType'     => 'write'
				);
		
		$this->tb->insert($data1);
		$this->tb->insert($data2);
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
			'list' => array(
				'index' => 'home',
				'controllers/list' => 'Controllers',
				'#' => 'Actions'
			),
			'edit' => array(
				'' => 'home',
				'controllers/list' => 'Controllers',
				'actions/list/rel/' .  $this->_params->rel => 'Actions',
				'#' => 'Formulário'
			)
		);
	
		return $bc[$action];
	}
	
}


















