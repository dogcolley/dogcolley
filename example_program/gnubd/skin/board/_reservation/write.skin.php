<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css?ver=20201008">', 1);

?>
<?php
//////////////////////////객실정보 담기 ///////////////////////////
$sql = "SELECT * FROM {$g5['write_prefix']}{$board['bo_1']} WHERE wr_id = '{$id}'";
$booking = sql_fetch($sql);

$sql = "SELECT * FROM g5_5_meta WHERE mta_db_table = 'board/{$board['bo_1']}' AND mta_db_id = '{$id}'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    
    $booking[$row['mta_key']] = $row['mta_value'];
}
//////////////////////////객실정보 담기 ///////////////////////////
?>
<style>
.rest_date{padding-top: 7px;width: 80px;float: left;}
.option_tbl>td{border: 1px solid !important;}


@media screen and (min-width:1000px){
    

    .aa{width: 48%;float: left;border: 1px solid #ababab;padding-bottom: 30px;height: 100%;}
    .bb{width: 48%;float: right;border: 1px solid #ababab;padding-bottom: 10px;height: 100%;}
    .selected_info{padding: 30px 0px 10px;text-align: center;width: 100%;font-size: 16px;font-weight: 700;}
    .reserve_date{color: #ff6559;font-size: 18px;padding-left: 8px;}
    .tb_div{padding-top: 10px;width: 80%;margin: auto;}
    .tb_price_div{padding-top: 10px;width: 80%;margin: auto;height: 100%;}
    .padding_table{width: 4%;}
    .tb_price{text-align: center;height: 100%;width: 100%;}
    #room_sale_price{color: red;}
    #sum_price{color: blue;}
    .tb_price td{font-size: 17px;}
    .room_data th{width: 20%;font-size: 15px;padding-bottom: 5px;padding-right: 70px;} 
    .room_data td {padding-bottom: 5px;width: 80%;font-size: 15px;}
    .price_info{padding: 30px 0px 10px;text-align: center;width: 100%;font-size: 16px;font-weight: 700;}
    .option_class{width: 50%;}
}
@media screen and (max-width:999px) {
    .aa{width: 100%;float: left;border: 1px solid #ababab;padding-bottom: 30px;}
    .bb{padding-top: 50px;width: 100%;float: right;padding-bottom: 30px;}
    .selected_info{padding: 30px 0px 10px;text-align: center;width: 100%;font-size: 16px;font-weight: 700;}
    .reserve_date{color: #ff6559;font-size: 18px;padding-left: 8px;}
    .tb_div{padding-top: 10px;width: 90%;margin: auto;}
    .tb_price_div{width: 100%;margin: auto;}
    .tb_price{padding-top: 20px;width: 80%;text-align: center;border: 1px solid #ababab;}
    #room_sale_price{color: red;}
    #sum_price{color: blue;}
    .padding_table{    }
    .tb_price td{font-size: 15px;}
    .room_data th{width: 20%;font-size: 13px;padding-bottom: 5px;padding-right: 70px;} 
    .room_data td {padding-bottom: 5px;width: 80%;font-size: 13px;}
    .price_info{padding: 30px 0px 10px;text-align: center;width: 100%;font-size: 16px;font-weight: 700;}
    .option_class{width: 100%;}
}
</style>
<?php 
$dailyCul = array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
$daycul = $dailyCul[date("w",strtotime($_GET['reservation_date']))];
?>

<h2 class="reservAccountTitle1" style="text-align:center;">
    <span class="highlight"><i class="fab fa-envira"></i></span> 
    <span class="highlight1">예약 하기</span> 
    
</h2>

<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="wr_subject" value="객실 예약">
    <input type="hidden" name="wr_content" value="-">
    <input type="hidden" name="wr_6" value="예약대기">
    <!-- <input type="hidden" name="wr_2" value = "<?php echo $_GET['bor_table']?>"> -->
    <input type="hidden" name="wr_3" value = "<?php echo $_GET['id']?>">
    <input type="hidden" name="wr_8" value = "<?php if($wr_8){echo $wr_8;}else{echo '0원';}?>" id="total_price">
    <input type="hidden" name="wr_5" value="<?php echo $booking['wr_subject']?>">
    <input type="hidden" name="wr_name" value="user">
    <input type="hidden" name="wr_animals" value="0원" id="animal_price">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html">html</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    
    $sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$board['bo_1']}'";
    $agree = sql_fetch($sql);
    
    
    ?>
    
    <div class="tbl_frm01 tbl_wrap">
    

        <table>
        
        <tbody>
            <div class="info" style="padding-bottom:5px;">
                <div style="/*border: 1px solid black;*/padding: 10px;background: #ddd;">
                    <h4><input type="checkbox" name="chk_agree1" class="check_agree"> 개인정보 동의서 
                        <div style="float: right;"> 
                            <span id="agree1" style="cursor: pointer;">내용보기</span> 
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr1" style="display: none;">
                    <?php echo nl2br($agree['bo_7'])?><br/>
                </div>
                
            </div>
            <div class="info" style="padding-bottom:5px;">
                <div style="padding: 10px;background: #ddd;">
                    <h4><input type="checkbox" name="chk_agree2" class="check_agree"> 환불 및 취소 안내
                        <div style="float: right;">
                            <span id="agree2" style="cursor: pointer;">내용보기</span>
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr2" style="display: none;">
                    <?php echo nl2br($agree['bo_8'])?><br/>
                </div>
                
            </div>
            <div class="info" style="padding-bottom:5px;">
                <div style="padding: 10px;background: #ddd;">
                    <h4><input type="checkbox" name="chk_agree3" class="check_agree"> 입퇴실 규정 동의서
                        <div style="float: right;">
                            <span id="agree3" style="cursor: pointer;">내용보기</span>
                        </div>
                    </h4>
                </div>
                <div class="scr" id="scr3" style="display: none;">
                   <?php echo nl2br($agree['bo_6'])?><br/>
                </div>
                
            </div>
            <div class="info" style="border-bottom:1px solid #ddd;padding-bottom: 30px;">
                <div style="padding: 10px;background: #ddd;">
                    <h4><input type="checkbox" id="check_all"> 전체 동의합니다.
                    </h4>
                </div>
            </div>

        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td>
                <select class="form-control" style="width:120px; display: inline-table;" id="ca_name" name="ca_name" required>
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>


        

        <!-- <tr>
            <th scope="row"><label for="wr_name">예약자명<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" maxlength="20"></td>
        </tr> -->

        <tr>
            <th scope="row"><label for="wr_2"><span style="color: red;"></span>입금계좌<strong class="sound_only">필수</strong></label></th>
                <td>
                    <!--351-1084-1775-13 농협 (이혜정) -->
					<p style="font-size:0.8em">해당계좌로 입금 바랍니다.</p>
				</td> 
			</tr>
        <tr>
            <th scope="row"><label for="wr_2">예금주명<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_2" value="<?php echo $wr_2 ?>" id="wr_2" required class="frm_input required" maxlength="20" placeholder="예약자명과 동일합니다."> </a></td> 
        </tr>
        

        

       <!--  <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" maxlength="100"></td>
        </tr>
        <?php } ?> -->


        
        <tr>
            <th scope="row"><label for="wr_1">휴대폰번호</label></th>
            <td>
                <span style="display: inline-block;"><input placeholder="ex) 01012345678" type="text" name="wr_1" value="<?php echo $write['wr_1'] ?>" id="wr_1" required class="frm_input required" size="25" maxlength="11"></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td>
                <span style="display: inline-block;"><input type="text" name="wr_mail" class="frm_input required"></span>
            </td>
        </tr>
        
    
        <tr>
            <?php 
            //숙박기간 시작 제한날짜 계산
            $sql = "SELECT wr_4 FROM $write_table WHERE wr_3 = {$id}";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                if (strpos($row['wr_4'], ";") !== false) {

                    $dividing = explode(";", $row['wr_4']);

                    for ($i=0; $i < count($dividing); $i++) { 
                        $before = strtotime($dividing[$i]);
                        $reserved[]= date("Y-n-j", $before);
                    }
                    
                }else{
                    $before = strtotime($row['wr_4']);
                    $reserved[]= date("Y-n-j", $before);
                    
                }
                
                
            }
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$bo_table."/reserved' AND mta_db_id = '{$id}'";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                
                $before = strtotime($row['mta_key']);
                $reserved[] = date("Y-n-j", $before);

                
                
            }
            if ($reserved== "") {
                $reserved = array("gd");
            }
            
            
            
            // datepicker 시작날짜
            if ($_GET['reservation_date']!="") {


                $target_date = new DateTime($reservation_date);
                $pre_date = new DateTime();
                $start_cul = abs(floor(($pre_date->format('U') - $target_date->format('U')) / (60*60*24)));
                
                //datepicker 끝 날짜
                
                $start =  strtotime($reservation_date); 
                $end = strtotime("+7 day", $start);        
                $count_day = 0;

                while ($start <= $end){        
                     $date_count = date("Y-m-d",$start);
                     $start = strtotime("+1 day",$start);

                     $sql = "SELECT wr_id, wr_4 FROM $write_table WHERE wr_3 = '{$id}' AND wr_4 LIKE '%{$date_count}%'";

                     
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
            }
            
            
            ?>

            <th>숙박 기간</th>

            <td>
                <div style="padding-bottom: 12px;">
                <div class="rest_date">입실 날짜</div> <input type="text" class="frm_input required" name="start_value" onchange="chang_start(this.value)" value="<?php if($wr_9){echo $wr_9;}else{echo $_GET['reservation_date'];} ?>" readonly id ="wr_4"></div>
                <div>
                <div class="rest_date">퇴실 날짜 </div><input type="text" class="frm_input required" name="end_value" onchange="getPriceJs(this.value)" value = "<?php if($wr_10){echo $wr_10;}else{echo $_GET['end_date'];}?>" readonly id = "wr_5">
                </div>
            </td>
        </tr>
        <!-- <tr>
            <th scope="row">입실시간 / <br>퇴실시간</th>
            <td>
                <?php 
                if ($_GET['reservation_date']!="") {
                    echo "<span id = 'in_time'>".$_GET['reservation_date']."</span> ".$booking['wr_roomstdate'] . "시 / <br><span id = 'out_time'></span> " . $booking['wr_roomendate']."시";
                }else{
                    echo "<span id = 'in_time'></span> ".$booking['wr_roomstdate'] . "시 / <br><span id = 'out_time'></span> " . $booking['wr_roomendate']."시";
                }
                ?>
                    
                </td>
        </tr> -->
        <!-- <tr>
            <th scope="row">예약금액</th>
            <td> <input type="text" value="0원" readonly id="reserve_price" name="" class="frm_input required"></td>
        </tr> -->
        <?php if (!empty($booking['wr_roomsale'])): ?>
            <!-- <tr>
                <th scope="row">연박할인금액</th>
                <td><input type="text" value="0원" readonly id="sale_price" name="" class="frm_input required"></td>
            </tr> -->    
        <?php endif ?>
        <tr>
            <th scope="row">기준인원(<?php echo $booking['wr_min']?>명)<br>최대인원(<?php echo $booking['wr_max']?>명)</th>
            <td>
                <div class = "select_count">
                성인
                <?php
                if ($wr_add1) {
                    $is_add1 = $wr_add1;
                }else{
                    $is_add1 = $booking['wr_min'];
                }
                ?>
                <select onchange="getPriceJs(this.id)" id="old1" name="wr_old1" class="sel">
                    <?php for ($i=0; $i <= $booking['wr_max']; $i++) { ?>
                    <option <?php if ($is_add1 == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                    <?php }?>
                </select></div>
                <?php if ($board['bo_2_subj']!=""): ?>
                    
                
                <div class = "select_count">
                소인
                <select onchange="getPriceJs(this.id)" id="old2" name="wr_old2" class="sel" data-toggle="tooltip" title="<?=$board['bo_3_subj']?"{$board['bo_3_subj']}세 이상은 소인에 해당됩니다":""?>">
                    <?php for ($i=0; $i <= $booking['wr_max']; $i++) { ?>
                    <option <?php if ($_GET['wr_add2'] == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                    <?php }?>
                </select>
             
                </div>
                <div class = "select_count">
                유아
                <select onchange="getPriceJs(this.id)" id="old3" name="wr_old3" class="sel" data-toggle="tooltip" title="<?=$board['bo_3_subj']?"{$board['bo_3_subj']}세 미만은 유아에 해당됩니다.":""?>">
                    <?php for ($i=0; $i <= $booking['wr_max']; $i++) { ?>
                    <option <?php if ($_GET['wr_add3'] == $i) {echo "selected";}?> value="<?=$i?>"><?=$i?></option>
                    <?php }?>
                </select>
                <?php if ($board['bo_4_subj']!=""): ?>
                    <label style="font-size: 17px;width: 24px;background: black;border-radius: 26px;text-align: center;color: white;margin-left: 9px;" data-toggle="tooltip" title="<?=$board['bo_4_subj'].'개월 미만의 유아는 추가요금이 발생하지 않습니다.'?>">?</label>
                <?php endif ?>
                </div>

                <?php endif ?>

                <?php if ($board['bo_1_subj'] != ""): ?>
                <div class = "select_count">
                    애완동물
                    <select name="wr_animals2" id="wr_animals" class="sel" onchange="getPriceJs(this.id)"> 
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <?php endif ?>
            </td>
            
        </tr>
        <?php 
        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/".$board['bo_1']."' and mta_db_id  = '".$id."' AND mta_key LIKE '%wr_option_name%' ORDER BY mta_key asc";
        $result = sql_query($sql);
        $option_array = array();
        
        $j = 0;
        
        while ($row = sql_fetch_array($result)) {
            $option_array[$j]['op_name'] = $row['mta_value'];
            
            $j++;
        }
        $j = 0;
        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/".$board['bo_1']."' and mta_db_id  = '".$id."' AND mta_key LIKE '%wr_option_price%' ORDER BY mta_key asc";
        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)) {
            $option_array[$j]['op_price'] = $row['mta_value'];
            $option_array[$j]['op_key'] = $row['mta_key'];
            $j++;
        }
        if (!empty($option_array)) {?>
        <tr>
            <th scope="row"><label for="wr_options">옵션 선택<strong class="sound_only">필수</strong></label></th>
            <td>
                <table class="option_tbl">
                    
                    
                
                <?

                // print_r2($option_array);
                for ($i=0; $i < count($option_array); $i++) { ?>
                    <tr>
                        <td><?php echo $option_array[$i]['op_name']?></td>
                        <td style="width: 25% !important;"><?php echo number_format($option_array[$i]['op_price'])?>원</td>
                        <td><input type="text" class="frm_input required" id="amount<?=$i?>" onkeyup="getPriceJs()" name="<?php echo $option_array[$i]['op_key']?>" value="<?php if($write[$option_array[$i]['op_key']]){echo $write[$option_array[$i]['op_key']];}else{echo '0';}?>" style="width: 50px;height: 28px;" >개</td>
                    </tr>
                    <!-- <div class="option_class" style="height: 33px;">
                        <div style="width: 33%; float: left;">
                            <?php echo $option_array[$i]['op_name']?>
                        </div>
                        <div style="width: 33%;float: left;">
                            <?php echo number_format($option_array[$i]['op_price'])?>원
                        </div>
                        <div style="width: 33%;float: left;">
                            <input type="text" class="frm_input required" id="amount<?=$i?>" onkeyup="getPriceJs()" name="<?php echo $option_array[$i]['op_key']?>" value="<?php if($write[$option_array[$i]['op_key']]){echo $write[$option_array[$i]['op_key']];}else{echo '0';}?>" style="width: 50px;height: 28px;" >개
                        </div>

                    </div> -->
                <?php }?>

                </table>
            </td>

        </tr>
        <?}?>
        <?php if ($board['bo_6_subj']) {?>
        <tr>
            <th scope="row"><label for="wr_pickup">픽업여부 <input type="checkbox" name="wr_pickup" value="1" id="wr_pickup"></label></th>
            <td>
                <div id="pickup_content">
                    <!-- <div style="clear: both;">
                        <div class="pick1">픽업 요금</div>
                        <div class="pick2">
                            <?if ($board['bo_6_subj'] == 0) {echo "무료";}else{echo number_format($board['bo_6_subj'])."원";}?>
                        </div>
                    </div>
                    <div style="clear: both;">
                        <div class="pick1">픽업 최대인원</div>
                        <div class="pick2"><?=$board['bo_7_subj']?>명</div>
                    </div>
                    <div style="clear: both;">
                        <div class="pick1">픽업 장소</div>
                        <div class="pick2"><?=$board['bo_8_subj']?></div>
                    </div>
                    <div style="clear: both;">
                        <div class="pick1">픽업 시간</div>
                        <div class="pick2"><?=$board['bo_9_subj']?></div>
                    </div> -->
                    픽업 요청시 체크박스를 클릭해주세요.
                    
                </div>
                
            </td>
        </tr>
        <?php }?>
        <tr>
            <td colspan="2">
                <?php
                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$bo_table."/date/config'";
                $result = sql_query($sql);
                $i=0;
                while ($row = sql_fetch_array($result)){
                    $date_config[$i]['date_name'] = $row['mta_db_id'];
                    $date_config[$i]['start_date'] = $row['mta_key'];
                    $date_config[$i]['end_date'] = $row['mta_value'];
                    $i++;
                }
                ?>
                <div class="aa">
                    <div class="selected_info">선택객실정보
                        <span class="reserve_date">
                        <?php  
                        if ($_GET['reservation_date']) {
                           echo date("Y년 m월 d일",strtotime($_GET['reservation_date']))." ".$daycul;
                        }
                        ?><span>
                    </div>
                    <div class="tb_div">
                        <table class="room_data">
                            <tr>
                                <th>객실명</th>
                                <td><?php echo $booking['wr_subject']?></td>
                            </tr>
                            <tr>
                                <th>입실시간<br>퇴실시간</th>
                                <td>
                                    <?php 
                                    if ($_GET['reservation_date']!="") {
                                        echo "<span id = 'in_time'>".$_GET['reservation_date']."</span> ".$booking['wr_roomstdate'] . "  <br><span id = 'out_time'></span> " . $booking['wr_roomendate'];
                                    }else{
                                        echo "<span id = 'in_time'></span> ".$booking['wr_roomstdate'] . "  <br><span id = 'out_time'></span> " . $booking['wr_roomendate'];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                <?php
                                for ($i=0; $i < count($date_config); $i++) { 
                                    $season_nna = preg_replace("/_/", " ", $date_config[$i]['date_name']);
                                   echo $season_nna."<br>";
                                }
                                ?>
                                </th>
                                <td>
                                    <?php
                                    for ($i=0; $i < count($date_config); $i++) { 
                                        echo $date_config[$i]['start_date']." ~ ".$date_config[$i]['end_date']."<br>";
                                    }
                                    ?>
                                 
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
                
                <!-- <div class="padding_table">
                    sdfsdf
                </div> -->
                <div class="bb">
                    <!-- <div class="price_info">선택객실금액정보</div> -->
                    <div class="tb_price_div">
                        <table class="tb_price">
                            <tr>
                                <td style="width: 40%;">객실 금액</td>
                                <td style="width: 20%;">-</td>
                                <td style="width: 40%;"><span id="room_price">+0원</span></td>
                            </tr>
                            <tr>
                                <td>연박 할인</td>
                                <td>-</td>
                                <td><span id="room_sale_price">-0원</span></td>
                            </tr>
                            <tr>
                                <td>추가 인원</td>
                                <td>-</td>
                                <td><span id="county_price">+0원</span></td>
                            </tr>
                            <?php if ($board['bo_1_subj'] != ""): ?>
                            <tr>
                                <td>애완동물 추가가격</td>
                                <td>-</td>
                                <td><span id="animals_price">+0원</span></td>
                            </tr>
                            <?php endif ?>
                            <tr>
                                <td>옵션 금액</td>
                                <td>-</td>
                                <td><span id="op_price">+0원</span></td>
                            </tr>
                            
                            <tr style="border-top: 1px solid #ddd !important;">
                                <td style="border-top: 1px solid #ddd;">총 결제금액</td>
                                <td style="border-top: 1px solid #ddd;">-</td>
                                <td style="border-top: 1px solid #ddd;"><span id="sum_price"><?php if($wr_8){echo $wr_8;}else{echo '0원';}?></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
        


        <?php if ($is_guest) { //자동등록방지 ?>
        <tr>
            <th scope="row">자동등록방지</th>
            <td>
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>

        </tbody>
        </table>

    </div>

    <div class="btn_confirm">
        <input type="submit" value="예약하기" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="./board.php?bo_table=<?php echo $board['bo_1'] ?>" class="btn_cancel">취소</a>
    </div>
    </form>
</section>

<script>
    $(function(){
        var is_search = "<?=$wr_add1?>";
        if (is_search) {
            getPriceJs();    
        }
        
    });
    $("#check_all").click(function(){
        var chk = $(this).is(":checked");//.attr('checked');

        if(chk){
            $(".check_agree").prop('checked', true);  
        }else{
            $(".check_agree").prop('checked', false);    
        }  
    });

    $("#agree1").click(function(){
        if ($("#agree1").text()=="내용보기") {
            
            $("#agree1").text("내용숨기기");
            $("#scr1").show(500);
        }else{
            $("#agree1").text("내용보기");
            $("#scr1").hide(500);
        }
        
    });
    $("#agree2").click(function(){
        if ($("#agree2").text()=="내용보기") {
            
            $("#agree2").text("내용숨기기");
            $("#scr2").show(500);
        }else{
            $("#agree2").text("내용보기");
            $("#scr2").hide(500);
        }
        
    });
    $("#agree3").click(function(){
        if ($("#agree3").text()=="내용보기") {
            
            $("#agree3").text("내용숨기기");
            $("#scr3").show(500);
        }else{
            $("#agree3").text("내용보기");
            $("#scr3").hide(500);
        }
        
    });
$(document).ready(function(){
    
    
    var is_set = $("#wr_4").val();
    if (is_set!= "") {
        $("#wr_5").datepicker({ 
                    changeMonth: true, 
                    changeYear: true, 
                    dateFormat: "yy-mm-dd", 
                    yearRange: "c-99:c+99", 
                    prevText: '이전 달',
                    nextText: '다음 달',
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                    yearSuffix: '년',
                    minDate: "+<?=$start_cul+1?>d", 
                    maxDate: "+<?=$start_cul+$count_day?>d", 
                    buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
                    buttonImageOnly: true, showOn: 'both'
                    });
    }
    $('[data-toggle="tooltip"]').tooltip();

    $('#wr_pickup').change(function(){
        if ($("#wr_pickup").is(":checked")) {
            // document.getElementById("pickup_content").innerHTML = '<div style="clear: both;"><div style="width: 150px;float: left;height:30px;">픽업 요금</div><div style="width: 250px;float: left;"><?if ($board['bo_6_subj'] == 0) {echo "무료";}else{echo number_format($board['bo_6_subj'])."원";}?></div></div><div style="clear: both;"><div style="width: 150px;float: left;height:30px;">픽업 최대인원</div><div style="width: 250px;float: left;"><?=$board['bo_7_subj']?>명</div></div><div style="clear: both;"><div style="width: 150px;float: left;height:30px;">픽업 장소</div><div style="width: 250px;float: left;"><?=$board['bo_8_subj']?></div></div><div style="clear: both;"><div style="width: 150px;float: left;height:30px;">픽업 시간</div><div style="width: 250px;float: left;"><?=$board['bo_9_subj']?></div></div>';
            document.getElementById("pickup_content").innerHTML = '<?=$board['bo_6_subj']?>';
        }else{
            document.getElementById("pickup_content").innerHTML = "픽업요청시 체크박스를 클릭해주세요.";
        }
    });

    
});
function chang_start($start_date){

    var day = ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'];
    
    $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_reservation.php?ver=20201008",
                type: "POST",
                data: {
                    "status" : "chang_start",
                    "bo_table" : '<?=$bo_table?>',
                    "start_date" : $start_date,
                    "id" : "<?=$_GET['id']?>"
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    var d = new Date($start_date);
                    var date = d.getFullYear()+"년 "+new String(d.getMonth()+1)+"월 " + d.getDate()+"일 "+day[d.getDay()];
                    
                    $min = "+"+data.start_cul+"d;";
                    $max = "+"+data.count_day+"d;";
                    // hi2 = data.count_day;
                    
                    console.log(data);
                    //datepicker 초기화
                    $("#wr_5").datepicker("destroy");
                    $("#wr_5").val("");
                    $("#wr_5").datepicker({ 
                        changeMonth: true, 
                        changeYear: true, 
                        dateFormat: "yy-mm-dd", 
                        yearRange: "c-99:c+99", 
                        prevText: '이전 달',
                        nextText: '다음 달',
                        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                        yearSuffix: '년',
                        // minDate: "+<?=$start_cul?>d;", 
                        // maxDate: "+<?=$start_cul+$count_day-1?>d;", 
                        minDate: $min,
                        maxDate: $max, 

                        buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
                        buttonImageOnly: true, showOn: 'both'
                    });
                    $('#animal_price').val("0원");
                    $('#count_price').val("0원");
                    $('#reserve_price').val("0원");
                    $('#sale_price').val("0원");
                    $('#total_price').val("0원");
                    $(".reserve_date").text(date);
 
                    $('#county_price').text("+0원");
                    $('#room_price').text("+0원");
                    $('#room_sale_price').text("-0원");
                    // $('#op_price').text("+0원");
                    $('#sum_price').text("0원");
                    document.getElementById("in_time").innerHTML = $start_date;
                    document.getElementById("out_time").innerHTML = "";
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        } );
}

    // 기간수정
function getPriceJs(id) {
    
    var opName = new Array();
    var opValue = new Array();
    var old1 = $('#old1').val();
    var old2 = $('#old2').val();
    var old3 = $('#old3').val();
    var animals = $('#wr_animals').val();
    var to = old1*1 + old2*1 + old3*1;
    if (to > <?=$booking['wr_max']?>) {
        alert("예약가능한 최대인원을 초과했습니다.");
        
        $("#"+id).val("0").attr("selected", "selected");

        return false;
    }
    // if (old1 + old2 + old3 ==<?=$booking['wr_max']?>) {
    //     alert("넘음");
    // }
     for (var i = 0; i < <?=count($option_array)?>; i++) {
        
        opName[i] = $('#amount'+i).attr('name');
        opValue[i] = $('#amount'+i).val();
        
     }
    // console.log(value);
    var $start_date = $('#wr_4').val();
    var $end_date = $('#wr_5').val();

    
    if ( $end_date == '' ) {
        alert( '날짜를 입력하세요' );
        $( '#date_name_'+end ).focus();
        return false;
    } else {
        
        $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_reservation.php?ver=20201008",
                type: "POST",
                data: {
                    "status" : "get_price",
                    "bo_table" : '<?=$bo_table?>',
                    "bor_table" : '<?=$board['bo_1']?>',
                    "sale" : '<?php echo $booking['wr_roomsale']?>',
                    "start_date" : $start_date,
                    "end_date" : $end_date,
                    "old1" : $('#old1').val(),
                    "old2" : $('#old2').val(),
                    "old3" : $('#old3').val(),
                    "bo_1_subj" : '<?=$board["bo_1_subj"]?>',
                    "animals" : animals,
                    "bo_5_subj" : '<?=$board["bo_5_subj"]?>',
                    "op_name" : opName,
                    "op_value" : opValue,
                    "bo_7_subj" : "<?=$board['bo_7_subj']?>",
                    "bo_8_subj" : "<?=$board['bo_8_subj']?>",
                    
                    "id" : "<?=$_GET['id']?>"
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    console.log(data);
                    $('#animal_price').val(data.animals+"원");
                    $('#count_price').val(data.count+"원");
                    $('#reserve_price').val(data.reserve+"원");
                    $('#option_price').val(data.option+"원");
                    $('#sale_price').val("-"+data.sale+"원");
                    $('#total_price').val(data.total+"원");

                    $('#animals_price').text("+"+data.animals+"원");
                    $('#county_price').text("+"+data.count+"원");
                    $('#room_price').text("+"+data.reserve+"원");
                    $('#room_sale_price').text("-"+data.sale+"원");
                    $('#op_price').text("+"+data.option+"원");
                    $('#sum_price').text(data.total+"원");

                    document.getElementById("out_time").innerHTML = data.out_time;
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        } );
    }
}
    

    $(document).ready(function(){
    /* 제이쿼리 충돌 수정 - 시작 */
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    });
    /* 제이쿼리 충돌 수정 - 종료 */
    
    var disabledDays = <?php echo json_encode($reserved)?>;
    
    function disableAllTheseDays(date) {
        var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
        for (i = 0; i < disabledDays.length; i++) {
            if($.inArray(y + '-' +(m+1) + '-' + d,disabledDays) != -1) {
                return [false];
            }
        }
        return [true];
    }

    /* 출발 시간 날짜 선택 - 시작 */
    
    var J_today = new Date();
    var J_year = J_today.getFullYear();
    var J_month = J_today.getMonth();
    var J_date = J_today.getDate();
    var J_time = J_today.getTime();

    console.dir(J_today);
    console.dir(J_year);
    console.dir(J_month);
    console.dir(J_date);
    console.dir(J_time);
    
    <?php

    $today = strtotime(date("Y-n-j"));
    $matchTime = strtotime("+".$board['bo_max_date']." month",$today);
    $matchDate = date("Y-n-t",$matchTime);

    ?>

    function macthDate(){
        var today = new Date();  
        var dateString = "<?=$matchDate?>";  
        var dateArray = dateString.split("-");  
        var dateObj = new Date(dateArray[0], Number(dateArray[1])-1, dateArray[2]);  
        var betweenDay = Math.abs(Math.ceil((today.getTime() - dateObj.getTime())/1000/60/60/24))+1;  
        return betweenDay;
    }

    var $setWr4Date = macthDate();
    


    $('#wr_4').datepicker({
            showOn: 'both',
            buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            yearRange: 'c-99:c+99',
            constrainInput: true,
            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            maxDate: '+'+$setWr4Date+'d',
            minDate: "+d;",
            beforeShowDay: disableAllTheseDays   
      });
    
    /* 출발 시간 날짜 선택 - 종료 */

});
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{

    <?php// echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php?ver=20201008",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    // if (document.getElementById("char_count")) {
    //     if (char_min > 0 || char_max > 0) {
    //         var cnt = parseInt(check_byte("wr_content", "char_count"));
    //         if (char_min > 0 && char_min > cnt) {
    //             alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
    //             return false;
    //         }
    //         else if (char_max > 0 && char_max < cnt) {
    //             alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
    //             return false;
    //         }
    //     }
    // }
    
    if (!f.chk_agree1.checked || !f.chk_agree2.checked || !f.chk_agree3.checked){
        alert("개인정보 사항에 체크하셔야 합니다.");
        f.chk_agree1.focus();
        return false;
    }
    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
