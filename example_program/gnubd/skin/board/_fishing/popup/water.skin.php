<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";

$fName = "water"; // 중복되는 값 걸러내기 위해 파일명 변수 등록
$bNum = "bo_3"; // 현재 페이지에서 사용되는 bo 여분필드 명
?>

<div id="setform">
	
	
	<div class="form-group list">
		<p><label><i class="fa fa-krw" aria-hidden="true"></i> 물때종류</label></p>
	</div>

	<div style="clear:both;"></div>

	<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">

	<? // 리스트 (루프) { ?>
	<?php
	$bo_arr = explode(";", $board[$bNum]);
	
	for ( $i = 0; $i < count( $bo_arr )-1; $i++ ) { 
		$V_arr = explode("|", $bo_arr[$i]);
	?>
	<div class="form-group list" id="<?=$fName?>_<?=$V_arr[0]?>">
		<p><input type="text" class="form-control" id="<?=$fName?>_name_<?=$V_arr[0]?>" placeholder="물때종류" size="15" value="<?=$V_arr[1]?>"></p>
		<p style="margin-left: 15px; margin-right: 15px;">
			<input type="button" class="btn btn-default" value="수정" onclick="<?=$fName?>_edit(<?=$V_arr[0]?>)">
			<input type="button" class="btn btn-danger" value="삭제" onclick="<?=$fName?>_del(<?=$V_arr[0]?>)">
		</p>
	</div>
	<?php } ?>
	<? // } 리스트 ?>

	<div style="clear:both;"></div>

	<form class="form-group list" id="<?=$fName?>_add" name="fwrite" id="fwrite" method="post" onsubmit="return false;">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<p style="margin-right: 15px;"><input type="text" name="<?=$fName?>_bo1" class="form-control" id="<?=$fName?>_bo1" placeholder="물때종류" size="15"></p>
		<p><input type="button" id="<?=$fName?>_btn_add" class="btn btn-primary btn-block" value="추가"></p>
	</form>

</div>

<script src="<?=$board_skin_url?>/js/jquery.number.min.js"></script>
<script>	
$( '.num_' ).number( true );
var $board_skin_url = "<?php echo $board_skin_url; ?>";

$( '#<?php echo $fName; ?>_bo1' ).keydown(function (e) {
	if (e.keyCode == 13) {
		e.preventDefault();
		$( '#<?php echo $fName; ?>_btn_add' ).click();
	}
});

$( '#<?php echo $fName; ?>_btn_add' ).click( function () {
	
	var $bo1 = $( '#<?php echo $fName ?>_bo1' ).val();

	if ( $bo1 == '' ) {
		alert( '물때종류를 입력해 주세요.' );
		$( '#<?php echo $fName ?>_bo1' ).focus();
		return false;
	} else {
		$.ajax({
				url: $board_skin_url + "/ajax/ajax.<?=$fName?>.php",
				type: "post",
				data: {
					"w" : 'r',
					"bo_table" : '<?=$bo_table?>',
					"bNum" : '<?=$bNum?>',
					"bo1": $bo1
				},
				dataType: "JSON",
				async: false,
				cache: false,
				success: function( data, textStatus) {
					
					//alert(data.fNum + 1);
					fNum = data.fNum + 1;

					var appendCon = '<div class="form-group list" id="<?php echo $fName; ?>_'+data.uid+'">';
						appendCon += '<p style="float: left;"><input type="text" class="form-control" id="<?php echo $fName; ?>_name_'+data.uid+'" placeholder="물때종류" size="15" value="'+data.bo1+'"></p>';
						appendCon += '<p style="float: left;margin-left: 15px;margin-right: 15px;"><input type="button" class="btn btn-default" value="수정" style="padding: 6px 11px;" onclick="<?php echo $fName; ?>_edit('+data.uid+')"> ';
						appendCon += '<input type="button" class="btn btn-danger" value="삭제" style="padding: 6px 11px;" onclick="<?php echo $fName; ?>_del('+data.uid+')"></p>';
						appendCon += '</div>';
						appendCon += '<div style="clear:both;"></div>';

					$( '#<?php echo $fName; ?>_add' ).before( appendCon );
					$( '.num_' ).number( true );
					$( '#<?php echo $fName ?>_bo1' ).focus();
					$( '#<?php echo $fName ?>_bo1' ).val( "" );
					
				},
				error: function( xhr, textStatus, errorThrown ) {
					console.error( xhr );
					alert("code:"+xhr.textStatus+"\n"+"message:"+xhr.responseText+"\n"+"error:"+errorThrown);
					//console.log( xhr );
				}
		});
	}
} );

function <?php echo $fName; ?>_edit(id) {
	if ( confirm( "선택한 데이터를 수정하시겠습니까?" ) == true ) {
		$.ajax( {
				url: $board_skin_url + "/ajax/ajax.<?=$fName?>.php",
				type: "POST",
				data: {
					"w" : "u",
					"bo_table" : '<?=$bo_table?>',
					"bNum" : '<?=$bNum?>',
					"bo1": $( '#<?php echo $fName; ?>_name_'+id ).val(),
					"uid_o": id
				},
				dataType: "json",
				async: false,
				cache: false,
				success: function( data, textStatus ) {

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
}

function <?php echo $fName; ?>_del(id) {
	if ( confirm( "선택한 데이터를 삭제하시겠습니까?" ) == true ) {
		$.ajax( {
			url: $board_skin_url + "/ajax/ajax.<?=$fName?>.php",
			type: "POST",
			data: {
				"w" : "d",
				"bo_table" : '<?=$bo_table?>',
				"bNum" : '<?=$bNum?>',
				"bo1": $( '#<?php echo $fName; ?>_name_'+id ).val(),
				"uid_o": id
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function( data, textStatus ) {
				//console.log( data );
				//alert( '선택한 데이터가 삭제되었습니다.' );
				$( '#<?php echo $fName; ?>_'+id ).remove();
			},
			error: function( xhr, textStatus, errorThrown ) {
				console.error( xhr );
			}
		} );
	} else {
		return false;
	}
	
}
</script>