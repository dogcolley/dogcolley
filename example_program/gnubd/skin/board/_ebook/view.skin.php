<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_javascript('<script src="'.G5_JS_URL.'/viewimageresize.js"></script>', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
?>

<h2 id="container_title">
	<?//=($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?>
	<?php if ($sca) { ?> <span> &gt; <?php echo($sca); ?></span> <?php } ?>
	<span class="sound_only"> 목록</span>
</h2>
		
<article id="bo_v">			
	<header>
		<h1 id="bo_v_title">
			<?php if ($category_name) { ?>
			<div class="ttl_ca"><?php if ($category_name) echo ($category_name ? $view['ca_name'].' ' : ''); // 분류 출력 끝 ?></div>
			<?php } ?>
		</h1>
	</header>
	<section id="bo_v_info">
		<table class="table" id="book_info">
			<colgroup><col width="50%"><col width="50%"></colgroup>
			<thead>
				<td colspan="2">
					<p><span style="font-size:1.2em"><?=$view['wr_4']?></span></p><br />
					<p><strong style="margin:0px 0;font-size:2.5em"><?=$view['wr_subject']?></strong>  <span style="font-size:1.8em"><?=$view['wr_3']?></span></p>
				</td>
			</thead>
			<tbody>
				<!--<tr>
					<td colspan="2">
						저자명, 출판사, 출판일이 필요한경우에는 아래 주석을 제거해 주세요 -->
						<!--<?//=$view['wr_1']?>&emsp;|&emsp;<?=$view['wr_2']?>
						<?php if ($view['wr_5'] !== "") { ?>
						&emsp;|&emsp;<?//=$view['wr_5']?>
						<?php } ?>-->
						<!--저자명, 출판사, 출판일이 필요한경우에는 아래 주석을 제거해 주세요 
					</td>
				</tr>-->
				<tr>
					<td align="left">
						<?php if($is_admin){?>
						<p>
							<i class="fa fa-user" aria-hidden="true"></i> 
							<strong><?=$view['name'] ?><?php if ($board['bo_use_ip_view']) { echo "&nbsp;($ip)"; } ?></strong>&emsp;
							<span><i class="fa fa-clock-o" aria-hidden="true"></i><?=date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></span>&emsp;
							<span><i class="fa fa-eye" aria-hidden="true"></i><?=number_format($view['wr_hit']) ?>회</span>
							<!--<span><i class="fa fa-commenting-o" aria-hidden="true"></i><?=number_format($view['wr_comment']) ?>건</span>-->
						</p>
						<?php } ?>					
					</td>
					<td align="right">
						<?php
						if (! is_numeric($board['bo_1'])) $board['bo_1'] = 1;
						if ($member['mb_level'] >= $board['bo_1']) { //보기권한
						?>
							<font style="font-size:1em; font-weight:520;"></font>
							<button class="btn btn-sm btn-warning" onclick="nowWin(this);">접기</button>
							<button class="btn btn-sm btn-info" onclick="openWin(<?=$wr_id?>, 'view')">새창열기</button>
						<?php } ?>
						<?php if ($update_href) { ?>
							<span style="font-size:1.5em;"> | </span><button class="btn btn-sm btn-danger" onclick="openWin(<?=$wr_id?>, 'sort')">페이지 수정</button>
						<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>
	</section>
	<?php		
	if ($update_href) {
		if ($view['file']['count']) {
			$cnt = 0;
			for ($i=0; $i<count($view['file']); $i++) {
				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
					$cnt++;
			}
		}
	}
	?>
	
	<?php if ($cnt) { ?>
	<section id="bo_v_file">
		<h2>첨부파일</h2>
		<ul>
		<?php // 가변 파일
		for ($i=0; $i<count($view['file']); $i++) {
			if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
		?>
			<li>
				<a href="<?=$view['file'][$i]['href'];  ?>" class="view_file_download">
					<img src="<?=$board_skin_url ?>/img/icon_file.gif" alt="첨부">
					<strong><?=$view['file'][$i]['source'] ?></strong>
					<?=$view['file'][$i]['content'] ?> (<?=$view['file'][$i]['size'] ?>)
				</a>
				<span class="bo_v_file_cnt"><?=$view['file'][$i]['download'] ?>회 다운로드</span>
				<span>DATE : <?=$view['file'][$i]['datetime'] ?></span>
			</li>
		<?php
			}
		}
		?>
		</ul>
	</section>
	<?php } ?>

	<?/*php if ($view['link']) { ?>
	<section id="bo_v_link">
		<h2>관련링크</h2>
		<ul>
		<?php
		$cnt = 0;
		for ($i=1; $i<=count($view['link']); $i++) {
			if ($view['link'][$i]) {
				$cnt++;
				$link = cut_str($view['link'][$i], 70);
		?>
			<li>
				<img src="<?=$board_skin_url ?>/img/icon_link.gif" alt="관련링크">
				<a href="<?=$view['link_href'][$i] ?>" target="_blank">
					<strong><?=$link ?></strong>
				</a>
				<span class="bo_v_link_cnt"><?=$view['link_hit'][$i] ?>회 연결</span>
			</li>
		<?php
			}
		}
		?>
		</ul>
	</section>
	<?php } */?>
	

	
	<section id="bo_v_atc">
		<h2 id="bo_v_atc_title">본문</h2>
		
		<div id="book_container">
			<iframe id="book_iframe" src="<?=$board_skin_url."/lib/ebook_view.php?bo_table={$bo_table}&wr_id={$wr_id}"?>"></iframe>
		</div>
	
		<div id="bo_v_con"><?=get_view_thumbnail($view['content']); ?></div>
	
		<?php if ($is_signature) { ?><p><?=$signature ?></p><?php } ?>
		<?php if ($scrap_href || $good_href || $nogood_href) { ?>
		<div id="bo_v_act">
			<?php if ($scrap_href) { ?><a href="<?=$scrap_href; ?>" target="_blank" class="btn btn-default" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
			<?php if ($good_href) { ?>
			<span class="bo_v_act_gng">
				<a href="<?=$good_href.'&amp;'.$qstr ?>" id="good_button" class="btn btn-default">추천 <strong><?=number_format($view['wr_good']) ?></strong></a>
				<b id="bo_v_act_good"></b>
			</span>
			<?php } ?>
			<?php if ($nogood_href) { ?>
			<span class="bo_v_act_gng">
				<a href="<?=$nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn btn-default">비추천  <strong><?=number_format($view['wr_nogood']) ?></strong></a>
				<b id="bo_v_act_nogood"></b>
			</span>
			<?php } ?>
		</div>
		<?php } else {
			if($board['bo_use_good'] || $board['bo_use_nogood']) {
		?>
		<div id="bo_v_act">
			<?php if($board['bo_use_good']) { ?><span>추천 <strong><?=number_format($view['wr_good']) ?></strong></span><?php } ?>
			<?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?=number_format($view['wr_nogood']) ?></strong></span><?php } ?>
		</div>
		<?php
			}
		}
		?>
	<div id="bo_v_top">
		<?php ob_start(); ?>
		<div class="bo_v_bt1">
			<?php if ($prev_href || $next_href) { ?>
			<ul class="bo_v_nb">
				<?php if ($prev_href) { ?><li><a href="<?=$prev_href ?>" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li><?php } ?>
				<?php if ($next_href) { ?><li><a href="<?=$next_href ?>" class="btn btn-default"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li><?php } ?>
			</ul>
			<?php } ?>
			<div class="bo_v_write">
				<span><a href="<?=$list_href ?>" class="btn btn-default">목록</a></span>
				<?php if ($write_href) { ?><span><a href="<?=$write_href ?>" class="btn btn-default">글쓰기</a></span><?php } ?>
			</div>
		</div>
		
		<div class="bo_v_bt2">
			<ul class="bo_v_com">
				<?php if ($update_href) { ?><li><a href="<?=$update_href ?>" class="btn btn-dark">수정</a></li><?php } ?>
				<?php if ($delete_href) { ?><li><a href="<?=$delete_href ?>" class="btn btn-dark" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
				<?php if ($search_href) { ?><li><a href="<?=$search_href ?>" class="btn btn-default">검색</a></li><?php } ?>
			</ul>
		</div>
		<?php
			$link_buttons = ob_get_contents();
			ob_end_flush();
		?>
	</div>
		<?php include(G5_SNS_PATH."/view.sns.skin.php"); ?>
	</section>
	<?php// include_once(G5_BBS_PATH.'/view_comment.php'); ?>
	<div id="bo_v_bot">
		<!-- 링크 버튼 -->
		<?//=$link_buttons ?>
	</div>
</article>

<script>
var bo_table = '<?=$board['bo_table']?>';
function openWin(wr_id, mode) {
	if (mode === 'view') {
		window.open(
			'<?=$board_skin_url."/lib/ebook_view.php"?>?bo_table='+bo_table+'&wr_id='+wr_id,
			"E-Book View", "width=900, height=600, toolbar=no, menubar=no, scrollbars=1, resizable=yes"
		);
	} else if(mode === 'sort') {
		window.open(
			'<?=$board_skin_url."/lib/ebook_sort.php"?>?bo_table='+bo_table+'&wr_id='+wr_id,
			"E-Book Sort", "width=900, height=600, toolbar=no, menubar=no, scrollbars=1, resizable=yes"
		);
	}
}
function nowWin(btn) {
	var isOpen = $('#book_iframe').css('display');
	var iframe_src = '<?=$board_skin_url."/lib/ebook_view.php?bo_table={$bo_table}&wr_id={$wr_id}"?>';
	if (isOpen === 'none') {
		var agent = navigator.userAgent.toLowerCase();
		if ((navigator.appName == 'Netscape' && agent.indexOf('trident') != -1) || (agent.indexOf("msie") != -1)) {
			 alert("인터넷 익스플로러에서는 현재창에서 볼 수 없습니다. 새창을 이용해 주세요.");
			 return false;
		}
		$('#book_iframe').css('display', 'inline').attr('src', iframe_src);
		setTimeout(setFrameHeight(),300);
		btn.innerHTML = "접기";
	} else if(isOpen === 'inline') {
		$('#book_iframe').css('display', 'none').attr('src', '');
		btn.innerHTML = "펼쳐보기";
	}
}
function setFrameHeight() {
	var deviceWidth = document.documentElement.clientWidth;
	var deviceHeight = document.documentElement.clientHeight;
	
	// 클라이언트 화면 가로:세로 비율
	var iframeRatio = ( deviceWidth / deviceHeight );
	
	// Iframe의 가로:세로 비율을 클라이언트 화면 비율로 맞춤
	var iframeWidth = $('#book_iframe').css('width').replace("px","");
	var iframeHeight = Math.round(Number(iframeWidth / iframeRatio));
	$('#book_iframe').css('height', iframeHeight + "px");	
}

<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }
        var msg = "파일을 다운로드 하시면 포인트가 차감(<?=number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";
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

function board_move(href) {
	alert('이 스킨에서는 복사/이동을 지원하지 않습니다.');
	return false;
    //window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}

$(function() {
	setFrameHeight()
	
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

function excute_good(href, $el, $tx) {
    $.post(href, { js: "on" }, function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }
            if (data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if ($tx.attr("id").search("nogood") > -1) {
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