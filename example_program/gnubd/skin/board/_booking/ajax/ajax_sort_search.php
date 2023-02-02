<?php 
include_once('./_common.php');
if ($_POST['sort'] == 'price') {
	$abc = array();
	asort($_POST['temp']);
	foreach ($_POST['temp'] as $key => $value) {
		$abc[] = $key;
	}
	echo json_encode($abc);
	return;
}
$booking_array = array();
$search_table = $g5['write_prefix'].$_POST['bo_table'];
$search_id = "wr_id";
$serach_where = "";
$search_order = $_POST['sort'];
if ($_POST['sort'] != "wr_subject") {
	$search_table = $g5['meta_table'];
	$search_id = "mta_db_id";
	$serach_where = "WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND mta_key = '{$_POST['sort']}'";
	$search_order = "mta_value";
}
// SELECT * FROM g5_5_meta WHERE mta_db_table = 'board/yp_reservation01' AND mta_key = 'wr_max' order by mta_value
$sql = "SELECT * FROM {$search_table} {$serach_where} ORDER BY {$search_order}";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
	$booking_array[] = $row[$search_id];
}
$result = array();
$sorted_array = array_intersect($booking_array, $_POST['id']);
foreach ($sorted_array as $key => $value) {
	$result[] = $value;
}






echo json_encode($result);
?>