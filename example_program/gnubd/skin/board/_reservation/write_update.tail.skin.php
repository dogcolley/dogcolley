<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
 
//print_r2($_POST);

//-- 필드명 추출 wr_ 와 같은 앞자리 3자 추출 --//
$r = sql_query(" desc {$write_table} ");
while ( $d = sql_fetch_array($r) ) {$db_fields[] = $d['Field'];}
$db_prefix = substr($db_fields[0],0,3);
 
//-- 체크박스 값이 안 넘어오는 현상 때문에 추가, 폼의 체크박스는 모두 배열로 선언해 주세요.
$checkbox_array=array();
for ($i=0;$i<sizeof($checkbox_array);$i++) {
	if(!$_REQUEST[$checkbox_array[$i]])
		$_REQUEST[$checkbox_array[$i]] = 0;
}
 
//-- 메타 입력 (디비에 있는 설정된 값은 입력하지 않는다.) --//
$db_fields[] = "mb_zip";	// 건너뛸 변수명은 배열로 추가해 준다.
$db_fields[] = "mb_sido_cd";	// 건너뛸 변수명은 배열로 추가해 준다.
foreach($_REQUEST as $key => $value ) {
	//-- 해당 테이블에 있는 필드 제외하고 테이블 prefix 로 시작하는 변수들만 업데이트 --//
	if(!in_array($key,$db_fields) && substr($key,0,3)==$db_prefix) {
		echo $key."=".$_REQUEST[$key]."<br>";
		meta_update(array("mta_db_table"=>"board/".$bo_table,"mta_db_id"=>$wr_id,"mta_key"=>$key,"mta_value"=>$value));
	}
}

//20200801 박균우 start
// 가끔** 날짜가 하루 더 들어가버리는 버그가 있는데 원인을 못찾아서 임시로 모든 업데이트마다 해당 문제 찾아서 업데이트
if (true)
{
    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d') {
        $dates = array();
        $current = strtotime( $first );
        $last = strtotime( $last );
        while ($current <= $last) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    $sql = "SELECT wr_id, wr_4, wr_9, wr_10 FROM {$g5['write_prefix']}{$bo_table} WHERE wr_4 LIKE CONCAT('%', wr_10, '%') AND wr_4 != ''";
    $result = sql_query($sql);

    while ($row = sql_fetch_array($result))
    {
        $date_range = dateRange($row['wr_9'], $row['wr_10']);
        unset($date_range[count($date_range)-1]);
        $result_str = join(';', $date_range);
        
        $sql = "UPDATE {$g5['write_prefix']}{$bo_table} SET wr_4 = '{$result_str}' WHERE wr_id = {$row['wr_id']}";
        sql_query($sql);
    }
}
//20200801 박균우 end

 
?>
