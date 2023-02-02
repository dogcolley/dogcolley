<?php
include_once('./_common.php');

$token = $_POST['dToken'];
$upd = $_POST['upd'];
$w = $_POST['w'];
$ca = $_POST['ca'];
$date = $_POST['date'];
$wr_id = $_POST['wr_id'];
$cancel_id = $_POST['cancel_id'];
$chk_id = $_POST['chk_id'];

$chkarr = @explode(",", $chk_id);
$_POST['chk_wr_id'] = $chkarr;


$delete_token = get_session('ss_delete_token');
set_session('ss_delete_token', '');

$write_table = $g5['write_prefix'] . $bo_table;

$dArr = explode("-", $date);

$url = clean_xss_tags($url);
if (!$url) $url = clean_xss_tags($_SERVER['HTTP_REFERER']);

$url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);

// url 체크
check_url_host($url);


/***** 체크건 넘어올때 인원수와 잔여수 체크 *****/
/***** 취소는 잔여 인원에 어차피 포함 안되니까 pass ******/
if ($upd == 'chk' && ($ca == "예약대기" || $ca == "예약완료")) {
	$per = [];

	if ($wr_id) // 건별삭제
		$tmp_array[0] = $wr_id;
	else // 일괄삭제
		$tmp_array = $_POST['chk_wr_id'];

	$chk_count = count($tmp_array);



	// 선박 불러오기
	$bRow = sql_fetch("select bo_1 from {$g5['board_table']} where bo_table = '{$bo_table}'");
	$bArr = explode(";", $bRow["bo_1"]);

	for ($z = 0; $z < $chk_count; $z++) {

		$sql = " select wr_id, ca_name, wr_name, wr_2, wr_3, wr_6 from $write_table where wr_id = '" . $tmp_array[$z] . "' order by wr_id ";
		$row = sql_fetch($sql);
		$row2[] = sql_fetch($sql);


		if (strpos($row["ca_name"], "취소") === 0) { // 예약에서 예약으로 넘어갈때는 어차피 인원수랑 상관이 없으니 취소에서 예약으로 올라올 경우에만 체크
			for ($i = 0; $i < count($bArr) - 1; $i++) {
				$sArr = explode("|", $bArr[$i]);
				$s_name = $sArr[1];

				if ($row["wr_3"] == $s_name) {
					$per[$i][$row["wr_3"]] += (int)$row["wr_6"];
				}
			}
		}
	}


	/*
	print_r2($row2);
	echo "<br>------------<br>";
	*/


	$p_cnt = 0;
	$all_cnt = 0;


	// 체크해서 넘어온 예약에 신청되어있던 인원수
	foreach ($per as $i => $value) {
		$sArr = explode("|", $bArr[$i]);

		unset($arr_db);
		$arr_db = array();
		$sql = "select wr_id, ca_name, wr_name, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7 from {$write_table} where wr_2 = '{$date}' and wr_3 = '{$sArr[1]}' and (ca_name != '공지' and ca_name not like '%취소%') order by wr_3 asc";
		$res = sql_query($sql);


		while ($row3 = sql_fetch_array($res)) {
			$arr_db[] = $row3;
		}
		if ($res) sql_free_result($res);

		$cnt_db = count($arr_db);

		// 정원
		$all_cnt = $sArr[2];


		// 잔여 숫자 구하기
		$arr_cnt = array(); // 잔여숫자도 배열에 담음
		for ($z = 0; $z < $cnt_db; $z++) {

			if ($arr_db[$z]['wr_3'] == $sArr[1]) {
				//echo $z;
				//echo "<br>";
				$p_cnt += ($arr_db[$z]['wr_6']); // 현재 신청 인원 합계

				if ($z == $cnt_db - 1) {
					$arr_cnt[] = $p_cnt;
					$p_cnt = 0;
				}
			}
		}

		/*
		// 정원에서 현재 신청되어있던 인원을 빼서 잔여인원을 구함
		$now_cnt = $all_cnt - $arr_cnt[0];
		
		print_r("정원 <span style='color:#fa5047;font-weight:bold;'> : ".$all_cnt."</span>");
		echo "<br>";
		print_r("지금 체크해서 넘어온 숫자 : ".$per[$i][$sArr[1]]);
		echo "<br>";
		print_r("현재 예약되어있는 숫자 : ".$arr_cnt[0]);
		echo "<br>";
		print_r("현재 예약가능 숫자 <span style='color:#53a5ee;font-weight:bold;'> : ".$now_cnt."</span>");
		echo "<br>";
		*/


		if (($per[$i][$sArr[1]] + $arr_cnt[0]) > $all_cnt) { // 현재 체크값으로 넘어온 인원을 합한 값과 잔여인원을 비교
			//echo "잔여인원초과";
			alert('체크된 항목에 잔여 인원을 초과한 항목이 있습니다.\n다시 확인해주시기 바랍니다.');
		} else {
			//echo "잔여인원이 충분합니다.";
		}
	}
}


