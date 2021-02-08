$(function(){
//	
	
	$(document).ready(function(){
	    $(".orders_menu").sticky({topSpacing:-20});
	    $('#undefined-sticky-wrapper').css('position','absolute')
	});
	
	$('.orders table').tablesorter({sortInitialOrder:"desc", sortMultisortKey:"ctrlKey"});
	
	$("select").chosen();
//	
	$('.orders table tbody tr').mouseover(function(){
		$(this).find('.panel_order').css('opacity', '1');
	})
	$('.orders table tbody tr').mouseout(function(){
		$(this).find('.panel_order').css('opacity', '0.3');
	})
//
	$('.one_select_product').mouseover(function(){
		$(this).find('.del').css('opacity', '1');
	})
	$('.one_select_product').mouseout(function(){
		$(this).find('.del').css('opacity', '0.3');
	})
//	
//	

	$.datepicker.regional['ru'] = {
                closeText: 'Закрыть',
                prevText: '&#x3c;Пред',
                nextText: 'След&#x3e;',
                currentText: 'Сегодня',
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                'Июл','Авг','Сен','Окт','Ноя','Дек'],
                dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                dateFormat: 'dd.mm.yy', firstDay: 1,
                isRTL: false};
	$('.date_delivery').datepicker($.datepicker.regional['ru'], { dateFormat: "yy-mm-dd" });
	
	
	$('input, textarea, select').click(function(){
		$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
	});
	$('input, textarea, select').change(function(){
		ChachgeField($(this));
	});
	
	$(".delete_show_product_block .delete_order").click(function(){
		var id = $('h1').attr('id').split('order_')[1];
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&field=status&id='+id+'&value=deleted&f=orders',
			  success: function(data){
				  location.reload();
			  }
		});
	})
	
	$('.panel_del').click(function(){
		
		var id = $(this).attr('id').split('del')[1]
		$.ajax({
			  url: '/ajax/orders',
			  type: 'POST',
			  data: 'stat=delete&id='+id,
			  success: function(data){
			  }
		});
		$('#order_'+id).fadeOut(function(){$(this).remove();})
	})
	$('.del_orders span').click(function(){
		
		var id = $(this).attr('id').split('del')[1];
		var cat = $(this).attr('type');
		$.ajax({
			  url: '/ajax/orders',
			  type: 'POST',
			  data: 'stat=delete&id='+id,
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/orders/"+cat},500)
	})

	
	$('.one_select_product .del').click(function(){
		var el_id = $(this).attr('id').split('product_del')[1];
		$('#product'+el_id).fadeOut(function(){
			$(this).remove();
			UpdateProductsInOrder();
		});
	})
	
	
/////	POPUP OTHER PRODUCTS

	$('.view_order_products .add_products').click(function() {
		
		$('.popup_wait').show();
		var opts = {
				  lines: 13, // The number of lines to draw
				  length: 7, // The length of each line
				  width: 4, // The line thickness
				  radius: 10, // The radius of the inner circle
				  corners: 1, // Corner roundness (0..1)
				  rotate: 0, // The rotation offset
				  color: '#000', // #rgb or #rrggbb
				  speed: 1, // Rounds per second
				  trail: 60, // Afterglow percentage
				  shadow: false, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: 'auto', // Top position relative to parent in px
				  left: 'auto' // Left position relative to parent in px
				};
		var target = document.getElementById('popup_wait');
		var spinner = new Spinner(opts).spin(target);
		
		var cat_id = $('.view_order_products').attr('id').split('last_cat')[1];

		$.ajax({
			  url: '/ajax/popup',
			  type: 'POST',
			  data: 'stat=start&cat='+cat_id+'&size=1',
			  success: function(data){
				  if ($('.popup_content').html(data)){
						 $('.popup_wait').hide();
						 setOtherProduct();
						 
						
						 
						 $('.popup_content .one_left_menu').click(function() {
							  var cat_id = $(this).attr('id');
								
							  $('.one_left_menu').removeClass('menu_select');
							  $(this).addClass('menu_select');
							  
							  $('.popup_content .popup_right').css('opacity', '0.5');
							  $('.popup_wait').show();
							  $.ajax({
								  url: '/ajax/popup',
								  type: 'POST',
								  data: 'stat=update&cat_id='+cat_id+'&size=1',
								  success: function(data){
									  		
									  if ($('.popup_content .br').remove() && $('.popup_right').remove() && $(data).appendTo('.popup_content')){
											 $('.popup_wait').hide();
											 setOtherProduct();
									  } 
									  
									
								  }
							  });
						  });
						 
				  } 
				  
				
			  }
		});
		
		$('#addimg_other_popup').fadeIn();
	});
	
	$('.popup_del').click(function() {
		$('#addimg_other_popup').fadeOut();
	});
	
	function  setOtherProduct() {
		
		var img = '';
		$('.popup_one_products .button_add_product').click(function() {		
			var id = $(this).attr('id').split('add')[1];
			var name = $('.popup_right #'+id+' .popup_one_products_name').html();
			var size = $('#size'+id).val();
			var size_html = $('#size'+id).html();
			var price = $('#price'+id).html();
			if (!document.getElementById('product'+size+id+'')){
				var li = $('<tr id="product'+size+id+'" class="one_select_product" type="prod'+id+'" />').appendTo('.view_order_products tbody');
				$('<td id="product_name'+size+id+'" class="one_select_product_name">'+name+'</td>').appendTo(li);
				$('<td id="product_price_one'+size+id+'" class="one_select_product_price_one"><span>'+price+'</span> р</td>').appendTo(li);
				$('<td id="product_size'+size+id+'" class="one_select_product_size"><select class="one_product_select">'+size_html+'</select></td>').appendTo(li);
				li.find('.one_select_product_size select').val(size);
				$('<td id="product_quantity'+size+id+'" class="one_select_product_quantity"><input  class="one_product_input" type="text" value="1"> шт</td>').appendTo(li);
				$('<td id="product_price'+size+id+'" class="one_select_product_price"><span>'+price+'</span> р</td>').appendTo(li);
				$('<td id="product_del'+size+id+'" class="del"><span><img src="/images/del.png"></span></td>').appendTo(li);				 
				UpdateProductsInOrder();
				
				li.find('input').change(function(){ChachgeField($(this));});
				li.find('textarea').change(function(){ChachgeField($(this));});
				li.find('select').change(function(){ChachgeField($(this));});

				li.find('.del').click(function(){
					var el_id = $(this).attr('id').split('product_del')[1];
					$('#product'+el_id).fadeOut(function(){
						$(this).remove();
						UpdateProductsInOrder();
					});
				})
				
				li.mouseover(function(){
					$(this).find('.del').css('opacity', '1');
				})
				li.mouseout(function(){
					$(this).find('.del').css('opacity', '0.3');
				})
				
				$('#addimg_other_popup').fadeOut();
				
			} else {
			}
		});
		  
	}
	
	
	$('.button_add_neworder_complete ').click(function(){
		var name = $('#namenew').val();
		var phone = $('#phonenew').val();
		var adress = $('#adressnew').val();
		var comment = $('#commentnew').val();
		var status = $('#statusnew').val();
		var email = $('#emailnew').val();
		var admin_comment = $('#admin_commentnew').val();
		var discount = $('#discountnew').val();
		
		//alert('stat=add&name='+name+'&phone='+phone+'&adress='+adress+'&comment='+comment+'&status='+status+'&email='+email+'&admin_comment='+admin_comment+'&discount='+discount);
		$.ajax({
			  url: '/ajax/orders',
			  type: 'POST',
			  data: 'stat=add&name='+name+'&phone='+phone+'&adress='+adress+'&comment='+comment+'&status='+status+'&email='+email+'&admin_comment='+admin_comment+'&discount='+discount,
			  success: function(data){
				 if(data != ''){
					 var order_id = $('.one_discount_input input').attr('id', 'discount'+data);
					 if (UpdateProductsInOrder()) {
						 window.location = "/admin/orders/new"
					 }
				 } 
			  }
		});
	});
	
});

