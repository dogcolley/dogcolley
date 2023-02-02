<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div>

<?//따로 추가로 하는거없이  여기서 바로 예약가능 불가능 상태값을 변경

if($change_wr7){
	if($view['wr_7']){
		$set_wr7 = '';
	}else{
		$set_wr7 = '1';
	}

		$sql = "update {$write_table}
				set wr_7 = '{$set_wr7}'
				where wr_id = '{$view[wr_id]}'
				";
		sql_query($sql);
		alert('변경완료되었습니다.',G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$view["wr_id"]);

}
	
?>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
			echo $view['wr_7'] ? '[종료]': '[진행중]';
            if ($category_name) echo ($category_name ? $view['ca_name'].' | ' : ''); // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <span class="bo_v_info_tit">작성자</span> <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="bo_v_info_tit">노출순위</span> <strong><?=($view['wr_12'])?></strong>
        <div class="right">
            <span class="bo_v_info_tit">작성일</span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
			<?/*
            <span class="bo_v_info_tit hit">조회</span><strong><?php echo number_format($view['wr_hit']) ?>회</strong>
            <span class="bo_v_info_tit comment">댓글</span><strong><?php echo number_format($view['wr_comment']) ?>건</strong>
			*/?>
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
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01 pre_bt">이전 예약</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01 next_bt">다음 예약</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
			<?php if($member['mb_level'] > 7){?>
			<li><a id="change_wr7" class="btn_admin" href="#" ><?=$view['wr_7'] ? '예약재개': '예약종료' ?></a></li>
			<?}?>
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_admin">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_admin" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <!-- <?php if ($copy_href) { ?><li><a href="<//?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?> -->
            <!-- <?php if ($move_href) { ?><li><a href="<//?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?> -->
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
			<?/*
            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?>
            */?>
			<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">예약추가</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>

	<section class="bo_v_info">
		<table class="U_table01">
			<tbody>
			<?
				if($view['wr_2']){
			?>
				<tr>
					<td>
						인원제한
					</td>
					<td><?= $view['wr_2']?> 명</td>
				</tr>
			<?}?>
				<tr>
					<td>일정설정</td>
					<td>
						<?
							if($view['wr_3'] == "week")
								echo '요일';
							else if($view['wr_3'] == "oneday")
								echo '단일';
							else if($view['wr_3'] == "term")
								echo '기간';
						?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?
							if($view['wr_3'] == "week")
								echo '적용 요일';
							else if($view['wr_3'] == "oneday")
								echo '설정 날짜 ';
							else if($view['wr_3'] == "term")
								echo '설정 날짜 ';
						?>
					</td>
					<td>
					<?
							if($view['wr_3'] == "week"){
								$arr = explode("|",$view['wr_4']);
								for($i=0;$i < count($arr);$i++ ){
									echo $arr[$i].' ';	

								}
							}
								
							else if($view['wr_3'] == "oneday")
								echo $view['wr_4'];
							else if($view['wr_3'] == "term")
								echo $view['wr_4'].' ~ '.$view['wr_5'];
						?>
					</td>
				</tr>
				
				<tr>
					<td>예약시간</td>
					<td>
						<?=$view['wr_6'] ? $view['wr_6'] : '제한없음' ?>
					</td>
				</tr>

				<?if($view['wr_9']){?>
					<tr>
						<td>가격</td>
						<td>
							<?=$view['wr_9']?>
						</td>
					</tr>
				<?}?>
				<?if($view['wr_10']){?>
					<tr>
						<td>인원,갯수 설정</td>
						<td>
							<?=$view['wr_10']?>
						</td>
					</tr>
				<?}?>

				<?	
					if($view['wr_13'] &&  $view['wr_11']==1){
					$wr_13 = $view['wr_13'];
					$wr_13_oj = json_decode($wr_13, true);
					$wr_13_arr =  (array) $wr_13_oj;				
				?>
					<tr>
						<td>옵션</td>
						<td>
							<ul class="U_op_wrap" id="J_op_data">
							<?
								for($i=0;$i < count($wr_13_arr['opName']);$i++){
									$setNum = $i+1;										
							?>
								
								<li class="U_input02_wrap">
									<div class="wr_13_tit">
										<span class="wr_13_delect">#<?=$setNum?> 옵션 <?= $wr_13_arr['use'][$i] !== '0'? '[활성]' : '[비활성]'?></span>
										
									</div>
									<?if($wr_13_arr['opName'][$i]){?>
									<div class="U_input02_box">
										<label for="wr_13_name<?=$setNum?>">옵션명</label>
										<input name="wr_13_name<?=$setNum?>" id="wr_13_name<?=$setNum?>" readonly value="<?=$wr_13_arr['opName'][$i];?>" type="text" class="U_input02 wr_13_name"/>
									</div>
									<?}?>
									<?if($wr_13_arr['opPrice'][$i]){?>
									<div class="U_input02_box">
										<label for="wr_13_price<?=$setNum?>">가격</label>
										<input name="wr_13_price<?=$setNum?>" id="wr_13_price<?=$setNum?>" readonly  value="<?=number_format($wr_13_arr['opPrice'][$i], 0).'원';?>" type="text" class="U_input02 wr_13_price" min="0"  />
									</div>
									<?}?>
									<?if($wr_13_arr['opNum'][$i]){?>
									<div class="U_input02_box">
										<label for="wr_13_num<?=$setNum?>">수량</label>
										<input name="wr_13_num<?=$setNum?>" id="wr_13_num<?=$setNum?>" readonly   value="<?=$wr_13_arr['opNum'][$i];?>" type="text" class="U_input02 wr_13_num" min="0" />
									</div>
									<?}?>
								</li>
							<?}?>
							</ul>
						</td>
					</tr>
				<?}?>

			</tbody>	
		</table>
	</section>

	<?if(get_view_thumbnail($view['content']) !== '부가설명이 있을경우 입력해주세요'){?>
    <section id="bo_v_atc" style="background:#f9f9f9">
        <h2 id="bo_v_atc_title">본문</h2>
		<strong class="U_tit02" >부가설명</strong>
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

		<?/*
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
		*/?>
	
        <?php
        include(G5_SNS_PATH."/view.sns.skin.php");
        ?>
    </section>
	<?}?>

    <?php
    // 코멘트 입출력
    //include_once(G5_BBS_PATH.'/view_comment.php');
     ?>

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


$(function(){

	$('a#change_wr7').on('click',function(){
		var txt = '<?=$view["wr_7"] ? "해당예약을 재개하시겠습니까?" : "해당예약을 종료하시겠습니까?" ?>';
		txt +='\n';
		txt += '<?=$view["wr_7"] ? "해당예약과 관련된 신청이 모두 예약가능상태가 됩니다." : "해당예약과 관련된 신청은 모두 예약불가상태가 됩니다." ?>';
		if(confirm(txt)){
			location.href = g5_bbs_url+'/board.php?bo_table='+g5_bo_table+'&wr_id=<?=$view["wr_id"]?>&change_wr7=true';
		}
		return false;
	});
});

$(function() {
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