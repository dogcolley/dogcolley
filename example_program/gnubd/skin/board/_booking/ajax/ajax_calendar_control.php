<?php
include_once('./_common.php');
include_once($_POST['path'].'/holiday_lib.php');
if ($_POST['change']=="prev") {
	$yy_mm = date('Y-m',strtotime("-1 month", strtotime($_POST['yy_mm'])));
}elseif ($_POST['change']=="next") {
	$yy_mm = date('Y-m',strtotime("+1 month", strtotime($_POST['yy_mm'])));
}elseif ($_POST['change']=="current") {
	$yy_mm = date('Y-m');
}

$holiday = new Calendar();
$holiday_list = $holiday->getHolidayList($yy_mm);


$time_stamp = strtotime($yy_mm);


// 1. 총일수 구하기
$last_day = date("t", $time_stamp);

// 2. 시작요일 구하기
$start_week = date("w", strtotime($yy_mm."-01"));

// 3. 총 몇 주인지 구하기
$total_week = ceil(($last_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', strtotime($yy_mm."-".$last_day));

// 5. 년,월 변수에 넣기

$append_table['table'] = "";


// 5. 화면에 표시할 화면의 초기값을 1로 설정
$day=1;

// 6. 총 주 수에 맞춰서 세로줄 만들기

// '<table id="cal_tb" style="display:none;">

$append_table['table'] .= 	
'<tr id = "table_header">
		<td colspan="2" style="padding-bottom: 26px;text-align: right;"><button class="change_month cal_head" value="<"><i class="far fa-arrow-alt-circle-left fa-lg"></i></button>
</td>
		<td colspan="3" style="padding-bottom: 26px;"><span class="cal_head">'.date('Y년 n월',$time_stamp).'</span></td>
		<td colspan="2" style="padding-bottom: 26px;text-align: left;"><button class="change_month cal_head" value=">"><i class="far fa-arrow-alt-circle-right fa-lg"></i></button></td>
	</tr>
	<tr id="daily">
		<td>일</td>
		<td>월</td>
		<td>화</td>
		<td>수</td>
		<td>목</td>
		<td>금</td>
		<td>토</td>
	</tr>';

for($i=1; $i <= $total_week; $i++){
	$append_table['table'] .= "<tr class='calendar_day'>";
	 // 7. 총 가로칸 만들기
	for ($j=0; $j<7; $j++){
		

		
		if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){

            // 12. 오늘 날자면 굵은 글씨
			if(strtotime($yy_mm."-".$day) >= strtotime(date('Y-m-j'))){
				$num = sprintf('%02d',$day);
				$append_table['table'] .= "<td id='".$yy_mm.'-'.$num."' class='check_day' style='cursor: pointer;'>";

				if($j == 0){
	    			//일요일
					$append_table['table'] .= "<font color='#FF0000' class='content'>";
				}else if($j == 6){
	                // 토요일
					$append_table['table'] .= "<font color='#0000FF' class='content'>";
				}else{
	                // 평일
					$append_table['table'] .= "<font color='#000000' class='content'>";
				}

				

	            // 13. 날자 출력
	            if ($holiday_list) {
                    $key_exist = array_key_exists($yy_mm.'-'.$num,$holiday_list);
                    if ($key_exist) {
                        $append_table['table'] .= "<div style='color:red;'>".$day."</div>";
                    }else{
                    	$append_table['table'] .= "<div>".$day."</div>";
                    }
                }else{
                	$append_table['table'] .= "<div>".$day."</div>";	
                }
				


			}else{
				
				$append_table['table'] .= "<td><font class='content closed'><div>마감</div></font>";
			}

			$append_table['table'] .= "</font>";

            // 14. 날자 증가
			$day++;
		}else{
			$append_table['table'] .= "<td>";		
		}
		
		$append_table['table'] .= "</td>";
	}
	$append_table['table'] .= "</tr>";
}
// $append_table['table'] .= "</table>";

$append_table['next_month'] = $yy_mm;
echo json_encode($append_table);