<?
/* 게시판 리스트 페이지 추가코드 여기까지***************
스킨경로 : $Board_Admin["skin_dir"]
게시판 너비 : $Board_Admin["width"]
********************************************************/
?>
<link type="text/css" href="/common/css/board.css" rel="stylesheet" />
<link type="text/css" href="/common/css/basic.css" rel="stylesheet" />
<script type="text/javascript">
function writeChk(form) {
	if(!form.passwd.value) {
		alert('비밀번호를 입력하세요');
		form.passwd.focus();
		return false;
	}

	if(form.mode.value == "VIEW" || form.mode.value == "MODIFY" || form.mode.value == "DELETE" || form.mode.value == "COMDEL"){
		form.target = "_parent";
	}
	return true;
}
</script>
<div class="pssscheckWrap">
	<form name="writeform" id="test" method="post" action="<?=$NextAction?>" enctype="multipart/form-data" validate="UTF-8" onsubmit="return writeChk(this)">
	<!-- ######### 주요 히든 필드 수정하지 마세요 ########### -->
	<input type="hidden" name="mode" value="<?=$type?>">
	<input type="hidden" name="tbl" value="<?=$Table?>">
	<input type="hidden" name="num" value="<?=$num?>">
	<input type="hidden" name="category" value="<?=$category?>">
	<input type="hidden" name="findType" value="<?=$findType?>">
	<input type="hidden" name="findword" value="<?=$findword?>">
	<input type="hidden" name="sort1" value="<?=$sort1?>">
	<input type="hidden" name="sort2" value="<?=$sort2?>">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="chr" value="<?=$chr?>">
	<!-- ######### 주요 히든 필드 수정하지 마세요 ########### -->
	<div class="pssscheck">
		<fieldset>
			<legend>비밀번호입력</legend>
			<label><strong class="pdR10">password</strong> <input name="passwd" type="password" value="" class="text" />  </label>
		</fieldset>
	</div>
	<div class="writeBtnArea">
		<input type="submit" class="button btn_black" value="OK" onClick='use();return false;'>
		<input type="button" class="button btn_red" value="CANCEL" onClick='history.back()' />
	</div>
	</form>
</div>