<?php
	include_once("./_common.php");
	include_once("./pclzip.lib.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Page Sort</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		$bo_table = $_REQUEST['bo_table'];
		$wr_id = $_REQUEST['wr_id'];
        
		// 수정권한 체크
		if ($is_admin == 'super') {// 최고관리자 통과
			;
		} else if ($is_admin == 'group') { // 그룹관리자
			$mb = get_member($write['mb_id']);
			if ($member['mb_id'] != $group['gr_admin']) { // 자신이 관리하는 그룹인가?
				alert_close('자신이 관리하는 그룹의 게시판이 아니므로 수정할 수 없습니다.');
			} else if ($member['mb_level'] < $mb['mb_level']) { // 자신의 레벨이 크거나 같다면 통과
				alert_close('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.');
			}
		} else if ($is_admin == 'board') { // 게시판관리자이면
			$mb = get_member($write['mb_id']);
			if ($member['mb_id'] != $board['bo_admin']) { // 자신이 관리하는 게시판인가?
				alert_close('자신이 관리하는 게시판이 아니므로 수정할 수 없습니다.');
			} else if ($member['mb_level'] < $mb['mb_level']) { // 자신의 레벨이 크거나 같다면 통과
				alert_close('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.');
			}
		} else if ($member['mb_id']) {
			if ($member['mb_id'] !== $write['mb_id']) {
				alert_close('자신의 글이 아니므로 수정할 수 없습니다.');
			}
		} else {
			if ($write['mb_id']) {
				//alert('로그인 후 수정하세요.', G5_URL.'/bbs/login.php?url='.urlencode(G5_URL.'/bbs/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));
				//alert_close('로그인 후 수정하세요.');
				alert_close('로그인 후 수정하세요.');
			} else if (!check_password($wr_password, $write['wr_password'])) {
				alert_close('비밀번호가 틀리므로 수정할 수 없습니다.');
			}
		}
		
		$sql = " SELECT * FROM g5_write_{$bo_table} WHERE wr_id='{$wr_id}' ";
		$book_info = sql_fetch($sql);
		//print_r2($book_info);
		
		$sql = sql_query(" SELECT * FROM {$g5['board_file_table']} WHERE bf_no='0' AND bo_table='{$bo_table}' AND wr_id='{$wr_id}' AND (bf_no=0 OR bf_no=1) ");
		$book_cover = sql_fetch_array($sql);
		//print_r2($book_cover);
		
		$sql = sql_query(" SELECT * FROM {$g5['board_file_table']} WHERE bf_no='1' AND bo_table='{$bo_table}' AND wr_id='{$wr_id}' AND (bf_no=0 OR bf_no=1) ");
		$book_zip = sql_fetch_array($sql);
		//print_r2($book_zip);
		
		$book_path = G5_DATA_PATH.'/file/'.$bo_table;
		$book_uri = G5_URL.'/data/file/'.$bo_table.'/'.substr($book_zip['bf_file'], 0, strrpos($book_zip['bf_file'], "."));
		
		$temp = explode('.', $book_zip['bf_file']);
		$book_dir =  preg_replace("/.{$temp[sizeof($temp)-1]}/", '', $book_zip['bf_file']);
		
		if ( is_file($book_path.'/'.$book_zip['bf_file']) && is_dir($book_path.'/'.$book_dir)){
			//echo "기존 압축해제된 내용 보여주는 중..";
			$sql = " SELECT mta_value AS files FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND  mta_db_id='{$wr_id}' ";
			$meta = sql_fetch($sql);
			$meta_array = unserialize($meta['files']);
			//print_r2($meta_array);
		} else {
			// 압축파일 없음.
			alert_close('Book 파일이 존재하지 않습니다.');
		}
	?>
	
	<!-- JS dependencies -->
    <script src="./BookReader/jquery-1.10.1.js"></script>
    <script src="./BookReader/jquery-ui-1.12.0.min.js"></script>
    <script src="./BookReader/jquery.browser.min.js"></script>
    <script src="./BookReader/dragscrollable-br.js"></script>
    <script src="./BookReader/jquery.colorbox-min.js"></script>
    <script src="./BookReader/jquery.bt.min.js"></script>

    <!-- mmenu library -->
    <link rel="stylesheet" href="./BookReader/mmenu/dist/css/jquery.mmenu.css"/>
    <link rel="stylesheet" href="./BookReader/mmenu/dist/addons/navbars/jquery.mmenu.navbars.css"/>
    <script src="./BookReader/mmenu/dist/js/jquery.mmenu.min.js"></script>
    <script src="./BookReader/mmenu/dist/addons/navbars/jquery.mmenu.navbars.min.js"></script>

    <!-- BookReader and plugins -->
    <link rel="stylesheet" href="./BookReader/BookReader.css"/>
    <script src="./BookReader/BookReader.js"></script>

    <!-- Mobile nav plugin -->
    <script src="./BookReader/plugins/plugin.mobile_nav.js"></script>

    <!-- URL-changing plugin -->
    <script src="./BookReader/plugins/plugin.url.js"></script>
	
	<script>
		$(function(){
			$('#sortable').sortable({ 
				revert: true
				/*
				,start: function(event, ui) {
						$(this).attr('data-currentindex', ui.item.index());
				 },
				 update: function(event, ui) {
					var id = ui.item;
					var current_position = $(this).attr('data-currentindex');
					var desired_position = ui.item.index();
				 }
				 */
			});
		});
		
		function saveChange(){
			
			var str = "";
			var pageArray = [];
			var book_page = $('.book_page');
			
			/* 개행문자(#TEXT) 배제불가 이슈
			var elems = document.getElementById('sortable').childNodes;
			for(var i=0; i<elems.length; i++){
				str += elems[i].nodeName;
			}*/
			/* Rest param - ES6문법, IE 지원안됨.
			[...document.querySelectorAll('.book_page')].forEach(function(el){
				str += el.id;
			});*/
			
			for(var i=0; i<book_page.length; i++){
				str += book_page[i].id+",";
			}
			
			$('#result').val(str);
			return false;
		}
		
		function enlarge(){

			var width1 = $('ul#sortable li').css('width').replace("px","");
			var height1 = $('ul#sortable li').css('height').replace("px","");
			
			var width2 = $('li.book_page img').css('width').replace("px","");
			var height2 = $('li.book_page img').css('height').replace("px","");
			
			$('ul#sortable li').css('width', width1*1.1);
			$('ul#sortable li').css('height', height1*1.1);
			
			$('li.book_page img').css('width', width2*1.1);
			$('li.book_page img').css('height', height2*1.1);
		}
		
		function reduct(){

			var width1 = $('ul#sortable li').css('width').replace("px","");
			var height1 = $('ul#sortable li').css('height').replace("px","");
			
			var width2 = $('li.book_page img').css('width').replace("px","");
			var height2 = $('li.book_page img').css('height').replace("px","");
			
			$('ul#sortable li').css('width', width1*0.9);
			$('ul#sortable li').css('height', height1*0.9);
			
			$('li.book_page img').css('width', width2*0.9);
			$('li.book_page img').css('height', height2*0.9);
		}
	</script>
	<style>
		html, body { width: 100%; height: 100%; margin: 0; padding: 0; }
		.container { width: 100%; margin: 45px 5px 0px 5px; }
		ul#sortable { list-style-type: none; margin: 0; padding: 0; }
		ul#sortable li { margin: 5px; padding: 0; width: 150px; height: 195px; background-color: #bebe; float: left;}
		.btn-save { margin-top: 5px; height: 40px; font-size:20px; color: #7a7a7a; border: 1px solid #fefe; background-color: #f7f7f7; }
		.sort_left { left:0; background-color:red; color:white; }
		.sort_right { right:0; background-color:blue; color:white; }
		.sort_control {
			cursor: pointer;
			text-align:center;
			line-height:1.5em;
			font-weight:700;
			font-size:1.3em;
			width:50%;
			height:20%;
			display:block;
			position:absolute;
			bottom:0;
			
			background: #000;
			opacity: 0.4;
			
			/* ie 5,6,7 bug fix */
			filter: alpha(opacity=40);
			zoom: 1;
		}
	</style>
</head>
<body style="background-color: #3a3b3b;">

	<div class="BRtoolbar" style="height:50px;">
		<span class="BRtoolbarLeft"></span>
		<span class="BRtoolbarRight">
			<span class="BRtoolbarSection">
				<button type="button" class="BRicon zoom_out js-tooltip" title="Zoom out" onclick="reduct()"></button>
				<button type="button" class="BRicon zoom_in js-tooltip" title="Zoom in" onclick="enlarge()"></button>
			</span>
			
			<span class="BRtoolbarSection">
				<form action="./ebook_sort_update.php" method="post" onsubmit="saveChange()">
					<input type="hidden" name="bo_table" value="<?=$bo_table?>">
					<input type="hidden" name="wr_id" value="<?=$wr_id?>">
					<input type="hidden" name="result" id="result" value="">
					<button class="btn-save" type="submit">Save Change</button>
				</form>
			</span>
			
		</span>
	</div>
	
	<div class="BRcontainer"  style="top: 50px; bottom: 0px; overflow: auto;">
		<ul id="sortable">
		<?php for($i=0; $i<sizeof($meta_array); $i++){ ?>
			<li class="book_page" id="page_<?=$i?>" style="position:relative; display:inline;">
				<img src="<?=$book_uri?>/<?=$meta_array[$i]?>" width="150" height="195" style="position:absolute;">
				
				<span class="sort_control sort_left">◀</span><!--&lt;&lt;-->
				<span class="sort_control sort_right">▶</span><!--&gt;&gt;-->
				
			</li>
		<?php } ?>
		</ul>
	</div>
	
	<script type="text/javascript">
		$(".sort_left").on("click", function () {
			var srcLi = $(this).parents(".book_page");
			var tgtLi = srcLi.prev();
			if (tgtLi[0]) {
				tgtLi.before(srcLi);
			}
			//var order = getOrder(".book_page", $("#sortable")[0]);
			//console.log(order);
		});
	
		$(".sort_right").on("click", function () {
			var srcLi = $(this).parents(".book_page");
			var tgtLi = srcLi.next();
			if (tgtLi[0]) {
				tgtLi.after(srcLi);
			}
			//var order = getOrder(".book_page", $("#sortable")[0]);
			//console.log(order);
		});
	
		function getOrder(selector, container) {
			var order = [];
			$(selector, container).each(function () {
				order.push(this.id);
			});
			return order;
		}
	</script>

</body>
</html>
