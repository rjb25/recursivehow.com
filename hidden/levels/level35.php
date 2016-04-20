<?php include('session.php'); ?>
<html>


<head>
    <meta charset="utf-8" />
    <title>Gamedev Canvas Workshop</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        
        canvas {
            background: #eee;
            display: block;
            margin: 0 auto;
            cursor: none;
        }
    </style>
</head>

<body>
    <button onclick="setInterval(update,iterationTime);">start</button>

    <canvas id="myCanvas" width="980" height="420"></canvas>
    <p id="keycode">
        <p>
            <script>
//discover the word, make invisible bullet bariers
//*******CURSOR NOT MATCHIGN VIEWPORT
//TODO 
//decide how you want to do different shots (entire new class, or just options?)
//if they differ in methods, they must be different class.maybe?I could just pass the method different things depending on what we want it to do, or nothign at all.
//same data, health speed, x,y different methods, fireOnspace or fireNearPlayer
//diff data though because health and speed are different things
//for a new gun all I need to do is make a different fire method that calls shot constructor with different parameters
//pass it the shooting function to assign?
// make canvas have a range option to move to player, will need an update method
//simply call trackStop on view instance
//make trackSlide remebmer the equation you made
//how to switch methods on an instance in game time, likely this.func replaced for all prototypes that might change
//order of things is off because screen follows player late
//make a new track to method for the view that is smoother, and uses matchMove on player
//make direction change not have the cursor be one state behind
								var iterationTime = 30;
                //canvas
                var canvas = document.getElementById("myCanvas");
          var message = document.getElementById("keycode");
                var ctx = canvas.getContext("2d");
                //mouse
								var mouseDown = false;
                //keyboard
                var upPressed = false;
                var downPressed = false;
                var leftPressed = false;
                var rightPressed = false;
                var spacePressed = false;
//investigating a solution for order errors is a good idea after current problems
//Mouse
var mouse = new Mouse();
								//cursor
								var cursor = new Cursor();
								var cursors = [cursor];
                //player
///player depends on view for its draw function?
//functions are not part of constructor? maybe.
//make a function that assigns a function to an object
                var player = new Player(20, 20, 15, 1500);
                var players = [player];
                //viewport
//I really need to stop this madness...
//view contructor depends on player location for its tracking function
								var view = new View(100);
								var views = [view];
                //rectangles
                var rectangle = new Rectangle(50, 50, 30, 30, "red");
                var rectangle2 = new Rectangle(100, 50, 30, 30, "green");
                var rectangle3 = new Rectangle(300, 50, 30, 30, "orange");
                var rectangle4 = new Rectangle(50, 200, 30, 30, "yellow");
                var rectangles = [rectangle, rectangle2, rectangle3, rectangle4];
//order is important!!!!!! some are defined based on others
//make these the same class, like person, fighter? making classes in javascript is werid. You could have one class and just pass it different things to make entirely different objects with different methods

//basically difference between player and spitter is xy update and team also wouldnt have to look through whole array to find the one to update. or you could make a function that contains the one you found so you no longer search? I am getting so confused with classes

                //spitters
/*
                var spitter = new Spitter(40, 40, 40, 40);
*/
                var spitters = [];
								//maybe make it so that it check if it is an array? avoid this silly stuff
                //playershots
                var circleShots = [];
                //anything that has methods constantly invoked
//movement order matters for viewport versus player
                var instances = [players, cursors, views, rectangles, spitters, circleShots];
								//*******METHODS*********
//death methods
                function healthDie(containingArray) { return function(){
													if(this.health < 1){
															containingArray.splice(containingArray.indexOf(this), 1);
												}
										};
                }
								//CircleShot.prototype.isAlive = function(){distanceDie(this, circleShots);};
                function distanceDie(that){ 
									if(getDistance(that.startX, that.startY, that.x,that.y) > that.range){	
											that.storage.splice(that.storage.indexOf(that), 1);
										}
								}

                function timeDie(that){
									if(that.durationSeconds <0 ){	
											that.storage.splice(that.storage.indexOf(that), 1);
										}else{
											that.durationSeconds -= iterationTime/1000;
										}
                
									}
