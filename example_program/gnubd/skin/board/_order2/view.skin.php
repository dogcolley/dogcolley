<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
.order_list { text-align: center; }
.order_list th { width:110px;font-weight:bold;text-align:center;background:#f3f3f3; }
</style>
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
	<!--
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo ($category_name ? $view['ca_name'].' | ' : ''); // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
	-->		
    </header>
<?/*
    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <span class="bo_v_info_tit">작성자</span> <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
    </section>
*/?>
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
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01 pre_bt">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01 next_bt">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php /* if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_admin">수정</a></li><?php } */ ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_admin" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <!-- <?php if ($copy_href) { ?><li><a href="<//?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?> -->
            <!-- <?php if ($move_href) { ?><li><a href="<//?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?> -->
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
            <?php /*if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } */?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">상품주문</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>

    <section id="bo_v_atc">
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
		<div class="row" id="bo_v_con">
			<div class="col-sm-12 wrap">
				<table>
                    <tbody>
						<tr>
							<td>주문일자</td>
							<td><?php echo date("Y-m-d H:i:s", strtotime($view['wr_datetime'])) ?></td>
						</tr>
						<tr>
							<td>이름</td>
							<td>&nbsp<?echo $view['name']?></td>
						</tr>
						<tr>
							<td>휴대폰번호 </td>
							<td><?echo $view['wr_4']?></td>
						</tr>
						<tr>
							<td>이메일 </td>
							<td><?echo $view['wr_email']?></td>
						</tr>
						<tr>
							<td>배송주소 </td>
							<td>[<?echo $view['wr_1']?>]<br><?echo $view['wr_2']?><br><?echo $view['wr_3']?><br><?echo $view['wr_4']?></td>
						</tr>
						<tr>
							<td>주문내역 </td>
							<td>
								<table class="order_list">
									<tr>
										<th>주문상품</th>
										<th>가격</th>
										<th>단위</th>
										<th>주문수량</th>
									</tr>
									<?php
									for ( $i = 0; $i < $view['wr_goods']; $i++ ) {
									?>
										<tr>
											<td><?=$view['wr_goods_name_'.$i]?></td>
											<td><?=$view['wr_goods_price_'.$i]?></td>
											<td><?=$view['wr_goods_measure_'.$i]?></td>
											<td><?=$view['wr_goods_count_'.$i]?></td>
										</tr>
									<?
										}
									?>
								</table>
							</td>
						</tr>
						<tr>
							<td>주문금액 </td>
							<td><?echo $view['wr_total_price']?> 원</td>
						</tr>
						<tr>
							<td>주문상태 </td>
							<td>
							<?php
								if ( empty( $view['wr_10'] ) ) {
									echo "대기중";
								} else if ( $view['wr_10'] == "배송중" ) {
									echo "<font color='blue'>".$view['wr_10']."</font>";
								} else if ( $view['wr_10'] == "배송완료" ) {
									echo "<font color='red'>".$view['wr_10']."</font>";
								}
							?>
							</td>
						</tr>
						<?php if ( $member['mb_level'] >= 8 ) { ?>
						<tr>
							<td>송장번호 </td>
							<td>
								<input type="text" name="wr_5" id="wr_5" value="<?=$view['wr_5']?>" class="frm_input input02">
								<input type="button" id="portnum" class="btn btn-default" value="등록">
								<?php if ( !empty( $view['wr_5'] ) ) { ?>
								<input type="button" id="complete" class="delivery_complete" value="배송완료">
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
				    </tbody>			
				</table>		
			</div>
		</div> 
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php
        include(G5_SNS_PATH."/view.sns.skin.php");
        ?>
    </section>

    <?php/*
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
    */?>

    <div id="bo_v_bot">
        <!-- 링크 버튼 -->
        <?php echo $link_buttons ?>
    </div>

</article>

<script>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->

<script>
$( '#portnum' ).click( function () {
	$.ajax( {
		"url" : "<?=$board_skin_url?>/ajax/portnum_regist.php",
		"type" : "POST",
		"data" : {
			"status" : "regist",
			"bo_table" : "<?=$bo_table?>",
			"id" : "<?=$wr_id?>",
			"portnum" : $( '#wr_5' ).val()
		},
		"dataType" : "json",
		"success" : function ( data, textStatus ) {
			alert( '송장번호가 등록되었습니다.' );
			location.reload();
		}
	} );
} );

$( '#complete' ).click( function () {
	$.ajax( {
		"url" : "<?=$board_skin_url?>/ajax/portnum_regist.php",
		"type" : "POST",
		"data" : {
			"status" : "complete",
			"bo_table" : "<?=$bo_table?>",
			"id" : "<?=$wr_id?>"
		},
		"dataType" : "json",
		"success" : function ( data, textStatus ) {
			alert( '배송완료 처리되었습니다.' );
			location.reload();
		}
	} );
} );

$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>