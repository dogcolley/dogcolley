<?php 
include_once('./_common.php');
include_once(G5_THEME_PATH.'/'.G5_SKIN_DIR.'/board/_booking/holiday_lib.php');
// include_once($board_skin_path."/holiday_lib.php");

if ($_POST['status'] == "get_price") {

	$price['animals'] = 0;
	$bo_7_subj = $_POST['bo_7_subj'];
	$bo_8_subj = $_POST['bo_8_subj'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$bo_table = $_POST['bo_table'];
	$bor_table = $_POST['bor_table'];
	$id = $_POST['id'];
	$options = $_POST['op_name'];
	$count = $_POST['op_value'];
	$sale = $_POST['sale'];
	$old1 = $_POST['old1'];
	$old2 = $_POST['old2'];
	$old3 = $_POST['old3'];
	$bo_5_subj = $_POST['bo_5_subj'];

	$week = getWeek($start_date, $end_date, $bo_7_subj,$bo_8_subj);
	$get = getSeason($week);

	$season = is_holiday($get, $bo_5_subj);

	//퇴실시간 계산
	$price['out_time'] = strtotime($end_date);
	
	$price['out_time'] = date("Y-m-d", $price['out_time']);

	//금액계산
	$price['reserve'] = getPrice($season,$id,$bor_table);
	//옵션계산
	$price['option'] = getOptionPrice($options, $count, $bor_table, $id);
	//추가인원계산
	$price['count'] = getAddPrice($old1, $old2, $old3, $bor_table, $id);
	$price['count'] = $price['count'] * count($week);

	//연박계산
	
	$price['sale'] = getSalePrice($season, $sale, $bor_table, $id);

	//애완동물 입장 가격 계산
	if ($_POST['bo_1_subj'] != "") {
		$animals = ($_POST['animals'] * $_POST['bo_1_subj']) * count($week);
	}
	

	// if (!empty($sale) && count($week) >= 2) {
	// 	$price['sale'] = count($week) * $sale;
	// }else{
	// 	$price['sale'] = "0";
	// }
	//결제금액 계싼
	$price['total'] = number_format($price['option'] + $price['reserve'] - $price['sale'] + $price['count'] + $animals);	
	$price['reserve'] = number_format($price['reserve']);
	$price['option'] = number_format($price['option']);
	$price['count'] = number_format($price['count']);
	$price['animals'] = number_format($animals);
	$price['sale'] = number_format($price['sale']);
	
	echo json_encode($price);
}elseif ($_POST['status'] == "update") {

	//예약수정
	$table = "g5_write_".$_POST['bo_table'];
	

	$sql = "SELECT * FROM  $table WHERE wr_id = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	$cur_status = $result['wr_6'];
	
	$sql = "update $table set wr_6 = '{$_POST['value']}' where wr_id = '{$_POST['id']}'";
	
	sql_query($sql);

	if ($cur_status == "취소완료") {
		if ($result['wr_9']==$result['wr_10']) {
			$date_cul = $result['wr_9'];
		}else{
			$in = strtotime($result['wr_9']);
			$out = strtotime($result['wr_10']);

			while ($in < $out) {
			
				$aray[] = date("Y-m-d",$in);
				$in = strtotime("+1 day",$in);
			
			}
			$date_cul = implode(';', $aray);	
		}
        $sql = "UPDATE $table SET wr_4 = '{$date_cul}' WHERE wr_id = '{$_POST['id']}'";
        //$sql = "UPDATE $table SET wr_4 = '' WHERE wr_id = '{$_POST['id']}'";
        sql_query($sql);
    }
    $set_state_value = $_POST['value'];
    $set_state_bo_table =$_POST['bo_table'];
    $set_mta_key = '';
    switch($set_state_value){
        case '예약완료':
            $set_mta_key = 'wr_date_state_pass';
        break;
        case '예약취소':
            $set_mta_key = 'wr_date_state_cancel';
        break;
        case '취소요청':
            $set_mta_key = 'wr_date_state_cancelrq';
        break;
        case '취소완료':
            $set_mta_key = 'wr_date_state_cancel';
            $sql = "update $table set wr_4 = '' where wr_id = '{$_POST['id']}'";
            sql_query($sql);
        break;
    }
    if($set_mta_key){
        $sql = "SELECT COUNT(*) as cnt FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$set_state_bo_table}' AND mta_db_id = '{$id}' AND mta_key = '{$set_mta_key}'";
        $save_date_check = sql_fetch($sql);
        if($save_date_check['cnt'] > 0){ //update
            $sql = "UPDATE {$g5['meta_table']} SET mta_value = NOW() WHERE mta_db_table = 'board/{$set_state_bo_table}' AND mta_db_id = '{$id}' AND mta_key = '{$set_mta_key}' ";
            sql_query($sql);
        }else{ //insert
            $sql = "INSERT INTO {$g5['meta_table']} SET 
                    mta_db_id = '{$id}',
                    mta_key = '{$set_mta_key}',
                    mta_db_table = 'board/{$set_state_bo_table}',
                    mta_value = NOW()
            ";
            sql_query($sql);
        }
    }
	

	$choose = "update";
	$result['wr_6'] = $_POST['value'];
	include_once($board_skin_path."/send_SMS.php");

	echo json_encode($sql); 

}elseif ($_POST['status'] == "chang_start") {
	//datepicker 시작날짜

    $target_date = new DateTime($_POST['start_date']);
    $pre_date = new DateTime();
    $start_cul = abs(floor(($pre_date->format('U') - $target_date->format('U')) / (60*60*24)));
    //datepicker 끝 날짜
    
    $start =  strtotime($_POST['start_date']); 
    $end = strtotime("+7 day", $start);        
    $count_day = 0;

    while ($start <= $end){        
         $date_count = date("Y-m-d",$start);
         $start = strtotime("+1 day",$start);

         $sql = "SELECT wr_id, wr_4 FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_3 = '{$_POST['id']}' AND wr_4 LIKE '%{$date_count}%'";

         
         $result = sql_query($sql);
         if (sql_fetch_array($result)) {
             break;
         }else{
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$bo_table."/reserved' AND mta_db_id = '{$id}' AND mta_key LIKE '%{$date_count}%'";
            if (sql_fetch($sql)) {
                break;
            }else{
                $count_day ++;    
            }
         }
        
    }
          $ss['start_cul'] = $start_cul+1;
          $ss['count_day'] = $start_cul+$count_day;
	
	echo json_encode($ss); 

}elseif($_POST['status'] == "cancel"){
	//예약수정
	$table = "g5_write_".$_POST['bo_table'];
	
	$sql = "update $table set wr_4 = '' where wr_id = '{$_POST['id']}'";
	sql_query($sql);

	$sql = "update $table set wr_6 = '취소완료' where wr_id = '{$_POST['id']}'";
	sql_query($sql);

	$choose = "cancel";
	$sql = "SELECT * FROM  $table WHERE wr_id = '{$_POST['id']}'";
	$result = sql_fetch($sql);

	include_once($board_skin_path."/send_SMS.php");

    $set_state_bo_table =$_POST['bo_table'];
    $set_mta_key = 'wr_date_state_cancel';
    $id = $_POST['id'];

    if($set_mta_key !== ''){
        $sql = "SELECT COUNT(*) as cnt FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$set_state_bo_table}' AND mta_db_id = '{$id}' AND mta_key = '{$set_mta_key}'";
        $save_date_check = sql_fetch($sql);
        if($save_date_check['cnt'] > 0){ //update
            $sql = "UPDATE {$g5['meta_table']} SET mta_value = NOW() WHERE mta_db_table = 'board/{$set_state_bo_table}' AND mta_db_id = '{$id}' AND mta_key = '{$set_mta_key}' ";
            sql_query($sql);
        }else{ //insert
            $sql = "INSERT INTO {$g5['meta_table']} SET 
                    mta_db_id = '{$id}',
                    mta_key = '{$set_mta_key}',
                    mta_db_table = 'board/{$set_state_bo_table}',
                    mta_value = NOW()
            ";
            sql_query($sql);
        }
    }

}
function getSalePrice($season, $sale, $bor_table, $id){
	
	if ($sale == "") {
		return 0;
	}
	global $g5;
	$count = count($season);

	if ($count < 2) {
		$sale = 0;
	}elseif ($count == 2) {
		$sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$bor_table}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale1'";
		$day_sale = sql_fetch($sql);
	}elseif ($count == 3) {
		$sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$bor_table}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale2'";
		$day_sale = sql_fetch($sql);
	}elseif ($count > 3) {
		$sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$bor_table}' AND mta_db_id = '{$id}' AND mta_key = 'wr_roomsale3'";
		$day_sale = sql_fetch($sql);
	}

	return $day_sale['mta_value'];
}
function getAddPrice($old1, $old2, $old3, $bor_table, $id){
	global $g5;
	$count = $old1 + $old2 + $old3;
	$price = 0;
	$vv = array();
	// $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$bor_table}' AND mta_db_id = '{$id}' AND (mta_key = 'wr_min' or mta_key = 'wr_max')";
	$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$bor_table}' AND mta_db_id = '{$id}'";
	$result = sql_query($sql);
	while ($row = sql_fetch_array($result)) {
		$vv[$row['mta_key']] = $row['mta_value'];
	}
	
	
	if ($count > $vv['wr_min']) {
		while ($old3 > 0) {
			if ($count > $vv['wr_min']) {
				$count --;
				$old3 --;
				$price += $vv['wr_13'];
				// echo $price."1<br>";

			}else{
				break;
			}
		}
		// echo $adult = $price;
		while ($old2 > 0) {
			if ($count > $vv['wr_min']) {
				$count --;
				$old2 --;
				$price += $vv['wr_12'];
				// echo $price."2<br>";
			}else{
				break;
			}
		}
		while ($old1 > 0) {
			if ($count > $vv['wr_min']) {
				$count --;
				$old1 --;
				$price += $vv['wr_11'];
				// echo $price."3<br>";
			}else{
				break;
			}
		}
	}

	
	return $price;
}