//fix this shitstorm******
//COLLISION methods
//work on making this better
function willBeOn(that, hitting){
//dangerous
//maybe make variables like futureX futureY
//possible problem with "still" things having a dx and dy so they hit things that move by where they would be if they could move
//in that case though just set something?
if("radius" in that && "radius" in hitting){
//replace with getDistanceFuture
			if(getDistanceFuture(that, hitting) < (that.radius+ hitting.radius)){
return true;
}else{
return false;}
}else 
if("radius" in that && "width" in hitting){
																if (that.x + that.dx < hitting.x + (hitting.dx || 0) + (hitting.width/2) + that.radius  && that.x + that.dx > hitting.x + (hitting.dx || 0) - (hitting.width/2) - that.radius  && that.whose !== hitting && that.y + that.dy < hitting.y + (hitting.dy || 0) + (hitting.height/2) + that.radius  && that.y + that.dy > hitting.y -(hitting.height/2)- that.radius) {

return true;
}else{
return false;}
}else
//TODO make these work if I ever use square ammo
if("width" in that && "radius" in hitting){
				if(getDistance((that.x+that.dx), (that.y+that.dy), hitting.x, hitting.y) < 100){
return true;
}else{
return false;}
}else

//could use this collision for viewport
if("width" in that && "width" in hitting){
				if(Math.abs((that.x+(that.dx || 0)) - (hitting.x+(hitting.dx || 0))) < (hitting.width + that.width)/2 && Math.abs((that.y+(that.dy || 0)) - (hitting.y+(hitting.dy || 0)))  < (that.height + hitting.height)/2){
return true;
}else{
return false;}
}
}

