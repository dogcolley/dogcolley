/* 
	use extend type 
	: sumsing of 2 over object, 
	fn.extend 
	: make plugin
    
    var : 2019-09-20
    maker : jsh
*/

$.fn.extend({
	onepage: function(options){
		var defaults = {
			mode: 'mode1',
			nav:true,
			btn:true,
			speed: 400,
			foot:false,
		}

		opts = $.extend(defaults,options)

		var set = $(this),
		set_lg = set.find('.paper').length,
		set_ct = 1,
		set_pg_tag = new Array,
		set_action = 'next',
		set_keyset = undefined,
		set_toggle = true,
		set_touch_start,
		set_touch_end,
		set_touch_sum,
		set_foot_mode = false;

		for(var i = 0; i < set_lg; i++){
			set_pg_tag[i] = set.find('.paper').eq(i);
		}

		if(opts.nav){
			var make_tag = '<div class="onpage_btn side_btn">';
			make_tag += '<button type="button" class="onpage_pv">이전</button>';
			make_tag += '<button type="button" class="onpage_nt">다음</button>';
			make_tag += '</div>';
			set.after(make_tag);
			$('.onpage_btn button').on('click',function(){
				if($(this).hasClass("onpage_nt")) set_action = 'next';
				if($(this).hasClass("onpage_pv")) set_action = 'prev';
				if(opts.mode=='mode1')Move_page(set_action,opts.speed,set_lg);
			});
		}

		if(opts.nav){
			var make_tag = '<ul class="onpage_nav side_nav">';
			for(var i = 0; i < set_lg; i++){
				make_tag += '<li><a href="#">'+set_pg_tag[i].find('.paper_tit').text()+'</a></li>'
			}
			make_tag += '</ul>';
			set.after(make_tag);
			$('.onpage_nav a').on('click',function(){
				var btn_nums = $(this).parent().index()+1;
				if(btn_nums == set_ct) return false;
				Move_page2(set_action,opts.speed,set_lg,btn_nums-1);
				set_ct = btn_nums;
				return false;
			});
		}

		set.addClass(opts.mode);

		$(window).on('mousewheel DOMMouseScroll keydown', function (e) {
			var Event = e.type; // event type
			var E = e.originalEvent.wheelDelta || e.originalEvent.detail * -1; // scroll number
			var E2 = e.keyCode; // key dow code
			if(E2 !== undefined) set_keyset = E2;
			if(opts.mode =='mode1' && (E <0 || E2 == 40 )) set_action = 'next';
			if(opts.mode =='mode1' && (E >0 || E2 == 38 )) set_action = 'prev';
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == true)set_foot_mode=true}
			if(opts.mode=='mode1' && !set_foot_mode)Move_page(set_action,opts.speed,set_lg);
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == false)set_foot_mode=false}
		});

		$(window).on('touchstart', function (e) {
			var event = e.originalEvent;
			set_touch_start = event.changedTouches[0].pageY;
		});

		$(window).on('touchend', function (e) {
			var event = e.originalEvent;
			set_touch_end = event.changedTouches[0].pageY;
			set_touch_sum = set_touch_start - set_touch_end;
			if(opts.mode =='mode1' && ( set_touch_sum > 100 )){}set_action = 'next';
			if(opts.mode =='mode1' && ( set_touch_sum < -100 )) set_action = 'prev';
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == true)set_foot_mode=true}
			if(opts.mode=='mode1' && !set_foot_mode && ( set_touch_sum > 100 || set_touch_sum < -100 ))Move_page(set_action,opts.speed,set_lg);
			if(opts.foot){if(Move_foot(set_action,opts.speed,set_lg) == false)set_foot_mode=false}
		});

		if(opts.mode=='mode1'){
		}

		if(opts.mode=='mode2'){
		}

		function Move_page(m_action,m_speed,m_limit){
			if(set_toggle){
				set_toggle = false;
				if(m_action == 'next' && set_ct < m_limit)set.animate({top: -(set_ct*100)+'%'},m_speed,function(){set_ct++;set_toggle=true});
				else if(m_action == 'prev' && set_ct > 1){set_ct--;set.animate({top: -((set_ct-1)*100)+'%'},m_speed,function(){set_toggle=true})}
				else set_toggle = true;
			}
		}

		function Move_page2(m_action,m_speed,m_limit,move_set){
			if(set_toggle){
				set.animate({top: -(move_set*100)+'%'},m_speed,function(){set_toggle=true});
			}
		}

		function Move_foot(m_action,m_speed,m_limit){
			var $footer = $('.one_foot');
			var f_h = ($footer.height() / $(window).height()) * 100;
			f_h =  -((m_limit-1)*100 + f_h)+'%';
			if(set_toggle && m_limit == set_ct && !set_foot_mode && set_action == 'next'){
				set.animate({top:f_h},m_speed,function(){set_toggle=true});
				return true;
			}else if(set_toggle && m_limit == set_ct && set_foot_mode && set_action == 'prev'){
				set.animate({top:-((m_limit-1)*100)+'%'},m_speed,function(){set_toggle=true});
				return false;
			}
		}
	}
});

