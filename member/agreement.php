<?
$pg = 6;
$sg = 1;
$main = false;
$mainpage = false;
$SNB = "blank";
include("../head.lib.php");
?>

<div class="subcontainer nosubm">
	<div class="titleArea">
	  <h3>terms of service</h3>
	  <div class="location">home &gt; <b>terms of service</b></div>
	</div>

	<div class="rule-txt-area">
		<textarea><?=get_text(stripslashes($default[member_stipulation]));?></textarea>

		<div class="rul-btn-box">
			<a href="/index.php" class="btn_red2" >홈으로</a>
			<a href="javascript:history.back();" class="btn_gray2">뒤로가기</a>
		</div>
	</div>
</div>



<? include("../foot.lib.php"); ?>
