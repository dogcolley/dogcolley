<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>
<style>
#view_list{overflow: auto;}
/*modal css */
/*셀렉스박스*/
.b02sub{background:black;border:0;}
.btn_bo_adm input{background:black;}
.select_box_div{width: 50%;height: 100%;float: left;}
.select_box_div>div{border: 1px solid #ddd;float: left;height: 100%;width: 48%;overflow: hidden;margin: 1%;padding: 8px;border-radius: 10px;position: relative;}
.select_box_div>div>label{display: block;color: #ababab;font-size: 12px;margin: 4px 4px 0 4px;}
.select_box_div>div>select{all:unset;width: 100%;font-weight: bold;outline:none;height: 100% !important;text-align:center;text-align-last: center;letter-spacing: 10px;font-size: 17px;background: none;float:left;}
.select_sign{float: right;position: absolute;font-size: 22px;right: 14px;}
.select_box_div>div>select::-ms-expand{ display:none;}
/*.select_box_div>div>select>option{text-align: left;padding: }*/
.select_box{border: 0;}
/*하단 리스트*/
.list_container{width: 100%;height: 100%;clear: both;}
.li_list_subject{font-size: 16px;font-weight: bold;padding: 5px 0 5px 6px;}
.li_list_obj{width: 100%;height: 160px;}
.li_list_obj>div{width: 29%;height: 100%;float: left;/*border: 1px solid;*/}
.li_list_obj>div:nth-child(4){width: 9%;height: 100%;float: left;}
.li_list_obj>div:nth-child(4)>div>input{background: #1f3d73;width: 100%;height: 160px;color: white;margin-left: 12px;font-size: 17px;}
.img_content{max-width: 100%;height: 100%;padding: 2px;}
.img_contn{display: none;}

/*객실안내*/
.li_list_obj>div:nth-child(1){width: 30%;}
.li_list_obj>div:nth-child(2){display: table;height: 100%;padding: 0 11px 0 11px;width: 31%;}
.li_list_obj>div:nth-child(2) *{background: #f7f7f7 !important;background-color: #f7f7f7 !important;}
.li_list_obj>div:nth-child(2)>div:nth-child(1){font-size: 14px !important;}

.li_list_obj>div:nth-child(2)>div:nth-child(1){height: 160px;width: 100%;float: left;overflow:hidden;padding: 11px;word-break: break-word;}
.li_list_obj>div:nth-child(2)>{padding: 9px;display: table-cell;vertical-align: middle;font-size: 13px;height: 136px;float: left;text-overflow: ellipsis;overflow-y: hidden;word-break: break-all;width: 100%;}
.li_list_obj>div:nth-child(2)>div:nth-child(1)>label{background-color: #6dadca;padding-left: 7px;padding-right: 7px;color: white;border-radius: 4px;}
/*요금별*/
.li_list_obj>div:nth-child(3){	font-size: 16px;padding: 11px;border: 1px solid #ddd;padding-bottom: 0;}
.li_list_obj>div:nth-child(3)>div>div{width: 50%;float: left;}
.li_list_obj>div:nth-child(3)>div>div:nth-child(even){text-align: right;font-weight: bold;}
/*.li_list_obj>div:nth-child(3)>div:last-child{border-top: 1px solid #ddd;padding-top: 10px;}*/


.price_cul>div{height: 20%;}
.price_cul>div:nth-child(4){height: 40%;}

#content_subject{font-size: 20px;font-weight: bold;}

.image_info{display: block;text-align: center;height: 160px;line-height: 160px;font-size: 40px;}
.image_info:hover{background: black;opacity: 0.5;color: white;-webkit-transition: background-color 0.5s, -webkit-transform 2s;
    transition: background-color 0.5s, transform 2s;}
/*이미지 슬라이더 사용자 설정*/

.ps-current>ul>li>img{
	width: 100%;
}


@media  (max-width: 991px) {
	.select_box_div{width: 100%;height: 100%;}
	.select_box_div>div{border: 1px solid #ddd;float: left;height: 100%;width: 48%;overflow: hidden;margin: 1%;}
	.li_list_obj{width: 100%;height: 100%;}
	.li_list_obj>div:nth-child(1){width: 100%;height: 100%;float: none;}
	.li_list_obj>div:nth-child(2){width: 100%;height: 100%;float: none;padding: 0;margin-top: 10px}
	.li_list_obj>div:nth-child(3){width: 100%;height: 100%;float: none;margin-top: 10px}
	.li_list_obj>div:nth-child(4){width: 100%;height: 100px;float: none;margin-top: 10px}
	.li_list_obj>div:nth-child(4)>div>input{margin-top: 30px;}
	.li_list_obj>div:nth-child(3)>div>div{padding: 6px;}
	.li_list_obj>div:nth-child(4)>div>input{height: 50px;margin: 0;}

	.img_contn>img{width: 100%;}
	.img_contn{display: block;}
	
}
.read_more{position: absolute;bottom: 4px;right: 12px;background: antiquewhite;padding: 3px;font-weight: bold;cursor: pointer;}
.booking_content{
	position: relative;
}

 
</style>




<script src="<?php echo $board_skin_url; ?>/lib/pgwslideshow.min.js"></script>
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow_light.min.css">
<link rel="stylesheet" href="<?php echo $board_skin_url?>/lib/pgwslideshow.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">	
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>


  <style>
  	.check_date_wrap>div{width: 49.5%;}
  	.check_date_wrap>div>div{width: 100%;border: 1px solid black;border-top: 3px solid;}
  	.check_date_wrap>div>div>span{display: block;text-align: center;}
  	.check_date_wrap>div>div>span:nth-child(1){padding: 10px 0 2px 0;font-size: 20px;font-weight: bold;}
  	.check_date_wrap>div>div>span:nth-child(2){font-size: 24px;font-weight: bold;padding-bottom: 13px;}
  	.select_container{margin-top: 1px;}
  </style>
  	

<div class="modal fade" id="view_list" role="dialog">
    <div class="modal-dialog modal-lg" style="z-index:1050;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body tbl_wrap" style="/*overflow: auto;*/">
            	<div class="check_date_wrap" style="overflow: hidden;margin: 6px;">
	            	<div style="float: left;">
						<div>
		            		<span>체크인</span>
		            		<span id="st_date"></span>
		        		</div>
	        		</div>
	        		<div style="float: right;">
		        		<div>
		        			<span>체크아웃</span>
		        			<span id="en_date" style="color: red;"></span>	
		        		</div>	
	        		</div>
				</div>
            	<div class="select_container" style="">
            		<?php
            		//select box 갯수 찾는 로직
            		$max_count_temp = array();

            		for ($i=0; $i < count($total_list); $i++) { 
            			//메타테이블에 있는 자료들을 $total_list에 합침
                		$sql = "SELECT * FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$i]['wr_id']}' AND mta_db_table = 'board/{$bo_table}'";
			            $result = sql_query($sql);
			            while ($row = sql_fetch_array($result)) {
			                $total_list[$i]["{$row['mta_key']}"] = $row['mta_value'];
			                
			            }
			            $max_count_temp[] = $total_list[$i]['wr_max'];

            		}
            		arsort($max_count_temp);
            		
            		foreach ($max_count_temp as $key => $value) {
            			$max_count = $value;
            			break;
            		}
            		?>
	                <div class="select_box_div">
	                	<div>
	                		<select id="sort_search" class="select_box">
	                			<option value="" selected style="display: none;">정렬</option>
		                		<option value="wr_subject">객실명순</option>
		                		<option value="price">가격순</option>
		                		<option value="wr_max">인원순</option>
		                		<option value="wr_area">넓이순</option>

		                	</select>
							<i class="fas fa-caret-down select_sign" ></i>
		                </div>
	                	<div>
	                		
	                		<select name="wr_add1" id="wr_add1" class="select_box chang_price">
		                		<option value="0" selected style="display: none;">성인<i class="fas fa-caret-down"></i></option>
		                		<?for ($i=1; $i <= $max_count; $i++) { ?>
		                			<option value="<?=$i?>"><?=$i?>명</option>	
		                		<? }?>
		                	</select>
							<i class="fas fa-caret-down select_sign" ></i>
		                </div>
	                </div>
	                <?php if ($board['bo_2_subj']) {?>
	                <div class="select_box_div kids_setting">
	                	<div>
	                		
	                		<select name="wr_add2" id="wr_add2" class="select_box chang_price">
		                		<option value="0" selected style="display: none;">소아</option>
		                		<?for ($i=0; $i <= $max_count; $i++) { ?>
		                			<option value="<?=$i?>"><?=$i?>명</option>	
		                		<? }?>
		                	</select>
							<i class="fas fa-caret-down select_sign" ></i>
		                </div>
	                	<div>
	                		<select name="wr_add3" id="wr_add3" class="select_box chang_price">
	                			<option value="0" selected style="display: none;">유아</option>
		                		<?for ($i=0; $i <= $max_count; $i++) { ?>
		                			<option value="<?=$i?>"><?=$i?>명</option>	
		                		<? }?>
		                	</select>
							<i class="fas fa-caret-down select_sign" ></i>
		                </div>
	                </div>
	            	<?php }?>
                </div>
				<?
				$thumb = get_list_thumbnail($board['bo_table'], $list[0]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
				?>
				<img src="<?=$thumb['src']?>" id="abc" style="width:100%;height:auto;display:none;">
				<!-- <img src="<?=$thumb['src']?>"> -->
                <ul class="list_container" style="position: relative;">
                	<?for ($i=0; $i<count($total_list); $i++) {
                		
			            //썸네일 추출
                		$thumb = get_list_thumbnail($board['bo_table'], $total_list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);
			            if($thumb['src']) {
			                $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" class="img_content" id="img_content">';
			            }

			            //옵션명 및 가격 추출
			            $sql = "SELECT COUNT(*) FROM {$g5['meta_table']} WHERE mta_db_id = '{$total_list[$i]['wr_id']}' AND mta_key LIKE '%wr_option_name%' AND mta_db_table = 'board/{$bo_table}'";
			            $result = sql_fetch($sql);
			            $option_tooltip = "";

			            // 테이블 모드
			            // $option_tooltip .="<table class='table'>";
			            // for ($j=0; $j < $result['COUNT(*)']; $j++) { 
			            // 	$option_tooltip .="<tr>";

			            // 	$option_tooltip .= "<td>".$total_list[$i]['wr_option_name'.$j]."</td><td>".number_format($total_list[$i]['wr_option_price'.$j])."원</td>";
			            	
			            // 	$option_tooltip .="</tr>";
			            // }
			            // $option_tooltip .= "</table>";

			            for ($j=0; $j < $result['COUNT(*)']; $j++) { 
			            	$option_tooltip .= $total_list[$i]['wr_option_name'.$j].":".number_format($total_list[$i]['wr_option_price'.$j])."원<br>";
			            	
			            }





	    				$text = "";
	    				$text .= "성인추가요금 : ".number_format($total_list[$i]['wr_11'])."원<br>";
	    				if ($board['bo_2_subj']) {
	    					$text .= "소인추가요금 : ".number_format($total_list[$i]['wr_12'])."원<br>";
							$text .= "유아추가요금 : ".number_format($total_list[$i]['wr_13'])."원";
	    				}
	    				?>

            		<li style="padding: 7px;" id="<?=$total_list[$i]['wr_id']?>" class="list_li">
						<div class="li_list_subject">
							<i class="far fa-calendar-alt"></i> 
							<span class="subject_name" style="font-size: 20px;letter-spacing: -0.05em;margin-right: 6px;    word-break: break-all;"><?=$total_list[$i]['wr_subject']?></span> 
							<span style="padding: 0 5px;border: 1px solid black; font-weight: bold;"><span class="min"><?=$total_list[$i]['wr_min']?></span>명/<span class="max"><?=$total_list[$i]['wr_max']?></span>명</span>
							<span style="padding: 0 5px;border: 1px solid black;padding: 0 4px; font-weight: bold;"><?=$total_list[$i]['wr_area']?>평</span>
	        				<?php if ($option_tooltip): ?>
	        					<label data-toggle="tooltip" title="<?=$option_tooltip?>" data-placement="bottom" data-html="true" style="background-color: #1f3d73;padding: 0 7px;color: white;font-weight: 100;border-radius: 3px;">옵션보기</label>	
	        				<?php else: ?>
	        					<label style="background-color: #a9a9a9;padding: 0 5px;color: white;">옵션없음</label>
	        				<?php endif ?>
						</div>
	                	<div class="li_list_obj">
	                		
	                		<div style="border: 1px solid #ddd;border-radius: 3px;background-image: url('<?=$thumb['src']?>');background-position: center;background-size: cover;cursor: pointer;" class="img_container">
	                			<!-- <div class="img_contn"><?=$img_content?></div> -->
	                			
		                		<span class="image_info"><i class="fas fa-search-plus"></i></span>
	                		</div>
	                		
	                		<div>
	                			
												
	                			<div class="booking_content" style="height: 128px;float: none;">
	                				<!-- <span class="read_more">더보기</span> -->
	                				<?$remove_img = str_replace("<img", "[사진첨부]<img style='display:none;' ", $total_list[$i]['wr_content']);
	                				$remove_img = strip_tags($remove_img,'<br>');
	                				?>
	                				<!-- <?=$remove_img?> -->
	                				<div><?=$remove_img?></div>

	            				</div>
	            				<div style="font-size: 23px;height: 31px;text-align: right;padding-right: 5px;"><i class="fas fa-plus-square" name="view_content_btn" style="cursor: pointer;"></i></div>
	                			
	                		</div>
	                		
	                		<div class="price_cul">
	                			<div style="overflow: hidden;">
		                			<div class="price_subj_clas count_day"></div><div class="book_prc"></div>
	                			</div>
	                			<div style="overflow: hidden;">
	                				
	                				<div class="price_subj_clas">추가인원 <i class="fas fa-question-circle" data-toggle="tooltip" title="<?=$text?>" data-html="true"></i></div><div class="add_prc">+0원</div>
	                			</div>
	                			<div style="overflow: hidden;margin-bottom: 9px;">
	                				<div class="price_subj_clas">연박할인</div><div style="color: red;"  class="sale_prc"></div>	
	                			</div>
	                			<div style="overflow: hidden;overflow: hidden;border-top: 1px solid #ddd;padding-top: 9px;font-weight: bold;font-size: 19px;">
	                				<div class="price_subj_clas">총요금</div><div class="total_prc"></div>	
	                			</div>
	                			
	                		</div>
	                		
	                		<div>
								<div style="text-align: center;"><input type="button" value="예약" name="is_reserved" class="btn btn-default submit_reserve"></div>
	                		</div>
	                	</div>
                	</li>
                	<?}?>
                	
                </ul>
				<img src="<?=$thumb['src']?>" id="abc" style="width:100%;height:auto;display:none;">
            </div>
			
            <!-- <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="view_img" role="dialog">
    <div class="modal-dialog modal-lg"  style="z-index:1060;">
    	<div style="width: 100%;height: 45px;position: absolute;z-index: 1;"><button type="button" class="close" data-dismiss="modal" style="width: 40px;height: 40px;"><i class="fas fa-times" style="color: black;font-size: 30px"></i></button></div>
    	
    	<div class="modal-body tbl_head01 tbl_wrap" style="overflow: auto;padding: 0;" id="image_info"></div>
        
    </div>
</div>

<div class="modal fade" id="view_content" role="dialog">
    <div class="modal-dialog"  style="z-index:1060;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            	<span id="content_subject"></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body tbl_wrap" style="/*overflow: auto;*/" id="content_box">



			</div>
            <!-- <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"> 닫기</button>
            </div> -->
        </div>
    </div>
</div>
        


<script>
	
	$('[name=view_content_btn]').click(function(event) {
		var booking_id = $(this).closest('li').attr('id');
		var booking_name = $('#'+booking_id).children('.li_list_subject').children('span.subject_name').text();
		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_view_content.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"id" : booking_id,
	        	"bo_table" : "<?=$bo_table?>"
	        },
	        dataType: "json",
	        async: false,
	        cache: false,
	        success: function( data, textStatus ) {

	        	$('#content_subject').empty();
	        	$('#content_subject').append(booking_name+" 객실 소개");
	        	$("#content_box").empty();
	        	$('#content_box').append(data);
	        	$('#view_content').modal();
	        	
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
		
	});

	$('.select_box_div div').hover(function() {
		$(this).css({
			'background': '#efefef',
			// 'color': 'white'
		});
	}, function() {
		$(this).css({
			'background': 'white',
			'color': 'black'
		});
		
	});
	$(document).on('change', '#sort_search', function(event) {
		if ($(this).val()=="price") {
			var temp = {};
		
			$('.total_prc').each(function(index, el) {
				var res = "";
				var price = $(this).text();
				
				res = price.replace(",", "");
				temp[$(this).closest('li').attr('id')] = res.replace("원", ""); 
				// temp[count]['price'] = res.replace("원", "");
				// temp[count]['id'] = $(this).closest('li').attr('id')
				
			});

			// temp.sort(dynamicSort(name));
			// console.log(temp);
			// var sortingField = "age";

			// student.sort(function(a, b) { // 오름차순
			//     return a[sortingField] - b[sortingField];
			//     // 13, 21, 25, 44
			// });
		}
		var id = [];
		$('.list_li').each(function(index, el) {
			id.push($(this).attr('id'));
		});
		
		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_sort_search.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"id" : id,
	        	"sort" : $(this).val(),
	        	"bo_table" : "<?=$bo_table?>",
	        	"temp" : temp
	        },
	        dataType: "json",
	        async: false,
	        cache: false,
	        success: function( data, textStatus ) {

	        	// $('.list_li').eq(0).before($('#'+));
	        	//정렬 로직
	        	for (var i = 0; i < data.length-1; i++) {
	        		if (i==0) {
	        			$('.list_li').eq(i).before($('#'+data[i]));		
	        		}
	        		$('.list_li').eq(i).after($('#'+data[i+1]));
	        	}
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
	});   
	
	$('.img_container').click(function() {
		var id = $(this).closest('li').attr('id');
		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_view_image.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"wr_id" : id,
	        	"bo_table" : "<?=$bo_table?>"
	        },
	        dataType: "json",
	        async: false,
	        cache: false,
	        success: function( data, textStatus ) {
	        	$('#slideshow').remove();
	        	// $('.pgwSlideshow').children('li').remove();
	        	$('#image_info').append(data);
				
	        	
	        	
	        	$('.pgwSlideshow').pgwSlideshow({
		            transitionEffect : "<?php echo $transitionEffect?>",
		            autoSlide : "<?php echo $autoSlide?>",
		         
		        });
		        $('.ps-current').css('height', '100%');
	        	$('.ps-list').css('background', 'black');
	        	$('.narrow').css('background', 'black');
	        	$('.ps-prev').css('background', 'rgba(0, 0, 0, 0)');
	        	$('.ps-next').css('background', 'rgba(0, 0, 0, 0)');
	        	// $('.bxslider').bxSlider(); 	
	        	$('#view_img').modal();
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
			
	});

	$('.submit_reserve').click(function() {

		var id = $(this).closest('li').attr('id');
		var bo_table = "<?=$board['bo_1']?>";
		var start = $('#st_date').text();
		var end = $('#en_date').text();
		var wr_add1 = $('#wr_add1').val();
		if (wr_add1=='0') {
			alert("성인 인원수를 정해주세요");
			return false;
		}
		var wr_add2 = "";
		var wr_add3 = "";	
		if ($('#wr_add2')) {
			var wr_add2 = "&wr_add2="+$('#wr_add2').val();
			var wr_add3 = "&wr_add3="+$('#wr_add3').val();	
		}
		
		location.href = "./write.php?bo_table="+bo_table+"&id="+id+"&reservation_date="+start+"&end_date="+end+"&wr_add1="+wr_add1+wr_add2+wr_add3;
	});
	
	$('[data-toggle="tooltip"]').tooltip();

	
	
	

	$(document).on('change', '.chang_price', function() {
		
		var wr_add1 = Number($('#wr_add1').val());
		var wr_add2 = 0;
		var wr_add3 = 0;
		if ($('#wr_add2').length!=0) {
			
			wr_add2 = Number($('#wr_add2').val());
			wr_add3 = Number($('#wr_add3').val());	

		}
		// alert($('#wr_add2').length);
		
		
		var count_arr = [wr_add1, wr_add2, wr_add3];
		var id_arr = [];
		var total = (wr_add1+wr_add2+wr_add3);

		$('.max').each(function (index, item) {
		 	$(this).closest('.list_li').show();
		 	if (total > $(this).text()) {
		 		$(this).closest('.list_li').hide();
		 		
		 	}else{
		 		id_arr.push($(this).closest('.list_li').attr('id'));
		 	}
		 
		});

		
		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_search.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"type" : "count",
	        	"id" : id_arr,
	        	"count" : count_arr,
	            "bo_table" : "<?=$bo_table?>",
	            "bo_1" : "<?=$board['bo_1']?>",
	            "start" : $('#st_date').text(),
	            "end" : $('#en_date').text()

	        },
	        dataType: "json",
	        async: false,
	        cache: false,
	        success: function( data, textStatus ) {
	        	var total = "";
	        	var result = "";
				for (var i = 0; i < data.length; i++) {
					$('#'+data[i].wr_id+' .add_prc').text('+'+data[i].price+'원');
					$('#'+data[i].wr_id+' .total_prc').text(data[i].total+'원');
					// total = $('#'+data[i].wr_id+' .total_prc').text();
					// total_result = total.replace( /,|원/gi, '');
					// add_result = data[i].price.replace( /,/gi, '');
					// result = Number(total_result) + Number(add_result);
					// $('#'+data[i].wr_id+' .total_prc').text(result+'원');
				}
				 
				
				
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
	});
	
	$( window ).resize( function () {
		var height = 0;
		var windowWidth = window.innerWidth;
		var windowWidth1 = $( window ).width();
 		if(windowWidth < 992) {
			height = $("#abc").height();
		
			$(".img_container").height(height);
			$(".image_info").css({
				'height': height,
				'line-height': height+'px'
			});
		}else{
			$(".img_container").height('inherit');
			$(".image_info").attr('style', '');
		}
		
		
	});
$('#view_list').on('shown.bs.modal', function () {
//$( window ).load( function () {
	var height = 0;
		var windowWidth = window.innerWidth;

 		if(windowWidth < 992) {
			height = $("#abc").height();
		
			$(".img_container").height(height);
			$(".image_info").css({
				'height': height,
				'line-height': height+'px'
			});
		}else{
			$(".img_container").height('inherit');
			$(".image_info").attr('style', '');
		}
});
</script>