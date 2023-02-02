<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

?>
<style type="text/css">
.tbl_head01 td {
    padding: 5px;
    border-top: 1px solid #e9e9e9;
    border-bottom: 1px solid #e9e9e9;
    border-left: 1px solid #e9e9e9;
	border-right: 1px solid #e9e9e9;
    line-height: 1.5em;
    word-break: break-all;
}
.tbl_head01 thead th {
    padding: 12px 0;
    border-top: 1px solid #d1dee2;
    border-bottom: 1px solid #d1dee2;
	border-left: 1px solid #d1dee2;
	border-right: 1px solid #d1dee2;
    background: #e5ecef;
    color: #383838;
    font-size: 0.95em;
    text-align: center;
    letter-spacing: -0.1em;
}

.gd_tbody td { text-align: center; }
</style>

<h2 id="container_title"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?><span class="sound_only"> 목록</span></h2>

<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">

    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>
        <fieldset id="bo_sch">
            <legend>게시물 검색</legend>

            <form name="fsearch" method="get">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl">
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
                <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
                <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
            </select>
            <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="required frm_input" size="15" maxlength="20">
            <input type="submit" value="검색" class="btn_submit">
            </form>
        </fieldset>
    </div>
    
    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
			<th scope="col" style="width:50px;">번호</th>
            <th scope="col" style="width:100px;">이름</th>
			<th scope="col" style="width:120px;">휴대폰번호</th>
			<th scope="col" style="width:100px;">상태</th>
			<th scope="col"style="width:130px;"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>작성일</a></th>
        </tr>
        </thead>
        <tbody>
			
        <?php

		//print_r2($list);
		
        for ($i=0; $i<count($list); $i++) {

			
        ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
			<td style="text-align: center;"><?=$list[$i]['wr_id']?></td>
      
			<td style="text-align: center;">
				<a href="<?php echo $list[$i]['href'] ?>">
                    <?=$list[$i]['wr_name']?>
                </a>
			</td>
			<td style="text-align: center;">
				<a href="<?php echo $list[$i]['href'] ?>">
				<?	//핸드폰번호 중간에 - 처리와 마지막 뒷 4자리 마스킹처리
					$phone = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $list[$i]['wr_4']);
					$phone1 = explode("-",$phone); 
					$wr_phone = $phone1[0]."-".$phone1[1]."-****"; 
					
					echo $wr_phone;
				?>
				</a>
			</td>
			<td style="text-align: center;">
				<?php 
				if ( empty ( $list[$i]['wr_10'] ) ) {
					echo "대기중";
				} else if ( $list[$i]['wr_10'] == "배송중" ) {
					echo "<font color='blue'>".$list[$i]['wr_10']."</font>";
				} else if ( $list[$i]['wr_10'] == "배송완료" ) {
					echo "<font color='red'>".$list[$i]['wr_10']."</font>";
				}
				?>
			</td>
            <td class="td_date"><?php echo substr($list[$i]['wr_datetime'],0,10) ?></td>
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($rss_href || $write_href) { ?>
            <ul class="btn_bo_user">
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
				<?php if ($member['mb_level'] >= 8) { ?><li><a class="btn_admin" id="goodsbtn" style="cursor: pointer">상품관리</a></li><?php } ?>
                <?php if ($member['mb_level'] >= 8) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
                <?php if ($write_href) { ?><li clss="write_btn"><a href="<?php echo $write_href ?>" class="btn_b02">상품주문</a></li><?php } ?>
            </ul>
         <?php } ?>
         
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"> 목록</a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    
    </form>
</div>

