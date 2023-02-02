<?php
if (!defined('_GNUBOARD_')) exit;
// 사용방법:  echo latest_group100("최신글스킨", "그룹아이디", 게시물수, 제목글자수, "정렬방식");
// $orderby(기본정렬은 최신순) : wr_hit(조회수 높은 순으로 정렬) / wr_comment(댓글 많은 순으로 정렬)
function latest_group100($skin_dir="", $gr_id, $rows=10, $subject_len=40, $orderby="") { 
    global $config; 
    global $g5; 
    
    $list = array(); 
    $limitrows = $rows; 
    
    $sql_groupname = " select gr_subject from ".$g5['group_table']." where gr_id='".$gr_id."' ";
    $rowgroup = sql_fetch_array( sql_query( $sql_groupname ) );
    $gr_subject = $rowgroup['gr_subject']; 
    
    $sqlgroup = " select bo_table, bo_subject from ".$g5['board_table']." where gr_id='".$gr_id."' and bo_use_search=1 order by bo_order";
    $rsgroup = sql_query( $sqlgroup );

    if (!$skin_dir) $skin_dir = 'basic'; 
  
    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest_grp/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest_grp/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest_grp/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest_grp/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest_grp/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest_grp/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest_grp/'.$skin_dir;
        }
    }
	
    
    for ($j=0, $k=0; $rowgroup = sql_fetch_array($rsgroup); $j++) { 
        $bo_table = $rowgroup['bo_table']; 
        // 테이블 이름구함 
        $sql = " select * from ".$g5['board_table']." where bo_table='".$bo_table."'"; 
        $board = sql_fetch($sql); 
        
        $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 실제이름 
        
        // 옵션에 따라 정렬 
        $sql = "select * from ".$tmp_write_table." where wr_is_comment = 0 "; 
        //$sql .= (!$category) ? "" : " and ca_name = '".$category."' "; 
        $sql .= (!$orderby) ? "  order by wr_datetime desc " : "  order by ".$orderby." desc, wr_datetime desc "; 
        $sql .= " limit ".$limitrows.""; 
        $result = sql_query($sql); 
		
        for ($i=0; $row = sql_fetch_array($result); $i++, $k++) { 
            if(!$orderby) {
                $op_list[$k] = $row['wr_datetime']; 
            } else { 
                $op_list[$k] = $row[$orderby]; 
                //$op_list[$k] = is_string($row[$orderby]) ? sprintf("%-256s", $row[$orderby]) : sprintf("%016d", $row[$orderby]); 
                //$op_list[$k] .= $row['wr_datetime']; 
                //$op_list[$k] .= $row['wr_name']; 
            } 
            
            $list[$k] = get_list($row, $board, $latest_skin_path, $subject_len, $wr_name, $wr_10); 
            
            $list[$k]['bo_table'] = $board['bo_table']; 
            $list[$k]['bo_subject'] = $board['bo_subject']; 
            $list[$k]['wr_name'] = $board['wr_name']; 
            
            $list[$k]['bo_wr_subject'] = cut_str($board['bo_subject'] . $list[$k]['wr_subject'], $subject_len, $wr_name, $wr_10); 
        } 
    }
    
    if($k>0) array_multisort($op_list, SORT_DESC, $list); 
    if($k>$rows) array_splice($list, $rows); 
    
    ob_start(); 
    include $latest_skin_path."/latest.skin.php"; 
    $content = ob_get_contents(); 
    ob_end_clean(); 
    return $content; 
} 
?>