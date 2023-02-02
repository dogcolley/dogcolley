<?php
include_once('./_common.php');

if ( $_POST['status'] == "regist" ) {
	$port_status = "";
	if ( empty ( $_POST['portnum'] ) ) {
		$port_status = "대기중";
	} else {
		$port_status = "배송중";
	}
	$sql = "update g5_write_{$_POST['bo_table']} set wr_5 = '{$_POST['portnum']}', wr_10 = '{$port_status}' where wr_id = '{$_POST['id']}'";
	$_POST['res'] = sql_query( $sql );
} else if ( $_POST['status'] == "complete" ) {
	$sql = "update g5_write_{$_POST['bo_table']} set wr_10 = '배송완료' where wr_id = '{$_POST['id']}'";
	$_POST['res'] = sql_query( $sql );
}

echo json_encode( $_POST );
?>