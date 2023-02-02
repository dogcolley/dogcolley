<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/bootstrap-select.min.css">', 1);
add_javascript('<script type="text/javascript" src="'.$board_skin_url.'/js/bootstrap-select.min.js"></script>', 0);
?>

<!-- 게시판 목록 시작 -->
<div id="bo_gall">
	
	<h2 id="container_title">
	<?=($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?>
	<?php if ($sca) { ?> <span> &gt; <?php echo($sca); ?></span> <?php } ?>
	<span class="sound_only"> 목록</span>
	</h2>

    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="cate_mo dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">카테고리<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu"><?=$category_option ?></ul>
    </nav>
	
    <nav id="bo_cate_pc" class="cate_pc">
        <div id="bo_cate_pc_ul"><?=$category_option ?></div>
    </nav>
	<script>
		$('#bo_cate_pc_ul li').each(function(){
			$(this).attr('class','btn btn-default');
		});
		
		if($(window).width() <= 767) {
			$('#bo_cate_pc').hide();
			$('#bo_cate').show();
		} else {
			$('#bo_cate_pc').show();
			$('#bo_cate').hide();
		}
		
		$(window).resize(function() {
			if($(window).width() <= 767) {
				$('#bo_cate_pc').hide();
				$('#bo_cate').show();
			} else {
				$('#bo_cate_pc').show();
				$('#bo_cate').hide();
			}
		});
	</script>
	<?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?=number_format($total_count) ?>건</span>
            <?=$page ?> 페이지
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href = false) { ?><li><a href="<?=$rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?>
			<li><a href="javascript:" onclick="setting_modal()">
				 <span class="icons glyphicon glyphicon-cog"></span></a>&nbsp;&nbsp;
			</li>
			<li><a href="<?=$admin_href ?>" class="btn btn-default">관리자</a></li>
			<?php } ?>
			<?php if ($write_href) { ?><li><a href="<?=$write_href ?>" class="btn btn-default">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
		<input type="hidden" name="bo_table" value="<?=$bo_table ?>">
		<input type="hidden" name="sfl" value="<?=$sfl ?>">
		<input type="hidden" name="stx" value="<?=$stx ?>">
		<input type="hidden" name="spt" value="<?=$spt ?>">
		<input type="hidden" name="sst" value="<?=$sst ?>">
		<input type="hidden" name="sod" value="<?=$sod ?>">
		<input type="hidden" name="page" value="<?=$page ?>">
		<input type="hidden" name="sw" value="">

		<h2 class="sound_only">이미지 목록</h2>

	   <?php if ($is_checkbox) { ?>
		<div id="gall_allchk">
			<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
			<label for="chkall"><span class="sound_only">현재 페이지</span> 전체 선택</label>
		</div>
		
		<script>
		$('#gall_allchk label[for=chkall]').bind('click',function() {
			if ($(this).siblings('input[type=checkbox]').is(':checked')) {
				$(this).removeClass("focus");
			} else {
				$(this).addClass("focus");
			}
		});
		</script>
		<?php } ?>
	
		<ul id="gall_ul">
			<?php for ($i=0; $i<count($list); $i++) { ?>
			<li class="gall_li <?php if ($wr_id == $list[$i]['wr_id']) { ?>gall_now<?php } ?>">
			
				<?php if ($is_checkbox) { ?>
				<span class="td_chk">
					<input type="checkbox" name="chk_wr_id[]" value="<?=$list[$i]['wr_id'] ?>" id="chk_wr_id_<?=$i ?>">
					<label for="chk_wr_id_<?=$i ?>"><span class="sound_only"><?=$list[$i]['subject'] ?></span></label>
				</span>
				<?php } ?>
				
				<span class="sound_only">
					<?=($wr_id == $list[$i]['wr_id']) ? "<span class=\"bo_current\">열람중</span>" : $list[$i]['num']; ?>
				</span>
				
				<div class="gall_con">
					<div class="gall_ica">
						<a href="<?=$list[$i]['href'] ?>">
						<?php
							$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 200, 284, true, true, 'center');
							if ($thumb['src']) {
								$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_mobile_gallery_width'].'" height="'.$board['bo_mobile_gallery_height'].'">';
							} else {
								$thumb_no = thumbnail('no_img.png', $board_skin_path.'/img', G5_DATA_PATH.'/no_img', $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], true, true, 'center');
								$img_content = "<img src='".G5_DATA_URL."/no_img/".$thumb_no."'>";
							}
							echo $img_content;
						?>
						</a>
						
						<?php if ($list[$i]['is_notice']) { //공지사항 ?>
							<div class="notice_icon"><i class="fa fa-star" aria-hidden="true"></i></div>
						<?php } ?>
						
						<?php if ($list[$i]['icon_new'] || $list[$i]['icon_new'] || $list[$i]['icon_hot'] || $list[$i]['icon_secret'] || $list[$i]['comment_cnt']) { ?>
							<div class="cont_icon">
								<?php if ($list[$i]['icon_new']) { ?><span class="icon_new"><?php if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];?></span><?php }?>
								<?php if ($list[$i]['icon_hot']) { ?><span><?php if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];?></span><?php }?>
								<?php if ($list[$i]['icon_secret']) { ?><span><?php if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];?><span><?php }?>
							</div>
						<?php } ?>
						
						<?php if ($is_category && $list[$i]['ca_name']) { ?>
						<div class="bo_cate_link_div">
							<div class="bo_cate_link"><?=$list[$i]['ca_name'] ?></div>
						</div>
						<?php } ?>
					</div>
					
					<div class="gall_con_cont">
						<div class="gall_text_href">
							<a href="<?=$list[$i]['href'] ?>" class="gall_subj">
								<?=$list[$i]['subject'] ?><p><?=$list[$i]['wr_1']?></p>
							</a>
							<?php if ($is_good < 0) { ?><div><span class="gall_subject"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </span><strong><?=$list[$i]['wr_good'] ?></strong></div><?php } ?>
							<?php if ($is_nogood = false) { ?><li><span class="gall_subject"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> </span><strong><?=$list[$i]['wr_nogood'] ?></strong></li><?php } ?>
						</div>
						
					</div>
				</div>
			</li>
			<?php } ?>
			<?=(count($list) == 0) ? "<li class=\"empty_list\">등록된 E-Book이 없습니다.</li>" : ""; ?>
		</ul>
		
		<?php if ($is_checkbox) { ?>
		<script>
		$('.td_chk label').bind('click',function() {
			if ($(this).siblings('input[type=checkbox]').is(':checked')) {
				$(this).removeClass("focus");
			} else {
				$(this).addClass("focus");
			}
		});
		</script>
		<?php } ?>
	
		<?php if ($list_href || $is_checkbox || $write_href) { ?>
		<div class="bo_fx bo_fx_adm">
			<ul class="btn_bo_adm">
				<?php if ($is_checkbox) { ?>
				<li><input class="btn btn-dark" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
				<li><input class="btn btn-dark" type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
				<li><input class="btn btn-dark" type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
				<?php } ?>
			</ul>

			<ul class="btn_bo_user">
				<li><a href="<?=$list_href ?>" class="btn btn-default"> 목록</a></li>
				<li><?php if ($write_href = false) { ?><a href="<?=$write_href ?>" class="btn btn-primary">글쓰기</a><?php } ?></li>
			</ul>
		</div>
		<?php } ?>
    </form>
	
	<?php if($is_admin || !($member['mb_level'] < 8)) { ?>
    <div class="modal fade" id="setting_modal">
        <div class="modal-dialog" style="top:5%;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">사용설정</h4>
				</div>
				<div class="modal-body" style="margin-left:20px;">
					<form>
						<div class="row form-group" style="margin-top:20px;">
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left">
								<label class="option_title" for="allow_auth">
								<input type="hidden" name="allow_auth" id="allow_auth" class="form-check-input" autocomplete="off" value="allow_auth">
								&nbsp;보기권한</label>
							</div>
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-left">
								<select class="selectpicker" name="bo_1" id="bo_1" autocomplete="off">
									<?php for ($i=1; $i<9; $i++) { ?>
									<option value="<?=$i?>" <?=($board['bo_1']==$i) ? "selected" : ""; ?>><?=$i ?></option>
									<?php } ?>
								</select>
								<p style="color:gray;font-size:10px;margin-top:5px;">
								&nbsp;권한 1은 비회원, 2 이상 회원입니다.</p>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="setting_save" onclick="settingSave()">Save changes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
            </div>
		</div>
    </div>
	<?php } ?>	
