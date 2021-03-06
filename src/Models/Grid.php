<?php
namespace App\Models;

/**
 * Class Grid - representation of the game grid
 *
 */
class Grid{
 	/**
    * @var int $row contain rows of grid
    * @var int $column contain col of grid
    * @var int $ships contain rows of grid
    * @var mixed [] $matrix contain game grid
    * @var int $countShips contain ships count
    * @var int $countShots contain player's shots
    * @var int $sunkedShips contain sunked ships
    * @var int $finalMessage contain final game message
    */
	private $row;
	private $col;
	private $ships;
	private $matrix;
	protected $countShips;
	protected $countShots;
	protected $sunkedShips;
	private $finalMessage;


	/**
	* @param Grid dimension
	*/
	public function __construct($gridDimension)
	{

		$this->sunkedShips = 0;
		$this->countShots = 0;
		$this->ships=[];
		$this->row = $gridDimension[0];
		$this->col = $gridDimension[1];
		$this->countShips = 0;
		$this->matrix = $this->generateGrid();
		if (!isset($_SESSION['grid'])) {
			$_SESSION['grid'] = $this->generateGrid();
		}
	}

	/**
	* Generate game grid
	*
	* @return array 
	*/
	private function generateGrid()
	{
		for ($row=0; $row < $this->row; $row++) { 
			for ($col=0; $col < $this->col; $col++) { 
				$this->matrix[$row][$col] = ".";
			}
		}
		return $this->matrix;
	}

	/**
	* Get generated game grid in SESSION. Cehck for backdoor command to show ships
	*
	* @param string $state State of grid 
	*
	* @return session 
	*/
	public function getGrid($state = null)
	{
		if($state == 'show') // Check for cheat command, to show ships in game grid
		{
			return $_SESSION['gridWithShips'] = $this->showShipsOnGrid($_SESSION['shipCoordinates']);
		}
		else{ // return game grid with hidden ships
			return $_SESSION['grid'];
		}
	}

	/**
	* Get grid row count
	*
	* @return int 
	*/
	public function getRowCount()
	{
		return $this->row;
	}

	/**
	* Get grid column count
	*
	* @return int 
	*/
	public function getColCount()
	{
		return $this->col;
	}

	/**
	*	Add ship to game grid
	*
	* @param int $shipsize
	*/
	public function addShip($shipSize)
	{
		// Generate random number from ship orientation 0 form column or 1 form row.
		$shipOrientation = rand(0, 1);

		// Generate random first starting point for ship (row).
		$startingCoordinateRow = [rand(0, $this->row - 1), rand(0, ($this->row -1) - $shipSize)];

		// Generate second starting point for ship (col).
		$startingCoordinateCol = [rand(0, ($this->col - 1) - $shipSize), rand(0, $this->col - 1)];
		
		$i = 0;
		while($i < $shipSize)//loop for adding other coordinates to ship
		{

			if($shipOrientation)// if orientation is 1(row) decrement column
			{
				$row = $startingCoordinateRow[0] ;
				$col = $startingCoordinateRow[1]+ $i;
			}
			else // if orientation is 0(column) decrement row
			{
				$row = $startingCoordinateCol[0]+ $i;
				$col = $startingCoordinateCol[1] ;
			}

			// Put ship coordinates to array to store them
			$shipCoordinates[] = $row . ';' . $col;
			$i++;
		}
			
		if(empty($this->ships)) // Cechk ships count, to add first ship without verification for overlaping
		{
			// Add Coordinate to ships array to store him
			$this->ships[] = $shipCoordinates;

			// Increment ships count
			$this->countShips++;
		}
		else
		{
			if($this->isShipOverlap($this->ships, $shipCoordinates)) // Cechk ship coordinate for overlaping with others ship
			{	
				// Clear ship from ship array
				$this->ships = [];

				// Call again same method to generate new coordinates
				$this->addShip($shipSize);
			}
			else
			{
				// Add Coordinate to ships array to store him
				$this->ships[] = $shipCoordinates;

				// Increment ships count
				$this->countShips++;
			}
		}
		if(!isset($_SESSION["shipCoordinates"][$this->countShips])) // Check is set session with current ship
		{
			// Set current ship coordinates to session
			$_SESSION["shipCoordinates"][$this->countShips] = $shipCoordinates;
		}
	}

	/**
	* Check ship for Overlaping
	*
	* @param array $shipsOnGtidCoordinates
	* @param array $currentShipPosition
	*
	* @return bool true|false
	*/
	protected function isShipOverlap($shipsOnGtidCoordinates, $currentShipPosition)
	{
		$isOverlap = false;

		if(!empty($shipsOnGtidCoordinates))
		{
			foreach ($shipsOnGtidCoordinates as $key => $shipCoordinate) 
			{
				if(!empty(array_intersect($currentShipPosition, $shipCoordinate)))
				{
					$isOverlap = true;
				}
			}
		}
		
		return $isOverlap;
	}

