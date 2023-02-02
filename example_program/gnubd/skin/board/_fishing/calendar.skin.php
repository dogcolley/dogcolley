<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($reserve_list == "list" && $member[mb_level] > 8)  {
	$r_list = "&reservation=list";
}else{
	$r_list = "";
}

$sch_year       = substr($vew_month, 0, 4);
$sch_month      = substr($vew_month, 5, 2);
$total_day      = wz_max_day($sch_month, $sch_year);
$first_day      = date('w', mktime(0, 0, 0, $sch_month, 1, $sch_year));
$count          = 0;
$weekcut        = 0; // 한주가 지나면 초기화


$p_m = explode("-", date("Y-m-d",mktime(0,0,0,$sch_month-1,$sch_day2,$sch_year)));
$n_m = explode("-", date("Y-m-d",mktime(0,0,0,$sch_month+1,$sch_day2,$sch_year)));
?>
<style>
select { height:32px; border-radius: 3px; }
</style>


<div id="bo_list">
	<div id="cal_navi" class="tbl_head01 tbl_wrap">
		<div class="cal_navi">
			<h3><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$p_m[0]?>&sch_month=<?=$p_m[1]?>">◀</a>&nbsp;<?php echo substr($vew_month, 0, 4)?> 년 <?php echo substr($vew_month, 5, 2)?> 월&nbsp;<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$n_m[0]?>&sch_month=<?=$n_m[1]?>">▶</a></h3>
		</div>
		
		<table class="wrap_calendar">
		<tbody>
		<tr style="background:#f9f9f9;">
		<? for ($i=1 ; $i<=12 ; $i++) {

					if (strlen($i) == "1") {	
						$tempI = "0".$i;	
					}
					else {	
						$tempI = $i;	
					}
			$t_bg = "";
			if($tempI == $sch_month) {
				$t_bg = "background:#eee;";
			}
		?>
			<td style="width:8.333%;vertical-align:middle;border:0;cursor:pointer;<?=$t_bg?>" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$tempI?>');"><?=$i?>월</td>
		<? } ?>
		</tr>
		</tbody>
		</table>

		<table class="wrap_calendar">
		<colgroup>
			<col width="14%" span="7" />
		</colgroup>
		<tbody>
		<thead>
			<tr>
				<th scope="col" style="color: #e05349;">일</th>
				<th scope="col">월</th>
				<th scope="col">화</th>
				<th scope="col">수</th>
				<th scope="col">목</th>
				<th scope="col">금</th>
				<th scope="col" style="color: #49a1e0;">토</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<?php
			for ($i=0; $i<$first_day; $i++) {
				echo '<td><span class="date_head none">&nbsp;</span></td>'.PHP_EOL;
				$count++;
			}

			$wFile = fopen($board_skin_path."/date/{$sch_year}-{$sch_month}.txt", "r");
			
			if($wFile) {
				$wDD = fread($wFile, filesize($board_skin_path."/date/{$sch_year}-{$sch_month}.txt"));
			}
			fclose($wFile);


			for ($day=1; $day<=$total_day; $day++) {
				
				$count++;

				$vDate = $sch_year ."-". $sch_month ."-". sprintf('%02d', $day); // 표시 날짜.
				$timestamp = strtotime( $vDate );
				$now = strtotime( date( 'Y-m-d' ) );
				$sch_day = sprintf('%02d', $day);
					
				//$wDD = sql_fetch("select bo_4 from {$g5[board_table]} where bo_table = '{$bo_table}'");

				if ($vDate == $today) { // 오늘 표시
					$bg_class = 'dday';
				}
				else { // 오늘이 아니면...
					if ($count == 1) // 일요일
						$bg_class = 'sun';
					elseif ($count == 7) // 토요일
						$bg_class = 'sat';
					else // 평일
						$bg_class = '';
				}
				
				$get_date = $_GET[sch_year]."-".$_GET[sch_month]."-".$sch_day2;
				
				if($_GET[month] != "month") 
				{

					if(date('Y-m') == $sch_year."-".$sch_month && $sch_day == $sch_day2) {
						$selected_td = "background:#eee;";
					}else if(date('Y-m') != $sch_year."-".$sch_month && $sch_day == $sch_day2 && $_GET['sch_day']) {
						$selected_td = "background:#eee;";
					}else{
						$selected_td = "";
					}

				}else{
					$selected_td = "";
				}
				
				$data_sel = "location.replace('".G5_BBS_URL."/board.php?bo_table=".$bo_table."&sch_year=".$sch_year."&sch_month=".$sch_month."&sch_day=".$sch_day.$r_list."')";

				if($member[mb_level] < 8){
					$data_click = 'onclick="'.$data_sel.'"';
					$data_click_cursor = 'cursor:pointer;';
					$data_click_admin = '';
				}else{
					$data_click = '';
					$data_click_admin = 'onclick="'.$data_sel.'"';
				}

				echo '<td style="vertical-align: top;'.$data_click_cursor.''.$selected_td.'" '.$data_click.'>'.PHP_EOL;
				
				if ( $count == 1 ) {
					echo '<p class="date_head" style="color: #e05349" '.$data_click.' '.$data_click_admin.'>'.$day.PHP_EOL;
				} else if ( $count == 7 ) {
					echo '<p class="date_head" style="color: #49a1e0" '.$data_click.' '.$data_click_admin.'>'.$day.PHP_EOL;
				} else {
					echo '<p class="date_head none" '.$data_click.' '.$data_click_admin.'>'.$day.PHP_EOL;
				}

				$strValue = strstr($wDD, $vDate);

				$boArr = explode(";", $strValue);

				$strArr = explode("|", $strValue);
				$boArr = $strArr[1];
				$boArr2 = explode(";", $boArr);




				
				echo "<span class='wtime wtime_".$day."'>";
				//if ( $now <= $timestamp ) {
					if($boArr2[0])
						echo "<br>".$boArr2[0]."";
				//}
				echo "</span>";

				echo '</p>'.PHP_EOL;
				
				// 물때등록
				if ($member[mb_level] >= 8) { 
					echo '<ul class="btn_bo_user hidden-sm hidden-xs" style="float: none;"><li>'.PHP_EOL;

					//if ( $now <= $timestamp ) {
							//echo '<a href="'.$write_href.'&vDate='.$vDate.'&wType=notice" class="btn_admin" style="color: #fff;">공지등록</a>'.PHP_EOL;
							//echo '<input type="hidden" class="wDate" id="wDate" value="'.$vDate.'">';
							echo '<button data-toggle="modal" data-id="'.$vDate.'" class="btn btn-default btn-xs wBtn" style="margin:5px 0 5px; 0">물때등록</button>'.PHP_EOL; 
						
						/*
						if ($member[mb_level] >= 8)
							echo '<a href="'.$write_href.'&vDate='.$vDate.'&wType=reserve" class="btn_admin" style="color: #fff;">예약하기</a>';
						*/

					//} else {
						echo "";
					//}
					echo '</li></ul>'.PHP_EOL;

					echo '<div style="clear:both;"></div>';
				}
				
				//print_r($arr_db[$vDate]);
				
				/*
				if (isset($arr_db[$vDate])) {	
					$cnt_db = count($arr_db[$vDate]);

					echo '<ul class="data-list">'.PHP_EOL;
					for ($z=0; $z < $cnt_db; $z++) { 

						if ($member[mb_level] >= 8) {
							$n_href = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&wr_id='.$arr_db[$vDate][$z]['wr_id'].'">';
							$n_href_end = '</a>';
						}

						echo '  <li>['.$n_href.$arr_db[$vDate][$z]['wr_3'].']'.conv_subject($arr_db[$vDate][$z]['wr_subject'], 10, '…').$n_href_end.'</li>'.PHP_EOL;
					}             
					echo '</ul>'.PHP_EOL;
				}
				*/
				
				echo '</td>'.PHP_EOL;


				if($count==7) { // 토요일이 되면 줄바꾸기 위한 <tr>태그 삽입을 위한 식
					echo '</tr>'.PHP_EOL;
					if($day != $total_day) {
						echo '<tr>'.PHP_EOL;
						$count = 0;
					}
				}

			}

			// 선택한 월의 마지막날 이후의 빈테이블 삽입
			for ($day++; $total_day < $day && $count < 7;) {
				$count++;
				echo '<td><span class="date_head none">&nbsp;</span></td>'.PHP_EOL;
				if ($count == 7) 
					echo '</tr>'.PHP_EOL;
			}
			?>
		</tbody>
		</table>
	</div>
	
	<?php include_once($board_skin_path."/memo_view.skin.php"); ?>

</div>

<!-- 게시판 페이지 정보 및 버튼 시작 { -->
<div class="bo_fx" style="margin:0;">

	<?php if ($member[mb_level] >= 8) { ?>
	<h5>※ 관리자 전용 관리 기능</h5>
	<hr class="m_hr" style="margin:6px 0 8px 0;">
	<ul class="btn_bo_user">
		<li><button class="btn btn-primary btn-sm" id="waterBtn" >물때관리</button></li>
		<li><button class="btn btn-primary btn-sm" id="shipBtn" >선박관리</button></li>
		<li><button class="btn btn-primary btn-sm" id="typeBtn" >낚시종류</button></li>
		<li><button class="btn btn-primary btn-sm" id="memoBtn" >예약내용</button></li>
		<li><button class="btn btn-primary btn-sm" id="smsBtn" >SMS설정</button></li>
		<li><button class="btn btn-primary btn-sm" id="priBtn" >약관설정</button></li>
	</ul>
	<?php } ?>

</div>
<!-- } 게시판 페이지 정보 및 버튼 끝 -->


