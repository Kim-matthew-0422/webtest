<? 
$pg = 5;
$main = false;
$mainpage = false;
$SNB = "bbs";
include("../head.lib.php");
?>

<div class="subcontainer nosubm">

<div class="titleArea">
  <h3>게시판 메인(최근 게시물 연동)</h3>
  <div class="location">홈 &gt; 게시판 &gt; <b>최근게시물</b></div>
</div>

<?
// 접속자 통계를 가져오기 위한 함수
$Gcount = Get_CntTotal();
// 회원 통계를 가져오기 위한 함수
$total = Get_MemTotal();
// 회원등급 배열에 저장
$level = Get_level("","ARR","where leb_level > 0");
$level_count = count($level);
?>

<div class="contentsArea">
	<div class="lastest-box">
		<?
			$sql = " select dbname, title from {$V_DB[bbsconfig]} where view = '1' and chr = '' order by dbname";
			$result = sql_query($sql,FALSE);
			for ($i=0; $row=sql_fetch_array($result,FALSE); $i++) {
		?>
		<div class="nboxim">
			<div class="ntitle"><?=$row["title"]?>
				<a href="/bbs/board.php?tbl=<?=$row["dbname"]?>" class="newin">바로가기</a>
			</div>
			<div class="latest-box">
				<?=latest($row["dbname"], "bbs", "list", 5, 30,"order by b_modify desc")?>
			</div>
		</div>
		<? } ?>
	</div>
</div><!-- contentsArea -->

</div><!-- subcontainer -->

<? include("../foot.lib.php"); ?>