<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($member[mb_level] < 8) {
	alert("관리자만 접근할 수 있습니다.");
	exit;
}
?>
<div id="bo_list">
	<div class="bo_fx">
		<ul class="btn_bo_user">
			<?php if ($member[mb_level] >= 8) { ?>
				<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>&month=month')"><?=$sch_month?>월 예약하기 페이지</button></li>
			<?php } ?>
			<li><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&reservation=check" class="btn btn-primary">예약확인 & 취소안내</a></li>
			<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>&month=month&reservation=list')"><?=$sch_month?>월 전체보기</button></li>
			<!--
			<? if(date('Y-m') == $_GET[sch_year]."-".$_GET[sch_month]) { ?>
				<li><button type="button" class="btn_admin" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&sch_year=<?=$sch_year?>&sch_month=<?=$sch_month?>')">일별 보기</button></li>
			<? } ?>
			-->
			<li><button type="button" class="btn btn-default" onclick="location.replace('<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&reservation=list')">오늘날짜보기</button></li>
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

	$strValue = strstr($wDD, $vDate);

	$boArr = explode(";", $strValue);

	$strArr = explode("|", $strValue);
	$boArr = $strArr[1];
	$boArr2 = explode(";", $boArr);

	// 선박 불러오기
	$bRow = sql_fetch("select bo_1 from {$g5['board_table']} where bo_table = '{$bo_table}'");
	$bArr = explode(";", $bRow[bo_1]);

?>

