<?php
echo $shotMessage;
echo '<pre>';
for ($i=0; $i <= $gridRowCount; $i++) { 
	if($i > 0)
	{
		//echo $i . "\040\040";
		echo $i . "\t";
	}
	else{
		echo "\t";
	}
}

echo PHP_EOL;
for($row=0; $row < $gridRowCount; $row++)
{
	echo chr($row+65) . "\t";
	for($col=0; $col < $gridColCount; $col++)
	{

		echo "{$grid[$row][$col]} \t";
	}
	echo PHP_EOL;
}
echo '</pre>';
?>
<?php 
if(empty($finalMessage))
{
?>
	<form name="input" action="index.php" method="post">
	Enter coordinates (row, col), e.g. A5 <input type="input" size="5" name="coord" autocomplete="off" autofocus>
	<input type="submit">
	<br />
<?php
}
else
{
	echo $finalMessage;
}
