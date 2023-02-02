<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ORDER BY bo_order ASC ";
$board = sql_fetch($sql);

if ($options)	list($width, $height, $wrap_width, $content_length) = explode(',', $options);
if (!$width) $width = 420;
if (!$height) $height = 760;
if (!$content_length) $content_length = 120;


?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->


<style>
	/* 섬네일 이미지 */
	.gal_list {*zoom:1; margin-top:30px; }
	.gal_list * {box-sizing:border-box;}
	.gal_list:after {display:block; clear:both; content:"";}
	.gal_list li {float:left; position:relative; width:25%; padding:0.7%; }
	.gal_list li .img_box {position:relative; left:0; top:0; width:100%; padding-top:100%; text-align:center; overflow:hidden; }
	.gal_list li .img_box a {display:block; width:100%; height:100%; }
	.gal_list li .img_box a img {position:absolute; top:0; right:0; bottom:0; left:0;  width:100%; height:auto;  margin:auto;}
	.gal_list li .info_box {/*display:none*/}
	
	/* 오버효과 */
	.gal_list li .img_box a:after {display:block; position:absolute; left:0; top:0;  width:100%; height:100%; background:rgba(52, 150, 213, 0.5); content:""; opacity:0;}
	.gal_list li .img_box a:before {display:inline-block; position:absolute; top:0; right:0; bottom:0; left:0; z-index:1; margin:auto; width:60px; height:60px; line-height:60px; border-radius:50% 50%; font-family: "FontAwesome";
font-size:18px; color:rgba(52, 150, 213, 1); content:"\f002"; background:#fff;  opacity:0;}
	.gal_list li .img_box a:before,
	.gal_list li .img_box a:after {transition:all 0.3s ease}
	.gal_list li .img_box a:hover:before,
	.gal_list li .img_box a:hover:after {opacity:1;}

	/* 텝메뉴 */
	/*
	.latest_nav{padding-left: 0;    margin-bottom: 0;    list-style: none;}
	.latest_nav ul{margin:0; padding:0; border:0;}
	.latest_nav>li>a {font-size:14px; padding: 10px 10px;}
	.latest_nav>li>a:focus, .latest_nav>li>a:hover {text-decoration: none; background-color:rgba(0, 0, 0, 0);}
	*/

	.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {color: #3496d5;   background-color: rgba(0, 0, 0, 0);  border-style:none;}
	.nav-tabs>li>a:hover {border-style:none; }
	.nav-tabs>li>a { border-style:none; font-size:14px;}

	/* 섬네일 정보*/
	.gal_list dl {display:none; height:60px; margin-top:10px;}
	.gal_list dt {font-size:16px;}
	.gal_list dd {font-size:13px;}
	
	/* responsive css */
	@media (min-width: 992px) and (max-width: 1199px) {
		.gal_list li {width:;} 
		.img_box {padding-top:;}
	}
	@media (max-width:768px) {
		.gal_list li {width:50%;} 
		.img_box {padding-top:;}
	}
	@media (max-width: 479px) {
		.gal_list li {width:50%;} 
		.img_box {padding-top:;}
	}
</style>
<script>

$(document).ready(function(){
	main_gallery_resize();
	
	$(window).on('resize', function(){
		main_gallery_resize();
	});
	
//	// 탭 클릭
//	$(document).on('click','#main_gallery .nav-tabs a',function() {
//		main_gallery_resize();
//	});
	

});

function main_gallery_resize() {
	//console.log('resize');
	var $list = $('.gal_list').find('li');

	var $box = $list.find('.img_box:first');
	var boxW = $box.innerWidth();
	var boxH = $box.innerHeight();
	var $img = $box.find('img:first');
	var imgW = $img.width();
	var imgH = $img.height();
	var imgW_per = imgW / (imgW + imgH);
	var boxW_per = boxW / (boxW + boxH);

	$list.each(function(i,e){
		if (imgW_per < boxW_per) {
			$img.css({'width':boxW, 'height':'auto'});
		} else if (imgW_per > boxW_per){
			$img.css({'height':boxH,'width':'auto','left':(boxW-imgW)/2});
		} else if (imgW == imgH){
			$img.css({'width':boxW, 'height':'auto'})
		}
	});
}
</script>
<div id="main_gallery">
	<ul class="nav nav-tabs">
	<?php
		$rsgroup2 = sql_query( $sqlgroup );
        $setStartTable = '?';
		for ( $g = 0; $row2 = sql_fetch_array( $rsgroup2 ); $g++ ) {
            if($g == 0) $setStartTable = $row2['bo_table'];
	?>
		<li><a href="#tab_<?=$row2['bo_table']?>" data-toggle="tab"><?=$row2['bo_subject']?></a></li>
	<? } ?>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="bo_table">
			<div class="gallery_wrap">
				<ul class="gal_list">		
				<?php
					for ( $i = 0; $i < count( $list ); $i++ ) {
						if ( $gr_id ) {
							$bo_table = $list[$i]['bo_table'];
						} else if ( $bo_table ) {
							$bo_table = $board['bo_table'];
						}
						$thumb = get_list_thumbnail( $bo_table, $list[$i]['wr_id'], $width, $height );
				?>
					<li>
						<div class="img_box">
							<a href="<?php echo $list[$i]['href']?>">
								<img src="<?php echo $thumb['ori']?>" alt="" />
							</a>
						</div>
						<dl class="info_box">
							<dt><a href="<?php echo $list[$i]['href']?>"><?=cut_str(get_text($list[$i]['subject']),20)?></a></dt>
							<dd class="gal_desc"><?=cut_str(strip_tags($list[$i]['wr_content']),20)?></dd>
						</dl>
					</li>
				<?php } ?>
				<?php if ( count( $list ) == 0 ) { ?>게시물이 없습니다.<?php } ?>
				</ul>
			</div>
		</div>
	<?php
		$rsgroup2 = sql_query( $sqlgroup );
		for ( $g = 0; $row2 = sql_fetch_array( $rsgroup2 ); $g++ ) {
			$sql_bo_table = "select * from ".$g5['write_prefix'].$row2['bo_table']." where wr_is_comment = 0";
			$sql_bo_table .= ( !$orderby ) ? "  order by wr_datetime desc " : "  order by ".$orderby." desc, wr_datetime desc "; 
			$sql_bo_table .= " limit ".$rows;
			$sql_result = sql_query( $sql_bo_table );
	?>	
		<div class="tab-pane" id="tab_<?=$row2['bo_table']?>">
			<div class="gallery_wrap">
				<ul class="gal_list">
				<?php
					for ( $g = 0; $row3 = sql_fetch_array( $sql_result ); $g++ ) {
						$thumb2 = get_list_thumbnail( $row2['bo_table'], $row3['wr_id'], $width, $height );
				?>
					<li>
						<div class="img_box">
							<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$row2['bo_table']?>&wr_id=<?=$row3['wr_id']?>">
								<img src="<?php echo $thumb2['ori']?>" alt="" />
							</a>
						</div>
						<dl class="info_box">
							<dt><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$row2['bo_table']?>&wr_id=<?=$row3['wr_id']?>"><?=cut_str(get_text($row3['wr_subject']),20)?></a></dt>
							<dd class="gal_desc"><?=cut_str(strip_tags($row3['wr_content']),20)?></dd>
						</dl>
					</li>
				<?php } ?>
				</ul>
			</div>	
		</div>
	<?php } ?>
	</div>
</div>

<script>
$(function(){

    $('#main_gallery  .nav-tabs li').eq(0).find('a').click();

});
</script>


<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->








