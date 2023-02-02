<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$fName = "sms"; // 중복되는 값 걸러내기 위해 파일명 변수 등록

if(@$config['cf_nct_sms_id'] && @$config['cf_nct_sms_key']){
	$info = parse_url("http://sms.nccj.kr/api/remind_count/".$config['cf_nct_sms_id']."/".$config['cf_nct_sms_key']);

	$fp = fsockopen($info['host'], 80);
	if($fp){
		$remindCountResult = "0";
		$parm = "";
		$send = "POST " . $info["path"] . " HTTP/1.1\r\n"
		."Host: " . $info["host"] . "\r\n"
		. "Content-type: application/x-www-form-urlencoded\r\n"
		. "Content-length: " . strlen($parm) . "\r\n"
		. "Connection: close\r\n\r\n" . $parm."\r\n";

		fputs($fp, $send);
		
		while(!feof($fp)) $remindCountResult = fgets($fp, 128);

		$remindResult = json_decode($remindCountResult);
		$remindCount = $remindResult->remind_count;
	}		   
}

$sql = "select mta_key, mta_value from g5_5_meta where mta_db_table = 'board/".$bo_table."' and mta_db_id = 'sms_setting' order by mta_idx desc";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
	$mta[$row["mta_key"]] = $row["mta_value"];
?>

