<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
 
//print_r2($_POST);
 
//-- 필드명 추출 wr_ 와 같은 앞자리 3자 추출 --//
$r = sql_query(" desc {$write_table} ");
while ( $d = sql_fetch_array($r) ) {$db_fields[] = $d['Field'];}
$db_prefix = substr($db_fields[0],0,3);
 
//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
$checkbox_array=array();
for ($i=0;$i<sizeof($checkbox_array);$i++) {
	if(!$_REQUEST[$checkbox_array[$i]])
		$_REQUEST[$checkbox_array[$i]] = 0;
}
 
//-- 메타 입력 (디비에 있는 설정된 값은 입력하지 않는다.) --//
$db_fields[] = "mb_zip";	// 건너뛸 변수명은 배열로 추가해 준다.
$db_fields[] = "mb_sido_cd";	// 건너뛸 변수명은 배열로 추가해 준다.
foreach($_REQUEST as $key => $value ) {
	//-- 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트 --//
	if(!in_array($key,$db_fields) && substr($key,0,3)==$db_prefix) {
		echo $key."=".$_REQUEST[$key]."<br>";
		meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>$key,"mta_value"=>$value));
	}
}
//exit;
 

 
//sand SMS
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

//send SMS Uplus


//db에서 sms 설정 정보들을 가져옴
$sql = " SELECT * FROM {$g5['config_table']}  ";
$uplus_sms = sql_fetch($sql);

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

$sms_message= "관리자님 $wr_name 님 문의 접수가 접수되었습니다. \n 연락처: $wr_1 \n 문의글확인 : ".G5_BBS_URL."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;
$send_number = $uplus_sms['cf_nct_sms_num'];
$admin_number = $uplus_sms['cf_nct_sms_sendnum'];

if (mb_strwidth($sms_message) <= 80) {
    $sms_type = "pension";
}else{
    $sms_type = "lms";
}

if($sms_message){
    $info = @parse_url("http://sms.nccj.kr/api/".$sms_type);
    $fp = @fsockopen($info['host'], 80);

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

?>
