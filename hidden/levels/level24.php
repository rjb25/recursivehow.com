<?php include('session.php'); ?>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gamedev Canvas Workshop</title>
    <style>
    	* { padding: 0; margin: 0; }
    	canvas { background: #eee; display: block; margin: 0 auto; cursor:none;}
    </style>
</head>
<body>
<button  onclick="setInterval(update,5);">start</button>

<canvas id="myCanvas" width="680" height="320"></canvas>
<p id="keycode"><p>
<script>
var canvas = document.getElementById("myCanvas");
var message = document.getElementById("keycode");
var ctx = canvas.getContext("2d");

var mouseX = canvas.width/2;
var mouseY = canvas.height/2;

var upPressed = false;
var downPressed = false;
var leftPressed = false;
var rightPressed = false;

var viewMaxX =  canvas.width;
var viewMaxY =  canvas.height; 
var viewMinX = 0;
var viewMinY =  0;




//**************PLAYER CLASS************
function Player(width, height, speed, health) {
        this.width = width;
        this.height = height;
        this.x = ((viewMaxX-viewMinX)/2) - (this.width/2);
        this.y = ((viewMaxY-viewMinY)/2) - (this.height/2);
	this.speed = speed;
	this.health = health;
        };

Player.prototype.draw = function () {
    ctx.beginPath();
    ctx.rect(getCanvasX(this.x), getCanvasY(this.y), this.width, this.height);
    ctx.fillStyle = "blue";
    ctx.fill();
    ctx.closePath();
}
//changes made here
/*
Player.prototype.setXY = function () {
        this.x = ((viewMaxX-viewMinX)/2) - (this.width/2);
        this.y = ((viewMaxY-viewMinY)/2) - (this.height/2);
	message.innerHTML = this.x + "x " + this.y + "y ";
}
*/
var player = new Player(20, 20, 1, 10);
//PLAYER CODE ENDS HERE
//**************Spitter CLASS************
function Spitter(x, y, width, height, health, speed) {
        this.width = width;
        this.height = height;
        this.x = x;
        this.y = y;
	this.speed = speed || 0;
	this.health = health || 15;
	this.reload = 0;
        };

Spitter.prototype.fire = function () {
	projectiles.push(new Projectile("bad", this.x, this.y));
};
Spitter.prototype.draw = function () {
    ctx.beginPath();
    ctx.rect(getCanvasX(this.x), getCanvasY(this.y), this.width, this.height);
    ctx.fillStyle = "black";
    ctx.fill();
    ctx.closePath();
}
//changes made here
/*
Player.prototype.setXY = function () {
        this.x = ((viewMaxX-viewMinX)/2) - (this.width/2);
        this.y = ((viewMaxY-viewMinY)/2) - (this.height/2);
	message.innerHTML = this.x + "x " + this.y + "y ";
}
*/
var spitter = new Spitter(200, 200, 40, 40, 10);
var spitters = [spitter];

//SPITTER CODE ENDS HERE

//********PROJECTILE CLASS***********
function Projectile(){
	this.x = player.x+player.width/2;
	this.y = player.y-player.height/2;
	this.radius = 2.5;
        this.speed = 1.5;
//and here
	this.differenceY = getGameY(mouseY) - this.y ;
	this.differenceX = getGameX(mouseX) - this.x;
        this.angle = (Math.atan2(this.differenceY, this.differenceX))*(180/Math.PI);
        this.radians = this.angle * (Math.PI / 180);
        this.dx = (this.speed * Math.cos(this.radians));
        this.dy = (this.speed * Math.sin(this.radians));
        };

var projectiles = [];
function makeProjectile(){
	projectiles.push(new Projectile());
	//message.innerHTML = projectiles.length;
}
//You could put object arrays in a single two dimensional array.
var firstArray =[15, 2, 3]
var secondArray =[firstArray]
console.log(secondArray[0][0]);
function bounceProjectiles(){
	for (var i = 0; i < projectiles.length; i++){
		projectiles[i].bounce();
	}
}

function drawProjectiles(){
	for(var i=0; i<projectiles.length; i++){
		projectiles[i].draw();
	}
}

Projectile.prototype.draw = function(){
	if(this.x < viewMaxX+this.radius && this.x > viewMinX-this.radius && this.y < viewMaxY + this.radius && this.y > viewMinY - this.radius){
    ctx.beginPath();
    ctx.arc(getCanvasX(this.x), getCanvasY(this.y), this.radius, 0, Math.PI*2);
    ctx.fillStyle = this.color;
    ctx.fill();
    ctx.closePath();
	}
};
//PROJECTILE ENDS HERE
//*****RectangleClass*********
function Rectangle(x, y, width, height, color, health){
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.color = color || "blue";
	this.health = health || 10;
}
Rectangle.prototype.draw = function (){
	if(this.x < viewMaxX && this.x > viewMinX - this.width && this.y < viewMaxY && this.y > viewMinY - this.height){
    ctx.beginPath();
    ctx.rect(getCanvasX(this.x), getCanvasY(this.y), this.width, /*correcting for 0 index*/ -this.height);
    ctx.fillStyle = this.color;
    ctx.fill();
    ctx.closePath();
	}
}
	
var rectangle = new Rectangle(50, 50, 30, 30, "red");
var rectangle2 = new Rectangle(100, 50, 30, 30,"green");
var rectangle3 = new Rectangle(300, 50, 30, 30, "orange");
var rectangle4 = new Rectangle(50, 200, 30, 30, "yellow");
var rectangles = [rectangle, rectangle2, rectangle3, rectangle4];
function drawRectangles(){
	for(var i = 0; i< rectangles.length; i++){
		rectangles[i].draw();
	}
}
function isalive(){
	for(var i = 0; i< rectangles.length; i++){
	if(rectangles[i].health<1){
		rectangles.splice(i, 1);
	}
}
}
//rectangle ends here
//********cursor*********
function drawcursor(){
drawing = new image();
drawing.src = "/images/crossheirs.png"
    ctx.beginpath();
	
    ctx.drawimage(drawing, mousex -10, mousey -10, 20, 20);
    ctx.fillstyle = "blue";
    ctx.fill();
    ctx.closepath();
}
//getgamexy
function mousemovehandler(e) {
    mousex = e.clientx - canvas.getboundingclientrect().left;
    mousey = e.clienty - canvas.getboundingclientrect().top;
}
document.addeventlistener("mousemove", mousemovehandler, false);
///mouse ends here

function move(){
	for(var i=0; i<projectiles.length; i++){
		projectiles[i].x +=projectiles[i].dx;
		projectiles[i].y +=projectiles[i].dy;
	}
}

function update(){
    ctx.clearrect(0, 0, canvas.width, canvas.height);
	//drawrectangles();
	move();
//	player.setxy();
	player.draw();
	viewupdate();
	drawprojectiles();
	drawcursor();
	bounceprojectiles();
	//isalive();
	//drawspitters();
	typesupdate();
}
var types=[rectangles, spitters];

function typesupdate(){
//going through types
	for(var j = 0; j< types.length; j++){
//drawing
	for(var i = 0; i< types[j].length; i++){
	console.log("works");
		types[j][i].draw();
	}
//deleteing if dead
	for(var i = 0; i< types[j].length; i++){
	if(types[j][i].health<1){
		types[j].splice(i, 1);
	}
	}
//bouncing off rectangles
for(var p = 0 ; p < projectiles.length; p++){
	for(var i = 0; i < types[j].length; i++){
    	if(projectiles[p].x + projectiles[p].dx < types[j][i].x + types[j][i].width + projectiles[p].radius && projectiles[p].x + projectiles[p].dx > types[j][i].x - projectiles[p].radius) {
    	if(projectiles[p].y + projectiles[p].dy < types[j][i].y + types[j][i].height+projectiles[p].radius && projectiles[p].y + projectiles[p].dy > types[j][i].y -projectiles[p].radius) {
	types[j][i].health--;
//is above or below currently
    if(projectiles[p].x  < types[j][i].x + types[j][i].width + projectiles[p].radius && projectiles[p].x > types[j][i].x - projectiles[p].radius) {
        projectiles[p].dy *= -1;
	}
//is to the side currently
    if(projectiles[p].y < types[j][i].y + types[j][i].height+projectiles[p].radius && projectiles[p].y  > types[j][i].y -projectiles[p].radius) {
        projectiles[p].dx *= -1;
    }
}
}
}
}
}
}

Projectile.prototype.bounce = function() {
for(var i = 0; i < rectangles.length; i++){
//checking will hit
    if(this.x + this.dx < rectangles[i].x + rectangles[i].width + this.radius && this.x + this.dx > rectangles[i].x - this.radius) {
    if(this.y + this.dy < rectangles[i].y + rectangles[i].height+this.radius && this.y + this.dy > rectangles[i].y -this.radius) {
	rectangles[i].health--;
//is above or below currently
    if(this.x  < rectangles[i].x + rectangles[i].width + this.radius && this.x > rectangles[i].x - this.radius) {
        this.dy *= -1;
	}
//is to the side currently
    if(this.y < rectangles[i].y + rectangles[i].height+this.radius && this.y  > rectangles[i].y -this.radius) {
        this.dx *= -1;
    }
    }
}
}
}


function viewUpdate(){
	if(rightPressed){
		viewMaxX += player.speed;
		viewMinX += player.speed;
		player.x += player.speed;
	}
	if(upPressed){
		viewMaxY += player.speed;
		viewMinY += player.speed;
		player.y += player.speed;
	}
	if(leftPressed){
		viewMaxX -= player.speed;
		viewMinX -= player.speed;
		player.x -= player.speed;
	}
	if(downPressed){
		viewMaxY -= player.speed;
		viewMinY -= player.speed;
		player.y -= player.speed;
	}
}

function getGameX(x){
	 return x + viewMinX;
}
function getGameY(y){
	 return ((canvas.height - y) + viewMinY);
}
function getCanvasX(gameX){
	return gameX-viewMinX;
}
function getCanvasY(gameY, reindex){
onlyReindex = reindex || false;
if(onlyReindex){
	return (canvas.height-gameY);
}else{
	return (canvas.height-(gameY-viewMinY));
}
}
	
document.addEventListener("click", makeProjectile, false);
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