$.fn.extend({
	/* slider : 호완, 모드, 상태 올클 */
	j_slider : function(options){
		var defaults = {
			mode: 'slider', //mode = slider, fade, m3d,  
			nav:true,
			btn:true,
			speed: 400,
			loop:true,
			auto:false,
			autoT:3000, 
			autoS:1000,
			view:1,
			css:true,
			Indc:true
		}
		opts = $.extend(defaults,options)

		var set = $(this),
		set_container = $(this).find('.j_container'),
		set_lg = set.find('.j_content').length,
		set_ct = 1,
		set_pg_tag = new Array,
		set_move = 'next',
		set_keyset = undefined,
		set_toggle = true,
		set_touch_start,
		set_touch_end,
		set_touch_sum,
		set_stock = 0,
		set_stock2 = 0,
		set_action = true,
		set_ct_stack=0,
		set_loop_mode = false,
		set_show_wd = (set_lg+(opts.view*2)) / opts.view,
		set_show_wd2 = 100  / (set_lg+(opts.view*2)),
		set_show_wd3 = 100  / (set_lg),
		nums_ctMax = Math.ceil(set_lg / opts.view),
		nums_ct = 1;
		
		/*root check*/
		if( set_lg <= opts.view ) opts.loop = false;
		if( set_lg <= opts.view ) set_action = false;
		
	
		/*setting css*/
		if(set_action){
			set.css({position:'relative',overflow:'hidden'})
			set_container.css({left:'-100%',position:'relative',width:set_show_wd*100+'%'})
			set_container.find('.j_content').css({float:'left',width: set_show_wd2+'%'})
		}else{
			set_container.find('.j_content').css({float:'left',width: set_show_wd3+'%'})
		}

		/* odd style */
		if(set_lg % opts.view !==0){
			var make_num = opts.view - (set_lg % opts.view);
			for(var i = 0; i < make_num; i++){
				var make_tag = set_container.find('.j_content').last().clone();
				set_container.append(make_tag);
				set_container.find('.j_content').last().css('min-height','1px')
				set_container.find('.j_content').last().children().remove();
			}
		}		

		/*setting pv, df*/
		if(set_action){
			for(var i = 0; i < opts.view; i++){
				var ft_tg = set_container.find('.j_content').eq(-(i+1)).clone();
				set_container.prepend(ft_tg);
			}
		}

		/* setting btn */
		if(set_action){
			var make_btn = '<ul class="j_btns">';
			if(opts.btn)make_btn += '<li><button type="button" class="j_pv">이전</button></li>';
			if(opts.btn)make_btn += '<li><button type="button" class="j_nt">다음</button></li>';
			if(opts.auto)make_btn += '<li><button type="button" class="j_auto on"><span>자동재생</span></button></li>';
			if(opts.auto)make_btn += '<li><button type="button" class="j_stop"><span>자동재생정지</span></button></li>';
			make_btn += '</ul>';
			set.append(make_btn);
		}

		set.find('.j_pv').on('click',function(){
			j_pvcc(opts.speed);
			if(opts.auto){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				set.find('.j_stop').addClass('on');
			}
		});

		set.find('.j_nt').on('click',function(){
			j_nt_cc(opts.speed);
			if(opts.auto){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				set.find('.j_stop').addClass('on');
			}
		});
			
		/*setting indc*/
		if(opts.Indc && set_action){
			var make_Indc = '<ul class="j_indcs">';
			for(var i=0; i < set_lg; i ++){
				if(i == 0 )make_Indc += '<li class="on"><button type="button" class="indc_btn">'+(i+1)+'</button></li>';
				else make_Indc += '<li><button type="button" class="indc_btn">'+(i+1)+'</button></li>';
			}
			make_btn += '</ul>';
			set.append(make_Indc);
		}

		/*event */
		$(set).on('touchstart', function (e) {
			var event = e.originalEvent;
			set_touch_start = event.changedTouches[0].pageX;
		});

		$(set).on('touchend', function (e) {
			var event = e.originalEvent;
			set_touch_end = event.changedTouches[0].pageX;
			set_touch_sum = set_touch_start - set_touch_end;
			if(set_touch_sum > 100 )  j_nt_cc(opts.speed);
			if(set_touch_sum < -100 ) j_pvcc(opts.speed);
		});

		/* control CC */
		function j_nt_cc(cc_speed){
			set_move ='next';
			in_num_ct('add');
			if(set_ct < Math.ceil(set_lg/opts.view)-1 && set_stock <= 0){
				set_ct++;
				move(set_ct,cc_speed);
			}else if(set_stock > 0){
				apen_to2(cc_speed , set_stock);
				set_stock --;
			}else{
				prepe_top(cc_speed);
				set_stock2++;
			}
		}

		function j_pvcc(cc_speed){
			set_move ='prev';
			in_num_ct('mis');
			if( set_ct <=1){
				apen_to(cc_speed);
				set_stock ++;
			}
			else if(set_stock2 > 0){
				prepe_top2(cc_speed , set_stock2);
				set_stock2--;
			}else{
				set_ct--;
				move(set_ct,cc_speed);
			 }
		};

		function in_num_ct(in_mode){
			if(in_mode == 'add'){
				if(nums_ct<nums_ctMax)nums_ct++;
				else nums_ct = 1;
			}else if(in_mode=='mis'){
				if(nums_ct > 1)nums_ct--;
				else nums_ct = nums_ctMax;;
			}
			set.find('.j_indcs li').removeClass('on');
			set.find('.j_indcs li').eq(nums_ct-1).addClass('on');
		}

		/*action function*/
		function move(move_action,move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-(move_action*100)+'%'},move_speed,function(){
					set_toggle = true;
				});
			}
		}
		function apen_to(move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:0},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.prepend(set_container.find('.j_content').eq(-(1+opts.view)));
					}
					set_container.css({left:'-100%'});
					set_toggle = true;
				});
			}
		}

		function apen_to2(move_speed, move_num){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:'-200%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						//set_container.find('.j_content').eq(-opts.view).insertBefore(set_container.find('.j_content').eq(0));
						set_container.find('.j_content').eq(0).insertBefore(set_container.find('.j_content').eq(-opts.view));
					}
					set_container.css({left:'-100%'});
					set_toggle = true;
				});
			}
		}

		function prepe_top(move_speed){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-((set_ct+1)*100)+'%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.append(set_container.find('.j_content').eq(opts.view));
					}
					set_container.css({left:-((set_ct)*100)+'%'});
					set_toggle = true;
					});
			}
		}

		function prepe_top2(move_speed, move_num){
			if(set_toggle){
				set_toggle = false;
				set_container.animate({left:-((set_ct-1)*100)+'%'},move_speed,function(){
					for(var i =0 ; i < opts.view ; i++){
						set_container.find('.j_content').last().insertAfter(set_container.find('.j_content').eq(opts.view-1));
					}
					set_container.css({left: -(set_ct*100)+'%'});
					set_toggle = true;
					});
			}
		}

		/* Auto mode */
		if(opts.auto){
			set_loop_mode = true;

			var auto_fn = setInterval(function(){
				j_nt_cc(opts.autoS);
			},opts.autoT);

			set.find('.j_stop').on('click',function(){
				clearInterval(auto_fn);
				set_loop_mode = false;
				set.find('.j_auto').removeClass('on');
				$(this).addClass('on');
			});

			set.find('.j_auto').on('click',function(){
				set.find('.j_stop').removeClass('on');
				$(this).addClass('on');
				if(!set_loop_mode){
					auto_fn = setInterval(function(){
						j_nt_cc(opts.autoS);
					},opts.autoT);
					set_loop_mode = true;
				}
			});
		}

		set.on('mouseleave',function(){
			//console.log('test');
			if(opts.auto && !set.find('.j_auto').hasClass('on')){
				set.find('.j_auto').trigger('click');
			}
		});
		
		/* test filed*/
		set.find('button').click(function(){
		});
	}
});

