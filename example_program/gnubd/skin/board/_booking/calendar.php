<?php

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

include_once($board_skin_path.'/holiday_lib.php');
include_once($board_skin_path.'/calendar_function.php');




$set_mta_db_table = 'board/'.$bo_table;
?>
<!-- 달력 출력 start -->

<?

    $calenar2 = new Calendar();
   
    if ($_GET['toYear'] && $_GET['toMonth']) {
        $aaa = $_GET['toYear']."-".$_GET['toMonth'];
        //공휴일 데이터 가져오기
        $set_time1 = date_create("$aaa");
        $set_time = date_format($set_time1,"Y-m");
        $mktime  = strtotime($set_time); 
        $last_day = date("t", $mktime);
        $is_selected = 1;
    }else{
        $time2 = date('Y')."-". date('n');
        $set_time = date("Y-m");
        $aaa = $set_time;
        $last_day = date("t", time());
    }

    $calendar_list = $calenar2->getHolidayList($aaa);

    // 2. 시작요일 구하기
    $start_week = date("w", strtotime(date($set_time)."-01"));

    // 3. 총 몇 주인지 구하기
    $total_week = ceil(($last_day + $start_week) / 7);

    // 4. 마지막 요일 구하기
    $last_week = date('w', strtotime(date($set_time)."-".$last_day));
    ?>


<?php
$qu = "select * from g5_write_{$board['bo_1']}";

$result1 = sql_query($qu);
$i = 0;
while ($row=sql_fetch_array($result1)) {
    
    $res_date[$i]['name'] = $row['wr_2'];
    $res_date[$i]['date'] = $row['wr_4'];
    $res_date[$i]['id'] = $row['wr_3'];
    $res_date[$i]['status'] = $row['wr_6'];
    $res_date[$i]['status_isManual'] = false;
    $res_date[$i]['wr_id'] = $row['wr_id'];
    
    $i++;
}

$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/reserved'";

$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $res_date[$i]['name'] = strpos($row['mta_value'], "|:|") !== false ? explode("|:|", $row['mta_value'], 2)[1] : $row['mta_value'];
    $res_date[$i]['date'] = $row['mta_key'];
    $res_date[$i]['id'] = $row['mta_db_id'];
    $res_date[$i]['status'] = strpos($row['mta_value'], "|:|") !== false ? explode("|:|", $row['mta_value'], 2)[0] : $row['mta_value'];
    $res_date[$i]['status_isManual'] = true;
    $res_date[$i]['wr_id'] = "un_".$row['mta_idx'];
    $res_date[$i]['is_admin'] = '1';
    $i++;
}



$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/date/config'";

$result = sql_query($sql);
$i = 0;
while ($row = sql_fetch_array($result)) {
    $season[$i]['name'] = $row['mta_db_id'];
    $season[$i]['start'] = strtotime($row['mta_key']);
    $season[$i]['end'] = strtotime($row['mta_value']);

    $i++;
}



$status['예약가능'] = '<span style="background: #4CAF50; color: #fff; padding: 2px;">예</span>';
$status['예약대기'] = '<span style="background: #e8bb46; color: #fff; padding: 2px;">대</span>';
$status['예약완료'] = '<span style="background: #e80000; color: #fff; padding: 2px;">완</span>';
$status['취소요청'] = '<span style="background: #4c62de; color: #fff; padding: 2px;">취</span>';

$is_setting1 = "주말";
$is_setting2 = "weekend";

if ($board['bo_8_subj']) {
    $is_setting1 = "주중";
    $is_setting2 = "weekday";
}

$daily = array('주중','주중','주중','주중','주중',$is_setting1,'주말');

$is_sat = "";
if ($board['bo_7_subj'] == 1) $is_sat = "2";

$daily2 = array('weekday','weekday','weekday','weekday','weekday',$is_setting2,'weekend'.$is_sat);

// print_r2($total_list);

?>


<h2 class="reservAccountTitle1" style="text-align:center;">
    <span class="highlight"><i class="fab fa-envira"></i></span> 
    <span class="highlight1">객실 예약</span> 
