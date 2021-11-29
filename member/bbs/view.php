<?
		/// 조회수를 변경합니다.
			if ($_COOKIE["ck_{$Table}_{$num}_hit"] != $num) {
				sql_query(" update $BB_table set b_hit = b_hit + 1 where b_no = '$num' "); // 1증가
				setcookie("ck_{$Table}_{$num}_hit", $num, time() + 3600, "/",$_SERVER["SERVER_NAME"]); // 1시간동안 저장
			}

	//########## 여기부터 게시글을 보기위한 변수들을 설정합니다 ######################//

		// 파일 테이블에서 해당하는 파일 정보를 불러옵니다.
		$Get_File_sql= "select* from {$V_DB[bbsfile]} where bf_table = '$Table' and bf_tno = '$num' order by bf_fno";
		$Get_File_result = sql_query($Get_File_sql,FALSE);
		$imgFile = "";
		$downTag = "";
		//다운파일이 있으면
		for ($i=1; $Get_File=sql_fetch_array($Get_File_result,FALSE); $i++) {
			if($Get_File["bf_no"] && $Board_Admin["use_data"]==TRUE) {
				##### 등록파일이 있을경우
				if($Get_File["bf_save_name"]) {
					$getsavename = $Get_File["bf_save_name"];
					$getfilename = $Get_File["bf_real_name"];
					//이미지 파일의 경우 화면에서 출력
					$size=@GetImageSize($default[AbsolutePath]."/bbs/data/$Table/".$getsavename);	// 이미지 싸이즈 추출
					$resize = ($size[0]> $Board_Admin["imgsize"]) ? $Board_Admin["imgsize"] : $size[0];

					$ext = file_type($getfilename);

					if(!strCmp($ext,"jpeg") || !strCmp($ext,"jpg") || !strCmp($ext,"gif") || !strCmp($ext,"png") || !strCmp($ext,"bmp")) {
						$imgFile .= "<img src='/bbs/data/".$Table."/".$getsavename."' name='target_resize_image[]' style=\"cursor:pointer;\" onclick=\"image_window(this);\"><br><br>";
						$view["img_".$i] = "/bbs/data/$Table/$getsavename";
					}else if(!strCmp($ext,"mov") || !strCmp($ext,"wmv") || !strCmp($ext,"avi") || !strCmp($ext,"asf") || !strCmp($ext,"asx") || !strCmp($ext,"mpeg") || !strCmp($ext,"mpg")) {
						$imgFile .= "<embed src='/bbs/data/".$Table."/".$getsavename."' autostart=true></embed><br><br>";
					} else {
						$view["img_".$i] = "";
					}
					if($downTag!="") $downTag .= " | ";
					$downTag .= "<img src='/images/common/icon/icon_data.gif' /> <a href='".$default[AbsoluteUrl]."/bbs/download.php?tbl=$Table&no={$Get_File[bf_no]}'>{$getfilename}</a>";
				}
			}
		}

		// Link 필드가 있으면
		if($view['b_link1']) {
			$view['b_link1'] = get_text($view['b_link1']);
			$linkUrl1 = str_replace("http://","",$view['b_link1']);
			$linkUrl = "<a href='http://".$linkUrl1."' target='_blank'>http://".cut_str($linkUrl1,60)."</a>";
		}
		if($view['b_link2']) {
			$view['b_link2'] = get_text($view['b_link2']);
			$linkUrl2 = str_replace("http://","",$view['b_link2']);
			if($view['b_link1']) $linkUrl .= "<br><a href='http://".$linkUrl2."' target='_blank'>http://".cut_str($linkUrl2,100)."</a>";
			else $linkUrl = "http://".$linkUrl2;
		}


		//html 사용을 허가 한다면...
		if($view["b_html"]==FALSE) {
			$view["content"] = conv_content(stripslashes($view["b_content"]),0);
		} else {
			$view["content"] = conv_content(stripslashes($view["b_content"]),$view["b_html"]);
		}

		// 이미지 태그가 있다면 확대보기 스크립트삽입
		$view["content"] = getAllImgOutput($view["content"]);

		$view["subject"] = get_text(stripslashes($view["b_subject"]));
		$view["b_writer"] = get_text(stripslashes($view["b_writer"]));
		$view["b_email"] = get_text(stripslashes($view["b_email"]));

		////////////////////// 카테고리 등록 게시판이면
		if($Board_Admin["use_category"] == "1") {
			if($view["b_category"]==FALSE){

				if($Board_Admin["chr"] == "eng"){
					$view["b_category"] = "All";
				}else{
					$view["b_category"] = "전체";
				}

			}
			$view["category"] = "[{$view[b_category]}]";
		}

	//########## 여기부터 게시글을 보기위한 변수들을 설정합니다 ######################//
		//2009.3.25 Ki-hong Park [이전글 다음글 표시]
		$pre_next_result = sql_query("select b_no from $BB_table where b_dep='A' ".$List_Order);
		for($j=0;$pre_next=mysql_fetch_array($pre_next_result);$j++){
			$array[$j] = $pre_next[b_no];
		}
		for($k=0;$k<count($array);$k++){
			if($array[$k] == $num){
				$pre_no = $array[$k - 1];
				$next_no = $array[$k + 1];
			}
		}
		if($pre_no!=""){
			$go_pre = sql_fetch(" select b_no,b_subject from $BB_table where b_no='$pre_no' ");
			$Url["pre"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=".$go_pre[b_no]."&$NextUrl";
		}else{
			$Url["pre"] = "";
		}
		if($next_no!=""){
			$go_next = sql_fetch(" select b_no,b_subject from $BB_table where b_no='$next_no' ");
			$Url["next"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=VIEW&num=".$go_next[b_no]."&$NextUrl";
		}else{
			$Url["next"] = "";
		}

		// 링크 변수를 설정합니다.
		if($sess["userlevel"] >= $Board_Admin["level_write"]) {
			if($Get_Login==TRUE && ($sess["userid"]==$view["b_member"] || $sess["userlevel"]==100)) {
				$Url["modify"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=MODIFY&num=$num&$NextUrl";
				$Url["delete"] = $default[AbsoluteUrl]."/bbs/process.php?tbl=$Table&mode=DELETE&num=$num&$NextUrl";
			} else {
				$Url["modify"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=".$Table."&mode=PASS&type=MODIFY&num=".$num."&".$NextUrl;
				$Url["delete"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=PASS&type=DELETE&num=$num&$NextUrl";
			}
		} else {
			$Url["modify"] = "";
			$Url["delete"] = "";
		}
		if($Board_Admin["use_reply"]==TRUE && $sess["userlevel"] >= $Board_Admin["level_reple"]) {
			$Url["reply"] = $default[AbsoluteUrl]."/bbs/board.php?tbl=$Table&mode=REPLY&num=$num&$NextUrl";
		} else {
			$Url["reply"] = "";
		}
		if($Board_Admin["use_best"]==TRUE && $Get_Login==TRUE) {
			$Url["best"] = $default[AbsoluteUrl]."/bbs/process.php?tbl=$Table&mode=BEST&num=$num&$NextUrl";
		} else {
			$Url["best"] = "";
		}

?>