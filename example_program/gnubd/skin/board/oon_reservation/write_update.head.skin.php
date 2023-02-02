<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(count($wr_3) < 1){
    alert("잘못된 접근입니다.","./board.php?bo_table=".$board['bo_1']);
}


if(count($start_value) < 1){
    alert("잘못된 접근입니다.","./board.php?bo_table=".$board['bo_1']);
}

if(count($end_value) < 1){
    alert("잘못된 접근입니다.","./board.php?bo_table=".$board['bo_1']);
}

$wr_3_arr = explode('|',$wr_3);

for($i=0;$i<count($wr_3_arr);$i++){
    $start =  strtotime($start_value[$i]); 
    $end = strtotime('-1 day',strtotime($end_value[$i]));

    while ($start <= $end){        
	
     
        $value = date("Y-m-d", $start);
    
        $sql = "SELECT EXISTS (SELECT * FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_4 LIKE '%{$value}%' AND wr_3 LIKE '%{$wr_3_arr[0]}%') AS isChk";
        $result = sql_fetch($sql);
        
        echo $sql.'<br>';

        if ($result['isChk']) {
            $sql = "SELECT wr_3 FROM {$g5['write_prefix']}{$_POST['bo_table']} WHERE wr_4 LIKE '%{$value}%' AND wr_3 LIKE '%{$wr_3_arr[0]}%' ";
            $wr_3_qry = sql_fetch($sql);
            $wr_3_qry_arr = explode('|',$wr_3_qry['wr_3']);
            for($j=0;$j <count($wr_3_qry_arr);$j++){
                if($wr_3_qry_arr[$j]==$wr_3_arr[0] )
                    alert("이미 예약된 객실입니다.","./board.php?bo_table=".$board['bo_1']);
            }
        }
        
        $start = strtotime("+1 day",$start);
    
    }
}

?>