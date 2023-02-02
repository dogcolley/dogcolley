<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>
<style>
    #settings label {font-weight: unset;}
</style>
<!-- 시즌관리 -->

<div id="J_ajax_loding">
    <div>
        <div>
            <i class="fas fa-spinner"></i>
            <span>처리중입니다. 잠시만 기다려주세요.</span>
        </div>
    </div>
</div>

<div class="modal fade" id="holidays" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="z-index: 9999;">
        <div class="modal-content">
            <div class="modal-header">
                <h5><i class="fa fa-list" aria-hidden="true"></i> 휴일 관리</h5>
            </div> 
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow-y: auto;overflow-x: hidden;">
                <div id="holiday_setting" class="holiday_con">
                    <h6>휴일 설정하기</h6>
                    <div class="holiday_setting_checkbox">
                        <?php
                           $sql = "SELECT wr_id , wr_subject FROM $write_table";
                           $result = sql_query($sql);
                           while($row = sql_fetch_array($result)){
                               $hd_wr_list[] = $row;
                        ?>
                            <label for="hd_id<?=$row['wr_id']?>" ><input type="checkbox" name="hd_id" value="<?=$row['wr_id']?>" id="hd_id<?=$row['wr_id']?>"><?=$row['wr_subject']?></label>
                        <?php
                           }
                        ?>
                    </div>
                    <input type="text" id="J_holiday_start" readonly class="frm_input U_hd_date01" placeholder="막기예약 시작일">
                    <input type="text" id="J_holiday_end" readonly class="frm_input U_hd_date01" placeholder="막기예약 종료일">
                    <button type="button" id="J_ajax_holiday_setting" class="btn U_hd_btn01">추가하기</button>
                </div>
                <div id="holiday_list" class="holiday_con">
                    <h6>
                        휴일 리스트 
                        <select name="" id="holiday_ajax_select">
                            <option value="all">전체</option>
                            <?php for($i=0;$i < count($hd_wr_list);$i++){ ?>
                            <option value="<?=$hd_wr_list[$i]['wr_id']?>"><?=$hd_wr_list[$i]['wr_subject']?></option>
                            <?php } ?>
                        </select>
                        <select name="" id="holiday_ajax_number"></select>
                        <button type="button" id="holiday_ch_del" class="hd_btn02">선택삭제</button>
                        <button type="button" id="holiday_ch_all" class="hd_btn02">현재리스트전체선택</button>
                    </h6>
                    <ul id="holiday_ajax_list" class="clear">

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="reload_button" class="btn btn-default btn-default pull-left"> 닫기</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="setting" role="dialog">
    <div class="modal-dialog" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i> 시즌 관리</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow-y: auto;overflow-x: hidden;">
                <form id="goods" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="4">시즌설정 주의사항</th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    1. 시즌을 추가했다면 반드시 객실마다 시즌에 맞는 가격을 수정해주셔야 합니다.<br>
                                    2. 시즌을 삭제하면 이미 예약된 객실은 시즌이 적용되어 가격이 정해집니다.<br>
                                    3. 시즌이 설정되지 않은 기간은 모두 비수기 처리 됩니다.<br>

                                </td>
                            </tr>
                            
                            <tr>
                                <th>시즌명</th>
                                <th>시작날짜</th>
                                <th>끝날짜</th>
                                <th>관리</th>
                            </tr>
                        </thead>
                        <tbody class="gd_tbody">
                            <tr>

                                <td><input type="text" name="is_name" id="date_name" class="frm_input input03"></td>
                                <td><input type="text" name="is_date" id="start_date" class="frm_input input01" readonly></td>
                                <td><input type="text" name="is_date" id="end_date" class="frm_input input01" readonly></td>
                                <td><button id="regBtn" type="button" class="btn btn-default">등록</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>시즌명</th>
                            <th>시작날짜</th>
                            <th>끝날짜</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody class="gd_tbody2">
                        <?php
                        $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_table = '".$board['bo_1']."/date/config'  order by mta_idx desc";
                        
                        $rs = sql_query( $sql );
                        for ( $i = 0; $row = sql_fetch_array( $rs ); $i++ ) {
                            $row['mta_db_id'] = preg_replace("/_/", " ", $row['mta_db_id']);
                            ?>
                            <tr id="tr_<?=$row['mta_idx']?>">
                                <td><input type="text" name="is_name" id="date_name_<?=$row['mta_idx']?>" class="frm_input input03"  value="<?=$row['mta_db_id']?>"></td>
                                <td><input type="text" name="is_date" id="start_date_<?=$row['mta_idx']?>" class="frm_input input01" value="<?=$row['mta_key']?>" readonly></td>
                                <td><input type="text" name="is_date" id="end_date_<?=$row['mta_idx']?>" class="frm_input input01" value="<?=$row['mta_value']?>" readonly></td>
                                <td>
                                    <button id="editBtn" type="button" class="btn btn-default" onclick="editBtn( <?=$row['mta_idx']?> )">수정</button>
                                    <button id="delBtn" type="button" class="btn btn-default" onclick="delBtn( <?=$row['mta_idx']?> )">삭제</button>
                                </td>
                            </tr>
                            <?php 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div>
        </div>
    </div>
</div>
<!-- 환경설정 -->
<div class="modal fade" id="settings" role="dialog">
    <div class="modal-dialog" style="z-index: 9999;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5><i class="fa fa-list" aria-hidden="true"></i>환경설정</h5>
            </div>
            <div class="modal-body tbl_head01 tbl_wrap" style="overflow: auto;">


                <?
                $sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$board['bo_1']}'";
                $fetch = sql_fetch($sql);
                ?>


                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">기본설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">입금계좌설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">예약동의란</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-sms-tab" data-toggle="pill" href="#pills-sms" role="tab" aria-controls="pills-sms" aria-selected="false">SMS발송설정</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-mail-tab" data-toggle="pill" href="#pills-mail" role="tab" aria-controls="pills-mail" aria-selected="false">메일발송설정</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">예약 대기시간</td>
                                <td>
                                    <input type="text" class="frm_input input03"  name="bo_2" value="<?php echo $board['bo_2'];?>" style="width: 50px"> 시간 뒤 예약취소
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">달력 예약완료 노출명 선택</td>
                                <td>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "") {echo "checked";}?> value=""> 모든이름 &nbsp;&nbsp;ex)홍길동<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "1") {echo "checked";}?> value="1"> 중간이름 &nbsp;&nbsp;ex)O길O<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "2") {echo "checked";}?> value="2"> 성만 노출 &nbsp;ex)홍OO<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "3") {echo "checked";}?> value="3"> 마지막이름 ex)OO동<br>
                                    <input type="radio" name ="bo_1_subj" <?php if ($board['bo_1_subj'] == "4") {echo "checked";}?> value="4"> 객실명 ex)객실 101호

                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">소인/유아 인원 포함 여부</th>
                                <td>
                                    <input type="radio" name ="bo_2_subj" <?php if ($board['bo_2_subj'] == "") {echo "checked";}?> value=""> 성인만 사용
                                    <br>
                                    <input type="radio" name ="bo_2_subj" <?php if ($board['bo_2_subj'] == "1") {echo "checked";}?> value="1"> 성인/소인/유아 구별
                                    
                                </td>
                            </tr>
                            <tr id="kids" style="display: none;">
                                
                                <td colspan="2">
                                    ※ 아래 내용을 작성하시면 사용자가 예약할 때 출력됩니다.<br>
                                    <input type="text" class="frm_input input03"  name="bo_3_subj" required value="<?echo $board['bo_3_subj']?>" style="height: 25px;width: 50px">세 이상은 소인으로, 미만은 유아로 취급합니다.<br>
                                    <input type="text" class="frm_input input03"  name="bo_4_subj" value="<?echo $board['bo_4_subj']?>" style="height: 25px;width: 50px">개월 이하의 유아는 기준인원에 포함하지 않음.<br>
                                    <font color="red">*모든 연령의 유아를 포함한다면 빈칸으로 작성해주세요.</font>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;"><label>애완동물 허용 <input type="checkbox" id="is_pay_for_pet" <? if($fetch['bo_1_subj'] != "") echo "checked";?>></label></th> 
                                <td>
                                    <label>1마리 1박당 <input type="text" class="frm_input" style="width: 150px;" id="pay_for_pet" value="<?=$fetch['bo_1_subj']?>">원</label>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">공휴일 전날 <br>주말요금 적용 여부
                                </th> 
                                <td>
                                    <label><input type="radio" name ="bo_5_subj" <?php if ($board['bo_5_subj'] == "1") {echo "checked";}?> value="1"> 사용</label>
                                    <label><input type="radio" name ="bo_5_subj" <?php if ($board['bo_5_subj'] == "") {echo "checked";}?> value=""> 사용안함</label>
                                    
                                    
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">금요일 주말적용 여부</th> 
                                <td>
                                    <label><input type="radio" name ="bo_8_subj" <?php if ($board['bo_8_subj'] == "") {echo "checked";}?> value=""> 금,토 주말가격 적용</label>
                                    <label><input type="radio" name ="bo_8_subj" <?php if ($board['bo_8_subj'] == "1") {echo "checked";}?> value="1"> 토요일만 주말가격 적용</label>
                                    
                                    
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">주말 가격 구분 여부</th> 
                                <td>
                                    <label><input type="radio" name ="bo_7_subj" <?php if ($board['bo_7_subj'] == "") {echo "checked";}?> value=""> 금,토 주말가격 일괄적용</label>
                                    <label><input type="radio" name ="bo_7_subj" <?php if ($board['bo_7_subj'] == "1") {echo "checked";}?> value="1"> 금,토 가격 구분</label>
                                    
                                    
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">픽업옵션 사용여부</th>
                                <td>
                                    <input type="radio" name ="bo_6_subj" <?php if ($board['bo_6_subj'] != "") {echo "checked";}?> value="1"> 사용
                                    <input type="radio" name ="bo_6_subj" <?php if ($board['bo_6_subj'] == "") {echo "checked";}?> value=""> 사용안함
                                </td>
                            </tr>
                            
                            
                            <tr id="pick_up" <?if (!$board['bo_6_subj']) {echo 'style="display: none;"';}?>>
                                <th style="text-align: center;">픽업시 유의사항<br>(요금, 장소, 시간 등)</th>
                                    <td><textarea class="frm_input input03" style="height: 100px;width: 100%;"  name="bo_6_subj_content" id="bo_6_subj_content"><?php echo $board['bo_6_subj'];?></textarea></td>
                                   
                            </tr>
                            <tr>
                                <th style="text-align: center;">날짜설정</th>
                                <td>
                                    <select name="bo_max_date" id="bo_max_date">
                                        <option value="" >설정안함</option>
                                        <option value="0" <?=$board['bo_max_date'] == '0'? 'selected' : '' ?> >이번달만</option>
                                        <option value="1" <?=$board['bo_max_date'] == '1'? 'selected' : '' ?> >이번달,다음달만</option>
                                        <option value="2" <?=$board['bo_max_date'] == '2'? 'selected' : '' ?> >3개월</option>
                                        <option value="5" <?=$board['bo_max_date'] == '5'? 'selected' : '' ?> >6개월</option>
                                        <option value="11" <?=$board['bo_max_date'] == '11'? 'selected' : '' ?> >1년</option>
                                        <option value="23" <?=$board['bo_max_date'] == '23'? 'selected' : '' ?> >2년</option>
                                    </select>
                                    <br/>
                                    <p>설정한 개월의 기간만큼만 예약을 받을 수 있습니다.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">입금 계좌정보</td>
                                <td>
                                    <?if ($config['cf_escrow']) {?>
                                        <table>
                                            <tr>
                                                <th>은행명</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_4" value="<?php echo $board['bo_4'];?>"></td>
                                            </tr>
                                            <tr>
                                                <th>계좌 번호</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_9" value="<?php echo $board['bo_9'];?>"></td>
                                            </tr>
                                            <tr>
                                                <th>예금주</td>
                                                <td><input type="text" class="frm_input input03"  name="bo_10" value="<?php echo $board['bo_10'];?>"></td>
                                            </tr>
                                        </table>    
                                    <? }else{?>
                                         <span style="color: red;">에스크로 등록하셔야 계좌설정이 가능합니다</span> <br> 관리자에 관리/설정->기본환경설정->에스크로설정<br>
                                         <a href="<?php echo G5_USER_ADMIN_URL.'/config_form.php#anc_cf_escrow' ?>" style="background: red; color: white;">에스크로 등록하기</a>
                                    <? }?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <table>
                            <tr>
                                <th style="text-align: center;">입퇴실 규정 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;"  name="bo_6"><?php echo $board['bo_6'];?></textarea></td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">개인정보활용 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;" name="bo_7"><?php echo $board['bo_7'];?></textarea></td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">환불규정 추가</th>
                                <td colspan="2"><textarea class="frm_input input03" style="height: 100px;width: 100%;" name="bo_8"><?php echo $board['bo_8'];?></textarea></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-sms" role="tabpanel" aria-labelledby="pills-sms-tab">
                        <?php
                        $sql = "SELECT * FROM {$g5['config_table']}";
                        $result = sql_fetch($sql);
                        
                        ?>
                        <table id="tb_sms">
                            <thead>
                                <tr>
                                    <th colspan="3">SMS발송 메세지 여부 및 문구 설정</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <b>[TIP] 발송 여부 및 문구 설정시</b><br><br>
                                        <span style="color:red;">
                                        ※ 전송내용에 있는 각 변수 들은 {name}: 예약자, {date}: 숙박날짜,{room}: 방이름, {price}: 예약금액입니다. <br>
                                        ※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
                                        ※ SMS 서비스는 80 byte 길이 까지만 지원합니다. (한글 기준 약 40자) <br><br>
                                        </span>
                                        ex) [관리자] {name}님 {room} {date} 예약이 접수되었습니다. {price}을 입금해주세요 <br>
                                             [사용자] {name}님 {room} {price} 입금 확인되어 예약접수 완료 공지사황 확인 부탁드립니다.<br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th>SMS 발송 여부</th>
                                    <td colspan="2">
                                        
                                        80byte 이상은 LMS로 전환되어 발송됩니다.<br>
                                        
                                        <select id="sms_check" class="sel" style="float: none;padding-top: 7px;">
                                            <option value="" <?if($result['cf_10']==""){echo "selected";}?>>사용안함</option>
                                            <option value="1" <?if($result['cf_10']=="1"){echo "selected";}?>>유플러스</option>
                                            <option value="2" <?if($result['cf_10']=="2"){echo "selected";}?>>아이코드</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sms_tr">
                                    <th>예약요청시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_ready_adm" <?php if ($result['cf_1_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_ready_adm" class="frm_input input03" style="height: 70px;" style="height: 70px;"><?php if ($result['cf_1']=="") {
                                            echo "{name}님이 {date} {room}에 예약하셨습니다. 객실금액 : {price}";
                                            }else{ 
                                                echo $result['cf_1'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_ready_user" <?php if ($result['cf_2_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_ready_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_2']=="") {
                                            echo "{name}님 {date} {room}에 예약이 접수되었습니다. {price}을 입금하면 완료처리 됩니다.";
                                            }else{ 
                                                echo $result['cf_2'];
                                            }?></textarea>
                                    </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>예약완료시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_compl_adm" <?php if ($result['cf_3_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_compl_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_3']=="") {
                                            echo "{name}님이 {date} {room} {price} 입금 확인되어 예약완료했습니다.";
                                            }else{ 
                                                echo $result['cf_3'];
                                            }?></textarea>

                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_compl_user"<?php if ($result['cf_4_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_compl_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_4']=="") {
                                            echo "{name}님 {date} {room} {price}이 입금 확인되어 예약완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_4'];
                                            }?></textarea>
                                    </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>취소요청시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_cancel_req_adm"<?php if ($result['cf_5_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_req_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_5']=="") {
                                            echo "{name}님이 {date} {room} 취소요청을 하셨습니다.";
                                            }else{ 
                                                echo $result['cf_5'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_cancel_req_user"<?php if ($result['cf_6_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_req_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_6']=="") {
                                            echo "{name}님 {date} {room} 취소요청 되었습니다.";
                                            }else{ 
                                                echo $result['cf_6'];
                                            }?></textarea>
                                </td>
                                </tr>
                                <tr class="sms_tr">
                                    <th>취소완료시</th>
                                    <td>
                                        <label>관리자 <input type="checkbox" name="chk_resev_cancel_res_adm" <?php if ($result['cf_7_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_res_adm" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_7']=="") {
                                            echo "{name}님 {date} {room} 취소완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_7'];
                                            }?></textarea>
                                    </td>
                                    <td>
                                        <label>예약자 <input type="checkbox" name="chk_resev_cancel_res_user" <?php if ($result['cf_8_subj'] == "true") {echo "checked";}?> value="1"></label><br>
                                        <textarea name="msg_resev_cancel_res_user" class="frm_input input03" style="height: 70px;"><?php if ($result['cf_8']=="") {
                                            echo "{name}님 {date} {room} 취소완료되었습니다.";
                                            }else{ 
                                                echo $result['cf_8'];
                                            }?></textarea>
                                    </td>
                                </tr>    
                                
                            </tbody>

                            
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-mail" role="tabpanel" aria-labelledby="pills-mail-tab">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="3">이메일 발송 여부 및 문구 설정</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <span style="color:red;">
                                        ※ 네이버 아이디와 비밀번호를 정확하게 입력해주세요.<br>
                                        ※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
                                        ※ {name} >> 예약자명, {room} >> 객실명, {date} >> 기간,<br>
                                        ※ {price} >> 가격, {link} >> 예약확인 링크
                                        </span>
                                    </td>
                                    
                                </tr>
                                
                                <tr>
                                    
                                    <th colspan="2">
                                        예약시 이메일 발송 여부
                                        <select id="email_check" class="sel" style="float: none;padding-top: 7px;">
                                            <option <?if($fetch['bo_10']==""){echo "selected";}?> value="">사용안함</option>
                                            <option <?if($fetch['bo_10']=="1"){echo "selected";}?> value="1">사용</option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="width: 25%;">발신명</th>
                                    <td style="width: 75%;"><input type="text" class="frm_input input03" name="mail_id" value="<?=$fetch['bo_9']?>"></td>
                                </tr>
                                <tr>
                                    <th style="width: 25%;">발송 이메일주소</th>
                                    <td style="width: 75%;"><input type="text" class="frm_input input03" name="mail_pass" value="<?=$fetch['bo_8']?>"></td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2">
                                        발송 메세지 입력
                                        <table>
                                            <tr>
                                                <td style="width: 50%;">

                                                    관리자 <input type="checkbox" id="admin_email" value="1" <?if ($fetch['bo_10_subj']) {echo "checked";}?> ><br>
<textarea class="frm_input input03" style="height: 150px;width: 100%" name="mail_text2"><?if($fetch['bo_7']){echo $fetch['bo_7'];}else{echo "{name}님 {date} 날짜로 예약이 신청되었습니다.
자세한 내용은 아래에 링크를 통해 예약을 확인해주세요.
{link}";}?></textarea>
                                                </td>
                                                <td style="width: 50%;">
                                                    사용자 <input type="checkbox" id="user_email" value="1" <?if ($fetch['bo_9_subj']) {echo "checked";}?> ><br>
<textarea class="frm_input input03" style="height: 150px;width: 100%" name="mail_text"><?if($fetch['bo_6']){echo $fetch['bo_6'];}else{echo "{name}님 {date} 날짜로 예약이 신청되었습니다.
자세한 내용은 아래에 링크를 통해 예약을 확인해주세요.
{link}";}?></textarea>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button> -->
                <button id="settings" type="button" class="btn btn-default" onclick="bo_set()" style="float: right;">완료</button>
            </div>
        </div>
    </div>
</div> 
<script>
    $(document).ready(function() {

        //add holiday control 
        $('#J_holiday_end').datepicker({
            changeMonth: true, 
            changeYear: true, 
            dateFormat: "yy-mm-dd", 

            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            yearRange: "c-99:c+99"
        // buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
        // buttonImageOnly: true, showOn: 'both'
        });
        
        $('#J_holiday_start').datepicker({
            changeMonth: true, 
            changeYear: true, 
            dateFormat: "yy-mm-dd", 

            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            yearRange: "c-99:c+99"
        // buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
        // buttonImageOnly: true, showOn: 'both'
        
    });


    $('#J_ajax_holiday_setting').on('click',function(){
          
        var hd_start_date = $('#J_holiday_start').val();
        var hd_end_date = $('#J_holiday_end').val();

        if($('input[name="hd_id"]:checked').length < 1){
            alert('휴일을 지정할 대상을 1개이상  선택해주세요.');
            return false;
        }
       // var hd_wr_id = $('input[name="hd_id').val();
        var hd_id = new Array();

       $('input[name="hd_id"]:checked').each(function(){
           hd_id.push($(this).val());
       })
       
        var x = new Date(hd_start_date);
        var y = new Date(hd_end_date);

        if(!hd_start_date){
            alert('시작일을 입력해주세요.');
            return false;
        }

        if(!hd_end_date){
            alert('종료일을 입력해주세요.');
            return false;
        }

        if(!(x < y) &&  !(+x === +y) ){
            alert('시작일보다 적게 설정 할 수 없습니다.');
            return false;
        }
        $('#J_ajax_loding').show();
        $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "holiday_date_update",
                "bo_table" : '<?=$bo_table?>',
                "id" : hd_id,
                "start_date" : hd_start_date,
                "end_date" : hd_end_date
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                console.log(data);
                $('#J_ajax_loding').hide();
                alert("수정되었습니다.");
                location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        });
    });

    $('#holidays').on('click',function(){
    });

    var now_page = 0; 

    $(window).load(function(){
        get_ajax_hd_list(); 
    });

    $('#holiday_ajax_number').on('change',function(){
        now_page = $(this).val();
        get_ajax_hd_list();
    });

    
    $('#holiday_ajax_select').on('change',function(){
        now_page = 0;
        get_ajax_hd_list();
    });

    $('#holiday_ch_all').on('click',function(){
        $('input[name="ch_hd_id"]').prop("checked", true);
    });

    $('#holiday_ch_del').on('click',function(){
        
        if($('input[name="ch_hd_id"]:checked').length < 1){
            alert('한개이상 선택해주세요.')
            return false;
        }

        var arr = new Array();
        $('input[name="ch_hd_id"]:checked').each(function(){
            arr.push($(this).val());
        });

        var cfm = confirm('정말 삭제하시겠습니까? 삭제후 복구가 되지 않습니다.');

        if(cfm){
            $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
                type: "POST",
                data: {
                    "bo_table" : '<?=$bo_table?>',
                    "status" : "holiday_del",
                    "mta_idx" : arr
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    alert('삭제완료되었습니다.');
                    now_page = 0;
                    get_ajax_hd_list();
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
            });
        }
    });

    $(document).on('click','.del_hoilday',function(){
        var cfm = confirm('정말 삭제하시겠습니까? 삭제후 복구가 되지 않습니다.');
        var $mta_idx = $(this).data('id');
        if(cfm){
            $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
                type: "POST",
                data: {
                    "bo_table" : '<?=$bo_table?>',
                    "status" : "holiday_del",
                    "mta_idx" : $mta_idx
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                    alert('삭제완료되었습니다.');
                    get_ajax_hd_list();
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
            });
        }
    });


    function get_ajax_hd_list () {
        
        $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
            type: "POST",
            data: {
                "bo_table" : '<?=$bo_table?>',
                "status" : "holiday_date_get",
                "holiday_ajax_select" : $('#holiday_ajax_select').val(),
                "now_page" : now_page
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                console.log(data);
                $('#holiday_ajax_list *').remove();
                var tag ='';
                for(var i=0;i<data.list.length;i++){
                    console.log(data.list[i].mta_db_id);
                    var txt = '';
                    $('#holiday_ajax_select').find('option').each(function(){
                        if($(this).val() == data.list[i].mta_db_id)txt = $(this).text();
                    })
                    tag += '<li><input type="checkbox" style="margin-right:5px" name="ch_hd_id" value="'+data.list[i].mta_idx+'">'+txt+', 날짜 : '+data.list[i].mta_key+'<button data-id="'+data.list[i].mta_idx+'" class="del_hoilday">삭제</button></li>'
                }
                $('#holiday_ajax_list').append(tag);
                tag = '';
                $('#holiday_ajax_number *').remove();
                for(var i =0; i < data.j_page_total;i++){
                    var selcted = now_page == i ? 'selected' : '';
                    tag += '<option '+selcted+' value="'+i+'">'+(i+1)+'페이지</option>';
                }
                $('#holiday_ajax_number').append(tag);

                //$('#J_ajax_loding').hide();
                //alert("수정되었습니다.");
                //location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        });
    }

    $('#reload_button').on('click',function(){location.reload();})
    //end holiday control
        $('#is_pay_for_pet').click(function(event) {
            if (!$(this).prop("checked")) {
                $('#pay_for_pet').val("");
                $('#pay_for_pet').attr('disabled', true);
            }else{
                $('#pay_for_pet').attr('disabled', false);
                $('#pay_for_pet').val("0");
            }
        });

        $('#pay_for_pet').keyup(function(event) {
            $(this).val($(this).val().replace(/[^0-9]/g,""));
            if ($(this).val()=="") {
                $(this).val("0");
            }
        });
        $('#pay_for_pet').blur(function(event) {
            $(this).val($(this).val().replace(/[^0-9]/g,""));
        });

        $('#pills-home-tab').trigger('click');

        $('[data-toggle="tooltip"]').tooltip();
        is_use_sms = $("#sms_check").val();
        if (is_use_sms == "") {

            $(".sms_tr").hide();
            $('#tb_sms').css("opacity","0.5");
        }else{
            $(".sms_tr").show();
            $('#tb_sms').css("opacity","1");
        }

        var use_count = $("input[name=bo_2_subj]:checked").val();

        if (use_count == "") {
            $("#kids").hide();

        }else{
            $("#kids").show();

        }

    });
    $("input[name^='is_date']").each(function(){
        var _this = this.id;

        $('#'+_this).datepicker({
            changeMonth: true, 
            changeYear: true, 
            dateFormat: "yy-mm-dd", 

            prevText: '이전 달',
            nextText: '다음 달',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix: '년',
            yearRange: "c-99:c+99"
        // buttonImage:"<?php echo $board_skin_url;?>/img/calendar.png", 
        // buttonImageOnly: true, showOn: 'both'
        
    });
    });
    ///////////////////modal//////////////////////
    $( '#goodsbtn' ).click( function () {
        $( '#setting' ).modal();
    } );

    $( '#settingbtn' ).click( function () {
        $( '#settings' ).modal();
    } );

    $( '#holidaybtn' ).click( function () {
        $( '#holidays' ).modal('show');
    } );

