<?php
$SNB = "bbs";
//게시판설치폴더 설정일경우
if(!empty($chr))
{
	$chr_path="/${chr}";
}

//head.lib 모바일 체크 (0802 백지훈)
if($_COOKIE["mobile_chk"]=="1"){
	include "../../head.lib.php";
}else{
	include "../../head.lib.php";
}
	include "../admin/plugin/naver_blog/lib/function.php";
//if($mode != "PASS")
//else include_once $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";

if($_GET[bl]) $_GET[tbl] = $_GET[bl];

if($_GET[tbl]==TRUE) {
	$Table = $_GET[tbl];
	$tbl = $_GET[tbl] = "";
} else {
	alert("게시판 테이블이 설정되지 않았습니다.","/main.php");
}

$BB_table = $V_DB["bbsitem"].$Table;
$BC_table = $V_DB["bbscomm"].$Table;

// 게시판 설정 내용을 불러옵니다.
$BoardSql = " select* from {$V_DB[bbsconfig]} where dbname = '$Table' ";
$Board_Admin = sql_fetch($BoardSql);

$cururl = $Board_Admin[title];

if($Board_Admin["dbname"]==FALSE) {
	alert("잘못된 게시판 테이블명입니다.",$default[AbsoluteUrl]."/main.php");
}
if($Board_Admin["view"]==FALSE) {
	alert("사용할 수 없는 게시판입니다.",$default[AbsoluteUrl]."/main.php");
}

// 게시판 설정 내용 변수를 설정합니다.
if($Board_Admin["width"] <=100) $Board_Admin["width"] = $Board_Admin["width"]."%";
else $Board_Admin["width"] = $Board_Admin["width"]."px";
// 페이지 코드를 설정해줍니다.
if($Board_Admin["page_loc"] == TRUE) $page_loc = $Board_Admin["page_loc"]; else $page_loc = "bbs";


//skin_dir 모바일 체크 (0802 백지훈)
if($_COOKIE["mobile_chk"]=="1"){
	$Board_Admin["skin_dir"] = $default[AbsoluteUrl]."/skin_mobile/bbs/".$Board_Admin[m_skin];
}else{
	$Board_Admin["skin_dir"] = $default[AbsoluteUrl]."/skin/bbs/".$Board_Admin[skin];
}

// 리스트 출력 순서를 조절합니다.
if (!$sort1){
	$List_Order = "order by b_notice desc, b_tno desc, b_dep asc, b_no desc, b_regist desc";
}else{
	if($Board_Admin["use_reply"]){
		$List_Order = "order by b_notice desc, b_tno desc, b_dep asc, b_no desc, b_regist desc";
	}else{
		$List_Order = "order by b_notice desc, $sort1 $sort2";
	}
}

$Comm_Order = " order by c_regist desc";

if(isset($findWord))  $findWord =  urlencode($findWord); // search field (검색 필드)
// 주소 변수 / 다음페이지 설정
$NextUrl = "chr=$chr&amp;category=$category&amp;findType=$findType&amp;findWord=$findWord&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

// 링크 변수를 설정합니다.
$Url["list"] = ($sess["userlevel"] >= $Board_Admin["level_list"]) ? $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl" : "";
$Url["write"] = ($sess["userlevel"] >= $Board_Admin["level_write"]) ? $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=WRITE&amp;$NextUrl" : "";
$Url["admin"] = ($sess["userlevel"] ==100) ? $default[AbsoluteUrl]."/admin/bbs/bbs_form.php?mode=E&amp;id={$Board_Admin[code]}" : "";

// 관리자 체크 변수
if($sess["userlevel"] ==100) $LogAdmin = TRUE; else $LogAdmin = FALSE;


if($ListMode){
	setcookie("{$Table}_ListMode", $ListMode, time() + 3600, "/",$_SERVER["SERVER_NAME"]); // 1시간동안 저장
	$_COOKIE[$Table."_ListMode"] = $ListMode;
}

// 게시판 해드부분 추출 모바일 체크 (0802 백지훈)
if($_COOKIE["mobile_chk"]=="1"){
	if($Board_Admin["m_head"]==TRUE && $mode != "PASS" && $mode != "MAIL"){
		if(file_exists($Board_Admin["m_head"])) @include $Board_Admin["m_head"];
	}
}else{
	if($Board_Admin["head"]==TRUE && $mode != "PASS" && $mode != "MAIL"){
		if(file_exists($Board_Admin["head"])) @include $Board_Admin["head"];
	}
}


