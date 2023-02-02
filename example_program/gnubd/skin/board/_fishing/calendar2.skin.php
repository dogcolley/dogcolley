<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div id="bo_list">
	<div class="bo_fx">
		
		<ul class="btn_bo_user">
			<?php if ($member[mb_level] >= 8) { ?>
			<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>&month=month&reservation=list')"><?=$sch_month?>월 전체 예약현황</button></li>
			<? } ?>
			<li><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&reservation=check" class="btn btn-primary">예약확인 & 취소안내</a></li>
			<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>&month=month')"><?=$sch_month?>월 전체보기</button></li>
			<!--
			<? if(date('Y-m') == $_GET[sch_year]."-".$_GET[sch_month]) { ?>
				<li><button type="button" class="btn_admin" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>')">일별 보기</button></li>
			<? } ?>
			-->
			<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>')">오늘날짜보기</button></li>
		</ul>
	</div>
</div>

<?
for ($day=$selected_day; $day<=$total_day; $day++) { 

	$count++;

	$vDate = $sch_year ."-". $sch_month ."-". sprintf('%02d', $day); // 표시 날짜.
	$timestamp = strtotime( $vDate );
	$now = strtotime( date( 'Y-m-d' ) );

	if ($vDate == $today) { // 오늘 표시
		$bg_class = 'dday';
	}
	else { // 오늘이 아니면...

		if ( $weekstr[date('w', strtotime($vDate))] == "토" ) {
			$bg_class = 'sat'.PHP_EOL;
		} else if ( $weekstr[date('w', strtotime($vDate))] == "일" ) {
			$bg_class = 'sun'.PHP_EOL;
		} else {
			$bg_class = 'color: #000;'.PHP_EOL;
		}
	}
	



	if ( $weekstr[date('w', strtotime($vDate))] == "토" ) {
		$d_color = 'color: #2281c6;'.PHP_EOL;
	} else if ( $weekstr[date('w', strtotime($vDate))] == "일" ) {
		$d_color = 'color: #e05349;'.PHP_EOL;
	} else {
		$d_color = 'color: #000;'.PHP_EOL;
	}


	// 선박 불러오기
	$bRow = sql_fetch("select bo_1 from {$g5['board_table']} where bo_table = '{$bo_table}'");
	$bArr = explode(";", $bRow[bo_1]);
?>

<form name="fboardlist_ca" id="fboardlist_ca" action="<?php echo $board_skin_url ?>/board_update.php" onsubmit="return fboardlist_ca_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sw" id="sw_<?=intval($day)?>" value="">
<input type="hidden" name="upd" id="upd_<?=intval($day)?>" value="">
<input type="hidden" name="ca" id="ca_<?=intval($day)?>" value="">
<input type="hidden" name="date" id="date_<?=intval($day)?>" value="">
<input type="hidden" name="chk_id" id="chk_id_<?=intval($day)?>" value="">
<div id="sector_<?=intval($day)?>">
<div id="<?=$vDate?>" class="cal_list">
	<table class="table table-sm table-bordered">
		<thead class="thead-dark">
			<tr class="hidden-xs hidden-sm">
				<th scope="col" style="width:8%;">날짜</th>
				<th scope="col" style="width:16%;">선박</th>
				<th scope="col" style="width:23%;">공지</th>
				<th scope="col" style="width:38%;">명단</th>
				<th scope="col" style="width:5%;">정원</th>
				<th scope="col" style="width:5%;">잔여</th>
				<th scope="col" style="width:5%;">예약</th>
			</tr>
			<tr class="visible-sm visible-xs">
				<th scope="col" style="width:15%;">날짜</th>
				<th scope="col" style="width:70%;">예약정보</th>
				<th scope="col" style="width:15%;">예약</th>
			</tr>
		</thead>
		<tbody>
			<? if(count($bArr) == 1) { ?>
			<tr>
				<td colspan="7">등록된 선박이 없습니다.</td>
			</tr>
			<? } ?>
			<?php
			$s_count = 0;
			$s_row = "";

			for($ship=0; $ship<count($bArr)-1; $ship++) {
				
				$cnt_db = count($arr_db[$vDate]);

				$sArr = explode("|", $bArr[$ship]);

				if($ship == 0) {
					$s_row = "rowspan='".(count($bArr)-1)."'"; 
				}
			?>
			<!-- PC 화면 리스트 [시작] -->
			<tr class="hidden-xs hidden-sm">
				<? if($ship == 0) {?>
					<td <?=$s_row?> style="background:#f3f3f3;">
					<?php
					//** 날짜 리스트 **//

					$strValue = strstr($wDD, $vDate);

					$boArr = explode(";", $strValue);

					$strArr = explode("|", $strValue);
					$boArr = $strArr[1];
					$boArr2 = explode(";", $boArr);
					
					if($ship == 0) {
						echo "<div class='m_date' style='".$d_color."'>";

						echo "<span class='m_month'>".$sch_year.".".$sch_month."</span>";
						echo "<span class='m_day'>".sprintf('%02d', $day)."</span>";

						echo "<span class='m_yoil'>(".($weekstr[date('w', strtotime($vDate))])."요일)</span>";

						//if ( $now <= $timestamp ) {
						echo "<div class='wtime wtime2_".intval($day)."'><span class='m_mool'>";
							if($boArr2[0])
								echo $boArr2[0];
						echo "</span></div>";
						//}

						if ($member[mb_level] >= 8) { 
							//echo '<a href="'.$write_href.'&vDate='.$vDate.'&wType=notice" class="btn_admin" style="color: #fff;">공지등록</a>'.PHP_EOL;
							//echo '<input type="hidden" class="wDate" id="wDate" value="'.$vDate.'">';
							echo '<br><button type="button" data-toggle="modal" data-id="'.$vDate.'" class="btn btn-default btn-xs wBtn" style="">개인 및 독배예약</button>'.PHP_EOL; 
						}
						echo "</div>";
					}

					?>
					</td>
				<? } ?>
				<td><? //** 선박 리스트 **// ?>
				<?=$sArr[1]?>
				<? if($sArr[3] == 1) { echo '<div class="dok_txt">[개인 및 독배예약]</div>'; } ?>
				<?php if ($member[mb_level] >= 8) { ?>
				<br>
				<button type="button" data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" class="btn btn-default btn-xs notiBtn" style="">공지추가</button>
				<? } ?>
				</td>
				<td>
				<?php
					//** 공지 리스트 **//

					echo '<ul class="data-list">'.PHP_EOL;
					for ($z=0; $z < $cnt_db; $z++) { 
						
						echo "<li>";
						if ($member[mb_level] >= 8 && $arr_db[$vDate][$z][ca_name] == "공지" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]) {
							echo "<input type='checkbox' name='chk_wr_id[]' id='chk_wr_id_".$day."' value='".$arr_db[$vDate][$z]['wr_id']."'>";
						}

					?>
					
						<? if ($member[mb_level] >= 8) { ?><a data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" data-write="u" data-wrid="<?=$arr_db[$vDate][$z]['wr_id']?>" class="notiBtn" style="cursor:pointer;"><? } ?>
						<?
						if($arr_db[$vDate][$z][ca_name] == "공지" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]){
							echo "{$arr_db[$vDate][$z][wr_subject]}";
						}
						?>
						<?
						/*
						if ($member[mb_level] >= 8) {
							$n_href = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&wr_id='.$arr_db[$vDate][$z]['wr_id'].'">';
							$n_href_end = '</a>';
						}
						
						if($arr_db[$vDate][$z][wr_1] == "1" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]) {
							echo '  <li>['.$n_href.$arr_db[$vDate][$z]['wr_3'].']'.conv_subject($arr_db[$vDate][$z]['wr_subject'], 100, '…').$n_href_end.'</li>'.PHP_EOL;
						}
						*/
						if ($member[mb_level] >= 8) echo "</a>";
						echo "</li>";
					}
					echo '</ul>'.PHP_EOL;

				?>
				</td>
				<td>
				<?php
					
					//** 예약 리스트 **//
					$ca_list = sql_fetch("select bo_category_list from {$g5['board_table']} where bo_table = '{$bo_table}'");
					$ca_ex = explode("|", $ca_list[bo_category_list]);
					
					if($member[mb_level] >= 8) {
						$ca_ex_cnt = count($ca_ex);
					}else{
						$ca_ex_cnt = count($ca_ex)-1;
					}

					$ca_style = "";

					for($k=1; $k < $ca_ex_cnt; $k++){ // 0은 공지사항
						
						switch ($ca_ex[$k]) {
							case '예약대기'  : $ca_style = "background:#8a8a8a;color:#fff;"; break;
							case '예약완료'  : $ca_style = "background:#347efa;color:#fff;"; break;
							case '취소요청'  : $ca_style = "background:#e8bb46;color:#fff;"; break;
							case '취소완료'  : $ca_style = "background:#e43c03;color:#fff;"; break;
							default   : $ca_style = "background:#8a8a8a;color:#fff;"; break;
						}

						echo '<ul class="data-list">'.PHP_EOL;
						echo "<li>";
						echo "<span style='padding:2px 1px;".$ca_style."'>".$ca_ex[$k]."</span>&nbsp;";
						
						for ($z=0; $z < $cnt_db; $z++) 
						{ 
						?>
							<?
								if($arr_db[$vDate][$z][ca_name] == $ca_ex[$k] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1])
								{
									if ($member[mb_level] >= 8) {
										$cut_name = $arr_db[$vDate][$z][wr_name];
									}else{
										//$cut_name = cut_str($arr_db[$vDate][$z][wr_name], 2, "○");
										$cut_name = masking('N', $arr_db[$vDate][$z][wr_name]);
									}
									
									if ($member[mb_level] >= 8) {
										echo "<input type='checkbox' name='chk_wr_id[]' id='chk_wr_id_".$z."' value='".$arr_db[$vDate][$z]['wr_id']."'>";
									?>
									<a data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id3="<?=$sArr[3];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" data-write="u" data-wrid="<?=$arr_db[$vDate][$z]['wr_id']?>" data-cname="<?=$arr_db[$vDate][$z][ca_name]?>" class="resBtn" style="cursor:pointer;">
									<? } ?>

									<?
									$back_phone = substr($arr_db[$vDate][$z]['wr_4'], -4);
									if($arr_db[$vDate][$z]['wr_9']) $dokbae = '[독배]'; else $dokbae = '';
									echo " {$cut_name} (".$back_phone.") (".$arr_db[$vDate][$z]['wr_6']."명)&nbsp;{$dokbae}&nbsp;&nbsp;";

									if ($member[mb_level] >= 8) echo "</a>";
								}
							
							}
							echo "</li>";
						echo '</ul>'.PHP_EOL;
						
						if($k != $ca_ex_cnt-1){
							echo '<hr class="m_hr">';
						}

					}

					

				?>
				</td>
				<td><? //** 정원 리스트 **// ?>
				<span style="color:#ff6600;font-weight:700;"><?=$sArr[2]?></span>
				</td>
				<td>
				<?php
					//** 잔여 리스트 **//
					$p_cnt = 0;


					for ($z=0; $z < $cnt_db; $z++) {
						if($arr_db[$vDate][$z][wr_6] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1] && !strstr($arr_db[$vDate][$z]['ca_name'], "취소")){
							$p_cnt += ($arr_db[$vDate][$z]['wr_6']);
						}
					}
					echo "<span style='color:#489cdb;font-weight:700;'>".($sArr[2]-$p_cnt)."</span>";

				?>
				</td>
				<td>
				<?php
				//** 예약하기 **//
				$p_cnt = 0;
				$dokChk = 0;

				for ($z=0; $z < $cnt_db; $z++) {
					
					if($arr_db[$vDate][$z][wr_6] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1] && !strstr($arr_db[$vDate][$z]['ca_name'], "취소")){
						$p_cnt += ($arr_db[$vDate][$z]['wr_6']);

						//독배 예약이 1개라도 있으면
						if($arr_db[$vDate][$z][wr_9]) {
							$dokChk = 1;
						}
					}
				}

				$timenow = date("Y-m-d"); 
				$timetarget = $vDate;

				$str_now = strtotime($timenow);
				$str_target = strtotime($timetarget);
				?>

				<? if(((($sArr[2]-$p_cnt) > 0 && $str_now <= $str_target) && !$dokChk)  || $member[mb_level] >= 8) { ?>
					<button type="button" data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" class="btn btn-default btn-xs resBtn" style="">예약신청</button>
				<? }else{ ?>
					예약마감
				<? } ?>

				</td>
			</tr>
			<!-- PC 화면 리스트 [끝] -->
			

			<!-- 모바일 & 태블릿 리스트 [시작] -->
			<tr class="visible-sm visible-xs">
				<? if($ship == 0) {?>
					<td <?=$s_row?> style="background:#f3f3f3;">
					<?php
					//** 날짜 리스트 **//

					$strValue = strstr($wDD, $vDate);

					$boArr = explode(";", $strValue);

					$strArr = explode("|", $strValue);
					$boArr = $strArr[1];
					$boArr2 = explode(";", $boArr);
					
					if($ship == 0) {
						echo "<div class='m_date' style='".$d_color."'>";

						echo "<span class='m_month'>".$sch_year.".".$sch_month."</span>";
						echo "<span class='m_day'>".sprintf('%02d', $day)."</span>";

						echo "<span class='m_yoil'>(".($weekstr[date('w', strtotime($vDate))])."요일)</span>";

						//if ( $now <= $timestamp ) {
						echo "<div class='wtime wtime2_".intval($day)."'><span class='m_mool'>";
							if($boArr2[0])
								echo $boArr2[0];
						echo "</span></div>";
						//}

						if ($member[mb_level] >= 8) { 
							//echo '<a href="'.$write_href.'&vDate='.$vDate.'&wType=notice" class="btn_admin" style="color: #fff;">공지등록</a>'.PHP_EOL;
							//echo '<input type="hidden" class="wDate" id="wDate" value="'.$vDate.'">';
							echo '<br><button type="button" data-toggle="modal" data-id="'.$vDate.'" class="btn btn-default btn-xs wBtn" style="">개인 및 독배예약</button>'.PHP_EOL; 
						}
						echo "</div>";
					}

					?>
					</td>
				<? } ?>
				<td><? //** 선박 리스트 **// ?>
				<span style="font-weight:700;color:#444;"><?=$sArr[1]?></span>
				


				(<span style="color:#ff6600;font-weight:700;"><?=$sArr[2]?></span> / 


				<?php
					//** 잔여 리스트 **//
					$p_cnt = 0;

					for ($z=0; $z < $cnt_db; $z++) {
						if($arr_db[$vDate][$z][wr_6] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1] && !strstr($arr_db[$vDate][$z]['ca_name'], "취소")){
							$p_cnt += ($arr_db[$vDate][$z]['wr_6']);
						}
					}
					echo "<span style='color:#489cdb;font-weight:700;'>".($sArr[2]-$p_cnt)."</span>)";

				?>
				<? if($sArr[3] == 1) { echo '&nbsp;<span class="dok_txt">[개인 및 독배예약]</span>'; } ?>


				<hr class="m_hr">


				<?php if ($member[mb_level] >= 8) { ?>
				<button type="button" data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" class="btn btn-default btn-xs notiBtn" style="">공지추가</button>
				<? } ?>

				<?php
					//** 공지 리스트 **//

					echo '<ul class="data-list">'.PHP_EOL;
					for ($z=0; $z < $cnt_db; $z++) { 
						
						echo "<li>";
						if ($member[mb_level] >= 8 && $arr_db[$vDate][$z][ca_name] == "공지" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]) {
							echo "<input type='checkbox' name='chk_wr_id[]' id='chk_wr_id_".$z."' value='".$arr_db[$vDate][$z]['wr_id']."'>";
						}

					?>
					
						<? if ($member[mb_level] >= 8) { ?><a data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" data-write="u" data-wrid="<?=$arr_db[$vDate][$z]['wr_id']?>" class="notiBtn" style="cursor:pointer;"><? } ?>
						<?
						if($arr_db[$vDate][$z][ca_name] == "공지" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]){
							echo "{$arr_db[$vDate][$z][wr_subject]}";
						}
						?>
						<?
						/*
						if ($member[mb_level] >= 8) {
							$n_href = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&wr_id='.$arr_db[$vDate][$z]['wr_id'].'">';
							$n_href_end = '</a>';
						}
						
						if($arr_db[$vDate][$z][wr_1] == "1" && $arr_db[$vDate][$z]['wr_3'] == $sArr[1]) {
							echo '  <li>['.$n_href.$arr_db[$vDate][$z]['wr_3'].']'.conv_subject($arr_db[$vDate][$z]['wr_subject'], 100, '…').$n_href_end.'</li>'.PHP_EOL;
						}
						*/
						if ($member[mb_level] >= 8) echo "</a>";
						echo "</li>";
					}
					echo '</ul>'.PHP_EOL;

				?>

				<hr class="m_hr">

				<?php
					
					//** 예약 리스트 **//
					$ca_list = sql_fetch("select bo_category_list from {$g5['board_table']} where bo_table = '{$bo_table}'");
					$ca_ex = explode("|", $ca_list[bo_category_list]);
					
					if($member[mb_level] >= 8) {
						$ca_ex_cnt = count($ca_ex);
					}else{
						$ca_ex_cnt = count($ca_ex)-1;
					}

					$ca_style = "";

					for($k=1; $k < $ca_ex_cnt; $k++){ // 0은 공지사항
						
						switch ($ca_ex[$k]) {
							case '예약대기'  : $ca_style = "background:#8a8a8a;color:#fff;"; break;
							case '예약완료'  : $ca_style = "background:#347efa;color:#fff;"; break;
							case '취소요청'  : $ca_style = "background:#e8bb46;color:#fff;"; break;
							case '취소완료'  : $ca_style = "background:#e43c03;color:#fff;"; break;
							default   : $ca_style = "background:#8a8a8a;color:#fff;"; break;
						}

						echo '<ul class="data-list">'.PHP_EOL;
						echo "<li>";
						echo "<span style='padding:2px 1px;".$ca_style."'>".$ca_ex[$k]."</span>&nbsp;";
						for ($z=0; $z < $cnt_db; $z++) 
						{ 
						?>
							<?
								if($arr_db[$vDate][$z][ca_name] == $ca_ex[$k] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1])
								{
									if ($member[mb_level] >= 8) {
										$cut_name = $arr_db[$vDate][$z][wr_name];
									}else{
										//$cut_name = cut_str($arr_db[$vDate][$z][wr_name], 2, "○");
										$cut_name = masking('N', $arr_db[$vDate][$z][wr_name]);
									}
									
									if ($member[mb_level] >= 8) {
										echo "<input type='checkbox' name='chk_wr_id[]' id='chk_wr_id_".$z."' value='".$arr_db[$vDate][$z]['wr_id']."'>";
									?>
									<a data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" data-write="u" data-wrid="<?=$arr_db[$vDate][$z]['wr_id']?>" data-cname="<?=$arr_db[$vDate][$z][ca_name]?>" class="resBtn" style="cursor:pointer;">
									<? } ?>

									<?
									$back_phone = substr($arr_db[$vDate][$z]['wr_4'], -4);
									if($arr_db[$vDate][$z]['wr_9']) $dokbae = '[독배]'; else $dokbae = '';
									echo " {$cut_name} (".$back_phone.") (".$arr_db[$vDate][$z]['wr_6']."명)&nbsp;{$dokbae}&nbsp;";

									if ($member[mb_level] >= 8) echo "</a>";
								}
							
							}
							echo "</li>";
						echo '</ul>'.PHP_EOL;
						
						if($k != $ca_ex_cnt-1){
							echo '<hr class="m_hr">';
						}

					}

					

				?>	

				</td>
				
				<td>
				<?php
				//** 예약하기 **//
				$p_cnt = 0;
				$dokChk = 0;

				for ($z=0; $z < $cnt_db; $z++) {
					if($arr_db[$vDate][$z][wr_6] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1] && !strstr($arr_db[$vDate][$z]['ca_name'], "취소")){
						$p_cnt += ($arr_db[$vDate][$z]['wr_6']);

						//독배 예약이 1개라도 있으면
						if($arr_db[$vDate][$z][wr_9]) {
							$dokChk = 1;
						}
					}
				}

				$timenow = date("Y-m-d"); 
				$timetarget = $vDate;

				$str_now = strtotime($timenow);
				$str_target = strtotime($timetarget);
				?>

				<? if(((($sArr[2]-$p_cnt) > 0 && $str_now <= $str_target) && !$dokChk)  || $member[mb_level] >= 8) { ?>
					<button type="button" data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$sArr[1];?>" data-id3="<?=$sArr[2];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" class="btn btn-default btn-xs resBtn" style="">예약신청</button>
				<? }else{ ?>
					예약마감
				<? } ?>

				</td>
			</tr>
			<!-- 모바일 & 태블릿 리스트 [끝] -->
			<?
				if($s_count == 7) {
					$s_count = 0;
				}
			}
			?>
		
		</tbody>
		
		<? if ($member[mb_level] >= 8) { ?>
		<tfoot>
			<tr>
				<td colspan="7">
					
					<div class="bo_fx">
						<div class="bo_fx_select">
							
							<? if(count($bArr) == 1) { ?>
							<div class="pull-left">
								<?php
									echo '<button type="button" data-toggle="modal" data-id="'.$vDate.'" class="btn btn-default btn-xs wBtn" style="">개인 및 독배예약</button>'.PHP_EOL; 
								?>
							</div>
							<? } ?>
							<div class="pull-right">
								<?php
								echo "<span>".$sch_year.".".$sch_month."</span>";
								echo "<span>.".sprintf('%02d', $day)."</span>";

								echo "<span> (".($weekstr[date('w', strtotime($vDate))])."요일)</span>";
								?>
								선택한 것을 : &nbsp;
								<input type="hidden" id="hdate_<?=intval($day)?>" value="<?=$sch_year."-".$sch_month."-".sprintf('%02d', $day); ?>">
								<select id="sel_send_<?=intval($day)?>">
									<option value="">---선택---</option>
									<option value="예약대기">예약대기</option>
									<option value="예약완료">예약완료</option>
									<option value="취소요청">취소요청</option>
									<option value="취소완료">취소완료</option>
									<option value="삭제">삭제</option>
								</select>&nbsp;
								<button type="button" onclick="fboardlist_ca_submit(this, <?=intval($day)?>)" class="btn btn-primary btn-xs" >확인</button>
							</div>
						</div>
					</div>

				</td>
			</tr>
		</tfoot>
		<? } ?>
		
	</table>


