<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css?ver=20201008">', 0);
add_stylesheet('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">', 0);
add_javascript('<script type="text/javascript" src="'.$board_skin_url.'/js/default.js?ver=20201008"></script>', 100);
include_once($board_skin_path.'/lib/draggable_sorting/draggable.php');
//설정한 예약 대기시간 이내로 완료처리가 안될 시 예약 취소 처리

include($board_skin_path."/time_out_reserve.php");

// mailer('관리자','admin@domain.com','jaiemf@naver.com','제목','테스트');
// mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="");

?>

<?php if ($_GET['check']) {?>
    <?php include_once($board_skin_path . '/checking.php')?>
<?php }else{?>

<h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2>
<!-- 게시판 목록 시작 { -->
  
<div id="bo_list" class="fz_wrap">
    
    <?php 
        //검색형
        $total_list = array();
        $sql = "SELECT * FROM {$g5['write_prefix']}{$bo_table} order by wr_num";
        $result= sql_query($sql);
        while($row = sql_fetch_array($result)){
            $total_list[]=$row;
        }
        include_once($board_skin_path . '/calendar.php');    
        include_once($board_skin_path . '/booking_list.php');    
    ?>
    
<!-- } 게시판 검색 끝 -->
</div>
<!-- if 끝 -->
<?php }?>

<?php if ($is_checkbox) { ?>
<script type="text/javascript">
$(function(){
    $("#chkall").click(function(){
        $(".fz_gallery_list input[type='checkbox']").prop("checked", $(this).prop("checked"));
    });
    $("#fz_admin_select").select_box({
        useBorderbox:true,
        height:24,
        onchange:function(p, $select, ul){
            if(!$select.val()) return false;

            if(!$(".fz_gallery_list input[type='checkbox']:checked").length)
            {
                alert($select.val()+" 할 게시물을 하나 이상 선택하세요.");
                $select.find("option").eq(0).prop("selected", true).change();
                return false;
            }

            if($select.val()=="선택복사" || $select.val()=="선택이동")
            {
                var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

                $("#fboardlist input[name='sw']").val($select.val()=="선택복사" ? "copy" : "move");
                $("#fboardlist").attr("target", "move");
                $("#fboardlist").attr("action", "./move.php");
                $("#fboardlist").submit();
            }
            else if($select.val()=="선택삭제")
            {
                if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                    return false;

                $("#fboardlist").attr("target", "");
                $("#fboardlist").attr("action", "./board_list_update.php");
                $("#fboardlist").submit();
            }
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->

<script type="text/javascript">
$(function(){
    $( "#tabs" ).tabs();
    $(".select_box").select_box({useBorderbox:true});
});
</script>
