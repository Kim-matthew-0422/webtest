// 퀵메뉴

function initMoving(target, position, topLimit, btmLimit) {
	if (!target)
		return false;
	var obj = target;
	obj.initTop = position;
	obj.topLimit = topLimit;
	obj.bottomLimit = document.documentElement.scrollHeight - btmLimit;
	obj.style.position = "absolute";
	obj.top = 20;
	obj.left = obj.initLeft;
	if (typeof(window.pageYOffset) == "number") {				
		obj.getTop = function() {				
			return window.pageYOffset;
		}
	} else if (typeof(document.documentElement.scrollTop) == "number") {				
		obj.getTop = function() {					
			return document.documentElement.scrollTop;
		}
	} else {
		obj.getTop = function() {
			return 0;
		}
	}
/*
	if (self.innerHeight) {
		alert("1");
		obj.getHeight = function() {
			return self.innerHeight;
		}
	} else if(document.documentElement.clientHeight) {
		alert("2");
		obj.getHeight = function() {
			return document.documentElement.clientHeight;
		}
	} else {
		alert("3");
		obj.getHeight = function() {
			return 500;
		}
	}
*/
	obj.move = setInterval(function() {
		if(!document.getElementById('quick_stop') || !document.getElementById('quick_stop').checked){
			if (obj.initTop > 0) {
				pos = obj.getTop() + obj.initTop;
			} else {
				pos = obj.getTop() + obj.getHeight() + obj.initTop;
				pos = obj.getTop() + obj.getHeight() / 2 - 15;
			}
			interval = obj.top - pos;
			obj.top = obj.top - interval / 3;
			obj.style.top = obj.top + "px";
		}
	}, 30)
}

