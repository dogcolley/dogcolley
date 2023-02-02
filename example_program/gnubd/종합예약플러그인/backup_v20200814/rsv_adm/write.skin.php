<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

/*
wr_1 //비워두었습니다.
wr_2 //인원
wr_3 //예약기간유형
wr_4 //단일,기간 ~부터, 요일
wr_5 //기간 ~까지(있을경우)
wr_6 //설정시간
wr_7 //예약불가여부
wr_8 //노출순서
wr_9 //가격
wr_10 //인원
wr_11 //옵션기능활성
wr_12 //노출순위생성
wr_13 //옵션생성 : json 
*/
$set_table = $g5['write_prefix'].$bo_table;

if(!sql_query(" select wr_11 from {$set_table} limit 1 ")) {
	sql_query(" ALTER TABLE {$set_table} ADD `wr_11` INT NOT NULL DEFAULT 0 AFTER `wr_10` ");
}

if(!sql_query(" select wr_12 from {$set_table} limit 1 ")) {
	sql_query(" ALTER TABLE {$set_table} ADD `wr_12` INT NOT NULL DEFAULT 50  AFTER `wr_11` ");
}


if(!sql_query(" select wr_13 from {$set_table} limit 1 ")) {
	sql_query(" ALTER TABLE {$set_table} ADD `wr_13` text NOT NULL DEFAULT ''  AFTER `wr_12` ");
}


$wr_11 = $write['wr_11'];
$wr_12 = $write['wr_12'];
$wr_13 = $write['wr_13'];

?>

