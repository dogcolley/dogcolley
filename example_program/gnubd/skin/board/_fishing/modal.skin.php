<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($member[mb_level] >= 8) { ?>
<!-- Modal -->
<div class="modal fade" id="waterList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 물때관리</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/water.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
			</div>
		</div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="shipList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 선박관리</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/ship.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
				<button type="button" id="all_shipList" class="btn btn-secondary pull-right"><span class="glyphicon glyphicon-edit"></span> 일괄수정</button>
			</div>
		</div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="typeList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 낚시종류</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/type.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
				<button type="button" id="all_typeList" class="btn btn-secondary pull-right"><span class="glyphicon glyphicon-edit"></span> 일괄수정</button>
			</div>
		</div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="wateraddList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 물때선택</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/wateradd.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="memoList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 예약규정 안내</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/memo.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
				<button type="button" id="all_memoList" class="btn btn-secondary pull-right"><span class="glyphicon glyphicon-edit"></span> 일괄수정</button>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="smsList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> SMS설정</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/sms.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="priList" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 약관설정</h5>
			</div>
			<div class="modal-body" style="max-height: 500px;overflow: auto;">
				<?php include_once($board_skin_path."/popup/privacy.skin.php"); ?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> 닫기</button>
			</div>
		</div>
    </div>
</div>

<div style="display:none;">
	<?php include_once($board_skin_path."/popup/notice_popup.skin.php"); ?>
</div>

<? } ?>


<div style="display:none;">
	<?php include_once($board_skin_path."/popup/reserve_popup.skin.php"); ?>
</div>


<script>
$( '#waterBtn' ).click( function () {
	$( '#waterList' ).modal();
} );
$(".wBtn").on("click", function () {
	var wDate = $(this).data('id');
	$("#setform #wDate").val( wDate );
	$("#setform #sDate").html( wDate );
	$("#wateraddList").modal("show");
});
$( '#shipBtn' ).click( function () {
	$( '#shipList' ).modal();
} );
$( '#typeBtn' ).click( function () {
	$( '#typeList' ).modal();
} );
$( '#memoBtn' ).click( function () {
	$( '#memoList' ).modal();
} );
$( '#smsBtn' ).click( function () {
	$( '#smsList' ).modal();
} );
$( '#priBtn' ).click( function () {
	$( '#priList' ).modal();
} );

/* 예약하기 팝업 */
$('.resBtn').click(function() { 

	var rDate = $(this).data('id');
	var rShip = $(this).data('id2');
	var rCnt = $(this).data('id3');
	var cntShip = $(this).data('id4');
	var bo_table = $(this).data('botable');
	var write = $(this).data('write');
	var wr_id = $(this).data('wrid');
	var cname = $(this).data('cname');

	var windowWidth = $( window ).width();

	if(windowWidth <= 991) {
		var width_size = "100%";
		var height_size = "auto";
	} else if(windowWidth <= 767) {
		var width_size = "100%";	
		var height_size = "auto";
	}else{
		var width_size = "700";
		var height_size = "600";
	}

	$('#resform').dialog({
		modal: true,
		resizeable:  true,
		clickOutside: true,
		open: function ()
		{
			$(this).load('<?php echo $board_skin_url?>/popup/reserve_popup.skin.php?rDate=' + encodeURI (rDate) + '&rCnt=' + encodeURI (rCnt) + '&rShip=' + encodeURI(rShip) + '&bo_table=' + encodeURI(bo_table) + '&write=' + encodeURI(write) + '&wr_id=' + encodeURI(wr_id) + '&cname=' + encodeURI(cname) + '&cntShip=' + encodeURI(cntShip));
			$('.ui-widget-overlay, .ui-button').bind('click',function(){
				$('#resform').dialog('close');
				$('html, body').css('overflow', 'auto');
			});
			if(windowWidth <= 991) {
				$('html, body').css('overflow', 'auto');
			} else if(windowWidth <= 767) {
				$('html, body').css('overflow', 'auto');
			}else{
				$('html, body').css('overflow', 'hidden');
			}
		},
		height: height_size,
		width: width_size,
		title: '예약하기'
	});

});

/* 공지 팝업 */
$('.notiBtn').click(function() { 

	var rDate = $(this).data('id');
	var rShip = $(this).data('id2');
	var rCnt = $(this).data('id3');
	var cntShip = $(this).data('id4');
	var bo_table = $(this).data('botable');
	var write = $(this).data('write');
	var wr_id = $(this).data('wrid');

	var windowWidth = $( window ).width();

	if(windowWidth <= 991) {
		var width_size = "100%";
		var height_size = "auto";
	} else if(windowWidth <= 767) {
		var width_size = "100%";	
		var height_size = "auto";
	}else{
		var width_size = "700";
		var height_size = "300";
	}

	$('#notiform').dialog({
		modal: true,
		resizeable:  true,
		clickOutside: true,
		open: function ()
		{
			$(this).load('<?php echo $board_skin_url?>/popup/notice_popup.skin.php?rDate=' + encodeURI (rDate) + '&rCnt=' + encodeURI (rCnt) + '&rShip=' + encodeURI(rShip) + '&bo_table=' + encodeURI(bo_table) + '&write=' + encodeURI(write) + '&wr_id=' + encodeURI(wr_id) + '&cntShip=' + encodeURI(cntShip));
			$('.ui-widget-overlay').bind('click',function(){
				$('#notiform').dialog('close');
				$('html, body').css('overflow', 'auto');
			});
			if(windowWidth <= 991) {
				$('html, body').css('overflow', 'auto');
			} else if(windowWidth <= 767) {
				$('html, body').css('overflow', 'auto');
			}else{
				$('html, body').css('overflow', 'hidden');
			}
		},
		height: height_size,
		width: width_size,
		title: '공지등록'
	});

});
</script>