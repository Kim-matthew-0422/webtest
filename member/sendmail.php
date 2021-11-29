<?php
include $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";

//빠른문의 메일발송
$to = $_POST["name"];
$Receiver = $default["admin_email"];
$fname = $default["site_name"];
$fmail = "webmaster@".str_replace("www.","",$_SERVER[HTTP_HOST]);
$subject = $to."Request for consultation has been successful.";

ob_start();
if($skin == 2){
	$SkinFile = "counsel_mail.skin2.php";
}else{
	$SkinFile = "counsel_mail.skin.php";
}

include $_SERVER["DOCUMENT_ROOT"]."{$G_member[skin_url]}/".$SkinFile;
$content = ob_get_contents();
ob_end_clean();

mailer($fname, $fmail, $Receiver, $subject, $content, 1);

?>
<script type="text/javascript">
<!--
	alert("Consultation inquiry has been received. The administerator will contact you as soon as possible.");
	parent.MnMailFrm.reset();
//-->
</script>
