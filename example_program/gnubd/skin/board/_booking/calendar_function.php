<?php
function getReserveName ($user_name, $booking_name, $is_admin = '') 
{
	global $g5;
	global $bo_table;
	
	if ($is_admin) {
		return $user_name;
	}
	$length = mb_strlen($user_name);
	$replace_value = 'O';

	$sql = "SELECT bo_1_subj FROM {$g5['board_table']} WHERE bo_table = '{$bo_table}'";
	$selected = sql_fetch($sql);
	switch ($selected['bo_1_subj']) {
		case '':
			// 모든이름
			$value = $user_name;

			break;
		case '1':
			// 중간이름
			$length = $length - 2;
			for ($i=1; $i <= $length ; $i++) { 
				$replace .= $replace_value;
			}
			$value = preg_replace('/(?<=^[가-힣])(.*)(?=[가-힣]$)/u', $replace, $user_name);
			break;
		case '2':
			// 성만 노출
			$length = $length - 1;
			for ($i=1; $i <= $length ; $i++) { 
				$replace .= $replace_value;
			}

			$value = preg_replace('/(?<=^[가-힣])(.*)/u', $replace, $user_name);
			break;
		case '3':
			// 마지막만 노출			
			$value =  preg_replace('/.(?=.)/u','O',$user_name); 
			break;
		case '4':
			// 객실명 노출			
			$value =  $booking_name; 
			break;
	}
	return $value;
}
?>