<div id="set_sms_table">
	
	<form name="sms_frm" id="sms_frm" onsubmit="return sms_write(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="u">
	<input type="hidden" name="bo_table" value="<?=$bo_table?>">
	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>SMS 설정</caption>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<thead>
		<tr>
			<th scope="row" style="width:35%;"></th>
			<th scope="row" style="width:65%;"></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_nct_sms_use">SMS 사용설정</label></th>
			<td>
				<select id="cf_nct_sms_use" name="cf_nct_sms_use">
					<option value="" <?php echo get_selected($config['cf_nct_sms_use'], ''); ?>>사용안함</option>
					<option value="uplus" <?php echo get_selected($config['cf_nct_sms_use'], 'uplus'); ?>>유플러스</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_nct_sms_id">SMS 아이디</label></th>
			<td>
				<input type="text" name="cf_nct_sms_id" value="<?php echo $config['cf_nct_sms_id']; ?>" id="cf_nct_sms_id" class="frm_input" size="20">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_nct_sms_key">SMS 키값</label></th>
			<td>
				<input type="text" name="cf_nct_sms_key" value="<?php echo $config['cf_nct_sms_key']; ?>" id="cf_nct_sms_key" class="frm_input" size="50">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_nct_sms_sendnum">관리자 전화번호<br>(SMS 관리자 등록용 번호)</label></th>
			<td>
				<input type="text" name="cf_nct_sms_sendnum" value="<?php echo $config['cf_nct_sms_sendnum']; ?>" id="cf_nct_sms_sendnum" class="frm_input">
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="cf_nct_sms_num">발신전화번호<br>(발송할 때 번호)</label></th>
			<td>
				<input type="text" name="cf_nct_sms_num" value="<?php echo $config['cf_nct_sms_num']; ?>" id="cf_nct_sms_num" class="frm_input">
			</td>
		</tr>
		<tr>
			<th scope="row">충전 잔여량</th>
			<td colspan="3">
				<?=$remindCount?>
			</td>
		</tr>
		</tbody>
		</table>
	</div>


	<div class="tbl_frm01 tbl_wrap">
		<table id="sms_table">
		<caption>SMS발송 설정</caption>
		<colgroup>
			<col class="grid_5">
			<col>
		</colgroup>
		<thead>
		<tr>
			<th scope="row" style="width:16%;"></th>
			<th scope="row" style="width:42%;"></th>
			<th scope="row" style="width:42%;"></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th scope="row" colspan="3" style="height:50px;">SMS발송 메세지 여부 및 문구 설정</th>
		</tr>
		<tr>
			<td colspan="3">
				<strong>[TIP]</strong> 발송 여부 및 문구 설정시 <br><br>
				<font style="color:red;">※ 전송내용에 있는 각 변수 들은 아래와 같습니다.<br />
				<b>예약자명 : {name}<br />
				예약일자 : {date}<br />
				선박종류 : {type}<br />
				요금합계 : {price}<br />
				전화번호 : {hp}<br /></b><br />
				※ 변수 이외의 문구들은 직접 설정이 가능합니다. <br>
				※ SMS 서비스는 80 byte 길이 까지만 지원합니다. (한글 기준 약 40자) <br><br></font>
				ex) [관리자] {name}님 {type}  {date} 예약이 접수되었습니다. <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[사용자] {name}님 {type} 예약접수 완료 공지사황 확인 부탁드립니다.
			</td>
		</tr>
		<tr>
			<th scope="row">SMS발송 여부 설정</th>
			<td colspan="3">
				<?php // echo help("예약시 SMS발송여부를 설정합니다.\n사용할 경우 SMS발송메세지를 반드시 입력하여 주십시오.", 50); ?>
				<select id="pn_pg_sms_use" name="pn_pg_sms_use">
					<option value="0" <?php if($mta['pn_pg_sms_use'] == "0") echo "selected"; ?>>사용안함</option>
					<option value="1" <?php if($mta['pn_pg_sms_use'] == "1") echo "selected"; ?>>사용</option>
				</select>
			</td>
		</tr>
		<tr class="sms_dis_table">
			<th scope="row">예약시</th>
			<td>
				<input type="checkbox" name="pn_sms_reserv_ready_adm" id="pn_sms_reserv_ready_adm" value="1" <?php echo ( $mta['pn_sms_reserv_ready_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
				<div >ex) 예약이 접수되었습니다.</div>
				<textarea name="pn_sms_reserv_ready_adm_info" id="pn_sms_reserv_ready_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_ready_adm_info']; ?></textarea>
			</td>
			<td>
				<input type="checkbox" name="pn_sms_reserv_ready_user" id="pn_sms_reserv_ready_user" value="1" <?php echo ( $mta['pn_sms_reserv_ready_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
				<div >ex) 예약이 접수되었습니다.</div>

				<textarea name="pn_sms_reserv_ready_user_info" id="pn_sms_reserv_ready_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_ready_user_info']; ?></textarea>
			</td>
		</tr>
		<tr class="sms_dis_table">
			<th scope="row">예약 완료시</th>
			<td>
				<input type="checkbox" name="pn_sms_reserv_comp_adm" id="pn_sms_reserv_comp_adm" value="1" <?php echo ( $mta['pn_sms_reserv_comp_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
				<div >ex) 예약이 완료 되었습니다.</div>

				<textarea name="pn_sms_reserv_comp_adm_info" id="pn_sms_reserv_comp_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_comp_adm_info']; ?></textarea>
			</td>
			<td>
				<input type="checkbox" name="pn_sms_reserv_comp_user" id="pn_sms_reserv_comp_user" value="1" <?php echo ( $mta['pn_sms_reserv_comp_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
				<div >ex) 예약이 완료 되었습니다.</div>

				<textarea name="pn_sms_reserv_comp_user_info" id="pn_sms_reserv_comp_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_comp_user_info']; ?></textarea>
			</td>
		</tr>
		<tr class="sms_dis_table">
			<th scope="row">취소 요청시</th>
			<td>
				<input type="checkbox" name="pn_sms_reserv_canc_adm" id="pn_sms_reserv_canc_adm" value="1" <?php echo ( $mta['pn_sms_reserv_canc_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
				<div >ex) 예약이 취소요청 되었습니다.</div>

				<textarea name="pn_sms_reserv_canc_adm_info" id="pn_sms_reserv_canc_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_adm_info']; ?></textarea>
			</td>
			<td>
				<input type="checkbox" name="pn_sms_reserv_canc_user" id="pn_sms_reserv_canc_user" value="1" <?php echo ( $mta['pn_sms_reserv_canc_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
				<div >ex) 예약이 취소요청 되었습니다.</div>

				<textarea name="pn_sms_reserv_canc_user_info" id="pn_sms_reserv_canc_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_user_info']; ?></textarea>
			</td>
		</tr>
		<tr class="sms_dis_table">
			<th scope="row">취소 완료시</th>
			<td>
				<input type="checkbox" name="pn_sms_reserv_canc_cplt_adm" id="pn_sms_reserv_canc_cplt_adm" value="1" <?php echo ( $mta['pn_sms_reserv_canc_cplt_adm'] ) ?  "checked" :  ""?>> <strong>관리자</strong> <br><br>
				<div >ex) 예약이 취소완료 되었습니다.</div>

				<textarea name="pn_sms_reserv_canc_cplt_adm_info" id="pn_sms_reserv_canc_cplt_adm_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_cplt_adm_info']; ?></textarea>
			</td>
			<td>
				<input type="checkbox" name="pn_sms_reserv_canc_cplt_user" id="pn_sms_reserv_canc_cplt_user" value="1" <?php echo ( $mta['pn_sms_reserv_canc_cplt_user'] ) ?  "checked" :  ""?>> <strong>예약자</strong> <br><br>
				<div >ex) 예약이 취소완료 되었습니다.</div>

				<textarea name="pn_sms_reserv_canc_cplt_user_info" id="pn_sms_reserv_canc_cplt_user_info" style="height:60px; resize: none;"><?php echo $mta['pn_sms_reserv_canc_cplt_user_info']; ?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</div>



	<p>
		<input type="submit" class="btn btn-primary btn-block" value="설정완료">
	</p>
	
	</form>

	<div style="clear:both;"></div>

</div>

<script>	
var $board_skin_url = "<?php echo $board_skin_url; ?>";

$(document).ready(function() {
	var state = $('#pn_pg_sms_use option:selected').val();
	if(state == '0') {
		$('.sms_dis_table').hide();
		$('#sms_table').css("opacity","0.5");
	} else {
		$('.sms_dis_table').show();
		$('#sms_table').css("opacity","1");
	}

	$('#pn_pg_sms_use').change(function() {
		var state = $('#pn_pg_sms_use option:selected').val();
		if(state == '0') {
			$('.sms_dis_table').hide();
			$('#sms_table').css("opacity","0.5");
		} else {
			$('.sms_dis_table').show();
			$('#sms_table').css("opacity","1");
		}
	});
});

function sms_write(f) {

	var params = jQuery("#sms_frm").serialize();

	if ( confirm( "선택한 데이터를 수정하시겠습니까?" ) == true ) {
		$.ajax( {
				url: $board_skin_url + "/ajax/ajax.<?=$fName?>.php",
				type: "POST",
				data: params,
				success: function( data, textStatus ) {
					alert( '정보가 수정 되었습니다.' );
					//console.log( data );
					//$( '#<?php echo $fName; ?>_op_'+id ).number( true );
					//alert( '정보가 수정 되었습니다.' );
				},
				error: function( xhr, textStatus, errorThrown ) {
					console.error( xhr );
				}
		} );
	} else {
		return false;
	}

	return false;
}

</script>