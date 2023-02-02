<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$fName = "type"; // 중복되는 값 걸러내기 위해 파일명 변수 등록
$bNum = "bo_2"; // 현재 페이지에서 사용되는 bo 여분필드 명
?>

<div id="setform">
	
	
	<div class="form-group list">
		<p><label><i class="fa fa-krw" aria-hidden="true"></i> 낚시종류</label></p>
		<p style="margin-left: 15px; margin-right: 15px;"><label><i class="fa fa-krw" aria-hidden="true"></i> 1인금액</label></p>
		<p style="margin-left: 15px; margin-right: 15px;"><label><i class="fa fa-krw" aria-hidden="true"></i> 1인예약금</label></p>
		<p><label><i class="fa fa-krw" aria-hidden="true"></i> 독배로 사용</label></p>
	</div>

	<div style="clear:both;"></div>

	<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">
	
	<div style="clear:both;"></div>

	<div class="form-group list">
		<p style="color:#ec0000;">- <b>[선박관리]</b>에서 <b>[독배사용]</b>에 체크되어있어야 사용 가능합니다.</p>
		<p style="color:#ec0000;">- <b>[독배사용]</b>을 선택하면 인원에 상관없이 <b>[1인금액]</b>으로 표시됩니다.</p>
		<p style="color:#ec0000;">- 독배가 체크되어 있지 않은 선박이라면 독배사용 옵션은 예약할때 표시되지 않습니다.</p>
		<p style="color:#ec0000;">- <b>[독배]</b>가 체크된 옵션을 <b>[예약신청]</b>하면 해당 날짜는 <b>[자동마감]</b> 됩니다.</p>
	</div>

	<div style="clear:both;"></div>

	<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">

	<div style="clear:both;"></div>

	<? // 리스트 (루프) { ?>
	<?php
	$bo_arr = explode(";", $board[$bNum]);
	
	for ( $i = 0; $i < count( $bo_arr )-1; $i++ ) { 
		$V_arr = explode("|", $bo_arr[$i]);
	?>
	<div class="form-group list list_each" id="<?=$fName?>_<?=$V_arr[0]?>">
		<p><input type="hidden" name="start" value="start"></p>
		<p><input type="text" class="form-control" id="<?=$fName?>_name_<?=$V_arr[0]?>" placeholder="낚시종류" size="15" value="<?=$V_arr[1]?>" readonly></p>
		<p style="margin-left: 15px; margin-right: 15px;"><input type="text" class="form-control num_" id="<?=$fName?>_op_<?=$V_arr[0]?>" placeholder="1인금액" size="5" value="<?=$V_arr[2]?>"></p>
		<p style="margin-right: 15px;"><input type="text" class="form-control num_" id="<?=$fName?>_op2_<?=$V_arr[0]?>" placeholder="1인예약금" size="5" value="<?=$V_arr[3]?>"></p>
		<p style="margin-right: 15px;"><label><input type="checkbox" class="form-check-input num_" id="<?=$fName?>_op3_<?=$V_arr[0]?>" value="1" <? if($V_arr[4] == 1) echo "checked"; ?>> 독배로 사용</label></p>
		<p><input type="hidden" name="end" value="end"></p>
		<div style="clear:both;"></div>
		<div style="margin:4px 0 7px 0;">
			<!--<input type="button" class="btn btn-default" value="수정" onclick="<?=$fName?>_edit(<?=$V_arr[0]?>, <?=$i?>)">-->
			<input type="button" id="" class="btn btn-danger <?=$fName?>_del" value="삭제" >
		</div>
		<div style="clear:both;"></div>
		<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">
		<div style="clear:both;"></div>
	</div>
	
	<?php } ?>
	<? // } 리스트 ?>

	<div style="clear:both;"></div>

	<form class="form-group list" id="<?=$fName?>_add" name="fwrite" id="fwrite" method="post" onsubmit="return false;">
		<p><input type="hidden" name="start" value="start"></p>
		<p><input type="text" name="<?=$fName?>_bo1" class="form-control" id="<?=$fName?>_bo1" placeholder="낚시종류" size="15"></p>
		<p style="margin-left: 15px; margin-right: 15px;"><input type="text" name="<?=$fName?>_bo2" class="form-control num_" id="<?=$fName?>_bo2" placeholder="1인금액" size="5">(숫자만)</p>
		<p style="margin-right: 15px;"><input type="text" name="<?=$fName?>_bo3" class="form-control num_" id="<?=$fName?>_bo3" placeholder="1인예약금" size="5">(숫자만)</p>
		<p style="margin-right: 15px;"><label><input type="checkbox" name="<?=$fName?>_bo4" class="form-check-input num_" id="<?=$fName?>_bo4" value="1"> 독배로 사용</label></p>
		<p><input type="hidden" name="end" value="end"></p>
		<p><input type="button" id="<?=$fName?>_btn_add" class="btn btn-primary btn-block" value="추가"></p>
	</form>

</div>

<script src="<?=$board_skin_url?>/js/jquery.number.min.js"></script>
<script>	
$( '.num_' ).number( true );
var $board_skin_url = "<?php echo $board_skin_url; ?>";

$( '#<?php echo $fName; ?>_bo1, #<?php echo $fName; ?>_bo2, #<?php echo $fName; ?>_bo3' ).keydown(function (e) {
	if (e.keyCode == 13) {
		e.preventDefault();
		$( '#<?php echo $fName; ?>_btn_add' ).click();
	}
});

