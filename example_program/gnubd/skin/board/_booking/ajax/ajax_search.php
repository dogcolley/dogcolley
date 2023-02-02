<?php
include_once('./_common.php');
include_once(G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/_reservation/ajax/ajax_reservation.php');
$start = strtotime($_POST['start']);
$end = strtotime('-1 day', strtotime($_POST['end']));
$reserve_list = array();
$total_list = array();
$abc = getWeek($_POST['start'],$_POST['end'], $_POST['bo_7_subj'],$_POST['bo_8_subj']);
$get = getSeason($abc);
$season = is_holiday($get, $_POST['bo_5_subj']);

$count = 0;

//우선 전체객실을 뽑는다
$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} ORDER BY wr_subject ASC";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$total_list[] = $row;

}
for ($i=0; $i < count($total_list); $i++) { 
	$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND mta_db_id = '{$total_list[$i]['wr_id']}'";
	$result = sql_query($sql);
	while ($booking = sql_fetch_array($result)) {
		$total_list[$i][$booking['mta_key']] = $booking['mta_value'];
	}
}
$dump = $total_list;
// 선택된 기간 뽑기
while ($start <= $end){        
	$value = date('Y-m-d',$start);
	//기간중 유저가 예약한 객실 검색
	$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_1']} WHERE wr_is_comment = '0' AND wr_6 != '취소완료' AND wr_4 LIKE '%{$value}%'";
	$result = sql_query($sql);
	while ($row = sql_fetch_array($result)) {
		//검색된 객실
		$reserve_list[] = $row['wr_3'];	
		$id = $row['wr_3'];
		$key = array_search($id, array_column($total_list, 'wr_id'));
		unset($total_list[$key]);
	}


	//관리자가 전화 및 어플로 예약한 객실 검색
	$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/reserved' AND mta_key='{$value}'";
	$result2 = sql_query($sql);
	while($row2 = sql_fetch_array($result2)){
		if (isset($row2['mta_db_id'])) {
			$reserve_list[] = $row2['mta_db_id'];
			$id = $row2['mta_db_id'];
		}	
	}
	
	
	
	$start = strtotime("+1 day",$start);
	$count++;	
}

//

//중복값 제거
$reserve_list = array_unique($reserve_list);
//제거 후 value sorting
$reserve_list['reserved'] = array_values($reserve_list);

$reserve_list['list'] = $dump;

$reserve_list['total'] = $dump;
//날짜일수 저장
$reserve_list['count'] = $count;

if ($_POST['type'] == 'count') {
	$count_price = array();

	for ($i=0; $i < count($_POST['id']); $i++) { 
		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND mta_key='wr_roomsale' AND mta_db_id = '{$_POST['id'][$i]}'";
		$fetch = sql_fetch($sql);
		$resv_price = getPrice($season,$_POST['id'][$i],$_POST['bo_table']);
		$sale_price = getSalePrice($season, $fetch['mta_value'], $_POST['bo_table'], $_POST['id'][$i]);
		$add_price = getAddPrice($_POST['count'][0], $_POST['count'][1], $_POST['count'][2], $_POST['bo_table'], $_POST['id'][$i]);
		$count_price[$i]['price'] = number_format($add_price);	
		$count_price[$i]['wr_id'] = $_POST['id'][$i];
		$count_price[$i]['total'] = number_format($resv_price - $sale_price + $add_price);
	}
	echo json_encode($count_price);
	return;
}

for ($i=0; $i < count($reserve_list['list']); $i++) { 
	$resv_price = getPrice($season,$reserve_list['list'][$i]['wr_id'],$_POST['bo_table']);
	$sale_price = getSalePrice($season, $reserve_list['list'][$i]['wr_roomsale'], $_POST['bo_table'], $reserve_list['list'][$i]['wr_id']);
	$total_price = $resv_price - $sale_price;

	$reserve_list['list'][$i]['price'] = number_format($resv_price).'원';
	$reserve_list['list'][$i]['sale'] = number_format($sale_price).'원';	
	$reserve_list['list'][$i]['total'] = number_format($total_price).'원';	
}


echo json_encode($reserve_list);
?>