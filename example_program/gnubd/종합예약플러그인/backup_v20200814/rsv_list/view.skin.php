<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

include_once($board_skin_path."/add_module.php");

if($member['mb_level'] >7 && $action){
	if($action == 'ps_rv'){
		$sql = "update  ".$write_table." set wr_4 = '예약완료' where wr_id = '".$view['wr_id']."'";
		echo $sql;
		sql_query($sql);
		alert('예약완료로 변경했습니다.',G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view['wr_id']);
	}
}

if($action == 'ps_cl' && ($member['mb_level'] >7  || $delete_href)){
	$sql = "update  ".$write_table." set wr_11 = NOW(), wr_4 = '예약취소' where wr_id = '".$view['wr_id']."'";
	sql_query($sql);
	alert('예약취소로 변경했습니다.',G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view['wr_id']);
}

if($_POST['wr_3'] && $_POST['wr_name']){
	$sql = "update  ".$write_table." set wr_3 = '".$_POST['wr_3']."', wr_name = '".$_POST['wr_name']."', wr_14 = NOW() where wr_id = '".$view['wr_id']."'";
	sql_query($sql);
	alert('변경완료되었습니다.',G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view['wr_id']);
}

if($member['mb_id']=='super'){
    if(!$view['wr_4']){
        $set_wr_1 = $view['wr_1'];
        $set_wr_2 = $view['wr_2'];
        $sql = "SELECT COUNT(*) AS CNT FROM ${write_table} WHERE wr_1 = '${set_wr_1}' AND wr_2 = '${set_wr_2}' AND (wr_4 = '' || wr_4 ='예약완료') AND wr_id < ${wr_id} ";
        $row = sql_fetch($sql);
        if($row['CNT'] > 0 ){
            $sql = "update  ".$write_table." set wr_11 = NOW(), wr_4 = '예약취소' where wr_id = '".$view['wr_id']."'";
            sql_query($sql);
            alert('먼저 예약하신 분이 있습니다! 다른예약을 신청해주세요!',G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view['wr_id']);
        }
    }
}

