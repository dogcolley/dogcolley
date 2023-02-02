<?php
include_once('./_common.php');

/* ship.skin 에서 변수값 전부 받아서 사용하기때문에 따로 설정 필요 없음 */
/* 추가 설정이 필요할 경우 직접 소스 수정 */

$uid = get_uniqid();
$_POST[uid] = $uid;
$bNum = $_POST['bNum'];

// 기존 bo 여분필드 값 불러오기
$bVal = sql_fetch("SELECT ".$bNum." FROM {$g5['board_table']} WHERE bo_table = '".$bo_table."'");
$boV = $bVal[$bNum];


$bo1 = strip_tags( $_POST['bo1'] );
$bo2 = strip_tags( $_POST['bo2'] );
$bo_sum = $bo1."|".$bo2.";";
$bo_add = $uid."|".$bo_sum; // 신규 uid 발급하여 새로 추가할 값

$uid_o = strip_tags( $_POST['uid_o'] ); // 할당되어있던 uid

$strValue = @strstr($boV, $uid_o);
$strArr = explode("|", $strValue);
$bo1_o = $strArr[1];
$bo2_o = $strArr[2];
$bo2_o = explode(";", $bo2_o);

$bo_o_sum = $bo1_o."|".$bo2_o[0].";";
$bo_o_add = $uid_o."|".$bo_o_sum; // 기존 값 전체

//$_POST[bo_add] = $bo_o_add; 

$bo_table = $_POST['bo_table'];
$write_table = $g5['write_prefix'].$_POST['bo_table'];
$w = $_POST['w'];


// 현재 등록된 총 개수 찾기
$bo_arr = explode(";", $board[$bNum]);
	
for ( $i = 0; $i < count( $bo_arr )-1; $i++ ) { 
	$fNum = $i++;
}

$_POST['fNum'] = $fNum;
$fNum = $_POST['fNum'];


if ( $w == 'r' ) {

	// 값을 지속적으로 추가
	$sql = " update
											{$g5['board_table']}
									set
											".$bNum." = '".$board[$bNum].$bo_add."'
									where
											bo_table = '".$bo_table."'
								";
	sql_query( $sql );

} else if ( $w == 'u' ) {	
		
	// 기존 uid 값 찾아서 뒤에 값만 변경
	$uData = str_replace($bo_o_add, $uid_o."|".$bo_sum, $boV);

	$sql = " update
											{$g5['board_table']}
									set
											".$bNum." = '".$uData."'
									where
											bo_table = '".$bo_table."'
								";
	sql_query( $sql );

} else if ( $w == 'd' ) {
	
	// 기존 여분필드 값에서 삭제 할 부분만 제거 후 다시 저장
	$dData = str_replace($bo_o_add, "", $boV);
	
	$sql = " update
											{$g5['board_table']}
									set
											".$bNum." = '".$dData."'
									where
											bo_table = '".$bo_table."'
								";
	sql_query( $sql );

}

echo json_encode( $_POST );
?>