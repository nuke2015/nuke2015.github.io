window.addEventListener("load", windowLoadHandler, false);
var sphereRad = 280;
var radius_sp=1.9;
var opt_display_dots = false;

var unicodeFlakes = ['?', '?', '?', '?', 'QQ569743', '?', 'FBI作战部署系统', '?', '?', '?', 'QQ569743', '?', '?', '?', '?', '黑客', '雨苁', '火', 'Metasploit', '山', '雨苁', 'Metasploit', '雨苁', '是', '肺', '化', '?', '化', 'QQ569743', '符', '', 'Webshell', '原', '子', 'Webshell', '?', '是', '它', 'Webshell', '肺', 'Webshell', 'Metasploit', '黑客', '?', 'Webshell', '?', '黑客', '光', 'FBI作战部署系统', 'Webshell', '硬', '', '於', '黑客', '爷爷都是从孙子过来的', 'Webshell', '?', 'Webshell', '冱', 'Webshell', '极客', '族', 'Webshell', '别认输,因为没人希望你赢', '极客', '矽', '相', 'Webshell', '有', '黑客', 'FBI作战部署系统', 'Webshell', '位', 'QQ569743', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '才', '雨苁', '参', '餐', '黑客', '茶', '黑客', '雨苁', '常', 'Metasploit', '', '超', 'Metasploit', 'Anonymous', '城', 'Metasploit', '黑客', '黑客', 'QQ569743', '黑客', 'Webshell', '雨苁', '雨苁', '黑客', 'Webshell', '黑客', '读', '雨苁', '度', '极客', '对', '', 'Metasploit', '儿', '雨苁', '发', 'HACK', 'QQ569743', '饭', '方', 'QQ569743', '放', '飞', 'QQ569743', '费', '分', 'Anonymous', 'Webshell', '封', '黑客', 'Webshell', '附', '雨苁', 'Webshell', '该', '改', 'QQ569743', '感', '刚', '雨苁', '黑客', '哥', '歌', '黑客', 'Metasploit', '给', 'HACK', '喝', 'QQ569743', '雨苁', '雨苁', '雨苁', '很', 'QQ569743', '后', '候', '湖', '护', '花', 'Webshell', 'Anonymous', '话', '坏', '雨苁', '还', '换', 'Webshell', '回', 'Webshell', '婚', '活', 'Metasploit', '或', '机', '极客', '黑客', 'Webshell', '急', 'QQ569743', '济', '继', 'Metasploit', '加', 'Webshell', '假', '价', 'Anonymous', 'WiFi', '丽', '雨苁', '凉', '两', '亮', '极客', '辆', '雨苁', 'Webshell', '零', '', '楼', '路', '录', '旅', '妈', '马', 'Webshell', '吗', '买', 'QQ569743', 'Metasploit', '慢', '黑客', '猫', '黑客', '雨苁', 'Webshell', '极客', '黑客', 'WiFi', '雨苁', '米', '', '民', 'Metasploit', '末', 'Metasploit', '目', 'Metasploit', '哪', 'QQ569743', '奶', 'Metasploit', '南', 'Webshell', 'WiFi', 'Webshell', '能', 'Metasploit', 'FBI', '念', '雨苁', '您', 'Anonymous', '雨苁', 'Metasploit', '女', 'QQ569743', '欧', 'Anonymous', '雨苁', '旁', '胖', '跑', '朋', 'QQ569743', 'Anonymous', '极客', 'Metasploit', '平', '雨苁', 'FBI', '奇', '骑', '雨苁', '极客', '汽', '千', '雨苁大帅逼', '签', '轻', 'Webshell', '情', '雨苁', '秋', '球', '雨苁', 'HACK', 'Anonymous', '趣', '全', '然', '让', 'WiFi', 'HACK', '书', 'FBI', 'Metasploit', 'Webshell', '谁', 'Webshell', '睡', '', '雨苁', '思', '死', 'Webshell', '送', '诉', 'Webshell', '黑客', '极客', '孙', '所', '他', 'QQ569743', 'WiFi', '极客', '', 'Webshell', '汤', '', '极客', '雨苁', '踢', '雨苁', '黑客', '体', '黑客', '雨苁', 'Anonymous', 'Webshell', 'FBI', '雨苁', 'Anonymous', '通', '同', '头', 'Metasploit', 'WiFi', '雨苁', '完', 'HACK', 'Webshell', 'Metasploit', '网', '极客', 'WiFi', '望', 'FBI', '黑客', 'Metasploit', '文', '我', '卧', 'QQ569743', '午', 'FBI', '物', 'QQ569743', 'WiFi', '希', '雨苁', '习', '雨苁', '亚', '烟', '雨苁', '羊', '雨苁', '样', '极客', 'Webshell', 'HACK', 'Webshell', '雨苁', '一', 'HACK', 'HACK', 'QQ569743', '以', '易', '极客', 'Metasploit', '音', '印', '银', '应', '英', 'HACK', '硬', 'QQ569743', 'FBI', '油', '雨苁', 'Webshell', '极客', '雨苁', 'Webshell', '雨苁', '愉', '雨苁', 'Webshell', '雨苁', 'HACK', 'Metasploit', '原', '远', '院', '愿', '月', 'Anonymous', '早', '怎', '黑客', '雨苁', '照', '者', '这', '真', '雨苁', '证', 'Webshell', '雨苁', '极客', '直', 'Webshell', '纸', 'Metasploit', '雨苁', 'Webshell', '雨苁', 'QQ569743', 'FBI作战部署系统', '周', 'QQ569743', 'Metasploit', '住', '助', 'QQ569743', 'HACK', '黑客', 'Anonymous' ];

