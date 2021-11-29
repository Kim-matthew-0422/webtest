<?

	include "../admin/lib/lib.php";
	include "../admin/plugin/naver_blog/lib/function.php";



	if($_POST[tbl]==TRUE) {

		$Table = $_POST[tbl];

		$tbl = $_POST[tbl] = "";

	} else if($_GET[tbl]==TRUE) {

		$Table = $_GET[tbl];

		$tbl = $_GET[tbl] = "";

	} else {

		alert("게시판 테이블이 설정되지 않았습니다.",$default[AbsoluteUrl]."/main.php");

	}



	$BB_table = $V_DB["bbsitem"].$Table;

	$BC_table = $V_DB["bbscomm"].$Table;



// 게시판 설정 내용을 불러옵니다.

	$BoardSql = " select* from {$V_DB[bbsconfig]} where dbname = '$Table' ";

	$Board_Admin = sql_fetch($BoardSql);



	//스팸 방지글

	if($Board_Admin["use_spam"]==TRUE && ($mode == "WRITE" ||  $mode == "REPLY") && !$Get_Login) {

		if ( isset($_POST['zsfCode']) ){

			$zsfCode = stripslashes(trim($_POST['zsfCode']));

			include 'zmSpamFree.php';

			$r = zsfCheck ( $_POST['zsfCode'],'DemoPage' );	# $_POST['zsfCode']는 입력된 스팸방지코드 값이고, 'DemoPage'는 기타 기록하고픈



			if (!$r){ alert("코드가 일치하지 않습니다","");}

		}

	}

	if($Board_Admin["dbname"]==FALSE) {

		alert("잘못된 게시판 테이블명입니다.",$default[AbsoluteUrl]."/main.php");

	}

	if($Board_Admin["view"]==FALSE) {

		alert("사용할 수 없는 게시판입니다.",$default[AbsoluteUrl]."/main.php");

	}



	// 주소 변수 / 다음페이지 설정

	$NextUrl = "chr=$chr&amp;category=$category&amp;findType=$findType&amp;findword=$findword&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";



/////// DB에 들어갈 값들을 변환합니다.

	$mcontent = $b_content;

	$b_subject = addslashes(str_replace("\\","\\\\",$b_subject));

	$b_content = stripslashes($b_content);



	// 게시글 실제번호 불러오기

	if($b_tno==FALSE) {

		$BoardSql = "select max(b_tno) as max from $BB_table ";

		$maxnum = sql_fetch($BoardSql);

		if($maxnum["max"]==TRUE) $b_tno=$maxnum["max"]+1; else $b_tno = 1;

	}



	// 게시글 실제번호 불러오기

	if($mode=="REPLY") {

		$BoardSql = "select b_dep,right(b_dep,1) as n_dep from $BB_table where b_tno='$b_tno' and length(b_dep)=length('$b_dep')+1 and locate('$b_dep',b_dep)=1 limit 1";

		$dep = sql_fetch($BoardSql);



		// 게시글의 깊이 설정

		if($dep["b_dep"]==TRUE) {

			$thread_head=substr($dep["b_dep"],0,-1);

			$thread_foot= ++$dep["n_dep"];

			$b_dep=$thread_head.$thread_foot;

		}else{

			$b_dep=$b_dep."A";

		}

	}



	// 비밀게시판일 경우

	if($Board_Admin["use_asecret"]==TRUE) {

		$b_secret	 = "1";

	}



	// 댓글 변수 변환

	$c_subject = addslashes(str_replace("\\","\\\\",$c_subject));

	$c_content = addslashes(str_replace("\\","\\\\",$c_content));





/////// DB에 들어갈 값들을 정리합니다.

	$Board_Invalue = "

		b_tno				=  '$b_tno',

		b_dep				=  '$b_dep',

		b_category			=  '$b_category',

		b_member			=  '$b_member',

		b_writer				=  '$b_writer',

		b_subject			=  '$b_subject',

		b_email				=  '$b_email',

		b_content			=  '$b_content',

		b_secret			=  '$b_secret',

		b_notice			=  '$b_notice',

		b_html				=  '$b_html',

		b_link1				=  '$b_link1',

		b_link2				=  '$b_link2',

		b_ex1				=  '$b_ex1',

		b_ex2				=  '$b_ex2',

		b_ex3				=  '$b_ex3',

		b_ex4				=  '$b_ex4',

		b_ex5				=  '$b_ex5',

		b_ex6				=  '$b_ex6',

		b_ex7				=  '$b_ex7',

		b_ex8				=  '$b_ex8',

		b_ex9				=  '$b_ex9',

		b_ex10				=  '$b_ex10'

	";



	if($Table == "esti01"){

		$Board_Invalue .= ",b_ex11 =  '$b_ex11',

							b_ex12 =  '$b_ex12',

							b_ex13 =  '$b_ex13',

							b_ex14 =  '$b_ex14',

							b_ex15 =  '$b_ex15'";

	}





	$Comm_Invalue = "

		c_bno				=  '$c_bno',

		c_member			=  '$c_member',

		c_writer				=  '$c_writer',

		c_subject			=  '$c_subject',

		c_content			=  '$c_content',

		c_ex1				=  '$c_ex1',

		c_ex2				=  '$c_ex2',

		c_ex3				=  '$c_ex3',

		c_ex4				=  '$c_ex4',

		c_ex5				=  '$c_ex5',

		c_ex6				=  '$c_ex6',

		c_ex7				=  '$c_ex7',

		c_ex8				=  '$c_ex8',

		c_ex9				=  '$c_ex9',

		c_ex10				=  '$c_ex10'

	";



//function Check_Pass() {

