<?php
namespace App\Utilities;
/**
* class View - representation of View in MVC logic 
*
*/
class View
{
	/**
	* @var string $_file
	* @var mixed array $_date
	* @var string $_renderFile
	*/
	protected $_file;
	protected $_date = array();
	public $_renderFile;
	
	/**
	* Set date to template
	* @param int $key;
	* @param int|string|bool|array $value
	* 
	* @return void
	*/
	public function set($key, $value)
	{
		$this->_date[$key] = $value;
	}
	
	/**
	* Get seted date to template
	*
	* @return array
	*/
	public function get()
	{
		return $thus->_date[$key];
	}

	/**
	* Set main file for rendering
	*
	* @param $setRenderFolder
	* @param $setRenderFile
	*
	* @return void
	*/
	public function setRender($setRenderFolder,$setRenderFile)
	{
		$this->_renderFile = HOME . DS . 'src\Views' . DS . $setRenderFolder . DS . $setRenderFile . '.tpl';
	}

	/**
	* Render date in template
	*
	* @return string
	*/
	public function render()
	{
		if(!file_exists($this->_renderFile)){
			throw new \App\Utilities\Exceptions("Missing sub template.");
		}
		extract($this->_date);
		ob_start();
		include($this->_renderFile);
		$renderOutput = ob_get_contents();
		ob_end_clean();
		return $renderOutput;
	}
	
	/**
	* Set file for rendering
	*
	* @param $setFolder
	* @param $setFile
	*
	* @return void
	*/
	public function setFile($setFolder,$setFile)
	{
		$this->_file = HOME . DS . 'src\Views' . DS . $setFolder . DS . $setFile . '.tpl';
	}
	
	/**
	* Output rendered file with date
	*
	* @return string
	*/
	public function output()
	{
		
		if(!file_exists($this->_file)){
			throw new \App\Utilities\Exceptions("Missing template.");
		}
		extract($this->_date);
		ob_start();
		include($this->_file);
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
	}
	
	
}