$(document).ready(function(){
	$( '#typeList #all_typeList' ).on('click', function(e){
		e.preventDefault();
		var eValue = '';
		var uid = "<?php echo get_uniqid(); ?>";
		var t = $("#typeList .list_each input");

		t.each(function(i){
			
			if( t.eq(i)[0].type  != "button" ) {
				
				if(t.eq(i).val() == "start") {
					eValue += uid + "|";
				}
				if( t.eq(i)[0].type  == "checkbox" ) {
					if (t.eq(i).is(":checked") == true) {
						eValue += 1 + "|";
					}else{
						eValue += 0 + "|";
					}
				}else{
					if(t.eq(i).val() != "start" && t.eq(i).val() != "end") {
						eValue += t.eq(i).val() + "|";
					}
				}

				if(t.eq(i).val() != "start" && t.eq(i).val() == "end") {
					eValue += ";";
				}

			}

		});
		
		if ( confirm( "데이터를 전체 수정하시겠습니까?" ) == true ) {
			$.ajax( {
					url: $board_skin_url + "/ajax/ajax.<?=$fName?>.php",
					type: "POST",
					data: {
						"w" : "u",
						"bo_table" : '<?=$bo_table?>',
						"bNum" : '<?=$bNum?>',
						"value": eValue
					},
					dataType: "json",
					async: false,
					cache: false,
					success: function( data, textStatus ) {

						console.log( data );
						//$( '#<?php echo $fName; ?>_op_'+id ).number( true );
						alert( '정보가 수정 되었습니다.' );
					},
					error: function( xhr, textStatus, errorThrown ) {
						console.error( xhr );
					}
			} );
		}

	});
});

$( '#<?php echo $fName; ?>_btn_add' ).click( function () {
	
	var $bo1 = $( '#<?php echo $fName ?>_bo1' ).val();
	var $bo2 = $( '#<?php echo $fName ?>_bo2' ).val();
	var $bo3 = $( '#<?php echo $fName ?>_bo3' ).val();
	var $bo4 = $( '#<?php echo $fName ?>_bo4' ).is(":checked");
	
	if($bo4 == true) {
		$bo4 = 1;
	}else{
		$bo4 = 0;
	}
	if($bo4 == 1) {
		var chkd = 'checked';
	}


	if ( $bo1 == '' ) {
		alert( '낚시종류를 입력해 주세요.' );
		$( '#<?php echo $fName ?>_bo1' ).focus();
		return false;
	} else if ( $bo2 == '' || $bo2 == 0	) {
		alert( '1인금액을 입력해 주세요.' );
		$( '#<?php echo $fName ?>_bo2' ).focus();
		return false;
	} else if ( $bo3 == '' || $bo3 == 0	) {
		alert( '1인예약금을 입력해 주세요.' );
		$( '#<?php echo $fName ?>_bo3' ).focus();
		return false;
	} else {
		var uid = "<?php echo get_uniqid(); ?>";
		
		var appendCon = '<div class="form-group list list_each" id="<?php echo $fName; ?>_'+uid+'">';
		appendCon += '<p><input type="hidden" name="start" value="start"></p>';
		appendCon += '<p style=""><input type="text" class="form-control" id="<?php echo $fName; ?>_name_'+uid+'" placeholder="낚시종류" size="15" value="'+$bo1+'" readonly></p>';
		appendCon += '<p style="margin-left: 15px; margin-right: 15px;"><input type="text" class="form-control num_" id="<?php echo $fName; ?>_op_'+uid+'" placeholder="1인금액" size="5" value="'+$bo2+'"></p>';
		appendCon += '<p style="margin-right: 15px;"><input type="text" class="form-control num_" id="<?php echo $fName; ?>_op2_'+uid+'" placeholder="1인예약금" size="5" value="'+$bo3+'"></p>';

		appendCon += '<p style="margin-right: 15px;"><label><input type="checkbox" class="form-check-input num_" id="<?php echo $fName; ?>_op3_'+uid+'" value="'+$bo4+'" ' + chkd + '> 독배로 사용</label></p>';

		//appendCon += '<p><input type="button" class="btn btn-default" value="수정" style="padding: 6px 11px;" onclick="<?php echo $fName; ?>_edit('+uid+')"> ';
		
		appendCon += '<p><input type="hidden" name="end" value="end"></p>';
		appendCon += '<div style="clear:both;"></div>';
		appendCon += '<div style="margin:4px 0 7px 0;"><input type="button" class="btn btn-danger <?=$fName?>_del" value="삭제" id=""></div>';
		appendCon += '<div style="clear:both;"></div>';
		appendCon += '<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">';
		appendCon += '<div style="clear:both;"></div>';
		appendCon += '</div>';

		alert('추가 후 일괄수정해야 적용됩니다.');

		$( '#<?php echo $fName ?>_bo1' ).val('');
		$( '#<?php echo $fName ?>_bo2' ).val('');
		$( '#<?php echo $fName ?>_bo3' ).val('');
		$( '#<?php echo $fName ?>_bo4' ).prop("checked", false);
		$( '#<?php echo $fName; ?>_add' ).before( appendCon );
		
	}
} );

$('#typeList ').on('click', '.<?php echo $fName?>_del', function(e) {
	e.preventDefault();
	
	if(confirm('삭제 후 일괄수정해야 적용됩니다.') == true) {
		var n = $('#typeList .<?php echo $fName?>_del').index(this);

		$("#typeList .list_each").each(function(i){
			if(n == i){
				$(this).remove();
			}
		});
	}

	//console.log(n);
});
</script>