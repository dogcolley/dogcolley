<!DOCTYPE html>
<html>
<head>
	<title>BookReader</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
	<?php
		include_once("./_common.php");
		include_once("./pclzip.lib.php");
		
		if (!isset($_REQUEST['bo_table']) || !isset($_REQUEST['wr_id'])) {
			alert_close('잘못된 접근입니다.');
			exit;
		}

    $bo_table = $_REQUEST['bo_table'];
		$wr_id = $_REQUEST['wr_id'];
		
		$sql = " SELECT * FROM ".G5_TABLE_PREFIX."write_{$bo_table} WHERE wr_id='{$wr_id}' ";
		$book_info = sql_fetch($sql);
		
		$book_file = get_file($bo_table, $wr_id);
		$book_cover = $book_file[0];
		$book_zip = $book_file[1];
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

    <style type="text/css">
		html, body { width: 100%; height: 100%; margin: 0; padding: 0; }
		#BookReader { width: 100%; height: 100%; }
		#BRpageview { margin-top: 15px; }
    </style>
</head>
<body style="background-color:#3a3b3b;">

	<div style="width:100%;height:20px;margin:30px;display:none;">
	<?php
		$book_path = G5_DATA_PATH.'/file/'.$bo_table;
		$book_uri = G5_URL.'/data/file/'.$bo_table.'/'.substr($book_zip['file'], 0, strrpos($book_zip['file'], "."));
		
		$ext = end(explode('.', $book_zip['file']));
		$book_dir =  preg_replace("/.{$ext}/i", '', $book_zip['file']);
		
		// 보기권한 검사
		if (! is_numeric($board['bo_1'])) $board['bo_1'] = 1;
		if ($member['mb_level'] >= $board['bo_1']) {
			;
		} else alert_close('보기 권한이 없습니다. 관리자에게 문의해 주세요.');
		
		// zip 파일이 아닌 파일이 업로드 되어 있음.
		if (is_file($book_path.'/'.$book_zip['file']) && $ext !== 'zip')
			alert_close('올바른 파일 형식이 아닙니다.');
		else if ( is_file($book_path.'/'.$book_zip['bf_file']) && !is_dir($book_path.'/'.$book_dir)) // 압축파일 있음, 압축해제한 폴더 없음.
			alert_close('업로드된 파일이 없습니다.');
		else if ( is_file($book_path.'/'.$book_zip['file']) && is_dir($book_path.'/'.$book_dir)) { // 압축파일 있음, 압축해제한 폴더 있음.
			//echo "기존 압축해제된 내용 보여주는 중..";
			$sql = " SELECT mta_value AS files FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND  mta_db_id='{$wr_id}' ";
			$meta = sql_fetch($sql);
			$meta_array = unserialize($meta['files']);
		} else { // 압축파일 없음.
	?>
		<script type="text/javascript">
		$('body').append('<h1 style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);color:white;">업로드 준비중 입니다.</h1>');
		</script>
	<?php
			exit;
		}
		
		// 페이지 컨텐츠 나열.
		$js_str = "";
		for ($i=0; $i<sizeof($meta_array); $i+=2) {
			if ($i+2>sizeof($meta_array) && (sizeof($meta_array)%2)===1){
				// 마지막 페이지로 짝수가 남았을 경우
				$js_str .=  " [ ";
				$js_str .= "{ width: 800, height: 1200, uri: '".$book_uri."/".$meta_array[$i]."' }";
				$js_str .=  " ], ";
			} else {
				$js_str .=  " [ ";
				$js_str .= "{ width: 800, height: 1200, uri: '".$book_uri."/".$meta_array[$i]."' },";
				$js_str .= "{ width: 800, height: 1200, uri: '".$book_uri."/".$meta_array[$i+1]."' },";
				$js_str .=  " ], ";
			}
		}
		
		// 썸네일을 구해서 책 상세정보에 넣음.
		$thumb = get_list_thumbnail($bo_table, $wr_id, 200, 284, true, true, 'center');
		if ($thumb['src']) {
			$img_src = $thumb['src'];
		} else {
			$thumb_no = thumbnail('no_img.png', $board_skin_path.'/img', G5_DATA_PATH.'/no_img', 200, 284, false, true, 'center');
			$img_src = G5_DATA_URL."/no_img/".$thumb_no;
		}
	?>
	</div>
	<div id="BookReader"></div>
	<script type="text/javascript">
	//
	// This file shows the minimum you need to provide to BookReader to display a book
	//
	// Copyright(c)2008-2009 Internet Archive. Software license AGPL version 3.

	//var bookCoverURI = "<?=G5_URL.'/data/file/'.$bo_table.'/'.$book_cover['bf_file'] ?>";
	var bookCoverThumb = "<?=$img_src?>";
	
	// Create the BookReader object
	var options = {
	  data: [
		//[ { width: 800, height: 1200, uri: bookCoverURI } ],
		<?=$js_str?>
	  ],
	  // Book title and the URL used for the book title link
	  /*bookTitle: '<?=$book_info['wr_subject']?>',
	  bookUrl: '#',//'javascript:self.close()',
	  bookUrlText: '<?=$book_info['wr_3']?>',
	  bookUrlTitle: 'The book URL title',

	  // thumbnail is optional, but it is used in the info dialog
	  thumbnail: bookCoverThumb,
	  // Metadata is optional, but it is used in the info dialog
	  metadata: [
			{label: 'Title', value: '<?=$book_info['wr_subject']?>'},
			{label: 'SubTitle', value:'<?=$book_info['wr_3']?>' },
			{label: 'Author', value: '<?=$book_info['wr_1']?>'},
			{label: 'Publisher', value: '<?=$book_info['wr_2']?>'},
	  ],*/

	  // Override the path used to find UI images
	  imagesBaseURL: './BookReader/images/',
	  ui: 'full', // embed, full (responsive)
	  el: '#BookReader',
	  
	  // Should image downloads be blocked
	  protected: true,
	  // Page progression. Choices: 'lr', 'rl'
	  <?php $page_progression = ($book_info['wr_6']==='lr' || $book_info['wr_6']==='rl') ? $book_info['wr_6'] : "lr"; ?>
	  pageProgression: '<?=$page_progression?>',
	  showLogo: false,
	  logoURL: '#',
	};
	
	var br = new BookReader(options);
	br.init();
	
	</script>
</body>
</html>
