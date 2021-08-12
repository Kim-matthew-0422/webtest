// JavaScript Document


//ë§í¬í…Œë‘ë¦¬
function bluring(){ 
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") document.body.focus(); 
} 
document.onfocusin=bluring; 
//



<!--

function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}



function MM_reloadPage(init) {  //reloads the window if Nav4 resized

  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {

    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}

  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();

}

MM_reloadPage(true);



function MM_showHideLayers() { //v6.0

  var i,p,v,obj,args=MM_showHideLayers.arguments;

  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];

    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }

    obj.visibility=v; }

}



function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}



function bt(id,after)

{

  eval('document.all["'+id+'"].filters.blendTrans.stop();'); 

  eval('document.all["'+id+'"].filters.blendTrans.Apply();'); 

  eval('document.all["'+id+'"].src="'+after+'";'); 

  eval('document.all["'+id+'"].filters.blendTrans.Play();'); 

}






function cgTab(tName, tCount, tNum) {

	for(i=1;i<=tCount;i++){

		obj = document.getElementById(tName+i);

		if(i != tNum) {

			obj.style.display = 'none';

		}

		else {

			obj.style.display = 'block';

		}

	}

}



//-->



function __ShowEmbedObject(__ELEMENT_ID) {

	document.write( __ELEMENT_ID.innerHTML );

	__ELEMENT_ID.id = "";

}



function __ShowFlash(efile,ewidth,eheight,equality,ename,ewmode)

{

	fval  = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+ ewidth +'" height="'+ eheight +'" id="'+ ename +'">';

	fval += '<param name="movie" value="'+ efile +'">';

	fval += '<param name="quality" value="'+ equality +'">';

	fval += '<param name="wmode" value="'+ ewmode +'">';

	fval += '<param name="base" value=".">';

	fval += '<embed src="'+ efile +'" width="'+ ewidth +'" height="'+ eheight +'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>';

	fval += '</object>';

	

	document.write(fval);

}



function MM_reloadPage(init) {  //reloads the window if Nav4 resized

  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {

    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}

  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();

}

MM_reloadPage(true);



	

function fdiv(f_no) {

        var fdiv_no = "Layer" + f_no;



        if (f_no.length != 2) {

                window.document.all[f_no].style.visibility = "visible";

        }

        else

                window.document.all[fdiv_no].style.visibility = "visible";

}



function hdiv(h_no) {

        var hdiv_no = "Layer" + h_no;

        

        if (h_no.length != 2) {

                window.document.all[h_no].style.visibility = "hidden";

        }

        else

                window.document.all[hdiv_no].style.visibility = "hidden";

}

//ë²„íŠ¼í´ë¦­ì‹œ ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆ ë§žê²Œ íŒì—…ì°½ ëœ¨ëŠ” ì†ŒìŠ¤(ê°¤ëŸ¬ë¦¬ê²Œì‹œíŒ)
/*function showPicture(src) {
  var imgObj = new Image();
  imgObj.src = src;
  var wopt = "scrollbars=no,status=no,resizable=no";
  wopt += ",width=" + imgObj.width;
  wopt += ",height=" + imgObj.height;
  var wbody = "<head><title>ì‚¬ì§„í™•ëŒ€ë³´ê¸°</title>";
  wbody += "<script language='javascript'>";
  wbody += "function finalResize(){";
  wbody += "  var oBody=document.body;";
  wbody += "  var oImg=document.images[0];";
  wbody += "  var xdiff=oImg.width-oBody.clientWidth;";
  wbody += "  var ydiff=oImg.height-oBody.clientHeight;";
  wbody += "  window.resizeBy(xdiff,ydiff);";
  wbody += "}";
  wbody += "</"+"script>";
  wbody += "</head>";
  wbody += "<body onLoad='finalResize()' style='margin:0'>";
  wbody += "<a href='javascript:window.close()'><img src='" + src + "' border=0></a>";
  wbody += "</body>";
  winResult = window.open("about:blank","",wopt);
  winResult.document.open("text/html", "replace");
  winResult.document.write(wbody);
  winResult.document.close();
  return;
}*/

