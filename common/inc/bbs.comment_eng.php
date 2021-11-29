<div class="postsArea mgT30"><span class="posts">Comment <?=$comm_total?></span></div>
<div id="commentArea">
	<form method="post" id="commentForm" action="./process.php" enctype="multipart/form-data" validate="UTF-8" onsubmit="return false">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="tbl" value="<?=$Table?>">
		<input type="hidden" name="chr" value="<?=$chr?>">
		<input type="hidden" name="c_bno" value="<?=$view["b_no"]?>">
		<input type="hidden" name="c_tno">
		<input type="hidden" name="c_member" value="<?=$sess["userid"]?>">
		<input type="hidden" name="c_dep">
		<input type="hidden" name="category" value="<?=$category?>">
		<input type="hidden" name="findType" value="<?=$findType?>">
		<input type="hidden" name="findword" value="<?=$findword?>">
		<input type="hidden" name="sort1" value="<?=$sort1?>">
		<input type="hidden" name="sort2" value="<?=$sort2?>">
		<input type="hidden" name="page" value="<?=$page?>">
		<!--input type="hidden" name="num" value="<?=$view["b_no"]?>"-->
		<!--input type="hidden" name="cnum" value=""-->
		<input type="hidden" name="passwd">
		<input type="hidden" name="delType">
		<input type="hidden" name="spamfree" value="">
		<!-- 댓글 목록 -->
		<ul class="commentList">
			<!-- 댓글 목록 출력 -->
			<? for($i = 0; $i < count($comm); $i++) { ?>
				<? if(in_array($comm[$i]["view_type"], array("admin", "general"))){ ?>
					<input type="hidden" id="com_dep_origin_<?=$i?>" value="<?=$comm[$i]["c_dep"]?>">
					<input type="hidden" id="com_tno_<?=$i?>" value="<?=$comm[$i]["c_tno"]?>">
					<input type="hidden" id="com_have_reply_<?=$i?>" value="<?=$comm[$i]["have_reply"]?>">
					<input type="hidden" id="com_del_<?=$i?>" value="<?=$comm[$i]["c_del"]?>">
					<!-- 댓글 폼 -->
					<li class="list_new" style='padding-left:<?echo (strlen($comm[$i]["c_dep"])-1) * 20 ?>px'>
						<!-- 댓글 제목줄 -->
						<ul class="listMenu">
							<!-- 댓글 글쓴이 출력 -->
							<li class="writer" id="com_li_writer_<?=$i?>">
								<?=$comm[$i]["c_writer"]?>
							</li>
							<!-- 댓글 작성날짜 출력 -->
							<li class="date" id="com_li_date_<?=$i?>">
								<?=$comm[$i]["c_regist"]?>
								<?=$comm[$i]["del_title"]?>
							</li>
							<!-- 손님 글쓴이, 비밀번호 확인 폼 -->
							<li id="com_li_modify_top_<?=$i?>" style="display:none; float:left; max-width:95%;">
								<? if($Get_Login == FALSE) { ?>
									<label>Name</label><input id="com_writer_modify_<?=$i?>" name="" type="text" class="text">&nbsp;&nbsp;
									<label>Password</label><input id="com_passwd_modify_<?=$i?>" name="" type="password" class="text">
								<? } ?>
							</li>
							<!-- 댓글 기능 버튼 출력 -->
							<li class="option" id="iconBox_options_<?=$i?>">
								<!-- 댓글 기능 : 추천 -->
								<? if($comm[$i]["combest"] == TRUE) { ?>
										<span class="best">
											<a href="<?=$comm[$i]["combest"]?>">Best[<?=$comm[$i]["c_best"]?>]<!--img src="/images/common/icon/icon_u.gif" alt="추천"/--></a>
										</span>
								<? } ?>
								<!-- 댓글 기능 : 답변 -->
								<? if($comm[$i]["comreply"] == TRUE) { ?>
										<span>
											<img src="/images/common/icon/icon_re.gif" class="cursor" alt="ANSWER" onclick="com_function_toggle('reply', <?=$i?>);" />
										</span>
								<? } ?>
								<!-- 댓글 기능 : 수정 -->
								<? if($comm[$i]["comedit"] == TRUE) { ?>
										<span>
											<img src="/images/common/icon/icon_m.gif" class="cursor" alt="MODIFY" onclick="com_function_toggle('modify', <?=$i?>);" />
										</span>
								<? } ?>
								<!-- 댓글 기능 : 삭제 -->
								<? if($comm[$i]["comdele"] == TRUE) { ?>
										<input type="hidden" id="com_cno_delete_<?=$i?>" name="" value="<?=$comm[$i][c_no]?>" />
										<span>
											<img src="/images/common/icon/icon_x.gif" class="cursor layerPop02_comdel" alt="삭제" 
												<? if(($sess["userlevel"] >= $Board_Admin["level_com_del"]) || ($Get_Login == TRUE && $sess["userid"] == $comm[$i]["c_member"])) { ?>
													onclick="confirmDel(<?=$i?>);"
												<? } else {?>
													onclick="com_function_toggle('delete', <?=$i?>);" 
												<? } ?>
											/>
											<!--img src="/images/common/icon/icon_x.gif" class="cursor layerPop02_comdel" alt="삭제" onclick="confirmDel(<?=$i?>);" /-->
										</span>
								<? } ?>
							</li>
							<li class="option" id="iconBox_cencel_<?=$i?>" style='display:none'>
								<!-- 댓글 기능 : 실행 취소 -->
								<span id="com_cencel_<?=$i?>">
									<img src="/images/common/icon/icon_u.gif" class="cursor layerPop02_comdel" alt="UNDO" onclick="com_function_toggle('cencel', <?=$i?>);"/>
								</span>
							</li>
						</ul>
						<!-- 댓글 내용 출력 -->
						<div id="com_content_origin_<?=$i?>">
							<?=nl2br(stripslashes($comm[$i]["content"]))?>
						</div>
						<!-- 삭제 비밀번호 폼 -->
						<div id="com_li_delete_<?=$i?>" style="display:none;">
							<label>Password</label>
							<input id="com_passwd_delete_<?=$i?>" name="" type="password" class="text">
							<!--img src="/images/common/btn/btn_ok.gif" class="button" alt="확인"/-->
							<input type="button" class="btn_black" value="CONFIRM" onclick="confirmDel(<?=$i?>);">
						</div>
					</li>

					<!-- 댓글 수정 폼 -->
					<li id="com_li_modify_bottom_<?=$i?>" class="cWrite" style="display:none;">
						<input type="hidden" id="com_cno_modify_<?=$i?>" name="" value="<?=$comm[$i][c_no]?>" />
						<table cellpadding="0" cellspacing="0" width="100%">
							<colgroup>
								<col />
								<col width="85" />
							</colgroup>
							<tr>
								<td><textarea id="com_content_modify_<?=$i?>" name=""  class="textarea"></textarea></td>
								<td class="confirm">
									<!--input type="image" src="/images/common/btn/btn_comment_ok.gif" class="button" value="확인"-->
							    <input type="button" class="btn_comment" value="OK" onclick="blank_check('COMMODIFY', 'modify', <?=$i?>);">
								</td>
							</tr>
						</table>
					</li>

					<!-- 답변 작성 폼 -->
					<li id="com_li_reply_<?=$i?>" class="cWrite" style="display:none; padding-left:<?echo (strlen($comm[$i]["c_dep"])) * 15 ?>px">
						<!-- 답변 제목줄 -->
						<div class="userInfo">
								<label>Name</label><input id="com_writer_reply_<?=$i?>" name="" type="text" class="text" value="<?=$sess["username"]?>">&nbsp;&nbsp;
							<? if($Get_Login == FALSE) { ?>
								<label>Password</label><input id="com_passwd_reply_<?=$i?>" name="" type="password" class="text">
							<? } ?>
						</div>
						<!-- 답변 내용 -->
						<table cellpadding="0" cellspacing="0" width="100%">
							<colgroup>
								<col />
								<col width="85" />
							</colgroup>
							<tr>
								<td>
									<textarea id="com_content_reply_<?=$i?>" name=""  class="textarea"></textarea>
								</td>
								<td class="confirm">
							    <input type="button" class="btn_comment" value="OK" onclick="setModeAndParam('COMREPLY', 'reply',<?=$i?>);">
									<!--input type="image" src="/images/common/btn/btn_comment_ok.gif" class="button" value="확인"-->
								</td>
							</tr>
						</table>      
					</li>
				<? } else if($comm[$i]["view_type"] == "delMsgShow"){ ?>
					<li class="list_new" style='padding-top:12px; padding-left:<?echo (strlen($comm[$i]["c_dep"])-1) * 20 ?>px'><?=$comm[$i]["del_title"]?></li>
				<? } ?>
			<? } ?>
			<!-- 댓글 작성 폼 -->
			<? if($sess["userlevel"] >= $Board_Admin["level_com"]) { ?>
				<li id="com_li_write" class="cWrite">
					<!-- 댓글 제목줄 -->
							<div class="userInfo">
									<label>Name</label><input id="com_writer_write_<?=$i?>" name="" type="text" class="text" value="<?=$sess["username"]?>">&nbsp;&nbsp;
								<? if($Get_Login == FALSE) { ?>
									<label>Password</label><input id="com_passwd_write_<?=$i?>" name="" type="password" class="text">
								<? } ?>
							</div>
					<!-- 댓글 내용 -->
					<table cellpadding="0" cellspacing="0" width="100%">
						<colgroup>
							<col />
							<col width="85" />
						</colgroup>
						<tr>
							<td>
								<textarea id="com_content_write_<?=$i?>" name=""  class="textarea"></textarea>
							</td>
							<td class="confirm">
								<!--input type="image" src="/images/common/btn/btn_comment_ok.gif" class="button" value="확인" onclick="setModeAndParam('COMFORM', 'write', <?=$i?>);"-->
							  <input type="button" class="btn_comment" value="OK" onclick="blank_check('COMFORM', 'write', <?=$i?>);">
								<!--input type="button" src="/images/common/btn/btn_comment_ok.gif" class="button btn_comment" value="등록"-->
							</td>
						</tr>
					</table>      
				</li>
			<? } ?>
		</ul>    
	</form>
