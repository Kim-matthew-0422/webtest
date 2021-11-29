<?
include_once $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/admin/sms/function.php";


if($_POST['mode']=='send'){
	$_POST["sendUserList"] = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
	$_POST["s_hp"] = $default["ex1"];
	$_POST['smsText'] = $_POST['message'];
	$_POST['send_date'] = date("Y-m-d");
	$_POST['RtimeH'] = date("H");
	$_POST['RtimeI'] = date("i");

	$tmpsp = @explode("\n",$_POST["sendUserList"]);
	$tmpid = @explode(",",$_POST["userid"]);
	for($i=0; $i<count($tmpsp); $i++){
		$tmpsp[$i] = str_replace("\n","",$tmpsp[$i]);
		$tmpsp[$i] = str_replace("\r","",$tmpsp[$i]);
		$tmpsp[$i] = str_replace(" ","",$tmpsp[$i]);
		if($tmpsp[$i]) $resp[] = $tmpsp[$i];
		if($tmpid[$i]) $reid[] = $tmpid[$i];
	}
	$rphone = @implode(",",$resp);
	$sphone = @explode("-",$_POST["s_hp"]);

	$tmprdate = str_replace("-","",$_POST['send_date']);
	$tmprtime = $_POST['RtimeH']."".$_POST['RtimeI']."00";

	if($_POST["sendType"] == 1){
		$rdate = $tmprdate;
		$rtime = $tmprtime;
		$reser_date = $tmprdate." ".$tmprtime;
	}
	$send_date = $tmprdate." ".$tmprtime;

	$SMS = new sms($default["buyer_code"]);
	for($i=0; $i<count($resp); $i++){
		//getSmsSend($sphone,$rphone,$msg,$rdate,$rtime)
		$SMS->getSmsSend($sphone,$resp[$i],$reid[$i],$_POST['smsText'],$send_date,$rdate,$rtime);
	}

	if($nointeractive=="1" && ($Result!="success" && $Result!="Test Success!" && $Result!="reserved")){
		//echo "<script>alert('".$alert ."')</script>";
	}else if($nointeractive!="1") {
		//echo "<script>alert('".$alert ."')</script>";
	}
	echo "<script>
			alert('담당자에 문의내용을 전송하였습니다.');
		  </script>";
}
?>