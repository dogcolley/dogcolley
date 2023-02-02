<?php
include_once ($board_skin_path . "/ajax/ajax_reservation.php");
//달력 예약된방 체크

//add. bo_max_date를 가져와서 해당일 보다 크면 막아버린다.

$today = strtotime(date("Y-n-j"));
$matchTime = strtotime("+".$board['bo_max_date']." month",$today);
$matchDate = date("Y-n-t",$matchTime);

if($board['bo_max_date'] == ''){
    $limitDate = true;
}
else {
    if(strtotime($start_value) <= strtotime($matchDate) &&  strtotime($end_value) <= strtotime($matchDate) )
        $limitDate = true;
    else
        $limitDate = false;
}

if(!$limitDate)
    alert('예약범위를 벗어났습니다!');

//예약날짜 = wr4
$start =  strtotime($start_value); 
       
$end = strtotime('-1 day',strtotime($end_value));
$count_day = 0;


while ($start <= $end){        

     if ($count_day==0) {
        $a = date("Y-m-d", $start);
     }else{
        $a .= ";".date("Y-m-d", $start);   
     }
     $start = strtotime("+1 day",$start);

     $count_day ++;

}


$week = getWeek($start_value, $end_value, $board['bo_7_subj'],$board['bo_8_subj']);
$getSeason = getSeason($week);
$getSeason = is_holiday($getSeason,$board['bo_5_subj'],$board['bo_7_subj']);


$new_array = array();
$price_array = array();

//new_array
for ($i=0; $i < count($getSeason); $i++) { 
    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$wr_3}' AND mta_key = '{$getSeason[$i]['name']}'";
    $val = sql_fetch($sql);
    //시즌 금액이 없다면 비수기 가격으로 계산
    if ($val['mta_value'] == "") {
        $getSeason[$i]['name'] = str_replace($getSeason[$i]['season'], '비수기', $getSeason[$i]['name']);
        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$wr_3}' AND mta_key = '{$getSeason[$i]['name']}'";
        $val = sql_fetch($sql);
    }
    $getSeason[$i]['price'] = $val['mta_value'];
    if ($getSeason[$i]['season']) {

        $new_array[$getSeason[$i]['season']][] = $getSeason[$i];

    }else{
        $new_array['비수기'][] = $getSeason[$i];
    }
    
}
//price_array
foreach ($new_array as $key => $value) {
    $price = 0;
    for ($i=0; $i < count($new_array[$key]); $i++) { 
        $price += $new_array[$key][$i]['price'];
    }
    $new_array[$key]['price'] = $price;
}
$encode = json_encode($new_array,JSON_UNESCAPED_UNICODE);

$sql = "ALTER TABLE `{$write_table}` CHANGE `wr_7` `wr_7` TEXT";
sql_query($sql);

$sql = "update $write_table set wr_4 = '{$a}',
                                wr_7 = '{$encode}', 
                                wr_9 = '{$start_value}',
                                wr_10 = '{$end_value}'
                                 where wr_id = '{$wr_id}'";
sql_query($sql);


//메세지 발송용 변수 정의
$choose = "write";
include_once($board_skin_path."/send_SMS.php");
//이메일 발송
if ($board['bo_10'] == '1') {
    include_once(G5_LIB_PATH.'/mailer.lib.php');

    $sql = "SELECT * FROM {$g5['config_table']}";
    $fetch = sql_fetch($sql);

    if ($board['bo_10_subj']=="1") {        
        //사용자
        $wr_name = $fetch['cf_title'];
        $wr_email = $board['bo_7']; 
        $email = $wr_mail;
        $subject= $fetch['cf_title']." 예약 객실 안내"; 
        $link = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;
        $board['bo_6'] = str_replace('{name}', $wr_2, $board['bo_6']);
        $board['bo_6'] = str_replace('{date}', $start_value.'~'.$end_value, $board['bo_6']);
        $board['bo_6'] = str_replace('{price}', $wr_8, $board['bo_6']);
        $board['bo_6'] = str_replace('{link}', "<br><a href='".$link."'>내 예약페이지 바로가기</a>", $board['bo_6']);
        $content=nl2br($board['bo_6']);
        mailer($board['bo_9'],$board['bo_8'],$email,$subject,$content);
    }
    if ($board['bo_9_subj']=="1") {
        //어드민
        $email = $fetch['cf_admin_email'];
        $subject= $fetch['cf_title']." 예약 객실 안내";
        $link = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;

        $board['bo_7'] = str_replace('{name}', $wr_2, $board['bo_7']);
        $board['bo_7'] = str_replace('{date}', $start_value.'~'.$end_value, $board['bo_7']);
        $board['bo_7'] = str_replace('{price}', $wr_8, $board['bo_7']);
        $board['bo_7'] = str_replace('{link}', "<br><a href='".$link."'>내 예약페이지 바로가기</a>", $board['bo_7']);
        $content=nl2br($board['bo_7']);

        mailer($board['bo_9'],$board['bo_8'],$email,$subject,$content);   
    }
}

?>