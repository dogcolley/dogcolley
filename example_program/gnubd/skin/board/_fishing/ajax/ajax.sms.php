<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];
$write_table = $g5['write_prefix'].$_POST['bo_table'];
$w = $_POST['w'];


//우예지 for:  ncts SMS 전송유형 필드 추가
if(!isset($config['cf_nct_sms_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_nct_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_port`,
                    ADD `cf_nct_sms_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_use`,
					ADD `cf_nct_sms_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_id`,
					ADD `cf_nct_sms_num` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_key`,
					ADD `cf_nct_sms_sendnum` varchar(255) NOT NULL DEFAULT '' AFTER `cf_nct_sms_num` ", true);
}


if ( $w == 'u' ) {	
		
	$sql = " update {$g5['config_table']}
					set 
					cf_nct_sms_use = '{$_POST['cf_nct_sms_use']}',
					cf_nct_sms_id = '{$_POST['cf_nct_sms_id']}',
					cf_nct_sms_key  = '{$_POST['cf_nct_sms_key']}',
					cf_nct_sms_sendnum = '{$_POST['cf_nct_sms_sendnum']}',
					cf_nct_sms_num = '{$_POST['cf_nct_sms_num']}'";
	sql_query($sql);

	//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
	$checkbox_array=array("pn_sms_reserv_ready_adm", "pn_sms_reserv_ready_user", "pn_sms_reserv_comp_adm", "pn_sms_reserv_comp_user", "pn_sms_reserv_canc_adm", "pn_sms_reserv_canc_user", "pn_sms_reserv_canc_cplt_adm", "pn_sms_reserv_canc_cplt_user");
	for ($i=0;$i<sizeof($checkbox_array);$i++) {
		if(!$_REQUEST[$checkbox_array[$i]])
			$_REQUEST[$checkbox_array[$i]] = 0;
	}

	$db_fields[] = "mb_zip";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "mb_sido_cd";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "bo_table";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "w";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "cf_nct_sms_use";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "cf_nct_sms_id";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "cf_nct_sms_key";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "cf_nct_sms_sendnum";	// 건너뛸 변수명은 배열로 추가해 준다.
	$db_fields[] = "cf_nct_sms_num";	// 건너뛸 변수명은 배열로 추가해 준다.
	foreach($_REQUEST as $key => $value ) {
		//-- 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트 --//
		if(!in_array($key,$db_fields)) {
			//echo $key."=".$_REQUEST[$key]."<br>";
			meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>"sms_setting","mta_key"=>$key,"mta_value"=>$value));
		}
	}

}
?>