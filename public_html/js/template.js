/*
 Krutilka (Spinner) Jquery Plugin, v 0.1
 Author: Artem Polikarpov | http://artpolikarpov.ru/
 */
(function ($) {
  var ns = 'http://www.w3.org/2000/svg';
  var svgTest = function() {
    // Поддерживается ли СВГ
    var div = document.createElement('div');
    div.innerHTML = '<svg/>';
    return (div.firstChild && div.firstChild.namespaceURI) == ns;
  };

  var svgFLAG = svgTest();


  var makeSVG = function (tag, attrs) {
    var el= document.createElementNS(ns, tag);
    for (var k in attrs) {
      el.setAttribute(k, attrs[k]);
    }
    return el;
  };

  var krutilka = function (el, options) {
    el.data('initialized', true);

    var svg = $(makeSVG('svg', {width: options.size, height: options.size, style: 'background: '+ options.background +''})).appendTo(el);
    var g = makeSVG('g', {fill: 'none', stroke: options.color, 'stroke-width': options.petalWidth});
    var $g = $(g).appendTo(svg);

    var x = options.size / 2;
    var y = options.size / 2;

    // Строим крутилку
    for (var _i = 0; _i < options.petals; _i++) {
      // Угол в градусах
      var a = 360 / options.petals * (options.petals - _i);
      // Прозрачность
      var opacity = Math.max(1 - 1 / options.petals * _i, .25);
      // Создаём линию
      $(makeSVG('line', {x1: options.size / 2, y1: options.petalOffset, x2: options.size / 2, y2: options.petalOffset + options.petalLength, transform: 'rotate('+ a + ' ' + x + ' ' + y + ')', opacity: opacity})).appendTo($g);
    }

    // Крутим крутилку
    var frame = 0;
    var animationInterval;
    var animation = function () {
      var a = 360 / options.petals * frame;
      g.setAttribute('transform', 'rotate('+ a + ' ' + x + ' ' + y + ')');

      frame++;
      if (frame >= options.petals) {
        frame = 0;
      }
    };

    el.bind('show', function(e, time){
      // Показываем и запускаем крутилку
      el.stop().fadeTo('fast', 1);
      clearInterval(animationInterval);
      animation();
      animationInterval = setInterval(animation, (time ? time : options.time) / options.petals);
    });

    el.bind('hide', function(){
      // Скрываем и останавливаем крутилку
      el.stop().fadeTo('fast', 0, function(){
        clearInterval(animationInterval);
      });
    });

    el.trigger('show');
  };

  $.fn.krutilka = function (o) {
    var options = {
      size: 32, // Ширина и высота блока с крутилкой
      petals: 15, // Сколько лепестков у крутилки
      petalWidth: 2, // Толщина лепестка
      petalLength: 8, // Длина лепестка
      petalOffset: 1, // Внутреннее поле блока с крутилкой (расстояние до кончика лепестка)
      time: 1000, // Время прохода круга в миллисекундах
      color: '#808080', // Цвет лепестков
      background: 'none' // Фон крутилки
    };

    $.extend(options, o);

    this.each(function () {
      var el = $(this);
      if (!el.data('initialized') && svgFLAG) {
        // Если ещё не инициализировано
        krutilka(el, options);
      }
    });

    // Чейнабилити
    return this;
  };
})(jQuery);