function getWeek($start_date, $end_date, $bo_7_subj,$bo_8_subj){
	$start = strtotime($start_date); 
	$end = strtotime('-1 day',strtotime($end_date));  
	
	$i = 0;
	while ($start <= $end){        
	     
		if (date("w",$start) == "5" || date("w",$start) == "6") {
		 	if ($bo_7_subj == 1 && date("w",$start) == "6") {
		 		$abc[$i]['date'] = date("Y-m-d",$start);
			 	$abc[$i]['name'] = "wr_weekend2비수기";	
		 	}elseif (date("w",$start) == "5" && $bo_8_subj == 1) {
		 		$abc[$i]['date'] = date("Y-m-d",$start);
			 	$abc[$i]['name'] = "wr_weekday비수기";
		 	}else{
		 		$abc[$i]['date'] = date("Y-m-d",$start);
			 	$abc[$i]['name'] = "wr_weekend비수기";	
		 	}
		}else{
		 	$abc[$i]['date'] = date("Y-m-d",$start);
		 	$abc[$i]['name'] = "wr_weekday비수기";
		}

	    $start = strtotime("+1 day",$start);
		$i++;
	}
	
	return $abc;
}


function getSeason($week){

	global $g5;
	global $bo_table;
	$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$bo_table."/date/config'";
    $result = sql_query($sql);
	$i = 0;

	while ($row = sql_fetch_array($result)) {

	    $date_config[$i]['date_name'] = $row['mta_db_id'];
	    $date_config[$i]['start_date'] = $row['mta_key'];
	    $date_config[$i]['end_date'] = $row['mta_value'];
	    
	    $start =  strtotime($date_config[$i]['start_date']); 
		$end = strtotime($date_config[$i]['end_date']);         

	    $i++;
	}

	

	for ($i=0; $i < count($week); $i++) { 
		for ($j=0; $j < count($date_config); $j++) { 
			$start = strtotime($date_config[$j]['start_date']);
			$end = strtotime($date_config[$j]['end_date']);
			$tartget = strtotime($week[$i]['date']);
			
			if ($start > $tartget || $end < $tartget) {

			}else{
				if (strpos($week[$i]['name'], "weekend")) {
					if (strpos($week[$i]['name'], "weekend2")) {
						$week[$i]['name'] = "wr_weekend2".$date_config[$j]['date_name'];
					}else{
						$week[$i]['name'] = "wr_weekend".$date_config[$j]['date_name'];
					}
					
					

				}else{
					$week[$i]['name'] = "wr_weekday".$date_config[$j]['date_name'];
				}
				$week[$i]['season'] = $date_config[$j]['date_name'];
			}
			

		}

		
	}

	return $week;

}

