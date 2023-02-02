<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wType = $_GET[wType];


if($member['mb_level'] >= 8 && $wType == "notice" || $member['mb_level'] >= 8 && $wType == ""){
	include_once($board_skin_path.'/write.admin.skin.php');
}
else if($member['mb_level'] < 8 && $wType == "reserve" || $member['mb_level'] < 8 && $wType == ""){
	include_once($board_skin_path.'/write.reserve.skin.php');
}
?>