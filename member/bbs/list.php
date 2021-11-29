<?
	/////////////////////// 주소 변수 / 다음페이지 설정
	$NextUrl = "chr=$chr&amp;category=$category&amp;findType=$findType&amp;findWord=$findWord&amp;sort1=$sort1&amp;sort2=$sort2";

	$Search_Where = "where 1 ";
	//////////////////////////검색 하고자 하는 단어가 있으면
	if($findWord==TRUE){
		if($findType=="title") $findfile="b_subject";
		else if($findType=="name") $findfile="b_writer";
		else if($findType=="content") $findfile="b_content";


		$findword = urldecode($findWord); // search field (검색 필드)
		if($findfile) $Search_Where .="and $findfile like '%$findword%' ";
		else{
			 $Search_Where .=" and (b_subject like '%$findword%' or b_writer like '%$findword%' or b_content like '%$findword%') ";
		}
		$findword = stripslashes($findword); // search field (검색 필드)
	}
	//////////////////////////검색 하고자 하는 분류가 있으면
	if($category!='') {
		$Search_Where .= "and b_category = '$category' ";
	}

	////////////////////// 카테고리 등록 게시판이면
	if($Board_Admin["use_category"] == TRUE) {
		if($Board_Admin["chr"] == "eng"){
			$Category_option = Get_BoardCate_eng($Board_Admin["category"],$category);		
		}else{
			$Category_option = Get_BoardCate($Board_Admin["category"],$category);
		}

	}

