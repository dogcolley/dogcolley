<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];
$write_table = $g5['write_prefix'].$_POST['bo_table'];
$w = $_POST['w'];


if ( $w == 'u' ) {	
		
	$sql = " update
											{$g5['board_table']}
									set
											bo_9 = '".$_POST[privacy_1]."',
											bo_10 = '".$_POST[privacy_2]."'
									where
											bo_table = '".$bo_table."'
								";
	sql_query( $sql );

}
?>