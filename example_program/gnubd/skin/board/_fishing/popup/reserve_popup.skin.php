<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$rDate = $_GET['rDate'];
$rShip = $_GET['rShip'];
$rCnt = $_GET['rCnt'];
$write = $_GET['write'];
$wr_id = $_GET['wr_id'];
$total_per = $_GET['tper'];
$ca_name = $_GET['cname'];
$cntShip = $_GET['cntShip'];

$write_table = $g5['write_prefix'] . $bo_table;

if($write == "u" && !$row) {
	$row = get_write($write_table, $wr_id);
	$w = "u";
	$del = "d";
	$ca = "ca";
	set_session('ss_bo_table', $bo_table);
	set_session('ss_wr_id', $wr_id);
	set_session('ss_delete_token', $dToken = uniqid(time()));
}

$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$captcha_html = '';
$captcha_js   = '';
if ($is_guest) {
    $captcha_html = captcha_html();
    $captcha_js   = chk_captcha_js();
}

$token = get_session('ss_write_'.$bo_table.'_token');
set_session('ss_write_'.$bo_table.'_token', '');

$vew_month = $rDate;
$curr_year = date( 'Y' );

unset($arr_db);
$arr_db = array();
?>

<div id="resform">
	
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="wr_2" id="resDate" value="<?=$rDate?>"/>
	<input type="hidden" name="wr_3" id="resShip" value="<?=$rShip?>"/>
	<input type="hidden" name="wr_9" id="dokChk" value=""/>
	<? if($ca_name == "예약완료") { ?>
	<input type="hidden" name="ca_name" id="ca_name" value="예약완료"/>
	<? }else if($ca_name == "취소요청") { ?>
	<input type="hidden" name="ca_name" id="ca_name" value="취소요청"/>
	<? }else if($ca_name == "취소완료") { ?>
	<input type="hidden" name="ca_name" id="ca_name" value="취소완료"/>
	<? }else{ ?>
	<input type="hidden" name="ca_name" id="ca_name" value="예약대기"/>
	<? } ?>
	<input type="hidden" name="wr_subject" id="wr_subject" value="예약신청"/>
    <input type="hidden" name="bo_edit" value="<?php echo $write ?>">
    <input type="hidden" name="total_per" value="<?=$rCnt?>">
    <input type="hidden" name="upd" value="">
    <input type="hidden" name="ca" value="">
    <input type="hidden" name="date" value="">
    <input type="hidden" name="dToken" value="<?=$dToken?>">
	
	<!-- PC 화면 리스트 [시작] -->
		<div class="cal_list">
			<table class="table table-sm table-bordered">
				<tbody>
					<tr>
						<th>예약날짜</th>
						<td><?=$rDate?></td>
					</tr>
					<tr>
						<th>선박종류</th>
						<td><?=$rShip?></td>
					</tr>
					<tr>
						<th>예약자명</th>
						<td><input type="text" name="wr_name" id="wr_name" required class="frm_input required" <? if($row[wr_name]) { ?>value="<?=$row[wr_name];?>"<? }else{ ?>value="<?=$wr_name;?>"<? } ?> maxlength="30" placeholder="예약자명"></td>
					</tr>
					<tr>
						<th>입금자명</th>
						<td><input type="text" name="wr_1" id="wr_1" required class="frm_input required" <? if($row[wr_1]) { ?>value="<?=$row[wr_1];?>"<? }else{ ?>value="<?=$wr_1;?>"<? } ?> maxlength="30" placeholder="입금자명"></td>
					</tr>
					<tr>
						<th>연락처</th>
						<td><input type="text" name="wr_4" id="wr_4" required class="frm_input required" <? if($row[wr_4]) { ?>value="<?=$row[wr_4];?>"<? }else{ ?>value="<?=$wr_4;?>"<? } ?> maxlength="14" placeholder="연락처 (-) 없이 입력" onkeydown="onlyNumber(this)"> (-) 없이 입력</td>
					</tr>
					<tr>
						<th>요청사항</th>
						<td><textarea name="wr_content" id="wr_content" class="frm_input" style="min-height:70px;"><? if($row[wr_content]) { ?><?=$row[wr_content];?><? }else{ ?><?=$wr_content;?><? } ?></textarea></td>
					</tr>
					<tr>
						<th>인원선택</th>
						<td>
							<?php

								$p_cnt = 0;
								
								$sql = "select * from {$write_table} where wr_2 = '".$vew_month."' and wr_3 = '".$rShip."' and (ca_name != '공지' and ca_name not like '%취소%')";
								$res = sql_query($sql);

								while($aRow = sql_fetch_array($res)) {
									$arr_db[$aRow['wr_2']][] = $aRow;
								}
								if ($res) sql_free_result($res);

								$cnt_db = count($arr_db[$rDate]);
								
								
								for ($z=0; $z < $cnt_db; $z++) {

									if($arr_db[$rDate][$z][wr_6] && $arr_db[$rDate][$z]['wr_3'] == $rShip){
										$p_cnt += ($arr_db[$rDate][$z]['wr_6']);
									}

								}
								
								$cnt = $rCnt-$p_cnt;
									
								if($row[wr_6]) {

									echo "<select id='wr_6' name='wr_6' required class='required'>";
									echo "<option value=''>선택해주세요.</option>";
									for($k=1; $k < ($row[wr_6]+$cnt+1); $k++) {
										$selected = "";
										if($row[wr_6] == $k) {
											$selected = "selected";
										}
										echo "<option value='".$k."' {$selected}>".$k."명</option>";
									}
									echo "</select>";

								}else{

									echo "<select id='wr_6' name='wr_6' required class='required'>";
									echo "<option value=''>선택해주세요.</option>";
									for($k=1; $k < $cnt+1; $k++) {
										echo "<option value='".$k."' {$selected}>".$k."명</option>";
									}
									echo "</select>";

								}

							?>
						</td>
					</tr>
					<tr>
						<th>옵션선택</th>
						<td>
							<table class="table table-bordered">
								<thead class="thead-dark">
								<tr>
									<th><b>선택</b></th>
									<th><b>종류</b></th>
								</tr>
								</thead>

								<tbody>
								<?php
								$bRow = sql_fetch("select bo_1, bo_2 from {$g5['board_table']} where bo_table = '{$bo_table}'");
								$bArr = explode(";", $bRow[bo_2]);
								$bArr2 = explode(";", $bRow[bo_1]);
								
								// 독배인지 확인
								$dokCheck = explode("|", $bArr2[$cntShip]);

								if(count($bArr) == 1) {
									echo "<tr><td colspan='2'>관리자가 옵션을 설정하지 않았습니다.</td></tr>";
								}

								for($i=0; $i<count($bArr)-1; $i++) {
									$sArr = explode("|", $bArr[$i]);
									$dokbae = false;
									if($sArr[4] == 1 && $dokCheck[3] == 1) { $dokbae = true; }
								?>
								<tr style="<?if($sArr[4] == 1 && $dokbae != true){?>display:none;<? } ?>">
									<td>
										<label><input type="radio" id="wr_5" name="wr_5" required data-id="<?=$sArr[1]?>|<?=$sArr[2]?>|<?=$sArr[3]?><? if($dokbae) { ?>|1<? } ?>" value="<?=$sArr[1]?>" <? if($row[wr_5] == $sArr[1]) echo "checked"; ?>>
										<? if($dokbae) { ?><div class="dok_txt">[독배가능]</div><? } ?>
										</label>
									</td>
									<td><span style="font-weight:700;"><?=$sArr[1]?></span><hr class="m_hr">예약금 : <span class="rev_money"><?=@number_format($sArr[3])?></span>원 <? if($dokbae) { ?><div class="dok_txt">[독배요금]</div><? } ?><hr class="m_hr">요금합계 : <span class="total_money"><?=@number_format($sArr[2])?></span>원 <? if($dokbae) { ?><div class="dok_txt">[독배요금]</div><? } ?></td>
								</tr>
								<?
								}
								?>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<th>예약금</th>
						<td>
						<? if($row[wr_8]) { ?>
						<span id="wr_8_text" class="rev_money"><?=@number_format($row[wr_8])?></span><input type="hidden" name="wr_8" id="wr_8_total" class="frm_input" value="<?=$row[wr_8];?>" maxlength="30" readonly size="8" style="width:auto;">원
						<? }else{ ?>
						<span id="wr_8_text" class="rev_money">0</span><input type="hidden" name="wr_8" id="wr_8_total" class="frm_input" value="<?=$wr_8;?>" maxlength="30" readonly size="8" style="width:auto;">원
						<? } ?>
						</td>
					</tr>
					<tr>
						<th>요금합계</th>
						<td>
						<? if($row[wr_7]) { ?>
						<span id="wr_7_text" class="total_money"><?=@number_format($row[wr_7])?></span><input type="hidden" name="wr_7" id="wr_7_total" class="frm_input" value="<?=$row[wr_7];?>" maxlength="30" readonly size="8" style="width:auto;">원
						<? }else{ ?>
						<span id="wr_7_text" class="total_money">0</span><input type="hidden" name="wr_7" id="wr_7_total" class="frm_input" value="<?=$wr_7;?>" maxlength="30" readonly size="8" style="width:auto;">원
						<? } ?>
						</td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>비밀번호는 휴대폰번호로 자동 저장됩니다.</td>
					</tr>

					<tr>
						<th>개인정보취급방침</th>
						<td>
							<div class="info" style="padding-bottom:5px;">
								<h4>개인정보 수집 및 이용 동의서</h4>
								<div class="scr">
									<?php echo nl2br($board['bo_9']);?>
								</div>
								<p align="left">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="chk_agree1" <? if($member[mb_level] >= 8 || $w != "") { ?>checked<? } ?>><span class="icon"></span>개인정보 수집/활용에 동의 합니다
										</label>
									</div>
								</p>
							</div>
							<div class="info">
								<h4>개인정보 제 3자 이용 동의서</h4>
								<div class="scr">
									<?php echo nl2br($board['bo_10']);?>
								</div>
								<p align="left">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="chk_agree2" <? if($member[mb_level] >= 8 || $w != "") { ?>checked<? } ?>><span class="icon"></span>개인정보 제 3자 활용에 동의합니다
										</label>
									</div>
								</p>
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

		<p><input type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-block" <? if($row) { ?>value="수정하기"<?}else{?>value="예약신청"<? } ?>></p>

		<? if($row && $member[mb_level] >= 8) { ?>
		<!--
		<p style="margin:5px 0;"><input type="submit" id="btn_submit" accesskey="s" class="btn btn-info btn-block" <? if($row[ca_name] == "예약대기") { ?>value="예약완료처리"<? }else{ ?>value="예약대기처리"<? } ?> onclick="document.pressed=this.value"></p>
		-->
		<p style="margin:5px 0;"><input type="submit" id="btn_submit" accesskey="s" class="btn btn-danger btn-block" value="삭제하기" onclick="document.pressed=this.value"></p>
		<? } ?>

	<!-- PC 화면 리스트 [끝] -->



	</form>

