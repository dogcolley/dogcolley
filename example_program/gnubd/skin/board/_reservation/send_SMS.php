<?php 
include_once('./_common.php');
include_once(G5_LIB_PATH.'/icode.sms.lib.php'); 

$useSendDate = true;
if($useSendDate)
    $SendDate = ' 신청 날짜 : '.date("Y-m-d H:i:s");
else 
    $SendDate = ' ';
/*yapge: 자체 sms 기록*/
$sql = "SHOW TABLES LIKE '%g5_5_sms%'";
$resulte = sql_query($sql);
$num = $resulte -> num_rows;
if($num <1){
    $sql = "
    CREATE TABLE `g5_5_sms` (
        `sms_id` INT(11) NOT NULL AUTO_INCREMENT,
        `sms_mssage` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `sms_type` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `sms_send_number` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `sms_receive_number` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `sms_status` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `sms_reg_date` DATETIME NULL DEFAULT NULL,
        PRIMARY KEY (`sms_id`) USING BTREE,
        INDEX `sms_id` (`sms_id`) USING BTREE
    )
    COLLATE='latin1_swedish_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=3
    ";
    sql_query($sql);
}

function g5_sms_add ($receive_number,$send_number){
    GLOBAL $g5_5_sms_status;
    GLOBAL $sms_type;
    GLOBAL $sms_message;
    $status = $g5_5_sms_status;
    if($sms_message){
        $sql = "INSERT INTO g5_5_sms SET 
            sms_mssage = '${sms_message}',
            sms_type = '${sms_type}',
            sms_send_number = '${send_number}',
            sms_receive_number = '${receive_number}',
            sms_status = '${status}',
            sms_reg_date = NOW()
        ";
    }
    $row = sql_query($sql);
}
/*yapge: 자체 sms 기록*/

////////예시변수
if ($choose == "write") {
	$msg_status = $wr_6; //상태 ex)취소요청
	$wr_2       = $wr_2; //유저이름
	$room       = $wr_5; //객실명
	$use_hp_mb  = $wr_1; // 사용자 전화번호 
	$wr_8       = $wr_8;
	if ($start_value == $end_value) {
		$date   = $start_value;
	}else{
		$date   = $start_value." ~ ".$end_value;
	}

}elseif ($choose == "update") {
	$msg_status = $result['wr_6']; //상태 ex)취소요청
	$wr_2       = $result['wr_2']; //유저이름
	$room       = $result['wr_5']; //객실명
	$use_hp_mb  = $result['wr_1']; // 사용자 전화번호 
	$wr_8       = $result['wr_8']; //예약 가격
	if ($result['wr_9'] == $result['wr_10']) {
		$date   = $result['wr_9'];
	}else{
		$date   = $result['wr_9']." ~ ".$result['wr_10'];
	}
}elseif ($choose == "cancel"){
	$msg_status = $result['wr_6']; //상태 ex)취소완료
	$wr_2       = $result['wr_2']; //유저이름
	$room       = $result['wr_5']; //객실명
	$use_hp_mb  = $result['wr_1']; // 사용자 전화번호 
	$wr_8       = $result['wr_8']; //예약 가격
	if ($result['wr_9'] == $result['wr_10']) {
		$date   = $result['wr_9']; //예약 날짜정보
	}else{
		$date   = $result['wr_9']." ~ ".$result['wr_10'];
	}
	
}elseif($choose == "calendar_update"){
	
	$msg_status = $result[$i]['wr_6']; //상태 ex)취소완료
	$wr_2       = $result[$i]['wr_2']; //유저이름
	$room       = $result[$i]['wr_5']; //객실명
	$use_hp_mb  = $result[$i]['wr_1']; // 사용자 전화번호 
	$wr_8       = $result[$i]['wr_8']; //예약 가격
	if ($result[$i]['wr_9'] == $result[$i]['wr_10']) {
		$date   = $result[$i]['wr_9']; //예약 날짜정보
	}else{
		$date   = $result[$i]['wr_9']." ~ ".$result[$i]['wr_10'];
	}
	
}else{
	return;
}

//db에서 sms 설정 정보들을 가져옴
$sql = " SELECT * FROM {$g5['config_table']}  ";

$uplus_sms = sql_fetch($sql);


if ($uplus_sms['cf_10']=="") {
	return;
}

