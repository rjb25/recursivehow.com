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
//switch classes over to having methods that equal functions that call functions which are passed the instance
//simply set player = otherCharchter to switch who the player is
//make an isAlive function that sets player to the one who died
//if a bullet belonging to player killed them
//'arguments' in a function gives access to the functions args. so if you want to go down that road, you could pass an array that 
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
      function descriptions(awesome, cool, alright){
               return awesome + " is awesome. " + cool + " is cool. " +
     alright + " is alright.";
}
								//cursor
								//*******METHODS*********
//DEATH methods
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
//COLLISION methods
//willBe on is techincally a utility, but is here for reference
//work on making this better
function willBeOn(that, hitting){
//maybe make variables like futureX futureY
//possible problem with "still" things having a dx and dy so they hit things that move by where they would be if they could move
//in that case though just set something?
if("radius" in that && "radius" in hitting){
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

//could use this collision for viewport drawing things or not
//altough this calculates willBe on not is On
//could alter this method with variables that are assign based on a passed true or false
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
														if ("solid" in instances[j][0]) {
															for (var i = 0; i < instances[j].length; i++) {
														if (instances[j][i].solid == true) {
																//checking will hit
																if(this !== instances[j][i]){
																if(willBeOn(this, instances[j][i]) && this.whose !== instances[j][i]){
																	hitCount++;}}}}}}}