</div>

<script src="<?=$board_skin_url?>/js/jquery.number.min.js"></script>
<script>	
$( '.num_' ).number( true );
var $board_skin_url = "<?php echo $board_skin_url; ?>";

function onlyNumber(obj) {
    $(obj).keyup(function(){
         $(this).val($(this).val().replace(/[^0-9]/g,""));
    }); 
}


function fwrite_submit(f)
{	
	if (!f.chk_agree1.checked || !f.chk_agree2.checked){
		alert("개인정보 사항에 체크하셔야 합니다.");
		f.chk_agree1.focus();
		return false;
	}


	if(!f.wr_content.value) {
		f.wr_content.value = ".";
	}

	if(document.pressed == "삭제하기") {

        if (!confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?"))
            return false;
		
		f.upd.value = "<?php echo $del ?>";
		f.date.value = "<?php echo $rDate ?>";
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }

	if(document.pressed == "예약완료처리") {
		f.upd.value = "<?php echo $ca ?>";
		f.ca.value = "예약완료";
		f.date.value = "<?php echo $rDate ?>";
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }

	if(document.pressed == "예약대기처리") {
		f.upd.value = "<?php echo $ca ?>";
		f.ca.value = "예약대기";
		f.date.value = "<?php echo $rDate ?>";
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}

$(document).ready(function(){
	
	$("#wr_6, .wr_6").on("change", function(){

		var total = 0;
		var total_r = 0;
		
		var chk_value = $("input[name=wr_5]:checked").data('id');
		var basic = chk_value.split("|");
		
		if(basic[3] == 1) { // 독배일경우 합산 안함
			var sel_v = 1;
			total += Number(basic[1]);
			total_r += Number(basic[2]);
		}else{
			var sel_v = $("#wr_6 option:selected, .wr_6 option:selected").val();
			$("input[name=wr_5]:checked").each(function(){
				total += Number(basic[1]);
				total_r += Number(basic[2]);
			});
		}


		$("#wr_7_text, .wr_7_text").text($.number(total * sel_v));
		$("#wr_8_text, .wr_8_text").text($.number(total_r * sel_v));

		$("#wr_7_total, .wr_7_total").val(total * sel_v);
		$("#wr_8_total, .wr_8_total").val(total_r * sel_v);

	});

	$("input[name=wr_5]").on("change", function(){

		var total = 0;
		var total_r = 0;
		var basic = $("input[name=wr_5]:checked").data('id').split("|");
		
		if(basic[3] == 1) { // 독배일경우 합산 안함
			var sel_v = 1;
			total += Number(basic[1]);
			total_r += Number(basic[2]);
			$("#dokChk").val('1');
		}else{
			var sel_v = $("#wr_6 option:selected, .wr_6 option:selected").val();
			$("input[name=wr_5]:checked").each(function(){
				total += Number(basic[1]);
				total_r += Number(basic[2]);
			});
			$("#dokChk").val('');
		}

		$("#wr_7_text, .wr_7_text").text($.number(total * sel_v));
		$("#wr_8_text, .wr_8_text").text($.number(total_r * sel_v));

		$("#wr_7_total, .wr_7_total").val(total * sel_v);
		$("#wr_8_total, .wr_8_total").val(total_r * sel_v);
	});

});

</script>