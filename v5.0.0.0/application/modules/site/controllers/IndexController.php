<?php
class IndexController extends Nadeb_Controller_Front
{
	
    public function init()
    {
    	parent::init();
    }

    public function indexAction()
    {
    	include '/DataForm/DataForm.php';
    	
    	$form = new DataForm( 'nadeb-form' );
    	$form->title( 'Cadastro de Faleconosco' );
    	$form->form()->action = 'index/save';
    	$form->add( new InputText('name', 'Nome') );
    	$form->add( new InputText('email', 'E-mail') );
    	$form->fieldset('buttons');
    	$form->add( new InputSubmit('btn_save', 'salvar') );
    	
    	$this->view->form = $form->get();
    	
//     	if( $post )
//     	{
//     		$result = $this->save($id, $post, $form);
//     		return $result['message'];
//     	}
//     	else
//     	{
//     		return 
//     	}
    	
    }
    
    public function saveAction()
    {
    	$data = $this->_request->getPost();
    	$data['active'] = 0;
    	
    	unset( $data['btn_save'] );
    	
    	$fale = new Application_Model_Db_Faleconosco();
    	$fale->insert( $data );
    	
    	Nadeb_Debug::x( $data );
    }

    public function formAction()
    {
    	include '/DataForm/DataForm.php';
    	
    	$form = new DataForm( 'nadeb-form' );
    	$form->title( 'Contate-nos' );
    	$form->form()->action = 'http://www.action.com.br';
    	
    	$form->add( new InputText( 'name', 'Nome' ) );
    	$form->add( new InputText( 'phone', 'Telefone' ) );
    	$form->add( new TextArea( 'message', 'Mensagem' ) );
    	$form->add( new InputSubmit( 'send', 'Enviar' ) );
    	
    	$this->view->form = $form->get();
    }
    
}

