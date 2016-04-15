<?php include('session.php'); ?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gamedev Canvas Workshop</title>
    <style>
    	* { padding: 0; margin: 0; }
    	canvas { background: #eee; display: block; margin: 0 auto; }
    </style>
</head>
<body>

<canvas id="myCanvas" width="680" height="320"></canvas>
	<button  onclick="setInterval(update,10);">start</button>
<p id="keycode"><p>
<script>
var canvas = document.getElementById("myCanvas");
var message = document.getElementById("keycode");
var ctx = canvas.getContext("2d");

var upPressed = false;
var downPressed = false;
var leftPressed = false;
var rightPressed = false;

var viewMaxX =  canvas.width;
var viewMaxY =  canvas.height; 
var viewMinX = 0;
var viewMinY =  0;

var boxX = 100;
var boxY = 50;
var boxWidth = 40;
var boxHeight = 40;


function Player(x, y, width, height, speed) {
        this.x = x;
        this.y = y;
	this.speed = speed;
        this.width = width;
        this.height = height;
        };
var player = new Player(200, 200, 20, 20, 1.5);

Player.prototype.draw = function () {
    ctx.beginPath();
    ctx.rect(((viewMaxX+viewMinX)/2) - viewMinX - (this.width/2), ((viewMaxY+viewMinY)/2) - viewMinY - (this.height/2), this.width, this.height);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
}
Player.prototype.setXY = function () {
        this.x = ((viewMaxX+viewMinX)/2) - viewMinX - (this.width/2);
        this.y = ((viewMaxY+viewMinY)/2) - viewMinY - (this.height/2);
}


function update(){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	drawBox();
	player.setXY();
	player.draw();
	viewUpdate();
message.innerHTML = "minx: " + viewMinX + "miny: " + viewMinY;
}

function viewUpdate(){
	if(rightPressed){
		viewMaxX += player.speed;
		viewMinX += player.speed;
	}
	if(upPressed){
		viewMaxY -= player.speed;
		viewMinY -= player.speed;
	}
	if(leftPressed){
		viewMaxX -= player.speed;
		viewMinX -= player.speed;
	}
	if(downPressed){
		viewMaxY += player.speed;
		viewMinY += player.speed;
	}
}

function drawBox() {
	if(boxX < viewMaxX && boxX > viewMinX && boxY < viewMaxY && boxY > viewMinY){
    ctx.beginPath();
    ctx.rect(boxX-viewMinX, boxY-viewMinY, boxWidth, boxHeight);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
	}
}
function drawPlayer() {
}
	

document.addEventListener("keydown", keydown, false);
document.addEventListener("keyup", keyup, false);
function keydown(e) {
	if(e.keyCode == 39){
		rightPressed = true;	
	}
	if(e.keyCode == 37){
		leftPressed = true;
	}
	if(e.keyCode == 38){
		upPressed = true;	
	}
	if(e.keyCode == 40){
		downPressed = true;
	}
	if(e.keyCode == 82){
		window.alert("restarting");
		document.location.reload();
	}
}
function keyup(e) {
	if(e.keyCode == 39){
		rightPressed = false;	
	}
	if(e.keyCode == 37){
		leftPressed = false;
	}
	if(e.keyCode == 38){
		upPressed = false;	
	}
	if(e.keyCode == 40){
		downPressed = false;
	}
}
</script>

</body>
</html>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
