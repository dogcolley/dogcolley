<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/*
스킨 명세 : 추가 1 wr_good으로 순서정렬 

bo_1 = 업데이트 상태
wr_1 = 노출상태
*/

/*
if(!$board['bo_1']){

    //$bo_sort_field  = 'wr_1 DESC, wr_num, wr_reply';
    $sql = "UPDATE {$g5['board_table']} SET 
            bo_sort_field  = '{$bo_sort_field}',
            bo_1_subj      = '업데이트 관리',
            bo_1           = '1'
            WHERE bo_table = '{$bo_table}' 
           ";
    sql_query($sql);
    
    alert('업데이트 완료되었습니다.');
}
*/

?>