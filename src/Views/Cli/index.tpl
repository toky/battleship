<?php
echo $shotMessage;
echo PHP_EOL;
for ($i=0; $i <= $gridRowCount; $i++) { 
	if($i > 0)
	{
		echo $i . "\040\040";
	}
	else{
		echo "\040\040";
	}
}
echo PHP_EOL;
for($row=0; $row < $gridRowCount; $row++)
{
	echo chr($row+65) . "\040";
	for($col=0; $col < $gridColCount; $col++)
	{
		echo "{$grid[$row][$col]} \040";
		//echo $grid[$row][$col];
	}
	echo PHP_EOL;
}

if(!empty($finalMessage))
{

	echo $finalMessage;
}

