<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
/**
 * for			디렉토리 내부 파일들을 삭제하고 해당 디렉토리를 삭제한다.
 * exception	하위 디렉토리가 있으면 작동이 안하더라.
 */
if (!function_exists('delTree')) {
	function delTree($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach($files as $file) {
			(is_dir("$dir/$file")) ? delTree("$dir/$file") : @unlink("$dir/$file");
		}
		return @rmdir($dir);
	}
}

$sql = " SELECT * FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND  mta_db_id='{$wr_id}' ";
$meta = sql_fetch($sql);
if ($meta) {
	$temp = explode('/', $meta['mta_key']);
	$dir = G5_DATA_PATH.'/file/'.$bo_table.'/'.$temp[sizeof($temp)-1];
	
	if(is_dir($dir)) delTree($dir);
	sql_query(" DELETE FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND mta_db_id='{$wr_id}' ");
}
?>