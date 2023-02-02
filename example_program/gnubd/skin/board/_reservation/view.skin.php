<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once ($board_skin_path . "/ajax/ajax_reservation.php");
//include_once $board_skin_path . "/lib/thumbnail.lib.php";
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css?ver=20201008">', 0);
?>
<style type="text/css">
#bo_v_cons a {
    color: #f5f5f5;
}
.price_table th,td{
    text-align: center;
}
a.btn_b02s {
    display: inline-block;
    margin: 0 0 30px;
    padding: 8px 7px 7px;
    border: 1px solid #3b3c3f;
    background: #4b545e;
    color: #fff;
    text-decoration: none;
    vertical-align: middle;
    
}
</style>

<?php
//booking 테이블 호출
$sql = "SELECT * FROM {$g5['write_prefix']}{$board['bo_1']} WHERE wr_id = '{$view['wr_3']}'";
$booking_tb = sql_fetch($sql);

//meta 테이블 호출
$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$board['bo_1']}' AND mta_db_id = '{$view['wr_3']}'";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $booking_tb[$row['mta_key']] = $row['mta_value'];
}

//


?>
<div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    
    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>

    <?php if($cnt) { ?>
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <?php
    if ($view['link']) {
     ?>
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
       <!--  <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01 pre_bt">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01 next_bt">다음글</a></li><?php } ?>
        </ul> -->
        <?php } ?>

        
        <ul class="bo_v_com">
            <?php if ($member['mb_level'] >= 8) {?>
                <?php if ($view['wr_6'] == "예약완료"): ?>
                    <li>
                        <input type="button" id="<?=$view['wr_id']?>" class="btn btn-default btn-xs resBtn" style="width:70px;" name="status_update" value="예약대기">
                    </li>
                <?php endif ?>
                <?php if ($view['wr_6'] == "예약대기"): ?>
                    <li>
                        <input type="button" id="<?=$view['wr_id']?>" class="btn btn-default btn-xs resBtn" style="width:70px;" name="status_update" value="예약완료">
                    </li>
                <?php endif ?>
                <?php if ($view['wr_6'] == "예약대기" || $view['wr_6'] == "예약대기" || $view['wr_6'] == "취소요청"): ?>
                    <li>
                        <input type="button" id="<?php echo $view['wr_id']?>" class="btn btn-default btn-xs resBtn" style="width:80px;" name="status_cancel" value="예약취소"> 
                    </li>
                <?php endif ?>
                
                <!-- <li>
                    <a href="<?php echo G5_BBS_URL.'/write.php?w=u&bo_table='.$bo_table.'&wr_id='.$view['wr_id'].'&reservation_date='.$view['wr_9'].'&id='.$view['wr_3'].'&bor_table='.$board['bo_1']?>" class="btn_admin">예약수정</a>
                </li> -->
                <li>
                    <a href="<?php echo $list_href ?>" class="btn_b01">목록</a>
                </li>
            <?php }else{?>
                <li>
                    <a href="<?php echo G5_BBS_URL.'/board.php?bo_table='.$board['bo_1']?>" class="btn_b02">객실예약</a>
                </li>
            <?php if( !($view['wr_6'] == "취소요청" ||  $view['wr_6'] == "취소완료")){ ?>
                <li>
                    <input type="button" id="<?=$view['wr_id']?>" class="btn btn-default btn-xs resBtn" style="width:70px;" name="status_update" value="취소요청">
                </li>
            <?php }}?>
            
        </ul>


        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
        ?>
    </div>
        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"slideshow\" style='max-width:100%;'>
            <ul class='pgwSlideshow'>
            \n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail2($view['file'][$i]['view']);
                }
            }

            echo "</ul></div>\n";
        }
         ?>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
            <div class="row" id="bo_v_con">
                <div class="col-sm-12 wrap">
                    <h2 class="reservAccountTitle1" style="text-align:center;">
                        <span class="highlight"><i class="fab fa-envira"></i></span> 
                        <span class="highlight1">예약 확인</span> 
                        
                    </h2>
                    
                    <?php
                    //총인원 계산
                    $total_pers = $view['wr_old1']+$view['wr_old2']+$view['wr_old3'];

                    //옵션 계산
                    $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$board['bo_1']}' and mta_db_id  = '{$view['wr_3']}' AND mta_key LIKE '%wr_option_%'";
                    $result = sql_query($sql);
                    foreach ($booking_tb as $key => $value) {
                        if (strpos($key, "wr_option_name") !== false) {
                            $op_name[] = $key;
                        }
                      
                    }           
                    
                    if(gettype($op_name) == 'array'){
                        sort($op_name);
                    }

                    $getWeek = getWeek($view['wr_9'],$view['wr_10'], $board['bo_7_subj'],$board['bo_8_subj']);
                    $getSeason = getSeason($getWeek);
                    

                    if($member['mb_level'] > 7){
                    ?>
                    <div class="content_area">
                        <div class="price_data" style="margin-bottom:30px">
                            <div class="inform">상태별 날짜기록</div>
                            <table class="info_table">
                                <body>
                                    <tr>
                                        <td>예약신청 날짜 : </td>
                                        <td><?=$view['wr_datetime']?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>예약승인 날짜 : </td>
                                        <td><?=$view['wr_date_state_pass'] ? $view['wr_date_state_pass']  : '승인기록없음'?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>취소신청 날짜 : </td>
                                        <td><?=$view['wr_date_state_cancelrq'] ? $view['wr_date_state_cancelrq'] : '취소신청기록없음'?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>취소완료 날짜 : </td>
                                        <td><?=$view['wr_date_state_cancel'] ? $view['wr_date_state_cancel']  : '취소완료기록없음'?></td>
                                    </tr>
                                </body>
                            </table>
                        </div>
                    </div>
                    <?php }?>

                    <div class="content_area">
                        <div class="wrap_data">
                            <div class="booking_data">
                                <div class="in_data">
                                    <div class="inform">객실정보</div>
                                    <table class="info_table">
                                        <tr>
                                            <th>객실명</td>
                                            <td><?php //echo $view['wr_5']
                                                    $row = sql_fetch("SELECT * FROM {$g5['write_prefix'] }{$board['bo_1']} WHERE wr_id = {$view['wr_3']}");
                                                    echo $row['wr_subject'];
                                            ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th>입실시간<br>퇴실시간</td>
                                            <td>
                                                <?php echo $view['wr_9']." ".$booking_tb['wr_roomstdate']?><br>
                                                <?php echo $view['wr_10']." ".$booking_tb['wr_roomendate']?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>인원</td>
                                            <td>총 <?php echo $total_pers;?>명</td>
                                        </tr>
                                        <?php if ($view['wr_pickup']): ?>
                                            <tr>
                                                <th>픽업여부</td>
                                                <td>픽업사용 <label style="font-size: 17px;width: 24px;background: black;border-radius: 26px;text-align: center;color: white;margin-left: 9px;" data-toggle="tooltip" title="<?=$board['bo_6_subj']?>">?</label></td>
                                            </tr>
                                        <?php endif ?>
                                        <tr>
                                            <th>옵션</td>
                                            <td>
                                                <?php
                                                $cccount = 0;
                                                for ($i=0; $i < count($op_name); $i++) { 
                                                    if ($view['wr_option_price'.$i]!=0) {
                                                        echo $booking_tb[$op_name[$i]]. " : ".$view['wr_option_price'.$i]."개<br>";    
                                                        $cccount++;
                                                    }
                                                    
                                                }
                                                if ($cccount == 0) {
                                                    echo "선택된 옵션 없음";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="reserve_data">
                                <div class="in_data">
                                    <div class="inform">예약자 정보</div>
                                    
                                    <table class="info_table">
                                        <tr>
                                            <th>예약자명</td>
                                            <td><?php echo $view['wr_2']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>휴대폰 번호</td>
                                            <td><?php echo $view['wr_1']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>이메일</th>
                                            <td><?=$view['wr_mail']?></td>
                                        </tr>
                                        <tr>
                                            <th>입금하실 <br>계좌정보</td>
                                            <td>
                                                <?=$board['bo_3']?><br>
                                                <?=$board['bo_2']?><br>
                                                <?=$board['bo_4']?>
                                            </td>
                                             
                                        </tr>
                                        <tr>
                                            <th>예약 상태</td>
                                            <td id="status"><?php echo $view['wr_6']?></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                        

                       <?php
                        //옵션 가격
                       $total_op = 0;
                       $option_info = "";
                        for ($i=0; $i < count($op_name); $i++) { 
                            if ($view['wr_option_price'.$i]!=0) {
                                $op_price = $booking_tb['wr_option_price'.$i] * $view['wr_option_price'.$i];

                                $option_info .='<tr>
                                                    <td style="border-top: 1px solid #ddd !important;">'.$booking_tb[$op_name[$i]].'</td>
                                                    <td style="border-top: 1px solid #ddd !important;">'.$view['wr_option_price'.$i].'개</td>
                                                    <td style="border-top: 1px solid #ddd !important;">'.number_format($op_price).'원</td>
                
                                                </tr>';
                                 
                                $total_op += $op_price;
                            }
                            
                        }

                        
                        ?>

                        <!-- **************************객실요금************************* -->
                        <?php
                        $result_array = json_decode($view['wr_7'],true);
                        $temp = date('Y-m-d',strtotime('-1 day',strtotime($view['wr_10'])));
                        ?>

                        <div class="price_data" id ="options_price_div">
                            <!-- 자료이전일시 숨김 -->
                            <?php if ($view['wr_7']!='자료이전'): ?>
                                
                            
                            <div class="inform" style="margin-bottom: 20px">이용요금 안내</div>
                            <div class="price_sbj">- 적용된 시즌별 객실요금</div>
                            <div class="wrap_price_table">
                                <table class="price_table">
                                    
                                    <tr>
                                        <td style="width: 30% !important;padding: 8px 0 8px 0;font-weight: bold;">시즌</td>
                                        <td style="width: 40% !important;padding: 8px 0 8px 0;font-weight: bold;">날짜</td>
                                        <td style="width: 30% !important;padding: 8px 0 8px 0;font-weight: bold;">가격</td>
                                    </tr>
                                    <?php
                                    $total_reserve = 0;
                                    foreach ($result_array as $key => $value) {
                                        $total_reserve += end($result_array[$key]);
                                        $season_key = preg_replace("/_/", " ", $key);
                                        ?>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;"><?php echo $season_key?> 적용</td>
                                            <td style="border-top: 1px solid #ddd !important;"><?php echo $result_array[$key][0]['date']." ~<br>";
                                            if ($temp == $result_array[$key][count($result_array[$key])-2]['date']) {
                                                echo $view['wr_10'];
                                            }else{
                                                echo $result_array[$key][count($result_array[$key])-2]['date'];
                                            }
                                            ?>&nbsp;&nbsp;</td>
                                            <td style="border-top: 1px solid #ddd !important;"><?php echo number_format(end($result_array[$key]))?>원</td>

                                        </tr>
                                    <?php }
                                    if ($booking_tb['wr_roomsale']=="1") {
                                        if (count($getSeason) < 2) {
                                            $roomsale = 0;
                                        }elseif (count($getSeason) == 2) {
                                            $roomsale = $booking_tb['wr_roomsale1'];
                                        }elseif (count($getSeason) == 3) {
                                            $roomsale = $booking_tb['wr_roomsale2'];
                                        }elseif (count($getSeason) > 3) {
                                            $roomsale = $booking_tb['wr_roomsale3'];
                                        }
                                        
                                        $total_reserve -=$roomsale;
                                        $dayi = count($getSeason)+1;
                                        ?>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;color: red;">연박시 할인금액</td>
                                            <td style="border-top: 1px solid #ddd !important;color: red;"><?=count($getSeason)."박 ".$dayi?>일</td>
                                            <td style="border-top: 1px solid #ddd !important;color: red;">-<?= number_format($roomsale)?>원</td>
                                        </tr>
                                    <?php }?>
                                </table>
                                <span class="total_p">객실요금 합계 : <?php echo number_format($total_reserve);?>원</span>
                            </div>

                            <!-- **************************옵션요금************************* -->
                            <?php if ($total_op!=0) {?>
                    
                            <div class="price_sbj" style="clear: both;">- 선택한 옵션요금</div>
                                <div class="wrap_price_table">
                                    <table class="price_table">
                                        
                                        <tr>
                                            <td style="width: 30% !important;padding: 8px 0 8px 0;font-weight: bold;">옵션명</td>
                                            <td style="width: 40% !important;padding: 8px 0 8px 0;font-weight: bold;">개수</td>
                                            <td style="width: 30% !important;padding: 8px 0 8px 0;font-weight: bold;">가격</td>
                                        </tr>
                                       <?php echo $option_info?>
                                        
                                    </table>
                                    <span class="total_p">옵션요금 합계 : <?php echo number_format($total_op)?>원</span>
                                </div>
                                <?php }?>
                                
                                <div class="price_sbj" style="clear: both;">- 추가인원 요금 (기준 : <?php echo $booking_tb['wr_min']?>명)</div>
                                <div class="wrap_price_table">
                                    <?php
                                    $adult = $view['wr_old1'] - $booking_tb['wr_min'];
                                    // echo $adult;
                                    if ($adult==0) {
                                        $adult_p = 0;
                                        $kids_p = $view['wr_old2'] * $booking_tb['wr_12'];
                                        $baby_p = $view['wr_old3'] * $booking_tb['wr_13'];

                                    }elseif ($adult > 0) {
                                        
                                        $adult_p = $adult * $booking_tb['wr_11'];
                                        $kids_p = $view['wr_old2'] * $booking_tb['wr_12'];
                                        $baby_p = $view['wr_old3'] * $booking_tb['wr_13'];
                                    }elseif ($adult < 0) {
                                        $adult_p = 0;
                                        $kids = $view['wr_old2'] + $adult;
                                        if ($kids < 0) {
                                            // echo $kids;
                                            $kids_p = 0;
                                            if ($view['wr_old3'] + $kids < 0 ) {
                                                $baby_p = 0;
                                            }else{
                                                $baby_p = ($view['wr_old3'] + $kids) * $booking_tb['wr_13'];       
                                            }
                                            

                                        }elseif($kids == 0){
                                            $kids_p = 0;
                                            $baby_p = $view['wr_old3'] * $booking_tb['wr_13'];
                                        }elseif ($kids > 0) {
                                            $kids_p = ($view['wr_old2'] + $kids) * $booking_tb['wr_12'];;
                                            $baby_p = $view['wr_old3'] * $booking_tb['wr_13'];
                                        }                                

                                    }
                                    // echo "성인".$adult_p;
                                    // echo "<br>소인".$kids_p;
                                    // echo "<br>유아".$baby_p;
                                    
                                    $old_price = getAddPrice($view['wr_old1'],$view['wr_old2'],$view['wr_old3'],$board['bo_1'],$view['wr_3']);
                                    $old_price = $old_price * count($getWeek);
                                    ?>
                                    <table class="price_table">
                                        
                                        <tr>
                                            <td style="width: 30% !important;padding: 8px 0 8px 0;font-weight: bold;">분류</td>
                                            <td style="width: 40% !important;padding: 8px 0 8px 0;font-weight: bold;">선택된 인원</td>
                                            <td style="width: 30% !important;padding: 8px 0 8px 0; border-left: 1px solid #ddd !important;font-weight: bold;">추가요금</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;">성인</td>
                                            <td style="border-top: 1px solid #ddd !important;"><?php echo $view['wr_old1']?>명</td>
                                            <td rowspan="3" style="border: 1px solid #ddd !important;border-right: 0 !important;"><?php echo number_format($old_price)?>원</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;">소인</td>
                                            <td style="border-top: 1px solid #ddd !important;"><?php if ($view['wr_old2']=='') {
                                                echo "해당없음";
                                            }else{
                                                echo $view['wr_old2'].'명';
                                            }?></td>
                                            
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;">유아</td>
                                            <td style="border-top: 1px solid #ddd !important;"><?php if ($view['wr_old3']=='') {
                                                echo "해당없음";
                                            }else{
                                                echo $view['wr_old3'].'명';
                                            }?></td>
                                            
                                        </tr>
                                        <?php if ($board['bo_1_subj'] != ""): ?>
                                        <tr>
                                            <td style="border-top: 1px solid #ddd !important;">애완동물</td>
                                            <td style="border-top: 1px solid #ddd !important;border-right: 1px solid #ddd !important;"><?=$view['wr_animals2']?>마리</td>
                                            <td style="border: 1px sold"><?=$view['wr_animals']?></td>
                                        </tr>
                                        <?$animal_prc = preg_replace('/,|원/', "", $view['wr_animals'])?>
                                        <?php endif ?>
                                    </table>
                                    <span class="total_p">추가요금 합계 : <?php echo number_format($old_price+$animal_prc)?>원</span>
                                </div>
                                <?php endif ?>
                                <!-- 자료이전 -->
                                <div style="">
                                    <div class="price_label">총 결제 금액</div>  
                                    <div class="status_label">입금상태</div>  
                                    <div class="status_class"><?=$view['wr_8']?></div>  
                                    <div class="status_class"><?php echo $view['wr_6']?></div>  
                                </div>
                            </div>
                          
                    </div>
                   <!-- <table>
                        <tbody>
                            <tr>
                                <td>객실명</td>
                                <td><?php echo $booking_tb['wr_subject']?></td>
                            </tr>
                            <tr>
                                <td>입실/퇴실시간</td>
                                <td><?php echo $booking_tb['wr_roomstdate']?>시 / <?php echo $booking_tb['wr_roomendate']?>시</td>
                            </tr>
                            <tr>
                                <td>예약자명</td>
                                <td><?php echo $view['wr_name']; ?></td>
                            </tr>
                            
                            <tr>
                                <td>휴대폰번호</td>
                                <td>
                                    <?php echo $view['wr_1']; ?>
                                </td>
                            </tr>
                             <tr>
                                <td>이메일주소</td>
                                <td><?php echo $view['wr_email']?></td>
                            </tr> 
                            <tr>
                                <td>숙박기간</td>
                                <td>
                                    <?php if ($view['wr_9'] == $view['wr_10']) {
                                        echo $view['wr_9'];
                                    }else{
                                        echo $view['wr_9']." ~ ".$view['wr_10'];
                                    }?>
                                        
                                    </td>
                            </tr>
                            <tr>
                                <td>옵션</td>
                                <td>
                                <?php 
                                $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = 'board/{$board['bo_1']}' and mta_db_id  = '{$view['wr_3']}' AND mta_key LIKE '%wr_option_%'";
                                $result = sql_query($sql);
                                foreach ($booking_tb as $key => $value) {
                                    if (strpos($key, "wr_option_name") !== false) {
                                        $op_name[] = $key;
                                    }
                                    
                                    
                                }
                                
                                for ($i=0; $i < count($op_name); $i++) { 
                                    if ($view['wr_option_price'.$i]!=0) {
                                        echo $booking_tb[$op_name[$i]]. " : ".$view['wr_option_price'.$i]."개<br>";    
                                    }
                                    
                                }
                                
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>인원</td>
                                <td>
                                    <?php if ($view['wr_old1']!=0): ?>
                                        성인 : <?php echo $view['wr_old1']?>명<br>    
                                    <?php endif ?>
                                    <?php if ($view['wr_old2']!=0): ?>
                                        소인 : <?php echo $view['wr_old2']?>명<br>
                                    <?php endif ?>
                                    <?php if ($view['wr_old3']!=0): ?>
                                        유아 : <?php echo $view['wr_old3']?>명<br>
                                    <?php endif ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>총금액</td>
                                <td><?php echo $view['wr_8']?></td>
                            </tr>
                            <tr>
                                <td>입금정보</td>
                                <td><?php echo $board['bo_3']." ".$board['bo_2']." ".$board['bo_4']?></td>
                            </tr>
                            
                            <tr>
                                <td>현재 상태</td>
                                <td id="status"><?php echo $view['wr_6']?></td>
                            </tr>
                        </tbody>
                    </table>-->
                </div>
            </div>


    <!-- <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
                      
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good">이 글을 추천하셨습니다</b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <?php
        include(G5_SNS_PATH."/view.sns.skin.php");
        ?>
    </section> -->

    <?php
    // 코멘트 입출력
    if ($member['mb_level'] >= 8) {
        include_once(G5_BBS_PATH.'/view_comment.php');    
    }
    
     ?>

    <div id="bo_v_bot">
        <!-- 링크 버튼 -->
        <?php echo $link_buttons ?>
    </div>

</article>

<script>
   


$('[data-toggle="tooltip"]').tooltip();
$("input[name='status_cancel']").click(function(){
    $id = $(this).attr("id");

    $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_reservation.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "cancel",
                "bo_table" : '<?=$bo_table?>',
                "id" : $id
                // "value" : $value
                
            },
            // dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                alert("예약 취소되었습니다.");
                location.reload();
                
                
                // document.getElementById("total_price").innerHTML = data.price.total+"원";
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
    } );

})
$("input[name='status_update']").click(function(){

    $id = $(this).attr("id");
    $value = $(this).val();
    status = $("#status").text();
    console.log($value);
    console.log(status);
    if ($value == status) {
        alert("이미 취소요청 되었습니다.")
        return false;
    }
    
    $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_reservation.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "update",
                "bo_table" : '<?=$bo_table?>',
                "id" : $id,
                "value" : $value
                
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {

                
                alert("상태가 수정되었습니다.");
                location.reload();
                
                // document.getElementById("total_price").innerHTML = data.price.total+"원";
            },
            error: function( xhr, textStatus, errorThrown ) {
                
                console.error( textStatus );
            }
    } );
})
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->

<script>
$(function() {


    // $(document).ready(function() {
    //     $('.pgwSlideshow').pgwSlideshow({
    //         transitionEffect : "<?php echo $transitionEffect?>",
    //         autoSlide : "<?php echo $autoSlide?>",
    //         //maxHeight : "<?php echo maxHeight?>"



    //     });
    // });


    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    // $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>