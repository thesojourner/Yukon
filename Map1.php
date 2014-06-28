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
    
    $attackArray = json_decode($attackJson);
    $defendArray = json_decode($defendJson);    
    
    $attackX = $attackArray[0];
    $attackY = $attackArray[1];
    
    $defendX = $defendArray[0];
    $defendY = $defendArray[1];
    //Get attack & defend values out of arrays
    
    $attackPlayer = $map[$attackX][$attackY];
    $attackTroops = $troops[$attackX][$attackY];
    
    $defendPlayer = $map[$defendX][$defendY];
    $defendTroops = $troops[$defendX][$defendY];
    
    //Combat calculations
    if($attackTroops < $defendTroops){
        $attackTroops--;
        $defendTroops = $defendTroops-$attackTroops;
        $attackTroops = 1;
        
        $troops[$defendX][$defendY] = $defendTroops;
        $troops[$attackX][$attackY] = $attackTroops;
        
    }elseif($attackTroops > $defendTroops){
        $attackTroops--;
        $attackTroops = $attackTroops-$defend;
        
        $map[$defendX][$defendY] = $attackPlayer;
        $troops[$defendX][$defendY] = $attackTroops;
        $troops[$attackX][$attackY] = 1;
    }else{
        
        $troops[$defendX][$defendY] = 1;
        $troops[$attackX][$attackY] = 1;
    }
    
    
    
    
    $mapJson = json_encode($map);
    file_put_contents("Games/Game1/map.json",$map);
    
    $troopsJson = json_encode($troops);
    file_put_contents("Games/Game1/troops.json",$troops);
    
}

?>
<SCRIPT>
//tiles object, contains tileset images and properties
var tiles = {
w: 50,
h: 50,
};
tiles.img = new Image();
tiles.img.src = "tiles.png";

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
ctx.fillText(text, xDraw * this.w, yDraw * this.h);
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

var input = document.createElement("input");
input.setAttribute("type", "hidden");
input.setAttribute("name", "attack");
input.setAttribute("value", aJson);
form.appendChild(input);

var input = document.createElement("input");
input.setAttribute("type", "hidden");
input.setAttribute("name", "attack");
input.setAttribute("value", dJson);
form.appendChild(input);

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
<DIV><BUTTON id="save" onClick="saveMap()">Save</BUTTON></DIV>
</BODY>
</HTML>