<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="wr_7" value="<?php echo $wr_7 ?>">
    <input type="hidden" name="wr_13" value="<?php echo $wr_13 ?>">
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
        <table>
        <caption><?php echo $g5['title'] ?></caption>
        <tbody>

		<?/*
        <?php if ($option) { ?>
        <tr>
            <th scope="row">옵션</th>
            <td><?php echo $option ?></td>
        </tr>
        <?php } ?>
		*/?>

        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td>
                <select class="form-control" style="width:120px; display: inline-table;" id="ca_name" name="ca_name" required>
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>
		
		<?/*
        <?php if ($is_name) { ?>
        <tr>
            <th scope="row"><label for="wr_name">신청자<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_password) { ?>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" maxlength="100"></td>
        </tr>
        <?php } ?>

        <?php if ($is_homepage) { ?>
        <tr>
            <th scope="row"><label for="wr_homepage">홈페이지</label></th>
            <td><input type="url" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input"></td>
        </tr>
        <?php } ?>
		*/?>
		<?/*
		<tr>
            <th scope="row"><label for="wr_1">연락처<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_1" value="<?php echo $wr_1 ?>" id="wr_subject" required class="frm_input required">
			</td>
        </tr>
		*/?>

		<tr>
            <th scope="row"><label for="wr_subject">노출순위<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_12" value="<?php echo $wr_12 ? $wr_12 : 50 ?>" id="wr_12" required class="frm_input required">
				<p class="U_info01">노출순서가 낮을수록 우선 노출됩니다.</p>
			</td>
        </tr>

		<tr>
            <th scope="row"><label for="wr_subject">예약명/예약시간<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_2" required class="frm_input required">
				<p class="U_info01">노출되는 예약 및 상품명입니다.</p>
			</td>
        </tr>

		<tr>
            <th scope="row"><label for="wr_2">인원(수량)<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_2" value="<?php echo $wr_2 ? $wr_2 : '1' ?>" id="wr_2"  class="frm_input ">
				<p class="U_info01">인원(수량)제한이 있을경우 입력시 예약의 횟수가 제한이 됩니다.(미입력가능)</p>
			</td>
        </tr>

		<tr>
            <th scope="row"><label for="wr_10">동시예약<br/>(인원,수량)<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_10" value="<?php echo $wr_10 ?>" id="wr_10"  class="frm_input ">
				<p class="U_info01">예약시 한명의 예약자가 동시에 (인원,수량)을 입력할수 있습니다. (미입력가능)</p>
			</td>
        </tr>
		
		<tr>
            <th scope="row"><label for="wr_9">가격<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_9" value="<?php echo $wr_9 ?>" id="wr_9"  class="frm_input ">
				<p class="U_info01">등록시 [가격기능]이 활성화 되어있다면 가격이 노출 됩니다.(미입력가능)</p>
			</td>
        </tr>
        
		<tr>
            <th scope="row"><span>일정설정</span><strong class="sound_only">필수</strong></th>
            <td>
				<label for="wr_3_0">요일</label>
				<input type="radio" name="wr_3" value="week" id="wr_3_0" class="" <?php if( $wr_3 == 'week') echo 'checked' ?>>
				
				<label for="wr_3_1">단일</label>
				<input type="radio" name="wr_3" value="oneday" id="wr_3_1" class="" <?php if( $wr_3 == 'oneday') echo 'checked' ?>>
				
				<label for="wr_3_2">기간</label>
				<input type="radio" name="wr_3" value="term" id="wr_3_2" class="" <?php if( $wr_3 == 'term') echo 'checked' ?>>
			</td>
        </tr>

		
		<tr id="wr_4_wrap">
		<?if( $wr_3 == 'week')  { 
				$wr_4s = explode("|",$wr_4);
				function mathName($cateN , $chrtN  ){
					if(strpos($cateN, $chrtN) !== false) {  
						echo "checked";  
					} else {  
						echo "";  
					}  
				}

				
		?>
			<th scope="row"><span>요일 설정</span><strong class="sound_only">필수</strong></label></th>
			<td id="wr_4_checkbox">
				<input type="hidden" name="wr_4" id="wr_4" value="<?=$wr_4?>" >
				<label for="wr_4_0">월</label>
				<input type="checkbox" name="wr_4_0" id="wr_4_0" class="wr_4" value="월" <?mathName($wr_4,'월') ?> >
				<label for="wr_4_1">화</label>
				<input type="checkbox" name="wr_4_1" id="wr_4_1"  class="wr_4" value="화" <?mathName($wr_4,'화') ?> >
				<label for="wr_4_2">수</label>
				<input type="checkbox" name="wr_4_2" id="wr_4_2"  class="wr_4" value="수" <?mathName($wr_4,'수') ?> >
				<label for="wr_4_3">목</label>
				<input type="checkbox" name="wr_4_3" id="wr_4_3"  class="wr_4" value="목" <?mathName($wr_4,'목') ?> >
				<label for="wr_4_4">금</label>
				<input type="checkbox" name="wr_4_4" id="wr_4_4"  class="wr_4" value="금" <?mathName($wr_4,'금') ?> >
				<label for="wr_4_5">토</label>
				<input type="checkbox" name="wr_4_5" id="wr_4_5"  class="wr_4" value="토" <?mathName($wr_4,'토') ?> >
				<label for="wr_4_6">일</label>
				<input type="checkbox" name="wr_4_6" id="wr_4_6"  class="wr_4" value="일" <?mathName($wr_4,'일') ?> >
			</td>
		<? } ?>


		<?if( $wr_3 == 'oneday')  { ?>
            <th scope="row"><label for="wr_4">단일 날짜 설정<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_4" value="<?php echo $wr_4 ?>" id="wr_4" required class="frm_input required"></td>
		<?}?>

		<?if( $wr_3 == 'term')  { ?>
			<th scope="row"><label for="wr_4">기간 날짜 설정<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="wr_4" value="<?php echo $wr_4 ?>" id="wr_4" required class="frm_input required">
				~
				<input type="text" name="wr_5" value="<?php echo $wr_5 ?>" id="wr_5" required class="frm_input required">
			</td>
		<?}?>
        </tr>
		<?/*
		<tr>
            <th scope="row">옵션설정<strong class="sound_only">필수</strong></th>
            <td>
				<?
					$wr_13_oj = json_decode($wr_13, true);
					$wr_13_arr =  (array) $wr_13_oj;				
				?>
				<p class="U_info01">옵션이 있을경우 입력해주세요. 가격과 수량은 필수값이 아닙니다. <br/>
					저장후에는 옵션을 삭제할수 없습니다. 비활성화를 눌러서 옵션을 가려주세요!
				</p>
				<input type="radio" value="1" name="wr_11" id="wr_11_0"/ <?=$wr_11 !== '0' ? 'checked' : ''?>>
				<label for="wr_11_0">활성</label>
				<input type="radio" value="0" name="wr_11" id="wr_11_1" <?=$wr_11 == '0' ? 'checked' : ''?>/>
				<label for="wr_11_1">비활성</label>
				<br>
				<div id="J_op_wrap" <?//= $wr_13 == '' ? 'style="display:none"' : '' ?>>
					<ul class="U_op_wrap" id="J_op_data">
						<?
							for($i=0;$i < count($wr_13_arr['opName']);$i++){
								$setNum = $i+1;										
						?>
						<li class="U_input02_wrap">
							<div class="wr_13_tit">
								<span class="wr_13_delect">#<?=$setNum?> 옵션 </span>
								<input type="radio" value="1" name="wr_13_use<?=$setNum?>" <?=$wr_13_arr['use'][$i] !== 0 ? "checked" : ''?> class="wr_13_use" id="wr_13_use<?=$setNum?>_1"/>
								<label for="wr_13_use<?=$setNum?>_1">활성</label>
								<input type="radio" value="0" name="wr_13_use<?=$setNum?>" <?=$wr_13_arr['use'][$i] == 0 ? "checked" : ''?> class="wr_13_use" id="wr_13_use<?=$setNum?>_0" />
								<label for="wr_13_use<?=$setNum?>_0">비활성</label>
							</div>
							<div class="U_input02_box">
								<label for="wr_13_name<?=$setNum?>">옵션명</label>
								<input name="wr_13_name<?=$setNum?>" id="wr_13_name<?=$setNum?>" value="<?=$wr_13_arr['opName'][$i];?>" type="text" class="U_input02 wr_13_name"/>
							</div>
							<div class="U_input02_box">
								<label for="wr_13_price<?=$setNum?>">가격</label>
								<input name="wr_13_price<?=$setNum?>" id="wr_13_price<?=$setNum?>" value="<?=$wr_13_arr['opPrice'][$i];?>" type="number" class="U_input02 wr_13_price" min="0"  />
							</div>
							<div class="U_input02_box">
								<label for="wr_13_num<?=$setNum?>">수량</label>
								<input name="wr_13_num<?=$setNum?>" id="wr_13_num<?=$setNum?>"  value="<?=$wr_13_arr['opNum'][$i];?>" type="number" class="U_input02 wr_13_num" min="0" />
							</div>
						</li>
						<?}
							if($i==0){
						?>
							<li class="U_input02_wrap">
								<div class="wr_13_tit">
									<span class="wr_13_delect">#1 옵션 </span>
									<input type="radio" value="1" name="wr_13_use1" class="wr_13_use" id="wr_13_use1_1"/>
									<label for="wr_13_use1_1">활성</label>
									<input type="radio" value="0" name="wr_13_use1" class="wr_13_use" id="wr_13_use1_0" />
									<label for="wr_13_use1_0">비활성</label>
								</div>
								<div class="U_input02_box">
									<label for="wr_13_name1">옵션명</label>
									<input name="wr_13_name1" id="wr_13_name1" type="text" class="U_input02 wr_13_name"/>
								</div>
								<div class="U_input02_box">
									<label for="wr_13_price1">가격</label>
									<input name="wr_13_price1" id="wr_13_price1" type="number" class="U_input02 wr_13_price" min="0"  />
								</div>
								<div class="U_input02_box">
									<label for="wr_13_num1">수량</label>
									<input name="wr_13_num1" id="wr_13_num1" type="number" class="U_input02 wr_13_num" min="0" />
								</div>
							</li>
						<?}?>
					</ul>
					<button type="button" class="wr_13_add U_btn01 TM_ds_inbl" id="wr_13_add" style="margin-top:10px">추가</button>
				</div>
			</td>
        </tr>
		*/?>

		<tr>
			<th scope="row"><label for="wr_6">시간 설정<strong class="sound_only">필수</strong></label></th>
            <td>
				<?php 
					if($wr_6 !== ''){
						$arr1 = explode('~',$wr_6);
						$times = [];

						foreach($arr1 as $value){
							$arr2 = explode(':',$value);
							foreach($arr2 as $value2){
								$times[] = $value2;
							}
						}
					}
				?>
				<input type="hidden" name="wr_6" value="<?php echo $wr_6 ?>" >
				<select name="wr_6s" id="wr_6s_1" class="frm_input " style="width:auto;padding:0 10px">
					<option value="">--</option>
					<?for($i=0;$i < 24;$i++){
						$value = $i < 10 ? '0'.$i : $i;
					?>
					<option value="<?=$value?>" <?if($value == $times[0])echo 'selected'?>><?=$value?></option>
					<?}?>
				</select>
				:
				<select name="wr_6s" id="wr_6s_2" class="frm_input " style="width:auto;padding:0 10px">
					<option value="">--</option>
					<?for($i=0;$i < 60;$i++){
						$value = $i < 10 ? '0'.$i : $i;
					?>
					<option value="<?=$value?>" <?if($value == $times[1])echo 'selected'?>><?=$value?></option>
					<?}?>
				</select>
				~
				<select name="wr_6s" id="wr_6s_3" class="frm_input " style="width:auto;padding:0 10px">
					<option value="">--</option>
					<?for($i=0;$i < 24;$i++){
						$value = $i < 10 ? '0'.$i : $i;
					?>
					<option value="<?=$value?>" <?if($value == $times[2])echo 'selected'?>><?=$value?></option>
					<?}?>
				</select>
				:
				<select name="wr_6s" id="wr_6s_4" class="frm_input " style="width:auto;padding:0 10px">
					<option value="">--</option>
					<?for($i=0;$i < 60;$i++){
						$value = $i < 10 ? '0'.$i : $i;
					?>
					<option value="<?=$value?>" <?if($value == $times[3])echo 'selected'?>><?=$value?></option>
					<?}?>
				</select>
				<p class="U_info01"> 입력시 시간에 따른 마감기능이 자동으로 설정 됩니다. 미입력시에 시간제한이 없습니다.</p>
			</td>
			</td>
        </tr>

        <tr>
            <th scope="row"><label for="wr_content">설명 [부가설명있을경우]<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

		<?/*
        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label></th>
            <td><input type="url" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input wr_link"></td>
        </tr>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row">파일 #<?php echo $i+1 ?></th>
            <td>
                <div class="file_box">
                    <input type="text" class="file_name frm_input">
                    <a href="javascript:" class="file_btn">파일첨부</a>
                    <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                </div>
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')'; ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <script>
            $('input[type=file]').change(function(){
                $(this).siblings('.file_name').val($(this).val());
            });
        </script>
        <?php } ?>
		*/?>

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

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>
</section>



