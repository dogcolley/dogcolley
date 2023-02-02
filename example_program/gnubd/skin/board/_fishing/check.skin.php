<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$action = $board_skin_url.'/check2.skin.php';
$w = $_GET[reservation];
?>

<!-- 비밀번호 확인 시작 { -->
<div id="mb_login" class="mbskin">
	<h1>예약 확인</h1>

    <form name="flogin" action="<?=$action?>" onsubmit="return flogin_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">

    <fieldset id="login_fs">
        <legend>회원로그인</legend>
        <label for="wr_name" class="login_id">이름<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="wr_name" id="wr_name" required="" class="frm_input required" size="20" maxlength="30" placeholder="이름">
        <label for="wr_4" class="login_pw">연락처<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="wr_4" id="wr_4" required="" class="frm_input required" size="20" maxlength="14" placeholder="연락처" onkeydown="onlyNumber(this)">
		<div>
			<input type="submit" value="예약확인" class="btn_submit">
		</div>
    </fieldset>

    </form>

    <div class="btn_confirm">
        <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>">돌아가기</a>
    </div>

</div>

<script>
function onlyNumber(obj) {
    $(obj).keyup(function(){
         $(this).val($(this).val().replace(/[^0-9]/g,""));
    }); 
}
</script>
<!-- } 비밀번호 확인 끝 -->