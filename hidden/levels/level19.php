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
	<button  onclick="setInterval(update,300);">start</button>
<p id="keycode"><p>
<script>
var canvas = document.getElementById("myCanvas");
var message = document.getElementById("keycode");
var ctx = canvas.getContext("2d");

var barHeight = 50;
var barWidth = 50;
var barX = canvas.width/2;
var barY = canvas.height/2;
var bardx = 4;
var bardy = 4;
var beamPadding =4;

var upPressed = false;
var downPressed = false;
var leftPressed = false;
var rightPressed = false;

//var boxBorder = (2 * ballRadius + dr + 10);

var score = 0;

var running = true;

var ball8 = new Ball(30, 100, 10, 15, 2.5);
var ball7 = new Ball(60, 100, 10, 5, 4);
var ball1 = new Ball(100, 109, 10, 0, 2.5);
var ball2 = new Ball(300, 100, 10, -180, 2.5);
var ball3 = new Ball(300, 200, 10, -22, 2.5);
var ball9 = new Ball(50, 200, 10, -98, 4);
var ball10 = new Ball(90, 200, 10, -350, 2.5, "blue");
var ball4 = new Ball(30, 50, 10, -45, 4, "green");
var ball5 = new Ball(100, 100, 10, 56, 2.5);
var ball11 = new Ball(100, 160, 10, 35, 2.5);
var ball6 = new Ball(70, 150, 10, 15, 2.5, "red");
var balls = [ball1, ball2, ball3, ball4, ball5, ball6, ball7, ball8, ball9, ball10, ball11];


function Ball(x, y, radius, angle, speed, color) {
	this.y = y;
	this.x = x;
	this.radius = radius;
	this.color = color || "#0095DD";
	this.speed = speed;
	this.angle = angle;
	this.radians = angle * (Math.PI / 180);
	this.dx = (speed * Math.cos(this.radians));
	//canvas coordinates increase as you go towards the bottom right **fixed**
	this.dy = (speed * Math.sin(this.radians));
	};


Ball.prototype.angleToDxDy = function () {
	this.angle = this.angle % 360;
	this.radians = this.angle * (Math.PI / 180);
	this.dx = (this.speed * Math.cos(this.radians));
//canvas x and y increase as you go towards the bottom right **fixed**
	this.dy = (this.speed * Math.sin(this.radians));
}
	
Ball.prototype.draw = function () {
    ctx.beginPath();
//**fixed**
//canvas is upper left 0 indexed and bottom right high indexed
//simply preference to recalculate the why to a bottom left o index with upper right high indexed
    ctx.arc(this.x, (canvas.height - this.y), this.radius, 0, Math.PI*2);
    ctx.fillStyle = this.color;
    ctx.fill();
    ctx.closePath();
}
Ball.prototype.wallBounce = function() {
    if(this.x + this.dx > canvas.width-this.radius || this.x + this.dx < this.radius) {
        this.angle = 180 - this.angle;
    }
    if(this.y + this.dy > canvas.height-this.radius || this.y + this.dy < this.radius) {
        this.angle *= -1;
    }
}
	
Ball.prototype.movement = function () {
    this.x += this.dx;
    this.y += this.dy;
}
Ball.prototype.update = function() {
	this.angleToDxDy();
	this.wallBounce();
	this.angleToDxDy();
	this.movement();
	this.draw();
}
function ballCollision() {
for(var i = 0; i<balls.length ;i++){
	for(var j = i+1;j<balls.length;j++){
	var futureYCurrent = balls[i].y + balls[i].dy;
	var futureXCurrent = balls[i].x + balls[i].dx;
	var futureYNext = balls[j].y + balls[j].dy;
	var futureXNext = balls[j].x + balls[j].dx;
//canvas x and y increase as you go towards the bottom right **fixed**
	var yDifference = futureYNext - futureYCurrent;
	var xDifference = futureXNext - futureXCurrent;
	var distance = Math.sqrt(Math.pow((futureYCurrent-futureYNext), 2)+Math.pow((futureXCurrent-futureXNext), 2))
	//within range
    if(distance < balls[j].radius + balls[i].radius ){
	var radiansToNext = Math.atan2(yDifference, xDifference) ;
	var angleToNext = (radiansToNext * (180/Math.PI));
	var xOfCollision = balls[i].x + balls[i].radius * Math.cos(radiansToNext);
	var yOfCollision = balls[i].y + balls[i].radius * Math.sin(radiansToNext);
	    balls[i].angle = angleToNext + 180;
	    balls[j].angle = angleToNext;
    ctx.beginPath();
    ctx.arc(xOfCollision, (canvas.height - yOfCollision), 4, 0, Math.PI*2);
    ctx.fillStyle = "yellow";
    ctx.fill();
    ctx.closePath();
	}

    }
}
}

function update(){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	ballCollision();
	for(var i =0; i<balls.length; i++){
		balls[i].update();
	}
}


function drawBar() {
    ctx.beginPath();
    ctx.rect(barX, barY, barWidth, barHeight);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
}

function flux(){
	if(ballRadius>15){
		dr = -dr;
	}
	if(ballRadius< 2){
		dr = -dr;
	}
	ballRadius += dr;
}
function checkPaddle(){
}

function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: "+score, 8, 20);
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
