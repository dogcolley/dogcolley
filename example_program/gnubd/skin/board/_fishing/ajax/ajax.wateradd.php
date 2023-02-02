<?php
include_once('./_common.php');

$uid = get_uniqid();
$_POST[uid] = $uid;

$bo_table = $_POST['bo_table'];
$write_table = $g5['write_prefix'].$_POST['bo_table'];
$w = $_POST['w'];

$wDate = trim( $_POST['wDate'] );
$wVal = trim( $_POST['wVal'] );


$ymDate = @substr($wDate, 0, 7);

			
// 기존에 등록된 물때 값 불러오기
$wFile = @fopen($board_skin_path."/date/{$ymDate}.txt", "r");


if($wFile) {
	// 기존에 등록된 물때 값 불러오기
	$wFile = @fopen($board_skin_path."/date/{$ymDate}.txt", "r");
	$wDD = @fread($wFile, @filesize($board_skin_path."/date/{$ymDate}.txt"));
}else{
	@fwrite($wFile, $wDate."|".$wVal.";");
	$wFile = @fopen($board_skin_path."/date/{$ymDate}.txt", "r");
	$wDD = @fread($wFile, @filesize($board_skin_path."/date/{$ymDate}.txt"));
}

$boV = $wDD;



$wArr = @explode("-", $wDate);

$_POST['wVal'] = $wVal;
$_POST['dVal'] = @number_format($wArr[2]);


$w_sum = $wDate."|".$wVal; 
$w_add = $w_sum.";"; // 물때 새로 추가

//$_POST[bo_add] = $bo_o_add; 

$sVal = @strstr($boV, $wDate);

$sArr = @explode(";", $sVal);

$w_o_sum = $sArr[0].";";

@fclose($wFile);



if($sVal == false || $sVal == "") { // 해당 날짜가 없다면

	$wSql = $wDD.$w_add;

	$wFile = @fopen($board_skin_path."/date/{$ymDate}.txt", "w+");
	$wDD = @fread($wFile, @filesize($board_skin_path."/date/{$ymDate}.txt"));
	$wfile = @fputs($wFile, $wSql);


}else{ // 해당 날짜가 이미 있다면

	// 기존 값 찾아서 뒤에 물때 값만 변경

	$wData = @str_replace($w_o_sum, $w_add, $boV);

	$wFile = @fopen($board_skin_path."/date/{$ymDate}.txt", "w+");
	$wDD = @fread($wFile, @filesize($board_skin_path."/date/{$ymDate}.txt"));
	$wfile = @fputs($wFile, $wData);


}

@fclose($wFile);
/*
if ( $w == 'r' ) {

	// 값을 지속적으로 추가
	$sql = " update
											{$g5['board_table']}
									set
											".$bNum." = '".$wSql."'
									where
											bo_table = '".$bo_table."'
								";
	sql_query( $sql );

}
*/

echo json_encode( $_POST );
?>