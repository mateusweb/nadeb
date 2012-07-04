<?php
/**
 * Nadëb (Makú-Nadëb)
 * 
 * @author     Mateus Martins <mateusweb@gmail.com>
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 * @package    Nadeb
 * @version    2.0.0
 */


/**
 * Class Nadeb_Data_Grid
 * 
 * 
 * @category   Nadeb
 * @package    Nadeb_Data_Grid
 * @copyright  Copyright 2011 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Data_Grid
{
	/**
	 * @var string
	 */
	private $gd;
	private $title;
	
	public $totReg = 0;
	public $readOnly = false;
	public $premission;
	public $primary;
	public $columns;
	public $tools;
	public $rows;
	public $uriParams;
	
	/**
	 * Metodo Construtor da classe
	 */
	public function __construct()
	{
		$request   = Zend_Controller_Front::getInstance();
		$this->uriParams = $request->getRequest()->getParams();
		
		$permission = new Zend_Session_Namespace();
		$this->permission = $permission->permissionType;
		$permission->permissionType = null;
		
		$this->title = '';
	}
	
	/**
	* Define o Titulo para o data grid
	*/
	public function title($value)
	{
		$this->title = "<h2 class=\"session-title\">$value</h2>";
	}
	
	/**
	 * Monta a tabela que forma o data grid
	 */
	public function create_table($data)
	{
    	$header      = Nadeb_HeaderController::get_instance();
		$header->css = "library/Nadeb/Components/TemplateBlue/css/grid.css";
		$header->css = "library/Nadeb/Components/TemplateBlue/css/forms.css";
		$header->js  = "library/Nadeb/Components/Javascript/jquery_plugins/jquery.form.js";
		
		$js             = Nadeb_JScontroller::get_instance();
		$js->JSInstance = "admin_grid";
		
		if( isset($this->permission) )
			$this->readOnly = ($this->permission == 'read,write') ? false : true;
		
		$exportButton = ( isset($this->tools['export']) ) ? "<a href='{$this->tools['export']}' class=\"export_button\">Exportar</a>" : '';
		
		if( $this->readOnly == false )
		{
			$buttons = "
					<tr class=\"buttons\">
						<th colspan=\"99\">
							<a href='{$this->tools['editar']}' class=\"insert_button\">Inserir</a>
							<input type=\"submit\" class=\"delete_button\" value=\"Excluir\" />
							$exportButton
							<!--strong class=\"abRex\">Total de registros: {$this->totReg}</strong --!>
						</th>
					</tr>";
			
			$checkAll = "<th class='td_checkbox'><a href=\"//todos\">all</a></th>";
		}
		elseif( $this->readOnly == true && isset($this->tools['export']) )
		{
			$buttons = "
					<tr class=\"buttons\">
						<th colspan=\"99\">
							$exportButton
							<!--strong class=\"abRex\">Total de registros: {$this->totReg}</strong --!>
						</th>
					</tr>";
			$checkAll = "";
		}
		else
		{
			$buttons = "";
			$checkAll = "";
		}
		
		if( isset($this->tools['export']) ) unset($this->tools['export']) ;
		
		$column = '';
		$x = 0;
		if( $this->columns )
			foreach($this->columns as $columns => $val) $column .= "<th class='top_" . $x++ . "'>{$val}</th>\n\t\t\t\t\t\t";
		
		$tools = ( $this->tools ) ? "<th colspan=\"". count($this->tools) ."\" class=\"th_editar\">Editar</th>" : "";
		
		
		$i = 0;
		$row = "";
		if($data)
		{
			foreach($data as $key => $value)
			{
	
				$row .= "
						<tr class='move'>\n";
				if( $this->readOnly == false )
					$row .= "						<td class='td_checkbox'><input name='id[]' type='checkbox' value='{$value[$this->primary]}' /></td>\n";
					
				foreach($this->rows as $name => $decorators)
				{
					$tmClass      = is_array($decorators) ? $decorators[0] : $decorators;
					$fnName       = is_array($decorators) ? 'Nadeb_Data_Decorator_' . ucfirst( $decorators[1] ) . '::get' : 'Nadeb_Data_Decorator_Text::get';
					$params       = array(
										'primary' => $value[$this->primary], 
										'column'  => $name, 
										'value'   => $value[$name], 
										'params'  => !is_array($decorators) ? '' : $decorators[2]
									);
					
					$strVal = call_user_func( $fnName, $params );
						
					$row .= "						<td class='$tmClass'>" . $strVal . "</td>\n";
				}
				
				if( $this->readOnly == true && isset($this->tools['excluir']) ) unset($this->tools['excluir']);
				
				if( $this->tools )
				{
					foreach($this->tools as $num => $name)
					{
						$param = ($num == 'rel') ? 'list/rel' : ($num == 'editar' || $num == 'excluir' ? 'id' : $num);
						$link  = $name . $param . '/' . $value[$this->primary];
						
						$row .= "						<td class='edit_$num'><a href=\"{$link}\">$num</a></td>\n";
					}
				}
				
				$row .= "					</tr> \n";
			}
		}
		else
		{
				$row .= "					<tr>\n";
				$row .= "						<td colspan=\"99\">Nenhum registro encontrado</td>\n";
				$row .= "					</tr> \n";
		}
		
		$excluirPath = ( $this->readOnly == false && isset($this->tools['excluir']) ) ? $this->tools['excluir'] : ''; 
		
		$this->gd = "<!-- DATAGRID! -->
		{$this->title}
		<form id=\"fGrid\" method=\"post\" action=\"{$excluirPath}\">
			<table>
				<thead>
					$buttons
					<tr>
						$checkAll
						$column
						$tools
					</tr>
				</thead>
				<tfoot>
					<tr>
						$checkAll
						$column
						$tools
					</tr>
					$buttons
				</tfoot>
				<tbody>$row</tbody>
			</table>
		</form>
		<!-- DATAGRID! -->";
		
		if( isset($this->uriParams['ajax']) && !isset($this->uriParams['export']) ) $this->gd = "<tbody>$row</tbody>";
		if( isset($this->uriParams['export']) ) $this->gd = "<table>{$column}{$row}</table>";
			
		
		return $this;
	}
	
	/**
	 * Retorna o XHTML do data grid
	 * 
	 * @return string
	 */
	public function get()
	{
		return $this->gd;
	}
}
