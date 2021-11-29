<?php
include $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";
$path = $_SERVER["DOCUMENT_ROOT"]."/upload/resume";

//이력서 등록///////////////////////////////////////////////////////////////////////
$applyType = $_POST['applyType'];
$title = "";
$resume_title = "";
$resumeName = "";
$resumeOri = "";
$thumb_up = is_uploaded_file($_FILES['resumeFile']['tmp_name']);
if($thumb_up) {
	$tmp_name = $_FILES['resumeFile']['tmp_name'];
	$name = $_FILES['resumeFile']['name'];

	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("pdf","hwp","doc","docx");

	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		$file_nm = strtolower(array_shift(explode('.',$name)));
		$file_ext = strtolower(array_pop(explode('.',$name)));
		$resume_title = $file_nm;
		$resumeOri = $file_nm.".".$file_ext;
		$resumeName = substr(md5(uniqid($now)),0,8).str_replace('%','',urlencode($file_nm)).".".$file_ext;
		$newPath = $path."/".$resumeName;

		@move_uploaded_file($tmp_name, $newPath);
	}

	//이력서 정보 등록
	$query = "insert into V_Incruit set";
	$query .= " ic_type='".$applyType."', ";
	$query .= " ic_title = '".$resume_title."',";
	$query .= " resume = '".$resumeName."',";
	$query .= " resume_ori = '".$resumeOri."',";
	$query .= " regDt = now()";
	$res = sql_query($query);
	if($res){
		alert("Registered.", "../company/incruit.php");
	}
}
//이력서 등록///////////////////////////////////////////////////////////////////////

alert("This is the wrong path.\\nPlease use after checking.", "../company/incruit.php");
