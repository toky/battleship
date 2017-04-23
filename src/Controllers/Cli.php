<?php
namespace App\Controllers;

class Cli extends Controller
{
	public function index()
	{
		
			while(true)
			{
				echo "Enter coordinates (row, col), e.g. A5: ";
				$input = trim(fgets(STDIN, 1024));
				$gameVariables = \App\Factory\GameFactory::buildGame($input);
				\App\Factory\GameFactory::showGame($gameVariables[1], GridRow, GridCol, $gameVariables[0], $gameVariables[2]);
				
				if($gameVariables[2])
				{
					return false;
				}
			}

		
	}
}