// 테이블의 전체 레코드수만 얻음
	$BoardSql = " select count(*) as cnt from $BB_table $Search_Where";
	$row = sql_fetch($BoardSql,FALSE);
	$total_count = $row[cnt];

	$rows = $Board_Admin["page_rows"];
	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함
	// 페이지별 시작번호
	$cur_num=$total_count - ($Board_Admin["page_rows"]*($page-1));

	// 게시물 리스트를 불러옵니다.
	$BoardSql = " select a.*, count(b.c_no) as comment from $BB_table a left join $BC_table b on (a.b_no = b.c_bno) $Search_Where group by b_no $List_Order limit $from_record, $rows";
	//echo $BoardSql;
	$BoardResult = sql_query($BoardSql,FALSE);
	for($B=0; $row=sql_fetch_array($BoardResult,FALSE); $B++) {
		$list[$B] = $row;

		// 게시글 강제번호
		$list[$B]["no"] = $cur_num - $B;

		$list[$B]["subject"] =get_text(stripslashes($row["b_subject"]));
		$list[$B]["b_writer"] = get_text(stripslashes($row["b_writer"]));
		$list[$B]["content"] = conv_content(stripslashes($row["b_content"]),$row["b_html"]);
		$list[$B]["hit"] = number_format($row["b_hit"]);
		$list[$B]["best"] = number_format($row["b_best"]);
		
		// 블로그형 게시판일시 list 에서 수정 삭제 확인 링크 설정
		if ($Board_Admin['skin']=="gallery_view"){
			if($Get_Login==TRUE && ($sess["userid"]==$row["b_member"] || $sess["userlevel"]==100)) {
				$list[$B][url]["modify"] = $default[AbsoluteUrl]."/bbs/board.php?tbl={$Table}&amp;mode=MODIFY&amp;num={$row[b_no]}&amp;{$NextUrl}";
				$list[$B][url]["delete"] = $default[AbsoluteUrl]."/bbs/process.php?tbl={$Table}&amp;mode=DELETE&amp;num={$row[b_no]}&amp;{$NextUrl}";
			} else {
				$list[$B][url]["modify"] = $default[AbsoluteUrl]."/bbs/board.php?tbl={$Table}&amp;mode=PASS&amp;type=MODIFY&amp;num={$row[b_no]}&amp;{$NextUrl}";
				$list[$B][url]["delete"] = $default[AbsoluteUrl]."/bbs/board.php?tbl={$Table}&amp;mode=PASS&amp;type=DELETE&amp;num={$row[b_no]}&amp;{$NextUrl}";
			}
		}

		if($row["comment"] > 0) { $list[$B]["comment"] = "<span class='comment'>[".number_format($row["comment"])."]</span>"; } else { $list[$B]["comment"] = "";}

		// 카테고리 등록 게시판이면
		if($Board_Admin["use_category"] == "1") {

			if($row["b_category"]==FALSE){

				if($Board_Admin["chr"] == "eng"){
				 $list[$B]["b_category"] = "All";
				}else{
				 $list[$B]["b_category"] = "전체";
				}

			}
		}

			## 비밀글이면 제목에 아이콘 추가
			if($row["b_secret"]==TRUE) {
					$sbutton = $default["AbsolutePath"]."/images/common/icon/icon_secret.gif";
					if (file_exists($sbutton)) {
						$list[$B]["secret"] = "<span><img src='/images/common/icon/icon_secret.gif' alt='비밀' /></span>";
					} else {
						$list[$B]["secret"] = "[S]";
					}
			}
			## 공지글이면 글번호에 아이콘 추가
			if($row["b_notice"]==TRUE) {
					$sbutton = $default["AbsolutePath"]."/images/common/icon/icon_notice.gif";
					if (file_exists($sbutton)) {
						$list[$B]["num"] = "<img src='/images/common/icon/icon_notice.gif' alt='공지' />";
						$list[$B]["no"] = "<img src='/images/common/icon/icon_notice.gif' alt='공지' />";
					} else {
						$list[$B]["num"] = "공지";
						$list[$B]["no"] = "공지";
					}
			} else {
						$list[$B]["num"] = $row["b_tno"];
			}
			## 새로 등록된 글이라면, 제목에 아이콘 추가
			$newdate = date("Y-m-d h:i:s",time() - 86400);
			if($row["b_modify"] > $newdate)  {
					$sbutton = $default["AbsolutePath"]."/images/common/icon/icon_new.gif";
					if (file_exists($sbutton)) {
						$list[$B]["new"] = "<span><img src='/images/common/icon/icon_new.gif' alt='새글' /></span>";
					} else {
						$list[$B]["new"] = "[N]";
					}
			}

		// 게시글 제목 설정
			## 답글일 경우 제목 들여쓰기
			$depth="";
			$depth_num="";
			$length=strlen($row["b_dep"]);
			## 답변 아이콘 초기화
			$list[$B]["reicon"] = "";
			if($length !=1) {
				for($k=2;$k<=$length;$k++) {
					//들여쓰기
					$depth_num=$depth_num."";
				}
				$list[$B]["reicon"] = $depth_num."<span><img src='/images/common/icon/icon_re.gif' alt='└[RE]'/><span>";
			}
			## 제목글 자르기
			if($Board_Admin["listsubject"]>0) {
				$SubCutStr = $Board_Admin["listsubject"] + ($length*3) + 6; // [제목글자수] + ( [들여쓰기횟수] * [들여쓰기공간] ) + [아이콘공간]
				$list[$B]["subject"] = $list[$B]["reicon"].cut_str($list[$B]["subject"],$SubCutStr);
			} else {
				$list[$B]["subject"] = $list[$B]["reicon"].$list[$B]["subject"];
			}

			if($row["b_notice"]==TRUE) {
				$list[$B]["subject"] = "<b>".$list[$B]["subject"]."</b>";
			}



//		// 파일 테이블에서 해당하는 파일 정보를 불러옵니다.
//		$Get_File_sql= "select* from {$V_DB[bbsfile]} where bf_table = '$SubTable' and bf_tno = '{$row[b_no]}' order by bf_fno";
//		$Get_File_result = sql_query($Get_File_sql,FALSE);
//		//다운파일이 있으면
//		for ($i=1; $Get_File=sql_fetch_array($Get_File_result,FALSE); $i++) {
//			if($Get_File["bf_save_name"] && $Board_Admin["use_data"]==TRUE) {
//				##### 등록파일이 있을경우
//					$getsavename = $Get_File["bf_save_name"];
//					$getfilename = $Get_File["bf_real_name"];
//					//이미지 파일의 경우 화면에서 출력
//					$size=@GetImageSize($default[AbsolutePath]."/bbs/data/$SubTable/".$getsavename);	// 이미지 싸이즈 추출
//					$resize = ($size[0]> $Board_Admin["imgsize"]) ? $Board_Admin["imgsize"] : $size[0];
//
//					$ext = file_type($getsavename);
//
//					if(!strCmp($ext,"jpg") || !strCmp($ext,"jpeg") || !strCmp($ext,"gif") || !strCmp($ext,"png") || !strCmp($ext,"bmp")) {
//						$list[$B]["img_".$i] = $default[AbsoluteUrl]."/bbs/data/$SubTable/$getsavename";
//
//						$img_width = $Board_Admin["listwidth"]; 
//						$img_height = $Board_Admin["listheight"];
//						$img_quality = 95;
//
//						$data_path  = $default[AbsolutePath]."/bbs/data/$SubTable";
//						$thumb_path = $data_path.'/thumb';
//						
//						@mkdir($thumb_path, 0707);
//						@chmod($thumb_path, 0707);
//
//						$list[$B]["thumb"] = $thumb_path.'/'.$list[$B][b_no];
//
//
//						// 썸네일 이미지가 존재하지 않는다면
//						if (!file_exists($list[$B]["thumb"])) {
//
//							$file = $default[AbsolutePath].$list[$B]["img_1"];
//
//
//							// 업로드된 파일이 이미지라면
//							if (preg_match("/\.(jp[e]?g|gif|png)$/i", $file) && file_exists($file)) {
//
//
//								$size = @getimagesize($file);
//								if ($size[2] == 1)
//									$src = @imagecreatefromgif($file);
//								else if ($size[2] == 2)
//									$src = @imagecreatefromjpeg($file);
//								else if ($size[2] == 3)
//									$src = @imagecreatefrompng($file);
//								else
//									break;
//
//
//								$rate = $img_width / $size[0];
//								$height = (int)($size[1] * $rate);
//
//								// 계산된 썸네일 이미지의 높이가 설정된 이미지의 높이보다 작다면
//								if ($height < $img_height)
//									// 계산된 이미지 높이로 복사본 이미지 생성
//									$dst = imagecreatetruecolor($img_width, $height);
//								else
//									// 설정된 이미지 높이로 복사본 이미지 생성
//								$dst = @imagecreatetruecolor($img_width, $img_height);
//								@imagecopyresized($dst, $src, 0, 0, 0, 0, $img_width, $height, $size[0], $size[1]);
//								//@imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $height, $size[0], $size[1]);
//								if ($size[2] == 1)
//									@imageGIF($dst, $thumb_path.'/'.$list[$B][b_no]);
//								else if ($size[2] == 2)
//									@imageJPEG($dst, $thumb_path.'/'.$list[$B][b_no], $img_quality);
//								else if ($size[2] == 3)
//									@imagePNG($dst, $thumb_path.'/'.$list[$B][b_no]);
//								else
//									break;
//
//								@chmod($thumb_path.'/'.$list[$B][b_no], 0606);
//							}
//						}else{
//
//							$save_thumb[$B] = $default[AbsoluteUrl]."/bbs/data/$SubTable/thumb/".$list[$B][b_no];
//						}
//
//					} else if(!strCmp($ext,"mov") || !strCmp($ext,"wmv") || !strCmp($ext,"avi") || !strCmp($ext,"asf") || !strCmp($ext,"asx") || !strCmp($ext,"mpeg") || !strCmp($ext,"mpg")) {
//						$list[$B]["img_".$i] = "{$Board_Admin[skin_dir]}/images/media_img.gif";
//					} else {
//						$list[$B]["img_".$i] = "{$Board_Admin[skin_dir]}/images/no_img.jpg";
//					}
//			}
//		}
//		-->


			// 파일 테이블에서 해당하는 파일 정보를 불러옵니다.
		$Get_File_sql= "select* from {$V_DB[bbsfile]} where bf_table = '$SubTable' and bf_tno = '{$row[b_no]}' order by bf_fno";
		$Get_File_result = sql_query($Get_File_sql,FALSE);
		//다운파일이 있으면
		for ($i=1; $Get_File=sql_fetch_array($Get_File_result,FALSE); $i++) {
			if($Get_File["bf_save_name"] && $Board_Admin["use_data"]==TRUE) {
				##### 등록파일이 있을경우
					$getsavename = $Get_File["bf_save_name"];
					$getfilename = $Get_File["bf_real_name"];
					//이미지 파일의 경우 화면에서 출력
					$size=@GetImageSize($default[AbsolutePath]."/bbs/data/$SubTable/".$getsavename);	// 이미지 싸이즈 추출
					$resize = ($size[0]> $Board_Admin["imgsize"]) ? $Board_Admin["imgsize"] : $size[0];

					$ext = file_type($getsavename);

					if(!strCmp($ext,"jpg") || !strCmp($ext,"jpeg") || !strCmp($ext,"gif") || !strCmp($ext,"png") || !strCmp($ext,"bmp")) {
						$list[$B]["img_".$i] = $default[AbsoluteUrl]."/bbs/data/$SubTable/$getsavename";
					} else if(!strCmp($ext,"mov") || !strCmp($ext,"wmv") || !strCmp($ext,"avi") || !strCmp($ext,"asf") || !strCmp($ext,"asx") || !strCmp($ext,"mpeg") || !strCmp($ext,"mpg")) {
						$list[$B]["img_".$i] = "{$Board_Admin[skin_dir]}/images/media_img.gif";
					} else {
						$list[$B]["img_".$i] = "{$Board_Admin[skin_dir]}/images/no_img.jpg";
					}
			}
		}

		if($i==1) {
			$list[$B]["img_1"] = $Board_Admin["skin_dir"]."/images/no_img.jpg";
		}

		if($save_thumb[$B]){
			$list[$B]["img_1"] = $save_thumb[$B];
		}


		// 글보기 링크 설정
		if($sess["userlevel"] >= $Board_Admin["level_view"]) {
			if($row["b_secret"]==TRUE && $row["b_dep"]=="A") {
				if($Get_Login==TRUE && Member_check($row["b_member"])==TRUE) {
					$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=VIEW&amp;num={$row[b_no]}&$NextUrl&amp;page=$page";
				} else if($row["b_member"]==FALSE) {
					if($_COOKIE["ck_{$Table}_{$row[b_no]}_hit"] != $row[b_no]){
						$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=PASS&amp;type=VIEW&amp;num=".$row[b_no]."&".$NextUrl."&amp;page=".$page;
					}else{
						$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=VIEW&amp;num={$row[b_no]}&$NextUrl&amp;page=$page";
					}
				} else {
					$list[$B]["viewUrl"] ="javascript:alert('본인이 쓴 글이 아니면 열람하실 수 없습니다.');";
				}
			// 비밀글이며, 답변글일 경우
			} else if($row["b_secret"]==TRUE && strlen($row["b_dep"])>1) {
				// 원본글을 가져옵니다.
				$dep = substr($row["b_dep"],0,strlen($row["b_dep"])-1);
				$BoardSql_old = " select b_no,b_member from $BB_table where b_tno = '{$row[b_tno]}' and b_dep='$dep' ";
				$old = sql_fetch($BoardSql_old);
				// 관리자,원본글작성자,본글작성자가 아닐경우
					if($Get_Login==TRUE && ( Member_check($row["b_member"])==TRUE || $old["b_member"]==$sess["userid"] ) ) {
						$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=VIEW&amp;num={$row[b_no]}&$NextUrl&amp;page=$page";
					} else if($row["b_member"]==FALSE || $old["b_member"]==FALSE) {
						if($_COOKIE["ck_{$Table}_{$row[b_no]}_hit"] != $row[b_no]){
							$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=PASS&amp;type=VIEW&amp;num=".$row[b_no]."&".$NextUrl."&amp;page=".$page;
						}else{
							$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=VIEW&amp;num={$row[b_no]}&$NextUrl&amp;page=$page";
						}
					} else {
						$list[$B]["viewUrl"] ="javascript:alert('본인이 쓴 글이 아니면 열람하실 수 없습니다.');";
					}
			} else {
				$list[$B]["viewUrl"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&amp;mode=VIEW&amp;num={$row[b_no]}&$NextUrl&amp;page=$page";
			}
		} else {
			$list[$B]["viewUrl"] ="javascript:alert('게시글 열람 권한이 없습니다.');";
		}
	}
	$list_total = count($list);

	if($mode=="VIEW") $PageNext = "mode=$mode&amp;num=$num"; else $PageNext = "";
	$PageLinks = get_paging($Board_Admin[page_block], $page, $total_page, "$_SERVER[PHP_SELF]?tbl=$Table&amp;$PageNext&$NextUrl&amp;page=");
	$PageLinksBtn = get_paging_btn($Board_Admin[page_block], $page, $total_page, "$_SERVER[PHP_SELF]?tbl=$Table&amp;$PageNext&$NextUrl&amp;page=");
?>