<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>

$(function(){

	function maker_op_tag (mode) {
		var new_U_input02_wrap = $('.new_U_input02_wrap').length;
		var save_new_name = new Array();
		var save_new_price = new Array();
		var save_new_num = new Array();
		var save_new_checked = new Array();

		$('.new_U_input02_wrap .wr_13_name').each(function(){
			save_new_name.push($(this).val());
		});
		$('.new_U_input02_wrap .wr_13_price').each(function(){
			save_new_price.push($(this).val());
		});
		$('.new_U_input02_wrap .wr_13_num').each(function(){
			save_new_num.push($(this).val());
		});
		$('.new_U_input02_wrap .wr_13_use:checked').each(function(){
			save_new_checked.push($(this).val());
		});

		$('.new_U_input02_wrap').remove();

		var op_data_lg = $('#J_op_data li').length;
		var op_data_add = op_data_lg+1;
		var make_tag = '';
		var cunter = mode == 'del'? new_U_input02_wrap : new_U_input02_wrap+1
		for(var i =0; i < cunter; i++){
			make_tag += '<li class="U_input02_wrap new_U_input02_wrap">';
			make_tag += '<div class="wr_13_tit">';
			make_tag += '<button type="button" class="wr_13_delect">#'+op_data_add+' 옵션 <span>삭제</span></button>';
			make_tag += '<input type="radio" '+(save_new_checked[i] !== '0' ? 'checked' : '')+' value="1" name="wr_13_use'+op_data_add+'" class="wr_13_use" id="wr_13_use'+op_data_add+'_1"/>';
			make_tag += '<label for="wr_13_use'+op_data_add+'_1">활성</label>';
			make_tag += '<input type="radio" '+(save_new_checked[i] == '0' ? 'checked' : '')+' value="0" name="wr_13_use'+op_data_add+'" class="wr_13_use" id="wr_13_use'+op_data_add+'_0" />';
			make_tag += '<label for="wr_13_use'+op_data_add+'_0">비활성</label>';
			make_tag += '</div>';
			make_tag += '<div class="U_input02_box">';
			make_tag += '<label for="wr_13_name'+op_data_add+'">옵션명</label>';
			make_tag += '<input name="wr_13_name'+op_data_add+'" value = "'+(save_new_name[i] ? save_new_name[i] : '')+'" id="wr_13_name'+op_data_add+'" type="text" class="U_input02 wr_13_name"/>';
			make_tag += '</div>';
			make_tag += '<div class="U_input02_box">';
			make_tag += '<label for="wr_13_price'+op_data_add+'">가격</label>';
			make_tag += '<input name="wr_13_price'+op_data_add+'" value = "'+(save_new_price[i] ? save_new_price[i] : '')+'" id="wr_13_price'+op_data_add+'" type="number" class="U_input02 wr_13_price" min="0"  />';
			make_tag += '</div>';
			make_tag += '<div class="U_input02_box">';
			make_tag += '<label for="wr_13_num'+op_data_add+'">수량</label>';
			make_tag += '<input name="wr_13_num'+op_data_add+'" value = "'+(save_new_num[i] ? save_new_num[i] : '')+'" id="wr_13_num'+op_data_add+'" type="number" class="U_input02 wr_13_num" min="0" />';
			make_tag += '</div>';
			make_tag += '</li>';
			op_data_add+=1;
		}
		$('#J_op_data').append(make_tag);
	}

	if($('#wr_content').text() == '')$('#wr_content').text('부가설명이 있을경우 입력해주세요');
	
	$('#wr_11_0').on('click',function(){
		$('#J_op_wrap').show();
	});

	$('#wr_11_1').on('click',function(){
		$('#J_op_wrap').hide();
	});

	$(document).on('click','button.wr_13_delect',function(){
		$(this).parents('.U_input02_wrap').remove();
		maker_op_tag('del');
	});

	$('#wr_13_add').on('click',function(){
		maker_op_tag('add');
	});


});




