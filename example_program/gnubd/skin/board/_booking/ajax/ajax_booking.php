<?php 
 include_once('./_common.php');
 
 if (isset($_POST['array_id'])) {
 	$_POST['array_id'] = array_unique($_POST['array_id']);
	 foreach ($_POST['array_id'] as $value) {
	 	$temp[] = $value;
	 }
	 $_POST['array_id'] = $temp;
 }
 
if ($_POST['status'] == "update") {
	
	$use_sms = true;
	
	//예약수정
	$table = "g5_write_".$_POST['bo_1'];
	
	$array_id = $_POST['array_id'];
	for ($i=0; $i < count($array_id); $i++) { 
		if (strpos($array_id[$i], "un")!==false) {
			$val =substr($array_id[$i], 3);
			$sql = "update {$g5['meta_table']} set mta_value = '예약완료' where mta_db_table = '".$board['bo_1']."/reserved' AND mta_idx = '{$val}'";
			sql_query($sql);
		}elseif (strpos($array_id[$i], "null")!==false) {
			$abc[] = explode(";", $_POST['array_date'][$i]);
		}else{
			//게시물 완료처리
			$sql = "update $table set wr_6 = '예약완료' where wr_id = '{$_POST['array_id'][$i]}'";
			sql_query($sql);
		}
	}
	if ($abc) {
		for ($i=0; $i < count($abc); $i++) { 
			meta_update(array("mta_db_table"=>$board['bo_1'].'/reserved',"mta_db_id"=>$abc[$i][1] ,"mta_key"=>$abc[$i][0],"mta_value"=>"예약완료"));
		}
	}
	
	

}elseif ($_POST['status'] == "update_name") {
	
	$use_sms = true;
	
	//예약수정
	$table = "g5_write_".$_POST['bo_1'];
	
	$array_id = $_POST['array_id'];
	for ($i=0; $i < count($array_id); $i++) { 
		if (strpos($array_id[$i], "un")!==false) {
			$val =substr($array_id[$i], 3);
			$sql = "update {$g5['meta_table']} set mta_value = '예약완료|:|{$_POST['username']}' where mta_db_table = '".$board['bo_1']."/reserved' AND mta_idx = '{$val}'";
			sql_query($sql);
		}elseif (strpos($array_id[$i], "null")!==false) {
			$abc[] = explode(";", $_POST['array_date'][$i]);
		}else{
			//게시물 완료처리
			$sql = "update $table set wr_6 = '예약완료' where wr_id = '{$_POST['array_id'][$i]}'";
			sql_query($sql);
		}
	}
	if ($abc) {
		for ($i=0; $i < count($abc); $i++) { 
			meta_update(array("mta_db_table"=>$board['bo_1'].'/reserved',"mta_db_id"=>$abc[$i][1] ,"mta_key"=>$abc[$i][0],"mta_value"=>"예약완료|:|{$_POST['username']}"));
		}
	}
	
	

}elseif($_POST['status'] == "reg"){

	// $use_sms = true;
	$table = "g5_write_".$_POST['bo_1'];
	$array_id = $_POST['array_id'];

	for ($i=0; $i < count($array_id); $i++) {

		$abc[] = explode(";", $_POST['array_date'][$i]);

	}

	for ($i=0; $i < count($abc); $i++) { 
		
		meta_update(array("mta_db_table"=>$board['bo_1'].'/reserved',"mta_db_id"=>$abc[$i][1] ,"mta_key"=>$abc[$i][0],"mta_value"=>"예약대기"));
	}

}elseif ($_POST['status'] == "delete") {
	$use_sms = true;
	//예약취소
	$array_id = $_POST['array_id'];
	$table = "g5_write_".$_POST['bo_1'];

	for ($i=0; $i < count($_POST['array_id']); $i++) { 
		if (strpos($array_id[$i], "null")!==false) {
			
		}elseif (strpos($array_id[$i], "un")!==false) {
			$val =substr($array_id[$i], 3);
			$sql = "DELETE FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/reserved' AND mta_idx = '{$val}'";
			sql_query($sql);
		}else{
			// $sql = "DELETE FROM {$table} WHERE wr_id = '{$_POST['array_id'][$i]}'";
			$sql = "UPDATE {$table} SET wr_4 = '', wr_6 = '취소완료' WHERE wr_id = '{$_POST['array_id'][$i]}'";
			sql_query($sql);
		}
	}

}elseif ( $_POST['status'] == 'date_insert' ) {
	//공백 언더바 처리
	$_POST['date_name'] = preg_replace("/\s+/", "_", $_POST['date_name']);


	// 기간추가
	meta_update(array(
		"mta_db_table"=> $board['bo_1']."/date/config",
		"mta_db_id"=>$_POST['date_name'],
		"mta_key"=>$_POST['start_date'],
		"mta_value"=>$_POST['end_date'])
	);
	
	$_POST['id'] = sql_insert_id();
	
}elseif ($_POST['status'] == "date_update") {
	$_POST['date_name'] = preg_replace("/\s+/", "_", $_POST['date_name']);
	$sql = "SELECT mta_db_id FROM {$g5['meta_table']} WHERE mta_idx = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	// 기간수정
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_db_id = '{$_POST['date_name']}',
					mta_key   = '{$_POST['start_date']}',
					mta_value = '{$_POST['end_date']}'
				WHERE mta_idx = '{$_POST['id']}'";
	sql_query($sql);

	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekday{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekday{$result['mta_db_id']}'";
	sql_query($sql);

	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend{$result['mta_db_id']}'";
	sql_query($sql);
	$sql = " UPDATE {$g5['meta_table']} SET 
					mta_key   = 'wr_weekend2{$_POST['date_name']}'
				WHERE mta_db_table = 'board/{$_POST['bo_table']}' AND  mta_key = 'wr_weekend2{$result['mta_db_id']}'";
	sql_query($sql);

	
	
}elseif ($_POST['status'] == "date_delete") {

	// 기간삭제
	$sql = "delete from {$g5['meta_table']} where mta_idx = '{$_POST['id']}'";
	sql_query($sql);


}elseif ($_POST['status'] == "settings") {
	$bo_table = $_POST['bo_table'];
	$bo_1 = $_POST['bo_1'];
	$bo_2 = $_POST['bo_2'];
	$bo_3 = $_POST['bo_3'];
	$bo_4 = $_POST['bo_4'];
	$bo_1_subj = $_POST['bo_1_subj'];
	$bo_2_subj = $_POST['bo_2_subj'];
	$bo_3_subj = $_POST['bo_3_subj'];
	$bo_4_subj = $_POST['bo_4_subj'];
	$bo_5_subj = $_POST['bo_5_subj'];
	$bo_6_subj = $_POST['bo_6_subj'];
	$bo_7_subj = $_POST['bo_7_subj'];
	$bo_8_subj = $_POST['bo_8_subj'];
	$bo_9_subj = $_POST['bo_9_subj'];
	if ($_POST['chk_SMS'] == "false") {
		$bo_5 = "";
	}else{
		$bo_5 = $_POST['bo_5'];
		
	}
	$bo_6 = $_POST['bo_6'];
	$bo_7 = $_POST['bo_7'];
	$bo_8 = $_POST['bo_8'];
	$bo_9 = $_POST['bo_9'];
    $bo_10 = $_POST['bo_10'];
    
	$bo_max_date = $_POST['bo_max_date'];
	 
	$sql = "ALTER TABLE `{$g5['board_table']}` CHANGE `bo_6` `bo_6` TEXT";
	sql_query($sql);
	$sql = "ALTER TABLE `{$g5['board_table']}` CHANGE `bo_7` `bo_7` TEXT";
	sql_query($sql);
	$sql = "ALTER TABLE `{$g5['board_table']}` CHANGE `bo_8` `bo_8` TEXT";
	sql_query($sql);
    
    $sql = "SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_max_date'";
    $sql_result = sql_query($sql);
    $ckCal = $sql_result -> num_rows;
    if($ckCal == 0){
        $sql = "ALTER TABLE `g5_board`
        ADD COLUMN `bo_max_date` VARCHAR(255) NOT NULL DEFAULT '' AFTER `bo_10`";
        sql_query($sql);
    }

	$sql = "UPDATE {$g5['board_table']} SET bo_2 = '{$bo_2}',
											bo_3 = '{$bo_3}',
											bo_4 = '{$bo_4}',
											bo_5 = '{$bo_5}',
											bo_6 = '{$bo_6}',
											bo_7 = '{$bo_7}',
											bo_8 = '{$bo_8}',
											bo_9 = '{$bo_9}',
											bo_1_subj = '{$bo_1_subj}',
											bo_2_subj = '{$bo_2_subj}',
											bo_3_subj = '{$bo_3_subj}',
											bo_4_subj = '{$bo_4_subj}',
											bo_5_subj = '{$bo_5_subj}',
											bo_6_subj = '{$bo_6_subj}',
											bo_7_subj = '{$bo_7_subj}',
											bo_8_subj = '{$bo_8_subj}',
											bo_9_subj = '{$bo_9_subj}',
											bo_10 = '{$bo_10}',
											bo_max_date = '{$bo_max_date}'
										WHERE bo_table = '{$bo_table}'";
	sql_query($sql);
	$sql = "UPDATE {$g5['board_table']} SET bo_2 = '{$bo_9}',
											bo_3 = '{$bo_4}',
											bo_1_subj = '{$_POST['pay_for_pet']}',
											bo_2_subj = '{$bo_2_subj}',
											bo_3_subj = '{$bo_3_subj}',
											bo_4_subj = '{$bo_4_subj}',
											bo_5_subj = '{$bo_5_subj}',
											bo_6_subj = '{$bo_6_subj}',
											bo_7_subj = '{$bo_7_subj}',
											bo_8_subj = '{$bo_8_subj}',
											bo_9_subj = '{$_POST['mail_user_chk']}',
											bo_10_subj = '{$_POST['mail_adm_chk']}',
											bo_4 = '{$bo_10}',
											bo_5 = 'no',
											bo_9 = '{$_POST['mail_id']}',
											bo_8 = '{$_POST['mail_pass']}',
											bo_7 = '{$_POST['mail_text2']}',
											bo_6 = '{$_POST['mail_text']}',
											bo_10 = '{$_POST['is_mail']}',
											bo_max_date = '{$bo_max_date}'
										WHERE bo_table = '{$bo_1}'";
	sql_query($sql);

	$sql = "UPDATE {$g5['config_table']} SET cf_10 = '{$_POST['sms_check']}',
											 cf_1_subj = '{$_POST['chk_resev_ready_adm']}',
											 cf_2_subj = '{$_POST['chk_resev_ready_user']}',
											 cf_3_subj = '{$_POST['chk_resev_compl_adm']}',
											 cf_4_subj = '{$_POST['chk_resev_compl_user']}',
											 cf_5_subj = '{$_POST['chk_resev_cancel_req_adm']}',
											 cf_6_subj = '{$_POST['chk_resev_cancel_req_user']}',
											 cf_7_subj = '{$_POST['chk_resev_cancel_res_adm']}',
											 cf_8_subj = '{$_POST['chk_resev_cancel_res_user']}',
											 cf_1 = '{$_POST['msg_resev_ready_adm']}',
											 cf_2 = '{$_POST['msg_resev_ready_user']}',
											 cf_3 = '{$_POST['msg_resev_compl_adm']}',
											 cf_4 = '{$_POST['msg_resev_compl_user']}',
											 cf_5 = '{$_POST['msg_resev_cancel_req_adm']}',
											 cf_6 = '{$_POST['msg_resev_cancel_req_user']}',
											 cf_7 = '{$_POST['msg_resev_cancel_res_adm']}',
											 cf_8 = '{$_POST['msg_resev_cancel_res_user']}'";
	sql_query($sql);


}

if ($use_sms) {
	$choose = "calendar_update";
	$array_id = $_POST['array_id']; 
	//전화주문은 입력정보들이 없기때문에 array에서 제외시킴

	$count = count($array_id); //unset시 배열 인덱스가 꼬이기 떄문에 선언

	for ($i=0; $i < $count; $i++) { 
		if (strpos($array_id[$i], "un")!==false) {
			unset($array_id[$i]);
		}elseif (strpos($array_id[$i], "null")!==false) {
			unset($array_id[$i]);
		}
	}

    $array_id = array_unique(array_values($array_id));
	$result = array();
	 for ($i=0; $i < count($array_id); $i++) { 
		$sql = "SELECT * FROM $table WHERE wr_id = '{$array_id[$i]}'";
		$result[$i] = sql_fetch($sql);
	 	include(G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/_reservation/send_SMS.php');
	 }
}

if($_POST['status'] == 'holiday_date_update'){


    $_j_state_date = $_POST['start_date'];
    $_j_state_end = $_POST['end_date'];
    
    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d') {
        $dates = array();
        $current = strtotime( $first );
        $last = strtotime( $last );
        while ($current <= $last) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }
    $abc= dateRange($_j_state_date,$_j_state_end);
    $hd_id = $_POST['id'];
	if ($abc) {
		for ($i=0; $i < count($abc); $i++) {
            for($j=0;$j < count($hd_id); $j++){
                meta_update(array("mta_db_table"=>$board['bo_1'].'/reserved',"mta_db_id"=>$hd_id[$j] ,"mta_key"=>$abc[$i],"mta_value"=>"예약완료"));
            } 
		}
    }

    $_POST['echo_state'] = 'holiday_setting';
    $_POST['echo_update_wr_id'] = $abc;
    $_POST['echo_update_hd_id'] = $hd_id;

}

if($_POST['status'] == 'holiday_date_get'){
    $j_page_row = 20;
    $j_page_now = $_POST['now_page'];
    $j_page_total = 0;
    
    $sql = "SELECT * FROM g5_5_meta WHERE mta_db_table = '".$board['bo_1'].'/reserved'."'";
    if($_POST['holiday_ajax_select'] !== 'all') $sql.= 'AND mta_db_id = "'.$_POST['holiday_ajax_select'].'"';
    $reslute = sql_query($sql);
    $total_list_num = sql_num_rows($reslute);
    $j_page_total = ceil($total_list_num / $j_page_row);
    
    $j_limit_start = $j_page_now * $j_page_row;
    $sql .= " LIMIT ".$j_limit_start.", ".$j_page_row;
    $reslute = sql_query($sql);
    while($row=sql_fetch_array($reslute)){
        $list[] = $row;
    }
    
    $_POST['j_page_row'] = $j_page_row;
    $_POST['j_page_now'] = $j_page_now;
    $_POST['j_page_total'] = $j_page_total;
    $_POST['list'] = $list;
    $_POST['sql'] = $sql;
}

if($_POST['status'] == 'holiday_del'){
    $mta_idx = $_POST['mta_idx'];
    if(gettype($mta_idx) == 'array'){
        for($i =0; $i < count($mta_idx);$i++){
            $set_mda_idx = $mta_idx[$i];
            $sql = "DELETE FROM g5_5_meta WHERE mta_idx = $set_mda_idx AND  mta_db_table = '".$board['bo_1'].'/reserved'."'";
            $reslute = sql_query($sql);

        }
    }else{
        $sql = "DELETE FROM g5_5_meta WHERE mta_idx = $mta_idx AND  mta_db_table = '".$board['bo_1'].'/reserved'."'";
        $reslute = sql_query($sql);
    }
}


echo json_encode($_POST); 
?>