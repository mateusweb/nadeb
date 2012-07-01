<?php
class Nadeb_Data_Form
{
	private $title;
	private $form;
	private $obj = "";
	private $objHidden = "";
	private $data;
	private $data_mapp;
	private $infos;
	private $prefix;
	private $jsfolder;
	private $name;
	private $formClass;
	
	public $form_action;
	
	public function __construct($_name = 'nadeb', $formClass = null)
	{
		$this->name = $_name;
		$this->formClass = $formClass;
		$this->title = '';
	}
	
	public function title($value)
	{
		$this->title = "<h2 class=\"session-title\">$value</h2>";
		
		return $this;
	}
	
	public function set_data($data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	public function set_prefix($prefix = '')
	{
		$this->prefix = $prefix;
		
		return $this;
	}
	
	private function inputAll($name,$label,$type,$initValue = null)
	{
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$_label =  ($type == 'button' || $type == 'submit' ) ? '' : "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";
		$_input =  ($type == 'button' || $type == 'submit' ) 
			? "<input type=\"".$type."\" name=\"".$name."\" value=\"$label\" id=\"".strtolower($name)."\" class=\"".strtolower($name)."\" />" 
			: "<input type=\"".$type."\" name=\"".$name."\" value=\"$value\" id=\"".strtolower($name)."\" class=\"".strtolower($name)."\" />";
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							$_label
						</dt>
						<dd id=\"".strtolower($name)."-object\">
							$_input
						</dd>
		";
		return $this;
	}
	
	private function inputHidden($name, $initValue = null)
	{
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		$this->objHidden .= "
						<input type=\"hidden\" name=\"".$name."\" value=\"$value\" id=\"".strtolower($name)."\" />
		";
		return $this;
	}
	
	public function label($name,$label)
	{
		$_label =  "<label class=\"".strtolower($name)."\">".$label."</label>";
		
		$this->obj .= "
						<dt class=\"".strtolower($name)."-label\">
							$_label
						</dt>
		";
		return $this;
	}
	
	public function hidden($name,$initValue = null)
	{
		$this->set_mapForm($name,'hidden');
		$this->inputHidden($name,$initValue);
	}
	
	public function text($name,$label,$initValue = null)
	{
		$this->set_mapForm($name,'text');
		$this->inputAll($name,$label,'text',$initValue);
	}
	
	public function password($name,$label,$initValue = null)
	{
		$this->set_mapForm($name,'password',$initValue);
		$this->inputAll($name,$label,'password',$initValue);
	}
	
	public function aesPsw($name,$label)
	{
		$this->set_mapForm($name,'aesPsw',$initValue = null);
		$this->inputAll($name,$label,'password',$initValue);
	}
	
	public function file($name,$label,$showLink = 'public/uploads/')
	{
		$request   = Zend_Controller_Front::getInstance();
		$uriParams = $request->getRequest()->getParams();
		
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_lightbox";
		
		$label = ( !isset($this->data[ $this->prefix . $name ]) || $this->data[ $this->prefix . $name ] == '' || (!$showLink) ) ? 
			$label : 
			$label . ' <a class="lightbox linkRed" href="'.__LINKS__ . $showLink . $this->data[ $this->prefix . $name ] . '">[ver imagem]</a>' . 
			' <a class="clearFolder linkRed" href="'.str_replace('//','/',
						__LINKS__.$uriParams['module'].'/'.$uriParams['controller'].'/clear-picture/'
						.'file/'.str_replace('.','/ext/',$this->data[ $this->prefix . $name ])
						.'/id/'.$uriParams['id']
						.'/coloumn/'.$name)
						.'" title="remover arquivo">[x]</a>';
		
		$this->set_mapForm($name,'file');
		$this->inputAll($name,$label,'file');
	}
	
	public function button($name,$label)
	{
		$this->inputAll($name,$label,'button');
	}
	
	public function submit($name,$label)
	{
		$this->inputAll($name,$label,'submit');
	}
	
	public function textarea($name,$label,$initValue = null)
	{
		$this->set_mapForm($name,'textarea');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>
						</dt>
						<dd id=\"".strtolower($name)."-object\">
							<textarea name=\"".$name."\" rows=\"4\" cols=\"50\" id=\"".strtolower($name)."\" class=\"".strtolower($name)."\">$value</textarea>
						</dd>
		";
		return $this;
	}
	
	public function jseditor($name,$label,$initValue = null)
	{
    	$header      = Nadeb_HeaderController::get_instance();
		$header->js  = "library/Nadeb/Components/Javascript/CLEditor/jquery.cleditor.min.js";
		$header->js  = "library/Nadeb/Components/Javascript/CLEditor/jquery.cleditor.xhtml.min.js";
		$header->css = "library/Nadeb/Components/Javascript/CLEditor/jquery.cleditor.css";
		
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_JSEditor";
		
		$this->set_mapForm($name,'textarea');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>
						</dt>
						<dd id=\"".strtolower($name)."-object\">
							<textarea name=\"".$name."\" rows=\"4\" cols=\"50\" id=\"".strtolower($name)."\" class=\"".strtolower($name)." jsEditor\">".stripslashes($value)."</textarea>
						</dd>
		";
		return $this;
	}
	
	public function multiple($name,$label,$options,$initValue = null)
	{
		$this->set_mapForm($name,'select');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$_label =  "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";
		
		$_input = "<select multiple name=\"{$name}\" >";
		foreach($options as $key => $val)
		{
			if( $val == $value || $value == $key)
			$_input .= "<option value=\"{$key}\" selected=\"selected\"> {$val} </option>";
			else
			$_input .= "<option value=\"{$key}\"> {$val} </option>";
		}
		$_input .= '</select>';
		
		$this->obj .= "
								<dt id=\"".strtolower($name)."-label\">
		$_label
								</dt>
								<dd id=\"".strtolower($name)."-object\">
		$_input
								</dd>
				";
		return $this;
	}
	
	public function select($name,$label,$options,$initValue = null)
	{
		$this->set_mapForm($name,'select');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$_label =  "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";
		
		$_input = "<select name=\"{$name}\" >";
		if($options)
		{
			foreach($options as $key => $val)
			{
				if( $val == $value || $value == $key)
				$_input .= "<option value=\"{$key}\" selected=\"selected\"> {$val} </option>";
				else
				$_input .= "<option value=\"{$key}\"> {$val} </option>";
			}
		}
		$_input .= '</select>';
		
		$this->obj .= "
								<dt id=\"".strtolower($name)."-label\">
		$_label
								</dt>
								<dd id=\"".strtolower($name)."-object\">
		$_input
								</dd>
				";
		return $this;
	}
	
	public function checkbox($name,$label,$options,$initValue = null)
	{
		$this->set_mapForm($name,'checkbox');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		$_label =  "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";

		$_input = '';
		foreach($options as $key => $val)
		{
			if( strpos(" $value ", "$key") )
				$_input .= "<label class=\"item-{$key}\"><input name=\"{$name}[]\" type=\"checkbox\" value=\"{$key}\" checked=\"checked\" /> <span>{$val}</span></label>";
			else
				$_input .= "<label class=\"item-{$key}\"><input name=\"{$name}[]\" type=\"checkbox\" value=\"{$key}\" /> <span>{$val}</span></label>";
		}
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							$_label
						</dt>
						<dd id=\"".strtolower($name)."-object\">
							$_input
						</dd>
		";
		return $this;
	}
	
	public function radio($name,$label,$options,$initValue = null)
	{
		$this->set_mapForm($name,'radio');
		$value = ( !isset($this->data[ $this->prefix . $name ]) ) ? $initValue : $this->data[ $this->prefix . $name ];
		
		
		$_label =  "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";

		$_input = '';
		foreach($options as $key => $val)
		{
			if( $key == '' && $key != 0 )
				$_input .= "<label class=\"item-{$key}\"><input name=\"{$name}[]\" type=\"radio\" value=\"{$key}\" /> <span>{$val}</span></label>";
			else if( ($value == 0 || $value && $key) && @strpos(" $value ", "$key") )
				$_input .= "<label class=\"item-{$key}\"><input name=\"{$name}[]\" type=\"radio\" value=\"{$key}\" checked=\"checked\" /> <span>{$val}</span></label>";
			else
				$_input .= "<label class=\"item-{$key}\"><input name=\"{$name}[]\" type=\"radio\" value=\"{$key}\" /> <span>{$val}</span></label>";
		}
		
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							$_label
						</dt>
						<dd id=\"".strtolower($name)."-object\">
							$_input
						</dd>
		";
		return $this;
	}
	
	public function jsfolder($name, $label)
	{
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_lightbox";
		$js->JSInstance = "admin_JSFolder";
		
		$header      = Nadeb_HeaderController::get_instance();
		$header->js  = "library/Nadeb/Components/Javascript/jquery_plugins/swfobject.js";
		
		$date = new Zend_Date();
		$value = md5( $date->get('dMYHms') . rand(1000000000001, 9999999999999) );
		
		$this->set_mapForm($name,'hidden');
		$this->inputHidden($name, $value);
		
		$this->jsfolder = "
				<div id=\"jsfolder\" class=\"$name\">
					<form id=\"formJsfolder\" action=\"#\">
						<h1>{$label}</h1>
						<span id=\"flashBrowser\"></span>
						<input type=\"file\" name=\"addfiles\" />
						<input type=\"button\" value=\"Enviar\" class=\"addfolder btn_sendFile\" />
						<input type=\"button\" value=\"Salvar Legendas\" class=\"save_legend btn_save\" />
						<div id=\"root_path\" class=\"".__ROOT__."\"></div>
					<form>
				</div>";
	}
	
	public function fieldset($name)
	{
		$this->obj .= "
					</dl>
				</fieldset>
				<fieldset class=\"fieldset-$name\">
					<dl class=\"dl-$name\">
		";
	}
	
	public function dl($name)
	{
		$this->obj .= "
					</dl>
					<dl  class=\"dl-$name\">
		";
	}
	
	
	public function textsearch($name,$label)
	{
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_search";
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>
						</dt>
						<dd id=\"".$name."Param\">
							<input type=\"text\" name=\"".$name."\" id=\"".strtolower($name)."\" class=\"inputSearch\" />
						</dd>
		";
	}
	public function datesearch($name,$label)
	{
    	$header      = Nadeb_HeaderController::get_instance();
		$header->css = "library/Nadeb/Components/Javascript/ui_theme/jquery-ui-1.8.2.custom.css";
		$header->js  = "library/Nadeb/Components/Javascript/jquery_plugins/jquery-ui-1.8.2.custom.min.js";
		
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_search";
		
		$this->obj .= "
						<dt id=\"".strtolower($name)."-label\">
							<label for=\"start_date\" class=\"".strtolower($name)."-label\">".$label."</label>
						</dt>
						<dd id=\"".$name."Param\">
							<input type=\"text\" name=\"start_date\" id=\"start_date\" class=\"start_date\" />
							<input type=\"text\" name=\"end_date\" id=\"end_date\" class=\"end_date\" />
						</dd>
		";
	}
	
	public function selectsearch($name,$label,$options)
	{
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_search";
		
		$_label =  "<label for=\"".strtolower($name)."\" class=\"".strtolower($name)."-label\">".$label."</label>";
		
		$_input = "<select name=\"{$name}\" class=\"selectSearch\">";
		if($options)
		{
			foreach($options as $key => $val)
			{
				$_input .= "<option value=\"{$key}\"> {$val} </option>";
			}
		}
		$_input .= '</select>';
		
		$this->obj .= "
								<dt id=\"".strtolower($name)."-label\">
		$_label
								</dt>
								<dd id=\"".$name."Param\"\">
		$_input
								</dd>
				";
		return $this;
	}
	
	
	public function create_form()
	{
		$cssClass = ( $this->formClass ) ? $this->formClass  : $this->name;
		$this->form = "
			{$this->title}
			<form class=\"{$cssClass}\" id=\"{$this->name}\" name=\"{$this->name}\" action=\"{$this->form_action}\" method=\"post\" enctype=\"multipart/form-data\">
				<fieldset class=\"fieldset-{$this->name}\">
					<dl class=\"dl-{$this->name}\">
						$this->obj
					</dl>
				</fieldset>
				<fieldset class=\"hidden\">
					$this->objHidden
				</fieldset>
			</form>
			$this->jsfolder";
		
		return $this;
	}
	
	private function set_mapForm($name,$type)
	{
		$this->infos .= $name . ',' . $type . '|';
	}
	
	public function get_dataToInsert($data,$files)
	{
		$data_insert = null;
		$mapp = explode( '|',$this->infos );
		array_pop($mapp);
		
		foreach( $mapp as $key => $value)
		{
			if($value) $mapp[$key] = explode( ',',$value );
		}
		
		foreach( $mapp as $key => $value)
		{
			if( $value[1] == 'file' )
			{
				if( $files[$value[0]]['name'] )	$data_insert[$this->prefix . $value[0]] = $files[$value[0]]['name'];
			}
			elseif( $value[1] == 'aesPsw' )
			{
				if( $data[$value[0]] ) $data_insert[$this->prefix . $value[0]] = new Zend_Db_Expr("AES_ENCRYPT('{$data[$value[0]]}','{$data[$value[0]]}')");
			}
			elseif( $value[1] == 'radio' || $value[1] == 'checkbox' )
			{
				if( isset($data[$value[0]]) && is_array($data[$value[0]]) ) $data_insert[$this->prefix . $value[0]] = implode(',',$data[$value[0]]);
				
				if( isset($data[$value[0]]) && !is_array($data[$value[0]]) ) $data_insert[$this->prefix . $value[0]] = $data[$value[0]];
			}
			else
			{
				if( $data[$value[0]] ) $data_insert[$this->prefix . $value[0]] = $data[$value[0]];
			}
			
		}
		
		return $data_insert;
	}
	
	/**
	 * Retorna o XHTML do data form
	 * 
	 * @return string
	 */
	public function get()
	{
		return $this->form;
	}
}