</div>
<script>
function confirmDel(index){
	var param_delType = $("#commentForm input[name=delType]");
	var param = "";

	if(confirm('Are you sure you want to delete?')) {
		<? if($sess["userlevel"] >= $Board_Admin["level_com_del"]) { ?>
				if($("#com_have_reply_" + index).val() == "Y"){
					if(confirm('The answer exists.\nAre you sure you want to delete together?\n\n(If you click Cancel, the comment will be deleted only.)')){
						param = "del_all";
					} else {
						if($("#com_del_" + index).val() == "Y"){
							alert("The answers can not be deleted exists.");
							return;
						} else {
							param = "del_one";
						}
					}
				}
		<? } else { ?>
			param = "del_one";
		<? } ?>

		param_delType.val(param);
		setModeAndParam('COMDEL', 'delete', index);
	}
}

function confirmDel(index){
	var param_delType = $("#commentForm input[name=delType]");
	var param = "";

	if(confirm("Are you sure you want to delete?<? echo ($sess['userlevel'] >= 100) ? '\n\n(최고관리자 권한으로 삭제시 복구할 수 없습니다.)' : '';?>")) {
		<? if($sess["userlevel"] >= $Board_Admin["level_com_del"]) { ?>
				if($("#com_have_reply_" + index).val() == "Y"){
					if(confirm('하위 계층 코멘트가 존재합니다.\n선택한 계층부터 모두 삭제하시겠습니까?\n\n(답변 코멘트가 있으면 현재 코멘트를 삭제할 수 없습니다.)')){
						param = "<? echo ($sess['userlevel'] >= 100) ? 'del_all' : 'del_part';?>";
					} else {
						return;
					}
				} else if($("#com_del_" + index).val() != "Y"){
					param = "<? echo ($sess['userlevel'] >= 100) ? '' : 'del_one';?>";
				}
		<? } else { ?>
			param = "del_one";
		<? } ?>

		param_delType.val(param);
		setModeAndParam('COMDEL', 'delete', index);
	}
}

