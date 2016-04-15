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
	<button  onclick="setInterval(update,20);">start</button>
<p id="keycode"><p>
<script>
	

var canvas = document.getElementById("myCanvas");
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

var ball8 = new Ball(30, 100, 10, 5, 5);
var ball7 = new Ball(50, 100, 10, 5, 5);
var ball1 = new Ball(90, 100, 10, 5, 5);
var ball2 = new Ball(30, 150, 10, 5, -5);
var ball3 = new Ball(30, 200, 10, -5, 5);
var ball9 = new Ball(50, 200, 10, -5, 5);
var ball10 = new Ball(90, 200, 10, -5, 5);
var ball4 = new Ball(30, 50, 10, -5, -5);
var ball5 = new Ball(100, 100, 10, -5, 5);
var ball11 = new Ball(100, 160, 10, -5, 5);
var ball6 = new Ball(70, 150, 10, 5, 5);
var balls = [ball1, ball2, ball3, ball4, ball5, ball6, ball7, ball8, ball9, ball10, ball11];

function Ball(x, y, radius, dx, dy) {
	this.y = y;
	this.x = x;
	this.radius = radius;
	this.dx = dx;
	this.dy = dy;
	};
Ball.prototype.draw = function () {
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
Ball.prototype.movement = function () {
    if(this.x + this.dx > canvas.width-this.radius || this.x + this.dx < this.radius) {
        this.dx = -this.dx;
    }
    if(this.y + this.dy > canvas.height-this.radius || this.y + this.dy < this.radius) {
        this.dy = -this.dy;
    }
    this.x += this.dx;
    this.y += this.dy;
}
Ball.prototype.update = function() {
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
	var distance = Math.sqrt(Math.pow((futureYCurrent-futureYNext), 2)+Math.pow((futureXCurrent-futureXNext), 2))
	//within range
    if(distance < balls[j].radius + balls[i].radius ){
	//center inside vertical beam
	if(Math.abs(futureXCurrent-futureXNext) < (balls[i].radius + balls[j].radius)/2){
	    balls[i].dy *= -1 ;
	    balls[j].dy *= -1 ;
	}else 
	//inside horizontal beam
	if(Math.abs(futureYCurrent-futureYNext) < (balls[i].radius + balls[j].radius)/2){
	    balls[i].dx *= -1 ;
	    balls[j].dx *= -1 ;
	//hitting but in neither
	}else{
	    balls[i].dx *= -1 ;
	    balls[j].dx *= -1 ;
	    balls[i].dy *= -1 ;
	    balls[j].dy *= -1 ;
	}

	}

    }
}
}

function update(){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	for(var i =0; i<balls.length; i++){
		balls[i].update();
	}
	ballCollision();
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
