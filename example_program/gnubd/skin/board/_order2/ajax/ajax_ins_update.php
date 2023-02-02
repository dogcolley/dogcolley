<?php
include_once('./_common.php');

$goods_table = "g5_write_{$_POST['bo_1']}";
$wr_num = get_next_num( $goods_table );

if ( $_POST['status'] == 'ins' ) {
	// 상품등록
	$_POST['sql'] = "insert into g5_write_{$_POST['bo_1']} ( wr_num, wr_datetime, mb_id, wr_subject, wr_1, wr_2 )
					values ( '".$wr_num."', '".date( "Y-m-d h:i:s" )."', '".$member['mb_id']."', '".$_POST['gd_name']."', '".$_POST['gd_measure']."', '".$_POST['gd_price']."' )";
	sql_query( $_POST['sql'] );
	$wr_id = sql_insert_id();
	sql_query(" update $goods_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");
	$_POST['id'] = $wr_id;

} else if ( $_POST['status'] == 'upd' ) {
	// 상품수정
	$_POST['sql'] = "update g5_write_{$_POST['bo_1']} set wr_subject = '{$_POST['gd_name']}', wr_1 = '{$_POST['gd_measure']}', wr_2 = '{$_POST['gd_price']}' where wr_id = '{$_POST['id']}'";
	sql_query( $_POST['sql'] );
} else if ( $_POST['status'] == 'del' ) {
	// 상품삭제
	$_POST['sql'] = "delete from g5_write_{$_POST['bo_1']} where wr_id = '{$_POST['id']}'";
	sql_query( $_POST['sql'] );
}

echo json_encode( $_POST );
?>