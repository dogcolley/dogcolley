<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once("./_common.php");

/****** bo_ 여분테이블 속성이 text 또는 longtext 가 아닐 경우에 text로 변경 *****/
$sql = "show full columns from `{$g5['board_table']}`";
$result = sql_query($sql);

$columArr = array("bo_1"=>"text", "bo_2"=>"text", "bo_3"=>"text", "bo_4"=>"text", "bo_5"=>"text", "bo_6"=>"text", "bo_7"=>"text", "bo_8"=>"text", "bo_9"=>"longtext", "bo_10"=>"longtext");

while($row = sql_fetch_array($result)) {
	for($i=0; $i<=count($columArr); $i++) {

		if($row['Field'] == 'bo_'.$i) {
			if($row['Type'] != "text" && $row['Type'] != "longtext") {
				@sql_query(" ALTER TABLE `{$g5['board_table']}`
										modify `".$row[Field]."` ".$columArr['bo_'.$i]." NOT NULL DEFAULT '' ", true);
			}
		}
	}
}


/****** 프로그램상에 카테고리 [공지|예약대기|예약완료|취소요청|취소완료] 가 고정으로 들어갔기 때문에 반드시 있어야 함 *****/
if(!$board[bo_category_list] || !strstr($board[bo_category_list], "공지|예약대기|예약완료|취소요청|취소완료") ) {
	$sql = sql_query("update `{$g5['board_table']}` set bo_category_list = '공지|예약대기|예약완료|취소요청|취소완료', bo_use_category = '1' where bo_table = '{$bo_table}'", true);
}
?>