<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$fName = "privacy"; // 중복되는 값 걸러내기 위해 파일명 변수 등록
?>

<div id="set_pri_table">
	
	<form name="pri_frm" id="pri_frm" onsubmit="return pri_write(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="u">
	<input type="hidden" name="bo_table" value="<?=$bo_table?>">
	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>약관 설정</caption>
		<thead>
		<tr>
			<th scope="row" style="width:30%;"></th>
			<th scope="row" style="width:70%;"></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th scope="row"><label for="privacy_1">개인정보 수집</label></th>
			<td>
				<textarea name="privacy_1" id="privacy_1" class="frm_input"><?php echo $board['bo_9']; ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="privacy_2">개인정보 제공</label></th>
			<td>
				<textarea name="privacy_2" id="privacy_2" class="frm_input"><?php echo $board['bo_10']; ?></textarea>
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


function pri_write(f) {

	var params = jQuery("#pri_frm").serialize();

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