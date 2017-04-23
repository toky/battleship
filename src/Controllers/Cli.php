<?php
namespace App\Controllers;

class Cli extends Controller
{
	public function index()
	{
		try {

			while(true)
			{
				echo "Enter coordinates (row, col), e.g. A5: ";
				$input = trim(fgets(STDIN, 1024));
				$gameVariables = \App\Factory\GameFactory::buildGame($input);
				\App\Factory\GameFactory::showGame("Cli", $gameVariables[1], GridRow, GridCol, $gameVariables[0], $gameVariables[2]);
				
				if($gameVariables[2])
				{
					return false;
				}
			}

		} catch (Exceptions $e) {
			echo "Application error:" . $e->getMessage();
		}
	}
}