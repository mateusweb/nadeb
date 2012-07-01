<?php
class Nadeb_Model_Crud
{
	protected $tb;
	protected $info;
	protected $primary;
	
	public $_params;
	
	public function __construct()
	{
    	$this->info = $this->tb->info();
    	$this->primary = $this->info['primary'][1];
    	
	}
	
	public function get_all($_order = null, $_where = null)
	{
		$data = $this->tb->fetchAll( $_where, $_order )->toArray();
		
    	return $data;
	}
	
	public function get_one($id)
	{
		$data = $this->tb->find($id)->toArray();
		
		if( isset($data[0]) )
	    	return $data[0];
	    else
	    	return false;
	}
	
	public function save($id = null, $post, Nadeb_Data_Form $form, $folder = null)
	{
        $files = new Nadeb_Upload();
		$data  = $form->get_dataToInsert($post, $files->zend_upload(__ROOT__ . 'public/uploads/' . $folder));
		
		if( $id )
		{
			$where = $this->tb->getAdapter()->quoteInto($this->primary . ' = ?', $id);
			$this->tb->update( $data, $where );
			$result  = Array(
					'type'    => 'update',
					'primary' => $id,
					'message' => '<h2>dados alterados com sucesso!</h2>'
				);
		}
		else
		{
			$this->tb->insert( $data );
			
			$result  = Array(
					'type'    => 'insert',
					'primary' => $this->tb->getAdapter()->lastInsertId(),
					'message' => '<h2>dados salvos com sucesso!</h2>'
				);
		}
		
		return $result;
	}
	
	public function delete($id)
	{
		if( !$id )
		{
			$result  = "nenhum dado removido!";
		}
		else if( !is_array($id) )
		{
			$where = $this->tb->getAdapter()->quoteInto($this->primary . ' = ?', $id);
			$this->tb->delete( $where );
			$result  = "dados removidos com sucesso!";
		}
		else
		{
			foreach($id as $key => $value)
			{
				$where = $this->tb->getAdapter()->quoteInto($this->primary . ' = ?', $value);
				$this->tb->delete( $where );
			}
			$result  = "dados removidos com sucesso!";
		}
		return $result;
	}
	
	public function save_order($_neworder)
	{
		$array = explode(",",$_neworder);
		for($i=0; $i < count($array); $i++)
		{
			$data = Array('order' => ($i+1));
			$where = $this->tb->getAdapter()->quoteInto($this->primary . ' = ?', $array[$i]);
			$this->tb->update( $data, $where );
		}
		
		return "Ordem atualizada com sucesso...";
	}
	
	public function list_galery_json($_folder)
	{
		$folder = "/public/uploads/" . $_folder . "/";
		$files  = new Nadeb_Folder();
		$lista  = $files->listFiles( $folder );
		$file   = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . $folder . "info.inf";
		
		if(!is_file( $file ) && is_dir( $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . $folder ))
		{
			foreach($lista as $key => $value)
			{
				$vars[$key]["file"]    = $value;
				$vars[$key]["legenda"] = "";
			}
			
			$json = Zend_Json::encode($vars);
			Nadeb_Savefile::save($file,$json,true);
			return $json;
		}
		elseif(is_file( $file ))
		{
			return Nadeb_Savefile::get($file);
		}
		
		return false;
	}
	
