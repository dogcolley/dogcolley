<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$uid = $_GET["uid"];
$uname = $_GET["uname"];
$unum = $_GET["unum"];

$str_encrypt = new str_encrypt();
$uid = $str_encrypt->decrypt($uid);

$str_encrypt = new str_encrypt();
$wr_name = $str_encrypt->decrypt($uname);

$str_encrypt = new str_encrypt();
$wr_4 = $str_encrypt->decrypt($unum);


$ss_name = 'ss_secret_'.$bo_table.'_'.$wr_name.'_'.$wr_4;
//set_session("ss_secret", "$bo_table|$wr[wr_num]");
get_session($ss_name, TRUE);

if($_SESSION[$ss_name]) {
	$w = "u";
}

if (!$_SESSION[$ss_name])
	alert('잘못된 접근입니다.');

?>
<form name="c_frm" id="c_frm" method="post" action="<?php echo $board_skin_url ?>/board_update.php">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="upd" value="cancel">
<input type="hidden" name="ca" value="">
<input type="hidden" name="cancel_id" value="">
<input type="hidden" name="w" value="<?=$w?>">

<div id="<?=$vDate?>" class="cal_list">

	<!-- PC 화면 리스트 [시작] -->
	<div class="hidden-xs hidden-sm">
		<h1>예약 확인</h1>
		
		<table class="table table-sm table-bordered">
			<thead class="thead-dark">
				<tr>
					<td scope="col">순서</td>
					<td scope="col" style="width:10%;">날짜</td>
					<td scope="col" style="width:15%;">선박</td>
					<td scope="col" style="width:25%;">이름 / 연락처 / 요청사항</td>
					<td scope="col" style="width:15%;">종류</td>
					<td scope="col" style="width:5%;">인원수</td>
					<td scope="col" style="width:15%;">총금액 / 예약금</td>
					<td scope="col" style="width:10%;">신청일시</td>
					<td scope="col" style="width:5%;">상태</td>
				</tr>
			</thead>
			<tbody>
			<?
			$uArr = explode("|", $uid);
			/*
			$sql = "select wr_name, wr_id, ca_name, wr_datetime, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8 from {$write_table} where wr_id = SUBSTRING_INDEX('".$uid."', '|', ".(count($uArr)-1).") order by wr_2 desc";
			$res = sql_query($sql);

			while($aRow = sql_fetch_array($res)) {
				$arr_db[$aRow['wr_2']][] = $aRow;
			}
			if ($res) sql_free_result($res);


			print_r($sql);
			*/

			unset($arr_db);
			$arr_db = array();

			for ($i=0; $i<count($uArr)-1; $i++) { 
				$sql = "SELECT wr_name, wr_id, ca_name, wr_content, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10, wr_datetime FROM {$write_table} where wr_id = '".$uArr[$i]."'";
				$row = sql_fetch($sql);
				$arr_db[] = array($row);
			}
			echo "<br>";

			foreach ($arr_db as $key => $row) {
				$sort[$key] = $row[0][wr_2];
				$datetime[$key] = $row[0][wr_datetime];
			}
			array_multisort($sort, SORT_DESC, $arr_db);

			for($i=0; $i<count($arr_db); $i++) {
			?>

			
			<tr>
				<td><?=($i+1)?></td>
				<td><?=$arr_db[$i][0][wr_2]?></td>
				<td><?=$arr_db[$i][0][wr_3]?><? if($arr_db[$i][0][wr_9] == 1) { ?><div class="dok_txt">[독배]</div><? } ?></td>
				<td><?=$arr_db[$i][0][wr_name]?> (<?=$arr_db[$i][0][wr_1]?>) / <?=$arr_db[$i][0][wr_4]?>
					<? if($arr_db[$i][0][wr_content] != "." && strlen($arr_db[$i][0][wr_content]) != 1) { // 요청사항이 있을때만 출력?>
						<div>=> <?=@nl2br($arr_db[$i][0][wr_content]);?></div>
					<? } ?>
				</td>
				<td><?=$arr_db[$i][0][wr_5]?><? if($arr_db[$i][0][wr_9] == 1) { ?><div class="dok_txt">[독배]</div><? } ?></td>
				<td><?=$arr_db[$i][0][wr_6]?>명</td>
				<td><span style="font-weight:700;color:#f03709;">총 금액 : <?=@number_format($arr_db[$i][0][wr_7])?>원</span><br>예약금 : <?=@number_format($arr_db[$i][0][wr_8])?>원</td>
				<td><?=$arr_db[$i][0][wr_datetime]?></td>
				<td>
				<?
					switch ($arr_db[$i][0][ca_name]) {
						case '예약대기'  : $ca_style = "background:#8a8a8a;color:#fff;"; break;
						case '예약완료'  : $ca_style = "background:#347efa;color:#fff;"; break;
						case '취소요청'  : $ca_style = "background:#e8bb46;color:#fff;"; break;
						case '취소완료'  : $ca_style = "background:#e43c03;color:#fff;"; break;
						default   : $ca_style = "background:#8a8a8a;color:#fff;"; break;
					}

					echo "<span style='padding:2px 1px;".$ca_style."'>".$arr_db[$i][0][ca_name]."</span>";
					

					$timenow = date("Y-m-d"); 
					$timetarget = $arr_db[$i][0][wr_2];

					$str_now = strtotime($timenow);
					$str_target = strtotime($timetarget);

					if(strstr($arr_db[$i][0][ca_name], "예약")) {
					
						if($member[mb_level] >= 8) {
							echo '<div style="margin-top:8px;"><button type="button" onclick="re_can(\''.$arr_db[$i][0][ca_name].'\', \''.$arr_db[$i][0][wr_id].'\')" class="btn btn-default btn-xs" >취소요청</button></div>';
						}else if($str_now <= $str_target && $member[mb_level] < 8) {
							echo '<div style="margin-top:8px;"><button type="button" onclick="re_can(\''.$arr_db[$i][0][ca_name].'\', \''.$arr_db[$i][0][wr_id].'\')" class="btn btn-default btn-xs" >취소요청</button></div>';
						}

					}
					?>

				</td>
			</tr>


			<?
			}
			?>


			</tbody>
		</table>
	</div>
	<!-- PC 화면 리스트 [끝] -->




	<!-- 모바일 & 태블릿 리스트 [시작] -->
	<div class="visible-xs visible-sm">
		<h1>예약 확인</h1>

		<table class="table table-sm table-bordered">
			<thead class="thead-dark">
				<tr>
					<td scope="col" style="width:15%;">날짜</td>
					<td scope="col" style="width:75%;">예약정보</td>
					<td scope="col" style="width:10%;">상태</td>
				</tr>
			</thead>
			<tbody>
			<?
			$uArr = explode("|", $uid);
			
			/*
			$sql = "select wr_name, wr_id, ca_name, wr_datetime, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8 from {$write_table} where wr_id = SUBSTRING_INDEX('".$uid."', '|', ".(count($uArr)-1).") order by wr_2 desc";
			$res = sql_query($sql);

			while($aRow = sql_fetch_array($res)) {
				$arr_db[$aRow['wr_2']][] = $aRow;
			}
			if ($res) sql_free_result($res);


			print_r($sql);
			*/

			unset($arr_db);
			$arr_db = array();

			for ($i=0; $i<count($uArr)-1; $i++) { 
				$sql = "SELECT wr_name, wr_id, wr_content, ca_name, wr_datetime, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8 FROM {$write_table} where wr_id = '".$uArr[$i]."'";
				$row = sql_fetch($sql);
				$arr_db[] = array($row);
			}
			echo "<br>";

			foreach ($arr_db as $key => $row) {
				$sort[$key] = $row[0][wr_2];
				$datetime[$key] = $row[0][wr_datetime];
			}
			array_multisort($sort, SORT_DESC, $arr_db);

			for($i=0; $i<count($arr_db); $i++) {
			?>

			
			<tr>
				<td><?=$arr_db[$i][0][wr_2]?></td>
				<td>
					<span style="font-weight:700;"><?=$arr_db[$i][0][wr_3]?></span>
					<hr class="m_hr">
					<?=$arr_db[$i][0][wr_name]?> (<?=$arr_db[$i][0][wr_1]?>) / <?=$arr_db[$i][0][wr_4]?>

					<? if($arr_db[$i][0][wr_content] != "." && strlen($arr_db[$i][0][wr_content]) != 1) { // 요청사항이 있을때만 출력?>
						<hr class="m_hr">
						=> <?=@nl2br($arr_db[$i][0][wr_content]);?>
					<? } ?>
					<hr class="m_hr">
					<?=$arr_db[$i][0][wr_5]?> / <?=$arr_db[$i][0][wr_6]?>명
					<hr class="m_hr">
					<span style="font-weight:700;color:#f03709;"><?=@number_format($arr_db[$i][0][wr_7])?>원</span> / <?=@number_format($arr_db[$i][0][wr_8])?>원
				</td>
				<td>
				<?
					switch ($arr_db[$i][0][ca_name]) {
						case '예약대기'  : $ca_style = "background:#8a8a8a;color:#fff;"; break;
						case '예약완료'  : $ca_style = "background:#347efa;color:#fff;"; break;
						case '취소요청'  : $ca_style = "background:#e8bb46;color:#fff;"; break;
						case '취소완료'  : $ca_style = "background:#e43c03;color:#fff;"; break;
						default   : $ca_style = "background:#8a8a8a;color:#fff;"; break;
					}

					echo "<span style='padding:2px 1px;".$ca_style."'>".$arr_db[$i][0][ca_name]."</span>";

					if(strstr($arr_db[$i][0][ca_name], "대기")) {
						echo '<div style="margin-top:8px;"><button type="button" onclick="re_can(\''.$arr_db[$i][0][ca_name].'\', \''.$arr_db[$i][0][wr_id].'\')" class="btn btn-default btn-xs" >취소요청</button></div>';
					}
					?>
				</td>
			</tr>


			<?
			}
			?>


			</tbody>
		</table>
	</div>
	<!-- 모바일 & 태블릿 리스트 [끝] -->



	<?php include_once($board_skin_path."/memo_view.skin.php"); ?>


</div>

<div class="btn_confirm" style="margin:0 0 50px 0;">
	<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>">돌아가기</a>
</div>


</form>

<script>
function re_can(c,n)
{	

	var f = document.c_frm;
	
	if(c && n) {

		if(c == "예약완료") {
			if (!confirm("예약완료 상태에서는 관리자와 합의된 사항이 아니면\n무단으로 취소가 불가능합니다.\n\n정말 취소하시겠습니까?"))
				return false;
		}else{
			if (!confirm("취소요청을 하면 관리자의 승인이 있기 전까지 재예약을 할 수 없습니다.\n\n정말 취소하시겠습니까?"))
				return false;
		}

		f.upd.value = "cancel";
		f.ca.value = "취소요청";
		f.cancel_id.value = n;

		f.submit();

    }else{
		return false;
	}

	/*
	if(document.pressed == "취소요청") {

        if (!confirm("예약완료 상태에서는 관리자와 협의된 사항이 아니면\n무단으로 취소가 불가능합니다.\n\n정말 취소하시겠습니까?"))
            return false;

		f.upd.value = "cancel";
		f.ca.value = "취소요청";

		f.removeAttribute("target");
        f.action = "<?php echo $board_skin_url ?>/board_update.php";
    }
	*/

}
</script>