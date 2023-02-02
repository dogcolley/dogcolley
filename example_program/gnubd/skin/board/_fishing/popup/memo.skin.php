<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$fName = "memo"; // 중복되는 값 걸러내기 위해 파일명 변수 등록
$bNum = "bo_4"; // 현재 페이지에서 사용되는 bo 여분필드 명
?>

<div id="setform">
	
	<div class="form-group list">
		<p><label><i class="fa fa-krw" aria-hidden="true"></i> 예약규정 내용</label></p>
	</div>

	<div style="clear:both;"></div>

	<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">

	<? // 리스트 (루프) { ?>
	<?php
	$bo_arr = explode(";", $board[$bNum]);
	
	for ( $i = 0; $i < count( $bo_arr )-1; $i++ ) { 
		$V_arr = explode("|", $bo_arr[$i]);
	?>
	<div class="form-group list list_each" id="<?=$fName?>_<?=$V_arr[0]?>">
		<p><input type="hidden" name="start" value="start"></p>
		<p><input type="text" class="form-control" id="<?=$fName?>_name_<?=$V_arr[0]?>" placeholder="내용" size="20" value="<?=$V_arr[1]?>"></p>
		<p><input type="hidden" name="end" value="end"></p>
		<p style="margin-left: 15px; margin-right: 15px;">
			<input type="button" class="btn btn-danger <?=$fName?>_del" value="삭제" >
		</p>
	</div>
	<div style="clear:both;"></div>
	<?php } ?>
	<? // } 리스트 ?>

	<div style="clear:both;"></div>

	<form class="form-group list" id="<?=$fName?>_add" name="fwrite" id="fwrite" method="post" onsubmit="return false;">
		<p><input type="hidden" name="start" value="start"></p>
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<p style="margin-right: 15px;"><input type="text" name="<?=$fName?>_bo1" class="form-control" id="<?=$fName?>_bo1" placeholder="내용" size="20"></p>
		<p><input type="hidden" name="end" value="end"></p>
		<p><input type="button" id="<?=$fName?>_btn_add" class="btn btn-primary btn-block" value="추가"></p>
	</form>

</div>

<script src="<?=$board_skin_url?>/js/jquery.number.min.js"></script>
<script>	
var $board_skin_url = "<?php echo $board_skin_url; ?>";

$(document).ready(function(){
	$( '#memoList #all_memoList' ).on('click', function(e){
		e.preventDefault();
		var eValue = '';
		var uid = "<?php echo get_uniqid(); ?>";
		var t = $("#memoList .list_each input");

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

	if ( $bo1 == '' ) {
		alert( '내용을 입력해 주세요.' );
		$( '#<?php echo $fName ?>_bo1' ).focus();
		return false;
	} else {
		var uid = "<?php echo get_uniqid(); ?>";

		var appendCon = '<div class="form-group list list_each" id="<?php echo $fName; ?>_'+uid+'">';
		appendCon += '<p><input type="hidden" name="start" value="start"></p>';
		appendCon += '<p style="float: left;"><input type="text" class="form-control" id="<?php echo $fName; ?>_name_'+uid+'" placeholder="내용" size="20" value="'+$bo1+'"></p>';
		appendCon += '<p><input type="hidden" name="end" value="end"></p>';
		appendCon += '<p style="float: left;margin-left: 15px;margin-right: 15px;">';
		appendCon += '<input type="button" class="btn btn-danger <?=$fName?>_del" value="삭제" style="padding: 6px 11px;" ></p>';
		appendCon += '</div>';
		appendCon += '<div style="clear:both;"></div>';

		alert('추가 후 일괄수정해야 적용됩니다.');

		$( '#<?php echo $fName; ?>_add' ).before( appendCon );
		$( '#<?php echo $fName ?>_bo1' ).focus();
		$( '#<?php echo $fName ?>_bo1' ).val( "" );
	}
} );

$('#memoList ').on('click', '.<?php echo $fName?>_del', function(e) {
	e.preventDefault();
	
	if(confirm('삭제 후 일괄수정해야 적용됩니다.') == true) {
		var n = $('#memoList .<?php echo $fName?>_del').index(this);

		$("#memoList .list_each").each(function(i){
			if(n == i){
				$(this).remove();
			}
		});
	}

	//console.log(n);
});
</script>