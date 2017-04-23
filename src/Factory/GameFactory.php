<?php
namespace App\Factory;
/**
* class GameFactory 
*/

class GameFactory
{
	public $gameMessage;
	private function __construct()
	{
		;
	}
	/**
	*
	* @param $input User input
	*
	* @return array $shotMessage, $gridState, $grid->getFinalMessage()
	*/
	public static function buildGame($input)
	{
		// Declared variable for shoting message
		$shotMessage = "";

		// Create new instance of class Grid to create game grid, with game grid dimensions 10x10
		$grid = new \App\Models\Grid([GridRow, GridRow]);
		
		for ($battleShip=0; $battleShip < Battleships; $battleShip++) { 

			// Create new instance of class Battleship to create Battleship
			$battleShipShip = new \App\Models\Ships\Battleship(BattleshipSize);

			// Add ships to grid
			$grid->addShip($battleShipShip->getSize());
		}
		
		for ($destroyer=0; $destroyer < Destroyers; $destroyer++) { 
			
			// Create new instance of class Destroyer to create Battleship
			$destroyerShip = new \App\Models\Ships\Battleship(DestroyerSize);

			// Add ships to grid
			$grid->addShip($destroyerShip->getSize());
		}

		// Generate game grid
		$gridState = $grid->getGrid();

		if(isset($input) && $input != "") // Cehck for empty input
			{
				if($input == 'show') // Check for back door command to show only ships
				{
					// Set only ships to grid
					$gridState = $grid->getGrid('show');
				}
				else{
					// Try to shot ship
					$shotMessage = $grid->shot($input);

					// Get game grid with result of shot
					$gridState = $grid->getGrid();
				}
			}else // If input is empty
			{
				// Set empty shot message
				$shotMessage = "";
				
				// Get current grid
				$gridState = $grid->getGrid();
			}

			return [$shotMessage, $gridState, $grid->getFinalMessage()];
	}

	public static function showGame($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage)
	{
		$decorator = new \App\Decorator\WebDecorator($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage);
		if(IsClient)
		{
			$decorator->cliDecorate();
			return;
		}
		
		$decorator->webDecorate();
	}
}