</h2>
<br />
<br />  
<div style="width: 100%;height: auto; border-collapse: collapse; display: block; overflow: auto;">
<table width='100%' cellpadding='0' cellspacing='1' bgcolor="#999999" class="calendar" >
  <tr>
    <td height="50" align="center" bgcolor="#FFFFFF" colspan="7">
        <h2 style="margin-bottom: 42px;">
            <?php if ($_GET['toYear']) {
                $aaa = strtotime($aaa);
                // $next = ;
                $next1 = date('Y', strtotime("+1 month",$aaa));
                $next2 = date('m', strtotime("+1 month",$aaa));
                // echo $next;
                $prev1 = date('Y', strtotime("-1 month",$aaa));
                $prev2 = date('m', strtotime("-1 month",$aaa));
                // echo ;
                echo "<b><a style='cursor: pointer;' onclick='prev_month()'><</a> &nbsp; ".date("Y년 n월",$aaa)." &nbsp; <a style='cursor: pointer;' onclick='next_month()'>></a></b>";
            }else{
                $aaa = strtotime(date("Y-m-d"));
                $next1 = date('Y', strtotime("+1 month",$aaa));
                $next2 = date('m', strtotime("+1 month",$aaa));
                // echo $next;
                $prev1 = date('Y', strtotime("-1 month",$aaa));
                $prev2 = date('m', strtotime("-1 month",$aaa));
                echo "<b><a style='cursor: pointer;' onclick='prev_month()'><</a> &nbsp; ".date("Y년 n월")." &nbsp; <a style='cursor: pointer;' onclick='next_month()'>></a></b>";
            }?>
                
        </h2>
    </td>
    <tr>
        <td colspan="4" style="font-size: 12px;">
        <?php
        echo $status['예약가능']." : 예약가능&nbsp;&nbsp;";
        echo $status['예약대기']." : 입금대기&nbsp;&nbsp;";
        echo $status['예약완료']." : 예약완료&nbsp;&nbsp";
        echo $status['취소요청']." : 취소요청";
        ?>                

        </td>
        <td colspan="3">

        <? if($member['mb_level'] > 7){ ?>
            <div class="admin_cel">
                <label for="inputDate">달력이동</label>
                <input type="text" name="inputDate" style="width:100px;" value="<?=date("Y-m",$aaa)?>" id="inputDate"> 
                <script>
                    $(document).ready(function(){
                        var datepicker_default = {
                            closeText : "닫기",
                            prevText : "이전달",
                            nextText : "다음달",
                            currentText : "오늘",
                            changeMonth: true,
                            changeYear: true,
                            monthNames : [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
                            monthNamesShort : [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
                            dayNames : [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
                            dayNamesShort : [ "일", "월", "화", "수", "목", "금", "토" ],
                            dayNamesMin : [ "일", "월", "화", "수", "목", "금", "토" ],
                            weekHeader : "주",
                            firstDay : 0,
                            isRTL : false,
                            showMonthAfterYear : true,
                            yearSuffix : '',
                            showOn: 'both',
                            buttonImage:'/resources/image/calendar.png',
                            buttonImageOnly: true,
                            
                            showButtonPanel: true,
                            yearRange: "c-99:c+99", 
                            buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
                            buttonImageOnly: true, showOn: 'both'
                        }
                
                        datepicker_default.closeText = "선택";
                        datepicker_default.dateFormat = "yy-mm";
                        datepicker_default.onClose = function (dateText, inst) {
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker( "option", "defaultDate", new Date(year, month, 1) );
                            $(this).datepicker('setDate', new Date(year, month, 1));
                            var selectDate = $("#inputDate").val().split("-");
                            location.href = '<?="./board.php?bo_table={$bo_table}&toYear="?>'+selectDate[0]+"&toMonth="+selectDate[1]+'&price_tab=0';
                        }
                    
                        datepicker_default.beforeShow = function () {
                            var selectDate = $("#inputDate").val().split("-");
                            var year = Number(selectDate[0]);
                            var month = Number(selectDate[1]) - 1;
                            $(this).datepicker( "option", "defaultDate", new Date(year, month, 1) );
                        }
    
                        $("#inputDate").datepicker(datepicker_default);
                    
                    });
                </script>
            </div>
        <? } ?>


            <?php 
            
            if ($_GET['toYear']) {
                if ($_GET['price_tab']) {?>
                    <a href="./board.php?bo_table=<?php echo $bo_table?>&toYear=<?=$_GET['toYear']?>&toMonth=<?=$_GET['toMonth']?>&price_tab=0" class="b02sub" style="width: 110px;float: right;">객실 예약 보기</a>
                <?php }else{?>
                    <a href="./board.php?bo_table=<?php echo $bo_table?>&toYear=<?=$_GET['toYear']?>&toMonth=<?=$_GET['toMonth']?>&price_tab=1" class="b02sub" style="width: 124px;float: right;">객실별 요금 보기</a>
                <?php }?>
   
            <?php }else{

                if ($price_tab) {?>
                    <a href="./board.php?bo_table=<?php echo $bo_table?>&toYear=<?=$_GET['toYear']?>&toMonth=<?=$_GET['toMonth']?>&price_tab=0" class="b02sub" style="width: 110px;float: right;">객실 예약 보기</a>
                <?php }else{?>
                    <a href="./board.php?bo_table=<?php echo $bo_table?>&toYear=<?=$_GET['toYear']?>&toMonth=<?=$_GET['toMonth']?>&price_tab=1" class="b02sub" style="width: 124px;float: right;">객실별 요금 보기</a>
                <?php }?>
            
        <?php }?>           

             
        <!-- <select onchange="changDate(this.value)" id="toMonth" class="sel" style="margin-right: 3px;">
            <?php for ($i=1; $i <= 12; $i++) { ?>
                <option <?php if($toMonth==$i){echo "selected";}?> <?php if(!$toMonth && $i == date("n")){echo "selected";}?> value="<?=$i?>"><?=$i?>월</option>
            <?php }?>
            
            <?php echo date("n") ?>
        </select>
        <select onchange="changDate(this.value)" id="toYear" class="sel" style="margin-right: 3px;">

            <option <?php if($toYear=="2018"){echo "selected";}?> value="2018">2018년</option>
            <option <?php if($toYear=="2019"){echo "selected";}?> value="2019">2019년</option>
            
        </select> -->
        </td>
    </tr>
    </td>

  </tr>
  <tr>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar"><font color="red">일</font></td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar">월</td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar">화</td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar">수</td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar">목</td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar">금</td>
    <td width="12%" align="center" style="border-top: 1px solid #ddd;font-size: 14px;" class="calendar"><font color="blue">토</font></td>
  </tr>
        
  <?
  
    // 5. 화면에 표시할 화면의 초기값을 1로 설정
    $day=1;
    $chk_day=1;
    
    // 6. 총 주 수에 맞춰서 세로줄 만들기
    for($i=1; $i <= $total_week; $i++){

        for ($k=0; $k < 7; $k++) { 
            
            // 14. 날자 증가
            
            if (!(($i == 1 && $k < $start_week) || ($i == $total_week && $k > $last_week))){

                if($k == 0){
                    // 9. $j가 0이면 일요일이므로 빨간색
                    echo '<td  class="calendar2"><div style="text-align:center;"><span style="float:left;color:red;">'.$day.'</span>';
                    
                }else if($k == 6){
                    // 10. $j가 0이면 일요일이므로 파란색
                    echo '<td  class="calendar2"><div style="text-align:center;"><span style="float:left;color:blue;">'.$day.'</span>';
                    

                }else{
                    // 11. 그외는 평일이므로 검정색
                    echo '<td  class="calendar2"><div style="text-align:center;"><span style="float:left;">'.$day.'</span>';
                    
                }
               
                $mk_day = sprintf('%02d',$day);
                $is_same = $set_time."-".$mk_day;
                if ($calendar_list) {
                    $key_exist = array_key_exists($is_same,$calendar_list);
                    if ($key_exist) {
                        echo "<span class='holiday'>".$calendar_list[$is_same]->name."</span></div>";
                    }
                }
                echo "</td>";
                $day++;
            }else{
                echo '<td align="center" class="calendar2"></td>';
            }

    }
        ?>


  <tr>

    <?
        // 7. 총 가로칸 만들기
        for ($j=0; $j<7; $j++){
            if ($j==0) {
                echo '<td  class="calendar" style="max-width:150px;">';
            }elseif ($j==6) {
                echo '<td  class="calendar" style="max-width:150px;">';
            }else{
                echo '<td  class="calendar" style="max-width:150px">';
            }
    ?>

    
        
      <?
        
        $bbb = $set_time."-".$chk_day;
        
        $set_date_time = date('Y-m-d',strtotime($bbb));

        // $set_time2 = DateTime::createFromFormat('Y-m-d', $bbb);
        // $set_date_time = $set_time2->format('Y-m-d');



        
        // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
        //    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){

            
            //add. bo_max_date를 가져와서 해당일 보다 크면 막아버린다.

            $today = strtotime(date("Y-n-j"));
            $matchTime = strtotime("+".$board['bo_max_date']." month",$today);
            $matchDate = date("Y-n-t",$matchTime);
            
            if($board['bo_max_date'] == ''){
                $limitDate = true;
            }
            else {
                if(strtotime($set_date_time) <= strtotime($matchDate) )
                    $limitDate = true;
                else
                    $limitDate = false;
            }

            
            // 12. 오늘 날자면 굵은 글씨
            if(strtotime($set_date_time) >= $today && $limitDate ){
                $cul_day = strtotime($bbb);
                $season_chk = 0;
                
                for ($a=0; $a < count($season); $a++) { 
                    
                    if ($season[$a]['start'] <= $cul_day && $season[$a]['end'] >= $cul_day) {
                        $se_name = preg_replace("/_/", " ", $season[$a]['name']);
                        $get_season = "<div class='season'>".$se_name."-";   
                         $season_chk = 1;

                    }


                    if ($a == count($season)-1 && $season_chk != 1) {
                        $get_season = "<div class='season_null'>비수기-";
                    } 
                    
                }
                
                //==========설정한 시즌이 없다면 비수기 출력
                if (!$season) {
                    $get_season = "<div class='season_null'>비수기-";
                }

                

                // echo "<b>";
                $cul_day = strtotime($set_date_time);
                $season_chk = 0;
                
                for ($a=0; $a < count($season); $a++) { 
                    
                    

                    if ($season[$a]['start'] <= $cul_day && $season[$a]['end'] >= $cul_day) {
                        
                        $is_season = "wr_".$daily2[date('w',$cul_day)].$season[$a]['name'];   

                         $season_chk = 1;
                         $season_name = $season[$a]['name'];
                    }


                    if ($a == count($season)-1 && $season_chk != 1) {
                        $season_name = "비수기";
                        $is_season = "wr_".$daily2[date('w',$cul_day)]."비수기";
                    } 
       
                }

                $prev_holiday = date('Y-m-d',strtotime('+1 day',strtotime($set_date_time)));

                if ($calendar_list != "") {
                    $is_holi_weekend = array_key_exists($prev_holiday, $calendar_list);
                }
                
                //========셋팅한 시즌이 하나도 없다면 모두 비수기 가격 출력
                if (!$season) {

                    $is_season = "wr_".$daily2[date('w',$cul_day)]."비수기";
                }
                if ($board['bo_5_subj']=="") {
                    $is_holi_weekend = 0;
                }
                
                //========공휴일 가격 처리

                if ($is_holi_weekend) {
                    $get_season .= "주말</div>";
                    $value_2 = "weekend";
                    if($board['bo_7_subj']=="1"){
                        $value_2 = "weekend2";
                    }
                    $is_season = str_replace("weekday", $value_2, $is_season);
                }else{
                    $get_season .= $daily[date('w',$cul_day)]."</div>";

                }
                
                //시즌 출력
                echo $get_season;
                    for ($k=0; $k<count($total_list); $k++) {
                        echo "<div class='cul'>";
                        $reserve = 0;
                        for ($z=0; $z < count($res_date); $z++) { 

                            if (strpos($res_date[$z]['date'], $set_date_time) !== false && $res_date[$z]['id']==$total_list[$k]['wr_id']) {

                                $reserve = 1;
                                if ($_GET['price_tab']) {
                                    
                                    $sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$k]['wr_id']}'  AND  mta_db_table = '{$set_mta_db_table}'  AND mta_key = '{$is_season}' ORDER BY  mta_reg_dt DESC";
                                    $val = sql_fetch($sql);
                                    // 시즌 가격이 없다면 비수기 가격으로 바꿈
                                    if ($val['mta_value'] == "") {
                                        $is_season2 = str_replace($season_name, '비수기', $is_season);
                                        $sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$k]['wr_id']}'  AND  mta_db_table = '{$set_mta_db_table}'  AND mta_key = '{$is_season2}'";
                                        $val = sql_fetch($sql);
                                    }
                                    echo "<div class = 'reserved'>";
                                    echo "<div class = 're_subj'>".$total_list[$k]['wr_subject']."</div>";
                                    echo "<div class = 're_price'>".number_format($val['mta_value'])."원</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    
                                }else{
                                    if (($member['mb_level'] >= 8 && getReserveName($res_date[$z]['name'],$total_list[$k]['wr_subject'], $res_date[$z]['is_admin']) == "예약완료") || $res_date[$z]['status_isManual']) {
                                    ?>
                                    <input type="checkbox" name="checkbox[]" class="<?php echo $res_date[$z]['status']?>" value="<?php echo $res_date[$z]['wr_id'];?>" id="<?php echo $set_date_time?>;<?php echo $total_list[$k]['wr_id']?>">
                                    <?php
                                    }
                                    
                                    echo $status[$res_date[$z]['status']]."&nbsp;&nbsp;";
                                    if($member['mb_level'] <7 ){
                                        echo substr(getReserveName($res_date[$z]['name'],$total_list[$k]['wr_subject'], $res_date[$z]['is_admin']),0,-3)."*";
                                    }else
                                    echo getReserveName($res_date[$z]['name'],$total_list[$k]['wr_subject'], $res_date[$z]['is_admin']);
                                    echo "</div>";

                                }
                                
                                break;
                                
                            }
                            
                        }
                        if ($reserve == 0) {
                            if ($_GET['price_tab']) {
                                
                                $sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$k]['wr_id']}'  AND  mta_db_table = '{$set_mta_db_table}'  AND mta_key = '{$is_season}'  ORDER BY  mta_reg_dt DESC";
                                    // echo $sql;
                                $val = sql_fetch($sql);

                                if ($val['mta_value'] == "") {
                                    $is_season2 = str_replace($season_name, '비수기', $is_season);
                                    $sql = "SELECT mta_value FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$k]['wr_id']}'  AND  mta_db_table = '{$set_mta_db_table}'  AND mta_key = '{$is_season2}'";
                                
                                    $val = sql_fetch($sql);
                                }
                                echo "<div>";
                                ?>
                                <a href="<?php echo G5_URL;?>/bbs/board.php?bo_table=<?php echo $bo_table?>&wr_id=<?php echo $total_list[$k]['wr_id'];?>&reservation_date=<?php echo $set_date_time?>" >
                                <?php
                                
                                echo "<div class = 'subj'>".$total_list[$k]['wr_subject']."</div>";
                                
                                echo "<div class = 'price'>".number_format($val['mta_value'])."원</div>";
                                
                                echo "</div></a>";
                                echo "</div>";
                            }else{
                            ?>
                                <?php if ($member['mb_level'] >= 8): ?>
                                    <input type="checkbox" name="checkbox[]" class="예약가능" value="<?php echo 'null'.$i.$j.$k?>" id="<?php echo $set_date_time?>;<?php echo $total_list[$k]['wr_id']?>" >    
                                <?php endif ?>
                                <a href="<?php echo G5_URL;?>/bbs/board.php?bo_table=<?=$bo_table?>&wr_id=<?php echo $total_list[$k]['wr_id'];?>&reservation_date=<?php echo $set_date_time?>" >
                                <?php 
                                
                                if (!$board['bo_3']) {
                                    echo $status['예약가능']."&nbsp;&nbsp;".$total_list[$k]['wr_subject']."</a></div>";
                                }else{
                                    echo $status['예약가능']."&nbsp;&nbsp;";    
                                }

                            }
                        }
                        
                        if ($board['bo_3'] && $reserve == 0) {

                            if ($_GET['price_tab']) {
                                
                                // echo $reserve;
                            }else{
                                echo $total_list[$k]['wr_subject']."</div></a>";

                            }

                        }
                        
                        

                    }
                

            ////////////////////////오늘기준으로 지난날 출력
            }else{
                
                
                // echo "<div align='center'>예약종료</div>";
            }
            

            

            if($day == date("j")){
                // echo "</b>";
            }

            
            $chk_day++;
            
        }
       
        
        ?>
    </td>
    <?}?>
  </tr>
  <?}?>
