<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 한글 파일명 보기위한 EUC-KR
header('Content-Type: text/html; charset=EUC-KR');
include_once(__DIR__."/lib/pclzip.lib.php");

// 2번 파일에 업로드된 Zip 파일이 있으면 압축을 푼다.
if ($_FILES['bf_file']['name'][1]!='') {
	$org = $_FILES['bf_file']['name'][1];
	$ext = end(explode(".",$org));
	
	if (preg_match("/zip/i", $ext) === 1) {
		// 압축해제할 폴더명은 압축파일에서 .zip를 땐 이름
		$extract_dir = G5_DATA_PATH.'/file/'.$bo_table.'/'.preg_replace("/.{$ext}/i", '', $upload[1]['file']);
		if (is_file(G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[1]['file'])) {
			$archive = new PclZip(G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[1]['file']);
			
			//해당 위치에 압축파일을 풀어줌
			$result = $archive->extract(PCLZIP_OPT_PATH, $extract_dir);
			@chmod($extract_dir, G5_DIR_PERMISSION);
			
			// 압축 파일 내용 배열 (이미지 원본 정보들)
			//$archive_list = $archive->listContent();
			//print_r2($archive_list);
			
			// 아래 문자열에 있는 확장자 이외의 파일이 들어있으면 삭제
			$allowed_ext = "/jpg|jpeg|png|bmp|gif/i";
			$matches = array();
			$meta_array = array();
			
			if (is_dir($extract_dir)) {
				$handle = opendir($extract_dir);
				while ($file= readdir($handle)) {
					if ($file != "." && $file != "..") {
						preg_match($allowed_ext, end(explode(".",$file)), $matches);
						if (count($matches) > 0) {
							;
						} else {
							if (is_file($extract_dir."/".$file))
								@unlink($extract_dir."/".$file);
							else
								delTree($extract_dir."/".$file);
						}
					}
				}
			}
			
			$result_dir = scandir($extract_dir, 1);
			$result_dir = array_diff($result_dir, [".", ".."]);
			//print_r2($result_dir);
			
			// 파일명 한글 & 특수문자 회피 및 혹시모를 허용되지 않은 확장자 처리
			foreach ($result_dir as $file) {
				$file = get_safe_filename($file);
				// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
				$file = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc|cer|cdx|asa|php3|html|htm|war|js|aspx|htaccess)/i", "$0-x", $file);
				
				$chars_array = array_merge(range(0,9), range("a","z"), range("A","Z"));
				shuffle($chars_array);
				$shuffle = implode("", $chars_array);
				
				// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다.
				$new_filename = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($file);
				@rename($extract_dir."/".$file, $extract_dir."/".$new_filename);
				
				$timg = @getimagesize($extract_dir."/".$new_filename);
				// image type
				if ( preg_match("/\.({$config['cf_image_extension']})$/i", $extract_dir."/".$new_filename) ||
					 preg_match("/\.({$config['cf_flash_extension']})$/i", $extract_dir."/".$new_filename) ) {
					if ($timg['2'] < 1 || $timg['2'] > 16) continue;
				}
				array_push($meta_array,$new_filename);
			}
			
			//$result = scandir($extract_dir, 1);
			//$result = array_diff($result, [".", ".."]);
			
			$meta_array = array_reverse($meta_array);
			$book_uri = G5_URL.'/data/file/'.$bo_table.'/'.preg_replace("/{$ext}/", '', $upload[1]['file']);
			meta_update(array(
				"mta_db_table"=>"board/".$bo_table,
				"mta_db_id"=>$wr_id,
				"mta_key"=>$book_uri,
				"mta_value"=>serialize($meta_array)
			));
		}
	}
}
?>