$.fn.extend({
	nav : function(options){
	
	
	}
})

$.fn.extend({
	j_tab : function(options){
		var defaults = {
			// IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this);

		set.find('.J_tab_btn li a').on('click', function(){
			$(this).parent().addClass('on').siblings().removeClass('on');
			var num = $(this).parent().index();
			set.find('.J_tab_con').find(' > li').eq(num).addClass('on').siblings().removeClass('on');
			return false;
		});
		/* IC mode */

		/* CC mode */
	}
});

$.fn.extend({
	hf_on : function(options){
		var defaults = {
		hf_out:true,
		hf_ch:true,
		}
		opts = $.extend(defaults,options)
		var set = $(this);
		
		set.on('mouseenter focusin',function(){
			set.addClass('hf_on');
		});

		set.find('a , button').on('mouseenter focusin',function(){
			if(opts.hf_ch){
				$(this).addClass('hf_on');
			}
		});
		

		set.on('mouseleave focusout',function(){
			set.removeClass('hf_on');
			//if(pots.hf_ch)set.children().addClass('hf_on');
		});

		set.find('a , button').on('mouseleave focusout',function(){
			if(opts.hf_ch){
				$(this).removeClass('hf_on');
			}
		});
	}
});


$.fn.extend({
	ch_vl : function(options){
		var defaults = {
			mode : 'IC' // IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this);

		set_toggle = false;
		set.on('submit',function(){

			//set_toggle = true;
			$(this).find('input').each(function(){

				if($(this).hasClass() == 'ch_rq' && $(this).val() == ''){
					alert('값을 입력해주세요');
					setTimeout(function(){set.focus()},50);
				}
			});

			return false;
		});

		/* IC mode */

		/* CC mode */
	}
});


$.fn.extend({
	ch_item : function(options){
		var defaults = {
			mode : 'null' // IC , CC
		}
		opts = $.extend(defaults,options)
		
		var set = $(this),
        set_val = $(this).val(),
        setExp;
        /* null mode */
        if(opts.mode == 'null'){
            set_val =  /\s/g;
            
        }    
		/* phone mode */
        if(opts.mode == 'null'){
            set_val =  /^\d{3}-\d{3,4}-\d{4}$/;;
            
        }   
        
        /* address mode */
        if(opts.mode == 'null'){
            set_val =  /\s/g;
            
        }        
        
        /* pw mode */
        if(opts.mode == 'null'){
            set_val =  /^[a-z0-9_]{4,20}$/;
            
        }      
         
        /* ajax ckeck mode mode */
	}
});

$.fn.extend({
	mk_tem_tag : function(options){
	var defaults = {
		TH_Num : '01', //
		TH_F : 'on',
		TH_H : 'on',
		TH_F_txt : 'TH_F_txt에 내용을 입력해주세요',
		TH_H_txt : 'TH_F_txt에 내용을 입력해주세요'
	}
	opts = $.extend(defaults,options)
	
	var set = $(this);
		
	return false;
    }
});

$.fn.extend({
	j_modal : function(options){
        var defaults = {
            // 아마 여기에 컨텐츠를 넣어야하는 옵션을 생성해주는게 좋을거같다.
        }
        opts = $.extend(defaults,options);
        var info_tg = true;
        var set = $(this);
        set.on('click',function(){

            var make_tag = "<div class='J_modal T_ds_table'>";
            make_tag += "<div class='J_modal_wrap01 T_ds_cell'>";
            make_tag += "<div class='J_modal_contant'>";
            make_tag += "plase content";
            make_tag += "<button type='button' class='J_mask_cl'>닫기</button>"
            make_tag += "</div>";
            make_tag += "</div>";
            
            if(info_tg){
                set.after(make_tag);
                info_tg =false;
            }
            
            $('.J_mask_cl').on('click',function(){
                set.siblings('.J_modal').remove();
                info_tg = true;
            });
        return false;          
        });

	return false;
    }
});



$.fn.extend({
   j_fullpage : function(opitons){
    var defaults = {
       // full page 플러그인 생성란
       j_hd : true,
       j_ind : true,
       j_resize : false
    }
     
    opts = $.extend(defaults,opitons)

    var set = $(this),
    set_section = new Array,
    set_section_title = new Array,
    set_section_top = new Array;
  
    set.find(' > article ').each(function(e,tag){
        set_section[e] = $(this);
        set_section_title[e] = $(this).find('h3').text();
        set_section_top[e] = $(this).offset().top;
        //console.log('태그:',set_section[e],',제목:',set_section_title[e],', 높이:',set_section_top[e]); // testing console.log;
    });
       
       
    if(opts.j_hd){
        var make_tag = "<nav id='J_fullpage_gnb'>";
        make_tag += "<ul>";
        for(var i = 0 ; i < set_section_title.length; i++){
            make_tag += '<li><button type="button">'+set_section_title[i]+'</button></li>';
        }
        make_tag += "</ul>";
        make_tag += "</nav>";
        
        if($('body').find('header').length > 0){
            $('header').append(make_tag)
        }else{
            set.before(make_tag);
        };
        
        $('#J_fullpage_gnb button').on('click',function(){
            var num = $(this).parent().index();
            console.log(num)
            $('body , html').animate({scrollTop:set_section_top[num]});
        });
    }
    
    if(opts.j_ind){
        var make_tag = "<nav id='J_fullpage_ind'>";
        make_tag += "<ul>";
        for(var i = 0 ; i < set_section_title.length; i++){
            make_tag += '<li><button type="button">'+set_section_title[i]+'</button></li>';
        }
        make_tag += "</ul>";
        make_tag += "</nav>";
        
        set.before(make_tag);
        
        $('#J_fullpage_ind button').on('click',function(){
            var num = $(this).parent().index();
            console.log(num)
            $('body , html').animate({scrollTop:set_section_top[num]});
        });   
    }

       
   } 
});


$(function(){
	var shifton = false;
    var win_touch_start = 0;
    var win_touch_end = 0;
    var win_touch_sum = 0;

    function keyControl() {
		$(window).on({
			keyup: function (e) {
				if (e.keyCode == 16) shifton = false
			},
			keydown: function (e) {
				if (e.keyCode == 16) shifton = true
			}
		});
	}
    keyControl(); // use function keybord 'shift' ckecking



    //win key cuntrol funtion
    
	/* use code scroll and keydow event*/
	/*
	$(window).on('mousewheel DOMMouseScroll keydown', function (e) {
        var Event = e.type; // event type
        var E = e.originalEvent.wheelDelta || e.originalEvent.detail * -1; // scroll number
        var E2 = e.keyCode; // key dow code
	});
	*/
	
	/* use tuch event basic*/
	/*
	$(window).on('touchstart', function (e) {
        var event = e.originalEvent;
        win_touch_start = event.changedTouches[0].pageY;
		console.log('tocuh start');
    });

	$(window).on('touchend', function (e) {
        var event = e.originalEvent;
        win_touch_end = event.changedTouches[0].pageY;
        win_touch_sum = win_touch_start - win_touch_end;
		console.log('tocuh end',win_touch_sum);
    });
	*/
    
    /*header gnb*/
	/*
    $('#U_gnb > li > a').on('mouseenter focusin',function(){
        if(!shifton){
            $(this).parent().addClass('on'); 
            $(this).siblings('ul').stop().slideDown(500);    
        }
    });
    
    $('#U_gnb > li').find('ul li:last a').on('focusout',function(){
       if(!shifton){
           $(this).parents('li').parents('li').removeClass('on').find('ul').stop().hide();  
       } 
    });
    $('#U_gnb > li > a').on('focusout',function(){
        if(shifton){
            $(this).parent().removeClass('on'); 
            $(this).siblings('ul').stop().hide();
        }
    });
    
    $('#U_gnb > li').on('mouseleave',function(){
        $(this).removeClass('on'); 
        $(this).find('ul').stop().hide();
    });
	*/
    
    /*header and sdSnb scroll event*/
	/*
	if (document.getElementById('U_sd_nav')) {
		var sd_tg = $('#U_sd_nav').offset().top;
	}
    $(window).on('scroll',function(){
        var hd_tg = $('#U_header').innerHeight();
        var win_sc = $(this).scrollTop();
        if(win_sc > hd_tg){
            $('#U_header > div').addClass('hd_fx');
        }else{
            $('.hd_fx').removeClass();
        }
        if(win_sc > sd_tg){
            $('#U_sd_nav').addClass('on');
        }else{
            $('#U_sd_nav').removeClass('on');
        }
        //fade event 
        $('.fadeIn').each(function(){
           var $fadeIn = $(this);
           var fadeOn = $(this).offset().top - ($(this).innerHeight() / 2);
            console.log(fadeOn , win_sc);

            if(win_sc > fadeOn){
                $fadeIn.addClass('on');
            }
        });
    });
	*/

    /* snb */
	/*
    if(!index && typeof(dep1_name) !== 'undefined' && typeof(dep2_name) !== 'undefined'){
        $('#U_snb').find('.dep1 button').text(dep1_name);
        $('#U_snb').find('.dep2 button').text(dep2_name);

        $('#U_snb').find('.dep1 ul li a').each(function(){
            if($(this).text() == dep1_name)$(this).addClass('on');  
        });

        $('#U_snb').find('.dep2 ul li a').each(function(){
            if($(this).text() == dep2_name)$(this).addClass('on');  
        });

        $('#U_snb button').on('click',function(){
           $(this).siblings('ul').toggle() 
        });

        $('#U_snb div div').on('mouseleave',function(){
           $(this).find('ul').hide(); 
        });
    }
	*/

    /*toggle*/
    $('.J_tg_btn01').on('click',function(){
        $(this).toggleClass('on');
        $(this).siblings('.J_tg_con01').toggle();
    });

    /*ad_modal*/
    //$('#J_btn01').j_motal();

	/*head fixed */
	$(window).on("scroll",function(e){
		//alert($(document).scrollTop() );
		if($(document).scrollTop() > 0){
			$("#sir_hd").addClass('on');
		}else{
			$("#sir_hd").removeClass('on');
		}
	});

	
	/*onepage control*/
	if(index){
		console.log("메인페이지 컨트롤");
		$('#cnt01').addClass('fadeOn');
		var JMS = new Swiper('#J_sw01.swiper-container', {
			/*
			autoplay: {
				delay: 3000,
			  },*/
			slidesPerView: 3,
			loop: true,
			pagination: {
			el: '.swiper-pagination',
			clickable: true,
			},
			
		});
		var DataAddress = ['#cnt02','#cnt06','#cnt07','#cnt08','#cnt09','#cnt11'];
		$(window).on("scroll",function(e){
			//main 
			if($(document).scrollTop() > $(DataAddress[0]).offset().top-100 && $(document).scrollTop() < $(DataAddress[1]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(0).children().addClass('sir_title02');
			}else if($(document).scrollTop() > $(DataAddress[1]).offset().top-100 && $(document).scrollTop() < $(DataAddress[2]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(1).children().addClass('sir_title02');
			}else if($(document).scrollTop() > $(DataAddress[2]).offset().top-100 && $(document).scrollTop() < $(DataAddress[3]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(2).children().addClass('sir_title02');
			}else if($(document).scrollTop() > $(DataAddress[3]).offset().top-100 && $(document).scrollTop() < $(DataAddress[4]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(3).children().addClass('sir_title02');		
			}else if($(document).scrollTop() > $(DataAddress[4]).offset().top-100 && $(document).scrollTop() < $(DataAddress[5]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(4).children().addClass('sir_title02');		
			}else if($(document).scrollTop() > $(DataAddress[5]).offset().top-100){
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
				$('#sir_nav').find('ul li').eq(5).children().addClass('sir_title02');
			}else{
				$('#sir_nav').find('ul li a').removeClass('sir_title02');
			}

			//fade

			clearTimeout( timerFN );
			timerFN = setTimeout( fadeFN(), 150 );
			

		});
		var timerFN;
		function fadeFN(){
			$('.J_fade').each(function(e,tag){
				var Fheight = $(this).offset().top - 200;
				var Fheight2 =  $(this).offset().top + $(this).outerHeight();
				//console.log(Fheight2 ,'//',Fheight);
				if($(document).scrollTop() > Fheight && $(document).scrollTop() < Fheight2) $(this).addClass('fadeOn');

			});
		}

		$('#J_main_down').on('click',function(){
			$("body, html").animate({scrollTop: $("#cnt02").offset().top});
		});

		$('#sir_nav ul li a').hover(function() {
					$(this).addClass('sir_title02_1');
			  }, function() {
					$(this).removeClass('sir_title02_1');
			  }
		);

		$('#sir_nav ul li a').on("click",function(){
			$("body, html").animate({scrollTop: $($(this).data('id')).offset().top});
			return false;
		});

		$('.J_tab_btn_wrap button').on('click',function(){
			var eqNum = $(this).parent().index();
			$(this).parent().siblings().find('button').removeClass('sir_bg04').removeClass('U_ft_cfff ').addClass('sir_ft04').addClass('U_bg_cf8');
			$(this).removeClass('sir_ft04').removeClass('U_bg_cf8 ').addClass('sir_bg04').addClass('U_ft_cfff');
			$(this).parents('.J_tab_btn_wrap').siblings('.J_tab_con_wrap').find('.J_tab_con').hide();
			$(this).parents('.J_tab_btn_wrap').siblings('.J_tab_con_wrap').find('.J_tab_con').eq(eqNum).show();
		});
	}

	$(document).on('change','.J_num',function(){
		var regexp = /^[0-9]*$/
		v = $(this).val();
		if( !regexp.test(v) ) {
			alert("숫자만 입력하세요");
			$(this).val('').select();
		}else if(v < 1){
			aler("최소 구매수량은 1개 입니다.");
		}
	});

	$(document).on('click','.J_add',function(){
		var mt_tag = $(this).parent().siblings('.J_num');
		mt_tag.val(parseInt(mt_tag.val()) +1 );
	
	});

	$(document).on('click','.J_mns',function(){
			var mt_tag = $(this).parent().siblings('.J_num');
		if(mt_tag.val() <= 1)alert("최소 구매수량은 1개 입니다.");
		 else mt_tag.val(parseInt(mt_tag.val()) -1 );
	});

	$('#J_pyc_op').on('click',function(){
		$('#J_info_pyc').show();
		bodyHidden("Y");
		return false;
	});

	$('#J_em_op').on('click',function(){
		$('#J_info_em').show();
		bodyHidden("Y");
		return false;
	});

	$('.J_close').on('click',function(){
		$(this).parents('.J_info').hide();
		bodyHidden();
		if($('#J_gp_modal'))$('#J_gp_modal').hide();
		if($('#J_od_find'))$('#J_od_find').hide();
	})


	$('.J_lg_op').on('click',function(){
		$('#s_ol_before').show();
		$('#url').val('');
		bodyHidden("Y");
		return false;
	});

	var set_captcha = $("#captcha");

	$('.J_rg_op').on('click',function(){
		$('#s_ol_before').hide();
		$('#J_modal_rg').show();
		$('#set_captcha02').append(set_captcha);
		return false;
	});

	$('.J_lg_op2').on('click',function(){
		$('#url').val(g5_shop_url +'/orderinquiry.php');
		$('#s_ol_before').show();
		bodyHidden("Y");
		$('#set_captcha02').append(set_captcha);
		$('#J_od_find').show();
		return false;
	});

	$('.J_fd_op').on('click',function(){
		$('#s_ol_before').hide();
		$('#J_modal_find').show();
		$('#set_captcha01').append(set_captcha);
		return false;			
	});

	$('.J_iv_modal ').on('click',function(){
		$('#J_item_modal').show();
		bodyHidden("Y");
		return false;	
	});

	function bodyHidden(aw){
		if(aw =="Y")$('body, html').css({overflow:'hidden'});
		else $('body, html').removeAttr('style');
	}
	
	if(g5_is_member ==""){
		var setOrder =false;
		var setEventBtn  = '';
		$(document).on('click','.cartopt_oder_btn',function(e){
				var mt_none = true;
			if(!setOrder){
				$(this).siblings('.it_option').each(function(){
					if($(this).val() ==""){
						alert('옵션을 선택해주세요!');
						mt_none = false;
						return false;
					}
				});
				if(mt_none){
					setEventBtn = e;
					alert("비회원입니다. 회원이면 로그인을 해주세요. \n비회원 구매를 원하면 약관에 동의해주세요!");
					$('#s_ol_before').show();
					$('#J_gp_modal').show();
					bodyHidden("Y");
				}
				
				return false;
			}
		});

		$('#order_pass').on('click',function(){
					if(!$('#agreeOder').is(":checked")){
						alert("개인정보처리방침에 동의해주세요.");
						return false
					}
					setOrder = true;
					setEventBtn.toElement.click();
		});
	}

});