</table> 
</div>
<?php if ($member['mb_level'] >=8): ?>
<div class="bo_fx" style=" float:  left; padding-top: 10px;">
    <?php
    /*
    <ul class="btn_bo_adm">
        <li><input type="button" onclick="status_reg()" value="예약 대기"></li>
        <li><input type="button" onclick="status_change()" value="예약 완료"></li>
        <li><input type="button" onclick="deleteReserve()" value="예약 취소"></li>
    </ul>
    */
    ?>
    <ul class="btn_bo_adm">
        <li>
            <label for="J_state_blind">예약막기</label>
            <input type="button" id="J_state_blind" onclick="status_change()" value="예약 완료" class="sound_only">
        </li>
        <li>
            <label for="J_state_blind_cl">예약막기해제</label>
            <input type="button" id="J_state_blind_cl" onclick="deleteReserve()" value="예약 취소" class="sound_only">
        </li>
        <li>
            <label for="J_state_blind_name">수기예약</label>
            <input type="button" id="J_state_blind_name" onclick="status_change('_name')" value="예약 완료" class="sound_only">
        </li>
        <li>
            <label for="J_state_blind_cl_name">수기예약취소</label>
            <input type="button" id="J_state_blind_cl_name" onclick="deleteReserve('_name')" value="예약 취소" class="sound_only">
        </li>
    </ul>
