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

<canvas id="myCanvas" width="480" height="320"></canvas>
<p id="keycode"><p>
<script>
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");

var ballX = canvas.width/2;
var ballY = canvas.height-30;
var speed = Math.pow(dx,2)
var dx = 5;
var ballRadius = 10;
var dy = -5;
var dr = .5;

var barHeight = 5;
var barWidth =40;
var barX = canvas.width/2;
var barY = 3 * canvas.height/4;
var bardx = 5;

function drawBall() {
    ctx.beginPath();
    ctx.arc(ballX, ballY, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
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

function checkEdge(){
	if (ballX - ballRadius < 0  || ballX + ballRadius >canvas.width){
		dx = -dx;
	}
	if (ballY - ballRadius < 0  || ballY + ballRadius >canvas.height){
		dy = -dy;
	}
}
		
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBall();
	drawBar();
flux();
	checkEdge();
    ballX += dx;
    ballY += dy;
}

setInterval(draw, 20);
document.addEventListener("keydown", keydown, false);
document.addEventListener("keyup", keyup, false);
function keydown(e) {
	document.getElementById('keycode').innerHTML = e.keyCode;
}
function keyup(e) {
	document.getElementById('keycode').innerHTML = "";
}
</script>

</body>
</html>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
