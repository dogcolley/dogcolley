<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$rDate = $_GET['rDate'];
$rShip = $_GET['rShip'];
$write = $_GET['write'];
$wr_id = $_GET['wr_id'];
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

<div id="notiform">
	
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="wr_2" id="resDate" value="<?=$rDate?>"/>
	<input type="hidden" name="wr_3" id="resShip" value="<?=$rShip?>"/>
	<input type="hidden" name="ca_name" id="ca_name" value="공지"/>
	<input type="hidden" name="wr_content" id="wr_content" value="."/>
    <input type="hidden" name="bo_edit" value="<?php echo $write ?>">
    <input type="hidden" name="upd" value="">
    <input type="hidden" name="ca" value="">
    <input type="hidden" name="date" value="">
    <input type="hidden" name="dToken" value="<?=$dToken?>">

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
					<th>공지내용</th>
					<td><input type="text" name="wr_subject" id="wr_subject" required class="frm_input required" <? if($row[wr_subject]) { ?>value="<?=$row[wr_subject];?>"<? }else{ ?>value="<?=$wr_subject;?>"<? } ?> maxlength="255"></td>
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

	<p><input type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-block" <? if($row) { ?>value="수정하기"<?}else{?>value="등록하기"<? } ?>></p>
	<? if($row && $member[mb_level] >= 8) { ?>
	<p style="margin:5px 0;"><input type="submit" id="btn_submit" accesskey="s" class="btn btn-danger btn-block" value="삭제하기" onclick="document.pressed=this.value"></p>
	<? } ?>

	</form>

</div>

<script src="<?=$board_skin_url?>/js/jquery.number.min.js"></script>
<script>	
$( '.num_' ).number( true );
var $board_skin_url = "<?php echo $board_skin_url; ?>";


function fwrite_submit(f)
{	
	if(document.pressed == "삭제하기") {

        if (!confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?"))
            return false;
		
		f.upd.value = "<?php echo $del ?>";
		f.date.value = "<?php echo $rDate ?>";
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }

	if(document.pressed == "수정하기") {
		f.upd.value = "<?php echo $ca ?>";
		f.ca.value = "수정하기";
		f.date.value = "<?php echo $rDate ?>";
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>