	/**
	* Put all ships to game grid
	*
	* @param array $grid
	* @param array $shipsCoordinates
	*/
	private function putShipsIntoGrid($grid, $shipsCoordinates)
	{
		$matrix = $grid;
		foreach ($shipsCoordinates as $key => $ship) {
			foreach ($ship as $key => $shipCoordinates) {
				$explodedShipCoordinates = explode(';', $shipCoordinates);
				$this->matrix[$explodedShipCoordinates[0]][$explodedShipCoordinates[1]] = "X";
			}
		}
	}

	/**
	* Show ships on game grid
	*
	* @param array $shipsCoordinates
	*
	* @return array Game grid without dot, only with ships
	*/
	public function showShipsOnGrid($shipsCoordinates)
	{
		$gridWithShips = [];
		for ($row=0; $row < $this->row; $row++) { 
			for ($col=0; $col < $this->col; $col++) { 
				$gridWithShips[$row][$col] = " ";
			}
		}

		foreach ($shipsCoordinates as $key => $ship) {
			foreach ($ship as $key => $shipCoordinates) {
				$explodedShipCoordinates = explode(';', $shipCoordinates);
				$gridWithShips[$explodedShipCoordinates[0]][$explodedShipCoordinates[1]] = "X";
			}
		}

		return $gridWithShips;
	}

	/**
	* Get coordinates of ships in game grid
	*
	* @return array
	*/
	public function getShipsOnGridCoordinates()
	{
		return $this->ships;
	}

	public function restartGrid()
	{
		session_destroy();
	}

	/**
	* Seter for final game message
	* 
	* @return void
	*/
	public function setFinalMessage($finalMessage)
	{
		$this->finalMessage = $finalMessage;
	}

	/**
	* Get final message
	*
	* @return string
	*/
	public function getFinalMessage()
	{
		return $this->finalMessage;
	}
	
	/**
	*	Transalte input to coordinate for shot
	* @param array $input
	*
	* @return array Return translated input to coordinate
	*/
	private function translateInputToCoordinates($input)
	{
		// Conver first segment of input to int
		$row = (ord(strtoupper(substr($input, 0, 1))) - 64) - 1;

		// Cut second segment of input
		$col = (substr($input, 1) * 1) - 1;
		
		return [$row, $col];
	}
	/**
	* Shot ship on game grid
	*
	* @param array $shotCoordinates
	*
	* @return string Return message for hit, miss ot sunked ship
	*/
	public function shot($inputShotCoordinates)
	{
		// Increment shot count
		$this->countShots++;

		//Cehck is first shot is stored
		if(!isset($_SESSION['countShots']))
		{
			// Set session with first shot
			$_SESSION['countShots'] = 1;
		}
		else{
			// Increment Session with shots
			$_SESSION['countShots']++;
		}

		// Declare empty variable for message
		$message = "";

		//Translate user input to shot coordinates
		$shotCoordinates = $this->translateInputToCoordinates($inputShotCoordinates);

		// Declare shot row coordinate
		$shotRow = $shotCoordinates[0];

		// Declare shot column coordinate
		$shotCol = $shotCoordinates[1];

		//Merge coordinate in string
		$shotCoordinates = $shotCoordinates[0].";".$shotCoordinates[1];

		//Count non sunked ships
		$shipCountRow = count(array_filter($_SESSION["shipCoordinates"]));

		foreach ($_SESSION["shipCoordinates"] as $key => $ship) 
		{
			// Check is shot hit ship
			$isHitShip = in_array($shotCoordinates, $ship);
			if($isHitShip)// Is ship is hitted
			{
				// Remove coordinate from ship
				unset($_SESSION["shipCoordinates"][$key][array_search($shotCoordinates, $ship)]);

				// Set grid session without hitted coordiante 
				$_SESSION['gridWithShips'] = $this->showShipsOnGrid($_SESSION['shipCoordinates']);

				// Set shot as successfully to game grid
				$_SESSION['grid'][$shotRow][$shotCol] = "X";

				if(count($ship) == 1) // Count current nonshoted ship coordinates
				{
					// Set message for sunked ship
					$message = "Sunk";

					if ($shipCountRow == 1) { // Cehck ship count, to check game status

						// Set Final Message
						$finalMessage = "Well done! You completed the game in " . $_SESSION['countShots'] . " shots";
						$this->setFinalMessage($finalMessage);
					}
				}
				else{ // If current shot hit ship

					// Set message for successfully hited ship
					$message = "Hit";
				}
				
				// Stop executing script
				break;
			}
			else // Set message for unsuccessful shot
			{
				// Set message
				$message = "Miss";
				
				// Set sign on game grid for unsuccessful shot
				$_SESSION['grid'][$shotRow][$shotCol] = "-";
			}
		}

		return $message;
	}

}