// 기간등록
$( '#regBtn' ).click( function () {

    var $date_name = $( '#date_name' ).val();
    var $start_date = $( '#start_date' ).val();
    var $end_date = $( '#end_date' ).val();
    
    if ( $date_name == '' ) {
        alert( '시즌명을 입력하세요.' );
        $( '#date_name' ).focus();
        return false;
    } else if ( $start_date == '' ) {
        alert( '시작날짜를 입력하세요.' );
        $( '#start_date' ).focus();
        return false;
    } else if ( $end_date == '' ) {
        alert( '끝날짜을 입력하세요.' );
        $( '#end_date' ).focus();
        return false;
    } else {
        $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "date_insert",
                "bo_table" : '<?=$bo_table?>',
                "date_name" : $date_name,
                "start_date" : $start_date,
                "end_date" : $end_date
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                alert("등록되었습니다.");
                location.reload();

                // var appendTr = "<tr id='tr_"+data.id+"'>";
                //     appendTr += "<td><input type=\"text\" name=\"mta_db_id\" id=\"date_name_"+data.id+"\" class=\"frm_input input03\" value=\""+$date_name+"\"></td>";
                //     appendTr += "<td><input type=\"text\" name=\"mta_key\" id=\"start_date_"+data.id+"\" class=\"frm_input input01\" value=\""+$start_date+"\"></td>";
                //     appendTr += "<td><input type=\"text\" name=\"mta_value\" id=\"end_date_"+data.id+"\" class=\"frm_input input01\" value=\""+$end_date+"\"></td>";
                //     appendTr += "<td><button id=\"editBtn\" type=\"button\" class=\"btn btn-default\" onclick=\"editBtn( "+data.id+" )\">수정</button>";
                //     appendTr += "<button id=\"delBtn\" type=\"button\" class=\"btn btn-default\" onclick=\"delBtn( "+data.id+" )\">삭제</button></td>";
                //     appendTr += "</tr>";
                // $( '.gd_tbody2 tr:first' ).before( appendTr );

                // $( '#date_name' ).val("");
                // $( '#start_date' ).val("");
                // $( '#end_date' ).val("");

            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        } );
    }
} );
// 기간수정
function editBtn( id ) {
    var $date_name = $( '#date_name_'+id ).val();
    var $start_date = $( '#start_date_'+id ).val();
    var $end_date = $( '#end_date_'+id ).val();
    

    if ( $date_name == '' ) {
        alert( '시즌명을 입력하세요.' );
        $( '#date_name' ).focus();
        return false;
    } else if ( $start_date == '' ) {
        alert( '시작날짜를 입력하세요.' );
        $( '#start_date' ).focus();
        return false;
    } else if ( $end_date == '' ) {
        alert( '끝날짜을 입력하세요.' );
        $( '#end_date' ).focus();
        return false;
    } else {
        $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "date_update",
                "bo_table" : '<?=$bo_table?>',
                "id" : id,
                "date_name" : $date_name,
                "start_date" : $start_date,
                "end_date" : $end_date
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {

                alert("수정되었습니다.");
                location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        } );
    }
}
//기간삭제
function delBtn( id ) {
    if ( confirm( "해당 기간을 삭제하시겠습니까?" ) == true ) {
        $.ajax( {
            url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
            type: "POST",
            data: {
                "status" : "date_delete",
                "bo_table" : '<?=$bo_table?>',
                "id" : id
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function( data, textStatus ) {
                alert("삭제 되었습니다.");
                
                location.reload();
            },
            error: function( xhr, textStatus, errorThrown ) {
                console.error( textStatus );
            }
        } );
    } else {
        return false;
    }
}
//sms 사용 여부
$("#sms_check").change(function(){
    is_use_sms = $("#sms_check").val();
    if (is_use_sms == "") {
        $(".sms_tr").hide();
        $('#tb_sms').css("opacity","0.5");
    }else{
        $(".sms_tr").show();
        $('#tb_sms').css("opacity","1");
    }
});
//소인 유아 환경설정 여부
$("input[name=bo_2_subj]").change(function(){
    var use_count = $("input[name=bo_2_subj]:checked").val();
    
    if (use_count == "") {
        $("#kids").hide('fast');
        
    }else{
        $("#kids").show('fast');
        
    }
});

$("input[name=bo_6_subj]").change(function(){
    var pick = $("input[name=bo_6_subj]:checked").val();
    
    if (pick == "") {

        $("#pick_up").hide('fast');
        
    }else{
        $("#pick_up").show('fast');
        
    }
});

// 환경설정
function bo_set() {
    var pick_up_ch = $("input[name=bo_6_subj]:checked").val();
    if (pick_up_ch == "") {
        var $bo_6_subj_content = "";

    }else{
        var $bo_6_subj_content = $("#bo_6_subj_content").val();

    }

    var $bo_1_subj         = $("input[name=bo_1_subj]:checked").val();
    var $bo_2_subj         = $("input[name=bo_2_subj]:checked").val();
    var $bo_3_subj         = $("input[name=bo_3_subj]").val();
    var $bo_4_subj         = $("input[name=bo_4_subj]").val();
    var $bo_5_subj         = $("input[name=bo_5_subj]:checked").val();
    var $bo_7_subj         = $("input[name=bo_7_subj]:checked").val();
    var $bo_8_subj         = $("input[name=bo_8_subj]:checked").val();

    var $bo_2              = $("input[name=bo_2]").val();
    var $bo_3              = $("input[name=bo_3]:checked").val();
    var $bo_4              = $("input[name=bo_4]").val();
    var $chk_SMS           = $("input:checkbox[name='chk_SMS']").is(":checked") == true;
    var $bo_5              = $("input[name=bo_5]").val();
    var $bo_6              = $("textarea[name=bo_6]").val();
    var $bo_7              = $("textarea[name=bo_7]").val();
    var $bo_8              = $("textarea[name=bo_8]").val();
    var $bo_9              = $("input[name=bo_9]").val();
    var $bo_10             = $("input[name=bo_10]").val();
    
    var $bo_max_date       = $("select[name=bo_max_date]").val();
    
    //SMS 발송
    var $sms_check = $("#sms_check").val();
    
    var $chk_resev_ready_adm       = $("input:checkbox[name='chk_resev_ready_adm']").is(":checked") == true;
    var $msg_resev_ready_adm       = $("textarea[name=msg_resev_ready_adm]").val();
    var $chk_resev_ready_user      = $("input:checkbox[name='chk_resev_ready_user']").is(":checked") == true;
    var $msg_resev_ready_user      = $("textarea[name=msg_resev_ready_user]").val();

    var $chk_resev_compl_adm       = $("input:checkbox[name='chk_resev_compl_adm']").is(":checked") == true;
    var $msg_resev_compl_adm       = $("textarea[name=msg_resev_compl_adm]").val();
    var $chk_resev_compl_user      = $("input:checkbox[name='chk_resev_compl_user']").is(":checked") == true;
    var $msg_resev_compl_user      = $("textarea[name=msg_resev_compl_user]").val();

    var $chk_resev_cancel_req_adm  = $("input:checkbox[name='chk_resev_cancel_req_adm']").is(":checked") == true;
    var $msg_resev_cancel_req_adm  = $("textarea[name=msg_resev_cancel_req_adm]").val();
    var $chk_resev_cancel_req_user = $("input:checkbox[name='chk_resev_cancel_req_user']").is(":checked") == true;
    var $msg_resev_cancel_req_user = $("textarea[name=msg_resev_cancel_req_user]").val();

    var $chk_resev_cancel_res_adm  = $("input:checkbox[name='chk_resev_cancel_res_adm']").is(":checked") == true;
    var $msg_resev_cancel_res_adm  = $("textarea[name=msg_resev_cancel_res_adm]").val();
    var $chk_resev_cancel_res_user = $("input:checkbox[name='chk_resev_cancel_res_user']").is(":checked") == true;
    var $msg_resev_cancel_res_user = $("textarea[name=msg_resev_cancel_res_user]").val();

    //Email 발송 내용
    var $is_mail = $("#email_check").val();
    var $mail_id = $("input[name=mail_id]").val();
    var $mail_pass = $("input[name=mail_pass]").val();
    var $mail_ad = $("input[name=mail_ad]").val();
    var $mail_text = $("textarea[name=mail_text]").val();
    var $mail_text2 = $("textarea[name=mail_text2]").val();
    var $mail_user_chk = $("#user_email:checked").val();
    var $mail_adm_chk = $("#admin_email:checked").val();
    var $pay_for_pet = "";
    if ($('#is_pay_for_pet').prop("checked")) {
        $pay_for_pet = $('#pay_for_pet').val();
    }
    
    
    $.ajax( {
        url: "<?=$board_skin_url?>/ajax/ajax_booking.php?ver=20201008",
        type: "POST",
        data: {
            "status"    : "settings",
            "bo_table"  : '<?=$bo_table?>',
            "bor_table" : '<?=$board['bo_1']?>',
            "bo_1_subj" : $bo_1_subj,
            "bo_2_subj" : $bo_2_subj,
            "bo_3_subj" : $bo_3_subj,
            "bo_4_subj" : $bo_4_subj,
            "bo_5_subj" : $bo_5_subj,
            "bo_6_subj" : $bo_6_subj_content,
            "bo_7_subj" : $bo_7_subj,
            "bo_8_subj" : $bo_8_subj,
            "bo_1"      : "<?php echo $board['bo_1'];?>",
            "bo_2"      : $bo_2,
            "bo_3"      : $bo_3,
            "bo_4"      : $bo_4,
            "chk_SMS"   : $chk_SMS,
            "bo_5"      : $bo_5,
            "bo_6"      : $bo_6,
            "bo_7"      : $bo_7,
            "bo_8"      : $bo_8,
            "bo_9"      : $bo_9,
            "bo_10"     : $bo_10,
            "bo_max_date" : $bo_max_date,
            "sms_check" : $sms_check,
            "chk_resev_ready_adm"       : $chk_resev_ready_adm,
            "msg_resev_ready_adm"       : $msg_resev_ready_adm,
            "chk_resev_ready_user"      : $chk_resev_ready_user,
            "msg_resev_ready_user"      : $msg_resev_ready_user,
            "chk_resev_compl_adm"       : $chk_resev_compl_adm,
            "msg_resev_compl_adm"       : $msg_resev_compl_adm,
            "chk_resev_compl_user"      : $chk_resev_compl_user,
            "msg_resev_compl_user"      : $msg_resev_compl_user,
            "chk_resev_cancel_req_adm"  : $chk_resev_cancel_req_adm,
            "msg_resev_cancel_req_adm"  : $msg_resev_cancel_req_adm,
            "chk_resev_cancel_req_user" : $chk_resev_cancel_req_user,
            "msg_resev_cancel_req_user" : $msg_resev_cancel_req_user,
            "chk_resev_cancel_res_adm"  : $chk_resev_cancel_res_adm,
            "msg_resev_cancel_res_adm"  : $msg_resev_cancel_res_adm,
            "chk_resev_cancel_res_user" : $chk_resev_cancel_res_user,
            "msg_resev_cancel_res_user" : $msg_resev_cancel_res_user,
            "is_mail"                   : $is_mail,
            "mail_id"                   : $mail_id,
            "mail_pass"                 : $mail_pass,
            "mail_ad"                   : $mail_ad,
            "mail_text"                 : $mail_text,
            "mail_text2"                : $mail_text2,
            "mail_user_chk"             : $mail_user_chk,
            "mail_adm_chk"              : $mail_adm_chk,
            "pay_for_pet"               : $pay_for_pet
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function( data, textStatus ) {
            alert("수정되었습니다.");
            location.reload();

        },
        error: function( xhr, textStatus, errorThrown ) {
            console.error( textStatus );
        }
    } );
    
}
/////////////////modal ////////////////////////////////////

</script>