//for debug messages
var Debugger = function() { };
Debugger.log = function(message) {
	try {
		console.log(message);
	}
	catch (exception) {
		return;
	}
}

function windowLoadHandler() {
	canvasApp();
}

function canvasSupport() {
	return Modernizr.canvas;
}

function canvasApp() {
	if (!canvasSupport()) {
		return;
	}
	
	var theCanvas = document.getElementById("canvasOne");
	var context = theCanvas.getContext("2d");
	
	var displayWidth;
	var displayHeight;
	var timer;
	var wait;
	var count;
	var numToAddEachFrame;
	var particleList;
	var recycleBin;
	var particleAlpha;
	var r,g,b;
	var fLen;
	var m;
	var projCenterX;
	var projCenterY;
	var zMax;
	var turnAngle;
	var turnSpeed;
	var sphereCenterX, sphereCenterY, sphereCenterZ;
	var particleRad;
	var zeroAlphaDepth;
	var randAccelX, randAccelY, randAccelZ;
	var gravity;
	var rgbString;
	//we are defining a lot of variables used in the screen update functions globally so that they don't have to be redefined every frame.
	var p;
	var outsideTest;
	var nextParticle;
	var sinAngle;
	var cosAngle;
	var rotX, rotZ;
	var depthAlphaFactor;
	var i;
	var theta, phi;
	var x0, y0, z0;
		
	init();
	
  // INITIALLI
	function init() {
		wait = 1;
		count = wait - 1;
		numToAddEachFrame = 4;
		
		//particle color
		r = 70;
		g = 255;
		b = 140;
		
		rgbString = "rgba("+r+","+g+","+b+","; //partial string for color which will be completed by appending alpha value.
		particleAlpha = 1; //maximum alpha
		
		displayWidth = theCanvas.width;
		displayHeight = theCanvas.height;
		
		fLen = 320; //represents the distance from the viewer to z=0 depth.
		
		//projection center coordinates sets location of origin
		projCenterX = displayWidth/2;
		projCenterY = displayHeight/2;
		
		//we will not draw coordinates if they have too large of a z-coordinate (which means they are very close to the observer).
		zMax = fLen-2;
		
		particleList = {};
		recycleBin = {};
		
		//random acceleration factors - causes some random motion
		randAccelX = 0.1;
		randAccelY = 0.1;
		randAccelZ = 0.1;
		
		gravity = -0; //try changing to a positive number (not too large, for example 0.3), or negative for floating upwards.
		
		particleRad = 2.5;
		
		sphereCenterX = 0;
		sphereCenterY = 0;
		sphereCenterZ = -3 - sphereRad;
		
		//alpha values will lessen as particles move further back, causing depth-based darkening:
		zeroAlphaDepth = -750; 
		
		turnSpeed = 2*Math.PI/1200; //the sphere will rotate at this speed (one complete rotation every 1600 frames).
		turnAngle = 0; //initial angle
		
		timer = setInterval(onTimer, 10/24);
	}
	
	function onTimer() {
		//if enough time has elapsed, we will add new particles.		
		count++;
			if (count >= wait) {
						
			count = 0;
			for (i = 0; i < numToAddEachFrame; i++) {
				theta = Math.random()*2*Math.PI;
				phi = Math.acos(Math.random()*2-1);
				x0 = sphereRad*Math.sin(phi)*Math.cos(theta);
				y0 = sphereRad*Math.sin(phi)*Math.sin(theta);
				z0 = sphereRad*Math.cos(phi);
				
				//We use the addParticle function to add a new particle. The parameters set the position and velocity components.
				//Note that the velocity parameters will cause the particle to initially fly outwards away from the sphere center (after
				//it becomes unstuck).
				var p = addParticle(x0, sphereCenterY + y0, sphereCenterZ + z0, 0.002*x0, 0.002*y0, 0.002*z0);
				
				//we set some "envelope" parameters which will control the evolving alpha of the particles.
				p.attack = 50;
				p.hold = 50;
				p.decay = 100;
				p.initValue = 0;
				p.holdValue = particleAlpha;
				p.lastValue = 0;
				
				//the particle will be stuck in one place until this time has elapsed:
				p.stuckTime = 90 + Math.random()*20;
				
				p.accelX = 0;
				p.accelY = gravity;
				p.accelZ = 0;
			}
		}
		
		//update viewing angle
		turnAngle = (turnAngle + turnSpeed) % (2*Math.PI);
		sinAngle = Math.sin(turnAngle);
		cosAngle = Math.cos(turnAngle);

		//background fill
		context.fillStyle = "#000000";
		context.fillRect(0,0,displayWidth,displayHeight);
		
		//update and draw particles
		p = particleList.first;
		while (p != null) {
			//before list is altered record next particle
			nextParticle = p.next;

			//update age
			p.age++;
			
			//if the particle is past its "stuck" time, it will begin to move.
			if (p.age > p.stuckTime) {	
				p.velX += p.accelX + randAccelX*(Math.random()*2 - 1);
				p.velY += p.accelY + randAccelY*(Math.random()*2 - 1);
				p.velZ += p.accelZ + randAccelZ*(Math.random()*2 - 1);
				
				p.x += p.velX;
				p.y += p.velY;
				p.z += p.velZ;
			}
			
			/*
			We are doing two things here to calculate display coordinates.
			The whole display is being rotated around a vertical axis, so we first calculate rotated coordinates for
			x and z (but the y coordinate will not change).
			Then, we take the new coordinates (rotX, y, rotZ), and project these onto the 2D view plane.
			*/
			rotX =  cosAngle*p.x + sinAngle*(p.z - sphereCenterZ);
			rotZ =  -sinAngle*p.x + cosAngle*(p.z - sphereCenterZ) + sphereCenterZ;
			m =radius_sp* fLen/(fLen - rotZ);
			p.projX = rotX*m + projCenterX;
			p.projY = p.y*m + projCenterY;
			
			//update alpha according to envelope parameters.
			if (p.age < p.attack+p.hold+p.decay) {
				if (p.age < p.attack) {
					p.alpha = (p.holdValue - p.initValue)/p.attack*p.age + p.initValue;
				}
				else if (p.age < p.attack+p.hold) {
					p.alpha = p.holdValue;
				}
				else if (p.age < p.attack+p.hold+p.decay) {
					p.alpha = (p.lastValue - p.holdValue)/p.decay*(p.age-p.attack-p.hold) + p.holdValue;
				}
			}
			else {
				p.dead = true;
			}
			
			//see if the particle is still within the viewable range.
			if ((p.projX > displayWidth)||(p.projX<0)||(p.projY<0)||(p.projY>displayHeight)||(rotZ>zMax)) {
				outsideTest = true;
			}
			else {
				outsideTest = false;
			}
			
			if (outsideTest||p.dead) {
				recycle(p);
			}
			
			else {
				//depth-dependent darkening
				depthAlphaFactor = (1-rotZ/zeroAlphaDepth);
				depthAlphaFactor = (depthAlphaFactor > 1) ? 1 : ((depthAlphaFactor<0) ? 0 : depthAlphaFactor);
				context.fillStyle = rgbString + depthAlphaFactor*p.alpha + ")";
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
				context.fillText(p.flake,p.projX, p.projY);
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
        /*ADD TEXT function!*/
				//draw
				context.beginPath();
        if(opt_display_dots)
          {context.arc(p.projX, p.projY, m*particleRad, 0, 2*Math.PI, false);}
				context.closePath();
				context.fill();
			}
			
			p = nextParticle;
		}
	}
		
	function addParticle(x0,y0,z0,vx0,vy0,vz0) {
		var newParticle;
		var color;
    
		
		//check recycle bin for available drop:
		if (recycleBin.first != null) {
			newParticle = recycleBin.first;
			//remove from bin
			if (newParticle.next != null) {
				recycleBin.first = newParticle.next;
				newParticle.next.prev = null;
			}
			else {
				recycleBin.first = null;
			}
		}
		//if the recycle bin is empty, create a new particle (a new ampty object):
		else {
			newParticle = {};
		}
		
		//add to beginning of particle list
		if (particleList.first == null) {
			particleList.first = newParticle;
			newParticle.prev = null;
			newParticle.next = null;
		}
		else {
			newParticle.next = particleList.first;
			particleList.first.prev = newParticle;
			particleList.first = newParticle;
			newParticle.prev = null;
		}
		
		//initialize
		newParticle.x = x0;
		newParticle.y = y0;
		newParticle.z = z0;
		newParticle.velX = vx0;
		newParticle.velY = vy0;
		newParticle.velZ = vz0;
		newParticle.age = 0;
		newParticle.dead = false;
    
    newParticle.flake = unicodeFlakes[Math.floor(Math.random() * unicodeFlakes.length)];
		if (Math.random() < 0.5) {
			newParticle.right = true;
		}
		else {
			newParticle.right = false;
		}
		return newParticle;		
	}
	
	function recycle(p) {
		//remove from particleList
		if (particleList.first == p) {
			if (p.next != null) {
				p.next.prev = null;
				particleList.first = p.next;
			}
			else {
				particleList.first = null;
			}
		}
		else {
			if (p.next == null) {
				p.prev.next = null;
			}
			else {
				p.prev.next = p.next;
				p.next.prev = p.prev;
			}
		}
		//add to recycle bin
		if (recycleBin.first == null) {
			recycleBin.first = p;
			p.prev = null;
			p.next = null;
		}
		else {
			p.next = recycleBin.first;
			recycleBin.first.prev = p;
			recycleBin.first = p;
			p.prev = null;
		}
	}	
}