//	global $sess, $_POST ;

	//비밀번호 설정

	if($Get_Login==TRUE) {

		$B_member = Get_member($sess["userid"]);

		$Board_Invalue .= ", b_passwd = '{$B_member[mem_pass]}' ";

		$Comm_Invalue .= ", c_passwd = '{$B_member[mem_pass]}' ";


	} else {

		if($_POST["passwd"]==TRUE) {

			$b_passwd = sql_password($_POST["passwd"]);

			$Board_Invalue .= ", b_passwd = '$b_passwd' ";

			$Comm_Invalue .= ", c_passwd = '$b_passwd' ";

		} else {

			alert("비밀번호가 전달되지 않았습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

	}

//}



/////// 파일 업로드

function FileDb_Input($GetFile, $id, $fid) {

	global $Board_Admin, $V_DB, $_FILES, $G_board, $datetime, $Table, $default;



	if($Board_Admin["use_data"]==TRUE) {

		##### 등록파일이 있을경우

		if ($GetFile["name"])

		{

			$FileSql = "select bf_no, bf_save_name from {$V_DB[bbsfile]} where bf_table = '$Table' and bf_tno = '$id' and bf_fno = '$fid'";

			$FileRow = sql_fetch($FileSql);

			$FileSearch = $FileRow["bf_no"];



			// 업로드할 파일의 용량을 체크합니다.

			if($GetFile["size"]==0) {

				return $fale = "파일이 정상적이지 않아 업로드 하실 수 없습니다.";

			}

			if($GetFile["size"]>$Board_Admin["fileupsize"]*1024) {

				return $fale = "파일의 용량이 너무 커서 업로드 하실 수 없습니다.";

			}



			// 이미 등록되어 있는 파일이 있을 경우

			if($FileSearch==TRUE) {

				@unlink("$G_board[data_dir]/$Table/$FileRow[bf_save_name]");

				//썸네일 삭제 09-12-07 J.H Kim

				@unlink("$G_board[data_dir]/$Table/flash_thumb/flash_thumb_{$FileRow[bf_save_name]}");
				@unlink("$G_board[data_dir]/$Table/thumb/{$id}");
				@unlink("$G_board[data_dir]/$Table/thumbmain/{$id}");

			}



			// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함

			$TmpUpfile = str_replace(" ","",$GetFile["name"]);

			$TmpUpfile = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $TmpUpfile);



			// 파일이름 정상체크

			$Upfile = explode(".",$TmpUpfile);

			$Upfile_total = count($Upfile) - 1;

			$Upfile_Rename =substr(md5(uniqid($now)),0,8).'_'.str_replace('%', '', urlencode($Upfile[0])).".".$Upfile[$Upfile_total];



			// 파일이름 중복체크

			$bimg = $G_board["data_dir"]."/$Table/".$Upfile_Rename;

			for($pn = 1; file_exists($bimg); $pn++) {

				$Upfile_Rename = substr(md5(uniqid($now)),0,8).'_'.str_replace('%', '', urlencode($Upfile[0]))."_($pn).".$Upfile[$Upfile_total];

				$bimg = $G_board["data_dir"]."/$Table/".$Upfile_Rename;

			}

			upload_file($GetFile["tmp_name"], $Upfile_Rename, $G_board["data_dir"]."/$Table/");


			//썸네일생성
			//확장자 구분
			$file_ext = substr(strrchr($GetFile["name"], "."),1); 
			$file_ext = strtolower($file_ext);	//확장자를 소문자로...

			//gif, jpg, png의 경우 썸네일이미지생성
			if ($file_ext=="gif" || $file_ext=="jpg" || $file_ext=="png")
			{
				$mpath = 'bbs/data'."/$Table/";
				$save_path = $G_board["data_dir"]."/$Table/";
				$dest_file = $save_path."$Upfile_Rename";
				//이전 썸네일 이미지명 삭제
				if($Upfile_Rename)
					$old_img_name="s_" . $Upfile_Rename;
			
					//썸네일 이미지명 지정 
					$save_img_name="s_" . $Upfile_Rename;				
			
				image_create_upload($dest_file, $GetFile["name"], $GetFile["size"], $save_path, $save_img_name, $old_img_name, 250, 250);

			}


			$Invalue = "

				bf_table = '$Table',

				bf_tno = '$id',

				bf_fno = '$fid',

				bf_save_name = '$Upfile_Rename',

				bf_real_name = '{$GetFile[name]}'

			";

			// 글입력하기

			if($FileSearch==TRUE) {

				$FileSql = "update {$V_DB[bbsfile]} set $Invalue , bf_time = '$datetime' where bf_no='$FileSearch' ";

			} else {

				$FileSql = "insert {$V_DB[bbsfile]} set $Invalue , bf_time = '$datetime', site = '{$default[site_code]}' ";

			}

			sql_query($FileSql);

			return $save_path.$save_img_name;

		}

	}

}



/////// 파일 업로드 사용하는 게시판이면

function FileDb_Delete($id, $fid="0") {

	global $Board_Admin, $V_DB, $_FILES, $G_board, $datetime, $Table, $default;



	##### 등록파일이 있을경우

		if ($fid==TRUE)

		{

			$FileSql = "select bf_no, bf_save_name from {$V_DB[bbsfile]} where bf_table = '$Table' and bf_tno = '$id' and bf_fno = '$fid'";

			$FileRow = sql_fetch($FileSql);

			$FileSearch = $FileRow["bf_no"];



			$Invalue = "

				bf_table = '$Table',

				bf_tno = '$id',

				bf_fno = '$fid',

				bf_save_name = '',

				bf_real_name = ''

			";



			// 이미 등록되어 있는 파일이 있을 경우

			if($FileSearch==TRUE) {

				@unlink("$G_board[data_dir]/$Table/{$FileRow[bf_save_name]}");

				//썸네일 삭제 
				@unlink("$G_board[data_dir]/$Table/s_{$FileRow[bf_save_name]}");
				@unlink("$G_board[data_dir]/$Table/flash_thumb/flash_thumb_{$FileRow[bf_save_name]}");
				@unlink("$G_board[data_dir]/$Table/thumb/{$id}");
				@unlink("$G_board[data_dir]/$Table/thumbmain/{$id}");

				$FileSql = "update {$V_DB[bbsfile]} set $Invalue , bf_time = '$datetime' where bf_no='$FileSearch' ";

				sql_query($FileSql);

			}

		} else {

			$FileSql = "select bf_no, bf_save_name from {$V_DB[bbsfile]} where bf_table = '$Table' and bf_tno = '$id'";

			$FileResult = sql_query($FileSql,FALSE);

			for ($i=1; $FileRow=sql_fetch_array($FileResult,FALSE); $i++) {

				@unlink("$G_board[data_dir]/$Table/$FileRow[bf_save_name]");

				//썸네일 삭제 09-12-07 J.H Kim

				@unlink("$G_board[data_dir]/$Table/flash_thumb/flash_thumb_{$FileRow[bf_save_name]}");
				@unlink("$G_board[data_dir]/$Table/thumb/{$id}");
				@unlink("$G_board[data_dir]/$Table/thumbmain/{$id}");

				$FileSql = "delete from {$V_DB[bbsfile]} where bf_tno ='{$FileRow[bf_tno]}' ";

				sql_query($FileSql);

			}

		}

}



switch ($mode) {



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  리스트 여러글 복사

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "COPY" :

		// 글복사 권한을 설정합니다.

		if($sess["userlevel"]<100) {

			alert("최고관리자만 관리 가능합니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}



		// 게시판 설정 내용을 불러옵니다.

		$DbnameSql = " select* from {$V_DB[bbsconfig]} where dbname = '$typedbname' ";

		$Dbname = sql_fetch($DbnameSql);



		$DI_table = $V_DB["bbsitem"].$typedbname;

		$DC_table =$V_DB["bbscomm"].$typedbname;



		//게시글 리스트 순서대로 정렬하기

		$list_ck = $_POST["list_ck"];

		$list_array = "";

		for($t=0;$t<count($list_ck);$t++){

			$list_fetch = sql_fetch("select * from $BB_table where b_no='".$list_ck[$t]."' ");

			if($list_fetch[b_dep]=="A"){

				if(!eregi($list_fetch[b_no],$list_array)){

					$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");

					while($list_row = sql_fetch_array($list_res)){

						if($list_array=="") $list_array.= $list_row[b_no];

						else $list_array.= ",".$list_row[b_no];

					}

				}

			}else{

				if(!eregi($list_fetch[b_no],$list_array)){

					$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");

					while($list_row = sql_fetch_array($list_res)){

						if($list_array=="") $list_array.= $list_row[b_no];

						else $list_array.= ",".$list_row[b_no];

					}

				}

				$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");



			}

		}



		$tmp_array = explode(",",$list_array);

		$m_no = "";

		for($i=0;$i<count($tmp_array);$i++){

			//게시물 불러오기

			$row = sql_fetch("select * from $BB_table where b_no='".$tmp_array[$i]."'");



			if($row[b_dep]=="A"){	//원본글일경우

				$sql = "insert into $DI_table set ";

				$sql.= "b_dep		= '".$row[b_dep]."', ";

				$sql.= "b_member	= '".$row[b_member]."', ";

				$sql.= "b_writer	= '".$row[b_writer]."', ";

				$sql.= "b_passwd	= '".$row[b_passwd]."', ";

				$sql.= "b_subject	= '".$row[b_subject]."', ";

				$sql.= "b_email		= '".$row[b_email]."', ";

				$sql.= "b_content	= '".$row[b_content]."', ";

				$sql.= "b_secret	= '".$row[b_secret]."', ";

				$sql.= "b_notice	= '".$row[b_notice]."', ";

				$sql.= "b_html		= '".$row[b_html]."', ";

				$sql.= "b_link1		= '".$row[b_link1]."', ";

				$sql.= "b_link2		= '".$row[b_link2]."', ";

				$sql.= "b_ex1		= '".$row[b_ex1]."', ";

				$sql.= "b_ex2		= '".$row[b_ex2]."', ";

				$sql.= "b_ex3		= '".$row[b_ex3]."', ";

				$sql.= "b_ex4		= '".$row[b_ex4]."', ";

				$sql.= "b_ex5		= '".$row[b_ex5]."', ";

				$sql.= "b_ex6		= '".$row[b_ex6]."', ";

				$sql.= "b_ex7		= '".$row[b_ex7]."', ";

				$sql.= "b_ex8		= '".$row[b_ex8]."', ";

				$sql.= "b_ex9		= '".$row[b_ex9]."', ";

				$sql.= "b_ex10		= '".$row[b_ex10]."', ";

				$sql.= "b_best		= '".$row[b_best]."', ";

				$sql.= "b_bestid	= '".$row[b_bestid]."', ";

				$sql.= "b_hit		= '".$row[b_hit]."', ";

				$sql.= "b_modify	= now(), ";

				$sql.= "b_regist	= now(), ";

				$sql.= "b_addip		= '".$row[b_addip]."', ";

				$sql.= "site		= '".$row[site]."' ";

				sql_query($sql);

				//테이블 고유번호 구하기

				$m_no = mysql_insert_id();

				sql_query("update $DI_table set b_tno='".$m_no."' where b_no='".$m_no."' ");



				//코멘트가 있을경우 복사

				$res_com = sql_query("select * from $BC_table where c_bno='".$tmp_array[$i]."'");

				$com_total = mysql_num_rows($res_com);

				if($com_total>0){

					while($com=sql_fetch_array($res_com)){

						$c_sql = "insert into $DC_table set ";

						$c_sql.= "c_bno			= '".$m_no."', ";

						$c_sql.= "c_member		= '".$com[c_member]."', ";

						$c_sql.= "c_writer		= '".$com[c_writer]."', ";

						$c_sql.= "c_passwd		= '".$com[c_passwd]."', ";

						$c_sql.= "c_subject		= '".$com[c_subject]."', ";

						$c_sql.= "c_content		= '".$com[c_content]."', ";

						$c_sql.= "c_ex1			= '".$com[c_ex1]."', ";

						$c_sql.= "c_ex2			= '".$com[c_ex2]."', ";

						$c_sql.= "c_ex3			= '".$com[c_ex3]."', ";

						$c_sql.= "c_ex4			= '".$com[c_ex4]."', ";

						$c_sql.= "c_ex5			= '".$com[c_ex5]."', ";

						$c_sql.= "c_ex6			= '".$com[c_ex6]."', ";

						$c_sql.= "c_ex7			= '".$com[c_ex7]."', ";

						$c_sql.= "c_ex8			= '".$com[c_ex8]."', ";

						$c_sql.= "c_ex9			= '".$com[c_ex9]."', ";

						$c_sql.= "c_ex10		= '".$com[c_ex10]."', ";

						$c_sql.= "c_best		= '".$com[c_best]."', ";

						$c_sql.= "c_bestid		= '".$com[c_bestid]."', ";

						$c_sql.= "c_modify		= now(), ";

						$c_sql.= "c_regist		= '".$com[c_regist]."', ";

						$c_sql.= "c_addip		= '".$com[c_addip]."', ";

						$c_sql.= "site		= '".$com[site]."'  ";

						sql_query($c_sql);

					}

				}



				//첨부파일이 있을경우 복사

				$res_file = sql_query("select * from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

				$file_total = mysql_num_rows($res_file);

				if($file_total>0){

					while($file=sql_fetch_array($res_file)){

						$save_name =rand(100,999)."_".$file[bf_save_name];

						copy($default[AbsolutePath]."/bbs/data/".$Table."/".$file[bf_save_name],$_SERVER['DOCUMENT_ROOT']."/bbs/data/".$typedbname."/".$save_name);

						sql_query("insert into {$V_DB[bbsfile]} set bf_table='".$typedbname."', bf_tno='".$m_no."', bf_fno='".$file[bf_fno]."', bf_save_name='".$save_name."', bf_real_name='".$file[bf_real_name]."', bf_down='".$file[bf_down]."', bf_time=now(), site='".$file[site]."'");

					}

				}

			}else{	//댓글(답글)일경우

				if($m_no){

					$sql = "insert into $DI_table set ";

					$sql.= "b_dep		= '".$row[b_dep]."', ";

					$sql.= "b_member	= '".$row[b_member]."', ";

					$sql.= "b_writer	= '".$row[b_writer]."', ";

					$sql.= "b_passwd	= '".$row[b_passwd]."', ";

					$sql.= "b_subject	= '".$row[b_subject]."', ";

					$sql.= "b_email		= '".$row[b_email]."', ";

					$sql.= "b_content	= '".$row[b_content]."', ";

					$sql.= "b_secret	= '".$row[b_secret]."', ";

					$sql.= "b_notice	= '".$row[b_notice]."', ";

					$sql.= "b_html		= '".$row[b_html]."', ";

					$sql.= "b_link1		= '".$row[b_link1]."', ";

					$sql.= "b_link2		= '".$row[b_link2]."', ";

					$sql.= "b_ex1		= '".$row[b_ex1]."', ";

					$sql.= "b_ex2		= '".$row[b_ex2]."', ";

					$sql.= "b_ex3		= '".$row[b_ex3]."', ";

					$sql.= "b_ex4		= '".$row[b_ex4]."', ";

					$sql.= "b_ex5		= '".$row[b_ex5]."', ";

					$sql.= "b_ex6		= '".$row[b_ex6]."', ";

					$sql.= "b_ex7		= '".$row[b_ex7]."', ";

					$sql.= "b_ex8		= '".$row[b_ex8]."', ";

					$sql.= "b_ex9		= '".$row[b_ex9]."', ";

					$sql.= "b_ex10		= '".$row[b_ex10]."', ";

					$sql.= "b_best		= '".$row[b_best]."', ";

					$sql.= "b_bestid	= '".$row[b_bestid]."', ";

					$sql.= "b_hit		= '".$row[b_hit]."', ";

					$sql.= "b_modify	= now(), ";

					$sql.= "b_regist	= now(), ";

					$sql.= "b_addip		= '".$row[b_addip]."', ";

					$sql.= "site		= '".$row[site]."' ";

					sql_query($sql);

					//테이블 고유번호 구하기

					$dep_no = mysql_insert_id();

					sql_query("update $DI_table set b_tno='".$m_no."' where b_no='".$dep_no."' ");



					//코멘트가 있을경우 복사

					$res_com = sql_query("select * from $BC_table where c_bno='".$tmp_array[$i]."'");

					$com_total = mysql_num_rows($res_com);

					if($com_total>0){

						while($com=sql_fetch_array($res_com)){

							$c_sql = "insert into $DC_table set ";

							$c_sql.= "c_bno			= '".$dep_no."', ";

							$c_sql.= "c_member		= '".$com[c_member]."', ";

							$c_sql.= "c_writer		= '".$com[c_writer]."', ";

							$c_sql.= "c_passwd		= '".$com[c_passwd]."', ";

							$c_sql.= "c_subject		= '".$com[c_subject]."', ";

							$c_sql.= "c_content		= '".$com[c_content]."', ";

							$c_sql.= "c_ex1			= '".$com[c_ex1]."', ";

							$c_sql.= "c_ex2			= '".$com[c_ex2]."', ";

							$c_sql.= "c_ex3			= '".$com[c_ex3]."', ";

							$c_sql.= "c_ex4			= '".$com[c_ex4]."', ";

							$c_sql.= "c_ex5			= '".$com[c_ex5]."', ";

							$c_sql.= "c_ex6			= '".$com[c_ex6]."', ";

							$c_sql.= "c_ex7			= '".$com[c_ex7]."', ";

							$c_sql.= "c_ex8			= '".$com[c_ex8]."', ";

							$c_sql.= "c_ex9			= '".$com[c_ex9]."', ";

							$c_sql.= "c_ex10		= '".$com[c_ex10]."', ";

							$c_sql.= "c_best		= '".$com[c_best]."', ";

							$c_sql.= "c_bestid		= '".$com[c_bestid]."', ";

							$c_sql.= "c_modify		= now(), ";

							$c_sql.= "c_regist		= '".$com[c_regist]."', ";

							$c_sql.= "c_addip		= '".$com[c_addip]."', ";

							$c_sql.= "site		= '".$com[site]."'  ";

							sql_query($c_sql);

						}

					}



					//첨부파일이 있을경우 복사

					$res_file = sql_query("select * from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

					$file_total = mysql_num_rows($res_file);

					if($file_total>0){

						while($file=sql_fetch_array($res_file)){

							$save_name =rand(100,999)."_".$file[bf_save_name];

							copy($default[AbsolutePath]."/bbs/data/".$Table."/".$file[bf_save_name],$_SERVER['DOCUMENT_ROOT']."/bbs/data/".$typedbname."/".$save_name);

							sql_query("insert into {$V_DB[bbsfile]} set bf_table='".$typedbname."', bf_tno='".$dep_no."', bf_fno='".$file[bf_fno]."', bf_save_name='".$save_name."', bf_real_name='".$file[bf_real_name]."', bf_down='".$file[bf_down]."', bf_time=now(), site='".$file[site]."'");

						}

					}//첨부파일 if end

				}//$m_no 가 있을경우

			}

		}



		alert("게시글이 복사되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table");



	break;





	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  리스트 여러글 이동

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "MOVE" :

		// 글이동 권한을 설정합니다.

		if($sess["userlevel"]<100) {

			alert("최고관리자만 관리 가능합니다.","/bbs/board.php?tbl=$Table&$NextUrl");

		}

		// 게시판 설정 내용을 불러옵니다.

		$DbnameSql = " select* from {$V_DB[bbsconfig]} where dbname = '$typedbname' ";

		$Dbname = sql_fetch($DbnameSql);



		$DI_table = ($Dbname[btype]=="c")?$V_DB["comitem"].$typedbname:$V_DB["bbsitem"].$typedbname;

		$DC_table = ($Dbname[btype]=="c")?$V_DB["comcomm"].$typedbname:$V_DB["bbscomm"].$typedbname;



		//게시글 리스트 순서대로 정렬하기

		$list_ck = $_POST["list_ck"];

		$list_array = "";

		for($t=0;$t<count($list_ck);$t++){

			$list_fetch = sql_fetch("select * from $BB_table where b_no='".$list_ck[$t]."' ");

			if($list_fetch[b_dep]=="A"){

				if(!eregi($list_fetch[b_no],$list_array)){

					$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");

					while($list_row = sql_fetch_array($list_res)){

						if($list_array=="") $list_array.= $list_row[b_no];

						else $list_array.= ",".$list_row[b_no];

					}

				}

			}else{

				if(!eregi($list_fetch[b_no],$list_array)){

					$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");

					while($list_row = sql_fetch_array($list_res)){

						if($list_array=="") $list_array.= $list_row[b_no];

						else $list_array.= ",".$list_row[b_no];

					}

				}

				$list_res = sql_query("select * from $BB_table where b_tno='".$list_fetch[b_tno]."' order by b_dep ASC ");



			}

		}



		$tmp_array = explode(",",$list_array);

		$m_no = "";

		for($i=0;$i<count($tmp_array);$i++){

			//게시물 불러오기

			$row = sql_fetch("select * from $BB_table where b_no='".$tmp_array[$i]."'");



			if($row[b_dep]=="A"){	//원본글일경우

				$sql = "insert into $DI_table set ";

				$sql.= "b_dep		= '".$row[b_dep]."', ";

				$sql.= "b_member	= '".$row[b_member]."', ";

				$sql.= "b_writer	= '".$row[b_writer]."', ";

				$sql.= "b_passwd	= '".$row[b_passwd]."', ";

				$sql.= "b_subject	= '".$row[b_subject]."', ";

				$sql.= "b_email		= '".$row[b_email]."', ";

				$sql.= "b_content	= '".$row[b_content]."', ";

				$sql.= "b_secret	= '".$row[b_secret]."', ";

				$sql.= "b_notice	= '".$row[b_notice]."', ";

				$sql.= "b_html		= '".$row[b_html]."', ";

				$sql.= "b_link1		= '".$row[b_link1]."', ";

				$sql.= "b_link2		= '".$row[b_link2]."', ";

				$sql.= "b_ex1		= '".$row[b_ex1]."', ";

				$sql.= "b_ex2		= '".$row[b_ex2]."', ";

				$sql.= "b_ex3		= '".$row[b_ex3]."', ";

				$sql.= "b_ex4		= '".$row[b_ex4]."', ";

				$sql.= "b_ex5		= '".$row[b_ex5]."', ";

				$sql.= "b_ex6		= '".$row[b_ex6]."', ";

				$sql.= "b_ex7		= '".$row[b_ex7]."', ";

				$sql.= "b_ex8		= '".$row[b_ex8]."', ";

				$sql.= "b_ex9		= '".$row[b_ex9]."', ";

				$sql.= "b_ex10		= '".$row[b_ex10]."', ";

				$sql.= "b_best		= '".$row[b_best]."', ";

				$sql.= "b_bestid	= '".$row[b_bestid]."', ";

				$sql.= "b_hit		= '".$row[b_hit]."', ";

				$sql.= "b_modify	= now(), ";

				$sql.= "b_regist	= now(), ";

				$sql.= "b_addip		= '".$row[b_addip]."', ";

				$sql.= "site		= '".$row[site]."' ";

				sql_query($sql);

				//테이블 고유번호 구하기

				$m_no = mysql_insert_id();

				sql_query("update $DI_table set b_tno='".$m_no."' where b_no='".$m_no."' ");



				//원본테이블 내용 삭제

				sql_query("delete from $BB_table where b_no='".$tmp_array[$i]."'");



				//코멘트가 있을경우 복사

				$res_com = sql_query("select * from $BC_table where c_bno='".$tmp_array[$i]."'");

				$com_total = mysql_num_rows($res_com);

				if($com_total>0){

					while($com=sql_fetch_array($res_com)){

						$c_sql = "insert into $DC_table set ";

						$c_sql.= "c_bno			= '".$m_no."', ";

						$c_sql.= "c_member		= '".$com[c_member]."', ";

						$c_sql.= "c_writer		= '".$com[c_writer]."', ";

						$c_sql.= "c_passwd		= '".$com[c_passwd]."', ";

						$c_sql.= "c_subject		= '".$com[c_subject]."', ";

						$c_sql.= "c_content		= '".$com[c_content]."', ";

						$c_sql.= "c_ex1			= '".$com[c_ex1]."', ";

						$c_sql.= "c_ex2			= '".$com[c_ex2]."', ";

						$c_sql.= "c_ex3			= '".$com[c_ex3]."', ";

						$c_sql.= "c_ex4			= '".$com[c_ex4]."', ";

						$c_sql.= "c_ex5			= '".$com[c_ex5]."', ";

						$c_sql.= "c_ex6			= '".$com[c_ex6]."', ";

						$c_sql.= "c_ex7			= '".$com[c_ex7]."', ";

						$c_sql.= "c_ex8			= '".$com[c_ex8]."', ";

						$c_sql.= "c_ex9			= '".$com[c_ex9]."', ";

						$c_sql.= "c_ex10		= '".$com[c_ex10]."', ";

						$c_sql.= "c_best		= '".$com[c_best]."', ";

						$c_sql.= "c_bestid		= '".$com[c_bestid]."', ";

						$c_sql.= "c_modify		= now(), ";

						$c_sql.= "c_regist		= '".$com[c_regist]."', ";

						$c_sql.= "c_addip		= '".$com[c_addip]."', ";

						$c_sql.= "site		= '".$com[site]."'  ";

						sql_query($c_sql);



						//원본테이블 코멘트 삭제

						sql_query("delete from $BC_table where c_bno='".$tmp_array[$i]."'");

					}

				}



				//첨부파일이 있을경우 복사

				$res_file = sql_query("select * from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

				$file_total = mysql_num_rows($res_file);

				if($file_total>0){

					while($file=sql_fetch_array($res_file)){

						$save_name =rand(100,999)."_".$file[bf_save_name];

						@copy($default[AbsolutePath]."/bbs/data/".$Table."/".$file[bf_save_name],$_SERVER['DOCUMENT_ROOT']."/bbs/data/".$typedbname."/".$save_name);

						sql_query("insert into {$V_DB[bbsfile]} set bf_table='".$typedbname."', bf_tno='".$m_no."', bf_fno='".$file[bf_fno]."', bf_save_name='".$save_name."', bf_real_name='".$file[bf_real_name]."', bf_down='".$file[bf_down]."', bf_time=now(), site='".$file[site]."'");



						//원본테이블 첨부파일 삭제

						@unlink($default[AbsolutePath]."/bbs/data/".$Table."/".$file[bf_save_name]);

						sql_query("delete from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

					}

				}

			}else{	//댓글(답글)일경우

				$sql = "insert into $DI_table set ";

				$sql.= "b_dep		= '".$row[b_dep]."', ";

				$sql.= "b_member	= '".$row[b_member]."', ";

				$sql.= "b_writer	= '".$row[b_writer]."', ";

				$sql.= "b_passwd	= '".$row[b_passwd]."', ";

				$sql.= "b_subject	= '".$row[b_subject]."', ";

				$sql.= "b_email		= '".$row[b_email]."', ";

				$sql.= "b_content	= '".$row[b_content]."', ";

				$sql.= "b_secret	= '".$row[b_secret]."', ";

				$sql.= "b_notice	= '".$row[b_notice]."', ";

				$sql.= "b_html		= '".$row[b_html]."', ";

				$sql.= "b_link1		= '".$row[b_link1]."', ";

				$sql.= "b_link2		= '".$row[b_link2]."', ";

				$sql.= "b_ex1		= '".$row[b_ex1]."', ";

				$sql.= "b_ex2		= '".$row[b_ex2]."', ";

				$sql.= "b_ex3		= '".$row[b_ex3]."', ";

				$sql.= "b_ex4		= '".$row[b_ex4]."', ";

				$sql.= "b_ex5		= '".$row[b_ex5]."', ";

				$sql.= "b_ex6		= '".$row[b_ex6]."', ";

				$sql.= "b_ex7		= '".$row[b_ex7]."', ";

				$sql.= "b_ex8		= '".$row[b_ex8]."', ";

				$sql.= "b_ex9		= '".$row[b_ex9]."', ";

				$sql.= "b_ex10		= '".$row[b_ex10]."', ";

				$sql.= "b_best		= '".$row[b_best]."', ";

				$sql.= "b_bestid	= '".$row[b_bestid]."', ";

				$sql.= "b_hit		= '".$row[b_hit]."', ";

				$sql.= "b_modify	= now(), ";

				$sql.= "b_regist	= now(), ";

				$sql.= "b_addip		= '".$row[b_addip]."', ";

				$sql.= "site		= '".$row[site]."' ";

				sql_query($sql);

				//테이블 고유번호 구하기

				$dep_no = mysql_insert_id();

				sql_query("update $DI_table set b_tno='".$m_no."' where b_no='".$dep_no."' ");



				//원본테이블 내용 삭제

				sql_query("delete from $BB_table where b_no='".$tmp_array[$i]."'");



				//코멘트가 있을경우 복사

				$res_com = sql_query("select * from $BC_table where c_bno='".$tmp_array[$i]."'");

				$com_total = mysql_num_rows($res_com);

				if($com_total>0){

					while($com=sql_fetch_array($res_com)){

						$c_sql = "insert into $DC_table set ";

						$c_sql.= "c_bno			= '".$dep_no."', ";

						$c_sql.= "c_member		= '".$com[c_member]."', ";

						$c_sql.= "c_writer		= '".$com[c_writer]."', ";

						$c_sql.= "c_passwd		= '".$com[c_passwd]."', ";

						$c_sql.= "c_subject		= '".$com[c_subject]."', ";

						$c_sql.= "c_content		= '".$com[c_content]."', ";

						$c_sql.= "c_ex1			= '".$com[c_ex1]."', ";

						$c_sql.= "c_ex2			= '".$com[c_ex2]."', ";

						$c_sql.= "c_ex3			= '".$com[c_ex3]."', ";

						$c_sql.= "c_ex4			= '".$com[c_ex4]."', ";

						$c_sql.= "c_ex5			= '".$com[c_ex5]."', ";

						$c_sql.= "c_ex6			= '".$com[c_ex6]."', ";

						$c_sql.= "c_ex7			= '".$com[c_ex7]."', ";

						$c_sql.= "c_ex8			= '".$com[c_ex8]."', ";

						$c_sql.= "c_ex9			= '".$com[c_ex9]."', ";

						$c_sql.= "c_ex10		= '".$com[c_ex10]."', ";

						$c_sql.= "c_best		= '".$com[c_best]."', ";

						$c_sql.= "c_bestid		= '".$com[c_bestid]."', ";

						$c_sql.= "c_modify		= now(), ";

						$c_sql.= "c_regist		= '".$com[c_regist]."', ";

						$c_sql.= "c_addip		= '".$com[c_addip]."', ";

						$c_sql.= "site		= '".$com[site]."'  ";

						sql_query($c_sql);



						//원본테이블 코멘트 삭제

						sql_query("delete from $BC_table where c_bno='".$tmp_array[$i]."'");

					}

				}



				//첨부파일이 있을경우 복사

				$res_file = sql_query("select * from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

				$file_total = mysql_num_rows($res_file);

				if($file_total>0){

					while($file=sql_fetch_array($res_file)){

						$save_name =rand(100,999)."_".$file[bf_save_name];

						copy($default[AbsolutePath]."/bbs/data/".$Table."/".$file[bf_save_name],$_SERVER['DOCUMENT_ROOT']."/bbs/data/".$typedbname."/".$save_name);

						sql_query("insert into {$V_DB[bbsfile]} set bf_table='".$typedbname."', bf_tno='".$dep_no."', bf_fno='".$file[bf_fno]."', bf_save_name='".$save_name."', bf_real_name='".$file[bf_real_name]."', bf_down='".$file[bf_down]."', bf_time=now(), site='".$file[site]."'");



						//원본테이블 첨부파일 삭제

						sql_query("delete from {$V_DB[bbsfile]} where bf_table='".$Table."' and bf_tno='".$tmp_array[$i]."' ");

					}

				}

			}

		}



		alert("게시글이 이동되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table");





	break;





	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  리스트 여러글 삭제

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "LISTDEL" :

		// 글삭제 권한을 설정합니다.

		if($sess["userlevel"]<100) {

			alert("최고관리자만 관리 가능합니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}



		$tmp_array = $_POST["list_ck"];

		$tmp_array_cnt = count($tmp_array)-1;



		// 거꾸로 읽는 이유는 답변글부터 삭제가 되어야 하기 때문임

		for ($i=$tmp_array_cnt; $i>=0; $i--)

		{

			// 글을 가져옵니다.

			$BoardSql = " select * from $BB_table where b_no = '{$tmp_array[$i]}'";

			$view = sql_fetch($BoardSql);



			if($view["b_dep"] == 'A') {										//원본일경우... 답글까지 다 지운다.

				// 답글을 가져옵니다.

				$BoardSql = " select * from $BB_table where b_tno = '{$view[b_tno]}' ";

				$BoardResult = sql_query($BoardSql,FALSE);

				$BoardTotal = mysql_num_rows($BoardResult);

				for($B=0; $BReply=sql_fetch_array($BoardResult,FALSE); $B++) {

					FileDb_Delete($BReply["b_no"]);



					// 댓글을 사용하는 게시판이면

					if($Board_Admin["use_comment"]==TRUE) {

						$ctotal = sql_fetch("select count(*) as cnt from $BC_table where c_bno ='{$BReply[b_no]}' ");

						$BoardSql = "delete from $BC_table where c_bno ='{$BReply[b_no]}' ";

						sql_query($BoardSql);



						##################################################

						#	댓글삭제시 포인트제 적용

						#	2009.3.24 Ki-hong Park

						##################################################

						if($Board_Admin["point_comment"]>0&&$ctotal[cnt]>0){

							$userpoint = Get_member($sess['userid']);

							if($userpoint['mem_point']>0){

								sql_query("update ".$V_DB['member']." set mem_point=mem_point-".($Board_Admin['point_comment']*$ctotal[cnt])." where mem_id='".$sess['userid']."' ");

							}

						}



					}

				}

				$BoardSql="delete from $BB_table where b_tno = '{$view[b_tno]}' ";

			}else{

				FileDb_Delete($view["b_no"]);

				$BoardSql="delete from $BB_table where b_no = '{$tmp_array[$i]}' ";

				$BoardTotal = 1;

			}

			sql_query($BoardSql);



			##################################################

			#	답글(답변) 삭제시 포인트제 적용

			#	2009.3.25 Ki-hong Park

			##################################################

			if($Board_Admin["point_replay"]>0){

				$userpoint = Get_member($sess['userid']);

				if($userpoint['mem_point']>0){

					$redelpoint = ($BoardTotal>1)?($Board_Admin['point_replay']*($BoardTotal-1))+$Board_Admin['point_write']:$Board_Admin['point_write'];

					sql_query("update ".$V_DB['member']." set mem_point=mem_point-".$redelpoint." where mem_id='".$sess['userid']."' ");

				}

			}



			// 댓글을 사용하는 게시판이면

			if($Board_Admin["use_comment"]==TRUE) {

				$ctotal = sql_fetch("select count(*) as cnt from $BC_table where  c_bno ='$num' ");

				$BoardSql = "delete from $BC_table where c_bno ='$num' ";

				sql_query($BoardSql);



				##################################################

				#	댓글삭제시 포인트제 적용

				#	2009.3.24 Ki-hong Park

				##################################################

				if($Board_Admin["point_comment"]>0&&$ctotal[cnt]>0){

					$userpoint = Get_member($sess['userid']);

					if($userpoint['mem_point']>0){

						sql_query("update ".$V_DB['member']." set mem_point=mem_point-".($Board_Admin['point_comment']*$ctotal[cnt])." where mem_id='".$sess['userid']."' ");

					}

				}

			}

		}



		alert("게시글이 삭제되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



	break;





	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  글 삭제

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "DELETE" :

		// 글을 가져옵니다.

		$BoardSql = " select * from $BB_table where b_no = '$num'";

		$view = sql_fetch($BoardSql);



		// 글삭제 권한을 설정합니다.

		if($view["b_member"]==TRUE) {

			if($sess["userid"]!=$view["b_member"] && $sess["userlevel"]<100) alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($view["b_member"]==FALSE &&$_POST["passwd"]==FALSE && $sess["userlevel"]<100) {

			alert("비밀번호가 전달되지 않았습니다.","/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($_POST["passwd"]==TRUE) {

			$ChangePass = sql_password($_POST["passwd"]);

			if($view["b_passwd"]!=$ChangePass) alert("비밀번호가 맞지 않아 삭제하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}



		if($view["b_dep"] == 'A') {										//원본일경우... 답글까지 다 지운다.

			// 답글을 가져옵니다.

			$BoardSql = " select * from $BB_table where b_tno = '{$view[b_tno]}' ";

			$BoardResult = sql_query($BoardSql,FALSE);

			$BoardTotal = mysql_num_rows($BoardResult);

			for($B=0; $BReply=sql_fetch_array($BoardResult,FALSE); $B++) {

				FileDb_Delete($BReply["b_no"]);



				// 댓글을 사용하는 게시판이면

				if($Board_Admin["use_comment"]==TRUE) {

					$ctotal = sql_fetch("select count(*) as cnt from $BC_table where c_bno ='{$BReply[b_no]}' ");

					$BoardSql = "delete from $BC_table where c_bno ='{$BReply[b_no]}' ";

					sql_query($BoardSql);



					##################################################

					#	댓글삭제시 포인트제 적용

					#	2009.3.24 Ki-hong Park

					##################################################

					if($Board_Admin["point_comment"]>0&&$ctotal[cnt]>0){

						$userpoint = Get_member($sess['userid']);

						if($userpoint['mem_point']>0){

							sql_query("update ".$V_DB['member']." set mem_point=mem_point-".($Board_Admin['point_comment']*$ctotal[cnt])." where mem_id='".$sess['userid']."' ");

						}

					}



				}

			}

			$BoardSql="delete from $BB_table where b_tno = '{$view[b_tno]}' ";

		}else{

			FileDb_Delete($view["b_no"]);

			$BoardSql="delete from $BB_table where b_no = '$num' ";

			$BoardTotal = 1;

		}

		sql_query($BoardSql);



		##################################################

		#	답글(답변) 삭제시 포인트제 적용

		#	2009.3.25 Ki-hong Park

		##################################################

		if($Board_Admin["point_replay"]>0){

			$userpoint = Get_member($sess['userid']);

			if($userpoint['mem_point']>0){

				$redelpoint = ($BoardTotal>1)?($Board_Admin['point_replay']*($BoardTotal-1))+$Board_Admin['point_write']:$Board_Admin['point_write'];

				sql_query("update ".$V_DB['member']." set mem_point=mem_point-".$redelpoint." where mem_id='".$sess['userid']."' ");

			}

		}

		// 댓글을 사용하는 게시판이면

		if($Board_Admin["use_comment"]==TRUE) {

			$ctotal = sql_fetch("select count(*) as cnt from $BC_table where  c_bno ='$num' ");

			$BoardSql = "delete from $BC_table where c_bno ='$num' ";

			sql_query($BoardSql);



			##################################################

			#	댓글삭제시 포인트제 적용

			#	2009.3.24 Ki-hong Park

			##################################################

			if($Board_Admin["point_comment"]>0&&$ctotal[cnt]>0){

				$userpoint = Get_member($sess['userid']);

				if($userpoint['mem_point']>0){

					sql_query("update ".$V_DB['member']." set mem_point=mem_point-".($Board_Admin['point_comment']*$ctotal[cnt])." where mem_id='".$sess['userid']."' ");

				}

			}



		}



		 alert("게시글이 삭제되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



	break;





	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  답글(답변) 등록

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "REPLY" :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적으로 글을 쓰시기 바랍니다","/bbs/board.php?tbl=$Table&$NextUrl");



		// 권한을 체크합니다.

		if($sess["userlevel"]<$Board_Admin["level_reple"]) alert("답변하실 권한이 없습니다.","/bbs/board.php?tbl=$Table&$NextUrl");

		if($Board_Admin["use_reply"]==FALSE) alert("본 게시판은 답변 기능을 사용하실 수 없습니다.","/bbs/board.php?tbl=$Table&$NextUrl");



		// 글등록하기

		$BoardSql = "insert $BB_table set $Board_Invalue , b_modify = '$datetime', b_regist = '$datetime', b_addip = '{$_SERVER[REMOTE_ADDR]}', site = '{$default[site_code]}' ";

		sql_query($BoardSql);



		##################################################

		#	답글등록시 포인트제 적용

		#	2009.3.24 Ki-hong Park

		##################################################

		if($Board_Admin["point_replay"]>0){

			sql_query("update ".$V_DB['member']." set mem_point=mem_point+".$Board_Admin['point_replay']." where mem_id='".$sess['userid']."' ");

		}



		// 등록된 글의 번호를 불러옵니다.

		$num = mysql_insert_id();


		for($i=1;$i<=$Board_Admin["fileupnum"];$i++) {

			##### 등록파일이 있을경우

			if ($_FILES["b_file".$i]["name"])

			{

				$mess = FileDb_Input($_FILES["b_file".$i], $num, $i);

				if($mess==TRUE) alert($mess,$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

			}

		}



		alert("게시글이 등록되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  글 수정

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "MODIFY" :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적으로 글을 쓰시기 바랍니다",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 수정할 글을 가져옵니다.

		$BoardSql = " select * from $BB_table where b_no = '$num' ";

		$view = sql_fetch($BoardSql);



		// 권한을 체크합니다.

		if($sess["userlevel"]<$Board_Admin["level_write"]) alert("게시글을 작성하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		if($view["b_member"]==TRUE) {

			if(Member_check($view["b_member"])==FALSE) alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($view["b_member"]==FALSE &&$_POST["passwd"]==FALSE && $sess["userlevel"]<100) {

			alert("비밀번호가 전달되지 않았습니다.","/bbs/board.php?tbl=$Table&$NextUrl");

		}



		// 글수정하기

		$BoardSql = "update $BB_table set $Board_Invalue , b_modify = '$datetime', b_addip = '{$_SERVER[REMOTE_ADDR]}' where b_no = '$num' ";

		sql_query($BoardSql);



		for($i=1;$i<=$Board_Admin["fileupnum"];$i++) {

			if ($_POST[file_del][$i])

			{

				FileDb_Delete($num, $i);

			}

			##### 등록파일이 있을경우

			if ($_FILES["b_file".$i]["name"])

			{

				$mess = FileDb_Input($_FILES["b_file".$i], $num, $i);

				if($mess==TRUE) alert($mess,$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

			}

		}



		alert("게시글이 수정되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  댓글(코멘트) 입력

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "COMFORM" :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적으로 글을 쓰시기 바랍니다",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 권한을 체크합니다.

		if($sess["userlevel"]<$Board_Admin["level_com"]) alert("댓글을 작성하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		if($Board_Admin["use_comment"]==FALSE) alert("본 게시판은 댓글 기능을 사용하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 글입력하기

		$BoardSql = "insert $BC_table set $Comm_Invalue , c_modify = '$datetime', c_regist = '$datetime', c_addip = '{$_SERVER[REMOTE_ADDR]}', site = '{$default[site_code]}' ";

		sql_query($BoardSql);



		##################################################

		#	댓글등록시 포인트제 적용

		#	2009.3.24 Ki-hong Park

		##################################################

		if($Board_Admin["point_comment"]>0){

			sql_query("update ".$V_DB['member']." set mem_point=mem_point+".$Board_Admin['point_comment']." where mem_id='".$sess['userid']."' ");

		}



		goto_url($default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$c_bno&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  댓글(코멘트) 입력

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "COMMODIFY" :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적으로 글을 쓰시기 바랍니다",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		$row = sql_fetch("select * from $BC_table where c_bno='$num' and c_no='$cnum'");



		if($Get_Login && ($sess[userid] == $row[c_member] || $sess[userlevel] == 100)){

			sql_query("update $BC_table set c_content='".addslashes($c_content)."' where c_no='$cnum' ");

		}else{

			if($row[c_passwd] == sql_password($passwd)){

				sql_query("update $BC_table set c_writer='".$c_writer."', c_content='".addslashes($c_content)."' where c_no='$cnum' ");

			}else{

				alert('비밀번호가 일치하지 않습니다.');

				exit;

			}

		}



		goto_url($default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$num}&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  댓글(코멘트) 삭제

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "COMDEL" :



		// 권한을 체크합니다.

		if($sess["userlevel"]<$Board_Admin["level_com"]) alert("댓글을 작성하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		if($Board_Admin["use_comment"]==FALSE) alert("본 게시판은 댓글 기능을 사용하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 글을 가져옵니다.

		$BoardSql = " select * from $BC_table where c_no = '$num'";

		$view = sql_fetch($BoardSql);



		// 글삭제 권한을 설정합니다.

		if($_SESSION[sess][userlevel] < 100 && $view["c_member"]==FALSE && $_POST["passwd"]==FALSE) {

			alert("비밀번호가 전달되지 않았습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($view["c_member"]==TRUE) {

			if(Member_check($view["c_member"])==FALSE) alert("본인이 작성하신 글이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($_POST["passwd"]==TRUE) {

			$ChangePass = sql_password($_POST["passwd"]);

			if($view["c_passwd"]!=$ChangePass) alert("비밀번호가 맞지 않아 삭제하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		}



		$BoardSql = "delete from $BC_table where c_no ='$num' ";

		sql_query($BoardSql);



		##################################################

		#	댓글삭제시 포인트제 적용

		#	2009.3.24 Ki-hong Park

		##################################################

		if($Board_Admin["point_comment"]>0){

			$userpoint = Get_member($sess['userid']);

			if($userpoint['mem_point']>0){

				sql_query("update ".$V_DB['member']." set mem_point=mem_point-".$Board_Admin['point_comment']." where mem_id='".$sess['userid']."' ");

			}

		}

		if($_POST["passwd"]) goto_url($default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		else goto_url($default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  글 등록

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "WRITE" :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적으로 글을 쓰시기 바랍니다",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 권한을 체크합니다.

		if($sess["userlevel"]<$Board_Admin["level_write"]) alert("게시글을 작성하실 권한이 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");



		// 글입력하기

		$BoardSql = "insert $BB_table set $Board_Invalue , b_modify = '$datetime', b_regist = '$datetime', b_addip = '{$_SERVER[REMOTE_ADDR]}', site = '{$default[site_code]}' ";

		sql_query($BoardSql);



		##################################################

		#	글등록시 포인트제 적용

		#	2009.3.24 Ki-hong Park

		##################################################

		if($Board_Admin["point_write"]>0){

			sql_query("update ".$V_DB['member']." set mem_point=mem_point+".$Board_Admin['point_write']." where mem_id='".$sess['userid']."' ");

		}



		// 등록된 글의 번호를 불러옵니다.

		$num = mysql_insert_id();

// include Syndication Ping class
include '../syndi/libs/SyndicationHandler.class.php';
include '../syndi/libs/SyndicationPing.class.php';

$oPing = new SyndicationPing;
$iddd = SyndicationHandler::getTag('article', $num, $Table);
$oPing->setId($iddd);

// 사용시 주석제거
$oPing->request();



		for($i=1;$i<=$Board_Admin["fileupnum"];$i++) {

			##### 등록파일이 있을경우

			if ($_FILES["b_file".$i]["name"]){

				$mess = FileDb_Input($_FILES["b_file".$i], $num, $i);

				if(!$mess) alert($mess,$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

			}

		}
		$sqlt = "select * from v_plugin where id = '1'";
		$datat = sql_fetch($sqlt);
		$ar = unserialize($datat['api_tables']);
		if(@in_array($Table,$ar) && !empty($_POST['blogYn']))
		{
			$nblog_insert = newPost($b_subject,$mcontent,$_POST['blog_cat']);
		}

		//작성한글 쿠키저장

		@setcookie("ck_{$Table}_{$num}_hit", $num, time() + 3600, "/",$_SERVER["SERVER_NAME"]); // 1시간동안 저장



		if($Table == "esti" || $Table == "esti2"){

			alert("가입신청서가 접수되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}else{

			alert("게시글이 등록되었습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");

		}



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  글 추천하기

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "BEST" :

		referer_check();



		// 글을 가져옵니다.

		$BoardSql = " select b_no, b_member, b_bestid from $BB_table where b_no = '$num' ";

		$view = sql_fetch($BoardSql);



		// 권한을 체크합니다.

		if($Get_Login==FALSE) {

			 alert("로그인 하셔야 이용하실 수 있습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");

		}

		if($Board_Admin["use_best"]==FALSE) {

			 alert("추천할 수 있는 게시판이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");

		}

		if($view["b_no"]==FALSE) {

			 alert("추천하실 게시물이 존재하지 않습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($view["b_member"]==$sess["userid"]) {

			 alert("본인의 글은 추천하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}



	// 추천자 목록 체크

		$Chbest = 0;

		$InBest = explode("|",$view["b_bestid"]);

		$InBestCnt = count($InBest);

		for($i=0; $i<$InBestCnt; $i++) {

			if($InBest[$i] == $sess["userid"]) $Chbest = 1;

		}



		if($view["b_bestid"]==TRUE && $Chbest==TRUE) {

			alert("이미 추천하셨습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");

		}



		if($view["b_bestid"]==FALSE) {

			$b_bestid = "|{$sess[userid]}|";

		} else {

			$b_bestid = $view["b_bestid"]."{$sess[userid]}|";

		}



		// 추천자 등록하고, 추천수 올려주기

		$BoardSql = "update $BB_table set b_best = b_best+1, b_bestid = '$b_bestid' where b_no = '$num' ";

		sql_query($BoardSql);





		alert("추천해주셔서 감사합니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=$num&$NextUrl");



	break;



	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  댓글 추천하기

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	case "CBEST" :

		referer_check();



		// 글을 가져옵니다.

		$BoardSql = " select c_no, c_member, c_bestid, c_bno from $BC_table where c_no = '$num' ";

		$view = sql_fetch($BoardSql);



		// 권한을 체크합니다.

		if($view["c_no"]==FALSE) {

			 alert("추천하실 게시물이 존재하지 않습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}

		if($Get_Login==FALSE) {

			 alert("로그인 하셔야 이용하실 수 있습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		}

		if($Board_Admin["use_combest"]==FALSE) {

			 alert("추천할 수 있는 게시판이 아닙니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		}

		if($view["c_member"]==$sess["userid"]) {

			 alert("본인의 글은 추천하실 수 없습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		}



	// 추천자 목록 체크

		$Chbest = 0;

		$InBest = explode("|",$view["c_bestid"]);

		$InBestCnt = count($InBest);

		for($i=0; $i<$InBestCnt; $i++) {

			if($InBest[$i] == $sess["userid"]) $Chbest = 1;

		}



		if($view["c_bestid"]==TRUE && $Chbest==TRUE) {

			alert("이미 추천하셨습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");

		}



		if($view["c_bestid"]==FALSE) {

			$c_bestid = "|{$sess[userid]}|";

		} else {

			$c_bestid = $view["c_bestid"]."{$sess[userid]}|";

		}



		// 추천자 등록하고, 추천수 올려주기

		$BoardSql = "update $BC_table set c_best = c_best+1, c_bestid = '$c_bestid' where c_no = '$num' ";

		sql_query($BoardSql);





		alert("추천해주셔서 감사합니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num={$view[c_bno]}&$NextUrl");



	break;



	//메일 발송

	case "MAIL":

		//mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $charset="EUC-KR", $cc="", $bcc="")



		mailer($sender, $sess[email], $reciver, $subject, $content);

		echo "<script>alert('전송하였습니다.'); self.close();</script>";

		exit;

	break;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////  비밀번호 확인창

	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	default :

		referer_check();

		if(getenv("REQUEST_METHOD") == 'GET' ) alert("정상적인 접근이 아닙니다.","/bbs/board.php?tbl=$Table&$NextUrl");



		// 원본글의 비밀번호를 가져옵니다.

		$BoardSql = " select b_passwd from $BB_table where b_no = '$num' ";

		$view = sql_fetch($BoardSql);

		$Getitpass = $view["b_passwd"];



		// 관련모드 코드를 확인후 전달할 주소를 확인합니다.

		if($type=="MODIFY") {

			$Gonexturl = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=$type&num=$num&$NextUrl";

		} else if($type=="DELETE") {

			$Gonexturl = $default[AbsoluteUrl]."/bbs/process.php?tbl=$Table&mode=DELETE&num=$num&$NextUrl";

		}



		if($_POST["passwd"]==TRUE) {

			$ChangePass = sql_password($_POST["passwd"]);

		} else {

			alert("비밀번호가 전달되지 않았습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		}



		if($Getitpass!=$ChangePass) {

			alert("비밀번호가 맞지 않습니다.",$default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&$NextUrl");

		} else {

			goto_url($Gonexturl);

		}



	break;



}

?>