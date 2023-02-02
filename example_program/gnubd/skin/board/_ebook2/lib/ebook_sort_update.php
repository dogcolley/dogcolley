<?php
include_once("./_common.php");
if (!isset($_POST['result']) || !isset($_POST['bo_table']) || !isset($_POST['wr_id'])) {
    alert_close('잘못된 접근입니다.');
    exit;
}
$wr_id = $_POST['wr_id'];
$bo_table = $_POST['bo_table'];
$sql = " SELECT * FROM ".G5_TABLE_PREFIX."write_{$bo_table} WHERE wr_id='{$wr_id}' ";
$write = sql_fetch($sql);

// 수정권한 체크
if ($is_admin == 'super') // 최고관리자 통과
    ;
else if ($is_admin == 'group') { // 그룹관리자
    $mb = get_member($write['mb_id']);
    if ($member['mb_id'] != $group['gr_admin']) // 자신이 관리하는 그룹인가?
        alert_close('자신이 관리하는 그룹의 게시판이 아니므로 수정할 수 없습니다.');
    else if ($member['mb_level'] < $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
        alert_close('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.');
} else if ($is_admin == 'board') { // 게시판관리자이면
    $mb = get_member($write['mb_id']);
    if ($member['mb_id'] != $board['bo_admin']) // 자신이 관리하는 게시판인가?
        alert_close('자신이 관리하는 게시판이 아니므로 수정할 수 없습니다.');
    else if ($member['mb_level'] < $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
        alert_close('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.');
} else if ($member['mb_id']) {
    if ($member['mb_id'] !== $write['mb_id'])
        alert_close('자신의 글이 아니므로 수정할 수 없습니다.');
} else {
    if ($write['mb_id'])
        alert_close('로그인 후 수정하세요.', G5_URL.'/bbs/login.php?url='.urlencode(G5_URL.'/bbs/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));
    //else if (!check_password($wr_password, $write['wr_password']))
    //    alert('비밀번호가 틀리므로 삭제할 수 없습니다.');
}

// 기존 페이지 순서 불러오기
$sql = " SELECT mta_value AS files FROM {$g5['meta_table']} WHERE mta_db_table='board/{$bo_table}' AND  mta_db_id='{$wr_id}' ";
$org_sort = sql_fetch($sql);
$current_meta = unserialize($org_sort['files']);
//print_r2($current_meta);

// 문자열 마지막에 ( , ) 제거 &&  prefix ( page_ ) 제거
$temp = substr($_POST['result'], 0 , mb_strlen($_POST['result'])-1);
$temp = preg_replace("/page_/", "", $temp);

// 바뀐 페이지 순서 배열 생성
$changed_sort = explode(',' , $temp);
//print_r2($changed_sort);

$desired_meta = array();
for ($i=0; $i<sizeof($changed_sort); $i++) {
	$desired_meta[$i] = $current_meta[$changed_sort[$i]];
}
//print_r2($desired_meta);
$mta_value = serialize($desired_meta);
$sql = " UPDATE {$g5['meta_table']} SET mta_value='{$mta_value}' WHERE mta_db_table='board/{$bo_table}' AND mta_db_id='{$wr_id}' ";
$msg = (sql_query($sql)) ? "변경사항이 저장되었습니다." : "변경사항 저장에 실패하였습니다.";
alert_close($msg);
?>