?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo ($category_name ? $view['ca_name'].' | ' : ''); // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <span class="bo_v_info_tit">작성자</span> <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <div class="right">
			<?if($view['wr_4'] =='예약취소'){?>
            <span class="bo_v_info_tit">취소날짜</span><strong style="margin-right:0;padding-right:10px;border-right:1px solid #d9d9d9"><?php echo date("y-m-d H:i", strtotime($view['wr_11'])) ?></strong>
            <?}?>
			<?if($view['wr_14'] !== '0000-00-00 00:00:00' && $is_admin){?>
            <span class="bo_v_info_tit">수정날짜</span><strong style="margin-right:0;padding-right:10px;border-right:1px solid #d9d9d9"><?php echo date("y-m-d H:i", strtotime($view['wr_14'])) ?></strong>
            <?}?>
			<span class="bo_v_info_tit">신청일</span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
            <span class="bo_v_info_tit hit">연락처</span><strong><?php echo $view['wr_3'] ?></strong>
			<?/*
            <span class="bo_v_info_tit comment">댓글</span><strong><?php echo number_format($view['wr_comment']) ?>건</strong>
			*/?>
			<span class="bo_v_info_tit comment">예약상태 </span><strong><?php echo $view['wr_4'] ? $view['wr_4'] : '접수완료'; ?></strong>
		</div>
    </section>

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <?php
    if ($view['link']) {
     ?>
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
		 <?/*
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01 pre_bt">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01 next_bt">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>
		*/?>
        <ul class="bo_v_com">
			<?if($delete_href && $view['wr_4'] !== '예약완료' && $view['wr_4'] !== '예약취소' && $view['wr_4'] !== '취소신청' ){?>
			<li><a id="ajax_cencel"  href="<?php echo $list_href ?>" class="btn_b01">예약취소</a></li>
			<?/*
			<li><a id="ajax_userCl" href="<?php echo $list_href ?>"class="btn_b01">취소신청</a></li>
			*/?>
			<?}?>
			<?/*
            <?php if ( $member['mb_level'] > 7 ) { ?><li><a href="<?php echo $update_href ?>" class="btn_admin">수정</a></li><?php } ?>
            */?>
			<?php if (/*$delete_href */ $member['mb_level'] > 7 ) { ?><li><a href="<?php echo $delete_href ?>" class="btn_admin" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <!-- <?php if ($copy_href) { ?><li><a href="<//?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?> -->
            <!-- <?php if ($move_href) { ?><li><a href="<//?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?> -->
			<?/*
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            */?>
			<li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
			<?if($member['mb_level'] > 7){?>
            <li><a id="ajax_pass" href="<?php echo $list_href ?>" class="btn_b01">예약승인</a></li>
			<?/*
            <li><a id="ajax_cencel"  href="<?php echo $list_href ?>" class="btn_b01">예약취소</a></li>
			*/?>
			<?}?>

			<?/*
            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?>
            */?>
			<?/*
			<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
			*/?>
			
		</ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>

    <section id="bo_v_atc">
	<?/*
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href; ?>" target="_blank" class="btn_b01" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good">이 글을 추천하셨습니다</b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <?php
        include(G5_SNS_PATH."/view.sns.skin.php");
        ?>
		*/
			if($view['wr_6']){
				$pepole_cnt = 0;
				$arr = explode('|',$view['wr_6']);
				foreach($arr as $value){
				$pepole_arr[] = $value;
				}
			}
			$item_arr = explode('|',$view['wr_1']);
			foreach($item_arr as $value){
				$item = ch_list($value);
		?>
		<form method="post" action="./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>">
			<table class="U_table01" style="margin-bottom:10px">
				<tbody>
					<tr>
						<td>예약시간</td>
						<td><?=$item['wr_subject']?></td>
					</tr>
					<tr>
						<td>예약날짜</td>
						<td><?=$view['wr_2']?></td>
						
					</tr>
					<?if($item['wr_6']){?>
					<tr>
						<td>예약시간</td>
						<td><?=$item['wr_6']?></td>
					</tr>
					<?}?>

					<?if($pepole_arr[$pepole_cnt] && $board['bo_8'] == '1' ){?>
					<tr>
						<td>예약인원</td>
						<td><?=$pepole_arr[$pepole_cnt]?>명</td>
					</tr>
					<?$pepole_cnt++;
					}?>

					<?if($item['wr_content'] !== '부가설명이 있을경우 입력해주세요' && !$item['wr_content']){?>
					<tr>
						<td>예약정보</td>
						<td><?php echo get_view_thumbnail($item['content']); ?></td>
					</tr>
					<?}?>

					<?if($board['bo_7'] == '1' && $item['wr_9'] ){?>
					<tr>
						<td>가격</td>
						<td><?=display_price($item['wr_9'],0)?></td>
					</tr>
					<?}?>
					<tr>
						<td>예약자</td>
						<td><input type="text" class="U_input01" value="<?=$view['wr_name']?>" name="wr_name" /></td>
					</tr>
					
					<tr>
						<td>연락처</td>
						<td><input type="text" class="U_input01" value="<?=$view['wr_3']?>" name="wr_3" /></td>
					</tr>

					<tr>
						<td colspan="2">
							<button class="U_btn01">예약정보 변경하기</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<?}?>


    </section>

    <?php
	if($board['bo_5']){
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	}?>

    <div id="bo_v_bot" style="margin-top:30px">
        <!-- 링크 버튼 -->
        <?php echo $link_buttons ?>
    </div>

</article>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->

<script>
$(function() {

	$('a#ajax_cencel').on('click',function(){
		if(confirm('예약을 취소하시겠습니까? \n 신청시 변경불가능합니다.')){
			location.href= g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&action=ps_cl&wr_id=<?=$view["wr_id"]?>';
		}
		return false;
	});	

	<?if($delete_href){?>
	$('a#ajax_userCl').on('click',function(){
		if(confirm('취소신청 하시겠습니까?\n신청시 변경불가능합니다.')){
			location.href= g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&action=ps_cl2&wr_id=<?=$view["wr_id"]?>';
		}
		return false;
	});	
	<?}?>

	<?if($member['mb_level'] > 7){?>
	//예약관리
	$('a#ajax_pass').on('click',function(){

		if(confirm('변경하시겠습니까?')){
			location.href= g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&action=ps_rv&wr_id=<?=$view["wr_id"]?>';
		}
		return false;
	});	


	<?}?>

	//이미지보기
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>