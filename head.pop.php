<?

include_once $_SERVER["DOCUMENT_ROOT"]."/admin/lib/lib.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko">
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<meta name="robots" content="noindex,nofollow">
<? if($default[keyword]==TRUE) { ?>
<meta name="keywords" content="<?=$default[keyword]?>">
<? } ?>
<title><?=$default[site_name]?> - <?=$default[title]?></title>
</head>
<script language='javascript' src='<?=$default[AbsoluteUrl]?>/admin/lib/javascript.js'></script>
<script language='javascript' src='<?=$default[AbsoluteUrl]?>/js/prototype.js'></script>

<link href="<?=$default[AbsoluteUrl]?>/inc/style.css" rel="stylesheet" type="text/css" />

<body style="margin:0px; padding:0px">
		