</div>
</div>
</form>

<?php
if($count == 7) {
	if($day != $total_day) {
		$count = 0;
	}
}
?>
<? } ?>

<script>
function fboardlist_ca_submit(f,n)
{	

	if ($("input[name='chk_wr_id[]']:checkbox:checked").length < 1) {
		alert("하나 이상 선택해주세요.");
		return;
	}

	var sel = $("#sel_send_" + n).val();

	if(sel == "") {
		alert("처리할 내용을 선택해주세요.");
		$("#sel_send_" + n).focus();
		return false;
	}

	if(sel == "예약완료") {

		$("input[name=date]").attr('value', $("#hdate_" + n).val()); 
		$("input[name=ca]").attr('value', "예약완료"); 
		$("input[name=upd]").attr('value', "chk"); 

		
		var lists = [];
		$("#sector_"+n+" input[name='chk_wr_id[]']:checked").each(function(i) {  
			lists.push($(this).val());
		});
		$("input[name=chk_id]").attr('value', lists); 
		

		$("#fboardlist_ca").submit();
	}

	if(sel == "예약대기") {

		$("input[name=date]").attr('value', $("#hdate_" + n).val()); 
		$("input[name=ca]").attr('value', "예약대기"); 
		$("input[name=upd]").attr('value', "chk"); 

		
		var lists = [];
		$("#sector_"+n+" input[name='chk_wr_id[]']:checked").each(function(i) {  
			lists.push($(this).val());
		});
		$("input[name=chk_id]").attr('value', lists); 
		

		$("#fboardlist_ca").submit();

	}

	if(sel == "취소요청") {
		
		$("input[name=date]").attr('value', $("#hdate_" + n).val()); 
		$("input[name=ca]").attr('value', "취소요청"); 
		$("input[name=upd]").attr('value', "chk"); 

		
		var lists = [];
		$("#sector_"+n+" input[name='chk_wr_id[]']:checked").each(function(i) {  
			lists.push($(this).val());
		});
		$("input[name=chk_id]").attr('value', lists); 
		

		$("#fboardlist_ca").submit();

	}

	if(sel == "취소완료") {

		$("input[name=date]").attr('value', $("#hdate_" + n).val()); 
		$("input[name=ca]").attr('value', "취소완료"); 
		$("input[name=upd]").attr('value', "chk"); 

		
		var lists = [];
		$("#sector_"+n+" input[name='chk_wr_id[]']:checked").each(function(i) {  
			lists.push($(this).val());
		});
		$("input[name=chk_id]").attr('value', lists); 
		

		$("#fboardlist_ca").submit();

	}

	if(sel == "삭제") {
		if (!confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?"))
			return false;
		
		$("input[name=date]").attr('value', $("#hdate_" + n).val()); 
		$("input[name=ca]").attr('value', "삭제"); 
		$("input[name=upd]").attr('value', "chk"); 

		
		var lists = [];
		$("#sector_"+n+" input[name='chk_wr_id[]']:checked").each(function(i) {  
			lists.push($(this).val());
		});
		$("input[name=chk_id]").attr('value', lists); 
		

		$("#fboardlist_ca").submit();
	}


}
</script>