function imgload(src){
	showPicture(src);
}


//ë²„íŠ¼í´ë¦­ì‹œ ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆ ë§žê²Œ íŒì—…ì°½ ëœ¨ëŠ” ì†ŒìŠ¤(ê°¤ëŸ¬ë¦¬ê²Œì‹œíŒ)
function showPicture(src) {

	var g4_charset   = "utf-8";
	var g4_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
	var g4_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;


	var imgObj = new Image();

	if(!src){
		src = "/images/common/board/no_img.jpg";
	}
		imgObj.src = src;

	if(imgObj.width<1 && imgObj.height<1){
		controller = "imgload('"+src+"')";
		intervalID = setTimeout(controller,20);
		return;
	}else{

		var w = imgObj.width; 
		var h = imgObj.height;
	
	}


	var winl = (screen.width-w)/2; 
	var wint = (screen.height-h)/3; 

	if (w >= screen.width) { 
		winl = 0; 
		h = (parseInt)(w * (h / w)); 
	} 

	if (h >= screen.height) { 
		wint = 0; 
		w = (parseInt)(h * (w / h)); 
	} 
  
	var js_url = "<script language='JavaScript1.2'> \n"; 
		js_url += "<!-- \n"; 
		js_url += "var ie=document.all; \n"; 
		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
		js_url += "var isdrag=false; \n"; 
		js_url += "var x,y; \n"; 
		js_url += "var dobj; \n"; 
		js_url += "function movemouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  if (isdrag) \n"; 
		js_url += "  { \n"; 
		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "function selectmouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
		js_url += "  } \n"; 
		js_url += "  if (fobj.className=='dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    isdrag = true; \n"; 
		js_url += "    dobj = fobj; \n"; 
		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
		js_url += "    document.onmousemove=movemouse; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "document.onmousedown=selectmouse; \n"; 
		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
		js_url += "//--> \n"; 
		js_url += "</"+"script> \n"; 

	var settings;

	if (g4_is_gecko) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {
		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 

	win=window.open("","image_window",settings); 

	
	win.document.open(); 
	win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n"); 
	var size = "ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆ : "+w+" x "+h;
	win.document.write ("<title>"+size+"</title> \n"); 
	if(w >= screen.width || h >= screen.height) { 
		win.document.write (js_url); 
		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆê°€ í™”ë©´ë³´ë‹¤ í½ë‹ˆë‹¤. \n ì™¼ìª½ ë²„íŠ¼ì„ í´ë¦­í•œ í›„ ë§ˆìš°ìŠ¤ë¥¼ ì›€ì§ì—¬ì„œ ë³´ì„¸ìš”. \n\n ë”ë¸” í´ë¦­í•˜ë©´ ë‹«í˜€ìš”. '"; 
	} 
	else 
		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n í´ë¦­í•˜ë©´ ë‹«í˜€ìš”. '"; 
	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
	win.document.write ("</head> \n\n"); 
	win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+imgObj.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
	win.document.write ("</body></html>"); 
	win.document.close(); 

	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}


// ì´ë¯¸ì§€ì˜ í¬ê¸°ì— ë”°ë¼ ìƒˆì°½ì˜ í¬ê¸°ê°€ ë³€ê²½ë©ë‹ˆë‹¤.
// zzzzë‹˜ê»˜ì„œ ì•Œë ¤ì£¼ì…¨ìŠµë‹ˆë‹¤. 2005/04/12
function image_window(img)
{

	var g4_charset   = "utf-8";
	var g4_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
	var g4_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;

	var w = img.tmp_width; 
	var h = img.tmp_height; 

	var winl = (screen.width-w)/2; 
	var wint = (screen.height-h)/3; 

	if (w >= screen.width) { 
		winl = 0; 
		h = (parseInt)(w * (h / w)); 
	} 

	if (h >= screen.height) { 
		wint = 0; 
		w = (parseInt)(h * (w / h)); 
	} 

	var js_url = "<script language='JavaScript1.2'> \n"; 
		js_url += "<!-- \n"; 
		js_url += "var ie=document.all; \n"; 
		js_url += "var nn6=document.getElementById&&!document.all; \n"; 
		js_url += "var isdrag=false; \n"; 
		js_url += "var x,y; \n"; 
		js_url += "var dobj; \n"; 
		js_url += "function movemouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  if (isdrag) \n"; 
		js_url += "  { \n"; 
		js_url += "    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n"; 
		js_url += "    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "function selectmouse(e) \n"; 
		js_url += "{ \n"; 
		js_url += "  var fobj      = nn6 ? e.target : event.srcElement; \n"; 
		js_url += "  var topelement = nn6 ? 'HTML' : 'BODY'; \n"; 
		js_url += "  while (fobj.tagName != topelement && fobj.className != 'dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n"; 
		js_url += "  } \n"; 
		js_url += "  if (fobj.className=='dragme') \n"; 
		js_url += "  { \n"; 
		js_url += "    isdrag = true; \n"; 
		js_url += "    dobj = fobj; \n"; 
		js_url += "    tx = parseInt(dobj.style.left+0); \n"; 
		js_url += "    ty = parseInt(dobj.style.top+0); \n"; 
		js_url += "    x = nn6 ? e.clientX : event.clientX; \n"; 
		js_url += "    y = nn6 ? e.clientY : event.clientY; \n"; 
		js_url += "    document.onmousemove=movemouse; \n"; 
		js_url += "    return false; \n"; 
		js_url += "  } \n"; 
		js_url += "} \n"; 
		js_url += "document.onmousedown=selectmouse; \n"; 
		js_url += "document.onmouseup=new Function('isdrag=false'); \n"; 
		js_url += "//--> \n"; 
		js_url += "</"+"script> \n"; 

	var settings;

	if (g4_is_gecko) {
		settings  ='width='+(w+10)+','; 
		settings +='height='+(h+10)+','; 
	} else {
		settings  ='width='+w+','; 
		settings +='height='+h+','; 
	}
	settings +='top='+wint+','; 
	settings +='left='+winl+','; 
	settings +='scrollbars=no,'; 
	settings +='resizable=yes,'; 
	settings +='status=no'; 

	win=window.open("","image_window",settings); 
	win.document.open(); 
	win.document.write ("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n"); 
	var size = "ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆ : "+w+" x "+h;
	win.document.write ("<title>"+size+"</title> \n"); 
	if(w >= screen.width || h >= screen.height) { 
		win.document.write (js_url); 
		var click = "ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n ì´ë¯¸ì§€ ì‚¬ì´ì¦ˆê°€ í™”ë©´ë³´ë‹¤ í½ë‹ˆë‹¤. \n ì™¼ìª½ ë²„íŠ¼ì„ í´ë¦­í•œ í›„ ë§ˆìš°ìŠ¤ë¥¼ ì›€ì§ì—¬ì„œ ë³´ì„¸ìš”. \n\n ë”ë¸” í´ë¦­í•˜ë©´ ë‹«í˜€ìš”. '"; 
	} 
	else 
		var click = "onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n í´ë¦­í•˜ë©´ ë‹«í˜€ìš”. '"; 
	win.document.write ("<style>.dragme{position:relative;}</style> \n"); 
	win.document.write ("</head> \n\n"); 
	win.document.write ("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n"); 
	win.document.write ("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");
	win.document.write ("</body></html>"); 
	win.document.close(); 

	if(parseInt(navigator.appVersion) >= 4){win.window.focus();} 
}

// HTML ë¡œ ë„˜ì–´ì˜¨ <img ... > íƒœê·¸ì˜ í­ì´ í…Œì´ë¸”í­ë³´ë‹¤ í¬ë‹¤ë©´ í…Œì´ë¸”í­ì„ ì ìš©í•œë‹¤.
function resizeBoardImage(imageWidth, borderColor) {

    var content = document.getElementById("DivContents");
    if (content) {
        var target = content.getElementsByTagName("img");
        if (target) {
            var imageHeight = 0;

            for(i=0; i<target.length; i++) { 
                // ì›ëž˜ ì‚¬ì´ì¦ˆë¥¼ ì €ìž¥í•´ ë†“ëŠ”ë‹¤
                target[i].tmpWidth  = target[i].width;
                target[i].tmpHeight = target[i].height;

                //alert(target[i].width);

                // ì´ë¯¸ì§€ í­ì´ í…Œì´ë¸” í­ë³´ë‹¤ í¬ë‹¤ë©´ í…Œì´ë¸”í­ì— ë§žì¶˜ë‹¤
                if(target[i].width > imageWidth) {
                    imageHeight = parseFloat(target[i].width / target[i].height)
                    target[i].width = imageWidth;
                    target[i].height = parseInt(imageWidth / imageHeight);

                    // ìŠ¤íƒ€ì¼ì— ì ìš©ëœ ì´ë¯¸ì§€ì˜ í­ê³¼ ë†’ì´ë¥¼ ì‚­ì œí•œë‹¤
                    target[i].style.width = '';
                    target[i].style.height = '';
                }

                if (borderColor) {
                    target[i].style.borderWidth = '1px';
                    target[i].style.borderStyle = 'solid';
                    target[i].style.borderColor = borderColor;
                }
            }
        }
    }

    var target = document.getElementsByName('target_resize_image[]');
    var imageHeight = 0;

    if (target) {
        for(i=0; i<target.length; i++) { 
            // ì›ëž˜ ì‚¬ì´ì¦ˆë¥¼ ì €ìž¥í•´ ë†“ëŠ”ë‹¤
            target[i].tmp_width  = target[i].width;
            target[i].tmp_height = target[i].height;
            // ì´ë¯¸ì§€ í­ì´ í…Œì´ë¸” í­ë³´ë‹¤ í¬ë‹¤ë©´ í…Œì´ë¸”í­ì— ë§žì¶˜ë‹¤
            if(target[i].width > imageWidth) {
                imageHeight = parseFloat(target[i].width / target[i].height)
                target[i].width = imageWidth;
                target[i].height = parseInt(imageWidth / imageHeight);
                target[i].style.cursor = 'pointer';

                // ìŠ¤íƒ€ì¼ì— ì ìš©ëœ ì´ë¯¸ì§€ì˜ í­ê³¼ ë†’ì´ë¥¼ ì‚­ì œí•œë‹¤
                target[i].style.width = '';
                target[i].style.height = '';
            }

            if (borderColor) {
                target[i].style.borderWidth = '1px';
                target[i].style.borderStyle = 'solid';
                target[i].style.borderColor = borderColor;
            }
        }
    }
}

/*=========SNS ì—°ë™ ê´€ë ¨ ===========*/
function fn_goSNS(site, url, msg, tag, img) {

	var goUrl;

	if (site == "facebook") { 
		goUrl = "http://www.facebook.com/sharer.php?s=100&p[url]=" + encodeURIComponent(url) + "&p[title]=" + encodeURIComponent(msg) + "&p[summary]=" + encodeURIComponent(tag) + "&p[images][0]=" +  encodeURIComponent(img);
	} else if(site == "twitter") { 
		goUrl = "http://twitter.com/home?status=" + encodeURIComponent(msg) + " " + encodeURIComponent(url);
	} else if(site == "me2day") { 
		goUrl = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + " " + encodeURIComponent(url) + "&new_post[tags]=" + encodeURIComponent(tag);
	} else if(site == "yozm") {
		goUrl = "http://yozm.daum.net/api/popup/prePost?link=" + encodeURIComponent(url)+ "&prefix=" + encodeURIComponent(msg) + "&parameter=" + encodeURIComponent(msg);
	}

	var goSNS = window.open(goUrl, site, '');
	goSNS.focus();
}

function sendSns(sns, url, txt)
{
    var o;
    var _url = encodeURIComponent(url);
    var _txt = encodeURIComponent(txt);
    var _br  = encodeURIComponent('\r\n');
 
    switch(sns)
    {
        case 'facebook':
            o = {
                method:'popup',
                url:'http://www.facebook.com/sharer/sharer.php?u=' + _url
            };
            break;
 
        case 'twitter':
            o = {
                method:'popup',
                url:'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
            };
            break;

		default:
            alert('ì§€ì›í•˜ì§€ ì•ŠëŠ” SNSìž…ë‹ˆë‹¤.');
            return false;
    }
 
    switch(o.method)
    {
        case 'popup':
            window.open(o.url);
            break;
 
        case 'web2app':
            if(navigator.userAgent.match(/android/i))
            {
                // Android
                setTimeout(function(){ location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'}, 100);
            }
            else if(navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i))
            {
                // Apple
                setTimeout(function(){ location.href = o.a_store; }, 200);          
                setTimeout(function(){ location.href = o.a_proto + o.param }, 100);
            }
            else
            {
              
			   if(sns == "band"){
			   		window.open("http://www.band.us/plugin/share?body=" + _txt + "&route=" + _url, "share_band", "width=510, height=540, resizable=no"); 
			   }else{
				   alert('ì´ ê¸°ëŠ¥ì€ ëª¨ë°”ì¼ì—ì„œë§Œ ì‚¬ìš©í•  ìˆ˜ ìžˆìŠµë‹ˆë‹¤.');
			   }
            }
            break;
    }
}

//ì´ë©”ì¼ ì •ê·œì‹ì²˜ë¦¬ 
function validateEmail(email) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(email);
}

//ìž…ë ¥ê°’ í™•ì¸ìš© ì •ê·œì‹
function valueChk(val, type) {
	if (type == 1) var reg = /^[0-9]*$/;		//ìˆ«ìžë§Œìž…ë ¥
	else if (type == 2) var reg = /^([0-9]{2,3})-([0-9]{3,4})-([0-9]{4})$/;		//ì¼ë°˜ì „í™”ë²ˆí˜¸
	else if (type == 3) var reg = /^01([0|1|6|7|8|9]?)-([0-9]{3,4})-([0-9]{4})$/;		//í•¸ë“œí°ë²ˆí˜¸
	else if (type == 4) var reg = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;		//ì´ë©”ì¼
	else if (type == 5) var reg = /^[a-zA-Z0-9!@$_-]{5,12}$/		//5~12ìžì˜ ì˜ë¬¸ëŒ€ì†Œë¬¸ìž, ìˆ«ìžì™€ íŠ¹ìˆ˜ê¸°í˜¸(!@$_)ë§Œ ì‚¬ìš©
	else if (type == 6) var reg = /^http[s]?\:\/\//i;		//url í™•ì¸
	return reg.test(val);
}

//3ìžë¦¿ìˆ˜ ì½¤ë§ˆì²˜ë¦¬
function addComma(str) { 
	var input_str = String(str);

	if (input_str == '') return false;
	input_str = parseInt(input_str.replace(/[^0-9]/g, '')).toString();
	if (isNaN(input_str)) { return false; }

	var sliceChar = ',';
	var step = 3;
	var step_increment = -1;
	var tmp  = '';
	var retval = '';
	var str_len = input_str.length;

	for (var i=str_len; i>=0; i--)	{
		tmp = input_str.charAt(i);
		if (tmp == sliceChar) continue;
		if (step_increment%step == 0 && step_increment != 0) retval = tmp + sliceChar + retval;
		else retval = tmp + retval;
		step_increment++;
	}

	return retval;
}

//ë¬¸ìžì—´ ë³€ê²½
function replaceAll(str, searchStr, replaceStr) {
    return str.split(searchStr).join(replaceStr);
}