</div>
<?php endif ?>
<div style="width: 100%; height: 50px; padding-top: 10px;"> 
    <?php if ($member['mb_level'] >=8): ?>
    <a class="btn_admin" id="holidaybtn" style="cursor: pointer;float: right; ;margin-left: 5px;">휴일관리</a>
    <a class="btn_admin" id="goodsbtn" style="cursor: pointer;float: right; ;margin-left: 5px;">시즌관리</a>
    <a class="btn_admin" id="settingbtn" style="cursor: pointer;float: right; ;margin-left: 5px;">환경설정</a>
    <?php endif ?>
    <a class="b02sub" id = "hide_calendar" style="float: right;cursor: pointer;margin-left: 5px;">달력숨기기</a>
    <?php if ($member['mb_level'] < 8): ?>
        <a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&check=1" id = "checkg" class="b02sub" style="float: right;margin-left: 5px;">예약확인</a>    
    <?php endif ?>
    
    <?php if ($member['mb_level'] >=8): ?>
    <a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $board['bo_1']?>&check=1" id = "checkg" class="b02sub" style="float: right;">예약목록</a>
    <?php endif ?>

</div>

<?php include_once($board_skin_path."/modal.skin.php")?>

<!-- 달력출력 end -->

<script>
    
    
    
    // alert(a);
