<?php
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<META charset="UTF-8" />
<SCRIPT src=jquery-2.1.1.min.js></SCRIPT>
<SCRIPT>
//tiles object, contains tileset images and properties
var tiles = {
    w: 50,
    h: 50,
    paint: 1 //set default value (blue square)
};
tiles.img = new Image();
tiles.img.src = "img/tiles.png";

//map object contains map info and cells array
var map = {
    size: 20
};
map.cells = new Array(map.size); //1D array
for (var i = 0; i < map.size; i++) {
    map.cells[i] = new Array(map.size); //2D array (x,y) = [x][y]
}
for (var y = 0; y < map.size; y++) {
    for (var x = 0; x < map.size; x++) {
        map.cells[x][y] = 0; //give each cell the default value
    }
}

//game entities (terrain, armies, etc) - currently just tile coords
var entities = new Array();
entities.push({x: 0, y: 0}); //green square
entities.push({x: 1, y: 0}); //blue square
entities.push({x: 0, y: 1}); //brown square
entities.push({x: 1, y: 1}); //black square

//function to encode map as json and post to server (must be in global scope)
function saveMap() {
	//convert map to json
	var mapJson = JSON.stringify(map.cells);

	//create a form to post json
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", "mapSave.php");

	//add json as a form input
	var	input = document.createElement("input");
	input.setAttribute("type", "hidden");
	input.setAttribute("name", "map");
	input.setAttribute("value", mapJson);
	form.appendChild(input);

	//attach form to document, submit form, remove form
	document.body.appendChild(form);
	form.submit();
	document.body.removeChild(form);
}

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

	//loop through each cell and draw the correct tile
    map.draw = function() {
        for (var y = 0; y < this.size; y++) {
            for (var x = 0; x < this.size; x++) {
                entID = this.cells[x][y];
                xTile = entities[entID].x;
                yTile = entities[entID].y;
                tiles.draw(xTile, yTile, x, y);
            }
        }
    }

    //draw map
    map.draw();

	//call keydown() whenever a key is pressed
    document.addEventListener("keydown", keydown, false);

	//if the key pressed was 0, 1, 2 or 3, change tiles.paint
    function keydown(event) {
		var key = event.keyCode;
		switch (key) {
			case 48: //keycode for 0
				tiles.paint = 0;
				break;
			case 49: //keycode for 1
				tiles.paint = 1;
				break;
			case 50: //keycode for 2
				tiles.paint = 2;
				break;
			case 51: //keycode for 3
				tiles.paint = 3;
				break;
		}
	}

    // click function (requires draw functions)
    canvas.onclick = function(e) {
        // find pixel location of click relative to canvas
        var rect = canvas.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        // convert pixel location to tile location
        x = Math.floor(x/tiles.w);
        y = Math.floor(y/tiles.h);
        // change value of cell and redraw
        map.cells[x][y] = tiles.paint;
        map.draw();
    };
});
</SCRIPT>
</HEAD>

<BODY>
    <CANVAS id="canvas"></CANVAS>
    <DIV><BUTTON id="save" onClick="saveMap()">Save</BUTTON></DIV>
</BODY>
</HTML>
