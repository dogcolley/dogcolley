<?php
include_once('./_common.php');

/* type.skin 에서 변수값 전부 받아서 사용하기때문에 따로 설정 필요 없음 */
/* 추가 설정이 필요할 경우 직접 소스 수정 */

$uid = get_uniqid();
$_POST[uid] = $uid;
$bNum = $_POST['bNum'];

if ( $w == 'u' ) {	

	$sql = " update
											{$g5['board_table']}
									set
											".$bNum." = '".$_POST['value']."'
									where
											bo_table = '".$bo_table."'
								";

	sql_query( $sql );

}

echo json_encode( $_POST );
?>