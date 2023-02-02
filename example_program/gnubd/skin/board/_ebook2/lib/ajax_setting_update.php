<?php
include_once("./_common.php");
header('Content-type: application/json');

// Ajax Validation
$validity = true;
if (!$_SERVER['HTTP_X_REQUESTED_WITH'] || 
	empty($_SERVER['HTTP_X_REQUESTED_WITH']) || 
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest')
	$validity = false;
if (!$validity) exit;

$result = array( 'msg' => '', 'alert' => true );
if(! $is_admin || ($member['mb_level'] < 8)) {
	$result['msg'] = "권한이 없습니다."; 
} else if (!isset($_POST['bo_table'])) { 
	$result['msg'] = "잘못된 접근입니다.";
} else {
	$bo_table = preg_replace("/[^a-zA-Z0-9_]/", "", $_POST['bo_table']);
	$table = G5_TABLE_PREFIX."write_{$_POST['bo_table']}";
	$bo_sql_field = array();
	$bo_success = false;
	$bo_option_cnt = 1;

	for ($i=1; $i<=$bo_option_cnt; $i++) {
		if (isset($_POST["bo_{$i}"]) && is_array($_POST["bo_{$i}"])) {
			$subj = preg_replace("/[^a-zA-Z0-9_-]/", "", $_POST["bo_{$i}"]['subj']);
			$val = preg_replace("/[^a-zA-Z0-9_-]/", "", $_POST["bo_{$i}"]['val']);
			$sql_set = "bo_{$i}_subj ='{$subj}', bo_{$i} = '{$val}' ";
			array_push($bo_sql_field, $sql_set);
		}
	}
	if (0 < sizeof($bo_sql_field) && sizeof($bo_sql_field) <= $bo_option_cnt) {
		$bo_sql_field_str = implode(",", $bo_sql_field);
		$bo_sql = " UPDATE {$g5['board_table']} SET {$bo_sql_field_str} WHERE bo_table='{$bo_table}' ";
		if (sql_query($bo_sql)) $bo_success = true;
		else $result['msg'] = "데이터베이스 오류. (bo)";
	} else {
		$bo_success = true;
	}
}

if ( $bo_success ) {
	$result['result'] = "success";
	$result['msg'] = "설정이 변경되었습니다.";
} else {
	$result['result'] = "fail";
	$result['test'] = $bo_sql;
}

echo json_encode($result);
exit;
?>