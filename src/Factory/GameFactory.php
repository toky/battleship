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

		// Create new instance of class Battleship to create Battleship
		$battleShip = new \App\Models\Ships\Battleship(BattleshipSize);

		// Create new instance of class Battleship to create first Destroyer
		//$firstDestroyer = new \App\Models\Ships\Destroyer(DestroyerSize);

		// Create new instance of class Battleship to create second Destroyer
		$secondDestroyer = new \App\Models\Ships\Destroyer(DestroyerSize);

		// Add ships to grid
		$grid->addShip($battleShip->getSize());
		//$grid->addShip($firstDestroyer->getSize());
		$grid->addShip($secondDestroyer->getSize());

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

	public static function showGame($client, $gridState, $gridRow, $gridCol, $shotMessage, $finalMessage)
	{

		if($client == "Web")
		{

			$decorator = new \App\Decorator\WebDecorator($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage);
		}
		else
		{
			$decorator = new \App\Decorator\CliDecorator($gridState, $gridRow, $gridCol, $shotMessage, $finalMessage);
		}

		$decorator->decorate();
	}
}