function blank_check(mode, type, index){
	var obj_writer = $("#com_writer_" + type + "_" + index);
	var obj_content = $("#com_content_" + type + "_" + index);
	var obj_passwd = $("#com_passwd_" + type + "_" + index);

	<? if($Get_Login == FALSE) { ?>
	if(!obj_writer.val()){
		alert("Please enter your name");
		obj_writer.focus();
	} else if(!obj_passwd.val()){
		alert("Please enter your password");
		obj_passwd.focus();
	} else <? } ?>if(!obj_content.val()){
		alert("Please enter your details");
		obj_content.focus();
	} else {
		setModeAndParam(mode, type, index);
	}
}

function setModeAndParam(mode, type, index){
	var param_mode = $("#commentForm input[name=mode]");
	var param_content = $("#com_content_" + type + "_" + index);
	var param_dept = $("#commentForm input[name=c_dep]");
	var param_tno = $("#commentForm input[name=c_tno]");
	var param_cno = $("#com_cno_" + type + "_" + index);
	var param_writer = $("#com_writer_" + type + "_" + index);
	var param_passwd = $("#com_passwd_" + type + "_" + index);


	if(type == "write") {
		param_dept.val("A");
		<? if($Get_Login == FALSE) { ?>
			param_passwd.attr("name", "passwd");
		<?}?>
	} else if(type == "reply") {
		param_tno.val($("#com_tno_" + index).val());
		param_dept.val($("#com_dep_origin_" + index).val());
		$("#com_spamfree_" + index).val(<?=time()?>);	//스팸방지
		<? if($Get_Login == FALSE) { ?>
			param_passwd.attr("name", "passwd");
		<? } ?>
	} else if (type == "modify" || type == "delete") {
		param_cno.attr("name", "c_no");
		param_tno.val($("#com_tno_" + index).val());
		param_dept.val($("#com_dep_origin_" + index).val());
		<? if($Get_Login == FALSE) { ?>
			param_passwd.attr("name", "passwd");
		<? } ?>
	}

	param_mode.val(mode);
	param_writer.attr("name","c_writer");
	param_content.attr("name", "c_content");

	$("#commentForm").attr("onsubmit", "true");
	$("#commentForm input[name=spamfree]").val(<?=time()?>);//스팸방지
	$("#commentForm").submit();
}

