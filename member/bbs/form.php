<?
		////////////////////// 카테고리 등록 게시판이면
		if($Board_Admin["use_category"] == TRUE) {
			if($view["b_category"] == TRUE) {
				$Category_option = Get_BoardCate($Board_Admin["category"],$view["b_category"]);
			} else {
				$Category_option = Get_BoardCate($Board_Admin["category"],$category);
			}
		}

		$content = get_text(stripslashes($view["b_content"]));
		$view["b_subject"] = get_text(stripslashes($view["b_subject"]));
		$view["b_writer"] = get_text(stripslashes($view["b_writer"]));
		$view["b_email"] = get_text(stripslashes($view["b_email"]));

		if($Board_Admin["use_notice"]==TRUE && $Board_Admin["level_notice"] <= $sess["userlevel"]) {
			$checked = ($view["b_notice"]==TRUE)?"checked":"";
			$Input_Notice = "<input type='checkbox' class='check' name='b_notice' value='1' $checked /> 공지";
		}
		if($Board_Admin["use_html"]==TRUE){
			if($Board_Admin["level_html"] <= $sess["userlevel"]){
				$Input_Html = "<input type='hidden' name='b_html' value='1' />";
			}else{
				$Input_Html = "<input type='hidden' name='b_html' value='0' />";
			}
		}
		if($Board_Admin["use_secret"]==TRUE) {
			if($mode=="MODIFY") $checked = ($view["b_secret"]==TRUE)?"checked":"";
			else  $checked = "checked";
			$Input_Secret = "<input type='checkbox' class='check' name='b_secret' value='1' $checked /> 비밀";
		}
		if($Board_Admin["use_asecret"]==TRUE) {
			$Input_Secret = "<input type='hidden' name='b_secret' value='1' />";
		}

		////////////////////// 파일 업로드 게시판이면
		if($Board_Admin["use_data"]==TRUE) {
			$file_script = "";
			$file_length = -1;

			// 파일 테이블에서 해당하는 파일 정보를 불러옵니다.
			$Get_File_sql= "select * from {$V_DB[bbsfile]} where bf_table = '$Table' and bf_tno = '$num' ";
			$Get_File_result = sql_query($Get_File_sql,FALSE);
			//다운파일이 있으면
			for ($i=1; $Get_File=sql_fetch_array($Get_File_result,FALSE); $i++) {
				if($Get_File["bf_no"]) {
					$i = $Get_File["bf_fno"];
					##### 등록파일이 있을경우
					if($Get_File["bf_save_name"]) {
						$getsavename = $Get_File["bf_save_name"];
						$getfilename = $Get_File["bf_real_name"];
						//파일 삭제 선택 INPUT 을 넣어줍니다.
						$view[file][$i] = "$getfilename <input type='checkbox' class='check' name='file_del[$i]' value='1' /> 삭제";
					}
				}
			}
			$file_length = $i;
		}

		// 에디터를 사용하기 위한 부분입니다.
		if($Board_Admin["use_html"]==TRUE && $Board_Admin["level_html"] <= $sess["userlevel"]){

			$EditorPath = $default[AbsoluteUrl]."/admin/editor/".$Board_Admin["editor"];
			if($Board_Admin["editor"] == "gmeditor"){	
			
				global $content,$upload_image,$upload_media,$msg;							
				
				// 내용
				$content = $view["b_content"];		
				// 이미지 업로드 사용
				$upload_image = "";
				// 미디어 업로드 사용
				$upload_media = "";	
								
				

				$editor_Url=$EditorPath;
				$formName = "writeform";
				$contentForm = "b_content";
				$textWidth = "100%";
				$textHeight = "400";				
				$lang = "utf-8";								
				
			
			
				if(empty($editor_Url)) $editor_Url = '.';
				if(empty($formName)) $formName = 'WriteFrm';
				if(empty($contentForm)) $contentForm = 'tcomment';
				$textWidth = $textWidth ? $textWidth : '100%';
				$textHeight = $textHeight ? $textHeight : '200';
				$lang = $lang ? $lang : 'utf-8';
				
				
				$FormChkScript = "form.b_content.value = SubmitHTML();
					  			  if(!form.b_content.value){
									alert('내용을 입력하세요!');
									return false;
								  }";	

				$EngFormChkScript = "form.b_content.value = SubmitHTML();
					  			  if(!form.b_content.value){
									alert('Plese enter contents.');
									return false;
								  }";	
		
				$TextArea = "<script language='javascript' src='$editor_Url/languages/$lang/java.lang.js'></script>
								 <script language=\"javascript\">
								 	var _editor_url = '$editor_Url';
								 	var _contentValue = '$contentForm';
								 	var _contentName = '$formName';
								 	var _i_uploaded = '$upload_image';
									var _m_uploaded = '$upload_media';

								 </script>
								 <table border=\"0\" cellpadding=\"1\" cellspacing=\"0\" width=\"98%\">
									<tr>
										<td bgcolor=\"#EFEFEF\" style=\"padding:10px;\">
											<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
												<tr>
													<td height=\"28\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_4.gif\" border=\"0\" align=\"absmiddle\" onClick=\"newDoc()\" title=\"새문서\">
													<img style=\"cursor:hand;\" src=\"$EditorPath/img/edit_1.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('cut')\" title=\"자르기\">
													<img style=\"cursor:hand;\" src=\"$EditorPath/img/edit_2.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('copy')\" title=\"'복사\">
													<img style=\"cursor:hand;\" src=\"$EditorPath/img/edit_3.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('paste')\" title=\"붙여넣기\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_5.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('outdent')\" title=\"내여쓰기\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_6.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('indent')\" title=\"들여쓰기\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_7.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('superscript')\" title=\"위첨자\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_8.gif\" 	border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('subscript')\" title=\"아래첨자\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_9.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('undo')\" title=\"뒤로\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_10.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('redo')\" title=\"앞으로\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_5.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('justifyleft')\" title=\"좌측정렬\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_6.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('justifycenter')\" title=\"중앙정렬\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_7.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('justifyright')\" title=\"우측정렬\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_10.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('insertorderedlist')\" title=\"숫자로 된 목록\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_11.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('insertunorderedlist')\" title=\"점으로 된 목록\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_18.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('inserthorizontalrule');\" title=\"가로선\">
													</td>
												</tr>
												<tr>
													<td height=\"28\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_11.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('fontname',4);\" title=\"글꼴\" >
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/edit_12.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('fontsize',7);\" title=\"글자 크기\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_1.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('bold');\" title=\"'진하게\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_2.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('italic')\" title=\"이탤릭\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_3.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('strikethrough')\" title=\"취소선\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_4.gif\" border=\"0\" align=\"absmiddle\" onClick=\"htmltrue('underline')\" title=\"밑줄\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_8.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('forecolor',5);\" title=\"글자색\" >
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_9.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('hilitecolor',6);\" title=\"글자 배경색'\" >
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_12.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('CreateLink',8);\" title=\"하이퍼링크 만들기\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_16.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',1);\" title=\"표 삽입\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_19.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',2);\" title=\"특수문자\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_20.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('InsertImage',3);\" title=\"이모티콘\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_13.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',9);\"  title=\"이미지\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_14.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',10);\" title=\"미디어\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_22.gif\" border=\"0\" align=\"absmiddle\" onClick=\"zoom_click();\" title=\"화면확대\">
													<span id=\"zoomin\" style=\"position:absolute;z-index:1\"></span>
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_17.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',11);\" title=\"HTML편집\">
													<img style=\"cursor:hand;cursor:pointer;\" src=\"$EditorPath/img/item_21.gif\" border=\"0\" align=\"absmiddle\" onClick=\"createHTML('',12);\" title=\"미리보기\">
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table BORDER=\"1\" WIDTH=100% cellspacing=\"0\" bordercolor=\"#EFEFEF\" bordercolordark=\"white\" bordercolorlight=\"#DBDBDB\">
												<tr>
													<td>
													<iframe id=\"gmEditor\" WIDTH=\"$textWidth\" HEIGHT=\"$textHeight\" scrolling=\"auto\" border=1 frameborder=0 framespacing=0 hspace=0 marginheight=0 marginwidth=0 vspace=0></iframe>

													<textarea cols=0 rows=0 style=\"display:none;\" wrap='physical' name=\"$contentForm\">$content</textarea>
													<input type=\"hidden\" name=\"editor_url\" id=\"editor_url\" value=\"$editor_Url\" />
													<input type=\"hidden\" name=\"editor_stom\" id=\"editor_stom\" value=\"$lang\" />
													<script type=\"text/javascript\" src='$editor_Url/gmEditor.js'></script>
													</td>
												</tr>
						 			 		</table>
										</td>
								</tr>
							</table>";
				
			}elseif($Board_Admin["editor"] == "cheditor"){
				$FormChkScript = "myeditor.outputBodyHTML();
								  if(!form.b_content.value){
									alert('내용을 입력하세요!');
									return false;
								  }";

				$EngFormChkScript = "myeditor.outputBodyHTML();
								  if(!form.b_content.value){
									alert('Plese enter contents.');
									return false;
								  }";


				$TextArea = "<textarea id=\"b_content\" name=\"b_content\" style=\"display:none\">".$content."</textarea>
							<script type=\"text/javascript\" language=\"javascript\" src=\"".$EditorPath."/cheditor.js\"></script>
							<script type=\"text/javascript\" language=\"javascript\">
								var myeditor = new cheditor('myeditor');
								myeditor.config.editorHeight = '200px';             // 에디터 세로폭입니다.
								myeditor.config.editorWidth = '100%';               // 에디터 가로폭입니다.
								myeditor.config.editorPath = '".$EditorPath."';     // 에디터 설치 경로입니다.
								myeditor.inputForm = 'b_content';                   // 입력 textarea의 ID 이름입니다.
								myeditor.run();                                     // 에디터를 실행합니다.
							</script>";

			}elseif($Board_Admin["editor"] == "ckeditor"){

				$FormChkScript = "if(!form.b_content.value){
									alert('내용을 입력하세요!');
									form.b_content.focus();
									return false;
								  }";

				$EngFormChkScript = "if(!form.b_content.value){
									alert('Plese enter contents.');
									form.b_content.focus();
									return false;
								  }";


				$TextArea = "<script type=\"text/javascript\" src=\"".$EditorPath."/ckeditor.js\"></script>
								<textarea id=\"b_content\" name=\"b_content\">".$content."</textarea>
								<script type=\"text/javascript\">
								//<![CDATA[

									CKEDITOR.replace( 'b_content',
										{
											fullPage : true
										});

								//]]>
								</script>";
			}elseif($Board_Admin["editor"] == "smarteditor"){

				$FormChkScript = "  oEditors.getById[\"b_content\"].exec(\"UPDATE_IR_FIELD\", []);
									form.b_content.value = document.getElementById(\"b_content\").value;
									if(!form.b_content.value){
									alert('내용을 입력하세요!');
									form.b_content.focus();
									return false;
								  }";

				$EngFormChkScript = "  oEditors.getById[\"b_content\"].exec(\"UPDATE_IR_FIELD\", []);
									form.b_content.value = document.getElementById(\"b_content\").value;
									if(!form.b_content.value){
									alert('Plese enter contents.');
									form.b_content.focus();
									return false;
								  }";

				$TextArea = "<script type=\"text/javascript\" src=\"".$EditorPath."/js/HuskyEZCreator.js\"></script>
								<textarea id=\"b_content\" name=\"b_content\" style=\"width:100%;height:300px;display:none;\">".$content."</textarea>
								<script type=\"text/javascript\">
								var oEditors = [];
								
								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors,
									elPlaceHolder: \"b_content\",
									sSkinURI: \"".$EditorPath."/SEditorSkin.html\",
									fCreator: \"createSEditorInIFrame\"
								});								
								
								function insertIMG(irid, filename){
								  var sHTML = \"<img src='\" + filename + \"'>\";								
									oEditors.getById[irid].exec(\"PASTE_HTML\", [sHTML]);	  
								}
								
								</script>";		
			}
			
			
			
			
			elseif($Board_Admin["editor"] == "smeng"){

				$FormChkScript = "  oEditors.getById[\"b_content\"].exec(\"UPDATE_IR_FIELD\", []);
									form.b_content.value = document.getElementById(\"b_content\").value;
									if(!form.b_content.value){
									alert('내용을 입력하세요!');
									form.b_content.focus();
									return false;
								  }";

				$EngFormChkScript = "  oEditors.getById[\"b_content\"].exec(\"UPDATE_IR_FIELD\", []);
									form.b_content.value = document.getElementById(\"b_content\").value;
									if(!form.b_content.value){
									alert('Plese enter contents.');
									form.b_content.focus();
									return false;
								  }";

				$TextArea = "<script type=\"text/javascript\" src=\"".$EditorPath."/js/HuskyEZCreator.js\"></script>
								<textarea id=\"b_content\" name=\"b_content\" style=\"width:100%;height:300px;display:none;\">".$content."</textarea>
								<script type=\"text/javascript\">
								var oEditors = [];
								
								nhn.husky.EZCreator.createInIFrame({
									oAppRef: oEditors,
									elPlaceHolder: \"b_content\",
									sSkinURI: \"".$EditorPath."/SEditorSkin.html\",
									fCreator: \"createSEditorInIFrame\"
								});								
								
								function insertIMG(irid, filename){
								  var sHTML = \"<img src='\" + filename + \"'>\";								
									oEditors.getById[irid].exec(\"PASTE_HTML\", [sHTML]);	  
								}
								
								</script>";		
			}
			
			
			
			
			else{

				$FormChkScript = "if(!form.b_content.value){
									alert('내용을 입력하세요!');
									form.b_content.focus();
									return false;
								  }";

				$EngFormChkScript = "if(!form.b_content.value){
									alert('Plese enter contents.');
									form.b_content.focus();
									return false;
								  }";


				$TextArea = "<textarea name=\"b_content\" class=\"noneEditor\">".$content."</textarea>";
			}
		}else{

			$FormChkScript = "if(!form.b_content.value){
								alert('내용을 입력하세요!');
								form.b_content.focus();
								return false;
							  }";

			$EngFormChkScript = "if(!form.b_content.value){
								alert('Plese enter contents.');
								form.b_content.focus();
								return false;
							  }";

			$TextArea = "<textarea name=\"b_content\" class=\"noneEditor\">".$content."</textarea>";
		}
?>