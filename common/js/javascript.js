// ì „ì—­ ë³€ìˆ˜
var errmsg = "";
var errfld;

// í•„ë“œ ê²€ì‚¬
function check_field(fld, msg)
{
    if ((fld.value = trim(fld.value)) == "")
        error_field(fld, msg);
    else
        clear_field(fld);
    return;
}

// í•„ë“œ ì˜¤ë¥˜ í‘œì‹œ
function error_field(fld, msg)
{
    if (msg != "")
        errmsg += msg + "\n";
    if (!errfld) errfld = fld;
    fld.style.background = "#BDDEF7";
}

// í•„ë“œë¥¼ ê¹¨ë—í•˜ê²Œ
function clear_field(fld)
{
    fld.style.background = "#FFFFFF";
}

function trim(s)
{
	var t = "";
	var from_pos = to_pos = 0;

	for (i=0; i<s.length; i++)
	{
		if (s.charAt(i) == ' ')
			continue;
		else
		{
			from_pos = i;
			break;
		}
	}

	for (i=s.length; i>=0; i--)
	{
		if (s.charAt(i-1) == ' ')
			continue;
		else
		{
			to_pos = i;
			break;
		}
	}

	t = s.substring(from_pos, to_pos);
	//				alert(from_pos + ',' + to_pos + ',' + t+'.');
	return t;
}

// ìžë°”ìŠ¤í¬ë¦½íŠ¸ë¡œ PHPì˜ number_format í‰ë‚´ë¥¼ ëƒ„
// ìˆ«ìžì— , ë¥¼ ì¶œë ¥
function number_format(data)
{

    var tmp = '';
    var number = '';
    var cutlen = 3;
    var comma = ',';
    var i;

    len = data.length;
    mod = (len % cutlen);
    k = cutlen - mod;
    for (i=0; i<data.length; i++)
	{
        number = number + data.charAt(i);

        if (i < data.length - 1)
		{
            k++;
            if ((k % cutlen) == 0)
			{
                number = number + comma;
                k = 0;
			}
        }
    }

    return number;
}

// ìƒˆ ì°½
function popup_window(url, winname, opt)
{
    window.open(url, winname, opt);
}

/*** window.popup.open ***/
/*** sms ê´€ë¦¬ ì¶”ê°€ ë  í•¨ìˆ˜ ***/
function popup(src,width,height) {
	var scrollbars = "1";
	var resizable = "no";
	if (typeof(arguments[3])!="undefined") scrollbars = arguments[3];
	if (arguments[4]) resizable = "yes";
	window.open(src,'popup','width='+width+',height='+height+',scrollbars='+scrollbars+',toolbar=no,status=no,resizable='+resizable+',menubar=no');
}
/*** sms ê´€ë¦¬ ì¶”ê°€ ë  í•¨ìˆ˜ End ***/


// í¼ë©”ì¼ ì°½
function popup_formmail(url)
{
	opt = 'scrollbars=yes,width=417,height=385,top=10,left=20';
	popup_window(url, "wformmail", opt);
}

// , ë¥¼ ì—†ì•¤ë‹¤.
function no_comma(data)
{
	var tmp = '';
    var comma = ',';
    var i;

	for (i=0; i<data.length; i++)
	{
		if (data.charAt(i) != comma)
		    tmp += data.charAt(i);
	}
	return tmp;
}

// ì‚­ì œ ê²€ì‚¬ í™•ì¸
function del(href)
{
    if(confirm("í•œë²ˆ ì‚­ì œí•œ ìžë£ŒëŠ” ë³µêµ¬í•  ë°©ë²•ì´ ì—†ìŠµë‹ˆë‹¤.\n\nì •ë§ ì‚­ì œí•˜ì‹œê² ìŠµë‹ˆê¹Œ?"))
        document.location.href = href;
}

