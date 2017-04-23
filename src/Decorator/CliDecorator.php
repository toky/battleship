<?php
namespace App\Decorator;

class CliDecorator
{
	private $gridState;
	private $gridRow;
	private $gridCol;
	private $shotMessage;
	private $finalMessage;

	public function __construct($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage)
	{
		$this->gridState = $gridState;
		$this->gridCol = $gridCol;
		$this->gridRow = $gridRow;
		$this->shotMessage = $shotMessage;
		$this->finalMessage = $finalMessage;
	}

	public function decorate()
	{
		$view = new \App\Controllers\View(HOME . DS . 'Views' . DS . 'Cli' . DS . 'index' . '.tpl');

		// Set grid variable to template with game grid
		$view->set('grid', $this->gridState);

		// Set variable with shot message to template
		$view->set('shotMessage', $this->shotMessage);

		// Set variable with final message to template
		$view->set('finalMessage', $this->finalMessage);

		// Set variable with grid row count to template
		$view->set('gridRowCount', $this->gridRow);

		// Set variable with grid colum count to template
		$view->set('gridColCount', $this->gridCol);

		$view->setFile('Cli', 'index');
		
		/*// Set path to sub template
		$view->setRender('Web', 'index');

		// Render sub template
		$viewTable = $view->render();

		// Set main variable to render sub template to main template
		$view->set('viewElement', $viewTable);
			
		// Set main template
		$view->setFile('', 'index');*/

		return $view->autput();

	}
}