<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/config.php");

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
//add_javascript('<script src="'.$board_skin_url.'/js/jquery.dialogOptions.js"></script>');

$reserve_list = $_GET['reservation'];
$reserve_uid = $_GET['uid'];

if($reserve_list == "check" && !$reserve_uid) { // 예약 체크

	@include_once($board_skin_path."/check.skin.php");

}else if($reserve_list == "check" && $reserve_uid) {  // 예약 체크 후 리스트

	@include_once($board_skin_path."/reservation_list2.skin.php");

}else{


	$sch_year = clean_xss_tags($_GET['sch_year']);
	$sch_year = preg_match("/([0-9]{4})/", $sch_year) ? $sch_year : substr(G5_TIME_YMD,0,4);

	$sch_month = clean_xss_tags($_GET['sch_month']);
	$sch_month = preg_match("/([0-9]{2})/", $sch_month) ? $sch_month : substr(G5_TIME_YMD,5,2);

	$sch_day2 = clean_xss_tags($_GET['sch_day']);
	$sch_day2 = preg_match("/([0-9]{2})/", $sch_day2) ? $sch_day2 : substr(G5_TIME_YMD,8,2);

	$vew_month = $sch_year.'-'.$sch_month;
	$curr_year = date( 'Y' );

	unset($arr_db);
	$arr_db = array();
	$sql = "select wr_id, wr_subject, ca_name, wr_name, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 from {$write_table} where left(wr_2, 7) = '$vew_month' order by wr_3 asc";
	$res = sql_query($sql);


	while($row = sql_fetch_array($res)) {
		$arr_db[$row['wr_2']][] = $row;
	}
	if ($res) sql_free_result($res);

	$weekstr = array('일', '월', '화', '수', '목', '금', '토');

	// 한달의 총 날짜 계산 함수
	function wz_max_day($i_month, $i_year) {
		$day = 1;
		while(checkdate($i_month, $day, $i_year))
		{
			$day++;
		}
		$day--;
		return $day;
	}


	@include_once($board_skin_path."/calendar.skin.php"); // 상단 달력 페이지


	$action_url = https_url(G5_BBS_DIR)."/write_update.php";

	$count = 0;
	$weekcut = 0; // 한주가 지나면 초기화


	$get_data = $_GET[sch_year]."-".$_GET[sch_month]."-".$sch_day2;

	if($sch_day2 == date('d')) {
		$sch_day2 = "";
	}


	if($_GET[month] == "month") {
		$selected_day = 1;
		$total_day = $total_day;
	}
	else if( $vew_month == date('Y-m') ) 
	{
		if($_GET[sch_day]) // 선택한 날짜가 있을 때
		{
			$selected_day = $_GET[sch_day];
			$total_day = $selected_day;
		}else{
			$selected_day = date('d');
			$total_day = $selected_day;
		}
	}else if($vew_month == $_GET[sch_year]."-".$_GET[sch_month]) {

		if($_GET[sch_day]) // 선택한 날짜가 있을 때
		{
			$selected_day = $_GET[sch_day];
			$total_day = $selected_day;
		}else{
			$selected_day = 1;
			$total_day = $total_day;
		}
	}else{
		$selected_day = 1;
		$total_day = $total_day;
	}


	$wFile = @fopen($board_skin_path."/date/{$sch_year}-{$sch_month}.txt", "r");

	if($wFile) {
		$wDD = @fread($wFile, filesize($board_skin_path."/date/{$sch_year}-{$sch_month}.txt"));
	}
	@fclose($wFile);



	function masking($_type, $_data){
		$_data = str_replace('-','',$_data);
		$strlen = mb_strlen($_data, 'utf-8');
		$maskingValue = "";
		  
		$useHyphen = "-";

		if($_type == 'N'){
			switch($strlen){
				case 2:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○';
					break;
				case 3:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○'.mb_strcut($_data, 8, 9, "UTF-8");
					break;
				case 4:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○○'.mb_strcut($_data, 10, 11, "UTF-8");
					break;
				case 5:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○○○'.mb_strcut($_data, 12, 13, "UTF-8");
					break;
				case 6:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○○○'.mb_strcut($_data, 14, 15, "UTF-8");
					break;
				case 7:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○○○○'.mb_strcut($_data, 16, 17, "UTF-8");
					break;
				default:
					$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'○○○○'.mb_strcut($_data, 16, 17, "UTF-8");
					break;
			}
		}else if($_type == 'P'){
			switch($strlen){
				case 10:
					$maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}***{$useHyphen}".mb_substr($_data, 6, 4);
					break;
				case 11:
					$maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}****{$useHyphen}".mb_substr($_data, 7, 4);
					break;
				default:
					trigger_error('Not a known format parametter in function', E_USER_NOTICE);
					break;
			}
		}else{
			trigger_error('Masking Function Parameter Error', E_USER_NOTICE);
		}
		return $maskingValue;
	}

	if($reserve_list == "list" && $member[mb_level] >= 8) 
	{
		@include_once($board_skin_path."/reservation_list.skin.php"); // 예약현황 페이지
	}else
	{
		@include_once($board_skin_path."/calendar2.skin.php"); // 예약가능 페이지 (게스트용)
	}
	@include_once($board_skin_path."/modal.skin.php"); // modal 

}
?>