	public function add_to_folder($_folder)
	{
		$patch = __ROOT__ . "public/uploads/" . $_folder . "/";
		
		@mkdir($_SERVER["DOCUMENT_ROOT"] . $patch . '/temp/', 0777,true);
		@chmod($_SERVER["DOCUMENT_ROOT"] . $patch . '/temp/', 0777,true);
		
		$add = new Nadeb_Upload();
		$new_file = $add->zend_upload($patch);
		
    	$image = new Nadeb_CropImages();
    	$image->set_patch( $patch )
    	      ->set_file( $new_file['Filedata']['name'] )
    	      ->set_newName( "temp/nadeb-temp-{$new_file['Filedata']['name']}" )
    	      ->set_newSize('100','100')
    	      ->create()
    	      ->auto_crop()
    	      ->make_file();
		
		$file = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . "public/uploads/" . $_folder . "/info.inf";
		$old_file = Nadeb_Savefile::get($file);
		
		$vars   = Zend_Json::decode($old_file);
		$ultimo = count($vars);
		$vars[$ultimo]["file"]    = $new_file['Filedata']['name'];
		$vars[$ultimo]["legenda"] = "";
		
		$json = Zend_Json::encode($vars);
		Nadeb_Savefile::save($file,$json,true);
		
		/*
		// This section edits your log file, if you don't need a text log file just delete these lines
		$myFile = "c:\logFile.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		$stringData = "\n\ntodayDate: $todayDate  \n Name: $Name \n Email: $Email \n ssid: $ssid \n FileName: $filename \n TmpName: $filetmpname \n Type: $fileType \n Size: $fileSizeMB MegaBytes";
		fwrite($fh, $stringData);
		fclose($fh);
		// End log file edit
		*/

		//return "Arquivos enviados com sucesso!";
		return $new_file['Filedata']['name'];
	}
	
	public function del_to_folder($_params)
	{
		$file = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . "public/uploads/" . $_params["folder"] . "/" . $_params["file"] . "." . $_params["ext"];
		unlink( $file );
		
		$file = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . "public/uploads/" . $_params["folder"] . "/temp/nadeb-temp-" . $_params["file"] . "." . $_params["ext"];
		unlink( $file );
		
		return "Arquivo excluido com sucesso";
	}
	
	public function clear_picture($_params)
	{
		$file = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . "public/uploads/" . $_params["file"] . "." . $_params["ext"];
		if( is_file( $file ) ) unlink( $file );
		
		$info = $this->tb->info();
		$this->tb->update( 
			array( $_params['coloumn'] => ''),
			$this->tb->getAdapter()->quoteInto($info['primary'][1].'= ?', $_params['id'])); 
		
		return "Arquivo excluido com sucesso";
	}
	
	public function getClearPictureUrl($file, $id, $coloumn)
	{
		$file = explode( '.', $file );
		
		return __LINKS__ . "{$this->_params->module}/{$this->_params->controller}/clear-picture/file/{$file[0]}/ext/{$file[1]}/id/{$id}/coloumn/{$coloumn}";
	}
	
	public function save_galery_json($_folder)
	{
		$file  = $_SERVER["DOCUMENT_ROOT"] . __ROOT__ . "public/uploads/" . $_folder . "/info.inf";
		foreach($_POST["file"] as $key => $value)
		{
			$vars[$key]["file"]    = $value;
			$vars[$key]["legenda"] = $_POST["legenda"][$key];
		}
		
		$json = Zend_Json::encode($vars);
		Nadeb_Savefile::save($file,$json,true);
		
		return "Legendas salvas com sucesso";
	}
	
	public function swap_active($_column, $_id)
	{
		$info = $this->tb->info();
		$rows  = $this->tb->find($_id)->toArray();
		$total = $rows[0][$_column];

		$value = ( !$total ) ? "1" :"0";
			
		if($this->tb->update( 
			array( $_column => $value),
			$this->tb->getAdapter()->quoteInto($info['primary'][1].'= ?', $_id)) 
		)
			$this->response = "Dados atualizados com sucesso!";
		else
			$this->response = "Erro ao atualizar dados!";
	}
	
	public function swap_status($_column, $_id)
	{
		$info = $this->tb->info();
		$rows  = $this->tb->find($_id)->toArray();
		$total = $rows[0][$_column];
		
		$value = ( $total == "INATIVO" ) ? "ATIVO" : "INATIVO";
			
		if($this->tb->update( 
			array( $_column => $value),
			$this->tb->getAdapter()->quoteInto($info['primary'][1].'= ?', $_id)) 
		)
			$this->response = "Dados atualizados com sucesso!";
		else
			$this->response = "Erro ao atualizar dados!";
	}
	
	public function breadCrumbs($action)
	{
		$bc = array(
			'list' => array(
				'' => 'home'
			),
			'edit' => array(
				'' => 'home'
			)
		);
		
		return $bc[$action];
	}
}


