function stopOnSolid(damage) {return function(){
	var hitCount =0;
	for (var j = 0; j < instances.length; j++) {
						if(instances[j].length >0){
//WARNING if you have changing solid state of objects it might not be recognized
														if (instances[j][0].solid == true) {
															for (var i = 0; i < instances[j].length; i++) {
																//checking will hit
																if(this !== instances[j][i]){
																if(willBeOn(this, instances[j][i]) && this.whose !== instances[j][i]){
																	hitCount++;}}}}}}
if(hitCount>0){
		this.still = true;
}
};}
function notifyOnSolid() {return function(){
	for (var j = 0; j < instances.length; j++) {
						if(instances[j].length >0){
//WARNING if you have changing solid state of objects it might not be recognized
														if (instances[j][0].solid == true) {
															for (var i = 0; i < instances[j].length; i++) {
																//checking will hit
																if(this !== instances[j][i]){
																if(willBeOn(this, instances[j][i]) && this.whose !== instances[j][i]){
																	console.log("touching");}}}}}}};
}
//draw methods
                var drawRectangle = function() {

                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
//                    if (this.x < view.maxX && this.x > view.minX - this.width && this.y < view.maxY && this.y > view.minY - this.height) {
                        ctx.beginPath();
//look into why thses are not drawn at a minus width and heigt, be consistent
//123
                        ctx.rect(getCanvasX(this.x)-(this.width/2), getCanvasY(this.y)-(this.height/2), this.width, /*canvas....*/ this.height);
                        ctx.fillStyle = this.color || "purple";
                        ctx.fill();
                        ctx.closePath();
                    }
                }

                var drawSprite = function() {
                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
                    //if (this.x < view.maxX && this.x > view.minX - this.width && this.y < view.maxY && this.y > view.minY - this.height) {
                        ctx.beginPath();
                    		drawing = new Image();
                    		drawing.src = this.src;
                    		ctx.drawImage(drawing, getCanvasX(this.x) - (this.width/2), getCanvasY(this.y)-(this.height/2), this.width, this.height);
                        //ctx.drawImage(drawing, getCanvasX(this.x), getCanvasY(this.y), this.width, /*canvas....*/ -this.height);
                        ctx.closePath();
                    }
                }
                var drawCircle = function() {
                    if (this.x < view.maxX + this.radius && this.x > view.minX - this.radius && this.y < view.maxY + this.radius && this.y > view.minY - this.radius) {
                        ctx.beginPath();
                        ctx.arc(getCanvasX(this.x), getCanvasY(this.y), this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = this.color || "red";
                        ctx.fill();
                        ctx.closePath();
                    }
                };
//firing methods
								function fireMouseDown(shotType, shotArray) { return function(){
									if(mouseDown){
                    shotArray.push(new shotType(this));
									}
                };}
								function fireAlways(shotType, shotArray) { return function(){
									if(true){
                    shotArray.push(new shotType(this));
									}
                };}
//warp methods
								function degreeWarp(amount){
										return function(){
											this.angle+=correctForInterval(amount);
										}
								}
//update methods
//avoid the bounceing back and forth when they want to go somewhere?? myabe its somewhat realistic
								function angleToDxDy(){	
										return function(){
                    this.radians = this.angle * (Math.PI / 180);
                    this.dx = (this.speed * Math.cos(this.radians));
                    this.dy = (this.speed * Math.sin(this.radians));
										}
								}
							var maxMin= function(){
								this.maxX = this.x + canvas.width/2;
								this.maxY = this.y + canvas.height/2;
								this.minX = this.x - canvas.width/2;
								this.minY = this.y - canvas.height/2;
							}	

//tracking methods
							
function trackToObjectXY(that, to){
//console.log(getDistanceObjs(that, to));
			if( getDistanceObjs(that, to) <= that.speed + 1){
								that.x = to.x;
								that.y = to.y;
								that.still = true;
				}else{
								setDxDyToObject(that, to);
}}	
function trackNearObject(that, to, bounceRange){
			if( getDistanceFuture(that, to) >(bounceRange||100)){
								setDxDyToObject(that, to);
//console.log(view.x, cursor.x);
}}	
function trackStopNearObject(that, to, range){
			if( getDistanceFuture(that, to) >(range||100)){
								setDxDyToObject(that, to);
}else {
that.still = true; 
;}
}	
//maybe update have contant cursor tracking
function setDxDyToObject(that, to){
//fix cursor draw loaction so it uses 
//took out getGameBla here
//added where will be to this to fix lag between screen and player
                    that.differenceY = to.y - that.y;
                    that.differenceX = to.x - that.x;
                    that.angle = (Math.atan2(that.differenceY, that.differenceX)) * (180 / Math.PI);
                    that.radians = that.angle * (Math.PI / 180);
                    that.dx = (that.speed * Math.cos(that.radians));
                    that.dy = (that.speed * Math.sin(that.radians));
}

//move methods
//EVENT direction methods
function matchMove(that){
 return    function(){
//console.log(view);
								var	countDx = 0;
									var countDy = 0;
console.log(that);
							if((that.still || false) != true){
//console.log(view.dx, view.dy);
//the or Does not work
//the .01 is because of bad math
this.dx = that.dx;
this.dy = that.dy;
}else{this.dx =0;
			this.dy =0;}};}
function handleWASD(that)
{ return    function(){
									countX = 0;
									countY = 0;
//the or Does not work
                    if (rightPressed) {
                        this.dx = (that.speed || this.speed);
												countX++;
                    }
                    if (upPressed) {
                        this.dy = (that.speed || this.speed);
												countY++;
                    }

                    if (leftPressed) {
                        this.dx = -(that.speed || this.speed);
												countX++;
                    }
                    if (downPressed) {
                        this.dy = -(that.speed || this.speed);
												countY++;
                    }
										if(countY ==0 ||countY ==2){
											this.dy = 0;
										}
										if(countX ==0 ||countX ==2){
											this.dx = 0;
										}
										if(countX ==1 && countY ==1){
												this.dy = (((that.dy||this.dy)/(Math.abs(that.dy||this.dy)))||0) * (Math.sqrt(Math.pow((that.speed || this.speed), 2)/2));
												this.dx = (((that.dx||this.dx)/(Math.abs(that.dx||this.dx)))||0) * (Math.sqrt(Math.pow((that.speed || this.speed), 2)/2));
}
};}
                //END METHODS HERE
								//***********VIEWPORT CLASS************
						function View(){
                this.x = canvas.width/2;
                this.y = canvas.height/2;
								this.trackTarget = player;
								//this.speed = this.trackTarget.speed;
								this.speed =15; 
								this.maxX = this.x + canvas.width/2;
								this.maxY = this.y + canvas.height/2;
								this.minX = this.x - canvas.width/2;
								this.minY = this.y - canvas.height/2;
								this.still = true;
								this.dx = 0;
								this.dy = 0;

								//this.followRange = 100;
							}	

								//View.prototype.eventDirection = handleWASD(player);
								View.prototype.eventDirection = matchMove(player);
//when player move diagonal there is a chance that where the player will be would not be outside the range of the viewport
								View.prototype.track = function(){trackStopNearObject(this, this.trackTarget, this.followRange);};
								View.prototype.update = maxMin;
					
								
								//END VIEWPORT HERE
                //**************PLAYER CLASS************
                function Player(width, height, speed, health, color) {
                    this.width = width;
										this.solid = true;
//not entirely necesary but helps clarity
										this.still = false;
                    this.height = height;
										this.trackTarget = cursor;
										this.x = canvas.width/2
										this.y = canvas.height/2;
/*
                    this.x = ((view.maxX - view.minX) / 2) - (this.width / 2);
                    this.y = ((view.maxY - view.minY) / 2) - (this.height / 2);
*/
                    this.speed = correctForInterval(speed);
                    this.health = health;
                    this.color = color;
										this.dx = 0;
										this.dy = 0;
                }

								Player.prototype.fire = fireMouseDown(CircleShot, circleShots);
								Player.prototype.bounce = stopOnSolid();
								Player.prototype.eventDirection = handleWASD(this);
                Player.prototype.draw = drawRectangle;
                Player.prototype.isAlive = healthDie(players);

                //PLAYER CODE ENDS HERE
                //**************Spitter CLASS************
                function Spitter(x, y, width, height, health, speed, color) {
                    this.x = x;
                    this.y = y;
										this.trackTarget = player;
                    this.width = width;
                    this.height = height;
                    this.solid = true;
                    this.health = health || 15000;
                    this.speed = correctForInterval(speed) || 0;
                    this.color = color || "green";
                    this.reload = 0;
                };

//								Spitter.prototype.fire = fireMouseDown(CircleShot, circleShots);
								Spitter.prototype.fire = fireAlways(CircleShot, circleShots);
                Spitter.prototype.isAlive = healthDie(spitters); 
                Spitter.prototype.draw = drawRectangle;
								//Spitter.prototype.fire = fireAtPlayer(SpitterBullet, spitterBullets);


                //SPITTER CODE ENDS HERE

                //********CIRCLE SHOT CLASS***********
                function CircleShot(whose) {
										this.whose = whose;//like player1 object, or spitter one object, then calls the xy wy of that for the bullet x y
                    this.x = whose.x;
                    this.y = whose.y;
										this.storage = circleShots;
										this.trackTarget = whose.trackTarget;
										this.still = false;
										//	console.log(whose);
										
										this.startX = this.x;
										this.startY = this.y;
										this.range = 1000;
										this.durationSeconds = 5;
										this.color = whose.color;
										
                    this.radius = 2.5;
                    this.speed = correctForInterval(25);
                    //and here
//problem here
										setDxDyToObject(this, whose.trackTarget);
//make this section just dx = getDxToCursor(this);
                }
										//Test.prototype.testmethod = function(){testfunc(this);};
								CircleShot.prototype.isAlive = function(){distanceDie(this);timeDie(this);};
                CircleShot.prototype.bounce = stopOnSolid();
                CircleShot.prototype.draw = drawCircle;
								//CircleShot.prototype.warp = degreeWarp(80);
								//CircleShot.prototype.update = angleToDxDy();
								CircleShot.prototype.track = function(){trackNearObject(this, this.trackTarget, 50);};
                //PROJECTILE ENDS HERE
								function testfunc(that){
												//console.log(that.num);
												console.log("hey");
								}
								var test2 = new Test2();
								var test1 = new Test();
								function Test2(){
											this.other = test1;
								}
								function Test(){
										this.num = 3;
										Test.prototype.testmethod = function(){testfunc(this);};
								}
								//console.log(test2.other.num);
                //*****RectangleClass*********
                function Rectangle(x, y, width, height, color, health) {
                    this.x = x;
                    this.y = y;
                    this.solid = true;
                    this.width = width;
                    this.height = height;
                    this.color = color || "blue";
                    this.health = health || 100;
                }
                Rectangle.prototype.draw = drawRectangle;
                Rectangle.prototype.isAlive = healthDie(rectangles); 


                //RECTANGLE ENDS HERE
                //********CURSOR CLASS*********
//problem with change in view direction moving the cursor just the very slightest bit
                function Cursor() {
										this.x = 100;
										this.y = 100;
										this.dx = 0;
										this.dy = 0;
										this.height = 20;
										this.still = false;
										this.width = 20;
                    this.src = "/images/crossheirs.png"
										this.speed = 10;
										this.trackTarget = mouse;
                }
//TODOdone I think
								Cursor.prototype.eventDirection = matchMove(view);
										Cursor.prototype.draw = drawSprite;
Cursor.prototype.handleSpace = function(){
if(spacePressed == true){
			this.still = true;
					}
};
								//Cursor.prototype.track = function(){trackToObjectXY(this, mouse);};
								//END CURSOR HERE

                function mouseMoveHandler(e) {
                    mouse.x = getGameX(e.clientX - canvas.getBoundingClientRect().left);
                    mouse.y = getGameY(e.clientY - canvas.getBoundingClientRect().top);
										if(spacePressed == false){
                    cursor.x = view.dx + getGameX(e.clientX - canvas.getBoundingClientRect().left);
                    cursor.y = view.dy + getGameY(e.clientY - canvas.getBoundingClientRect().top);
									}	
                }
//****MOUSE*****
function Mouse(){
 this.x = 0;
 this.y = 0;
}
                document.addEventListener("mousemove", mouseMoveHandler, false);
                ///MOUSE ENDS HERE
//no need to put in the classes themselves, just buff it up here
//*******UPDATE STARTS HERE********
                function move() {
                    for (var j = 0; j < instances.length; j++) {
                        for (var i = 0; i < instances[j].length; i++) {
													
                            //if it has movement
                          if ("dx" in instances[j][i]) {
                            if ("still" in instances[j][i]) {
																	if(instances[j][i].still != true){
																							
                                instances[j][i].x += instances[j][i].dx;
                                instances[j][i].y += instances[j][i].dy;
																				
																		}


                            }else{
                                instances[j][i].x += instances[j][i].dx;
                                instances[j][i].y += instances[j][i].dy;
														}
												}
											//should fix track bounce complication	
                                instances[j][i].still = false;
                       }
                    }
										
						}
//forward could be direction of mouse
                function update() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//oh so debating making move a method for all
//problem with wanting the order to be track then bounce or bounce then track
									//	viewUpdate();
//this piece of nice sounding logical order is the cause of methods equaling functions that return functions and all the other wierd things that go on in this code.
//one might think why not just use the this.(whatever function) = function
//but it is done in this wierd way for sorting purposes
//caution with using event direction twice
//track sets still to to true, then move sets it to false, then event direction cannot pick up on it unless its infront
//update means viewmax and min are set
										["handleSpace", "update", "isAlive", "fire", "track", "eventDirection", "draw",  "bounce"/*set angle to dxdy*/ /*"update"*/  /*,"warp"*/].map(invokeOnInstances);
//player drawn in relation to view
                    move();
//console.log(mouse.x, mouse.y);
                }

                function invokeOnInstances(method) {
                    for (var i = 0; i < instances.length; i++) {
                        for (var j = 0; j < instances[i].length; j++) {
                            if (instances[i][j][method] && typeof instances[i][j][method] === "function") {
                                instances[i][j][method]();
                            };
                        }
                    }
                }

