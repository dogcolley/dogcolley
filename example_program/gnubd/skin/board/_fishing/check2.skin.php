<?php
include_once('./_common.php');

$bo_table = $_POST["bo_table"];
$wr_name = $_POST["wr_name"];
$wr_4 = $_POST["wr_4"];
$w = $_POST["w"];

if ($w == "check") {
	
	$sql_chk = "SELECT wr_id, wr_parent, wr_password, ca_name, wr_4 FROM {$write_table} WHERE wr_name = '".$wr_name."' and wr_4 = '".$wr_4."'";
	$row_chk = sql_fetch($sql_chk);



	if($row_chk) { // 일치하는 예약이

		$sql = "SELECT wr_id, wr_parent, wr_password, ca_name, wr_4 FROM {$write_table} WHERE wr_name = '".$wr_name."' and wr_4 = '".$wr_4."'";
		$res = sql_query($sql);
		
		while($row = sql_fetch_array($res)) {
			$arr_db[] = $row;
		}
		if ($res) sql_free_result($res);
		
		$wr_id = "";

		for($i=0; $i < count($arr_db); $i++) {

			$check_cnt = check_password($arr_db[$i]['wr_4'], $arr_db[$i]['wr_password']);

			if($check_cnt == 1) {
				$wr_id .= $arr_db[$i]['wr_id']."|";
			}else{
				$wr_id .= "";
			}
		}
		
		$url = clean_xss_tags($url);
		if (!$url) $url = clean_xss_tags($_SERVER['HTTP_REFERER']);

		$url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);

		// url 체크
		check_url_host($url);
		
		$str_encrypt = new str_encrypt();
		$wr_id = $str_encrypt->encrypt($wr_id);

		$str_encrypt = new str_encrypt();
		$ss_wr_name = $str_encrypt->encrypt($wr_name);

		$str_encrypt = new str_encrypt();
		$ss_wr_4 = $str_encrypt->encrypt($wr_4);

		// 세션에 아래 정보를 저장. 하위번호는 비밀번호없이 보아야 하기 때문임.
		//$ss_name = 'ss_secret.'_'.$bo_table.'_'.$wr_id';
		$ss_name = 'ss_secret_'.$bo_table.'_'.$wr_name.'_'.$wr_4;
		//set_session("ss_secret", "$bo_table|$wr[wr_num]");
		set_session($ss_name, TRUE);

		goto_url($url."&uid=".urlencode($wr_id)."&uname=".urlencode($ss_wr_name)."&unum=".urlencode($ss_wr_4));

	}else{
		alert('일치하는 예약이 없습니다.\n이름과 연락처를 다시 확인해주시기 바랍니다.\n\n문제가 지속될 경우 관리자에게 연락해주시기 바랍니다.');
	}
		

} else {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

//goto_url('./board.php?'.$qstr);
?>