//Iframe Layer
include $default[AbsolutePath]."/js/iframe_layer/iframe_layer.php";


if($Board_Admin["headtag"]==TRUE) echo stripslashes($Board_Admin["headtag"]);


$SubTable = $Table;

//온라인 문의나 견적게시판은 바로 쓰기페이지로...
if($_SESSION[sess][userlevel] < 100 && ($Table == "esti" || $Table == "esti2") && !$mode) $mode = "WRITE";

// MODE에 따른 출력
switch ($mode) {

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  비밀번호 확인 폼
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "PASS" :

		if($type=="MODIFY" || $type=="VIEW") {
			$NextAction = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=$type&amp;num=$num&amp;$NextUrl";
		} else {
			$NextAction = $default[AbsoluteUrl]."/bbs/process.php";
		}
		// 해당 스킨파일 인클루드
		include_once($default["AbsolutePath"]."/common/inc/bbs.passcheck.php");

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  답글쓰기
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "REPLY" :
		// 권한을 체크합니다.
		if($sess["userlevel"]<$Board_Admin["level_reple"]) alert("답변하실 권한이 없습니다.","/bbs/board.php?tbl=$Table&amp;$NextUrl");
		if($Board_Admin["use_reply"]==FALSE) alert("본 게시판은 답변 기능을 사용하실 수 없습니다.","/bbs/board.php?tbl=$Table&amp;$NextUrl");

		// 원본글을 가져옵니다.
		$BoardSql = " select b_tno, b_dep, b_subject, b_content, b_secret from $BB_table where b_no = '$num' ";
		$view = sql_fetch($BoardSql);

		//답글에 >> 표시 해주기
		//$tmp_body = split("\n", $view["b_content"]);
		//for ($R = 0; $R < sizeOf($tmp_body); $R++) { $view["b_content"] .= ">> ".$tmp_body[$R]."\n"; }
		$view["b_content"] = "<br><br><br>\n\n===================== 원글 내용 ====================<br>\r\n".$view["b_content"];
		$view["b_subject"] = $view["b_subject"];

		// 로그인 기본정보 불러오기
		$view["b_member"] = $sess["userid"];
		$view["b_writer"] = $sess["username"];
		$view["b_email"] = $sess["email"];

		// 게시글 쓰기 코드파일을 불러옵니다.
		include_once("./form.php");

		// 해당 스킨파일 인클루드 모바일체크(0802 백지훈)
		if($_COOKIE["mobile_chk"]=="1"){
			include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/form.skin.php");
		}else{
			include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/form.skin.php");
		}

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  글쓰기
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "WRITE" :

		// 권한을 체크합니다.
		if($sess["userlevel"]<$Board_Admin["level_write"]) alert("게시글을 작성하실 권한이 없습니다.","/bbs/board.php?tbl=$Table&amp;$NextUrl");

		// 로그인 기본정보 불러오기
		$view["b_member"] = $sess["userid"];
		$view["b_writer"] = $sess["username"];
		$view["b_email"] = $sess["email"];

		$view["b_dep"] = "A";

		// 게시글 쓰기 코드파일을 불러옵니다.
		include_once("./form.php");

		// 해당 스킨파일 인클루드 모바일체크(0802 백지훈)
		if($_COOKIE["mobile_chk"]=="1"){
			include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/form.skin.php");
		}else{
			include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/form.skin.php");
		}

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  글 수정
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "MODIFY" :

		// 글을 가져옵니다.
		$BoardSql = " select * from $BB_table where b_no = '$num' ";
		$view = sql_fetch($BoardSql);

		// 권한을 체크합니다.
		if($sess["userlevel"]<$Board_Admin["level_write"]) alert("게시글을 작성하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
		if($view["b_member"]==TRUE) {
			if(Member_check($view["b_member"])==FALSE) alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
		}
		if($view["b_member"]==FALSE && $_POST["passwd"]==FALSE && $sess["userlevel"]<100) {
			alert("비밀번호가 전달되지 않았습니다.","/bbs/board.php?tbl=$Table&amp;$NextUrl");
		}
		if($_POST["passwd"]==TRUE) {
			$ChangePass = sql_password($_POST["passwd"]);
			if($view["b_passwd"]!=$ChangePass) alert("비밀번호가 맞지 않아 수정하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
		}

		// 게시글 쓰기 코드파일을 불러옵니다.
		include_once("./form.php");

		// 해당 스킨파일 인클루드 모바일체크(0802 백지훈)
		if($_COOKIE["mobile_chk"]=="1"){
			include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/form.skin.php");
		}else{
			include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/form.skin.php");
		}

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  보기 화면 출력
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	case "VIEW":

		// 글을 가져옵니다.
		$BoardSql = " select a.*, count(b.c_no) as comment from $BB_table a left join $BC_table b on (a.b_no = b.c_bno) where b_no = '$num' group by b_no";
		$view = sql_fetch($BoardSql);

		// 보는글이 답변 글일 경우
		if(strlen($view["b_dep"])>1) {
			// 원본글을 가져옵니다.
			$BoardSql = " select * from $BB_table where b_tno = '{$view[b_tno]}' and b_dep='A' ";
			$old = sql_fetch($BoardSql);
		}

		// 권한을 체크합니다.
		if($sess["userlevel"]<$Board_Admin["level_view"]) alert("게시글을 열람하실 권한이 없습니다.","/bbs/board.php?tbl=$Table&amp;$NextUrl");
		if($view["b_no"]==FALSE) {
			 alert("열람하실 게시물을 선택하세요.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
		}

		if($view["b_secret"]==TRUE && $view["b_dep"]=="A" && $_COOKIE["ck_{$Table}_{$num}_hit"] != $num) {
		// 비밀글이며, 답변글이 아닐 경우
			if($view["b_member"]==TRUE && Member_check($view["b_member"])==FALSE) {
				alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}
			if($Get_Login==FALSE && $_POST["passwd"]==FALSE && $sess["userlevel"]<100) {
				alert("비밀번호가 전달되지 않았습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}
			if($_POST["passwd"]==TRUE) {
				$ChangePass = sql_password($_POST["passwd"]);
				if($view["b_passwd"]!=$ChangePass) alert("비밀번호가 맞지 않아 열람하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}

		// 비밀글이며, 답변글일 경우
		} else if($view["b_secret"]==TRUE && $old["b_no"]==TRUE && $_COOKIE["ck_{$Table}_{$num}_hit"] != $num) {
			if(($view["b_member"]==TRUE && Member_check($view["b_member"])==FALSE) && ($old["b_member"]==TRUE && Member_check($old["b_member"])==FALSE)) {
				alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}
			if($Get_Login==FALSE && $_POST["passwd"]==FALSE && $sess["userlevel"]<100) {
				alert("비밀번호가 전달되지 않았습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}
			if($_POST["passwd"]==TRUE) {
				$ChangePass = sql_password($_POST["passwd"]);
				if(($view["b_passwd"]!=$ChangePass || $view["b_member"]!="") && ($old["b_passwd"]!=$ChangePass || $old["b_member"]!="")) alert("비밀번호가 맞지 않아 열람하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;$NextUrl");
			}
		}


		// 게시글 목록 코드파일을 불러옵니다.
		include_once("./view.php");

		// 댓글을 사용하는 게시판이면
		if($Board_Admin["use_comment"]==TRUE) {
			// 댓글 리스트를 불러옵니다.
			$BoardSql = " select * from $BC_table where c_bno = '$num' $Comm_Order";
			$BoardResult = sql_query($BoardSql,FALSE);
			for($C=0; $row = sql_fetch_array($BoardResult); $C++) {
				$comm[$C] = $row;
				$comm[$C]["subject"] = get_text(stripslashes($row["c_subject"]));
				$comm[$C]["content"] = get_text(stripslashes($row["c_content"]));
				$comm[$C]["c_writer"] = get_text(stripslashes($row["c_writer"]));
				$comm[$C]["regist"] = substr($row["c_regist"],0,10);

				if($Get_Login == TRUE && ($_SESSION[sess]["userid"] == $row["c_member"] || $_SESSION[sess]["userlevel"] == 100)){
					$comm[$C]["comedit"]  = $default[AbsoluteUrl]."/bbs/commodify.php?tbl=$Table&amp;num=$num&amp;cnum=".$comm[$C][c_no];
					$comm[$C]["comdele"] = $default[AbsoluteUrl]."/bbs/process.php?tbl=$Table&amp;mode=COMDEL&amp;num={$row[c_no]}&amp;$NextUrl";
				}else{
					$comm[$C]["comedit"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=PASS&amp;type=MODIFY&amp;num=$num&amp;cnum=".$comm[$C][c_no];
					$comm[$C]["comdele"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=PASS&amp;type=COMDEL&amp;num={$row[c_no]}&amp;$NextUrl";
				}
				if($Board_Admin["use_combest"]==TRUE && $Get_Login==TRUE) {
					$comm[$C]["combest"] = $default[AbsoluteUrl]."/bbs/process.php?tbl=$Table&amp;mode=CBEST&num={$row[c_no]}&amp;$NextUrl";
				} else {
					$comm[$C]["combest"] = "";
				}
			}
			$comm_total = count($comm);
		}

		//보기 화면에서 리스트 출력할 경우
		if($Board_Admin["view_list"] == TRUE) {
			// 게시글 목록 코드파일을 불러옵니다.
			include_once("./list.php");
		}//리스트 출력 끝

		// 해당 스킨파일 인클루드 모바일체크(0802 백지훈)
		if($_COOKIE["mobile_chk"]=="1"){
			if($Board_Admin["view_sort"]==TRUE && $Board_Admin["view_list"] == TRUE) include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/list.skin.php");
			include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/view.skin.php");
			if($Board_Admin["view_sort"]==FALSE && $Board_Admin["view_list"] == TRUE) include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/list.skin.php");
		}else{
			if($Board_Admin["view_sort"]==TRUE && $Board_Admin["view_list"] == TRUE) include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/list.skin.php");
			include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/view.skin.php");
			if($Board_Admin["view_sort"]==FALSE && $Board_Admin["view_list"] == TRUE) include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/list.skin.php");
		}

	break;

	case "MAIL":
		// 글을 가져옵니다.
		$BoardSql = " select a.*, count(b.c_no) as comment from $BB_table a left join $BC_table b on (a.b_no = b.c_bno) where b_no = '$num' group by b_no";
		$view = sql_fetch($BoardSql);

		// 해당 스킨파일 인클루드
		include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/mail.skin.php");

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////  리스트 화면 출력
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	default :

		// 권한을 체크합니다.
		if($sess["userlevel"]<$Board_Admin["level_list"]) alert("게시글 목록을 열람하실 권한이 없습니다.","/member/login.php?URL=/bbs/board.php?tbl=$Table");

		// 게시글 목록 코드파일을 불러옵니다.
		include_once("./list.php");

		// 해당 스킨파일 인클루드(갤러리형 게시판에만 지원...)
		if($_COOKIE[$Table."_ListMode"] == "List") $ListSkin = "list.list.skin.php";
		elseif($_COOKIE[$Table."_ListMode"] == "Webzine") $ListSkin = "list.webzine.skin.php";
		else $ListSkin = "list.skin.php";

		// 모바일체크(0802 백지훈)
		if($_COOKIE["mobile_chk"]=="1"){
			include_once($G_board["skin_dir_mobile"]."/{$Board_Admin[m_skin]}/".$ListSkin);
		}else{
			include_once($G_board["skin_dir"]."/{$Board_Admin[skin]}/".$ListSkin);
		}

		break;
}


if($Board_Admin["foottag"]==TRUE) echo stripslashes($Board_Admin["foottag"]);

// 게시판 풋터부분 추출 모바일 체크 (0802 백지훈)
if($_COOKIE["mobile_chk"]=="1"){
	if($Board_Admin["m_foot"]==TRUE && $mode != "PASS" && $mode != "MAIL"){
		if(file_exists($Board_Admin["m_foot"])) @include $Board_Admin["m_foot"];
	}
}else{
	if($Board_Admin["foot"]==TRUE && $mode != "PASS" && $mode != "MAIL"){
		if(file_exists($Board_Admin["foot"])) @include $Board_Admin["foot"];
	}
}

//if($mode != "PASS") include "../foot.lib.php";

//foot.lib 모바일 체크 (0802 백지훈)
if($_COOKIE["mobile_chk"]=="1"){
	include "..${chr_path}/mobile/foot.lib.php";
}else{
	include "..${chr_path}/foot.lib.php";
}

?>
