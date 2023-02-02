<style type="text/css">

#wrap_content{width: 100%;margin: auto;overflow:hidden;}
#cal_tb {width: 66%;margin: auto;text-align: center;border-radius: 10px;background-color: white;z-index: 1;left: 31%;float: left;}
.calendar_day{border-top: 1px solid #ddd;}
.calendar_day>td{width: 14.28%;position: relative;}
.calendar_day>td:after {content: '';display: block;margin-top: 100%;}
#daily{height: 30px;background: #f3f3f3;}
#daily > td:first-child{color: red;}
#daily > td:last-child{color: blue;}
td .content {position: absolute;top: 0;bottom: 0;left: 0;right: 0;top: 0;background: white;font-weight: bold;font-size: 1.7rem;height: 60%;position: absolute;margin: auto;}
.closed{background: white !important;color: #cacaca;font-size: 1.4rem !important;}
#wrap_search_form{width: 33%;height: 80px;margin: auto;float: right;}
#wrap_search_form>div{height: 17%;border: 1px solid;}    /*height 원래 20%*/
#wrap_search_form>div>.date_data{font-weight: bold;}


/*여기 지워야댐*/




#wrap_search_form>div>.date_info{text-align: center;font-weight: bold;font-size: 1.6rem;}
#wrap_search_form>div>.date_data{text-align: center;color: red;/*padding-top: 10px;*/line-height: 95px;}
#wrap_search_form>div:nth-child(2)>.date_data{color: black;}
.srch_booking{text-align: center;/*padding-top: 15px;*/}
.srch_booking>input{background-color: #000000;line-height: 0;border: none;color: white;padding: 13px;text-align: center;text-decoration: none;display: inline-block;font-size: 1.6rem;margin: 4px 2px;cursor: pointer;font-weight: bold;height: 56px;width: 100%;}                /*원래 width 70퍼*/


   

.change_month{border: 0;background-color:#ffffff;}
.cal_head{font-size: 2.3rem;/*padding: 17px 0 17px 0;*/}
.check_day:hover font {/*background-color: red;font-size: 20px;transition: .1s;*/}


/*btn list 부분*/
.wrap_setting_btn_list{
	float: right;
	margin-top: 30px;
}
.setting_btn_list{
	overflow: hidden;
}
.setting_btn_list > li{
	float: left;
	margin-right: 6px;
}

@media all and (min-width: 768px) {
	#wrap_search_form>div:nth-child(odd)>div{ border-bottom: 1px solid;width: 77px;margin: 23px auto;}
	#wrap_search_form>div:nth-child(5)>div{width: 100%;border-bottom: 0;}
	#wrap_search_form>div:nth-child(odd){border-bottom: 0;margin: 28px 35px 0 35px;border-top: 4px solid;}
	#wrap_search_form>div:nth-child(odd)>div{font-size: 2rem;}
	#wrap_search_form>div:nth-child(even){border-top: 0;margin: 0 35px 0 35px;line-height: 62px;}
	#wrap_search_form>div:nth-child(5){border: 0;margin-top: 0;}
	#wrap_search_form>div>.date_data{font-weight: bold;font-size: 2.6rem;}
	#wrap_search_form>div:nth-child(odd){line-height: 66px;}


	.wrap_setting_btn_list{
		width: 100%;
		/*float: right;*/
	}
	.setting_btn_list{
		float: right;
	}
	/*.setting_btn_list > li{width: 25%;margin-right: 0;}*/
	/*.setting_btn_list > li > *{ width: 90%; }*/
}

@media (min-width: 768px) and (max-width: 991px) {
	#wrap_search_form>div>.date_data{text-align: center;color: red;/*padding-top: 10px;*/}


	

	#wrap_search_form>div>div>span{font-size:2rem;}	

	

}
@media (min-width: 550px) and (max-width: 767px)  {
	#wrap_search_form>div{border-right: 0;border-left: 0;}
	#wrap_search_form>div:nth-child(odd){border-left: 1px solid;}
	#wrap_search_form>div:nth-child(5){border-right: 1px solid;}
	#wrap_search_form>div{height: 100%;width: 20%;float: left;}
	#wrap_content{width: 100%;margin: auto;}
	#cal_tb {width: 100%;}
	#wrap_search_form>div:nth-child(even){line-height: 81px;}
	#wrap_search_form>div>.date_data{text-align: center;font-size: 1.6rem;color: red;/*padding-top: 10px;*/line-height: 81px;}
	table {width: 100%;margin: auto;text-align: center;border-radius: 10px;background-color: white;z-index: 1;}
	#wrap_search_form{width: 100%;height: 80px;margin-bottom: 30px;}
	td .content {position: absolute;top: 0;bottom: 0;left: 0;right: 0;top: 0;/*margin: 1px;*/border-radius: 0;}
	.srch_booking>input{width: 100%;height: 80px;margin: -5px 0 0 0;}
	#wrap_search_form>div:nth-child(odd){line-height: 81px;}

	.wrap_setting_btn_list{
		width: 100%;
	}
	.setting_btn_list > li{width: 25%;margin-right: 0;}
	.setting_btn_list > li > *{ width: 90%; }
}
@media (max-width: 549px)  {
	/*#wrap_search_form>div:nth-child(odd){line-height: 81px;}
	#wrap_search_form>div:nth-child(even){line-height: 81px;}*/

	#wrap_search_form>div{border-right: 0;border-left: 0;}
	#wrap_search_form>div:nth-child(1){border-bottom: 0;}
	#wrap_search_form>div:nth-child(2){border-bottom: 0;}
	/*#wrap_search_form>div:nth-child(even){border-right: 1px solid;border-left: 1px solid;}*/
	/*#wrap_search_form>div:nth-child(odd){border-left: 1px solid;}*/
	/*#wrap_search_form>div:nth-child(5){border-left: 1px solid;height L60px;}*/

	#wrap_search_form>div{height: 100%;float: left;}
	#wrap_content{width: 100%;margin: auto;}
	#wrap_search_form>div>.date_data{text-align: center;font-size: 1.6rem;color: red;/*padding-top: 10px;*/line-height: 24px;margin-top: 10px;}
	#wrap_search_form>div>.date_info{margin-top: 11px;}
	#cal_tb {width: 100%;margin: auto;text-align: center;border-radius: 10px;background-color: white;z-index: 1;}
	#wrap_search_form{width: 100%;height: 80px;}
	td .content {position: absolute;top: 0;bottom: 0;left: 0;right: 0;top: 0;/*margin: 1px;*/border-radius: 0;}
	#wrap_search_form>div:nth-child(3){clear: both;}
	#wrap_search_form>div:nth-child(odd){width: 30%;}
	#wrap_search_form>div:nth-child(even){width: 40%;}
	#wrap_search_form>div:nth-child(5){width: 30%;border: 0;}
	#wrap_search_form>div{width: 40%;}
	#wrap_search_form{width: 100%;height: 45px;margin: auto;margin-bottom: 77px;}
	.srch_booking>input{line-height: 0;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: block;font-size: 1.6rem;cursor: pointer;border-radius: 0px;font-weight: bold;width: 95%;margin-top: -46px;height: 92px;margin-left: 7px;}

	.wrap_setting_btn_list{
		width: 100%;
	}
	.setting_btn_list > li{width: 25%;margin-right: 0;}
	.setting_btn_list > li > *{ width: 90%; }
}

</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<div id="wrap_content">
	<div id="wrap_search_form">
		<div>
			<div class="date_info">체크인</div>
		</div>

		<div>
			<div class="date_data"><span id="start">선택하세요</span></div>
		</div>
		<div>
			<div class="date_info">체크아웃</div>
		</div>
		<div>
			<div class="date_data"><span id="end">선택하세요</span></div>
		</div>
		<div>
			<div class="srch_booking">
				<input type="button" class="search_booking" value="객실검색">
<!-- 				<img src="<?=$board_skin_url?>/img/ajax-loader.gif" style="height: 40px;"> -->
			</div>
		</div>
	</div>

	<table id="cal_tb">
	</table> 	
	
	
</div>
<div>
<style>
	
</style>
<div class="wrap_setting_btn_list">
	<ul class="setting_btn_list">
		<?if ($member['mb_level'] < 8) {?>
    		<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&check=1" id = "checkg" class="b02sub" >예약확인</a></li>
    	<?}else{?>
    		<li><input type="button" id="settingbtn" class="btn btn-default" value="환경설정"></li>
	        <li><input type="button" id="goodsbtn" class="btn btn-default" value="시즌설정"></li>
    		<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $board['bo_1']?>" id = "checkg" class="btn btn-default">예약목록</a></li>
			<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&route=reserve_set" id = "checkg" class="btn btn-default">예약관리</a></li>
    	<?}?>
	</ul>
</div>

<!-- <div class="bo_fx" style=" float:  right; padding-top: 10px;">
	    <ul class="btn_bo_adm" style="margin-top: 42px;">
        	<?if ($member['mb_level'] < 8) {?>
        		<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&check=1" id = "checkg" class="b02sub" >예약확인</a></li>
        	<?}else{?>
        		<li><input type="button" id="settingbtn" class="btn btn-default" value="환경설정"></li>
		        <li><input type="button" id="goodsbtn" class="btn btn-default" value="시즌설정"></li>
        		<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $board['bo_1']?>" id = "checkg" class="btn btn-default">예약목록</a></li>
				<li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=<?php echo $bo_table?>&route=reserve_set" id = "checkg" class="btn btn-default">예약관리</a></li>
        	<?}?>
	        
	        
	    </ul>

	</div> -->
	</div>
<div style="clear: both;"></div>

<?php include_once($board_skin_path."/search_modal.skin.php")?>
<?php include_once($board_skin_path."/modal.skin.php")?>

<script>

$(function(){
	var count        = 0;
	var start        = "";
	var end          = "";
	var temp         = "";
	var start_date   = "";
	var end_date     = "";
	var change       = "current";
	var select_color = ' #e3e3e3';
	var border_set   = "2px solid black"; 
	
	var current_date = "";
	var yy1          = "";
	var mm1          = "";
	var yy_mm        = "";
	var arrr1        = "";
	var arrr2        = "";

	
	change_calendar(yy_mm, change);
	$( "#tabs" ).tabs();

	$(document).on('click', '.check_day', function() {

		var date = new Date();
		var yy =date.getFullYear();
		var mm =date.getMonth()+1;
		// $(this).children('font').css('background-color', select_color);
		

		if (count > 1) {
			
			// $('.check_day').children('font').css('background-color', 'white');
			$('.check_day').children('font').css({
				'background-color': 'white',
				'border': '0',
				'border-radius': '0'
			});
			count = 0;
			start = "";
			end = "";
			start_date = "";
			end_date = "";
			$('#start').text("선택하세요");
			$('#end').text("선택하세요");
			return;
		}
		count++;


		if (count % 2 == 1) {
			$(this).children('font').css({
				'background-color': select_color,
				// 'border-top': border_set,
				// 'border-bottom': border_set,
				// 'border-left': border_set,
				'border-radius': '120px 0 0 120px'
			});
			start = $(this).attr('id');
			start_date = new Date(start);
			tr = $(this).parent().index();
			td = $(this).index();
			arrr1 = [tr,td];
			
			$('#start').text(start);
		}else{

			$(this).children('font').css({
				'background-color': select_color,
				// 'border-top': border_set,
				// 'border-bottom': border_set,
				// 'border-right': border_set,
				'border-radius': '0 120px 120px 0'
			});
			
			end = $(this).attr('id');	
			end_date = new Date(end);
			tr = $(this).parent().index();
			td = $(this).index();
			arrr2 = [tr,td];
			
			if (start_date>end_date) {

				
				//YY-MM-DD 값
				temp = start;
				start = end;
				end = temp;

				$('#'+start).children('font').css({
					'background-color': select_color,
					// 'border-top': border_set,
					// 'border-bottom': border_set,
					// 'border-left': border_set,
					// 'border-right': '0',
					'border-radius': '120px 0 0 120px'
				});
				$('#'+end).children('font').css({
					'background-color': select_color,
					// 'border-top': border_set,
					// 'border-bottom': border_set,
					// 'border-right': border_set,
					// 'border-left': '0',
					'border-radius': '0 120px 120px 0'
				});

				//td 좌표
				temp = arrr1;
				arrr1 = arrr2;
				arrr2 = temp;

				//타임스템프 값
				temp = start_date;
				start_date = end_date;
				end_date = temp;

				$('#start').text(start);
			}
			
			$('#end').text(end);
			select_td(arrr1,arrr2,start_date,end_date,yy_mm);
			
			

			
		}

	});
	function change_calendar(date, value){
		
		yy_mm = date;
		change = value;
		start_ajax = $('#start').text();
		end_ajax = $('#end').text();
		

		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_calendar_control.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"change" : change,
	        	"path" : "<?=$board_skin_path?>",
	            "yy_mm" : yy_mm
	        },
	        dataType: "json",
	        async: false,
	        cache: true,
	        success: function( data, textStatus ) {
				// console.log(data);
	        	$("#cal_tb").append(data.table);
	        	var parent_height = $('.content').height();
				$('.content').children('div').css('line-height', parent_height+'px');
	        	
				yy_mm = data.next_month;
				var present = new Date(yy_mm);
				if (start_date) {
					var restore_start = start_date.setDate(1);	
				}

				sb_string1 = yy_mm.substring(0,7);
				sb_string2 = start.substring(0,7);
				sb_string3 = $('#end').text().substring(0,7);
				
				if (present >= restore_start && present <= end_date && count == 2 ) {
					select_td(arrr1,arrr2,start_date,end_date,yy_mm);
				}
				
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
	}
	
	function select_td(start, end,start_date,end_date,yy_mm){
		var i_start   = 0;
		var i_end     = 0;
		var for_start = 0;
		var for_end   = 0;
		var counting  = 0;
		var route     = "";
		
		if (start_date.getMonth()+1 < end_date.getMonth()+1 || start_date.getFullYear() < end_date.getFullYear()) {

			if ($('#start').text().substring(0,7) == yy_mm) {
				//입실날짜와 같을때
				for_start = 6;
				for_end = start[1];
				i_start = start[0];
				i_end = $('#cal_tb tr').length-1;
				route = "start";

			}else if($('#end').text().substring(0,7) == yy_mm){
				//퇴실날짜와 같을때
				for_start = end[1];
				for_end = 0;
				i_start = 2;
				i_end = end[0];
				route = "end";

			}else{
				for_start = 10;
				for_end = 0;
				i_start = 2;
				i_end = 7;
			}
			
			for (var i = i_start; i <= i_end; i++) {
				
				if (route == "start") {
					//입실날짜와 같을때
					if (counting > 0) {
						for_end = 0;
					}
				}else if(route == "end"){
					//퇴실날짜와 같을때
					if (i != end[0]) {
						for_start = 6;
					}else{
						for_start = end[1];
					}
				}
		
				for (var j = for_start; j >= for_end; j--) {
					//중간날짜
					$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
						'background-color': select_color
						
					});
					//시작날짜 처음 radious 처리
					if (i == i_start && j == for_end && route == 'start') {
						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '120px 0 0 120px'
						});
					//끝날짜 처음 radious 처리	
					}else if (route == 'end' && i == i_end && j == for_start) {

						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '0 120px 120px 0'
						});
					}	
				}
				counting++;
			}


		}else{

			for (var i = start[0]; i <= end[0]; i++) {
				//첫번째
				if (start[0] == end[0]) {
					for_start = end[1];
					for_end = start[1];
				//마지막이거나 중간
				}else{
				
					if (i == start[0]) {
						for_start = 6;
						for_end = start[1];
						
					}else{
						//마지막 row

						if (i == end[0]) {
							for_start = end[1];
							for_end = 0;
							
						}else{
							for_start = 6;
							for_end = 0;
							
								
						}
					}
				}


				

				for (var j = for_start; j >= for_end; j--) {
					
					$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
						'background-color': select_color
						// 'border-top': border_set,
						// 'border-bottom': border_set
					});

					//시작날짜 처음 radious 처리
					if (i == start[0] && j==for_end) {
						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '120px 0 0 120px'
						});
					//끝날짜 마지막 radious 처리	
					}else if (i == end[0] && j == for_start) {

						$("tr:eq("+i+")").find("td:eq("+j+")").children('font').css({
							
							'border-radius': '0 120px 120px 0'
						});
					}
				}
			}
		}	
	}

	//객실검색

	$('.search_booking').click(function() {
		
		choose_start = $('#start').text();
		choose_end = $('#end').text();
		
		if (choose_start=="선택하세요") {
			alert("입실날짜를 선택해주세요");
			return false;
		}else if (choose_end=="선택하세요") {
			alert("퇴실날짜를 선택해주세요");
			return false;
		}else if (choose_start == choose_end) {
			alert("입실날짜와 퇴실날짜가 같으면 안됩니다.");
			$('.check_day').children('font').css({'background-color': 'white','border-radius': '0'});
			
			count = 0;
			start = "";
			end = "";
			start_date = "";
			end_date = "";
			$('#start').text("선택하세요");
			$('#end').text("선택하세요");
			return false;
		}
		
		
		$.ajax( {
	        url: "<?=$board_skin_url?>/ajax/ajax_search.php?ver=20201008",
	        type: "POST",
	        data: {
	        	"start" : choose_start,
	        	"end" : choose_end,
	            "bo_table" : "<?=$bo_table?>",
	            "bo_1" : "<?=$board['bo_1']?>",
	            "bo_5_subj" : "<?=$board['bo_5_subj']?>",
	            "bo_7_subj" : "<?=$board['bo_7_subj']?>",
	            "bo_8_subj" : "<?=$board['bo_8_subj']?>"


	        },
	        dataType: "json",
	        //async: false,
	        cache: true,
			beforeSend: function( xhr ) {
				
				$('.search_booking').css({
	            	'background-image': 'url(<?=$board_skin_url?>/img/ajax-loader.gif)',
				    'background-size': '36px',
				    'background-repeat': 'no-repeat',
				    'background-position': 'center',
					'transition':'none'
	            });
				$('.search_booking').val("");
			},
	        success: function( data, textStatus ) {
	        	// console.log(data);
	        	$('#wr_add1').val('0');
	        	$('#wr_add2').val('0');
	        	$('#wr_add3').val('0');
	        	
	        	for (var i = 0; i < data.list.length; i++) {
	        		$('#'+data.list[i].wr_id).show();
	        		$('#'+data.list[i].wr_id+' .book_prc').text(data.list[i].price);
	        		$('#'+data.list[i].wr_id+' .sale_prc').text('-'+data.list[i].sale);
	        		$('#'+data.list[i].wr_id+' .total_prc').text(data.list[i].total);
	        		$('#'+data.list[i].wr_id+' .add_prc').text('+0원');
	        		
	        	}

	        	//버튼 초기화
	        	$('input[name=is_reserved]').attr({
	        		'value': '예약',
	        		'style': ''
	        	});
	        	$('input[name=is_reserved]').removeAttr('disabled');
	        	
	        	for (var i = 0; i < data.reserved.length; i++) {
	        		// $('#'+data.reserved[i]).hide();
	        		// $('#'+data.reserved[i]).children('input[name=is_reserved]').attr('value', '불가');
	        		$('#'+data.reserved[i]).children('.li_list_obj').children('div').children('div').children('input').attr({
	        			'value': '불가',
	        			'disabled': 'true',
	        			'style': 'background:#6d6d6d;'
	        		});
	        		// $('#'+data.reserved[i]).attr('name', 'blocked');
	        	}
	        	
				$('#st_date').text($('#start').text());
				$('#en_date').text($('#end').text());
				var count_2 = data.count + 1;
				$('.count_day').text(data.count+'박 '+count_2+'일');
				
				//로딩감추기
				$('.search_booking').attr('style','');
				$('.search_booking').val("객실검색");


				$('#view_list').modal({backdrop:'static'});
				
	        },
	        error: function( xhr, textStatus, errorThrown ) {
	            console.error( textStatus );
	            
	        }
	    });
	});




	//달력 날짜 바꾸기
	$(document).on('click', '.change_month', function() {
		if ($(this).val() == "<") {
			var change = 'prev';
		}else if ($(this).val() == ">") {
			var change = 'next';
		}

		
		if (current_date == "") {
			current_date = new Date();
			yy1 = current_date.getFullYear();
			mm1 = current_date.getMonth()+1;
			yy_mm = yy1+"-"+mm1;
		}


		$('.calendar_day').remove();
		$('#daily').remove();
		$('#table_header').remove();
	    change_calendar(yy_mm,change);
	});

	
	
});

$( window ).resize( function () {
	var parent_height = $('.content').height();
	if (window.innerWidth > 767) {
		$('#wrap_search_form').height($('#cal_tb').height());	
	}else{
		$('#wrap_search_form').attr('style', '');
	}
	$('.content').children('div').css('line-height', parent_height+'px');
} );

$( window ).load( function () {
	var parent_height = $('.content').height();

	if (window.innerWidth > 767) {
		$('#wrap_search_form').height($('#cal_tb').height());	
	}
	
	$('.content').children('div').css('line-height', parent_height+'px');
	
	
} );	


// $(window).resize(function() {
// 	var windowWidth = $( window ).width();
// 	if(windowWidth < 550) {
// 		$('.search_booking').val('검색');
		
// 	} else {
// 		$('.search_booking').val('객실검색');
// 	}
// });

	

</script>