function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{


	var wr_13 = new Object()
	var save_name = new Array();
	var save_price = new Array();
	var save_num = new Array();
	var save_checked = new Array();

	$('.U_input02_wrap .wr_13_name').each(function(){
		save_name.push($(this).val());
	});
	$('.U_input02_wrap .wr_13_price').each(function(){
		save_price.push($(this).val());
	});
	$('.U_input02_wrap .wr_13_num').each(function(){
		save_num.push($(this).val());
	});
	$('.U_input02_wrap .wr_13_use:checked').each(function(){
		save_checked.push($(this).val());
	});
	wr_13.opName = save_name;
	wr_13.opPrice = save_price;
	wr_13.opNum = save_num;
	wr_13.use = save_checked;
	f.wr_13.value =  JSON.stringify(wr_13);

	var check_times = false;
	var wr_6_value = '';
	var arr = [];
	for(var i = 0 ; i < f.wr_6s.length; i++){
		if(f.wr_6s[i].value){
			arr.push(f.wr_6s[i].value);
			check_times = true;
		} 
	}
	
	if(check_times){
		if(arr.length < 4){
			alert('시간 설정을 모두 알맞게 작성하거나 설정을 하지 말아주세요!');
			return false;
		}
		for(var i = 0; i < arr.length; i++){
			wr_6_value += arr[i] ;
			if(i == 0 || i == 2) wr_6_value += ":";
			if(i == 1) wr_6_value += "~";
		}
	}

	f.wr_6.value = wr_6_value;

	if(f.wr_3.value == 'week'){
		var wr_4_val = ''; 
		$('.wr_4:checked').each(function(){
			wr_4_val += $(this).val()+'|';
		});
		$('#wr_4').val(wr_4_val.slice(0,-1));
	}

	if(f.wr_content == ''){
		f.wr_content = '설명없음';
	}

    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
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

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>


<script>
	$(function(){

		$('input[name="wr_3"]').on('click',function(e){
			var set_wr4 = $('#wr_4_wrap');
			set_wr4.find(' > *').remove();
			var set_tag = "";
			var set_date = false;
			if($(this).val() == "week"){
				set_tag += `
				<th scope="row"><span>요일 설정</span><strong class="sound_only">필수</strong></label></th>
				<td id="wr_4_checkbox">
					<input type="hidden" name="wr_4" id="wr_4" value="" >
					<label for="wr_4_0">월</label>
					<input type="checkbox" name="wr_4_0" id="wr_4_0" class="wr_4" value="월" >
					<label for="wr_4_1">화</label>
					<input type="checkbox" name="wr_4_1" id="wr_4_1"  class="wr_4" value="화" >
					<label for="wr_4_2">수</label>
					<input type="checkbox" name="wr_4_2" id="wr_4_2"  class="wr_4" value="수" >
					<label for="wr_4_3">목</label>
					<input type="checkbox" name="wr_4_3" id="wr_4_3"  class="wr_4" value="목" >
					<label for="wr_4_4">금</label>
					<input type="checkbox" name="wr_4_4" id="wr_4_4"  class="wr_4" value="금" >
					<label for="wr_4_5">토</label>
					<input type="checkbox" name="wr_4_5" id="wr_4_5"  class="wr_4" value="토" >
					<label for="wr_4_6">일</label>
					<input type="checkbox" name="wr_4_6" id="wr_4_6"  class="wr_4" value="일" >
				</td>	
				`;

			}else if($(this).val() == "oneday"){
				set_tag += `
					<th scope="row"><label for="wr_4">단일 날짜 설정<strong class="sound_only">필수</strong></label></th>
					<td><input type="text" name="wr_4" value="<?php echo $wr_4 ?>" id="wr_4" required class="frm_input required"></td>
				`;
				set_date = true;

			}else if($(this).val() == "term"){
				set_tag += `
					<th scope="row"><label for="wr_4">기간 날짜 설정<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="wr_4" value="" id="wr_4" required class="frm_input required">
						~
						<input type="text" name="wr_5" value="" id="wr_5" required class="frm_input required">
					</td>
				`;
				set_date = true;
			
			}
			console.log(set_tag);
			set_wr4.append(set_tag);

			if(set_date){
				$( "#wr_4" ).datepicker({
					minDate: 0,
					changeMonth: true,
					changeYear: true,
					dateFormat: "yy-mm-dd",
					yearRange: 'c-99:c+99',
					constrainInput: true,
					prevText: '이전 달',
					nextText: '다음 달',
					monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					dayNames: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				});

				$( "#wr_5" ).datepicker({
					minDate: 0,
					changeMonth: true,
					changeYear: true,
					dateFormat: "yy-mm-dd",
					yearRange: 'c-99:c+99',
					constrainInput: true,
					prevText: '이전 달',
					nextText: '다음 달',
					monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					dayNames: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				});
			}


		});

		<?if( $wr_3 == 'oneday')  { ?>
			$( "#wr_4" ).datepicker({
					minDate: 0,
					changeMonth: true,
					changeYear: true,
					dateFormat: "yy-mm-dd",
					yearRange: 'c-99:c+99',
					constrainInput: true,
					prevText: '이전 달',
					nextText: '다음 달',
					monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					dayNames: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				});
		<?}?>

		<?if( $wr_3 == 'term')  { ?>
			$( "#wr_4" ).datepicker({
					minDate: 0,
					changeMonth: true,
					changeYear: true,
					dateFormat: "yy-mm-dd",
					yearRange: 'c-99:c+99',
					constrainInput: true,
					prevText: '이전 달',
					nextText: '다음 달',
					monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					dayNames: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				});

				$( "#wr_5" ).datepicker({
					minDate: 0,
					changeMonth: true,
					changeYear: true,
					dateFormat: "yy-mm-dd",
					yearRange: 'c-99:c+99',
					constrainInput: true,
					prevText: '이전 달',
					nextText: '다음 달',
					monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
					dayNames: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				});
		
		<?}?>
	
	});

</script> 
