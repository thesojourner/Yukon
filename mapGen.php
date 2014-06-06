<?php
Global $mapFile;
Global $mapSize;

$mapFile = "map.json";
$mapSize = 4;

$dirs = array(
    0 => array("x" =>  1, "y" =>  0), //right
    1 => array("x" =>  0, "y" =>  1), //down
    2 => array("x" => -1, "y" =>  0), //left
    3 => array("x" =>  0, "y" => -1)  //up
);

//initialize map array
$map = array();
for ($x=0; $x < $mapSize; $x++) {
    for ($y=0; $y < $mapSize; $y++) {
        $map[$x][$y] = 0;
    }
}

//initialize variables for adding land, start in middle of map
$xTest = floor($mapSize/2);
$yTest = floor($mapSize/2);

//change starting cell to land
$map[$xTest][$yTest] = 1;

//initialze array of placed land and index of location in array
$land = array();
$index = 0;

//initialize direction variable
$dir;

//set number of cells left to fill with land
$toFill = floor($mapSize * .4);
while ($toFill > 0) {
    //choose random direction
    $dir = $dirs[rand(0,3)];
    //move to chosen cell
    $xTest += $dir["x"];
    $yTest += $dir["y"];
    //test that cell is within map array
    if (inBounds($xTest, $yTest)) {
        //change cell to land, add to land array, decrement $toFill
        $map[$xTest][$yTest] = 1;
        $land[] = array("x" => $xTest, "y" => $yTest);
        $toFill--;
    }

    //start next from next land cell in next loop
    $index++;
    if ($index >= count($land)) {
        //or return to begin if end of land array has been reached
        $index = 0;
    }

    //set xTest and yTest to next cell in land
    $xTest = $land[$index]["x"];
    $yTest = $land[$index]["y"];
}

for ($y=0; $y < $mapSize; $y++) {
    for ($x=0; $x < $mapSize; $x++) {
        print($map[$x][$y] . " ");
    }
    print("<BR>");
}

function inBounds($x, $y) {
    if ($x >= 0 && $x < $mapSize && $y >= 0 && $y < $mapSize) {
        return true;
    } else {
        return false;
    }
}

?>
