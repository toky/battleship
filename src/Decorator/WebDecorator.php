<?php
namespace App\Decorator;

class WebDecorator
{
	private $gridState;
	private $gridRow;
	private $gridCol;
	private $shotMessage;
	private $finalMessage;
	private $view;

	public function __construct($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage)
	{
		$this->gridState = $gridState;
		$this->gridCol = $gridCol;
		$this->gridRow = $gridRow;
		$this->shotMessage = $shotMessage;
		$this->finalMessage = $finalMessage;
		$this->view = new \App\Utilities\View();
	}

	private function setVarToTemplate()
	{
		// Set grid variable to template with game grid
		$this->view->set('grid', $this->gridState);

		// Set variable with shot message to template
		$this->view->set('shotMessage', $this->shotMessage);

		// Set variable with final message to template
		$this->view->set('finalMessage', $this->finalMessage);

		// Set variable with grid row count to template
		$this->view->set('gridRowCount', $this->gridRow);

		// Set variable with grid colum count to template
		$this->view->set('gridColCount', $this->gridCol);
	}

	public function cliDecorate()
	{
		$this->setVarToTemplate();
		$this->view->setFile('Cli', 'index');
		
		return $this->view->output();
	}
	public function webDecorate()
	{
		$this->setVarToTemplate();

		// Set path to sub template
		$this->view->setRender('Web', 'index');

		// Render sub template
		$viewTable = $this->view->render();

		// Set main variable to render sub template to main template
		$this->view->set('viewElement', $viewTable);
			
		// Set main template
		$this->view->setFile('', 'index');

		return $this->view->output();

	}
}