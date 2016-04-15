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
<p id="keycode"><p>
<script>
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");

var ballX = canvas.width/2;
var ballY = canvas.height-30;
var dx = 5;
var ballRadius = 10;
var dy = -5;
var dr = .5;

var badBallX = 20;
var badBallY = 20;
var baddx = 5;
var badBallRadius = 10;
var baddy = 7;
var baddr = .5;

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

var boxBorder = (2 * ballRadius + dr + 10);

var score = 0;

var running = true;

function drawBall() {
    ctx.beginPath();
    ctx.arc(ballX, ballY, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}
function drawBadBall() {
    ctx.beginPath();
    ctx.arc(badBallX, badBallY, badBallRadius, 0, Math.PI*2);
    ctx.fillStyle = "red";
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
/*
function checkEdge(){
	if (ballX - ballRadius < 0  || ballX + ballRadius >canvas.width){
		dx = -dx;
	}
	if (ballY - ballRadius < 0  || ballY + ballRadius >canvas.height){
		dy = -dy;
	}
	if(ballY + dy < barY + ballRadius && ballY > barY - ballRadius){
		if(ballX < barX + ballRadius + 40  && ballX > barX - ballRadius){
		dy = -dy;
		}
	}
}
*/
function checkPaddle(){
}

function movement(){
//bad ball
    if(badBallX + baddx > canvas.width-badBallRadius || badBallX + baddx < badBallRadius) {
        baddx = -baddx;
    }
    if(badBallY + baddy > canvas.height-badBallRadius || badBallY + baddy < badBallRadius) {
        baddy = -baddy;
    }
//ball
    if(ballX + dx > canvas.width-ballRadius || ballX + dx < ballRadius) {
        dx = -dx;
    }
    if(ballY + dy > canvas.height-ballRadius || ballY + dy < ballRadius) {
        dy = -dy;
    }
    
//box
    if(rightPressed && barX < canvas.width - barWidth - boxBorder ) {
        barX += bardx;
    }
    if(leftPressed && barX > boxBorder) {
        barX -= bardx;
    } 
    if(downPressed && barY < canvas.height - barHeight - boxBorder) {
        barY += bardy;
    }
    if(upPressed && barY > boxBorder) {
        barY -= bardy;
    } 
    if(badBallY +baddy > barY -badBallRadius && badBallY +baddy < barY + barHeight +badBallRadius){
	if(badBallX + baddx < barX + badBallRadius + barWidth  && badBallX + baddx  > barX - badBallRadius && running){
		window.alert("DOH!!! You lose... Your score was: " + score);
		running = false;
		document.location.reload();
	}
    }
//ball off box
	//ball targeting box
    if(ballY +dy > barY -ballRadius && ballY +dy < barY + barHeight +ballRadius){
	if(ballX + dx < barX + ballRadius + barWidth  && ballX + dx  > barX - ballRadius){
	score++;
	//inside vertical beam
	if(ballX < barX + barWidth + beamPadding && ballX > barX - beamPadding){
	    dy = -dy;
	}else 
	//inside horizontal beam
	if(ballY > barY - beamPadding && ballY < barY + barHeight + beamPadding){
	    dx = -dx;
	//hitting but in neither
	}else{
	    dx = -dx;
	    dy = -dy;
	}
	}

    }
    
    badBallX += baddx;
    badBallY += baddy;

    ballX += dx;
    ballY += dy;
}
function drawScore() {
    ctx.font = "16px Arial";
    ctx.fillStyle = "#0095DD";
    ctx.fillText("Score: "+score, 8, 20);
}
		
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBall();
	drawBadBall();
	drawBar();
	drawScore();
//flux();
	movement();
}

setInterval(draw, 20);


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
