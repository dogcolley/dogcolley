<?php 
 include_once('./_common.php');

$search_list = array();

$sql = "SELECT * FROM g5_write_{$_POST['bo_1']} WHERE wr_1 = '{$_POST['cell']}' AND wr_2 = '{$_POST['name']}'";
$result = sql_query($sql);


while ($row = sql_fetch_array($result)) {
	$search_list[] = $row;
}
// $result['sql'] = $sql;
echo json_encode($search_list);
 ?>