// 체크된 항목
if ($upd == 'chk') {

	$count_write = 0;

	$tmp_array = array();


	if ($wr_id) // 건별삭제
		$tmp_array[0] = $wr_id;
	else // 일괄삭제
		$tmp_array = $_POST['chk_wr_id'];

	$chk_count = count($tmp_array);


	for ($i = $chk_count - 1; $i >= 0; $i--) {
		$row = sql_fetch(" select wr_id, mb_id, wr_is_comment, wr_content, ca_name from $write_table where wr_id = '" . $_POST["chk_wr_id"][$i] . "' order by wr_id ");
		$ca_chk .= $row["ca_name"];
	}

	$ca_chk = strstr($ca_chk, "공지");


	for ($i = $chk_count - 1; $i >= 0; $i--) {
		$sql = " select wr_id, mb_id, wr_is_comment, wr_content, ca_name from $write_table where wr_id = '" . $_POST["chk_wr_id"][$i] . "' order by wr_id ";
		$result = @sql_query($sql);


		$asd = sql_fetch($sql);

		while ($row = sql_fetch_array($result)) {

			if ($ca == "예약대기") {
				$sql_ca = "예약대기";
				$sql_chk = " update {$write_table} set ca_name = '{$sql_ca}' where wr_id = '{$row['wr_id']}' ";
				$sql_chk2 = "";
				if ($ca_chk) {
					alert("공지는 삭제 외에 다른 버튼을 적용할 수 없습니다.", $url);
					return false;
				}
			} else if ($ca == "예약완료") {
				$sql_ca = "예약완료";
				$sql_chk = " update {$write_table} set ca_name = '{$sql_ca}' where wr_id = '{$row['wr_id']}' ";
				$sql_chk2 = "";
				if ($ca_chk) {
					alert("공지는 삭제 외에 다른 버튼을 적용할 수 없습니다.", $url);
					return false;
				}
			} else if ($ca == "취소요청") {
				$sql_ca = "취소요청";
				$sql_chk = " update {$write_table} set ca_name = '{$sql_ca}' where wr_id = '{$row['wr_id']}' ";
				$sql_chk2 = "";
				if ($ca_chk) {
					alert("공지는 삭제 외에 다른 버튼을 적용할 수 없습니다.", $url);
					return false;
				}
			} else if ($ca == "취소완료") {
				$sql_ca = "취소완료";
				$sql_chk = " update {$write_table} set ca_name = '{$sql_ca}' where wr_id = '{$row['wr_id']}' ";
				$sql_chk2 = "";
				if ($ca_chk) {
					alert("공지는 삭제 외에 다른 버튼을 적용할 수 없습니다.", $url);
					return false;
				}
			} else if ($ca == "삭제") {
				$sql_chk = " delete from $write_table where wr_id = '{$row['wr_id']}' ";
				$sql_chk2 = " delete from $write_table where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ";
			} else {
				$sql_ca = "";
				$sql_chk = "";
				$sql_chk2 = "";
			}

			@sql_query($sql_chk);
			@sql_query($sql_chk2);

			$count_write++;
		}
	}


	$sms_type = $ca;
	@include_once($board_skin_path . "/sms_chk_update.skin.php");

	alert("수정이 완료되었습니다.", $url);
} else if ($upd == 'd' && $w == "u") {

	if (!($token && $delete_token == $token)) {
		alert('토큰 에러로 삭제 불가합니다.');
	}

	// 게시글 삭제
	$sql = " delete from $write_table where wr_id = '{$_POST['wr_id']}' ";
	sql_query($sql);


	// 최근게시물 삭제
	$sql = " delete from {$g5['board_new_table']} where bo_table = '$bo_table' and wr_id = '{$_POST['wr_id']}' ";
	sql_query($sql);

	alert("삭제가 완료되었습니다.", $url . '#' . $date);
} else if ($upd == 'ca' && $w == "u") {

	if ($ca == "예약대기") {
		$sql_ca = "예약대기";
	} else if ($ca == "예약완료") {
		$sql_ca = "예약완료";
	} else if ($ca == "취소요청") {
		$sql_ca = "취소요청";
	} else if ($ca == "취소완료") {
		$sql_ca = "취소완료";
	} else {
		$sql_ca = "";
	}

	if (get_session('ss_bo_table') != $_POST['bo_table'] || get_session('ss_wr_id') != $_POST['wr_id']) {
		alert('올바른 방법으로 수정하여 주십시오.');
	}

	$sql = " update {$write_table} set ca_name = '{$sql_ca}' where wr_id = '{$_POST['wr_id']}' ";
	sql_query($sql);

	if ($ca == "예약완료") { // 대기로 다시 바꾸는것은 처리하지 않음

		// 예약완료 시 sms 문자 발송
		$sms_type = "예약완료";
		$sms_wr_id = $_POST['wr_id'];
		@include_once($board_skin_path . "/sms_chk_update.skin.php");
	}

	alert("수정이 완료되었습니다.", $url . '#' . $date);
} else if ($upd == 'cancel' && $w == "u" && $cancel_id) {

	$sql = " update {$write_table} set ca_name = '취소요청' where wr_id = '{$cancel_id}' ";
	sql_query($sql);

	$sql = " select wr_id, mb_id, wr_is_comment, wr_content, ca_name, wr_name, wr_2, wr_3 from $write_table where wr_id = '{$cancel_id}' ";
	$wr_row = sql_fetch($sql);

	$wr_name = $wr_row["wr_name"];
	$wr_2 = $wr_row["wr_2"];
	$wr_3 = $wr_row["wr_3"];

	// 취소요청 시 sms 문자 발송
	$sms_type = "취소요청";
	$sms_wr_id = $cancel_id;
	@include_once($board_skin_path . "/sms_chk_update.skin.php");

	alert("취소요청이 완료되었습니다.", $url);
} else {
	alert('올바른 방법으로 이용해 주세요.');
}