function is_holiday($week, $bo_5_subj="",$is_use_holi=""){
	if ($bo_5_subj=="") {

		return $week;
	}

	$calendar = new Calendar();


	for ($i=0; $i < count($week); $i++) { 
		// $holi_check = date("Y-m-d",strtotime("+1 day", strtotime($week[$i]['date'])));
		$is_holiday = $calendar->getHolidayWeekend($week[$i]['date']);

		if ($is_holiday) {
			$value_2 = "weekend";

			if($_POST['bo_7_subj']=="1" || $is_use_holi=="1"){
				$value_2 = "weekend2";
			}
            
            if(strpos($week[$i]['name'], 'weekday') !== false) {  
                $week[$i]['name'] = str_replace('weekday', $value_2, $week[$i]['name']);
            } else {  
                $week[$i]['name'] = str_replace('weekend', $value_2, $week[$i]['name']);
            }  
            
		}
	}
	

	return $week;
}

function getPrice($season, $id, $table){
	global $g5;
	$price = 0;

	for ($i=0; $i < count($season); $i++) { 
		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$table}' AND mta_db_id = '{$id}' AND mta_key = '{$season[$i]['name']}'  ORDER BY  mta_reg_dt DESC";
		$result = sql_fetch($sql);

		

		//가격,날짜,요일 정보
		if ($result['mta_value']=="") {
			$reple = str_replace($season[$i]['season'], '비수기', $season[$i]['name']);
			$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$table}' AND mta_db_id = '{$id}' AND mta_key = '{$reple}'";
			$result = sql_fetch($sql);
		}

		$price = $price + $result['mta_value'];

		$price_data[$i]['price'] = $result['mta_value'];
		$price_data[$i]['date'] = $season[$i]['date'];
		$price_data[$i]['name'] = $season[$i]['name'];
	}
	
	return $price;

}

function getOptionPrice($options, $count, $table, $id){
	global $g5;
	$price = 0;

	for ($i=0; $i < count($options); $i++) { 
		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$table}' AND mta_db_id = '{$id}' AND mta_key = '{$options[$i]}'";
		$result = sql_fetch($sql);
		$price = $price + ($result['mta_value'] * $count[$i]);
		// $arr[$i]['op_name'] = $options[$i];
		// $arr[$i]['count'] = $count[$i];
	}
	return $price;
}


?>