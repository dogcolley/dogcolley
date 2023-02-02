<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
/**
 * for			디렉토리 내부 파일들을 삭제하고 해당 디렉토리를 삭제한다.
 * exception	하위 디렉토리가 있으면 작동이 안하더라.
 */
if (!function_exists('delTree')) {
	function delTree($dir) {
	   $files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
		  (is_dir("$dir/$file")) ? delTree("$dir/$file") : @unlink("$dir/$file");
		}
		return @rmdir($dir);
	}
}
$row = sql_fetch(" SELECT * FROM {$g5['board_file_table']} WHERE bo_table='{$bo_table}' AND wr_id='{$wr_id}' AND bf_no='1' ");
$ext = end(explode(".",$row['bf_file']));
$dir = G5_DATA_PATH.'/file/'.$bo_table.'/'.preg_replace("/.{$ext}/", '', $row['bf_file']);

// 압축파일 삭제 체크 감지되면 해당 파일 압축해제 한 폴더도 삭제.
if (isset($_POST['bf_file_del'][1]) && $_POST['bf_file_del'][1]) {
	if (preg_match("/zip/i", $ext) === 1) {
		if(is_dir($dir)) delTree($dir);
		sql_query(" DELETE FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND mta_db_id='{$wr_id}' ");
	}
}

// 압축파일이 새로/덮어쓰기로 올라온 경우 기존 디렉토리 삭제 및 압축해제.
if ($_FILES['bf_file']['type'][1] === 'application/x-zip-compressed') {
	if (preg_match("/zip/i", $ext) === 1) {
		if (is_dir($dir)) delTree($dir);
		sql_query(" DELETE FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND mta_db_id='{$wr_id}' ");
	}
} else if (!$_FILES['bf_file']['type'][1] === '') {
	alert("Zip 형식의 파일만 업로드 해 주세요.");
}
?>