//*******UTILITY FUNCTIONS*******
//would need the function to return a function using the args for this to work
function assignMethodWithFunctionToClass(typeClass, method, func){
	typeClass.prototype.method = func;
}
function getDistance(x1, y1, x2, y2) {
	return Math.sqrt(Math.pow((y2-y1),2)+(Math.pow((x2-x1),2) ));
}
function getDistanceObjs(that, to) {
	return Math.sqrt(Math.pow((that.y-to.y),2)+(Math.pow((that.x-to.x),2) ));
}
function getDistanceFuture(that, to) {
	return (getDistance(that.x+(that.dx||0), that.y+(that.dy ||0) , to.x+(to.dx || 0), to.y +(to.dy||0)))
}
								function correctForInterval(x){
											return (iterationTime/100)* x;
								}
//probably the problem
                function getGameX(x) {
                    return x + view.minX;
                }

                function getGameY(y) {
                    return ((canvas.height - y) + view.minY);
                }

								function getCanvas(){}
                function getCanvasX(gameX) {
                    return gameX - view.minX;
                }

                function getCanvasY(gameY, reindex) {
                    onlyReindex = reindex || false;
                    if (onlyReindex) {
                        return (canvas.height - gameY);
                    } else {
                        return (canvas.height - (gameY - view.minY));
                    }
                }
