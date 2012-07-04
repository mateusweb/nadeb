<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';

class Admin_Model_Faleconosco extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$this->tb = new Application_Model_Db_Faleconosco();
    	
    	parent::__construct();
	}
	
	
	public function data_grid($params = null)
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all(  );
	
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Sample' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Nome' => 'tm150', 'E-mail' => 'tm100', 'Exibir' ) );
		$grid->setRows( array( 
					'name',
					'email',
					'active' => new GSwap( $modelPath,'1,0' ) ));
		
		return $grid->get();
	}
	
	
	public function data_form($id = null, $post)
	{
		$data = $id ? $this->get_one($id) : null;
	
		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Faleconosco' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new InputText('name', 'Nome') );
		$form->add( new InputText('email', 'E-mail') );
		$form->add( new JSEditor('body', 'Mensagem') );
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
	
}


