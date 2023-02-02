<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
if ($w == "r") {
	alert("해당 스킨은 답변하기를 사용할 수 없습니다.", G5_BBS_URL.'/board.php?bo_table='.$bo_table);
}
?>

<section id="bo_w">
    <h2 id="container_title"><?=$g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?=$action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?=$w ?>">
    <input type="hidden" name="bo_table" value="<?=$bo_table ?>">
    <input type="hidden" name="wr_id" value="<?=$wr_id ?>">
    <input type="hidden" name="sca" value="<?=$sca ?>">
    <input type="hidden" name="sfl" value="<?=$sfl ?>">
    <input type="hidden" name="stx" value="<?=$stx ?>">
    <input type="hidden" name="spt" value="<?=$spt ?>">
    <input type="hidden" name="sst" value="<?=$sst ?>">
    <input type="hidden" name="sod" value="<?=$sod ?>">
    <input type="hidden" name="page" value="<?=$page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice">공지</label>';
        }
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html">html</label>';
            }
        }
        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }
        if ($is_mail) {
            $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail">답변메일받기</label>';
        }
    }
    echo $option_hidden;
    ?>
    <div class="tbl_frm01 tbl_wrap">
		<?php if ($is_name || $is_password) { ?>
		<div class="tbl_solid">
			<div class="form-inline">
				<?php if ($is_name) { ?>
				<div class="form-group">
					<label for="wr_name">이름<strong class="sound_only">필수</strong></label>
					<input placeholder="이름을 입력해주세요." type="text" name="wr_name" value="<?=$name ?>" id="wr_name" required class="form-control required" size="25" maxlength="20">
				</div>
				<?php } ?>

				<?php if ($is_password) { ?>
				<div class="form-group">
					<label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label>
					<input placeholder="비밀번호를 입력해주세요." type="password" name="wr_password" id="wr_password" <?=$password_required ?> class="form-control <?=$password_required ?>" size="25" maxlength="20">
				</div>
				<?php } ?>
			</div>
			
			
			<div class="form-inline ">
				<?php if ($is_email) { ?>
				<div class="form-group">
					<label for="wr_email">이메일</label>
					<input placeholder="email@example.com" type="email" name="wr_email" value="<?=$email ?>" id="wr_email" class="form-control email" size="25" maxlength="100">
				</div>
				<?php } ?>

				<?php if ($is_homepage) { ?>
				<div class="form-group">
					<label for="wr_homepage">홈페이지</label>
					<input placeholder="http://www.hompage.com" type="url" name="wr_homepage" value="<?=$homepage ?>" id="wr_homepage" class="form-control" size="25">
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		
		<?php if ($option || $is_category) { ?>
		<div class="bo_w_opt_cate">
			<?php if ($option) { ?>
			<div class="option_chk">
				<div><?=$option ?></div>
			</div>
			<?php } ?>
			
			<?php if ($is_category) { ?>
			<div class="bo_w_cate">
				<i class="fa fa-caret-down" aria-hidden="true"></i>
				<select class="required form-control" id="ca_name" name="ca_name" required>
					<option value="">분류를 선택하세요</option>
					<?=$category_option ?>
				</select>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

        <table class="table table-bordered" id="book_write">
			<colgroup>
				<col width="10%"><col width="40%"><col width="10%"><col width="40%">
			</colgroup>
			<thead></thead>
			<tbody>
				<tr>
					<th><label for="wr_subject">책 제목<strong class="sound_only">필수</strong></label></th>
					<td><input placeholder="책 제목" type="text" name="wr_subject" value="<?=$subject ?>" id="wr_subject" required class="form-control required"></td>
					<th><label for="wr_3">부제목</label></th>
					<td><input placeholder="부제목" type="text" name="wr_3" value="<?=$wr_3 ?>" id="wr_3" class="form-control"></td>
				</tr>
				<tr>
					<th><label for="wr_1">작가<strong class="sound_only">필수</strong></label></th>
					<td><input placeholder="작가" type="text" name="wr_1" value="<?=$wr_1 ?>" id="wr_1" required class="form-control required"></td>
					<th><label for="wr_2">출판사</label></th>
					<td><input placeholder="출판사" type="text" name="wr_2" value="<?=$wr_2 ?>" id="wr_2" class="form-control"></td>
				</tr>
				<tr>
					<th><label for="wr_4">장르</label></th>
					<td><input type="text" name="wr_4" class="form-control" id="wr_4" value="<?=$wr_4 ?>"></td>
					<th><label for="wr_5">출간일</label></th>
					<td>
						<div class="form-inline">
							<div class="form-group">
								<input type="text" name="wr_5" class="form-control" id="wr_5" value="<?=$wr_5 ?>" style="cursor:pointer" readonly>
							</div>
						</div>
					</td>
				</tr>
				<tr class="bo_w_file">
					<th><label for="bf_file[]">책 표지</label></th>
					<td class="file_box">
						<input type="text" class="file_name form-control">
						<a href="javascript:" class="file_btn">파일첨부</a>
						<input type="file" accept="image/*" name="bf_file[]" title="파일첨부 1 :  용량 <?=$upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
						<?php if ($is_file_content) { ?>
							<input type="text" name="bf_content[]" placeholder="책 표지 이미지 파일 설명" value="<?=($w == 'u') ? $file[0]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file form-control file_explan">
						<?php } ?>
						<?php if($w == 'u' && $file[0]['file']) { ?>
							<div class="bf_file_del_box">
								<input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="1"> 
								<label for="bf_file_del0"><?=$file[0]['source'].'('.$file[0]['size'].')'; ?> 
								<p>파일 삭제</p>
								</label>
							</div>
						<?php } ?>
					</td>
					<th><label for="bf_file[]">ZIP 파일</label></th>
					<td class="file_box">
						<input type="text" class="file_name form-control">
						<a href="javascript:" class="file_btn">파일첨부</a>
						<input type="file" accept=".zip" name="bf_file[]" title="파일첨부 2 :  용량 <?=$upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
						<?php if ($is_file_content) { ?>
							<input type="text" name="bf_content[]" placeholder="E-book zip 파일 설명" value="<?=($w == 'u') ? $file[1]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file form-control file_explan">
						<?php } ?>
						<?php if($w == 'u' && $file[1]['file']) { ?>
							<div class="bf_file_del_box">
								<input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"> 
								<label for="bf_file_del1"><?=$file[1]['source'].'('.$file[1]['size'].')'; ?> 
								<p>파일 삭제</p>
								</label>
							</div>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>페이지 넘김</th>
					<td>
						<select name="wr_6" class="form-control" id="wr_6">
							<option value="lr" <?=($wr_6!='rl')?"selected":"";?>>오른쪽에서 왼쪽으로
							<option value="rl" <?=($wr_6==='rl')?"selected":"";?>>왼쪽에서 오른쪽으로
						</select>
					</td>
					<th></th><td></td>
				</tr>
				<tr>
					<th><label for="wr_content">책 설명<strong class="sound_only">필수</strong></label></th>
					<td colspan="3">
						<div class="wr_content">
							<?php if($write_min || $write_max) { ?>
							<!-- 최소/최대 글자 수 사용 시 -->
							<p id="char_count_desc">이 게시판은 최소 <strong><?=$write_min; ?></strong>글자 이상, 최대 <strong><?=$write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
							<?php } ?>
							<?=$editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
							<?php if($write_min || $write_max) { ?>
							<!-- 최소/최대 글자 수 사용 시 -->
							<div id="char_count_wrap"><span id="char_count"></span>글자</div>
							<?php } ?>
						</div>
					</td>
				</tr>
				
				<?php if($file_count) { ?>
				<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
				<tr class="bo_w_link_box">
					<th><label for="wr_link<?=$i ?>">링크 #<?=$i ?></label></th>
					<td colspan="3">
						<input placeholder="http://www.link_url.com" type="url" name="wr_link<?=$i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?=$i ?>" class="form-control wr_link">
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
        <?php if ($is_guest) { //자동등록방지 ?>
        <div>
            <label>자동등록방지</label>
            <div><?=$captcha_html ?></div>
        </div>
        <?php } ?>
    </div>
    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" class="btn btn-primary" accesskey="s">
        <a href="./board.php?bo_table=<?=$bo_table ?>" class="btn btn-default">취소</a>
    </div>
    </form>
</section>

<script>
$(document).ready(function() {
	jQuery.browser = {};
	(function () {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	});
	$("#wr_5").datepicker({
		changeMonth: true, 
		changeYear: true, 
		dateFormat: "yy-mm-dd", 
		showButtonPanel: true, 
		yearRange: "c-99:c+99", 
		//minDate: "0d;", 
		//maxDate: "+365d;", 
		buttonImage:"<?=$board_skin_url;?>/img/calendar.png", 
		buttonImageOnly: true, 
		showOn: 'both'
	});
});

<?php if($write_min || $write_max) { // 글자수 제한 ?>
var char_min = parseInt(<?=$write_min; ?>); // 최소
var char_max = parseInt(<?=$write_max; ?>); // 최대
check_byte("wr_content", "char_count");
$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});
<?php } ?>

function html_auto_br(obj) {
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    } else
        obj.value = "";
}

function fwrite_submit(f) {
    <?=$editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST", dataType: "json", cache: false, 
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });
    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }
    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }
    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }
    <?=$captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
    document.getElementById("btn_submit").disabled = "disabled";
    return true;
}
</script>
