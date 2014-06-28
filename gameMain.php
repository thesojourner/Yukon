<?php

?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<META charset="UTF-8" />
<SCRIPT src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></SCRIPT>
<?

$mapJson = file_get_contents("Games/Game1/map.json");
$troopsJson = file_get_contents("Games/Game1/troops.json");

$map = json_decode($mapJson);
$troops = json_decode($troopsJson);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attackJson = $_POST["attack"];
    $defendJson = $_POST["defend"];
    //echo "<P>$attackJson</P>";
    //echo "<P>$defendJson</P>";
    
    $attackArray = json_decode($attackJson);
    $defendArray = json_decode($defendJson);

    //retrieve coordinates for attacker and defender
    $attackX = $attackArray[0];
    $attackY = $attackArray[1];
    
    $defendX = $defendArray[0];
    $defendY = $defendArray[1];

    $mapX = end(array_values($map));
    foreach($map as $x){
	    $lastY = end(array_values($x));
	    if($lastY > $mapY){
		    $mapY = $lastY;
	    }
    }

    $error = false;
    

    //validate x and y < mapsize
    if($attackX > $mapX || $defendX > $mapX || $attackX < 0 || $defendX < 0 && $error == false){
        ?>
	<SCRIPT>
		alert("You must select a tile on the map!");
	</SCRIPT>
	<?
	$error = true;
    }
    //validate adjacent tiles
    if(abs($attackX-$defendX) > 1 && $error == false){
	?>
	<SCRIPT>
		alert("You must attack an adjacent tile (diagonals count!)");
	</SCRIPT>
	<?
	$error = true;
    }

    if(abs($attackY-$defendY) > 1 && $error == false){
	?>
	<SCRIPT>
		alert("You must attack an adjacent tile(diagonals count)!");
	</SCRIPT>
	<?
	$error = true;
    }

    //get owner and troop count for combatants
    $attackPlayer = $map[$attackX][$attackY];
    $attackTroops = $troops[$attackX][$attackY];
    //echo "<p>A: $attackPlayer, $attackTroops</P>";
    
    $defendPlayer = $map[$defendX][$defendY];
    $defendTroops = $troops[$defendX][$defendY];
    //echo "<p>D: $defendPlayer, $defendTroops</P>";

    //validate enemy
    if($attackPlayer == $defendPlayer && $error == false){
	?>
	<SCRIPT>
		alert("You must attack an enemy tile!");
	</SCRIPT>
	<?
	$error = true;
    }

    //attacker must have > 1 troop
    if($attackTroops == 1 && $error == false){
	?>
	<SCRIPT>
		alert("You must have more than 1 troop to attack!");
	</SCRIPT>
	<?
	$error = true;
    }

    if($error == false){

        //Combat calculations
        if($attackTroops < $defendTroops){
            $attackTroops--;
            $defendTroops = $defendTroops-$attackTroops;
            $attackTroops = 1;
        
            $troops[$defendX][$defendY] = $defendTroops;
            $troops[$attackX][$attackY] = $attackTroops;
        
        }elseif($attackTroops > $defendTroops){
            $attackTroops--;
	    $attackTroops = $attackTroops-$defendTroops;
	    //quick fix for attacker having only 1 more troop than defender
	    if($attackTroops == 0){
		$attackTroops = 1;
	    }
            $map[$defendX][$defendY] = $attackPlayer;
            $troops[$defendX][$defendY] = $attackTroops;
            $troops[$attackX][$attackY] = 1;
        }else{
        
            $troops[$defendX][$defendY] = 1;
            $troops[$attackX][$attackY] = 1;
        }
    
        $mapJson = json_encode($map);
        file_put_contents("Games/Game1/map.json", $mapJson);
    
        $troopsJson = json_encode($troops);
        file_put_contents("Games/Game1/troops.json", $troopsJson);
    }    
}

?>

<SCRIPT>
//tiles object, contains tileset images and properties
var tiles = {
w: 50,
h: 50,
};
tiles.img = new Image();
tiles.img.src = "img/tiles.png";

//map object contains map info and cells array
var map = {
size: 10
};
map.cells = <?echo $mapJson?>;
map.troops = <?echo $troopsJson?>;

//game entities (terrain, armies, etc) - currently just tile coords
var entities = new Array();
entities.push({x: 0, y: 0}); //green square
entities.push({x: 1, y: 0}); //blue square
entities.push({x: 0, y: 1}); //brown square
entities.push({x: 1, y: 1}); //black square

//initialize canvas variables into the global scope
var canvas;
var ctx;

$(document).ready(function() { //wait until the document is done loading, otherwise canvas might not exist yet
canvas = document.getElementById("canvas"); //store the canvas element in a variable for easy access
//set size here rather than in html, automatically updates if configs change
canvas.width = tiles.w * map.size;
canvas.height = tiles.h * map.size;

ctx = canvas.getContext("2d"); //drawing takes place on the canvas context, not the element, and we want a 2d context

//draw functions cannot be defined before ctx is available
//tiles.draw takes in coords, not pixel locations, i.e. send in 2, 0 to draw in the third cell on the top row
tiles.draw = function(xTile, yTile, xDraw, yDraw) {
//drawImage() takes 9 data points: 1)source image, 2-5)coords and size from that image, 6-9)coords and size to draw on the context
ctx.drawImage(this.img, xTile * this.w, yTile * this.h, this.w, this.h, xDraw * this.w, yDraw * this.h, this.w, this.h);
};

tiles.text = function(text, xDraw, yDraw) {
ctx.fillText(text, (xDraw + .5) * this.w, (yDraw + .5) * this.h);
};

//loop through each cell and draw the correct tile
map.draw = function() {
for (var y = 0; y < this.size; y++) {
for (var x = 0; x < this.size; x++) {
var entID = this.cells[x][y];
var troopNum = this.troops[x][y];
var xTile = entities[entID].x;
var yTile = entities[entID].y;
tiles.draw(xTile, yTile, x, y);
tiles.text(troopNum, x, y);
}
}
}

//draw map
map.draw();

var attack;
var defend;

// click function (requires draw functions)
canvas.onclick = function(e) {
// find pixel location of click relative to canvas
var rect = canvas.getBoundingClientRect();
var x = e.clientX - rect.left;
var y = e.clientY - rect.top;
// convert pixel location to tile location
x = Math.floor(x/tiles.w);
y = Math.floor(y/tiles.h);
if(attack == undefined) {
attack = [x, y];
} else {
defend = [x, y];

var aJson = JSON.stringify(attack);
var dJson = JSON.stringify(defend);

var form = document.createElement("form");
form.setAttribute("method", "post");
form.setAttribute("action", "<?echo $_SERVER['PHP_SELF']?>");

var aInput = document.createElement("input");
aInput.setAttribute("type", "hidden");
aInput.setAttribute("name", "attack");
aInput.setAttribute("value", aJson);
form.appendChild(aInput);

var dInput = document.createElement("input");
dInput.setAttribute("type", "hidden");
dInput.setAttribute("name", "defend");
dInput.setAttribute("value", dJson);
form.appendChild(dInput);

document.body.appendChild(form);
form.submit();
document.body.removeChild(form);
}
};
});
</SCRIPT>
</HEAD>

<BODY>
<CANVAS id="canvas"></CANVAS>
</BODY>
</HTML>