function  UpdateProductsInOrder() {
	var arr_product_id = new Array();
	var all_price = 0;
	var discount_price = 0;
	var discount = $('.one_discount_input input').val();
	var order_id = $('.one_discount_input input').attr('id').split('discount')[1];
	var ii = 0;
	$('.view_order_products tbody .one_select_product').each(function(){
		var size = $(this).find('.one_select_product_size select').val();
		var id =  $(this).attr('type').split('prod')[1];
		var quantity = $(this).find('.one_select_product_quantity input').val();
		var price = $(this).find('.one_select_product_price_one span').html();
		arr_product_id[ii] = id+':'+size+':'+quantity+':'+addSpace(price);
		ii++;
		all_price = all_price + eval(addSpace(price));
	})
	var line_product_id = arr_product_id.join('|'); 
	
	discount_price = Math.floor(all_price - all_price/100*eval(discount));

	//alert('stat=update_products&id='+order_id+'&price='+all_price+'&discount_price='+discount_price+'&products_id='+line_product_id)
	$('.product_price span').html(all_price+' рублей');
	$('.product_allprice span').html(discount_price+' рублей');
	$.ajax({
		  url: '/ajax/orders',
		  type: 'POST',
		  data: 'stat=update_products&id='+order_id+'&price='+all_price+'&discount_price='+discount_price+'&products_id='+line_product_id,
		  success: function(data){
		  }
	});
	
	return true;
}

