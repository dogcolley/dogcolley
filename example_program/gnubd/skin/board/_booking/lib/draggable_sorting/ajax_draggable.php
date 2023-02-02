<?php
include_once("./_common.php");
$sql = "SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} ORDER BY wr_num ASC";
$result = sql_query($sql);
$basic_list = array();
$num_list = array();
$temp = "";
$i = 0;
while ($row = sql_fetch_array($result)) {
	$basic_list[$i][$row['wr_num']] = $row['wr_id'];
	$num_list[] = $row ['wr_num'];
	$i++;
}
$min = min($num_list);
$max = max($num_list);

$temp = $basic_list[$_POST['current']];

unset($basic_list[$_POST['current']]);

$arr_front = array_slice($basic_list, 0, $_POST['desired']); //처음부터 해당 인덱스까지 자름
$arr_end = array_slice($basic_list, $_POST['desired']); //해당인덱스 부터 마지막까지 자름

$arr_front[] = $temp;
$basic_list = array_merge($arr_front, $arr_end);

// 
for ($k=0; $k < count($basic_list); $k++) { 
	foreach ($basic_list[$k] as $key => $value) {
		$sql = "UPDATE {$g5['write_prefix']}{$_POST['bo_table']} SET wr_num = '{$min}' WHERE wr_id='{$value}'";
		sql_query($sql);
	}
	$min++;

}

echo json_encode($basic_list);
?>