//END UTILITY FUNCTIONS HERE
                function mouseDownHandler() {
										mouseDown = true;
                }
								function mouseUpHandler(){
										mouseDown = false;
								}
                document.addEventListener("mousedown", mouseDownHandler, false);
                document.addEventListener("mouseup", mouseUpHandler, false);
                document.addEventListener("keydown", keydown, false);
                document.addEventListener("keyup", keyup, false);

                function keydown(e) {
                    if (e.keyCode == 68) {
                        rightPressed = true;
                    }
                    if (e.keyCode == 65) {
                        leftPressed = true;
                    }
                    if (e.keyCode == 87) {
                        upPressed = true;
                    }
                    if (e.keyCode == 83) {
                        downPressed = true;
                    }
                    if (e.keyCode == 32) {
                        spacePressed = true;
                    }
                    if (e.keyCode == 82) {
                        window.alert("restarting");
                        document.location.reload();

                    }
                }

                function keyup(e) {
                    if (e.keyCode == 68) {
                        rightPressed = false;
                    }
                    if (e.keyCode == 65) {
                        leftPressed = false;
                    }
                    if (e.keyCode == 87) {
                        upPressed = false;
                    }
                    if (e.keyCode == 32) {
                        spacePressed =false;
                    cursor.x =  mouse.x; 
                    cursor.y =  mouse.y;
					console.log(mouse.x, mouse.y);
                    }
                    if (e.keyCode == 83) {
                        downPressed = false;
                    }
}
</script>

</body>
</html>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
