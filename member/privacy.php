<?
$pg = 6;
$sg = 1;
$main = false;
$mainpage = false;
$SNB = "blank";
include("../head.lib.php");
?>
<div class="subcontainer nosubm">

	<!-- <div class="titleArea">
	  <h3>개인정보처리방침</h3>
	  <div class="location">홈 &gt; <b>개인정보처리방침</b></div>
	</div> -->

	<div class="contentsArea">
		<div class="section">
			<div class="inner">
				<div class="TitleArea">
					<h3>
						Privacy Policy
					</h3>
				</div>

				<div class="rule-txt-area">
					<textarea><?=get_text(stripslashes($default[member_privacy_eng]));?></textarea>

					<div class="rul-btn-box">
						<a href="/index.php" class="btn_red2" >Main</a>
						<a href="javascript:history.back();" class="btn_gray2">Back</a>
					</div>
				</div>

			</div>
		</div>
	</div>


</div>


<? include("../foot.lib.php"); ?>
