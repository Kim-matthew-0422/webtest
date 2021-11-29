<?
	include $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";
	include $_SERVER["DOCUMENT_ROOT"]."/admin/lib/sms_function.php";

	if($targets_name == false && $targets_tell == false && strlen($targets_tell) < 11){
		echo "False";
	} else {
		$success_check = "Y";
		$adminphone = explode(",", $default["admin_sms_phone"]);
		$targets_name = iconv("euc-kr","utf-8",$targets_name);

		foreach($adminphone as $phoneval)
		{
			$result = send_sms2($default[site_code], $phoneval, "웨이투온", $default["admin_phone"], "문의가 접수되었습니다. 이름 : ".$targets_name.", 연락처 : ".$targets_tell, str_replace('-', '', $default["admin_phone"]));
			if($reuslt != "ok"){
				$success_check = "N";
			}
		}
		
		if($success_check = "Y"){
			echo "True";
		} else {
			echo "False";
		}
	}
?>