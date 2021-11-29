</div> <!-- inner -->
</div> <!-- section -->
</div><!-- contenstArea -->

<!-- 게시판 비밀번호 레이어팝업 -->
<div class="pssscheckWrap"  id="passBox" style="display:none;">
  <form name="fbox" method="post" onsubmit="return false" style="margin:0;padding:0; z-index:200;">
    <input type="hidden" name="mode" value="">
    <input type="hidden" name="type" value="">
    <input type="hidden" name="num" value="">
    <input type="hidden" name="tbl" value="<?=$Table?>">
    <input type="hidden" name="category" value="<?=$category?>">
    <input type="hidden" name="findType" value="<?=$findType?>">
    <input type="hidden" name="findword" value="<?=$findword?>">
    <input type="hidden" name="sort1" value="<?=$sort1?>">
    <input type="hidden" name="sort2" value="<?=$sort2?>">
    <input type="hidden" name="page" value="<?=$page?>">
    <input type="hidden" name="chr" value="<?=$chr?>">
    <input type='hidden' name='NextUrl' value='<?=$NextUrl?>'>
    <div class="pssscheck">
  	<fieldset>
    	<legend>Password</legend>
    	<label><strong class="pdR10">Password</strong> <input name="passwd" type="password" value="" class="text" />  </label>
  	</fieldset>
    </div>
  	<div class="writeBtnArea">
  		<input type="submit" class="button btn_red" value="OK" onClick='PassSubmit()'>
  		<input type="button" class="button btn_black rebod" value="CANCEL" onClick='closePass()' />
  	</div>
  </form>
</div>
<!-- 게시판 비밀번호 레이어팝업 END -->

<script>
function PassSubmit(){
	var form = document.fbox;

	$(form).attr('onsubmit', true);

	form.submit();
}
function togglePass(mode, no){
	var form = document.fbox;

	form.passwd.value = "";
	$("#passBox").show();

	if(mode == 'MODIFY'){
		form.action = "<?=$default[AbsoluteUrl]?>/bbs/board.php?tbl=<?=$Table?>&amp;mode="+mode+"&amp;num="+no+"&amp;<?=$NextUrl?>";
	} else if(mode == 'VIEW' || mode == 'DELETE'){
		form.action = "<?=$default[AbsoluteUrl]?>/bbs/process.php";
	} else {
		form.action = "";
	}

	form.mode.value = mode;
	form.type.value = mode;
	form.num.value = no;
}
function closePass(){
	$("#passBox").hide();
}
</script>