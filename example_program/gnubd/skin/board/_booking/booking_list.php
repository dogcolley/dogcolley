<!-- 게시판 카테고리 시작 { -->
<?php if ($is_category) { ?>
<nav id="bo_cate">
    <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
    <ul id="bo_cate_ul">
        <?php echo $category_option ?>
    </ul>
</nav>
<?php } ?>

<div id="list_booking">

    <!-- } 게시판 페이지 정보 및 RSS 끝 -->
    <h2 class="reservAccountTitle" style="text-align:center;clear: both;">
        <span class="highlight"><i class="fab fa-envira"></i></span> 
        <span class="highlight1" id="list_title">객실 리스트</span> 
        
    </h2>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">
    <?php if ($is_checkbox) { ?>
    <div id="gall_allchk">
        <br>
        <br>
        <input type="checkbox" id="chkall">
        <label for="chkall">전체 선택</label>
    </div>
    <?php } ?>

    <ul class="fz_gallery_list row" id="sortable">
        <?php
        for ($i=0; $i<count($list); $i++) {
            $sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$list[$i]['wr_id']}' AND mta_db_table = 'board/{$bo_table}'";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                $list[$i]["{$row['mta_key']}"] = $row['mta_value'];
            }
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
            if($thumb['src']) {
                $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
            } else {
                $img_content = '<i class="fa fa-picture-o"></i>';
            }
         ?>
        <li class="col-sm-12 col-xs-6 <?=$wr_id == $list[$i]['wr_id'] ? " active" : ''?>" id="<?=$list[$i]['wr_num']?>" value="<?=$list[$i]['wr_id']?>">
            <a href='<?php echo $list[$i]['href'];?>' class="fz_gallery_li_wrap">
                <span class="fz_gallery_thumb"><?php echo $img_content;?></span>
                <span class="fz_gallery_box">
                    <span class="fz_gallery_title">
                    <?php
                        echo $list[$i]['icon_reply'];
                        echo $list[$i]['article_type'];
                        if ($is_category && $list[$i]['ca_name']) {echo "<span class=\"fz_cate_link\">[{$list[$i]['ca_name']}]</span>";}
                        echo $list[$i]['subject'];
                        echo $list[$i]['icon_pack'];
                    ?>
                    </span>
                    <span class="fz_gallery_content">
                        <?php
                        echo "기준인원 ".$list[$i]['wr_min']."명 / 최대인원 ".$list[$i]['wr_max']."명<br>";
                        echo "객실 면적 - ".$list[$i]['wr_area']."평<br>";
                        ?>
                    </span> 
                </span>
            </a>
            <a href="./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i]['wr_id']?>">
            <span class="fz_gallery_user">
                예약하기
                <?php if ($is_checkbox) { ?>
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="fz_admin_chk">
                <?php } ?>
            </span>
            </a>
        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<div class="fz_empty_list">게시물이 없습니다.</div>'; } ?>
    </ul>

    <?php
    $bool_mobile = false;
    $arr_browser = array ("iPhone","UP.Browser","Nokia","webOS","Opera Mini","opera mobi","Windows Phone","POLARIS","Ice Cream Sandwich","Gallexy","Optimus","BlackBerry","Android","Gallexy","Windows CE","LG","MOT","SAMSUNG","SonyEricsson","IEMobile","Mobile","lgtelecom","PPC");
    for($indexi = 0; $indexi < count($arr_browser); $indexi++) {
        if(strpos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true) {
            $bool_mobile = true;
            break;
        }
    }
    ?>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm btn_admin2">
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <?php if(!$bool_mobile ){?>
                <li><input type="button" name="sorting_mode" id="sorting_mode" value="순서바꾸기"></li>
            <? }?>
        </ul>
        <?php } ?>
        
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li><?php } ?>
        </ul>
        <?php } ?>

        <?php if ($is_checkbox): ?>

        <ul class="btn_bo_user">
            
            <li><a href="<?php echo $write_href ?>" class="btn_b02">객실등록</a></li>
            <!-- <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_b02">관리자</a></li><?php } ?> -->
            <!-- <?php if ($write_href) { ?><?php } ?>  -->
        </ul>    
        <?php endif ?>
        
        
    </div>
    <?php } ?>


    </form>


<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php 
    $write_pages=str_replace("처음", "<i class='fa fa-angle-left'></i><i class='fa fa-angle-left'></i>", $write_pages);
    $write_pages=str_replace("이전", "<i class='fa fa-angle-left'></i>", $write_pages);
    $write_pages=str_replace("다음", "<i class='fa fa-angle-right'></i>", $write_pages);
    $write_pages=str_replace("맨끝", "<i class='fa fa-angle-right'></i><i class='fa fa-angle-right'></i>", $write_pages);
    echo $write_pages; 
?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>
    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <span class="select_box" style="width: 250px;">
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>객실명</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>객실소개</option>
        
    </select>
    </span>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="i_text w_sbox required" size="15" maxlength="20" placeholder="검색어 필수">
    <input type="submit" value="검색" class="btn_submit1">

    </form>
</fieldset>

</div>