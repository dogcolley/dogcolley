<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$action_url = https_url(G5_BBS_DIR)."/write_update.php";
?>

<div id="setform">

	<div class="form-group list">
		<p><label><i class="fa fa-krw" aria-hidden="true"></i> 물때선택 (<span id="sDate"></span>)</label></p>
	</div>

	<div style="clear:both;"></div>

	<hr style="border-top:1px dotted #ccc;display:block;margin:5px 0 9px 0;">
	
	<input type="hidden" name="wDate" id="wDate" value=""/>

	<ul id="wadd">
        <li style="float:left;margin-right:5px;margin-bottom:5px;"><button class="btn_water btn_water_no"></button></li>
		<?php
		$wVal = sql_fetch("SELECT bo_3 FROM {$g5['board_table']} WHERE bo_table = '".$bo_table."'");

		$wRow = explode(";", $wVal[bo_3]);
		//$wRow = explode("|", $wRow[1]);
	

		for($i=0; $i<count($wRow)-1; $i++) {

			$wArr = explode("|", $wRow[$i]);
		?>
			<li style="float:left;margin-right:5px;margin-bottom:5px;"><button class="btn_water"><?=$wArr[1]?></button></li>
		<? } ?>

		<? if(count($wRow) == 1) { ?>
			<li style="float:left;margin-right:5px;margin-bottom:5px;">등록된 물때가 없습니다.<br>물때관리에서 물때를 등록해주세요.</li>
		<? } ?>
	</ul>

</div>

<script>
var $board_skin_url = "<?php echo $board_skin_url; ?>";

$( 'button.btn_water' ).click( function () {


	var $wDate = $('input[name=wDate]').val();
	var $wVal = $(this).html();

	$.ajax({
			url: $board_skin_url + "/ajax/ajax.wateradd.php",
			type: "post",
			data: {
				"w" : 'r',
				"bo_table" : '<?=$bo_table?>',
				"wDate" : $wDate,
				"wVal": $wVal
			},
			dataType: "JSON",
			async: false,
			cache: false,
			success: function( data, textStatus) {

				$("#wateraddList").modal("hide");
				$(".wtime_" + data.dVal).html( "<br>" + data.wVal + "" );
				$(".wtime2_" + data.dVal).html( data.wVal );
				
			},
			error: function( xhr, textStatus, errorThrown ) {
				console.error( xhr );
				//alert("code:"+xhr.textStatus+"\n"+"message:"+xhr.responseText+"\n"+"error:"+errorThrown);
				//console.log( xhr );
			}
	});


} );
</script>