function com_function_toggle(type, index){
	if(type == "reply"){
		$("#com_writer_reply_" + index).val("<?=$sess[username]?>");
		<? if($Get_Login == FALSE) { ?>
			$("#com_passwd_reply_" + index).val("");
		<? } ?>
		$("#com_content_reply_" + index).val("");
		object_toggle("#com_li_reply_" + index);
	} else if(type == "modify"){
		$("#com_content_modify_" + index).val($.trim($("#com_content_origin_" + index).text()));
			object_toggle("#com_content_origin_" + index);
			object_toggle("#com_li_modify_bottom_" + index);
		<? if($Get_Login == FALSE) { ?>
			$("#com_writer_modify_" + index).val($.trim($("#com_li_writer_" + index).text()));
			$("#com_passwd_modify_" + index).val("");
			object_toggle("#com_li_writer_" + index);
			object_toggle("#com_li_date_" + index);
			object_toggle("#com_li_modify_top_" + index);
		<? } ?>
	} else if(type == "cencel"){
		if ($("#com_li_modify_bottom_" + index).is(":visible")){
			object_toggle("#com_content_origin_" + index);
			object_toggle("#com_li_modify_bottom_" + index);
			<? if($Get_Login == FALSE) { ?>
				object_toggle("#com_li_writer_" + index);
				object_toggle("#com_li_date_" + index);
				object_toggle("#com_li_modify_top_" + index);
			<? } ?>
		} else if ($("#com_li_reply_" + index).is(":visible")){
			object_toggle("#com_li_reply_" + index);
		} else if ($("#com_li_delete_" + index).is(":visible")){
			object_toggle("#com_li_writer_" + index);
			object_toggle("#com_li_date_" + index);
			object_toggle("#com_content_origin_" + index);

			object_toggle("#com_li_delete_" + index);
		}
	} else if(type == "delete"){
		object_toggle("#com_li_writer_" + index);
		object_toggle("#com_li_date_" + index);
		object_toggle("#com_content_origin_" + index);

		object_toggle("#com_li_delete_" + index);
	}

	object_toggle("#iconBox_cencel_" + index);
	object_toggle("#iconBox_options_" + index);
}

function object_toggle(id){
	var object = $(id);
	if(object.is(":visible")){
		object.hide();
	} else {
		object.show();
	}
}
</script>