function ChachgeField(el){
	var id = $('h1').attr('id').split('order_')[1];	
	var field = el.attr('name').split('order_')[1];
	
	if (el.hasClass('order_checkbox')) {
		if (!$('input[name="'+el.attr('name')+'"]:checked').length)
			var value = 0;
		else
			var value = $('input[name="'+el.attr('name')+'"]:checked').val();
	} else{
		var value = el.val();
	}
	
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=orders',
		  success: function(data){
		  }
	});
}

function ChachgeField_Old(el){
	if (!el.hasClass('one_product_select') && !el.hasClass('one_product_input')){ 
		var id = el.attr('id').split(''+el.attr('name')+'')[1];
		var field = el.attr('name');
		if (id != '' && id != 'new'){
			var value = el.val();
			
			$.ajax({
				  url: '/ajax/orders',
				  type: 'POST',
				  data: 'stat=edit_field&field='+field+'&id='+id+'&value='+value,
				  success: function(data){
					  if (field == 'discount'){
						  $('.product_allprice span').html(data+' рублей');
					  }
					 
					 
				  }
			});
		 } else {
			 if (field == 'discount'){
				var value = el.val();
				var price = $('.product_price span').html().split(' рублей')[0];
				var discount_price =  Math.floor(eval(price) - eval(price)/ 100 * eval(value)); 
				$('.product_allprice span').html(discount_price+' рублей') 
			 }
			 
		 }
	} else {
		if (el.hasClass('one_product_input')){
			var quantity = el.val();
			var id = el.parent(".one_select_product_quantity").attr('id').split('product_quantity')[1];
			if ( eval(quantity) == 0){
				$('#product'+id).fadeOut(function(){
					el.remove();
					UpdateProductsInOrder();
				});
			}else {
				
				var price_one = $('#product_price_one'+id+' span').html();
				var price_prod = eval(addSpace(price_one))*quantity;
				$('#product_price'+id+' span').html(price_prod);
				UpdateProductsInOrder();
			}
		} else {UpdateProductsInOrder();}
		
	}
}


function PLtospace(str) {
		var VRegExp = new RegExp(/[\+]+/g);
		var VResult = str.replace(VRegExp, ' ');
		return VResult
}
function PLtoNonspace(str) {
		var VRegExp = new RegExp(/[\+]+/g);
		var VResult = str.replace(VRegExp, '');
		return VResult
}
function addSpace(str) {
		var VRegExp = new RegExp(/[ ]+/g);
		var VResult = str.replace(VRegExp, '');
		return VResult
}
	
function ToSpace(str) {
	return  str.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')
}