$("#hide_calendar").click(function(){
    if ($(".calendar").css("display") == "none") {
        document.getElementById("hide_calendar").innerHTML = "달력숨기기";
        $(".calendar").show();   
        $(".bo_fx").show();   
        

    }else{
        $(".calendar").hide();
        $(".bo_fx").hide(); 
        document.getElementById("hide_calendar").innerHTML = "달력보기";
    }
    
});
    // var chking = [];
    $("input[name='checkbox[]']").click(function (){   
        var chk_value = $(this).val();
        var is_check = $(this).prop('checked'); 
        
        if (is_check) {
                $("input[name ='checkbox[]']:input[value='"+chk_value+"']").prop("checked", true);   
                
                
            }else{
                $("input[name ='checkbox[]']:input[value='"+chk_value+"']").prop("checked", false); 
            }
    });








//////////////달력 기간 변경 /////////////////////////////
function prev_month(){
    var year = <?php echo $prev1?>;
    var month = <?php echo $prev2?>;

    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+year+"&toMonth="+month;
}
function next_month(){
    var year = <?php echo $next1?>;
    var month = <?php echo $next2?>;

    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+year+"&toMonth="+month;
}

function changDate(month){
    
    var toYear = $('#toYear').val();
    var toMonth = $('#toMonth').val();


    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+toYear+"&toMonth="+toMonth;
}
/////////////////////////상태 변경 및 취소 //////////////////////
function status_change(status){
    
    status = status ? status : null;

    var checked = []
    var date_id = []
    var check_can = []
    $("input[name='checkbox[]']:checked").each(function ()
    {
        checked.push($(this).val());
        date_id.push($(this).attr('id'));
        check_can.push($(this).attr('class'));
    });

    /*
    console.log(checked);
    console.log(date_id);
    console.log(check_can);
    return false;
    */
    
    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약완료") {
            alert("이미 완료된 객실입니다.");
            return false;
        }
    }
    var username = null;
    if(status){
        username = prompt("예약자 성함을 입력해주세요.");
        if(username.trim() == ""){
            alert("예약자 성함을 입력하세요.");
            return false;
        }
    }
    
    $.ajax( {
        url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
        type: "POST",
        data: {
            "bo_1" : "<?php echo $board['bo_1'];?>",
            "status" : "update" + (status ? status : ''),
            "bo_table" : "<?php echo $bo_table?>",
            "array_date" : date_id,
            "array_id" : checked,
            "username" : username
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            if(status) alert("예약처리 완료 되었습니다.");
            else alert("예약막기가 완료되었습니다.");
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
        }
    });
}
function status_reg(){
        
    var checked = []
    var date_id = []
    var check_can = []
    $("input[name='checkbox[]']:checked").each(function ()
    {
        
        checked.push($(this).val());
        date_id.push($(this).attr('id'));
        check_can.push($(this).attr('class'));
    });
    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약대기" || check_can[i]=="예약완료" || check_can[i]=="취소요청") {
            alert("예약가능한 객실만 선택해주세요.");
            return false;
        }
    }
    $.ajax( {
        url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
        type: "POST",
        data: {
            "bo_1" : "<?php echo $board['bo_1'];?>",
            "status" : "reg",
            "bo_table" : "<?php echo $bo_table?>",
            "array_date" : date_id,
            "array_id" : checked
        },
        // dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            alert("예약대기가 완료되었습니다.");
            console.log(data);
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
            
        }
    });
}
function deleteReserve(status){
        
    status = status ? status : null;

    var checked = []
    var check_can = []
    $("input[name='checkbox[]']:checked").each(function ()
    {
        checked.push($(this).val());
        check_can.push($(this).attr("class"));
    });
    if (checked=="") {
        alert("선택된 객실이 없습니다.");
        return false;
    }
    for (var i = check_can.length - 1; i >= 0; i--) {
        if (check_can[i]=="예약가능") {
            alert("예약된 객실만 선택해주세요.");
            return false;
        }
    }
    $.ajax( {
        url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
        type: "POST",
        data: {
            "bo_1" : "<?php echo $board['bo_1'];?>",
            "status" : "delete",
            "bo_table" : "<?php echo $bo_table?>",
            "array_id" : checked
        },
        // dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            if(status) alert("취소처리 완료 되었습니다.");
            else alert("예약막기 해제되었습니다.");
            console.log(data);
            location.reload();
        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
        }
    });
}
/////////////////////////상태 변경 및 취소 //////////////////////
</script>