<? 
/***************************************************************************
 * 공통 파일 include
 **************************************************************************/
	include "../admin/lib/lib.php";

	//if(!eregi($HTTP_HOST,$HTTP_REFERER)) die();


	if($_GET[tbl]==TRUE) {
		$Table = $_GET[tbl];
		$tbl = $_GET[tbl] = "";
	} else {
		alert("게시판 테이블이 설정되지 않았습니다.",$default[AbsoluteUrl]."/main.php");
	}

// 게시판 설정 내용을 불러옵니다.
	$BoardSql = " select* from {$V_DB[bbsconfig]} where dbname = '$Table' ";
	$Board_Admin = sql_fetch($BoardSql);

// 파일 정보 불러오기
	$data=mysql_fetch_array(mysql_query("select * from {$V_DB[bbsfile]} where bf_no='$no' and bf_table = '$Table' "));

/***************************************************************************
 * 게시판 설정 체크
 **************************************************************************/

// 사용권한 체크
	if($sess["userlevel"]<$Board_Admin["level_view"]) alert("파일을 다운로드하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

// 현재글의 Download 수를 올림;;
    if($data["bf_real_name"]==TRUE) {
        mysql_query("update {$V_DB[bbsfile]} set bf_down=bf_down+1 where bf_no='$no'");
    }

// 다운로드;;
	$filedir = $default[AbsolutePath]."/bbs/data/$Table/".$data["bf_save_name"];
	$filename = $data["bf_real_name"];



if (file_exists($filedir)) {
    if(eregi("msie", $_SERVER[HTTP_USER_AGENT]) && eregi("5\.5", $_SERVER[HTTP_USER_AGENT])) {
        header("content-type: doesn/matter");
        header("content-length: ".filesize("$filedir"));
        header("content-disposition: attachment; filename=\"$filename\"");
        header("content-transfer-encoding: binary");
    } else {
        header("content-type: file/unknown");
        header("content-length: ".filesize("$filedir"));
        header("content-disposition: attachment; filename=\"$filename\"");
        header("content-description: php generated data");
    }
    header("pragma: no-cache");
    header("expires: 0");
    flush();

    if (is_file("$filedir")) {
        $fp = fopen("$filedir", "rb");

        // 4.00 대체
        // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
        //if (!fpassthru($fp)) {
        //    fclose($fp);
        //}

        while(!feof($fp)) {
            echo fread($fp, 100*1024);
            flush();
        }
        fclose ($fp);
        flush();
    } else {
        alert("해당 파일이나 경로가 존재하지 않습니다.");
    }

} else {
    alert("파일을 찾을 수 없습니다.");
}

?>