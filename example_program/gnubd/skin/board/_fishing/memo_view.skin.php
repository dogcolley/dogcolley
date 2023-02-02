<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

		

// 예약 내용 불러오기
$mRow = sql_fetch("select bo_4 from {$g5['board_table']} where bo_table = '{$bo_table}'");
$mArr = explode(";", $mRow[bo_4]);
?>
<div id="f_memo">
	<table>
		<tbody>
			<tr>
				<th>예약규정<br>안내</th>
				<td>
					<ul>
						<?
						for($i=0; $i<count($mArr)-1; $i++) { 
							$sArr = explode("|", $mArr[$i]);
						?>
						<li><?=$sArr[1]?></li>
						<? } ?>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
</div>