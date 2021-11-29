<?
include_once "../head.lib.php";

if(!$num||!$cnum) echo "<script>alert('잘못된 경로입니다.');parent.location.reload();getCloseIframeLayer(0);</script>";
$BoardSql = " select* from {$V_DB[bbsconfig]} where dbname = '$tbl' ";
$Board_Admin = sql_fetch($BoardSql);

$BB_table = $V_DB["bbsitem"].$tbl;
$BC_table = $V_DB["bbscomm"].$tbl;

$row = sql_fetch("select * from $BC_table where c_bno='$num' and c_no='$cnum'");

if($_POST[mode]=="MODIFY"){
	if($Get_Login && ($sess[userid] == $row[c_member] || $sess[userlevel] == 100)){
		sql_query("update $BC_table set c_content='".addslashes($c_content)."' where c_no='$cnum' ");
		echo "<script>alert('수정되었습니다.');parent.location.reload();getCloseIframeLayer(0);</script>";
		exit;
	}else{
		if($row[c_passwd] == sql_password($passwd)){
			sql_query("update $BC_table set c_writer='".$c_writer."', c_content='".addslashes($c_content)."' where c_no='$cnum' ");
			echo "<script>alert('수정되었습니다.');parent.location.reload();getCloseIframeLayer(0);</script>";
			exit;
		}else{
			alert('비밀번호가 일치하지 않습니다.');
			exit;
		}
	}
}

if($row[c_content]==""){
	echo "<script>alert('비정상적인 접근입니다.');parent.location.reload();getCloseIframeLayer(0);</script>";
}

// 게시판 설정 내용 변수를 설정합니다.
if($Board_Admin["width"] <=100) $Board_Admin["width"] = $Board_Admin["width"]."%";
// 페이지 코드를 설정해줍니다.
if($Board_Admin["page_loc"] == TRUE) $page_loc = $Board_Admin["page_loc"]; else $page_loc = "bbs";
$Board_Admin["skin_dir"] = "../skin/bbs/{$Board_Admin[skin]}";

include $Board_Admin["skin_dir"]."/comment_form.skin.php";

include_once "../foot.lib.php";
?>