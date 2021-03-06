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
    <button onclick="setInterval(update,5);">start</button>

    <canvas id="myCanvas" width="980" height="420"></canvas>
    <p id="keycode">
        <p>
            <script>
                //canvas
                var canvas = document.getElementById("myCanvas");
          var message = document.getElementById("keycode");
                var ctx = canvas.getContext("2d");
                //mouse
                var mouseX = canvas.width / 2;
                var mouseY = canvas.height / 2;
								var mouseDown = false;
                //keyboard
                var upPressed = false;
                var downPressed = false;
                var leftPressed = false;
                var rightPressed = false;
                //viewport
                var viewMaxX = canvas.width;
                var viewMaxY = canvas.height;
                var viewMinX = 0;
                var viewMinY = 0;
                //rectangles
                var rectangle = new Rectangle(50, 50, 30, 30, "red");
                var rectangle2 = new Rectangle(100, 50, 30, 30, "green");
                var rectangle3 = new Rectangle(300, 50, 30, 30, "orange");
                var rectangle4 = new Rectangle(50, 200, 30, 30, "yellow");
                var rectangles = [rectangle, rectangle2, rectangle3, rectangle4];
                //spitters
                var spitter = new Spitter(200, 200, 40, 40, 10);
                var spitters = [spitter];
                //player
                var player = new Player(20, 20, 1, 10);
                var players = [player];
                //playershots
                var playerCircleShots = [];
                //anything that has methods constantly invoked
                var instances = [rectangles, spitters, players, playerCircleShots];
								//*******METHODS*********
//death methods
                function healthDie(containingArray) { return function(){
													if(this.health < 1){
															containingArray.splice(containingArray.indexOf(this), 1);
												}
										}
                };
                function distanceDie(containingArray){return function() {
									if(getDistance(this.startX, this.startY, this.x,this.y) > this.range){	
											containingArray.splice(containingArray.indexOf(this), 1);
										}
                }
	}
//bounce methods
								 function circleBounce(degree) {return function(){
										for (var j = 0; j < instances.length; j++) {
											if(instances [j].length >0){
														if (instances[j][0].solid == true) {
												for (var i = 0; i < instances[j].length; i++) {
																//checking will hit
																if (this.x + this.dx < instances[j][i].x + instances[j][i].width + this.radius && this.x + this.dx > instances[j][i].x - this.radius) {
																		if (this.y + this.dy < instances[j][i].y + instances[j][i].height + this.radius && this.y + this.dy > instances[j][i].y - this.radius) {
																				instances[j][i].health--;
																				//is above or below currently
																				if (this.x < instances[j][i].x + instances[j][i].width + this.radius && this.x > instances[j][i].x - this.radius) {
																					if(degree == true){
																							this.angle*= -1;
																							}else{
																						this.dy *= -1;
																							}
																				}
																				//is to the side currently
																				if (this.y < instances[j][i].y + instances[j][i].height + this.radius && this.y > instances[j][i].y - this.radius) {
																					if(degree == true){
																								this.angle = 180 -this.angle;
																							}else{
																						this.dx *= -1;
																							}
																				}
																		}
}
																}
}
														}
												}
										}
								};
//draw methods
                var drawRectangle = function() {
                    if (this.x < viewMaxX && this.x > viewMinX - this.width && this.y < viewMaxY && this.y > viewMinY - this.height) {
                        ctx.beginPath();
                        ctx.rect(getCanvasX(this.x), getCanvasY(this.y), this.width, /*canvas....*/ -this.height);
                        ctx.fillStyle = this.color || "purple";
                        ctx.fill();
                        ctx.closePath();
                    }
                }
                var drawCircle = function() {
                    if (this.x < viewMaxX + this.radius && this.x > viewMinX - this.radius && this.y < viewMaxY + this.radius && this.y > viewMinY - this.radius) {
                        ctx.beginPath();
                        ctx.arc(getCanvasX(this.x), getCanvasY(this.y), this.radius, 0, Math.PI * 2);
                        ctx.fillStyle = this.color;
                        ctx.fill();
                        ctx.closePath();
                    }
                };
//firing methods
								function fireMouseDown(shotType, shotArray) { return function(){
									if(mouseDown){
                    shotArray.push(new shotType);
									}
                }};
//warp methods
								function degreeWarp(amount){
										return function(){
											this.angle+=amount;
										}
								}
//update methods
								function angleToDxDy(){	
										return function(){
                    this.radians = this.angle * (Math.PI / 180);
                    this.dx = (this.speed * Math.cos(this.radians));
                    this.dy = (this.speed * Math.sin(this.radians));
										}
								}