// ì¿ í‚¤ ìž…ë ¥
function set_cookie(name, value, expirehours)
{
	var today = new Date();
	today.setTime(today.getTime() + (60*60*1000*expirehours));
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// ì¿ í‚¤ ì–»ìŒ
function get_cookie(name)
{
    var find_sw = false;
    var start, end;
    var i = 0;

	for (i=0; i<= document.cookie.length; i++)
	{
		start = i;
		end = start + name.length;

		if(document.cookie.substring(start, end) == name)
		{
			find_sw = true
			break
		}
	}

    if (find_sw == true)
	{
        start = end + 1;
        end = document.cookie.indexOf(";", start);

        if(end < start)
            end = document.cookie.length;

        return document.cookie.substring(start, end);
    }
    return "";
}

// ì¿ í‚¤ ì§€ì›€
function delete_cookie(name)
{
	var today = new Date();

	today.setTime(today.getTime() - 1);
	var value = getCookie(name);
	if(value != "")
		document.cookie = name + "=" + value + "; path=/; expires=" + today.toGMTString();
}

// a íƒœê·¸ì—ì„œ onclick ì´ë²¤íŠ¸ë¥¼ ì‚¬ìš©í•˜ì§€ ì•Šê¸° ìœ„í•´
function winopen(url, name, option)
{
    window.open(url, name, option);
    return ;
}

// TEXTAREA ì‚¬ì´ì¦ˆ ë³€ê²½
function textarea_size(fld, size)
{
	var rows = parseInt(fld.rows);

	rows += parseInt(size);
	if (rows > 0) {
		fld.rows = rows;
	}
}

var old='';
function menu(name){

	submenu=eval(name+".style");

	if (old!=submenu)
	{
		if(old!='')
		{
			old.display='none';
		}
		submenu.display='block';
		old=submenu;
	}
	else
	{
		submenu.display='none';
		old='';
	}
}

////////////////////////////// íŽ˜ì´ì§€ì—´ê¸° /////////////////////////////////
function Win_Open(page,value,style){
	window.open(page+value,"OpenWin",style).focus();
}

/// ì„ íƒí˜• ì´ë©”ì¼ ìž…ë ¥í¼ ìŠ¤í¬ë¦½íŠ¸
	function Email_Select(OBJC,form) {
		if(OBJC.options[OBJC.selectedIndex].value=="") {
			form.email_url.value="ìž…ë ¥í•˜ì„¸ìš”";
			form.email_url.disabled=false;
		} else {
			form.email_url.value=OBJC.options[OBJC.selectedIndex].value;
			form.email_url.disabled=true;
		}
	}

//ì§€ì—­ì„ íƒ íŒì—…
function SAddress(form,target){
	window.open("/member/pop_area.php?form="+form+"&target="+target,"SAddress","width=500,height=180").focus();
}

function checknum(obj){
	var num = escape(obj.value);
	if(num.length > 0){
		if(num.match(/^\d+$/ig)==null){
			alert("ìˆ«ìžë§Œ ìž…ë ¥ê°€ëŠ¥í•©ë‹ˆë‹¤.");
			obj.value = "";
			obj.focus();
			return;
		}
	}
}

///íƒìŠ¤íŠ¸ í•„ë“œì—ì„œ ìˆ«ìžì™€ ,ë§Œ ì‚¬ìš©ê°€ëŠ¥í•˜ê²Œ í•¨
function numOnly(obj,isCash) {
	//ì‚¬ìš©ì˜ˆ : <input type="text" name="text" onKeyUp="javascript:numOnly(this,true);">
	//ì„¸ìžë¦¬ ì½¤ë§ˆ ì‚¬ìš©ì‹œ true , ìˆ«ìžë§Œ ìž…ë ¥ ì‹œ false
	event = window.event;
	if (event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39) return;
	var returnValue = "";
	for (var i = 0; i < obj.value.length; i++){
		if (obj.value.charAt(i) >= "0" && obj.value.charAt(i) <= "9") returnValue += obj.value.charAt(i);
		else returnValue += "";
	}

	if (isCash){
		obj.value = cashReturn(returnValue);
		return;
	}

	obj.focus();
	obj.value = returnValue;
}

function cashReturn(numValue){
	//numOnlyí•¨ìˆ˜ì— ë§ˆì§€ë§‰ íŒŒë¼ë¯¸í„°ë¥¼ trueë¡œ ì£¼ê³  numOnlyë¥¼ ë¶€ë¥¸ë‹¤.
	var cashReturn = "";
	for (var i = numValue.length-1; i >= 0; i--){
		cashReturn = numValue.charAt(i) + cashReturn;
		if (i != 0 && i%3 == numValue.length%3) cashReturn = "," + cashReturn;
	}
	return cashReturn;
}


///íƒìŠ¤íŠ¸ í•„ë“œì— í•œê¸€ ìž…ë ¥ ì²˜ë¦¬
function ketKorean(msg) {
	if((event.keyCode < 12592) || (event.keyCode > 12687))
	alert("í•œê¸€ë§Œ ìž…ë ¥ ë©ë‹ˆë‹¤")
	event.returnValue = false
}

///íƒìŠ¤íŠ¸ í•„ë“œì— í•œê¸€ ì²˜ë¦¬
function isKorean(field){
	var chk;
	var chk2 = 0;
	var strLength = field.value.length
	for(i = 0 ; i < strLength ; i++){
		chk = field.value.charCodeAt(i)
		if((chk >= 44032 && chk <= 55203)){	}
		else {
			alert('í•œê¸€ë§Œ ìž…ë ¥í•  ìˆ˜ ìžˆìŠµë‹ˆë‹¤.');
			return false;
		}
	}
}

//íƒìŠ¤íŠ¸ í•„ë“œì— ì˜ì–´ì™€ ìˆ«ìžë§Œ í—ˆìš©
function isEnglish(field){
	var chk;
	var chk2 = 0;
	var strLength = field.value.length
	for(i = 0 ; i < strLength ; i++){
		chk = field.value.charCodeAt(i)
		if((chk >= 97 && chk <= 122) || (chk >= 48 && chk <= 57) || chk == 95){	}
		else {
			alert('a~z , 0~9 ë§Œ ìž…ë ¥í•  ìˆ˜ ìžˆìŠµë‹ˆë‹¤.');
			return false;
		}
	}
}

///ê¸¸ì´ ì²´í¬
function strLen(field,min,max) {
	if(field.value.length < min) {
		alert(min + "ìž ì´ìƒ ìž…ë ¥í•˜ì‹œê¸° ë°”ëžë‹ˆë‹¤.");
		field.focus();
		return false;
	}

	if(max != '') {
		if(field.value.length > max) {
			alert(min + "ìž ì´ìƒ " + max + "ìž ì´í•˜ ìž…ë ¥í•˜ì‹œê¸° ë°”ëžë‹ˆë‹¤.");
			field.focus();
			return false;
		}
	}

	return true;
}


///ìŠ¤í¬ë¦½íŠ¸ í•„ë“œ ì²´í¬
function chkStr(field,msg) {
	if(field.value =="") {
		alert(msg);
		field.focus();
		return false;
	}
	return true;
}

// ìŠ¤í¬ë¦½íŠ¸ ë¼ë””ì˜¤ ì²´í¬
function ridiaChk(v,meg){
	for (i=0;i<v.length;i++){if(v[i].checked==true){return true}};
	alert(meg);v[0].focus();return false;
}

///ìŠ¤í¬ë¦½íŠ¸ ë°°ì—´ ì²´í¬
function chkArr(field,msg) {
	var cnt = 0;
	for(var i=0;i<field.length;i++) if(field[i].checked == true) cnt++;

	if(cnt == 0) {
		alert(msg);
		field[0].focus();
		return false;
	}
	return true;
}

///Email ì²´í¬
function chkMail(email) {
	if (!email.value){
		alert("Email ì£¼ì†Œë¥¼ ìž…ë ¥í•´ ì£¼ì„¸ìš”.");
		email.value = "";
		email.focus();
		return false;
	}

	if (email.value.indexOf("http") >= 0 ) {
		alert ('http://ëŠ” ì˜¬ë°”ë¥¸ ì „ìžìš°íŽ¸ ì£¼ì†Œê°€ ì•„ë‹™ë‹ˆë‹¤.');
		email.focus();
		return false;
	}
	if (email.value.indexOf("@") <= 0 ) {
		alert ('Email ì£¼ì†Œì— @(ê³¨ë±…ì´)ê°€ ë¹ ì¡ŒìŠµë‹ˆë‹¤.');
		email.focus();
		return false;
	}
	if (email.value.indexOf(".") <= 0 ) {
		alert ('ì˜¬ë°”ë¥¸ ì „ìžìš°íŽ¸ ì£¼ì†Œê°€ ì•„ë‹™ë‹ˆë‹¤.');
		email.focus();
		return false;
	}
	return true;
}

function chkDel(url) {
	yes_no = confirm('ì‚­ì œí•˜ì‹œê² ìŠµë‹ˆê°€?');
	if(yes_no == true) { // í™•ì¸ ì„ íƒí•´ í–ˆì„ë•Œ
		location.href=url;
	}
}

//ENTER ì•ˆë¨¹ê²Œ í•˜ëŠ”ê²ƒ
function captureReturnKey(e) {
	if(e.keyCode==13 && e.srcElement.type != 'textarea')
	return false;
}

//ìš°íŽ¸ë²ˆí˜¸ ê²€ìƒ‰
function autoAddress(target1,target2,target3,form){
	window.open("/member/pop_address.php?form="+form+"&target1="+target1+"&target2="+target2+"&target3="+target3,"autoAddress","width=500,height=280").focus();
}
//ìš°íŽ¸ë²ˆí˜¸ ê²€ìƒ‰
function NewautoAddress(target1,target2,target3,form){
	window.open("/member/pop_new_address.php?form="+form+"&target1="+target1+"&target2="+target2+"&target3="+target3,"autoAddress","width=500,height=300").focus();
}

//ì—°ë½ì²˜ ì²´í¬
function IsKRPhoneNumber(strNumber){
	var bRetNo;
	bRetNo = false;
	if(isNaN(strNumber) == false && (strNumber.length >= 2 && strNumber.length <=4)){
		bRetNo = true;
	}
	return bRetNo;
}

//ì´ë¯¸ì§€ ë¡¤ ì˜¤ë²„
// ì´ë¶€ë¶„ì€ ìˆ˜ì •í•  í•„ìš”ì—†ìŠµë‹ˆë‹¤.
var cnj_str=new Array();
function Rollover(imgName, imgSrc){
	cnj_str[imgName] = new Image();
	cnj_str[imgName].src = imgSrc;
}
function turnOn(imgName) {
		document.images[imgName].offSrc = document.images[imgName].src;
		document.images[imgName].src    = cnj_str[imgName].src;
}
function turnOff(imgName){
		document.images[imgName].src = document.images[imgName].offSrc;
	}
// ì´ë¶€ë¶„ê¹Œì§€ ìˆ˜ì •í•  í•„ìš”ì—†ìŠµë‹ˆë‹¤.

// ì‚¬ì§„ë¯¸ë¦¬ë³´ê¸°
function PhotoView(form)
{
	if (form.photo.value) {
		form.myphoto.src = form.photo.value;
	}
}

////////////////////////////// í”Œëž˜ì‰¬ ë¼ì¸ì„ ì—†ì• ê¸° ìœ„í•´ /////////////////////////////////
function cfShowEmbedObject(elementId){
 document.write(elementId.text);

 // ë™ì¼í•œ IDë¥¼ ì‚¬ìš©í•˜ê¸° ìœ„í•´ ë‹¤ì‹œ elementID ë¥¼ ì´ˆê¸°í™”
 elementId.id = "";
}

function TextBoxObject(id) {
	document.write(document.getElementById(id).value);
}

////////////////////////////// ë¦¬ìŠ¤íŠ¸ ì²´í¬ /////////////////////////////////
function List_Checked_Box(form,sw) {

    for (var i=0; i<form.length; i++) {
        if (form.elements[i].name == "list_ck[]")
            form.elements[i].checked = sw;
    }
}
function List_Checked_Sel(form,box) {
	if (box.checked) {
		List_Checked_Box(form,true);
	} else {
		List_Checked_Box(form,false);
	}
}


////////////////////////////// ì„¸ê¸ˆê³„ì‚°ì„œ íŒì—… /////////////////////////////////
function TaxPaper_Print(value,type){
	window.open("/bill/bill_print.php?type="+type+"&id="+value,"Bill_Print","width=405,height=380, scrollbars=1").focus();
}

////////////////////////////// ì„¤ë¬¸ì¡°ì‚¬ íŒì—… /////////////////////////////////
function Open_Poll(url)
{
	if (!url)
		url = "";
	window.open(url, "OpenPoll", "left=50, top=50, width=616, height=500, scrollbars=1");
}

////////////////////////////// ìª½ì§€ íŒì—… /////////////////////////////////
function My_memo(id) {
	var window_left = (screen.width-510)/2;
	var window_top = (screen.height-450)/2;
	if(id) {
		window.open('/member/memo_form.php?id='+id,'memo',"width=500,height=500,status=no,top=" + window_top + ",left=" + window_left);
	} else {
		window.open('/member/memo.php','memo',"width=500,height=500,status=no,top=" + window_top + ",left=" + window_left);
	}
}

////////////////////////////// ìºì‰¬ê²°ì œì°½ íŒì—… /////////////////////////////////
function cash_save(value){
	window.open("/cash/mycash_save.php?pay_type="+value,"cash_save","width=405,height=380").focus();
}

////////////////////////////// ì•„ì´ë””/ë¹„ë²ˆ ê²€ìƒ‰ íŒì—… /////////////////////////////////
function id_search() {
	var window_left = (screen.width-510)/2;
	var window_top = (screen.height-220)/2;
	window.open('/member/pop_search.php','ID_PW_SEARCH',"width=420,height=220,status=no,top=" + window_top + ",left=" + window_left);
}
////////////////////////////// íšŒì›ì •ë³´ ì „ìš© ìŠ¤í¬ë¦½íŠ¸ /////////////////////////////////
function Break_member(){
	yes_no = confirm('íƒˆí‡´í•˜ì‹œë©´ ê°™ì€ ì•„ì´ë””ë¡œëŠ” ë‹¤ì‹œ ê°€ìž…í•˜ì‹¤ ìˆ˜ ì—†ìŠµë‹ˆë‹¤.\n\níƒˆí‡´ í•˜ì‹œê² ìŠµë‹ˆê¹Œ?');
	if(yes_no == true) { // í™•ì¸ ì„ íƒí•´ í–ˆì„ë•Œ
		window.open("/member/pop_pass.php","autoAddress","width=420,height=200,status=yes").focus();
	}
}

function autoSearch(target1,form,type){
window.open("/member/pop_check.php?type="+type+"&form="+form+"&target1="+target1,"autoAddress","width=420,height=250,scrollbars=no").focus();
}

//ì£¼ë¯¼ë“±ë¡ë²ˆí˜¸ ì²´í¬
function chkSsn(ssn1,ssn2) {
	//ì£¼ë¯¼ë²ˆí˜¸ ì²´í¬
	if (chkStr(ssn1,"ì£¼ë¯¼ë²ˆí˜¸ ì•žìžë¦¬ 6ìžë¥¼ ìž…ë ¥í•˜ì„¸ìš”.") ==false) return false;
	if(strLen(ssn1,6,'') == false) return false;
	if (chkStr(ssn2,"ì£¼ë¯¼ë²ˆí˜¸ ì•žìžë¦¬ 7ìžë¥¼ ìž…ë ¥í•˜ì„¸ìš”.") ==false) return false;
	if(strLen(ssn2,7,'') == false) return false;

	var reginum = ssn1.value.concat(ssn2.value);
	var weight = '234567892345'; // ìžë¦¬ìˆ˜ weight ì§€ì •
	var len = reginum.length;
	var sum = 0;

	if (len != 13) {
		ssn1.value='';
		ssn2.value='';
		ssn1.focus();
		return false;
	}

	for (var i = 0; i < 12; i++) sum = sum + (reginum.substr(i,1)*weight.substr(i,1));

	var rst = sum%11;
	var result = 11 - rst;

	if (result == 10) result = 0;
	else if (result == 11) result = 1;

	var jumin = reginum.substr(12,1);

	if (result != jumin) {
		ssn1.value='';
		ssn2.value='';
		ssn1.focus();
		return false;
	} else {
		return true;
	}
}

// ë¡œê·¸ì¸ í•„ë“œ ì²´í¬
function login_chk(form)
{
	if(!form.mb_id.value) {
		alert('ì•„ì´ë””ë¥¼ ìž…ë ¥í•´ì£¼ì„¸ìš”.');
		form.mb_id.focus();
		return false;
	}

	if(!form.mb_pass.value) {
		alert('ë¹„ë°€ë²ˆí˜¸ë¥¼ ìž…ë ¥í•´ì£¼ì„¸ìš”.');
		form.mb_pass.focus();
		return false;
	}

	if(strLen(form.mb_pass,0,8) == false) {
		form.mb_pass.value='';
		form.mb_pass.focus();
		return false;
	}

    form.action = "/member/login.php";
    form.submit();
}

////////////////////////////// íŽ˜ì´ì§€ ì¼ë¶€ í”„ë¦°íŠ¸ ìŠ¤í¬ë¦½íŠ¸ ì—¬ê¸°ë¶€í„° /////////////////////////////////
function printDiv () {
	if (document.all && window.print) {
		window.onbeforeprint = beforeDivs;
		window.onafterprint = afterDivs;
		window.print();
	}
}

function beforeDivs () {
	if (document.all) {
		objContents.style.display = 'none';
		objSelection.innerHTML = document.all['d1'].innerHTML;
	}
}

function afterDivs () {
	if (document.all) {
		objContents.style.display = 'block';
		objSelection.innerHTML = "";
	}
}

function doPrint(frame){
	printDiv('d1');
//	factory.printing.Print(false, frame);
}
////////////////////////////// íŽ˜ì´ì§€ ì¼ë¶€ í”„ë¦°íŠ¸ ìŠ¤í¬ë¦½íŠ¸ ì—¬ê¸°ê¹Œì§€ /////////////////////////////////

// request ê°ì²´ ìƒì„±
var AJ_Value = null;

function Get_Request() {
	if(window.ActiveXObject) {
		try
		{
			return new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e1)
			{
				return null;
			}
		}
	} else if(window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else {
		return null;
	}
}


function nextFocus(sFormName,sNow,sNext){
	var sForm = 'document.'+ sFormName +'.'
	var oNow = eval(sForm + sNow);
	if (typeof oNow == 'object'){
		if ( oNow.value.length == oNow.maxLength){
			var oNext = eval(sForm + sNext);
			if ((typeof oNext) == 'object') oNext.focus();
		}
	}
}

//2009.3.24 Ki-hong Park

function iframe_autoresize(arg) {
arg.height =
eval(arg.name+".document.body.scrollHeight");
}

//byteì²´í‚¹
function updateChar(FieldName, contentName, textlimitName){
		var strCount = 0;
		var tempStr, tempStr2;
		var frm = document.getElementById(contentName);
		var size = frm.value.length;
		for(i = 0;i < size;i++)
		{
			tempStr = frm.value.charAt(i);
			if(escape(tempStr).length > 4) strCount += 2;
				else strCount += 1 ;
		}
		if (strCount > FieldName){
			alert("ìµœëŒ€ " + FieldName + "byteì´ë¯€ë¡œ ì´ˆê³¼ëœ ê¸€ìžìˆ˜ëŠ” ìžë™ìœ¼ë¡œ ì‚­ì œë©ë‹ˆë‹¤.");
			strCount = 0;
			tempStr2 = "";
			for(i = 0; i < size; i++)
			{
				tempStr = frm.value.charAt(i);
				if(escape(tempStr).length > 4) strCount += 2;
				else strCount += 1 ;
				if (strCount > FieldName)
				{
					if(escape(tempStr).length > 4) strCount -= 2;
					else strCount -= 1 ;
					break;
				}
				else tempStr2 += tempStr;
			}
			frm.value = tempStr2;
		}
		//document.getElementById(textlimitName).innerHTML = strCount;
}


var Admchkboxchk = 0;
function getListCheck(obj){
	if(obj.checked == true) Admchkboxchk = 0;
	if(obj.checked == false) Admchkboxchk = 1;

	if(document.all.list_seq){
		var chk = document.all.list_seq;
		if(chk[0]){
			for(var i=0; i<chk.length; i++){
				if(Admchkboxchk == 0){
					chk[i].checked = true;
				}else{
					chk[i].checked = false;
				}
			}
		}else{
			if(Admchkboxchk == 0){
				chk.checked = true;
			}else{
				chk.checked = false;
			}
		}
	}
}


function getListCheckBoxChecked(){
	var AdmListChkCnt = 0;
	if(document.all.list_seq){
		var chk = document.all.list_seq;
		if(chk[0]){
			for(var i=0; i<chk.length; i++){
				if(chk[i].checked == true) AdmListChkCnt++;
			}
		}else{
			if(chk.checked == true) AdmListChkCnt++;
		}
	}

	return AdmListChkCnt;
}

function getListModify(f){
	if(getListCheckBoxChecked() == 0){
		alert("ìˆ˜ì •í•˜ì‹¤ í•­ëª©ì„ ì„ íƒí•˜ì„¸ìš”!");
		return;
	}
	if(confirm("ì„ íƒí•˜ì‹  í•­ëª©ì„ ìˆ˜ì •í•˜ì‹œê² ìŠµë‹ˆê¹Œ?")){
		f.mode.value = "LE";
		f.submit();
	}
}

function getListDelete(f){
	if(getListCheckBoxChecked() == 0){
		alert("ì‚­ì œí•˜ì‹¤ í•­ëª©ì„ ì„ íƒí•˜ì„¸ìš”!");
		return;
	}
	if(confirm("ì„ íƒí•˜ì‹  í•­ëª©ì„ ì‚­ì œí•˜ì‹œê² ìŠµë‹ˆê¹Œ?")){
		f.mode.value = "LD";
		f.submit();
	}
}

function getMemberDelete(f){
	if(getListCheckBoxChecked() == 0){
		alert("ì‚­ì œí•˜ì‹¤ í•­ëª©ì„ ì„ íƒí•˜ì„¸ìš”!");
		return;
	}
	if(confirm("ì„ íƒí•˜ì‹  í•­ëª©ì„ ì‚­ì œí•˜ì‹œê² ìŠµë‹ˆê¹Œ?")){
		f.mode.value = "LX";
		f.submit();
	}
}

//í¼ì²´í¬
function getFrmElementValueChk(f){
	for(var i=0; i<f.length; i++){
		var obj = f[i];
		if(obj.getAttribute("required") == "true"){
			if(!obj.value){
				alert(obj.title);
				obj.focus();
				return false;
			}
		}
	}
	return true;
}

//iframe layer ìˆ¨ê¸°ê¸°
function getCloseIframeLayer(i){
	parent.xf[i].hide();
	parent.xf[i] = null;
}

// Ajax Component
function getAjaxRequest(url,para,icond) {

	var ReturnValue = "";
	var url = url;
	var myAjax = new Ajax.Request(
	url,
	{
		method: 'post',
		asynchronous: false,
		parameters: para,
		onComplete: function(req) { ReturnValue = req.responseText; }

	});

	return ReturnValue;
}


function nowDisplay(eventer,obj)
{
	var nowdatetime = new Date()
	//í˜„ìž¬ ì‹œê°„ êµ¬í•˜ê¸°
	var y = getSprintf(nowdatetime.getYear());
	var m = getSprintf((nowdatetime.getMonth()+1));
	var d = getSprintf(nowdatetime.getDate());
	var h = getSprintf(nowdatetime.getHours());
	var n = getSprintf(nowdatetime.getMinutes());
	var s = getSprintf(nowdatetime.getSeconds());

	// ì‹œê°„ ë¬¸ìžì—´ ì™„ì„±
	nowTime = y+"-"+m+"-"+d+" "+h+":"+n+":"+s;
	if(eventer.checked == true) obj.value = nowTime;
	else obj.value = "";
}

function chkBox(obj){
	var ret = document.getElementsByName(obj);
	for (var i=0;i<ret.length;i++){
		ret[i].checked = (ret[i].checked==true) ? false : true;
	}
}

function chkBoxTrue(fm){
	var obj = document.getElementsByName('chk[]');
	var chk = false;
	for (var i=0;i<obj.length;i++){
		if (obj[i].checked == true) chk = true;
	}

	if (chk == false){
		alert("ì„ íƒëœ ì‚¬í•­ì´ ì—†ìŠµë‹ˆë‹¤");
		return false;
	}

	return true;
}

function chgEmail(val,obj){
	var ret = document.getElementsByName(obj)[1];
	ret.value = val;
}

function Board_Delete_Check(){

}

jQuery(function($) {

  inView('.an').on('enter', function(el) { $(el).addClass('in'); });

  inView('.xn').on('enter', function(el) { $(el).closest('article').find('.a-image').removeClass('out').addClass('in'); });
  inView('.xn').on('exit', function(el) { $(el).closest('article').find('.a-image').removeClass('in').addClass('out'); });
  inView('.xn').on('enter', function(el) { $(el).closest('article').find('.a-image-sm').removeClass('out').addClass('in'); });
  inView('.xn').on('exit', function(el) { $(el).closest('article').find('.a-image-sm').removeClass('in').addClass('out'); });

});
