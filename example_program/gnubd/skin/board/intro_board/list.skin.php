<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//wr_subject => 성명, wr_1 => 인사말, wr_2 => 직업, wr_3 => 간단소개(외부노출), wr_4 => 직급, wr_content => 내용 wr_good => 노출 순서
$sql_c = "SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='{$g5['write_prefix']}{$bo_table}' AND COLUMN_NAME='wr_1'";
$res_c = sql_fetch($sql_c);
if($res_c['DATA_TYPE'] != 'text'){
    sql_query("ALTER TABLE {$g5['write_prefix']}{$bo_table} CHANGE COLUMN  wr_1 wr_1 TEXT");
}

$sql_c = "SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='{$g5['write_prefix']}{$bo_table}' AND COLUMN_NAME='wr_3'";
$res_c = sql_fetch($sql_c);
if($res_c['DATA_TYPE'] != 'text'){
    sql_query("ALTER TABLE {$g5['write_prefix']}{$bo_table} CHANGE COLUMN  wr_3 wr_3 TEXT");
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css?ver=20201208">', 0);

	if($board['bo_1'] == 'center'){
		$align = 'text-align:center;';
	}
	if($board['bo_1'] == 'left'){
		$align = 'text-align:left;';
	}
	if($board['bo_1'] == 'right'){
		$align = 'text-align:right;';
	}
	if($board['bo_1'] == ''){
		$align = 'text-align:left;';
    }
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.15.3/tingle.min.js" integrity="sha512-plGUER9JkeEWPPqQBE4sdLqBoQug5Ap+BCGMc7bJ8BXkm+VVj6QzkpBz5Yv2yPkkq+cqg9IpkBaGCas6uDbW8g==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.15.3/tingle.min.css" integrity="sha512-j1u8eUJ4f23xPPxwOrLUPQaCD2dwzNqqmDDcWS4deWsMv2ohLqmXXuP3hU7g8TyzbMSakP/mMqoNBYWj8AEIFg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js" integrity="sha512-kp7YHLxuJDJcOzStgd6vtpxr4ZU9kjn77e6dBsivSz+pUuAuMlE2UTdKB7jjsWT84qbS8kdCWHPETnP/ctrFsA==" crossorigin="anonymous"></script>
<style>
    
.tingle-modal{background: rgb(0 0 0 / 40%) !important; overflow: auto !important; z-index: 999999 !important;}
.tingle-modal:before {
    -webkit-backdrop-filter: blur(18px);
    backdrop-filter: none !important;
}
/* .tingle-modal-box  .tingle-modal-box__content{
  height: 50vmin;
  overflow-y: auto;
  background: silver;
} */
.tingle-modal-box {border-radius: 5px !important; max-width: 500px  !important;}

.tingle-modal-box .tingle-modal-box__header{
    /* border-radius: 25rem 25rem 0 0; */
    border-bottom: .1rem solid var(--gray);
    /* padding-top: .1rem; */
    background-color: #396dac;
    padding: 20px 5px;
}
.tingle-modal-box .tingle-modal-box__header h2{
    text-align: center;
    font-weight: 530;
    font-size: 1.6rem;
    color: white;
}
.tingle-modal-box  .tingle-modal-box__header *{
    background: var(--light);
    border-radius: 0;
}

.tingle-modal-box .tingle-modal-box__header2{
    padding: 20px;
}
.tingle-modal-box .tingle-modal-box__header2 .tingle-btn--default{
    /* padding: 0  !important; */
    width: 50%;
    margin: 0 !important;
    color: gray !important;
    background-color: white !important;
    border: 1px solid #c8c8c8 !important;
    font-size: 1rem !important;
	background:#fff;
	font-weight:400;
}
.tingle-modal-box .tingle-modal-box__header2 .tingle-btn--default:focus{
	border:0px solid #1c3f6a !important;
	outline:0px !important;
	border-radius:0px !important;
	background:#6a97ce !important;
	color:#fff !important;
	font-weight:800;
}
.tingle-modal-box__content {
    padding: 2rem 2rem !important;
}
body ::-webkit-scrollbar {
    width: 8px;
}
body ::-webkit-scrollbar-button {
    width: 8px;
    height:5px;
}
body ::-webkit-scrollbar-track {
    background:#eee;
    border: thin solid lightgray;
    box-shadow: 0px 0px 3px #dfdfdf inset;
    border-radius:10px;
}
body ::-webkit-scrollbar-thumb {
    background:#999;
    border: thin solid gray;
    border-radius:10px;
}
body ::-webkit-scrollbar-thumb:hover {
    background:#7d7d7d;
}        

</style>

<script>
    $(window).resize(function() {
        if(this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function() {
            $(this).trigger('resizeEnd');
        }, 500);
    });
    function imgResizeFunc(){
        $('.tingle-modal-box__content img').each(function(){
            if($(this).outerWidth() > $('.tingle-modal-box__content').innerWidth() ){
                $(this).css({width:'100%'})
            }/*else{
                $(this).removeAttr('style');
            }*/
        });
    }
    $(function(){
        $(window).on('resizeEnd',function(){
            imgResizeFunc();
        });
    });
</script>

<div class="title_box"> 
<h2 id="container_title" style="display: inline-block; vertical-align: top; font-size: 32px; margin-top: 20px; color: #333333; font-weight: 700; line-height: 100%; border-bottom: 0px;"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?><span class="sound_only"> 목록</span></h2>
</div>
<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">


    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="cate_mo dropdown" style="padding-bottom: 10px;">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
		<?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <?php echo $category_option ?>
        </ul>
    </nav>
	
    <nav id="bo_cate_pc" class="cate_pc" style="padding-bottom: 10px;">
        <!--<h2><?php //echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> </h2>-->
        <div id="bo_cate_pc_ul">
            <?php echo $category_option ?>
        </div>
    </nav>
	<script>
		$('#bo_cate_pc_ul li').each(function(){
			$(this).attr('class','btn_b02');
		});
		
		if($(window).width() <= 767){
			$('#bo_cate_pc').hide();
			$('#bo_cate').show();
		}
		else{
			$('#bo_cate_pc').show();
			$('#bo_cate').hide();
		}
		
		$(window).resize(function(){
			if($(window).width() <= 767){
				$('#bo_cate_pc').hide();
				$('#bo_cate').show();
			}
			else{
				$('#bo_cate_pc').show();
				$('#bo_cate').hide();
			}
		});
		
	</script>
	<?php } ?>

