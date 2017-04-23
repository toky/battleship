<?php
namespace App\Controllers;
/**
* class Web - representation for game logic for web 
*
*/
class Web extends Controller
{ 
	public function index()
	{
		try {

			if(isset($_POST['coord']) && $_POST['coord'] != "")
			{
				$input = $_POST['coord'];
			}
			else
			{
				$input = "";
			}

			$gameVariables = \App\Factory\GameFactory::buildGame($input);
			
			\App\Factory\GameFactory::showGame("Web", $gameVariables[1], GridRow, GridCol, $gameVariables[0], $gameVariables[2]);

		} catch (Exceptions $e) {
			echo "Application error:" . $e->getMessage();
		}
	}
}