<form name="fboardlist_re" id="fboardlist_re" action="<?php echo $board_skin_url ?>/board_update.php" onsubmit="return fboardlist_re_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sw" id="sw_<?=$day?>" value="">
<input type="hidden" name="upd" id="upd_<?=$day?>" value="">
<input type="hidden" name="ca" id="ca_<?=$day?>" value="">
<input type="hidden" name="date" id="date_<?=$day?>" value="">
<input type="hidden" name="chk_id" id="chk_id_<?=$day?>" value="">
<div id="sector_<?=$day?>">
<div id="<?=$vDate?>" class="cal_list">


	<div class="">
		<table class="table table-sm table-bordered">
			<thead class="thead-dark">
				<tr>
					<th colspan="6" style="<?=$d_color?>background:#f7f7f7;"><?=$vDate;?> <span class='m_yoil'>(<?=($weekstr[date('w', strtotime($vDate))])?>요일)</span> <span class="wtime wtime2_<?=@(int)$day?>"><? if($boArr2[0]) { echo $boArr2[0]; } ?></span>
					<?
					if ($member[mb_level] >= 8) { 
						//echo '<a href="'.$write_href.'&vDate='.$vDate.'&wType=notice" class="btn_admin" style="color: #fff;">공지등록</a>'.PHP_EOL;
						//echo '<input type="hidden" class="wDate" id="wDate" value="'.$vDate.'">';
						echo '&nbsp;&nbsp;<button type="button" data-toggle="modal" data-id="'.$vDate.'" class="btn btn-default btn-sm wBtn" style="">물때등록</button>'.PHP_EOL; 
					}
					?>
					</p>
					
					</th>
				</tr>
				<tr>
					<td scope="col" style="width:20%;">선박</td>
					<td scope="col" style="width:65%;" class="visible-sm visible-xs">예약정보</td>
					<td scope="col" style="width:30%;" class="hidden-sm hidden-xs">이름 / 연락처 / 요청사항</td>
					<td scope="col" style="width:20%;" class="hidden-sm hidden-xs">종류</td>
					<td scope="col" style="width:5%;" class="hidden-sm hidden-xs">인원수</td>
					<td scope="col" style="width:20%;" class="hidden-sm hidden-xs">총금액 / 예약금</td>
					<td scope="col" style="width:5%;" class="hidden-sm hidden-xs">상태</td>
					<td scope="col" style="width:15%;" class="visible-sm visible-xs">상태</td>
				</tr>
			</thead>

			<tbody>
			<?php
			
			$s_count = 0;

			for($ship=0; $ship<count($bArr)-1; $ship++) {
				
				$cnt_db = count($arr_db[$vDate]);

				$sArr = explode("|", $bArr[$ship]);

				$bRow2 = sql_fetch("select bo_1 from {$g5['board_table']} where bo_table = '{$bo_table}'");
				$bArr2 = explode(";", $bRow2[bo_1]);
				
				// 독배인지 확인
				$dokCheck = explode("|", $bArr2[$ship]);

				$dokbae = false;
				if($dokCheck[3] == 1) { $dokbae = true; }

				$re_cnt = sql_fetch("SELECT count(*) as cnt FROM {$write_table} where wr_2 = '{$vDate}' and wr_3 = '{$sArr[1]}' and (ca_name != '공지')");

				if($re_cnt[cnt]) {

					if($re_cnt[cnt] != 1){
						$re_cnt2 = "rowspan='".($re_cnt[cnt]+1)."'";
					}else{
						$re_cnt2 = "rowspan='2'";
					}

				}else{
					$re_cnt2 = "";
				}

				if($re_cnt[cnt] == 0) {
					$re_td = "rowspan='2'";
				}

			?>
				<tr>

					<td <?=$re_cnt2?> style="background:#f3f3f3;">

					<?php
					echo $sArr[1];
					?>&nbsp;<div class="visible-xs visible-sm"></div>(<span style='font-weight:700;color:#ff6600;'><?=$sArr[2]?></span>
					<?php
						//** 잔여 리스트 **//
						$p_cnt = 0;

						for ($z=0; $z < $cnt_db; $z++) {
							if($arr_db[$vDate][$z][wr_6] && $arr_db[$vDate][$z]['wr_3'] == $sArr[1] && !strstr($arr_db[$vDate][$z]['ca_name'], "취소")) {
								$p_cnt += ($arr_db[$vDate][$z]['wr_6']);
							}
						}
						echo " / <span style='color:#489cdb;font-weight:700;'>".($sArr[2]-$p_cnt)."</span>)";

						if($dokbae) {
							echo '<div class="dok_txt">[개인 및 독배예약]</div>';
						}
					?>

					</td>
					
					<? if($re_cnt[cnt] == 0) { ?>
						<td class="visible-sm visible-xs"></td>
						<td class="hidden-sm hidden-xs"></td>
						<td class="hidden-sm hidden-xs"></td>
						<td class="hidden-sm hidden-xs"></td>
						<td class="hidden-sm hidden-xs"></td>
						<td class="hidden-sm hidden-xs"></td>
						<td class="visible-sm visible-xs"></td>
					<? } ?>
				
				</tr>

				<?
				$list_res = sql_query("SELECT wr_id, wr_subject, wr_content, ca_name, wr_name, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 FROM {$write_table} where wr_2 = '{$vDate}' and wr_3 = '{$sArr[1]}' and (ca_name != '공지')");
				$list_res2 = sql_fetch("SELECT count(*) as cnt FROM {$write_table} where wr_2 = '{$vDate}' and wr_3 = '{$sArr[1]}' and (ca_name != '공지')");

				$ca_list = sql_fetch("select bo_category_list from {$g5['board_table']} where bo_table = '{$bo_table}'");
				$ca_ex = explode("|", $ca_list[bo_category_list]);

				$ca_style = "";

				$ca_cnt = 0;

				while ($rrow = sql_fetch_array($list_res))
				{

				?>

					<tr>
						<td>
							<div>
							<? echo "<input type='checkbox' name='chk_wr_id[]' id='chk_wr_id_".$ca_cnt."' value='".$rrow[wr_id]."'>"; ?>
							</div>
							<a data-toggle="modal" data-id="<?=$vDate;?>" data-id2="<?=$rrow[wr_3];?>" data-id3="<?=$sArr[2];?>" data-id3="<?=$sArr[3];?>" data-id4="<?=$ship;?>" data-botable="<?=$bo_table?>" data-write="u" data-wrid="<?=$rrow[wr_id]?>" data-cname="<?=$rrow[ca_name]?>" class="resBtn" style="cursor:pointer;"><?=$rrow[wr_name]?> (<?=$rrow[wr_1]?>) / <?=$rrow[wr_4]?></a>

							<? if($rrow[wr_content] != "." && strlen($rrow[wr_content]) != 1) { // 요청사항이 있을때만 출력?>
								<div>=> <?=@nl2br($rrow[wr_content]);?></div>
							<? } ?>

							<div class="visible-sm visible-xs">
								<hr class="m_hr">
								<? if($rrow['wr_9']) { ?><div class="dok_txt">[독배]</div><? } ?>
								<div><?=$rrow[wr_5]?> / <?=$rrow[wr_6]?>명</div>
								<hr class="m_hr">
								<div>
								<span style="font-weight:700;color:#f03709;"><?=@number_format($rrow[wr_7]);?>원</span>
								/
								<span style=""><?=@number_format($rrow[wr_8]);?>원</span>
							</div>
						</td>
						
						<td class="hidden-sm hidden-xs">
							<?=$rrow[wr_5]?>
							<? if($rrow['wr_9']) { ?><div class="dok_txt">[독배]</div><? } ?>
						</td>

						<td class="hidden-sm hidden-xs">
							<?=$rrow[wr_6]?>명
						</td>

						<td class="hidden-sm hidden-xs">
						<span style="font-weight:700;color:#f03709;"><?=@number_format($rrow[wr_7]);?>원</span>
						/
						<span style=""><?=@number_format($rrow[wr_8]);?>원</span>
						</td>

						<td>
							<ul class="data-list">
								<li>
									<?
									switch ($rrow[ca_name]) {
										case '예약대기'  : $ca_style = "background:#8a8a8a;color:#fff;"; break;
										case '예약완료'  : $ca_style = "background:#347efa;color:#fff;"; break;
										case '취소요청'  : $ca_style = "background:#e8bb46;color:#fff;"; break;
										case '취소완료'  : $ca_style = "background:#e43c03;color:#fff;"; break;
										default   : $ca_style = "background:#8a8a8a;color:#fff;"; break;
									}
									
									echo "<span style='padding:2px 1px;".$ca_style."'>".$rrow[ca_name]."</span>";
									?>
								</li>
							</ul>
						</td>

					</tr>
					<? $ca_cnt++ ?>
				<? } ?>

				<?
					if($s_count == 7) {
						$s_count = 0;
					}
				?>
				
			<?
			}
			?>

			</tbody>

			<? if ($member[mb_level] >= 8) { ?>
				<tfoot>
					<tr>
						<td colspan="6">
							
							<div class="bo_fx">
								<div class="bo_fx_select">
									<?php
									echo "<span>".$sch_year.".".$sch_month."</span>";
									echo "<span>.".sprintf('%02d', $day)."</span>";

									echo "<span> (".($weekstr[date('w', strtotime($vDate))])."요일)</span>";
									?>
									선택한 것을 : &nbsp;
									<input type="hidden" id="hdate_<?=$day?>" value="<?=$sch_year."-".$sch_month."-".sprintf('%02d', $day); ?>">
									<select id="sel_send_<?=$day?>">
										<option value="">---선택---</option>
										<option value="예약대기">예약대기</option>
										<option value="예약완료">예약완료</option>
										<option value="취소요청">취소요청</option>
										<option value="취소완료">취소완료</option>
										<option value="삭제">삭제</option>
									</select>&nbsp;
									<button type="button" onclick="fboardlist_re_submit(this, <?=$day?>)" class="btn btn-primary btn-xs" >확인</button>
								</div>
							</div>

						</td>
					</tr>
				</tfoot>
				<? } ?>

		</table>
	</div>
	


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
function fboardlist_re_submit(f,n)
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
		

		$("#fboardlist_re").submit();
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
		

		$("#fboardlist_re").submit();

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
		

		$("#fboardlist_re").submit();

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
		

		$("#fboardlist_re").submit();

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
		

		$("#fboardlist_re").submit();
	}

}
</script>