<?/*
    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
        <fieldset id="bo_sch">
            <legend>게시물 검색</legend>

            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl">
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
                <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
                <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
            </select>
            <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required frm_input" size="15" maxlength="20">
            <input type="submit" value="검색" class="btn_submit">
            </form>
        </fieldset>
    </div>
*/?>
    
    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <div class="info_class">
            <ul class="info_box" style="">
                <?php
                // echo "<pre>";
                for ($i=0; $i<count($list); $i++) {
                    // print_r($list[$i]);
                ?>
                    <li class="info_box_li">
                        <dl>
                            <dt class="info_box_dt"><?php if($is_admin) { ?><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">&nbsp;<a href="<?php echo $list[$i]['href'] ?>"><?php } ?>
							<? if($list[$i]['wr_4']) { ?><span class="info_box_job"><?=$list[$i]['wr_4']; ?></span><? } ?><span class="info_box_name"><?=$list[$i]['wr_subject']?></span><?php if($is_admin) { echo "</a>"; } ?></dt>
							<dt class="info_box_work"><?=$list[$i]['wr_2']?></dt>
                            <dd class="info_box_dd1"><?=nl2br($list[$i]['wr_3'])?></dd>
                            <dd class="info_box_dd2"><input type="button" data-target="modal_starthere" class="modal_<?=$list[$i]['wr_id']?>" value="약력 더보기" onclick="imgResizeFunc();"></dd>
                        </dl>
                    </li>
                <? } ?>
                <?php if (count($list) == 0) { echo '게시물이 없습니다.'; } ?>
            </ul>
        </div>
			
      

        <?php /*if($is_admin){ ?>
        <table style="margin-top: 50px;">
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
			<th scope="col" style="width:50px;">번호</th>
            <th scope="col" style="width:530px;">제목</th>
            <th scope="col" style="width:100px;">작성자</th>
			<!--<th scope="col" style="width:100px;">상태</th>-->
			<th scope="col"style="width:130px;"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>작성일</a></th>
        </tr>
        </thead>
        <tbody>
			

        <?php 
        for ($i=0; $i<count($list); $i++) {
        ?>

        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
			<td style="text-align: center;">
				<?php 
					if ( $list[$i]['is_notice'] ) {
						echo "공지";
					} else {
                        // echo $list[$i]['num'];
                        // echo $list[$i]['num'] < 10 ? '0'.$list[$i]['num'] : $list[$i]['num'];
                        echo sprintf("%02d", $list[$i]['num']);
					}
				?>
			</td>
            <td class="td_subject" style="<?=$align;?> ">
                <?php
                if ($is_category && $list[$i]['ca_name']) {
                ?>                
				<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
				<?echo $list[$i]['icon_reply'];?>
                    <?php echo $list[$i]['subject'] ?>
					<?php if ($list[$i]['comment_cnt']) { ?> 댓글 <?php echo $list[$i]['comment_cnt']; ?>개<?php } ?>
					<?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                    if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                    if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                    if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                    if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                    if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                    ?>
                </a>
				<td style="text-align: center;"><?=$list[$i]['wr_name']?>
				<!--<td style="text-align: center;">
					<?php
						if ($list[$i]['comment_cnt']) {
							echo '<font color="red">답변완료</font>';
						}else {
							echo '<font color="gray">대기중</font>';
						}
					?>
				</td>-->
            </td>
            <td class="td_date"><?php echo substr($list[$i]['wr_datetime'],0,10) ?></td>
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
        <?php }*/ ?>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($rss_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b02">RSS</a></li><?php } ?>
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
                <?php if ($write_href) { ?><li clss="write_btn"><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
            </ul>
         <?php } ?>
         
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b02"> 목록</a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    
    </form>
</div>


<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>
<script type="text/babel">
<?php if ($is_checkbox) { ?>



function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}
<?php } ?>

<?php for($i=0; $i<count($list); $i++) { ?>
var btn<?=$list[$i]['wr_id']?> = document.querySelector('.modal_<?=$list[$i]['wr_id']?>');
btn<?=$list[$i]['wr_id']?>.addEventListener('click', function(){
    var modalSurprise = new tingle.modal({
        onClose: function(){
            modalSurprise.destroy();
        }
    });
    imgResizeFunc();
    // var title = "<div class='tingle-modal-box__footer'>";
    // var title = "<button class='tingle-btn tingle-btn--default'>인사말</button>";
    // title += "<button class='tingle-btn tingle-btn--default'>약력</button>";
    // title += "</div>";
    // var content = '<?//=get_view_thumbnail($list[$i]['wr_content'])?>';
    modalSurprise.setContent(`<?=get_view_thumbnail($list[$i]['wr_content'])?>`);
    modalSurprise.setHeader=function(content){
        $(".tingle-modal-box__content").before('<div class="tingle-modal-box__header">'+content+'</div>');
    }
    modalSurprise.setHeader2=function(content){
        $(".tingle-modal-box__content").before('<div class="tingle-modal-box__header2">'+content+'</div>');
    }
    modalSurprise.setHeader("<h2><?=$list[$i]['wr_subject']?></h2>");
    modalSurprise.setHeader2("<button class='tingle-btn tingle-btn--default intro1'>인사말</button><button class='tingle-btn tingle-btn--default intro2'>약력</button>");
    modalSurprise.open();

    
    setTimeout(() => {
        imgResizeFunc();
        $('.intro2').focus();
        $('.intro1').on('click', function(){
            modalSurprise.setContent(`<?=get_view_thumbnail($list[$i]['wr_1'])?>`);
            imgResizeFunc();
			$(this).css({
				"border" : "2px solid #245188"
			});
        });
        $('.intro2').on('click', function(){
            modalSurprise.setContent(`<?=get_view_thumbnail($list[$i]['wr_content'])?>`);
            imgResizeFunc();
			$(this).css({
				"border" : "2px solid #245188"
			});
        });
    }, 100);
});

<?php } ?>


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

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
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
<!-- 게시판 목록 끝 -->