</div>

<script>
<?php if ($is_admin || !($member['mb_level'] < 8)) { ?>
// setting 모달 오픈
function setting_modal() {
    $('#setting_modal').modal();
}
// 모달 save 버튼
function settingSave() {
	var settingData = { bo_table: g5_bo_table };
	var options = [{
		key: 'bo_1', name: 'allow_auth', 
		value: $('select[name=bo_1] option:selected').val()
	}];
	$.each( options, function( i, op ) {
		settingData[op.key] = { val: op.value, subj: op.name };
	});
	$.ajax({
		url: "<?=$board_skin_url?>/lib/ajax_setting_update.php",
		type: "POST", cache: false,
		data: settingData, dataType: "json",
		success: function( data, textStatus ) {
			if (data.alert) alert(data.msg);
			if (data.result) {
				window.location.reload();
			}
		},
		error: function( xhr, status, error ) {
			alert( '업데이트에 실패하였습니다.' );
		}
	});
}
<?php } ?>
</script>

<?php if ($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?=$write_pages; ?>

<fieldset id="bo_sch">
    <legend>게시물 검색</legend>
    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?=$bo_table ?>">
    <input type="hidden" name="sca" value="<?=$sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?=get_selected($sfl, "wr_subject", true); ?>>제목</option>
        <option value="wr_content"<?=get_selected($sfl, "wr_content"); ?>>내용</option>
		<option value="wr_1"<?=get_selected($sfl, "wr_1"); ?>>작가</option>
		<option value="wr_2"<?=get_selected($sfl, "wr_2"); ?>>출판사</option>
    </select>
    <input name="stx" value="<?=stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required form-control" size="15" maxlength="20">
    <input type="submit" value="검색">
    </form>
</fieldset>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
	$('.td_chk').each(function() {
		$(this).find('input').attr('checked',sw);
		if (sw) {
			$(this).find('label').addClass('focus');
		} else {
			$(this).find('label').removeClass('focus');
		}
	});	
}

function fboardlist_submit(f) {
    var chk_count = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }
    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    if(document.pressed == "선택복사") { //select_copy("copy");
		alert('이 스킨에서는 '+document.pressed+'를 지원하지 않습니다.');
        return false;
    }
    if(document.pressed == "선택이동") { //select_copy("move");
		alert('이 스킨에서는 '+document.pressed+'을 지원하지 않습니다.');
        return false;
    }
    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;
        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }
    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;
    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";
    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");
    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