<?php if ( $member['mb_level'] >= 8 ) { ?>
<!-- Modal -->
<div class="modal fade" id="setting" role="dialog">
    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5><i class="fa fa-list" aria-hidden="true"></i> 상품관리</h5>
			</div>
			<div class="modal-body tbl_head01 tbl_wrap" style="max-height: 500px;overflow: auto;">
				<form id="goods" method="post">
					<table>
						<thead>
						<tr>
							<th>상품명</th>
							<th>단위</th>
							<th>가격</th>
							<th>관리</th>
						</tr>
						</thead>
						<tbody class="gd_tbody">
							<tr>
								<td><input type="text" name="wr_subject" id="gd_name" class="frm_input input03"></td>
								<td><input type="text" name="wr_1" id="gd_measure" class="frm_input input01"></td>
								<td><input type="text" name="wr_2" id="gd_price" class="frm_input input01"></td>
								<td><button id="regBtn" type="button" class="btn btn-default">등록</button></td>
							</tr>
						</tbody>
					</table>
				</form>
				<table>
					<thead>
						<tr>
							<th>상품명</th>
							<th>단위</th>
							<th>가격</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="gd_tbody2">
					<?php
						$sql = " select * from g5_write_{$board['bo_1']} order by wr_id desc";
						$rs = sql_query( $sql );
						for ( $i = 0; $row = sql_fetch_array( $rs ); $i++ ) {
					?>
						<tr id="tr_<?=$row['wr_id']?>">
							<td><input type="text" name="wr_subject" id="gd_name_<?=$row['wr_id']?>" class="frm_input input03" value="<?=$row['wr_subject']?>"></td>
							<td><input type="text" name="wr_1" id="gd_measure_<?=$row['wr_id']?>" class="frm_input input01" value="<?=$row['wr_1']?>"></td>
							<td><input type="text" name="wr_2" id="gd_price_<?=$row['wr_id']?>" class="frm_input input01" value="<?=$row['wr_2']?>"></td>
							<td>
								<button id="editBtn" type="button" class="btn btn-default" onclick="editBtn( <?=$row['wr_id']?> )">수정</button>
								<button id="delBtn" type="button" class="btn btn-default" onclick="delBtn( <?=$row['wr_id']?> )">삭제</button>
							</td>
						</tr>
					<?php 
						} 
					?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
			</div>
		</div>
    </div>
</div> 
<?php } ?>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<?php if ( $member['mb_level'] >= 8 ) { ?>
<script>
$( '#goodsbtn' ).click( function () {
	$( '#setting' ).modal();
} );

// 상품등록
$( '#regBtn' ).click( function () {
	var $gd_name = $( '#gd_name' ).val();
	var $gd_measure = $( '#gd_measure' ).val();
	var $gd_price = $( '#gd_price' ).val();
	
	if ( $gd_name == '' ) {
		alert( '상품명을 입력하세요.' );
		$( '#gd_name' ).focus();
		return false;
	} else if ( $gd_measure == '' ) {
		alert( '단위를 입력하세요.' );
		$( '#gd_measure' ).focus();
		return false;
	} else if ( $gd_price == '' ) {
		alert( '가격을 입력하세요.' );
		$( '#gd_price' ).focus();
		return false;
	} else {
		$.ajax( {
				url: "<?=$board_skin_url?>/ajax/ajax_ins_update.php",
				type: "POST",
				data: {
					"status" : "ins",
					"bo_table" : '<?=$bo_table?>',
					"bo_1" : '<?=$board['bo_1']?>',
					"gd_name" : $gd_name,
					"gd_measure" : $gd_measure,
					"gd_price" : $gd_price
				},
				dataType: "json",
				async: false,
				cache: false,
				success: function( data, textStatus ) {
					alert( '상품 등록이 완료되었습니다.' );
					console.log( data );
					var appendTr = "<tr id='tr_"+data.id+"'>";
						appendTr += "<td><input type=\"text\" name=\"wr_subject\" id=\"gd_name_"+data.id+"\" class=\"frm_input input03\" value=\""+$gd_name+"\"></td>";
						appendTr += "<td><input type=\"text\" name=\"wr_1\" id=\"gd_measure_"+data.id+"\" class=\"frm_input input01\" value=\""+$gd_measure+"\"></td>";
						appendTr += "<td><input type=\"text\" name=\"wr_2\" id=\"gd_price_"+data.id+"\" class=\"frm_input input01\" value=\""+$gd_price+"\"></td>";
						appendTr += "<td><button id=\"editBtn\" type=\"button\" class=\"btn btn-default\" onclick=\"editBtn( "+data.id+" )\">수정</button>";
						appendTr += "<button id=\"delBtn\" type=\"button\" class=\"btn btn-default\" onclick=\"delBtn( "+data.id+" )\">삭제</button></td>";
						appendTr += "</tr>";
					$( '.gd_tbody2 tr:first' ).before( appendTr );
				},
				error: function( xhr, textStatus, errorThrown ) {
					console.error( textStatus );
				}
		} );
	}
} );

// 상품수정
function editBtn( id ) {
	var $gd_name = $( '#gd_name_'+id ).val();
	var $gd_measure = $( '#gd_measure_'+id ).val();
	var $gd_price = $( '#gd_price_'+id ).val();
	
	if ( $gd_name == '' ) {
		alert( '상품명을 입력하세요.' );
		$( '#gd_name_'+id ).focus();
		return false;
	} else if ( $gd_measure == '' ) {
		alert( '단위를 입력하세요.' );
		$( '#gd_measure_'+id ).focus();
		return false;
	} else if ( $gd_price == '' ) {
		alert( '가격을 입력하세요.' );
		$( '#gd_price_'+id ).focus();
		return false;
	} else {
		$.ajax( {
				url: "<?=$board_skin_url?>/ajax/ajax_ins_update.php",
				type: "POST",
				data: {
					"status" : "upd",
					"bo_table" : '<?=$bo_table?>',
					"bo_1" : '<?=$board['bo_1']?>',
					"id" : id,
					"gd_name" : $gd_name,
					"gd_measure" : $gd_measure,
					"gd_price" : $gd_price
				},
				dataType: "json",
				async: false,
				cache: false,
				success: function( data, textStatus ) {
					alert( '상품 수정이 완료되었습니다.' );
				},
				error: function( xhr, textStatus, errorThrown ) {
					console.error( textStatus );
				}
		} );
	}
}

// 상품삭제
function delBtn( id ) {
	if ( confirm( "해당 상품을 삭제하시겠습니까?" ) == true ) {
		$.ajax( {
			url: "<?=$board_skin_url?>/ajax/ajax_ins_update.php",
			type: "POST",
			data: {
				"status" : "del",
				"bo_table" : '<?=$bo_table?>',
				"bo_1" : '<?=$board['bo_1']?>',
				"id" : id
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function( data, textStatus ) {
				alert( '상품 삭제가 완료되었습니다.' );
				$( '#tr_'+data.id ).remove();
			},
			error: function( xhr, textStatus, errorThrown ) {
				console.error( textStatus );
			}
		} );
	} else {
		return false;
	}
}

</script>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
