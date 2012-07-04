<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';

class Admin_Model_Sample extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$this->tb = new Application_Model_Db_Sample();
    	
    	parent::__construct();
	}
	
	public function get_all($params = null, $order = null)
	{
		$select = $this->tb->select();
		if( isset($params['dateBetween']) )    $select->where("insertDate BETWEEN '{$params['start_date']}' AND  ?", "{$params['end_date']}");
		if( $order )                           $select->order($order);
	
		$fetchAll = $this->tb->fetchAll( $select )->toArray();
		
		return $fetchAll;
	}
	
	public function data_grid($params = null)
	{
		$modelPath = __LINKS__ . 'admin/' . $this->_params->controller;
		$data = $this->get_all( $params );
		
		$grid = new DataGrid( 'nadeb-grid' );
		$grid->title( 'Listagem de Sample' );
		$grid->primary( $this->primary );
		$grid->setData( $data );
		$grid->setAction( $modelPath.'/delete/' );
		$grid->setControllers( new DeleteButton('delete_button', 'Excluir') );
		$grid->setControllers( new Link('insert_button', 'Inserir', $modelPath . '/edit') );
		$grid->setTools( new MoveTool('Mover', $modelPath . '/save-order') );
		$grid->setTools( new EditTool('Editar', $modelPath . '/edit') );
		$grid->setTools( new DeleteTool('Excluir', $modelPath . '/delete') );
		$grid->setHeader( array( 'Titulo' => 'tm150', 'Tipo' => 'tm100', 'Imagem' => 'tm50', 'Data', 'Exibir' ) );
		$grid->setRows( array( 
					'title', 
					'type', 
					'picture', 
					'date',
					'active' => new GSwap( $modelPath,'1,0' ) ));
		return $grid->get();
	}
	
	public function data_form($id = null, $post)
	{
		$data = $id ? $this->get_one($id) : null;
		$picFolder =  __ROOT__ . 'public/uploads/';
		$picRemove = $data ? $this->getClearPictureUrl($data['picture'], $data['idSample'], 'picture') : null;

		$form = new DataForm( 'nadeb-form' );
		$form->setData( $data );
		$form->title( 'Cadastro de Sample' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/edit/' . ( ($id) ? 'id/' . $id : '' );
		$form->add( new InputHidden('idSample') );
    	$form->add( new InputPassword('password', 'Senha') );
		$form->add( new Select('type', 'Tipo', $this->typeOptions(), '04') );
		$form->add( new InputText('title', 'Titulo') );
		$form->add( new TextArea('body', 'Conteúdo') );
		$form->add( new JSEditor('htmlBody', 'Conteúdo') );
		$form->add( new InputFile('picture', 'Imagem', null, null, $picFolder, $picRemove) );
		$form->add( new InputText('date', 'Data') );
		$form->fieldset('options');
		$form->label('nadebTitle', 'Outras Opções');
		$form->add( new RadioButton('option1', 'Opções 1', $this->typeOptions(), '02') );
		$form->add( new Checkbox('option2', 'Opções 2', $this->typeOptions(), '03') );
		$form->fieldset('buttons');
		$form->add( new InputSubmit('btn_save', 'salvar') );
		$form->add( new InputButton('btn_cancel', 'cancelar') );
		$form->jsFolder( new JSFolder('folder', 'Galeria de imagens') );
		
		if( $post )
        {
        	$result = $this->save($id, $post, $form, $picFolder);
        	return $result['message'];
        }
        else
        {
        	return $form->get();
        }
	}
	
	public function search_form()
	{
		$form = new FormSearch( 'search-form' );
		$form->form()->action = __LINKS__ . 'admin/'. $this->_params->controller .'/list/search/true/';
		$form->add( new DateSearch('insertDate','Data') );
		$form->add( new SelectSearch('type','Tipo', $this->typeOptions()) );
		$form->add( new SelectSearch('state','Estado') );
		$form->add( new TextSearch('title','Titulo') );
		
		return $form->get();
	}
	
	public function typeOptions()
	{
		return array('01' => 'Tipo 1', '02' => 'Tipo 2', '03' => 'Tipo 3', '04' => 'Tipo 4');
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
			'list' => array(
				'index' => 'home',
				'#' => 'Sample'
			),
			'edit' => array(
				'' => 'home',
				'sample/list' => 'Sample',
				'#' => 'Formulário'
			)
		);
			
		return $bc[$action];
	}
}