$(function() {
	if(!jQuery || !window.jQuery) return false;
	else $(".ias_pager").hide();

	/* global functions */
	var _OS = CheckOS();
	
	initktutilka();
	UpdatePositionBasket();
	$(window).resize(function(){ UpdatePositionBasket()})
	ScrollingMenu();
	$(window).scroll(function(){ 
		ScrollingMenu();
	});
	
	
	/* ALoading */
	function ALoading(element, callback){		
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
									el.parents('.a_load_block').addClass('show');
									el.addClass('a_end')
									if (!el.hasClass('pass'))
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
				if (callback) callback();
			}
		}	
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
	
	/*  LOGIN */	
	var show = false;
	$('.footer_login').css('left', ($(window).width() - 370) / 2+'px');
	
	$('#login').click(function(){
		
		show = true;	
		var el = $('#login_input');
		$('.footer_login').animate({"top": "0"}, 200 , function(){document.getElementById("login_input").focus();})				
		
		
		el.keydown(function(e) { 
			if(e.which == 13) { ToLogin()}
			
		});
		el.keyup(function(e) {
		});	
		$('body').click(function(){
			if(!$('.footer_login').is(':hover') && show && !$('#login').is(':hover')){
				$('.footer_login').animate({"top": "-90px"}, 200)
			}
		});
		return false;	
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
		return false;
	});
	
	function ToLogin(){
		var pass = $('#login_input').val()
		$.ajax({
			  url: '/login',
			  type: 'POST',
			  data: 'stat=login&pass='+pass, 
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
	
	
	/*   ANIMATE ITEMS  */
	var Ani = '';
	var Animate = function(el) {
	  	var newPos = $(el).parent().position()	
		newPos = {'left': newPos.left + eval(($(el).parent().css('margin-left').split('px')[0])) + 'px', 'top':  (newPos.top + 25) + 'px'}
	 	$(el).css(newPos)
	}
	var ItemsCentered = function(el){
		var itemwidth  = (el.find('.item:not(.hide)').width() + 20) ;
		var count  =Math.floor((el.width()) / (itemwidth ));
		
		if (el.find('.index').length > 0) {
			var elemLength = el.find('.item:not(.hide)').length;
			if (count >= elemLength) {
				el.find('.item').each(function() {
					if ($(this).index() < count - 1) {
						$(this).removeClass('hide');
					}
				})
			} else {
				console.log('nado suzhat');
				el.find('.item:not(.hide)').each(function() {
					if ($(this).index() >= count - 1 && $(this).index() < elemLength-1) {
						$(this).addClass('hide');
					}
				})
			}

		}
		if (count > el.find('.item:not(.hide):not(.pass)').length)
			count = el.find('.item:not(.hide):not(.pass)').length;
		
		var PadWidth = (el.width()) - (el.find('.item:not(.hide)').width() * count);
		var padding = Math.floor(( PadWidth / count) / 2) - 1;

		el.find('.item:not(.hide)').css({'margin-left': padding+'px', 'margin-right': padding+'px'})
		
		if (!$('body.body_edit').length)
			HandlerAimate(el.find('.any_bield'));
	}
	initSortable();
	ALoading( $('.aloading'), function(){});
	
	if (!$('body.body_edit .wrap_block.sortable').length){	
		AddAniBield();
	}
	
	HandlerAimate(Ani);
	HandlerCentered($('.wrap_block:not(.other_block)'));
  	setTimeout(function(){
  		
  		HandlerCentered($('.wrap_block:not(.other_block)'));
  	}, 600)
	
	$(window).resize(function(){
		setTimeout(function(){
			HandlerCentered(false);
		})
	})
	
	
	
	$('.sm_big_chahge div').click(function(){
		if (!$(this).hasClass('select')){
			$(this).parents('.resize_block').toggleClass('big_block');
			$(this).parents('.resize_block').find('.sm_big_chahge div').toggleClass('select');
			HandlerCentered($('.wrap_block:not(.other_block)'));
			SetCickokieSort();
		}
		
	})
	
	function SetCickokieSort() {
								
		var type = 'Все';
		if ($('#sort_type a.select').length){
			type = $('#sort_type a.select').html()
			subtype = $('#sort_type a.select').data('subtype')
		}

		var price = '';								
			price = $('#sort_price a.select').attr('data-price');
			
		var sort = '';					
		if ($('#sort_sort a.select').length)
			sort = $('#sort_sort a.select').attr('data-sort');
		
		var smbig = 'sm';								
		 if ($('.sm_big_chahge .select').hasClass('s_big_img ')) {
			 smbig = 'big';
		}
		 var data = {
			type:type,
			subtype:subtype,
			price:price,
			sort:sort,
			smbig:smbig
		 }
		
		$.ajax({
			  url: '/catalog/sort',
			  type: 'POST',
			  data: data,
			  success: function(data){
			  }
		});	
	}

	function HandlerAimate(any) {
 		$.each(any, function(index, el){ Animate(el) })	
	}
	
	function HandlerCentered(Bck){
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
	
	
	/* ADD TO CART */
	var EnterEnable = false;
	
	$('body').on('click' ,'.buy_order:not(.confirm_btn)', function(e){
		e.preventDefault();
		var el = $(this);
		el.parents('.basket').addClass('confirm_basket')
		EnterEnable = true;
		console.log('click .buy_order')
		//return false;
	})
	
	$('body').on('click', '.addtocart', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		AddToCart(href, $(this));
		EnterEnable = false;
		if (typeof $(this).data('fastorder') !== 'undefined') {
			step = $(this).data('fastorder');
		} else {
			step = 1;
		}
		basketStep.changeStep(step);
	})
	
	$('body').on('click', '.basket_item_del', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		DeleteToCart(href, $(this).parents('.preview_item'));
	})
	
	$('body').on('click', '.basket_clear', function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		EnterEnable = false;
		$.ajax({
			type: 'POST',
			url: href,
			success: function(response) {
				data =$.parseJSON(response);
				if (data.error == 0){
					basketStep.$basket.find('.basket_step').removeClass('_active')
					$( ".basket_poduct .preview_item" ).remove();
					UpdateBasket();
					$('.basket').removeClass('confirm_basket').removeClass('sended')
				}
			}
		});
	})
	
	function AddToCart(href, el) {
		var data  = '';
		if (el.parents('.item_block').find('.one_product_price_desc_input_count input.number').length)
			var count = el.parents('.item_block').find('.one_product_price_desc_input_count input.number').val();
			data = {
				count : count}
		
		$.ajax({
			type: 'POST',
			url: href,
			data:data,
			success: function(response) {
				data =$.parseJSON(response);
				if (data.error == 0){
					el.parents('.item_block').find('.one_product_price_desc_input_count input.number').val(1);
					$('.basket').removeClass('confirm_basket').removeClass('sended')
					UpdateBasket();
					if (!$('.basket #pr'+data.id).length){
						$( ".basket_poduct .br" ).before('<div class="preview_item " id="pr'+data.id+'">'+data.preview+'</div>');
					} else {
						
						$('.basket #pr'+data.id).html(data.preview);
					}
					UpdatePositionBasket();
					$('html, body').animate({
				    	scrollTop: 0
				 	}, 200);
					console.log('addtocart');
					yaCounter24162886.reachGoal('addtocart');
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
					UpdatePositionBasket();
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
					count = count + 1;
					allprice += (parseInt(Arrone[1]) * parseInt(Arrone[2]));
							
				}
			}
			
			allprice = allprice.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1&nbsp;')
			
			var item = get_correct_str(count, 'товар', 'товара', 'товаров');
		} else {
			var item = '0 товаров';
			allprice = 0;
		}
		if (count == 0){
			$('.basket').addClass('empty');
			$('.basket input').removeClass('show')
			$('.basket .buy_order').removeClass('confirm_btn').html('Заказать...')
			$('.confirm_form').removeClass('show');
		} else
			$('.basket').removeClass('empty');
		
		$('.basket_order_label').html('В&nbsp;корзине&nbsp;'+item+' на&nbsp;сумму&nbsp;<span>'+allprice+'&nbsp;рублей</span>');

	}
	
	function UpdatePositionBasket () {
		/*
		if ($(window).width() < 1500) {
			$('.basket_poduct').css('width', ($('.basket .wrap_sizes').width() - 380)+'px')
			var count_item_line = Math.floor(( $('.basket_poduct').width()) / 225);
		} else {
			$('.basket_poduct').css('width', ($('.basket .wrap_sizes').width() - 380 - 150)+'px')
			var count_item_line = Math.floor(( $('.basket_poduct').width() - 120) / 225);
		}
		
		if (count_item_line > $('.basket_poduct .preview_item').length)
			count_item_line = $('.basket_poduct .preview_item').length;
		
		var margin = (count_item_line  * 240)   ;
		if ($(window).width() > 1500) {
			margin += 75
		}
		if (count_item_line < 2){
			$('.confirm_form').addClass('sm')
		} else {
			$('.confirm_form').removeClass('sm')
		}
		
		
		$('.basket_order').css({'right': 'auto', 'left': margin+'px'})
		*/
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
	
	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime()+(exdays*24*60*60*1000));
		var expires = "expires="+d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires+'; path=/';
	}
	
	/* AJAX LOAD CATALOG  */
	
	var href = location.href;
	var ajaxContentHandler = function(el, href) {	
		var body = $('body');
		if(body.data('ajaxContent') == 1) return false;
		
		var get = '';
		if($('#sort_price a.select').length) {
			get += '?price='+$('#sort_price a.select').html()
		}
		if($('#sort_type a.select').length) {
			if (get != '') var sep = '&';
			else var sep = '?';
			get += sep+'type='+$('#sort_type a.select').html()
		}
		if($('#sort_sort a.select').length) {
			if (get != '') var sep = '&';
			else var sep = '?';
			get += sep+'sort='+$('#sort_sort a.select').attr('data-sort')
		}
		if (el.attr('href') !='' &&  el.attr('href') !='#')
			href = el.attr('href');
		$('.products_line .ani_animated_box').removeClass('scale0')
		
		$.ajax({
			type: 'POST',
			url: href+get,
			beforeSend: function() { body.data('ajaxContent', 1);},
			success: function(data) {
				setTimeout(function(){
					$('#products_line').html(data);
					AddAniBield();
					HandlerCentered($('.wrap_block:not(.other_block)'));
					ALoading($('.aloading'));
					initAjaxScroll();
				}, 100)
				
			},
			complete: function() {
				body.data('ajaxContent', 0);
			}
		});
		return href;
		
	};
	
	function liveSort(callback){
//		if (!$('#sort_price').length) {
//				
//			if (callback) callback();
//			return true;
//		}
		//$('.description_block').css('opacity','0');
		var type = '';
		var subtype = '';
		var currentCategory = '';
		if ($('#sort_type a.select').length){
			if ( $('#sort_type a.select').html() != 'Все') {
				subtype = $('#sort_type a.select').data('subtype');
				currentCategory = $('#sort_type a.select').data('value');
				//console.log(subtype)
				if (subtype == 'flowertype') {
					type = $('#sort_type a.select').html()
				}
			}
		}
		
		searchText = $('[name=searchByName]').val().toLowerCase();

		var price = '';
		if ( $('#sort_price a.select').length && $('#sort_price a.select').html() != 'Любая')
			price = $('#sort_price a.select').attr('data-price');

		
		$('.catalog_empty').removeClass('show');
		$('.item').each(function(){
			var check = true;
			if ($('input.sorttype').length)
				var i_type = $(this).find('input.sorttype').val();
			else 
				var i_type = '';
			var i_price = $(this).find('input.sortprice').val();
			
			if (type != '' && !i_type.match(type)){
				check = false;
			}
			if (searchText != '' && !$(this).find('.item_desc a').text().toLowerCase().match(searchText)){
				check = false;
			}
			
			itemCategory = $(this).find('input[data-sort=category]').val();
			if (subtype == 'cat' && itemCategory != currentCategory){
				check = false;
			}
			
			if (price != ''){
				var priceArr = price.split('-');
				if ( (!priceArr[1] && parseInt(i_price) <= parseInt(price) ) || ( priceArr[1]  && parseInt(i_price) >= parseInt(priceArr[0]) && parseInt(i_price) <= parseInt(priceArr[1]) )) {				
				} else {
					check = false;
				}
				
			}
			
			if (check){
				$(this).removeClass('pass')
			} else {
				$(this).addClass('pass');
				$(this).find('.any_bield').removeClass('scale0');
			}
			
		})
		$('.item.pass').addClass('hide');
		$('.item:not(.pass)').removeClass('hide');
		
		
		setTimeout(function(){
			
			HandlerCentered($('.wrap_block:not(.other_block)'));
			$('.products_line').css('min-height','300px');

			if (!$('.description_block').length) {
				$('.products_line').css('min-height', ($('.footer').offset().top - ($('.products_line').offset().top ))+'px')
			}
			
		}, 400)
		setTimeout(function(){
			$('.item:not(.pass) .any_bield').addClass('scale0');
			if(!$('.item:not(.pass) .any_bield').length)
				$('.catalog_empty').addClass('show');
			if (callback) callback();
			return true;
		}, 600)
		
		
	}
	
	
	function reInitIAS() {
		if($.ias || $.fn.ias) {
			$(window).off('scroll');
			$.ias({
				container: '.ias_parent',
				item: '.ias_child',
				pagination: '.ias_pager',
				next: '.next:not(.hidden) a',
				loader: '',
				history: false,
				trigger: 'Загрузить еще',
				
				onRenderComplete: function(items) {
					AddAniBield();
					HandlerCentered(Bck);
					ALoading($('.aloading'));					
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
	
	
	/*   SORTABLE ITEM   */
	
	function initSortable(){
		
		if ($('body.body_edit .wrap_block.sortable').length){	
			
			$('body.body_edit .wrap_block.sortable .products_line .ias_parent').css('position','').sortable({
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
	
	function initktutilka(){
		
		$('.krutilka:not(.init)').krutilka({
			size: 50, // Ширина и высота блока с крутилкой
			  petals: 15, // Сколько лепестков у крутилки
			  petalWidth: 2, // Толщина лепестка
			  petalLength: 12, // Длинна лепестка
			  petalOffset: 1, // Внутреннее поле блока с крутилкой
			  time: 1000, // Время прохода круга в миллисекундах
			  color: '#808080', // Цвет лепестков
			  background: 'none' // Фон крутилки
		});
		$('.krutilka:not(.init)').addClass('init')
	}
	
	
	function initAjaxScroll(){
		$.ias({
			container: '.ias_parent',
			item: '.ias_child',
			pagination: '.ias_pager',
			next: '.next:not(.hidden) a',
			loader: '',
			history: false, /* evil force */
			trigger: 'Загрузить еще',
			triggerPageThreshold: 3,
			beforePageChange:function(){
				$('.wrap_block .krutilka').addClass('show')
			},
			onRenderComplete: function(items) {
				AddAniBield();
				HandlerCentered($('.wrap_block:not(.other_block)'));
				ALoading($('.aloading'));
				$('.wrap_block .krutilka').removeClass('show')
			}
		});
		$('.ias_pager a').each(function() {
			var el = $(this);
			if(el.attr('href').search(/\?/) !== -1)
				el.attr('href', el.attr('href') + '&ajax=1&os='+_OS);
			else
				el.attr('href', el.attr('href') + '?ajax=1&os='+_OS);
		});
	}
	
	function ScrollingMenu(){
		
		if (CheckOS() == 'anyone'){
			var scroll = $(window).scrollTop();
	
			var pos = 15;
			
			if(!$('.basket').hasClass('empty'))
				pos = pos + $('.basket').height() + 40;
			if ($('.admin_line').length)
				pos = pos + 40;
			
			if (scroll < pos)
			 	$('.wrap_header').removeClass('fixed');
			else
			 	$('.wrap_header').addClass('fixed');
		}
	}
	
	function CheckOS(){
		
		var OS = '';
			if (navigator.userAgent.match(/Android/i)) OS = 'android';
			else if (navigator.userAgent.match(/BlackBerry/i)) OS = 'blackberry';
			else if (navigator.userAgent.match(/iPhone|iPod/i)) OS = 'iphone';
			else if (navigator.userAgent.match(/iPad/i)) OS = 'ipad';
			else if (navigator.userAgent.match(/IEMobile/i)) OS = 'iemobile';
			else  OS = 'anyone';
			
		return OS;
		
	}
	
	function is_touch_device() {
		  return !!('ontouchstart' in window);
	}
	
	/* YEONOPE */
	yepnope.Timeout = 1500;	
	var loadIAS = typeof(window.loadIAS) == 'undefined' ? false : window.loadIAS;	
	var loadInputMask = typeof(window.loadInputMask) == 'undefined' ? false : window.loadInputMask;

	yepnope([
				
				{ /* infinite Home Fotorama */
					test: $('.h_fotorama').length,
					yep: ['/js/fotorama4.js', '/css/fotorama4.css'],
					complete: function() {				
						if(!$('.h_fotorama').length) return true;
						
						$('.h_fotorama').fotorama({
							click:false,
						});
						
					}
				},
				{ /* infinite ajax scroll */
					test: $('.ias_parent').length || loadIAS,
					yep: ['/js/jquery-ias.min.js', '/js/tinysort.js'],
					complete: function() {
						if(!($.ias || $.fn.ias || loadIAS)) return true;
						$(function() {
							
							
							$("#sort_type  a.blue, #sort_price  a.blue").click(function(e){
								e.preventDefault()
								if (!$(this).hasClass('select')){
									$(this).parents('.one_sort').find('a').removeClass('select');
									$(this).addClass('select');
									liveSort();
									SetCickokieSort();
									var el = $(this) 
//									setTimeout(function(){
//										if (el.parents('.one_sort').attr('id') == 'sort_type')
//											DisableEmptySort(el, $('#sort_price'));
//										else 
//											DisableEmptySort(el, $('#sort_type'));
//									},0)
								}
								return false;
							});
							$("#sort_sort  a.blue").click(function(e){
								e.preventDefault()
								if (!$(this).hasClass('select')){
									$(this).parents('.one_sort').find('a').removeClass('select');
									$(this).addClass('select');
									var data_sort = $(this).attr('data-sort');
									$('.ias_parent>.item').tsort('.sortprice',{order:''+data_sort+'', attr:'value'});
								} else {
									$(this).parents('.one_sort').find('a').removeClass('select');
									$('.ias_parent>.item').tsort('.sortorder',{order:'asc', attr:'value'});
								}
								
								HandlerCentered($('.wrap_block:not(.other_block)'));
								SetCickokieSort();
								return false;
							})
							timerId = false;
							$('[name=searchByName]').on('keyup', function() {
								if (timerId) {
									clearTimeout(timerId);
								}
								timerId = setTimeout(function() {
									liveSort();
								},500);
							})
							$('.searchByName').on('submit', function(e) {
								e.preventDefault();
								liveSort();
							})
							initAjaxScroll();
							
							
//							function DisableEmptySort(el, block) {
//								block.find('a.blue:not(.select)').each(function(){
//									if (block.attr('id') == 'sort-type')
//										var val = $(this).html();
//									else if (block.attr('id') == 'sort_price') 
//										var val = $(this).attr('data-price');
//									
//									if (val != '' && val != 'Все') {
//										var check = false;
//										$('#products_line .item').each(function(){
//											if (block.attr('id') == 'sort-type'){
//												if ($(this).find('.sorttype').val() == val)
//													check = true;
//											} else if (block.attr('id') == 'sort_price'){
//												var item_val = $(this).find('.sortprice').val();
//												var priceArr = val.split('-');
//												if ( (!priceArr[1] && parseInt(item_val) <= parseInt(val) ) || ( priceArr[1]  && parseInt(item_val) >= parseInt(priceArr[0]) && parseInt(item_val) <= parseInt(priceArr[1]) )) {				
//													check = true;
//												}
//											}
//										})
//										
//										if (!check) {
//											$(this).addClass('disable')
//										} else {
//											$(this).removeClass('disable')
//										}
//									}
//								})
//							}
						});
					}
				},
				{ /* For Item page*/
					test: $('.wrap_item').length ,
					yep:'',
					complete: function() {
						if(!$('.wrap_item').length) return true;
						
						$(function() {
							var checkMousewheel = true; 
							if (_OS != 'anyone'){
								$('.message_nav').addClass('disable');
							}
							
							$('body').on('click', '.count_minus' ,function(){
								var count = parseInt($(this).parents('.item_feature').find('input.number').val());
								if (count > 1) {
									count--;
									var input = $(this).parents('.item_feature').find('input.number');
									input.val(count);
									
								}
							})

							$('body').on('click', '.item_feature .count_plus' ,function(){
								var input = $(this).parents('.item_feature').find('input.number');
								var count = parseInt(input.val());

								if (count < 999) {			
									count++;		
									
									input.val(count);
								}	
								
							})
							$('body').on('change', '.one_product_price_desc_input_count input.number' ,function(){
								if (parseInt($(this).val()) > 999)
									$(this).val(999);
							})
							
							$('body').on('click', '.item_block .item_feature .fprice:not(.select)', function(){
								$(this).parents('.item_block').find('.item_block_price span').html($(this).attr('data-price'))
								$(this).parents('.item_block').find('.item_feature .select').removeClass('select')
								$(this).addClass('select');
								var fid = $(this).attr('id').split('fprice_')[1];
								var href  = $(this).parents('.item_block').find('.addtocart').attr('href');
								var RegExp = /\?/
								var link = '';
								if (RegExp.test(href))
									var link = href.split('?')[0]
								else 
									link = href;
								
								$(this).parents('.item_block').find('.addtocart').attr('href', link+'?fid='+fid);
								
							})
							
							
							
							var check = true;
							$('.item_def').addClass('item_active')
							setTimeout(function(){ResizeItemBlock()},200)
							$('.wrap_item').css('height', ($('.item_active').height() + $('.item_active .wrap_sizes.recent_block').height() + 40) )
							$(window).resize(function(){
								setTimeout(function(){
									ResizeItemBlock()
								}, 600)
							})
							
							$('body').on('click', '.galery_sm .sm_one:not(select)' ,function(){
								ChangeGalery($(this))
							})
							
							
							$('body').on('click', '.wrap_nav:not(.disable)' ,function(){
								if ($(this).hasClass('left'))
									ChangeGalery($(this).parents('.content_item').find('.sm_one.select').prev('.sm_one'))
								else
									ChangeGalery($(this).parents('.content_item').find('.sm_one.select').next('.sm_one'))
									
							})
							
							function ChangeGalery(el){
								var id = el.attr('id').split('_')[1];
								el.parents('.content_item').find('.galery_big img, .sm_one').removeClass('select');
								el.addClass('select');
								el.parents('.content_item').find('.galery_big #big_'+id).addClass('select');
								if (el.prev('.sm_one').length)
									el.parents('.content_item').find('.wrap_nav.left').removeClass('disable')
								else 
									el.parents('.content_item').find('.wrap_nav.left').addClass('disable')
									
								if (el.next('.sm_one').length)
									el.parents('.content_item').find('.wrap_nav.right').removeClass('disable')
								else 
									el.parents('.content_item').find('.wrap_nav.right').addClass('disable')
							}
								
							$('body').on('click', '.prev_item a, .next_item a', function(event){
								event.preventDefault()
								if (check){ 
									check = false;	
									HadlerNewItemLoader($(this))
									
								}
							})
							
							yepnope([
							        {
							        	test: $('.wrap_item').length && is_touch_device(),
										yep: '/js/jquery.mobile.mousewheel.custom.min.js',
										complete: function() {											
											if(!$('.wrap_item').length || !is_touch_device()) {
												return true;
											}
											
											if (is_touch_device() && getCookie('swipe') != 1){
												
												$('.nav_item_mobile').removeClass('disable');
												$('.nav_item_mobile').delay(3000).fadeOut();
											}
											var first = true;
											 
											/* moble touch */
											$.event.special.swipe.horizontalDistanceThreshold = 80
											$(window).on( "swipe", function( event) {
												var onSwipe = false;	
												
												start = event.swipestart;
												stop = event.swipestop;
												if ( Math.abs( start.coords[ 0 ] - stop.coords[ 0 ] ) > 30){
													if (start.coords[0] > stop.coords[ 0 ]){
														if (check && $('.next_item:not(.hide) a').length){
															var el =$('.next_item:not(.hide) a');
															el.addClass('active')
															setTimeout(function(){
																el.removeClass('active');
																HadlerNewItemLoader(el)
																},100)
															check = false; 
															
															if (!$('.nav_item_mobile').hasClass('disable')){
															
																$('.nav_item_mobile').addClass('disable')
															}
															
															onSwipe  = true;
															
														}
													}else {
														if (check && $('.prev_item:not(.hide) a').length){
															var el =$('.prev_item:not(.hide) a');
															el.addClass('active')
															setTimeout(function(){
																el.removeClass('active');
																HadlerNewItemLoader(el)
															},100)
															check = false;
															if (!$('.nav_item_mobile').hasClass('disable')){
																
																$('.nav_item_mobile').addClass('disable')
															}
															
															onSwipe  = true;
														}
														
													}
												}
												
												if (onSwipe && first) {
													if (is_touch_device() && getCookie('swipe') != 1) {
														setCookie('swipe', 1, 3600)
													}
													first = false;
												}
													
												
											});
											
											/* mac  multitouch 
											$(window).mousewheel(function(event, delta) {
						                        
						                       
						                        if (event.deltaX == 1){
						                        	if (check && $('.prev_item:not(.hide) a').length && checkMousewheel){
						                        		checkMousewheel = false;
														var el =$('.prev_item:not(.hide) a');
														el.addClass('active')
														setTimeout(function(){
															el.removeClass('active');
															HadlerNewItemLoader(el)
														},100)
														check = false;
														setTimeout(function(){
															checkMousewheel = true;
														},600)
														if (!$('.navigation_item').hasClass('active')){
															$('.navigation_item').addClass('active')
															$('.nav_item_mobile').addClass('disable')
														}
														
													}
						                        } else if (event.deltaX == -1){
						                        	if (check && $('.next_item:not(.hide) a').length && checkMousewheel){
						                        		checkMousewheel = false;
														var el =$('.next_item:not(.hide) a');
														el.addClass('active')
														setTimeout(function(){
															el.removeClass('active');
															HadlerNewItemLoader(el)
															},100)
														check = false;
														setTimeout(function(){
															checkMousewheel = true;
														},600)
														if (!$('.navigation_item').hasClass('active')){
															$('.navigation_item').addClass('active')
															$('.nav_item_mobile').addClass('disable')
														}
													}

						                        }
						                       
						                    });
						                    
											*/
											
											$(window).bind("popstate", function(e) {
												var  id = location.pathname.split('/')[3];
												if ($('.item_def').attr('id') != 'content_item_'+id )
													location.reload();												
												return false;
											});
										}
							        }
							])
							

							
							$('body').on('keydown', function(e){
								
								if ($('input').is( ":focus" ))
									return true;
								
								if(e.which == 39 ) {
									if (check && $('.next_item:not(.hide) a').length){
										var el =$('.next_item:not(.hide) a');
										el.addClass('active')
										setTimeout(function(){
											el.removeClass('active');
											HadlerNewItemLoader(el)
											},100)
										check = false; 
									}
									return true;
								} else if(e.which == 37 ) {
									if (check && $('.prev_item:not(.hide) a').length){
										var el =$('.prev_item:not(.hide) a');
										el.addClass('active')
										setTimeout(function(){
											el.removeClass('active');
											HadlerNewItemLoader(el)
											},100)
										check = false;
										}
									return true;
								}
							})
							
							/*
							var posX = -1;
							var move = false;
							$('body').on('mousedown', '.wrap_item', function(e){
								posX = e.clientX;
								console.log(posX)
								move = true;
							})
					
							$('body').on('mouseup', function(e){
								
								if ( (e.clientX - posX) >= 100) {
									HadlerNewItemLoader($('.next_item:not(.hide) a'))
								} else if ( (posX - e.clientX ) >= 100) {
									HadlerNewItemLoader($('.prev_item:not(.hide) a'))
								}	
								move = false;
								 $('body .content_item.item_active').removeClass('move').css('left', 'auto')

							})
							$('body').on('mousleave', '.wrap_item', function(e){
								move = false;
								 $('body .content_item.item_active').removeClass('move').css('left', 'auto')

							})
							$('body').on('mousemove', function(e){
								if (!move) return true;
								

								var posMove = posX - e.clientX;
								console.log(posMove);
//								 $('body .content_item.item_active').css({
//									 '-webkit-transition':'ease all 0.3s !important',
//									 '-webkit-transform':'translate(1000px,0px) !important'
//	
//								 })
								
								 $('body .content_item.item_active').addClass('move').css({
								 '-webkit-transition-duration':'0s',
									 'left': -(posMove)+'px',

								 })
								
							});
							*/
						
							function HadlerNewItemLoader(el) {	
								if (!el.length) return false;
								
								
								var new_el = ''; var now_el = ''; var load = true; var new_element = '';
								var href = el.attr('href');
								
								if (el.hasClass('prev')) {
									new_el = 'prev'; now_el = 'next';
									new_element = $('.item_active').prev('.content_item');
								}else if (el.hasClass('next')) {
									new_el = 'next'; now_el = 'prev';
									new_element = $('.item_active').next('.content_item');
								}											
								
								if (!new_element.length){
									LoadNewElement(href, el, new_el, now_el, function(){ })									
								} else {
									var new_item = new_element;
									var bottom_products = new_item.find('.bottom_products');
									
									LoadItemNext(new_item, now_el, new_el, function(){
										$('.wrap_item').css('height', ($('.item_active').height() + $('.item_active .wrap_sizes.recent_block').height() + 40) )
										HandlerCentered(bottom_products);
										setTimeout(function(){ResizeItemBlock()},300)
									})
								}
							}
							
						
							function LoadNewElement(href, el, new_el, now_el, callback) {
								$.ajax({
									type: 'POST',
									url: href,
									beforeSend: function() { el.addClass('loading')	},
									success: function(data) {
										var new_item = $(data).find('.content_item');
																		
										var bottom_products = new_item.find('.bottom_products');
										//bottom_products.addClass('hide')
										if (now_el == 'next') $('.item_active').before(new_item);
										else if (now_el == 'prev') $('.item_active').after(new_item);
										new_item.addClass('cont_item_'+new_el)
										ResizeItemBlock();
										AddAniBield();
										ALoading(new_item.find('.item_block_galery .aloading') ,function(){
											var  nav = $(data).find('.navigation_item');
											$(nav.html()).appendTo($('.navigation_item'));
											if (_OS != 'anyone'){
												$('.message_nav').addClass('disable');
											}
											LoadItemNext(new_item, now_el, new_el, function(){
												ALoading(new_item.find('.other_block .aloading'),function(){
													ResizeItemBlock();
												});
												setTimeout(function(){
													ALoading(new_item.find('.aloading'),function(){
														setTimeout(function(){ResizeItemBlock()},300)
													});
													
												},500)
												if (callback) callback();
											});
										});
										setTimeout(function(){
											HandlerCentered(bottom_products);
										}, 200);
										//bottom_products.removeClass('hide')
									},
									complete: function() {
										
									}
								});
							}
							
							function LoadItemNext(new_item, now_el, new_el, callback){
								$('.wrap_item .nav_item').addClass('hide');
								var id =new_item.attr('id').split('content_item_')[1];
								$('#nav_prev_'+id+', #nav_next_'+id).removeClass('hide');
								
								$('.item_active').find('.item_block').removeClass('aloading').removeClass('a_end')
								$('.item_active').removeClass('item_def').removeClass('item_active').addClass('cont_item_'+now_el);
								new_item.addClass('item_active').removeClass('cont_item_next').removeClass('cont_item_prev');
								
								history.pushState(null, null, new_item.attr('data-href'))
								document.title = new_item.attr('data-title');
								$('.nav_item a').removeClass('loading');
								if (callback) callback();
								check = true;
								initktutilka();
							}
						
						});
						function ResizeItemBlock(){
							$('.others_product').css('width', ($('.wrap_item').width() /2)+'px');
							
							setTimeout(function(){
								$('.wrap_item').css('height', ($('.item_active').height() + $('.item_active .wrap_sizes.recent_block').height() + 40) )
							},300)
							
						}
						
						
					}
				},
				{
					test: $('input.mask_input').length,
					yep: '/js/inputmask.js',
					complete: function() {
						
						if (!$('input.mask_input').length)
							return true;

						$('input.mask_input').each(function(){
							if ($(this).hasClass('phone')){
								$(this).inputmask("+7 (999) 999-99-99");
							}
						})
					}
				},
				{
					test: typeof window.ajaxSubmit == 'undefined',
					yep: '/js/jquery.form.min.js',
					complete: function() {
						console.log('form complete')
						if (!$('#order').length && !$('#call').length) return true;

						$(function(){
							if ($('#order').length){
							
								$('body').on('click', '#resend', function(){
									$('.basket').removeClass('sended');
									EnterEnable = false;
									return false;
								})
								$('body').on('click', '.return_cart', function(){
									$('.basket').removeClass('sended').removeClass('confirm_basket');
									EnterEnable = false;
									return false;
								})
								
								$('body').on('keydown', function(e){
									
									if (EnterEnable && e.which == 13){
										SendOrder();
									}
								})
								
								
								$('body').on('click', '.confirm_btn', function(){
									console.log('confirm_btn click')
									SendOrder();
									return false;
								})
								
								
								function SendOrder(){
										form = $('#order');
										var check = true; 
										
										/*if (!$('.basket').hasClass('confirm_basket') || form.hasClass('sended'))
											return true;*/
											
										form.find('input').each(function(){
												
												if ($(this).val() == ''){
													check = false;
													$(this).addClass('error')
													var curStep = $(this).closest('.basket_step').data('step')
													basketStep.changeStep(curStep);
													console.log('error step '+curStep)
												}
		
												$(this).change(function(){
													if ($(this).val() != ''){
														$(this).removeClass('error')
													}
												})
										})
										$('.sendalert').removeClass('show');
										console.log('form before check')
										if (check) {
											$('.progress_send').addClass('show');
											form.ajaxSubmit({
												success: function (response) {
													data = $.parseJSON(response);
													if (data.error == 0) {
														form.find('input[type=text],textarea').val('');
														form.addClass('sended');
														UpdateBasket();
														
														basketStep.changeStep(0);
														
														console.log('orderdone');
														yaCounter24162886.reachGoal('orderdone');
														
													} 
														
														$('.success_form p').html(data.message);
														$('.basket').addClass('sended')
													
												},
												error:function(response){
													data = $.parseJSON(response);
													$('.success_form p').html(data.message);
													$('.basket').addClass('sended')
												},
												complete:function(){
													$('.progress_send').removeClass('show');
												}
											})	
										}
									}
								}
								if ($('#call').length){
									$('#call').on('click', '.green_btn', function(){
										SendCall();
										return false;
									})
									
									function SendCall(){
										form = $('#call');
										var check = true; 
										
										if (form.hasClass('sended'))
											check = false;
										
										form.find('input').each(function(){
												
												if ($(this).val() == ''){										
													check = false;
													$(this).addClass('error')
												}
		
												$(this).change(function(){
													if ($(this).val() != ''){
														$(this).removeClass('error')
													}
												})
										})
										
										if (check) {
											$('.call_progress').addClass('show');
											form.ajaxSubmit({
												success: function (response) {
													data = $.parseJSON(response);
													if (data.error == 0) {
														form.find('input:not(.green_btn)').val('');
														form.addClass('sended');
														
													} 
														$('.call_message').html(data.message);
														
												},
												error:function(response){
													data = $.parseJSON(response);
													$('.success_form p').html(data.message);
													$('.basket').addClass('sended')
												},
												complete:function(){
													$('.call_progress').removeClass('show');
												}
											})	
										}
									}
								}
								
							})
						}
				},
				
				
		 ]);
	$('a[href^=#]').on('click', function(e) {
		e.preventDefault();
		
		var href = $(this).attr('href');
		
		$('html, body').animate({
			scrollTop: $(href).offset().top
		}, 500);
	});
	basketStep.init();
})






basketStep = {
	$basket: $('.basket'),
	curStep: 1,
	stepsNum: 1,
	init: function() {
		this.stepsNum = this.$basket.find('[data-step]').last().data('step');
		console.log(this.stepsNum);
		_this = this;
		$('[data-nav]').on('click', function(e) {
			e.preventDefault();
			//console.log(this)
			_this.curStep = $(this).data('nav') == 'next' ? (_this.curStep == _this.stepsNum ? _this.stepsNum : _this.curStep+1) : (_this.curStep == 1 ? 1 : _this.curStep-1)
			//this.curStep = $(this).data('step')
			//console.log(_this.curStep)
			_this.changeStep();
		})
	},
	changeStep: function(step) {
		if (typeof step !== 'undefined') {
			this.curStep = step
		}
		this.$basket.find('.basket_step[data-step='+this.curStep+']').addClass('_active').siblings().removeClass('_active');
		if (this.curStep > 1) {
			$('.return_cart').addClass('_active')
		} else {
			$('.return_cart').removeClass('_active')
		}
	},
}