elseif ($uplus_sms['cf_10']=="1") {
	// 유플러스sms 인증키
	$use_smsid = $uplus_sms['cf_nct_sms_id']; // SMSID
	$use_smskey = $uplus_sms['cf_nct_sms_key']; // SMSkey 

	//관리자 문자 발송
	$send_hp_mb = $uplus_sms['cf_nct_sms_num']; // 발신 전화번호
	$admin_hp_mb = $uplus_sms['cf_nct_sms_sendnum']; // 관리자 전화번호 

	//소켓통신
	$info = parse_url("http://sms.nccj.kr/api/remind_count/".$use_smsid."/".$use_smskey);
	$fp = fsockopen($info['host'], 80);

	if($fp){
		$remindCountResult = "0";
		$parm = "";
		$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
		."Host: " . $info["host"] . "\r\n"
		. "Content-type: application/x-www-form-urlencoded\r\n"
		. "Content-length: " . strlen($parm) . "\r\n"
		. "Connection: close\r\n\r\n" . $parm."\r\n";

		fputs($fp, $send);
		
		while(!feof($fp)) $remindCountResult = fgets($fp, 128);

		$remindResult = json_decode($remindCountResult);
        $remindCount = $remindResult->remind_count;
	}
}else{
	$sql = " SELECT * FROM sms5_config where cf_phone ";
	$sms5 = sql_fetch($sql);

	$sql = " SELECT * FROM g5_member where mb_level='8'";
	$admin_member = sql_fetch($sql);

	if($admin_member['mb_level'] == '8' && $admin_member['mb_sms']=='1'){
		$admin_hp_mb = $admin_member['mb_hp']; //  관리자 전화번호 
		 
	}

	$SMS = new SMS; // SMS 연결 
	$SMS->SMS_con($uplus_sms['cf_icode_server_ip'], $uplus_sms['cf_icode_id'], $uplus_sms['cf_icode_pw'], $uplus_sms['cf_icode_server_port']);

	$send_hp_mb = $sms5['cf_phone']; // 발신 전화번호 
}

$send_hp = str_replace("-","",$send_hp_mb); // - 제거 
$admin_hp = str_replace("-","",$admin_hp_mb); // - 제거 
$use_hp = str_replace("-","",$use_hp_mb); // - 제거 

$send_number =  "$send_hp"; // 사전등록번호
$admin_number = "$admin_hp"; // 관리자 전화번호 
$use_number = "$use_hp"; // 사용자 전화번호 



//관리자한테 메세지 보냄
if($msg_status == "예약대기") {
    if($uplus_sms['cf_1_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_1']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if($msg_status == "예약완료") {
    if($uplus_sms['cf_3_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_3']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if($msg_status == "취소요청") {
    if($uplus_sms['cf_5_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_5']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if($msg_status == "취소완료") {
    if($uplus_sms['cf_7_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_7']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if (mb_strwidth($sms_message) <= 80) {
    $sms_type = "pension";
}else{
    $sms_type = "lms";
}
//메세지 보내기
if ($uplus_sms['cf_10']=="1") {
    if($sms_message){
        $info = @parse_url("http://sms.nccj.kr/api/".$sms_type);
        $fp = @fsockopen($info['host'], 80);
        $sms_message = $sms_message.$SendDate;
        if($fp){
            $parm = "callbackHp=".$send_number."&smsHp=".$admin_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
            $send = "POST " . $info["path"] . " HTTP/1.1\r\n"
            ."Host: " . $info["host"] . "\r\n"
            . "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-length: " . strlen($parm) . "\r\n"
            . "Connection: close\r\n\r\n" . $parm."\r\n";
            
            $resulte = @fputs($fp, $send);
            g5_sms_add($admin_number,$send_number);
        }
    }
}elseif ($uplus_sms['cf_10']=="2") {
    $SMS->Add($admin_number, $send_number, $uplus_sms['cf_icode_id'], iconv("utf-8", "euc-kr", stripslashes($sms_message)), "");
    $SMS->Send(); 
}



//예약자한테 메세지 보냄
if($msg_status == "예약대기") {
    if($uplus_sms['cf_2_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_2']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}

if($msg_status == "예약완료") {
    if($uplus_sms['cf_4_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_4']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}

if($msg_status == "취소요청") {
    if($uplus_sms['cf_6_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_6']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if($msg_status == "취소완료") {
    if($uplus_sms['cf_8_subj']=="true") {
        $message_con = str_replace("{name}", $wr_2, $uplus_sms['cf_8']);
        $message_con = str_replace("{room}", $room, $message_con);
        $message_con = str_replace("{date}", $date, $message_con);
        $sms_message = str_replace("{price}", $wr_8, $message_con);
    }
}
if (mb_strwidth($sms_message) <= 80) {
    $sms_type = "pension";
}else{
    $sms_type = "lms";
}
//메세지 보내기
if ($uplus_sms['cf_10']=="1") {
    if($sms_message){
        $info = @parse_url("http://sms.nccj.kr/api/".$sms_type);
        $fp = @fsockopen($info['host'], 80);
        $sms_message = $sms_message.$SendDate;
        if($fp){
            $parm = "callbackHp=".$send_number."&smsHp=".$use_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
            // $parm = "callbackHp=".$admin_number."&smsHp=".$use_number."&smsId=".$use_smsid."&encCode=".$use_smskey."&receiveContent=".$sms_message;
            //echo $parm;
            $send = "POST " . $info["path"] . " HTTP/1.1\r\n"
            ."Host: " . $info["host"] . "\r\n"
            . "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-length: " . strlen($parm) . "\r\n"
            . "Connection: close\r\n\r\n" . $parm."\r\n";
            
            @fputs($fp, $send);
            g5_sms_add($use_number,$send_number);
        }	
    }
}elseif ($uplus_sms['cf_10']=="2") {
    $SMS->Add($use_number, $send_number, $uplus_sms['cf_icode_id'], iconv("utf-8", "euc-kr", stripslashes($sms_message)), "");
    $SMS->Send(); 
}





?>