/*
									if(mouseDown){
                    playerCircleShots.push(new PlayerCircleShot());
									}
								};
*/
														

                //END METHODS HERE
                //**************PLAYER CLASS************
                function Player(width, height, speed, health, color) {
                    this.width = width;
                    this.height = height;
                    this.x = ((viewMaxX - viewMinX) / 2) - (this.width / 2);
                    this.y = ((viewMaxY - viewMinY) / 2) - (this.height / 2);
                    this.speed = speed;
                    this.health = health;
                    this.color = color;
                };

								Player.prototype.fire = fireMouseDown(PlayerCircleShot, playerCircleShots);
                Player.prototype.draw = drawRectangle;
                Player.prototype.isAlive = healthDie(players);

                //PLAYER CODE ENDS HERE
                //**************Spitter CLASS************
                function Spitter(x, y, width, height, health, speed, color) {
                    this.x = x;
                    this.y = y;
                    this.width = width;
                    this.height = height;
                    this.solid = true;
                    this.health = health || 15;
                    this.speed = speed || 0;
                    this.color = color || "green";
                    this.reload = 0;
                };

                Spitter.prototype.isAlive = healthDie(spitters); 
                Spitter.prototype.draw = drawRectangle;
								//Spitter.prototype.fire = fireAtPlayer(SpitterBullet, spitterBullets);


                //SPITTER CODE ENDS HERE

                //********PLAYER CIRCLE SHOT CLASS***********
                function PlayerCircleShot(whose) {
										this.whose = whose;
                    this.x = player.x + player.width / 2;
                    this.y = player.y + player.height / 2;
										this.startX = this.x;
										this.startY = this.y;
                    this.radius = 2.5;
                    this.speed = 1.5;
										this.range = 1000;
                    //and here
                    this.differenceY = getGameY(mouseY) - this.y;
                    this.differenceX = getGameX(mouseX) - this.x;
                    this.angle = (Math.atan2(this.differenceY, this.differenceX)) * (180 / Math.PI);
                    this.radians = this.angle * (Math.PI / 180);
                    this.dx = (this.speed * Math.cos(this.radians));
                    this.dy = (this.speed * Math.sin(this.radians));
                };
								PlayerCircleShot.prototype.isAlive = distanceDie(playerCircleShots);
                PlayerCircleShot.prototype.bounce = circleBounce(true);
                PlayerCircleShot.prototype.draw = drawCircle;
								PlayerCircleShot.prototype.warp = degreeWarp(2);
								PlayerCircleShot.prototype.update = angleToDxDy(1);
                //PROJECTILE ENDS HERE
                //*****RectangleClass*********
                function Rectangle(x, y, width, height, color, health) {
                    this.x = x;
                    this.y = y;
                    this.solid = true;
                    this.width = width;
                    this.height = height;
                    this.color = color || "blue";
                    this.health = health || 100000;
                }
                Rectangle.prototype.draw = drawRectangle;
                Rectangle.prototype.isAlive = healthDie(rectangles); 

                //RECTANGLE ENDS HERE
                //********CURSOR*********
                function drawCursor() {
                    drawing = new Image();
                    drawing.src = "/images/crossheirs.png"
                    ctx.beginPath();

                    ctx.drawImage(drawing, mouseX - 10, mouseY - 10, 20, 20);
                    ctx.fillStyle = "blue";
                    ctx.fill();
                    ctx.closePath();
                }

                function mouseMoveHandler(e) {
                    mouseX = e.clientX - canvas.getBoundingClientRect().left;
                    mouseY = e.clientY - canvas.getBoundingClientRect().top;
                }
                document.addEventListener("mousemove", mouseMoveHandler, false);
                ///MOUSE ENDS HERE

                function move() {
                    for (var j = 0; j < instances.length; j++) {
                        for (var i = 0; i < instances[j].length; i++) {
                            //if it has movement
                            if ("dx" in instances[j][i]) {
                                instances[j][i].x += instances[j][i].dx;
                                instances[j][i].y += instances[j][i].dy;
                            }
                        }
                    }
                }

                function update() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    move();
										viewUpdate();
                    drawCursor();
                    invokeOnInstances("draw");
                    invokeOnInstances("update");
                    invokeOnInstances("bounce");
                    invokeOnInstances("isAlive");
                    invokeOnInstances("fire");
                    invokeOnInstances("warp");
                }
                var types = [rectangles, spitters];


                function invokeOnInstances(method) {
                    for (var i = 0; i < instances.length; i++) {
                        for (var j = 0; j < instances[i].length; j++) {
                            if (instances[i][j][method] && typeof instances[i][j][method] === "function") {
                                instances[i][j][method]()
                            };
                        }
                    }
                }

                function viewUpdate() {
                    if (rightPressed) {
                        viewMaxX += player.speed;
                        viewMinX += player.speed;
                        player.x += player.speed;
                    }
                    if (upPressed) {
                        viewMaxY += player.speed;
                        viewMinY += player.speed;
                        player.y += player.speed;
                    }
                    if (leftPressed) {
                        viewMaxX -= player.speed;
                        viewMinX -= player.speed;
                        player.x -= player.speed;
                    }
                    if (downPressed) {
                        viewMaxY -= player.speed;
                        viewMinY -= player.speed;
                        player.y -= player.speed;
                    }
                }

function getDistance(x1, y1, x2, y2) {
	var distance = Math.sqrt(Math.pow((y2-y1),2)+(Math.pow((x2-x1),2) ));
	return distance;
}
                function getGameX(x) {
                    return x + viewMinX;
                }

                function getGameY(y) {
                    return ((canvas.height - y) + viewMinY);
                }

                function getCanvasX(gameX) {
                    return gameX - viewMinX;
                }

                function getCanvasY(gameY, reindex) {
                    onlyReindex = reindex || false;
                    if (onlyReindex) {
                        return (canvas.height - gameY);
                    } else {
                        return (canvas.height - (gameY - viewMinY));
                    }
                }
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
