<?php

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

include_once($board_skin_path.'/holiday_lib.php');
include_once($board_skin_path.'/calendar_function.php');


if ($member['mb_level']< 8) {
    alert("권한이 없습니다.");
}

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
    $res_date[$i]['wr_id'] = $row['wr_id'];
    
    $i++;
}

$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/reserved'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $res_date[$i]['name'] = $row['mta_value'];
    $res_date[$i]['date'] = $row['mta_key'];
    $res_date[$i]['id'] = $row['mta_db_id'];
    $res_date[$i]['status'] = $row['mta_value'];
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


$daily = array('주중','주중','주중','주중','주중','주말','주말');

$is_sat = "";
if ($board['bo_7_subj'] == 1) $is_sat = "2";

$daily2 = array('weekday','weekday','weekday','weekday','weekday','weekend','weekend'.$is_sat);

// print_r2($total_list);

?>



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
        <!-- <td colspan="3">

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

         
        </td> -->
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

            
            
            // 12. 오늘 날자면 굵은 글씨
            if(strtotime($set_date_time) >= strtotime(date("Y-n-j"))){


                    for ($k=0; $k<count($total_list); $k++) {

                        echo "<div class='cul'>";
                        $reserve = 0;
                        for ($z=0; $z < count($res_date); $z++) { 

                            if (strpos($res_date[$z]['date'], $set_date_time) !== false && $res_date[$z]['id']==$total_list[$k]['wr_id']) {

                                $reserve = 1;
                                

                                    if ($member['mb_level'] >= 8) {

                                    ?>
                                    <input type="checkbox" name="checkbox[]" class="<?php echo $res_date[$z]['status']?>" value="<?php echo $res_date[$z]['wr_id'];?>" id="<?php echo $set_date_time?>;<?php echo $total_list[$k]['wr_id']?>">
                                    <?php
                                    
                                    }
                                    
                                    echo $status[$res_date[$z]['status']]."&nbsp;&nbsp;";
                                    echo getReserveName($res_date[$z]['name'],$total_list[$k]['wr_subject'], $res_date[$z]['is_admin']);
                                    // echo $res_date[$z]['is_admin'];
                                    echo "</div>";

                                
                                
                                break;
                                
                            }
                            
                        }

                        if ($reserve == 0) {
                            
                            ?>


                                <?php if ($member['mb_level'] >= 8): ?>
                                    <input type="checkbox" name="checkbox[]" class="예약가능" value="<?php echo 'null'.$i.$j.$k?>" id="<?php echo $set_date_time?>;<?php echo $total_list[$k]['wr_id']?>" >    
                                <?php endif ?>
                                
                               
                                <?php 
                                
                                if (!$board['bo_3']) {
                                    echo $status['예약가능']."&nbsp;&nbsp;".$total_list[$k]['wr_subject']."</div>";
                                }else{
                                    echo $status['예약가능']."&nbsp;&nbsp;";    
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
    <ul class="btn_bo_adm">
        <li><input type="button" onclick="status_reg()" value="예약 대기"></li>
        <li><input type="button" onclick="status_change()" value="예약 완료"></li>
        <li><input type="button" onclick="deleteReserve()" value="예약 취소"></li>
        <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>" class="b02sub">돌아가기</a></li>
    </ul>

</div>
<?php endif ?>


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

    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+year+"&toMonth="+month+"&route=reserve_set";
}
function next_month(){
    var year = <?php echo $next1?>;
    var month = <?php echo $next2?>;

    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+year+"&toMonth="+month+"&route=reserve_set";
}

function changDate(month){
    
    var toYear = $('#toYear').val();
    var toMonth = $('#toMonth').val();


    location.href="<?=$_SERVER['PHP_SELF']."?bo_table=".$bo_table?>&toYear="+toYear+"&toMonth="+toMonth;
}
/////////////////////////상태 변경 및 취소 //////////////////////
function status_change(){
    
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
        if (check_can[i]=="예약완료") {
            alert("이미 완료된 객실입니다.");
            return false;
        }
    }
    
    $.ajax( {
        url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
        type: "POST",
        data: {
            "bo_1" : "<?php echo $board['bo_1'];?>",
            "status" : "update",
            "bo_table" : "<?php echo $bo_table?>",
            "array_date" : date_id,
            "array_id" : checked
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            alert("예약 수정이 완료되었습니다.");
            console.log(data);
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
function deleteReserve(){
        
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
            alert("예약이 취소되었습니다.");
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