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

    <canvas id="myCanvas" width="680" height="320"></canvas>
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
                var circleBounce = function() {
                    for (var j = 0; j < instances.length; j++) {

                        for (var i = 0; i < instances[j].length; i++) {
                            if (instances[j][i].solid = true;) {
                                //checking will hit
                                if (this.x + this.dx < [i].x + instances[j][i].width + this.radius && this.x + this.dx > instances[j][i].x - this.radius) {
                                    if (this.y + this.dy < instances[j][i].y + instances[j][i].height + this.radius && this.y + this.dy > instances[j][i].y - this.radius) {
                                        instances[j][i].health--;
                                        //is above or below currently
                                        if (this.x < instances[j][i].x + instances[j][i].width + this.radius && this.x > instances[j][i].x - this.radius) {
                                            this.dy *= -1;
                                        }
                                        //is to the side currently
                                        if (this.y < instances[j][i].y + instances[j][i].height + this.radius && this.y > instances[j][i].y - this.radius) {
                                            this.dx *= -1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                };

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

                Player.prototype.draw = drawRectangle;

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

                Spitter.prototype.fire = function() {
                    projectiles.push(new Projectile("bad", this.x, this.y));
                };
                Spitter.prototype.draw = drawRectangle;

                //changes made here
                /*
                Player.prototype.setXY = function () {
                        this.x = ((viewMaxX-viewMinX)/2) - (this.width/2);
                        this.y = ((viewMaxY-viewMinY)/2) - (this.height/2);
                	message.innerHTML = this.x + "x " + this.y + "y ";
                }
                */

                //SPITTER CODE ENDS HERE

                //********PLAYER CIRCLE SHOT CLASS***********
                function PlayerCircleShot() {
                    this.x = player.x + player.width / 2;
                    this.y = player.y + player.height / 2;
                    this.radius = 2.5;
                    this.speed = 1.5;
                    //and here
                    this.differenceY = getGameY(mouseY) - this.y;
                    this.differenceX = getGameX(mouseX) - this.x;
                    this.angle = (Math.atan2(this.differenceY, this.differenceX)) * (180 / Math.PI);
                    this.radians = this.angle * (Math.PI / 180);
                    this.dx = (this.speed * Math.cos(this.radians));
                    this.dy = (this.speed * Math.sin(this.radians));
                };

                function shoot() {
                    playerCircleShots.push(new PlayerCircleShot());
                }
                /*function bounceProjectiles(){
                	for (var i = 0; i < projectiles.length; i++){
                		projectiles[i].bounce();
                	}
                }
                */
                PlayerCircleShot.prototype.bounce = circleBounce;

                PlayerCircleShot.prototype.draw = drawCircle;
                //PROJECTILE ENDS HERE
                //*****RectangleClass*********
                function Rectangle(x, y, width, height, color, health) {
                    this.x = x;
                    this.y = y;
                    this.solid = true;
                    this.width = width;
                    this.height = height;
                    this.color = color || "blue";
                    this.health = health || 10;
                }
                Rectangle.prototype.draw = drawRectangle;

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
                    drawCursor();
                    invokeOnInstances("draw");
                    invokeOnInstances("bounce");
                    //isAlive();
                    //typesUpdate();
                }
                var types = [rectangles, spitters];

                function typesUpdate() {
                    draw();
                    //bouncing off rectangles
                    bounce();
                    isAlive();
                    for (var p = 0; p < projectiles.length; p++) {
                        for (var i = 0; i < types[j].length; i++) {
                            if (projectiles[p].x + projectiles[p].dx < types[j][i].x + types[j][i].width + projectiles[p].radius && projectiles[p].x + projectiles[p].dx > types[j][i].x - projectiles[p].radius) {
                                if (projectiles[p].y + projectiles[p].dy < types[j][i].y + types[j][i].height + projectiles[p].radius && projectiles[p].y + projectiles[p].dy > types[j][i].y - projectiles[p].radius) {
                                    types[j][i].health--;
                                    //is above or below currently 
                                    if (projectiles[p].x < types[j][i].x + types[j][i].width + projectiles[p].radius && projectiles[p].x > types[j][i].x - projectiles[p].radius) {
                                        projectiles[p].dy *= -1;
                                    }
                                    //is to the side currently 
                                    if (projectiles[p].y < types[j][i].y + types[j][i].height + projectiles[p].radius && projectiles[p].y > types[j][i].y - projectiles[p].radius) {
                                        projectiles[p].dx *= -1;
                                    }
                                }
                            }
                        }
                    }
                }

                function invokeOnInstances(method) {
                    for (var i = 0; i < instances.length; i++) {
                        for (var j = 0; j < instances[i].length; j++) {
                            if (instances[i][j][method] && typeof instances[i][j][method] === "function") {
                                instances[i][j][method]()
                            };
                        }
                    }
                }

                //*****Draw functions****
                function draw() {
                    //going through types
                    for (var j = 0; j < drawables.length; j++) {
                        //drawing
                        for (var i = 0; i < drawables[j].length; i++) {
                            drawables[j][i].draw();
                        }
                    }
                }
                var drawCircleInGame = function() {
                    if (this.x < viewMaxX && this.x > viewMinX - this.width && this.y < viewMaxY && this.y > viewMinY - this.height) {
                        ctx.beginPath();
                        ctx.rect(getCanvasX(this.x), getCanvasY(this.y), this.width, /*correcting for 0 index*/ -this.height);
                        ctx.fillStyle = this.color;
                        ctx.fill();
                        ctx.closePath();
                    }
                }

                //END DRAW FUNCTIONS
                //*******BOUNCE functions*****

                function bounce() {
                    //going through types
                    for (var j = 0; j < drawables.length; j++) {
                        //drawing
                        for (var i = 0; i < drawables[j].length; i++) {
                            drawables[j][i].draw();
                        }
                    }
                }
                //END BOUNCE FUNCTIONS
                //*******IS ALIVE FUNCTIONS*****
                function isAlive() {
                    for (var j = 0; j < livings.length; j++) {
                        for (var i = 0; i < livings[j].length; i++) {
                            livings[j][i].isAlive();
                        }
                    }
                }

                //END IS ALIVE FUNCTIONS

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

                document.addEventListener("click", shoot, false);
                document.addEventListener("keydown", keydown, false);
                document.addEventListener("keyup", keyup, false);

                function keydown(e) {
                    if (e.keyCode == 39) {
                        rightPressed = true;
                    }
                    if (e.keyCode == 37) {
                        leftPressed = true;
                    }
                    if (e.keyCode == 38) {
                        upPressed = true;
                    }
                    if (e.keyCode == 40) {
                        downPressed = true;
                    }
                    if (e.keyCode == 82) {
                        window.alert("restarting");
                        document.location.reload();

                    }
                }

                function keyup(e) {
                    if (e.keyCode == 39) {
                        rightPressed = false;
                    }
                    if (e.keyCode == 37) {
                        leftPressed = false;
                    }
                    if (e.keyCode == 38) {
                        upPressed = false;
                    }
                    if (e.keyCode == 40) {
                        downPressed = false;
                    }
                }
</script>

</body>
</html>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