if(hitCount>0){
		this.still = true;
}
};}
function notifyOnSolid() {return function(){
	for (var j = 0; j < instances.length; j++) {
						if(instances[j].length >0){
//WARNING if you have changing solid state of objects it might not be recognizewhole list
														if ("solid" in instances[j][0]) {
															for (var i = 0; i < instances[j].length; i++) {
														if (instances[j][i].solid == true) {
																//checking will hit
																if(this !== instances[j][i]){
																if(willBeOn(this, instances[j][i]) && this.whose !== instances[j][i]){
																	console.log("touching");}}}}}}}};
}
//DRAW methods
                var drawRectangle = function() {

                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
                        ctx.beginPath();
                        ctx.rect(getCanvasX(this.x)-(this.width/2), getCanvasY(this.y)-(this.height/2), this.width, /*canvas....*/ this.height);
                        ctx.fillStyle = this.color || "purple";
                        ctx.fill();
                        ctx.closePath();
                    }
                }
                 function drawRectangle2() {

                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
                        ctx.beginPath();
                        ctx.rect(getCanvasX(this.x)-(this.width/2), getCanvasY(this.y)-(this.height/2), this.width, /*canvas....*/ this.height);
                        ctx.fillStyle = this.color || "purple";
                        ctx.fill();
                        ctx.closePath();
                    }
                }

                var drawSprite = function() {
                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
                        ctx.beginPath();
                    		drawing = new Image();
                    		drawing.src = this.src;
                    		ctx.drawImage(drawing, getCanvasX(this.x) - (this.width/2), getCanvasY(this.y)-(this.height/2), this.width, this.height);
                        ctx.closePath();
                    }
                };
                var drawCircle = function() {
                    if (this.x < view.maxX + this.radius && this.x > view.minX - this.radius && this.y < view.maxY + this.radius && this.y > view.minY - this.radius) {
                        ctx.beginPath();
                        ctx.arc(getCanvasX(this.x), getCanvasY(this.y), this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = this.color || "red";
                        ctx.fill();
                        ctx.closePath();
                    }
                };
//FIRE methods
/*
								var fireMouseDown = function(shotType, shotArray) { 
									if(mouseDown){
//what if I wanted to make a specific players shots track something else
//run through bullet array, set each bullet that belongs to the person who the bullets belong to  and set their track equal to the new track target likely would be an update method "CorrectBulletTrack"
//actually seeing as it is using whose, you just have the function take the object 'whose' and go from that because that is constantly updated all you would need to do is change the track target in the object
//for that constant update though you must pass object not a variable of object
//then call makeShot(that) and from 'that' it can gunType, team, track target
//shot will will call the shot class multiple times say for a shotgun
//but passed different parameters based on the that.gun variable
                    shotArray.push(new shotType(this));
									}
                }
*/
								function fireAlways(shotType, shotArray) { return function(){
									if(true){
                    shotArray.push(new shotType(this));
									}
                };}
/*
								function fireProximity(shotType, shotArray) { return function(){
									if(//distance){
                    shotArray.push(new shotType(this));
									}
                };}
*/
//WARP methods
//but you might want to be able to pass somethign an angle and have that be its direction
//do conversion to dx dy here, make angles almmost pointless, or do angleDxDy here
//make it so that they all have function on class side, make it look much prettier for functions
//does not do actual angle, angles are corrected for interval so that changing interval does not change angle
								function degreeWarp(amount){
										return function(){
											this.angle+=correctForInterval(amount);
										}
								}
//UPDATE methods
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

//TRACK methods
							
function trackToObjectXY(that, to){
			if( getDistanceObjs(that, to) <= that.speed + 1){
//make this so that it sets dx and dy to the distance between x and y. teleporting is bad for business!
//also keep in mind its if this will be past where that will be reduce the dx and dy so that it is on top of it.
//some version of this should be applied for solids so balls are not at varying distances depending on andgle and dx
								that.x = to.x;
								that.y = to.y;
								that.still = true;
				}else{
								setDxDyToObject(that, to);
}}	
function trackNearObject(that, to, bounceRange){
			if( getDistance(that.x, that.y, to.x +to.dx, to.y +to.dy) >(bounceRange||100)){
								setDxDyToObject(that, to);
}}	
function trackStopNearObject(that, to, range){
			if( getDistance(that.x, that.y, to.x + to.dx, to.y +to.dy) >(range||100)){
	that.still = false;
								setDxDyToObject(that, to);
}else {
that.still = true; 
//setting dx dy to 0 here messes up cursor following screen, no idea why
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

//MATCH methods
//matchMOVE is only for things that are supposed to move exactly with another thing
function matchMove(that){
 return    function(){
								var	countDx = 0;
									var countDy = 0;

							if((that.still || false) != true){
this.still = false;
this.dx = that.dx;
this.dy = that.dy;
}else{this.dx =0;
			this.dy =0;}};}
//EVENT methods
//maybe add mouseMove and such to here
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
								this.speed = this.trackTarget.speed;
								this.maxX = this.x + canvas.width/2;
								this.maxY = this.y + canvas.height/2;
								this.minX = this.x - canvas.width/2;
								this.minY = this.y - canvas.height/2;
//shouldnt matter unless you have somethings movig on first instance or such
		//						this.still = true;
								this.dx = 0;
								this.dy = 0;

								//this.followRange = 100;
							}	

					
								
								//END VIEWPORT HERE
function runFunction(name, arguments)
{
    var fn = window[name];
    if(typeof fn !== 'function')
        return;

    fn.apply(window, arguments);
}

var X;
//If you have following function

function foo(num, second)
{
    X = num + second;
}

//You can call it like

runFunction('foo', [1, 3]); //alerts test.
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



                //SPITTER CODE ENDS HERE

                //********CIRCLE SHOT CLASS***********
/*
                function CircleShot(whose) {
										this.whose = whose;//like player1 object, or spitter one object, then calls the xy wy of that for the bullet x y
                    this.x = whose.x;
                    this.y = whose.y;
										this.dx = 0
										this.dy = 0
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
                    this.speed = correctForInterval(35);
										setDxDyToObject(this, whose.trackTarget);
                }
*/
                //PROJECTILE ENDS HERE
                //*****RectangleClass*********
                function Rectangle(x, y, width, height, color, health) {
                    this.x = x;
                    this.y = y;
                    this.solid = true;
                    this.width = width;
                    this.height = height;
                    this.color = color || "blue";
                    this.health = health || 100;
                    this.draw = drawRectangle2;
}


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
								//Cursor.prototype.track = function(){trackToObjectXY(this, mouse);};
								//END CURSOR HERE

                function mouseMoveHandler(e) {
                    mouse.x = getGameX(e.clientX - canvas.getBoundingClientRect().left);
                    mouse.y = getGameY(e.clientY - canvas.getBoundingClientRect().top);
										if(spacePressed == false){
                    cursor.x = cursor.dx + getGameX(e.clientX - canvas.getBoundingClientRect().left);
                    cursor.y =  cursor.dy + getGameY(e.clientY - canvas.getBoundingClientRect().top);
									}	
                }
//****MOUSE*****
function Mouse(){
 this.x = 0;
 this.y = 0;
}
                document.addEventListener("mousemove", mouseMoveHandler, false);
                ///MOUSE ENDS HERE
//*******UPDATE STARTS HERE********
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
//"update" is for things that have a change in one variable that must be matched to another.
										["handleSpace", "update", "isAlive", "fire", "eventHandle", "track", "match", "draw",  "bounce"/*set angle to dxdy*/ /*"update"*/  /*,"warp"*/].map(invokeOnInstances);
//With these console tests I slew the dragon of glitchy screen movement
//console.log(view.dx +"view", view.still,player.dx,player.still);
//console.log(view.dx ,view.still ,"viewdx", player.dx , player.still,"playerdx");
                    move();
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
//ALL methods
//doesnt need to be in every method because can be applied to everything
//same for others?
//others might have different functions fire has different shot
//maybe speed should be calculated here to dx dy
//no to the above take for example 'trudge' want the same speed to be passed, but a different dx and dy is evaulated
//just make a helper functions for calculating the different types of dx dy based on speed and angle or stuff like that if you run into redundancy
                function move() {
                    for (var j = 0; j < instances.length; j++) {
                        for (var i = 0; i < instances[j].length; i++) {
													
                            //if it has movement
														//if the group has movement
                          if ("dx" in instances[j][0]) {
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
//*******UTILITY FUNCTIONS*******
//would need the function to return a function using the args for this to work
function mergeMaps(obj1,obj2){
    var obj3 = {};
    for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
    for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
    return obj3;
}
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
//for leaving the cursor behind
                    if (e.keyCode == 32) {
                        spacePressed =false;
                    cursor.x =  mouse.x; 
                    cursor.y =  mouse.y;
                    }
                    if (e.keyCode == 83) {
                        downPressed = false;
                    }
}
/*
								function testfunc(){
												//console.log(that.num);
												console.log("hey");
								}
//								var test2 = new Test2();
//								var test1 = new Test(['letter', 'a'],['num', 5]);
								function Test2(){
											this.other = test1;
								}
//godly
								function Test(mapArr){
										for(var i =0; i<mapArr; ){
										this[numArr[0]] = numArr[1];
										}
								}
*/
//CHECK THIS OUT
								var cursor = new Cursor();
								var cursors = [cursor];
function setYap(that){
			that.yap = "yaaaap" + that.weirdo;	
}
function setHistory(that){
			that.history = "Lot of history down thaauauat road" + that.weirdo;	
}
var map2 = {weirdo : "-Weird Dude\n", init : function(){ setYap(this); setHistory(this);}};
map2.init();
//console.log(map2);
//END CHECK

Foo = {
    bar: function() {
        alert("baz");
    }   
}
/*
console.log("start");
console.log(map2);
//use merging for maps that have some presets
//not necesary but helps with not having to be so elaborate all the time. just do a part then append the rest
//like a type of baddy
/*
var map4 = map3.hey;
console.log(map3);
map3.hey = "pl";
console.log(map3);
*/
//IE doesnt like trailing commas but oh well
function fun(){
	return {width : 20, 
		height : 20, 
 health : 1500,
 solid : true,
 trackTarget : cursor,
 x : 2,
 y : 2,
	speed : correctForInterval(15),
dx :0,
dy :0
};
}
								function fireMouseDown(that, shotType, shotArray) { 
//return "hey";
									if(mouseDown){
console.log("clickity");
//what if I wanted to make a specific players shots track something else
//run through bullet array, set each bullet that belongs to the person who the bullets belong to  and set their track equal to the new track target likely would be an update method "CorrectBulletTrack"
//actually seeing as it is using whose, you just have the function take the object 'whose' and go from that because that is constantly updated all you would need to do is change the track target in the object
//for that constant update though you must pass object not a variable of object
//then call makeShot(that) and from 'that' it can gunType, team, track target
//shot will will call the shot class multiple times say for a shotgun
//but passed different parameters based on the that.gun variable
                    shotArray.push(new shotType(that));
									}
                }
//maybe make it so the object contains objects, like {vars : {x :1, y:0}, funcs : {f : func1, f2 :func2}}
                var drawRectangle = function() {

                    if (this.x < view.maxX +(this.width/2) && this.x > view.minX - (this.width/2) && this.y < view.maxY + (this.height/2) && this.y > view.minY - (this.height/2)) {
                        ctx.beginPath();
                        ctx.rect(getCanvasX(this.x)-(this.width/2), getCanvasY(this.y)-(this.height/2), this.width, /*canvas....*/ this.height);
                        ctx.fillStyle = this.color || "purple";
                        ctx.fill();
                        ctx.closePath();
                    }
                }
function level(that){
		that.health +=	100;
}
function Player(){
return {width: 20,
height: 20,
//commetn
health: 1500,
trackTarget : cursor,
 solid : true,
 x : 2,
 y : 2,
	speed : correctForInterval(15),
dx :0,
dy :0,
								fire :function(){ fireMouseDown(this, CircleShot, circleShots)},
								bounce : stopOnSolid(),
								eventHandle : handleWASD(this),
                draw : drawRectangle,
                isAlive : healthDie(players),
                levelUp : function(){level(this);}
};
}
var player = Player();
console.log(player);
//                var player = new Player(20, 20, 15, 1500);
                var players = [player];
                //player
///player depends on view for its draw function?
//functions are not part of constructor? maybe.
//make a function that assigns a function to an object why not just assign a different variable that uses the function differently
                //viewport
//I really need to stop this madness...
//view contructor depends on player location for its tracking function
								var view = new View(100);
//console.log(view);
								var views = [view];
                //rectangles
                var rectangle = new Rectangle(50, 50, 30, 30, "red");
                var rectangle2 = new Rectangle(100, 50, 30, 30, "green");
                var rectangle3 = new Rectangle(300, 50, 30, 30, "orange");
                var rectangle4 = new Rectangle(50, 200, 30, 30, "yellow");
                var rectangleObj = new Rectangle(50, 200, 30, 30, "yellow");
                var rectangles = [rectangle, rectangle2, rectangle3, rectangle4];

                //Rectangle.prototype.draw = drawRectangle;
                Rectangle.prototype.isAlive = healthDie(rectangles); 
/*
                function CircleShot(whose) {
										this.whose = whose;//like player1 object, or spitter one object, then calls the xy wy of that for the bullet x y
                    this.x = whose.x;
                    this.y = whose.y;
										this.dx = 0
										this.dy = 0
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
                    this.speed = correctForInterval(35);
										setDxDyToObject(this, whose.trackTarget);
                }
function Player(){
return {width: 20,
height: 20,
//commetn
health: 1500,
trackTarget : cursor,
 solid : true,
 x : 2,
 y : 2,
	speed : correctForInterval(15),
dx :0,
dy :0,
//appending to functions?
								fire :function(){ fireMouseDown(this, CircleShot, circleShots)},
								bounce : stopOnSolid(),
								eventHandle : handleWASD(this),
                draw : drawRectangle,
                isAlive : healthDie(players),
                levelUp : function(){level(this);}
};
}
var player = Player();
*/
var map = {mine : "MINE!"};
function CircleShot(whose){
return {whose : whose};
}
console.log(CircleShot(map));
function getFunctionOfFunctions(){};
function derp(){
//make fireFuncs array
//then have the annon function call all of those
	return {funcs : function(){console.log('smoke');}, function(){console.log('weed');}}
}
								CircleShot.prototype.isAlive = function(){distanceDie(this);timeDie(this);};
                CircleShot.prototype.bounce = stopOnSolid();
//make this drawShape(this), then call that.shape in drawShape functions, then have the constructor
                CircleShot.prototype.draw = drawCircle;
/*
shooter.fire = function(){shootLeftHandGun("handgun");};
shooter.fire = function(){shooter.fire(); shootLeftHandGun("handgun");};
var shooter = {
								fire :function(){ fireMouseDown(this, CircleShot, circleShots)},
    leftHandWeapon : function () {},
    fire : function () {
        this.rightHandWeapon();
        this.leftHandWeapon();
    }
}
*/
								
								//CircleShot.prototype.warp = degreeWarp(80);
//wouldnt need an update if you made it set dx dy aswell
//within degree warp
								//CircleShot.prototype.update = angleToDxDy();
								CircleShot.prototype.track = function(){trackNearObject(this, this.trackTarget, 50);};

										Cursor.prototype.draw = drawSprite;
/*
Cursor.prototype.handleSpace = function(){
if(spacePressed == true){
			this.still = true;
					}
};
*/
								Cursor.prototype.match = matchMove(view);
//view funcs
								//View.prototype.eventHandle = handleWASD(player);
								//View.prototype.match = matchMove(player);
//when player move diagonal there is a chance that where the player will be would not be outside the range of the viewport
//WORK
								View.prototype.track = function(){trackStopNearObject(this, this.trackTarget, this.followRange);};
								View.prototype.update = maxMin;
//order is important!!!!!! some are defined based on others
//make these the same class, like person, fighter? making classes in javascript is werid. You could have one class and just pass it different things to make entirely different objects with different methods

//								Spitter.prototype.fire = fireMouseDown(CircleShot, circleShots);
								Spitter.prototype.fire = fireAlways(CircleShot, circleShots);
                Spitter.prototype.isAlive = healthDie(spitters); 
                Spitter.prototype.draw = drawRectangle;
								//Spitter.prototype.fire = fireAtPlayer(SpitterBullet, spitterBullets);
//basically difference between player and spitter is xy update and team also wouldnt have to look through whole array to find the one to update. or you could make a function that contains the one you found so you no longer search? I am getting so confused with classes
//fire method might become like move, giving gun names and suchto fire that make it create a different bullet based on location and team
//classes differ because of different methods
                //spitters
/*
                var spitter = new Spitter(40, 40, 40, 40);
*/
//get rid of sub arrays? but they do make s=certain check operations happen quicker
//also lets you know the order of what happens to the types
//this could be a problem, the ordering stuff that is. dont want to HAVE to makes these arrays. Optional is ok. Im thinking about problems with comparisons between object items. like for match move
//how could I make it so that when one object is updated all the rest that track it are too even if they are behind it in list
//maybe only way would be for dx dy to have a reference to that that object, then have move call either what is being tracked's dx and dy rather than the current objects dx and dy

                var spitters = [];
								//maybe make it so that it check if it is an array? avoid this silly stuff
                //playershots
                var circleShots = [];
                //anything that has methods constantly invoked
//movement order matters for viewport versus player
//technically this just means everything, but allows for sorting
                var instances = [players, cursors, views, rectangles, spitters, circleShots];
</script>

</body>
</html>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
