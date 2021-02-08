

$(function() {

	
	if(!jQuery || !window.jQuery)
		return false;
	else {

		$(".ias_pager").hide();
	}

	yepnope.Timeout = 1500;
	
	var loadIAS = typeof(window.loadIAS) == 'undefined' ? false : window.loadIAS;	
	var loadInputMask = typeof(window.loadInputMask) == 'undefined' ? false : window.loadInputMask;
	
	var href = location.href;
	/* global functions */
	var ajaxContentHandler = function(el, href) {
		
		var body = $('body');
		if(body.data('ajaxContent') == 1) return false;
		
		var get = '';
		if($('#sort_price a.select').length) {
			get += '?price='+$('#sort_price a.select').html()
		}
		if($('#sort_type a.select').length) {
			if (get != '')
				var sep = '&';
			else 
				var sep = '?';
			get += sep+'type='+$('#sort_type a.select').html()
		}
		if($('#sort_sort a.select').length) {
			if (get != '')
				var sep = '&';
			else 
				var sep = '?';
			get += sep+'sort='+$('#sort_sort a.select').attr('data-sort')
		}
		if (el.attr('href') !='' &&  el.attr('href') !='#')
			href = el.attr('href');
		$('.products_line .ani_animated_box').removeClass('scale0')
		
		$.ajax({
			type: 'POST',
			url: href+get,
			beforeSend: function() {
				body.data('ajaxContent', 1);
				
			},
			success: function(data) {
				setTimeout(function(){
				$('#products_line').html(data);
				AddAniBield();
				HadnlerC(Bck);
				ALoad($('.aloading'));
				reInitIAS();
				}, 100)
				
			},
			complete: function() {
				body.data('ajaxContent', 0);
				setTimeout(function(){
					
				})
			}
		});
		return href;
		
	};
	function reInitIAS() {
		if($.ias || $.fn.ias) {
			$(window).off('scroll');
			$.ias({
				container: '.ias_parent',
				item: '.ias_child',
				pagination: '.ias_pager',
				next: '.next:not(.hidden) a',
				loader: '<img src="/img/ajax-loader.gif" alt="" class="ias_loader" />',
				history: false,
				trigger: 'Загрузить еще',
				onRenderComplete: function(items) {
					AddAniBield();
					HadnlerC(Bck);
					ALoad($('.aloading'));					
				}
			});
			$('.ias_pager a').each(function() {
				var el = $(this);
				if(el.attr('href').search(/\?/) !== -1)
					el.attr('href', el.attr('href') + '&ajax=1');
				else
					el.attr('href', el.attr('href') + '?ajax=1');
			});
		};
	};
	
	yepnope([
 		
			{ /* infinite scrollyeah */
				test: $('.phone_mask').length  || loadInputMask,
				yep: '/js/jquery.maskedinput-1.3.min.js',
				complete: function() {				
					if(!$('.phone_mask').length || loadInputMask) return true;
					
					$(".phone_mask").mask("+7 (999) 999-99-99");
					
					if ($("#time").length)
						$("#time").mask("99 : 99");
				}
			},
			{ /* infinite scrollyeah */
				test: $('.h_fotorama').length,
				yep: ['/js/fotorama4.js', '/css/fotorama4.css'],
				complete: function() {				
					if(!$('.h_fotorama').length) return true;
					
					$('.h_fotorama').fotorama({
						click:false,
						onClick: function(data){
						},
					});
					
				}
			},
			{ /* infinite ajax scroll */
				test: $('.ias_parent').length || loadIAS,
				yep: '/js/jquery-ias.min.js',
				complete: function() {
					
					if(!($.ias || $.fn.ias || loadIAS)) return true;
					$(function() {
						$(".sort_product a.blue").click(function(e){
							
							if (!$(this).hasClass('select')){
								$(this).parents('.one_sort').find('a').removeClass('select');
								$(this).addClass('select');
								href = ajaxContentHandler($(this), href);
							}
							return false;
							
						});
						
						$.ias({
							container: '.ias_parent',
							item: '.ias_child',
							pagination: '.ias_pager',
							next: '.next:not(.hidden) a',
							loader: '<img src="/img/ajax-loader.gif" alt="" class="ias_loader" />',
							history: false, /* evil force */
							trigger: 'Загрузить еще',
							triggerPageThreshold: 3,
							onRenderComplete: function(items) {
								AddAniBield();
								HadnlerC($('.wrap_block:not(.other_block)'));
								ALoad($('.aloading'));
								
							}
						});
						$('.ias_pager a').each(function() {
							var el = $(this);
							if(el.attr('href').search(/\?/) !== -1)
								el.attr('href', el.attr('href') + '&ajax=1');
							else
								el.attr('href', el.attr('href') + '?ajax=1');
						});
						
					});
				}
			},
			{ /* infinite ajax scroll */
				test: $('.wrap_item').length ,
				yep: '',
				complete: function() {
					
					if(!$('.wrap_item').length) return true;
					$(function() {
						$('.wrap_item').css('height', $('.item_active').height() +40)
//			 			setTimeout(function(){
//			 				$('.content_item').toggleClass('item_active');
//			 			},2000)
						$('.others_product').css('width', ($('.wrap_item').width() /2)+'px');
						$(window).resize(function(){
					 		$('.others_product').css('width', ($('.wrap_item').width() /2)+'px');
						})
						
						$('body').on('click', '.galery_sm .sm_one:not(select)' ,function(){

							var id = $(this).attr('id').split('_')[1];
							$(this).parents('.content_item').find('.galery_big img, .sm_one').removeClass('select');
							$(this).addClass('select');
							$(this).parents('.content_item').find('.galery_big #big_'+id).addClass('select');
						})
						
						var check = true;
						
						$('body').on('click', '.prev_item a, .next_item a', function(event){
							if (!check)
								return false;
							
							check = false;
							event.preventDefault()
							var el = $(this);
							var href = el.attr('href');
							if (el.hasClass('prev')) {
								var new_el = 'prev';
								var now_el = 'next';
							}else if (el.hasClass('next')) {
								var new_el = 'next';
								var now_el = 'prev';
							}
							var load = true;
						
							if (new_el == 'prev')
								var new_element = $('.item_active').prev('.content_item');
							else if (new_el == 'next')
								var new_element = $('.item_active').next('.content_item');
								
							if (new_element.length)
								load = false;
							
							if (load){
							$.ajax({
								type: 'POST',
								url: href,
								beforeSend: function() {
									el.addClass('loading')
								},
								success: function(data) {
									var new_item = $(data).find('.content_item');
									
									history.pushState(null, null, new_item.attr('data-href'))
									document.title = new_item.attr('data-title');
									
									var bottom_products = new_item.find('.bottom_products');
									bottom_products.addClass('hide')
									if (now_el == 'next')
										$('.item_active').before(new_item);
									else if (now_el == 'prev')
										$('.item_active').after(new_item);
									new_item.addClass('cont_item_'+new_el)
									AddAniBield();
									console.log('get')
									ALoad(new_item.find('.item_block_galery .aloading') ,function(){
										
										console.log('load');
										var  nav = $(data).find('.navigation_item');
										$(nav.html()).appendTo($('.navigation_item'));
										
										$('.others_product').css('width', ($('.wrap_item').width() /2)+'px');
										
										$('.wrap_item .nav_item').hide();
										var id =new_item.attr('id').split('content_item_')[1];
										$('#nav_prev_'+id+', #nav_next_'+id).show();
										
										$('.item_active').removeClass('item_active').addClass('cont_item_'+now_el);
										new_item.addClass('item_active').removeClass('cont_item_next').removeClass('cont_item_prev');
										$('.wrap_item').css('height', $('.item_active').height() +40)
										$('.nav_item a').removeClass('loading');
										check = true;
										ALoad(new_item.find('.aloading'),function(){})
										
									});
									setTimeout(function(){
										
 										HadnlerC(bottom_products);
										bottom_products.removeClass('hide')
									},0)
								},
								complete: function() {
									
								}
							});
							} else {
								var new_item = new_element;
								history.pushState(null, null, new_item.attr('data-href'));
								document.title = new_item.attr('data-title');
								
								var bottom_products = new_item.find('.bottom_products');
								bottom_products.addClass('hide')
								
								$('.wrap_item .nav_item').hide();
								var id =new_item.attr('id').split('content_item_')[1];
								$('#nav_prev_'+id+', #nav_next_'+id).show();
								$('.item_active').removeClass('item_active').addClass('cont_item_'+now_el);
								new_item.addClass('item_active').removeClass('cont_item_next').removeClass('cont_item_prev');
								$('.wrap_item').css('height', $('.item_active').height() +40)
								$('.nav_item a').removeClass('loading');
								check = true;
								
								setTimeout(function(){
									
									HadnlerC(bottom_products);
									bottom_products.removeClass('hide')
								},0)
							}
						})
						
					});
					
					
					function LoadItemNext(el){
						
					}
				}
			},
			
			
	 ]);
	initSortable();
	ALoad( $('.aloading'), function(){});
	/* ALoad */
	function ALoad(element, callback){
		
		element.each(function(){
			$(this).attr('data-pos', parseInt($(this).offset().top));
			if ($(this).hasClass('h_fotorama')){
				$(this).on('fotorama:ready', function (e, fotorama) {

					$(this).addClass('a_end')
				});
			}
		})
		
		element.find('img, embed').each(function(){
			$(this).addClass('i_load');
			$(this).bindImageLoad(function(){
				$(this).removeClass('i_load').addClass('i_end');
			});
		})
		
		var interval = setInterval(function(){LoadingElement(element, callback)}, 100)
		
		function LoadingElement(element, callback){
			
			var i = 0;
			element.each(function(){
				if (!$(this).hasClass('a_end')){
					i++;
					var check = true;
					if  (!$(this).parents('.no_prog_load').length){										
						var pos = parseInt($(this).attr('data-pos'));
						element.each(function(){
							if (!$(this).hasClass('a_end')){
							
								if (pos > parseInt($(this).attr('data-pos'))){
									check = false;
									
								}
							}
						})
					}
					if(check){
						if  (!$(this).hasClass('h_fotorama')){
							if (!$(this).find('img.i_load:not(i_end)').length ){
									var el = $(this);
									el.addClass('a_end')
									el.find('.any_bield').addClass('scale0');
									
								} else {
									
								}
						}
					} else {
					}
				}
			})
			
			if (i == 0 ){
				clearTimeout(interval);		
				
				if (callback){
					callback();
				}
			}
		}
	}
	
	/*  LOGIN  */
	var show = false;
	$('.footer_login').css('left', ($(window).width() - 370) / 2+'px');
	
	$('#login').click(function(){
		
		show = true;	
		var el = $('#login_input');
		$('.footer_login').animate({"top": "0"}, 200 , function(){document.getElementById("login_input").focus();})				
		
		
		el.keydown(function(e) { 
			el.css('color','#333333');
			if(e.which == 13) { ToLogin()}
			
		});
		el.keyup(function(e) {
			if(!el.val().length) {el.css('color','#aaaaaa');}
		});	
		$('body').click(function(){
			if(!$('.footer_login').is(':hover') && show && !$('#login').is(':hover')){
				$('.footer_login').animate({"top": "-90px"}, 200)
			}
		});
		
		
	})	
	
	$('#logout').click(function(){
			$.ajax({
				  url: '/logout',
				  type: 'POST',
				  data: 'stat=logout', 
				  success: function(data){
				  		if (data){
				  			window.location = data;
				  		}
				  }
			});	
		});	
	/*  LOGIN  */
	
	/* Product Line */ 
	
	
	var Bck = $('.wrap_block:not(.other_block)');		
	var Animate = function(el) {
  	var newPos = $(el).parent().position()	
		newPos = {'left': newPos.left + eval(($(el).parent().css('margin-left').split('px')[0])) + 'px', 'top':  (newPos.top + 25) + 'px'}
   	 	$(el).css(newPos)
	}
	var Ani = '';  	
	AddAniBield();
  	HandlerA(Ani);
  	
  
 	$(window).resize(function(){
 		HadnlerC(false);
	})
  
	$('.sm_big_chahge div').click(function(){
		if (!$(this).hasClass('select')){
			$(this).parents('.resize_block').toggleClass('big_block');
			$(this).parents('.resize_block').find('.sm_big_chahge div').toggleClass('select');
			HadnlerC(Bck);
		}
		
	})
	
	
	$('body').on('click', '.wrap_block .item', function(){
		href= $(this).find('.item_desc a').attr('href');
		location.href= href;
	})
	
	function HandlerA(any) {
 		$.each(any, function(index, el){ Animate(el) })
 		
	}

	function HadnlerC(Bck){
		if (!Bck) {
			$('.wrap_block:not(.other_block)').each(function(){ItemsCentered($(this))})
		} else {
			Bck.each(function(){ItemsCentered($(this))})
		}		
	}
	
	function AddAniBield(){
		$('.ani_box:not(.any_add)').wrapInner('<div class="any_bield" />')
	    Ani = $('.ani_box:not(.any_add) .any_bield');
		$('.ani_box:not(.any_add)').addClass('any_add')
		setTimeout (function () {Ani.addClass ('ani_animated_box')}, 333)
		
	}

	var ItemsCentered = function(el){
		
		
		var itemwidth  = (el.find('.item').width() + 40) ;
		
		var count  =Math.floor((el.width()) / (itemwidth ));

		if (count > el.find('.item').length)
			count = el.find('.item').length;
		var PadWidth = (el.width()) - (el.find('.item').width() * count);
		var padding = Math.floor(( PadWidth / count) / 2);

		el.find('.item').css({'margin-left': padding+'px', 'margin-right': padding+'px'})
		
		if (!$('body.body_edit').length)
				HandlerA(el.find('.any_bield'));
	}

	HadnlerC(Bck);
	
	/* ADD TO CART */
	$('body').on('click', '.addtocart', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		AddToCart(href);
	})
	
	$('body').on('click', '.basket_item_del', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		DeleteToCart(href, $(this).parents('.preview_item'));
	})
	
	$('body').on('click', '.basket_clear', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		$.ajax({
			type: 'POST',
			url: href,
			success: function(response) {
				data =$.parseJSON(response);
				if (data.error == 0){
					$( ".basket_poduct .preview_item" ).remove();
					UpdateBasket();
				}
			}
		});
	})
	
	function AddToCart(href) {
		$.ajax({
			type: 'POST',
			url: href,
			success: function(response) {
				data =$.parseJSON(response);
				if (data.error == 0){
					UpdateBasket();
					$( ".basket_poduct .br" ).before(data.preview);
					
					
				}
			}
		});
	}
	
	function DeleteToCart(href,el) {
		$.ajax({
			type: 'POST',
			url: href,
			success: function(response) {
				data =$.parseJSON(response);
				if (data.error == 0){
					el.remove();
					UpdateBasket();					
				}
			}
		});
	}
	
	function UpdateBasket(){
		var allprice = 0;
		var count = 0;
		if (getCookie('cart')) {
			$Arrcoockie = getCookie('cart').split('|');
			for (var i=0;i<$Arrcoockie.length;i++) {
				var Arrone = $Arrcoockie[i].split(':');
				if($Arrcoockie[i] != ''){
					var Arrone = $Arrcoockie[i].split(':');
					count = count + eval(Arrone[2]);
					allprice += parseInt(Arrone[1]);
							
				}
			}
			
			allprice = allprice.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')
			allprice = allprice.replace(/ /, '&nbsp;')

			
			var item = get_correct_str(count, 'товар', 'товара', 'товаров');
		} else {
			var item = '0 товаров';
			allprice = 0;
		}
		if (count == 0)
			$('.basket').addClass('empty');
		else
			$('.basket').removeClass('empty');
		
		$('.basket_order_label').html('В&nbsp;корзине&nbsp;'+count+'&nbsp;товара на&nbsp;сумму&nbsp;<span>'+allprice+'&nbsp;рублей</span>');

	}
	
	
	function get_correct_str(num, str1, str2, str3) {
		var val = eval(num);
	    if (val > 10 && val < 20) { return num +'&nbsp;'+ str3 ;}
	    else {
	    	  val = eval(num) % 10;
	        if (val == 1) { return num +'&nbsp;'+ str1;
	        } else if (val > 1 && val < 5) { return num +'&nbsp;'+ str2;
	        } else { return num +'&nbsp;'+ str3;}
	    }
	}
	
	function initSortable(){
		
		if ($('body.body_edit .wrap_block.sortable').length){	
			
			$('body.body_edit .wrap_block.sortable .products_line .ias_parent').sortable({
				revert: 100,
				update: function(){
					var sort = 1;
			  		var sort_line = '';
					 $( ".wrap_block.sortable .products_line .item" ).each(function(){
						 var id = $(this).attr('id').split('_')[1];
						 sort_line = sort_line+'|'+id+'-'+sort;
						 sort++;
					 })
					 $.ajax({
						  url: '/edit',
						  type: 'GET',
						  data: 'stat=sort&sort_line='+sort_line,
						  success: function(data){
						  }
					});				
				}
			});

		$('body.body_edit .sortable .products_line .ias_parent item').disableSelection();
		}
	}
	
});


function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}

function ToLogin(){
	var pass = $('#login_input').val()
	$.ajax({
		  url: '/login',
		  type: 'POST',
		  data: 'pass='+pass, 
		  success: function(data){
		  		if (data){
		  			window.location = data;
			 	} else {
			  	$('.footer_login').animate({"left": "+=5px"}, 50)
			        .animate({"left": "-=8px"}, 50)
			        .animate({"left": "+=6px"}, 50)
			        .animate({"left": "-=4px"}, 50)
			        .animate({"left": "+=1px"}, 50);
			 	} 
		  }
	});
}

;(function ($) {
    $.fn.bindImageLoad = function (callback) {
        function isImageLoaded(img) {

            if (!img.complete) {
                return false;
            }
            if (typeof img.naturalWidth !== "undefined" && img.naturalWidth === 0) {
                return false;
            }
            return true;
        }

        return this.each(function () {
            var ele = $(this);
            if (ele.is("img") && $.isFunction(callback)) {
                ele.one("load", callback);
                if (isImageLoaded(this)) {
                    ele.trigger("load");
                }
            }
        });
    };
})(jQuery);

