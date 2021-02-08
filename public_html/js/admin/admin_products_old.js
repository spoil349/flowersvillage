$(function(){
//	
	
/// ///////////////////////////////// ------------PRODUCT LIST --------------------------------------------------	
	$("select").chosen();
	
	
	$('#products tbody').sortable({
		revert: 100,
		update: function(){
				var sort = 1;
		  		var sort_line = '';
				 $( "#products tbody tr" ).each(function(){
					 var id = $(this).attr('id').split('_')[1];
					 sort_line = sort_line+'|'+id+'-'+sort;
					 sort++;
				 })
				 $.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=sort&sort_line='+sort_line+'&f=products',
					  success: function(data){
					  }
				});				
		}
	});
	
	$('#products tbody tr').disableSelection();
	
	
/// ///////////////////////////////// ------------ ONE PRODUCT --------------------------------------------------	
		
	$('#hot_checkbox').change(function(){
		var id = $('h1').attr('id').split('product_')[1];
		if ($(this).hasClass('check_on')){ 
			var value = 0;
			$(this).removeClass('check_on')
		} else{
			var value = 1;
			$(this).addClass('check_on')
		}
		 $.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&f=products&field=hot&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
	})	
	
	
$('.show_action_category input').change(function(){
	
	var id = $(this).attr('id').split('__')[1];
	
	if ($(this).hasClass('enable_show')) {
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&id='+id+'&f=actions_category_product&value=0&field=visibly',
			  success: function(data){
			  }
		});
		$(this).removeClass('enable_show');
	}else {
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&id='+id+'&f=actions_category_product&value=1&field=visibly',
			  success: function(data){ 
			  }
		});
		$(this).addClass('enable_show');
	}
})	
	
$('#change_category').change(function(){
	var id = $('h1').attr('id').split('product_')[1];	
	value = $(this).val();
	var last_category = $(this).attr('type').split('lastcat_')[1];	
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&id='+id+'&f=products&value='+value+'&field=cat_id&last_value='+last_category,
		  success: function(data){
			  location.reload(); 
		  }
	});
});	

$('#action_products').change(function(){
	var id = $('h1').attr('id').split('product_')[1];	
	value = $(this).val();
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editaction_toproduct&id='+id+'&&value='+value,
		  success: function(data){
		  }
	});
})


$('.one_feature_category input, .one_feature_category select, .one_feature_category textarea').change(function(){
	var id = $(this).attr('id').split('features_products_')[1];
	var value = $(this).val();
	if ($(this).hasClass('multiselect')){

		if ($(this).val() != null)
			value = value.toString().split(',').join('|');
		else
			value = '';
	} 
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=value&id='+id+'&value='+value+'&f=features_products',
		  success: function(data){}
	});
	
})	
	
$('input, textarea, select').click(function(){
		$(this).addClass('input_selected_click');
})

$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
});


$('.delete_show_product_block .delete_product').click(function(){
		
		var id = $('h1').attr('id').split('product_')[1];	
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=products',
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/products/list/"},500)
	})
//		
	$('.delete_show_product_block .show_product').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('product_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=products',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть товар').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('product_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=products',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать товар').addClass('no_visibly');
		}
		
	})
	
	$( ".product_img_block" ).sortable({
		revert: 100,
		update: function( event, ui ) { 
				AutoSaveImages($(".product_img_block"));
			}
		});
	
	$( ".product_others_block " ).sortable({
		revert: 100,
		update: function( event, ui ) {
				AutoSaveOtherProducts($('.product_others_block'));
			}	
		});
	$( ".one_preview_img_product, .one_preview_other_img_products"  ).disableSelection();
	
	$('input, textarea, select').click(function(){
		$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
	});
	$('.product_field').change(function(){
		ChachgeField($(this));
	});

	$('.button_add_img, #img_button_add_img').click(function(){
		fileBrowse();
	})	
	
	
	$('#add_img_input').change(function() {
		      displayFiles(this.files);
		      $('.product_img_block .message_img').remove();
	});
	
	var count_img = 1000;
	function displayFiles(files) {	
			    $.each(files, function(i, file) {
			    	count_img++;
			    	var reg = /\.(?:png|gif|jpe?g)$/i;
			    	if (!reg.test(file.name)) {
			    		//return true;
			    	} else {
			    		var li = $('<div class="one_preview_img_product" id="img'+count_img+'" />').appendTo($('.product_img_block'));
			    		var img_div =  $('<div class="one_preview_div_img preview'+count_img+'"  style="background:url(/img/ajax-loader.gif) no-repeat center center; background-size: 20px 20px; text-align:center;"/>').appendTo(li);
			    		var img = $('<img height="84" class="loading" style="display:none;" />').appendTo(img_div);
			    		var del = $('<span class="del" id="del'+count_img+'"></span>').appendTo(li);
			    		li.get(0).file = file;
			    		
			    		var reader = new FileReader();
			    		reader.onload = (function(aImg) {
				        return function(e) {
				        
				        	var path = $('h1').attr('type');
					        uploadFile(file, '/post_file.php?f='+path+'&flag=product', img, li);
					        			
				        };
				      })(img);
				      
				      reader.readAsDataURL(file);
			    	}
			    });	  	
	} 
	

	$(".one_preview_img_product , .one_preview_other_img_products ").mouseover(function(){
		$(this).find(".del").css("display", "block");
	})
	$(".one_preview_img_product , .one_preview_other_img_products ").mouseout(function(){
		$(this).find(".del").css("display", "none");
	})
	
	$('.one_preview_img_product ').find('.del').click(function(){
		$(this).parent(".one_preview_img_product").fadeOut(function(){
			$(this).remove();
			 AutoSaveImages($('.product_img_block'));
		});
	})
       
		
    $('.one_preview_other_img_products .del').click(function(){
		$(this).parent(".one_preview_other_img_products").fadeOut(function(){
			$(this).remove();
			AutoSaveOtherProducts($('.product_others_block'));
		});
	})
    
    
    
$('.button_add_other_product, #img_button_add_other_product').click(function() {
		
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
		$.ajax({
			  url: '/admin/update/productpopup',
			  type: 'POST',
			  data: 'stat=start&cat=',
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
								  url: '/admin/update/productpopup',
								  type: 'POST',
								  data: 'stat=update&cat_id='+cat_id,
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
	
	
})	


function ChachgeField(el) {
		
		var id = el.attr('id').split('__')[1];
		var field = el.attr('id').split('__')[0];
		if (id != '' && id != 'new'){
			var value = el.val();

			$.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=products',
					  success: function(data){}
				});
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
	
	


function updateRating(val) {
	
	var id = $('.rating').attr('id').split('rating_')[1];

	$.ajax({
		  url: '/ajax/products',
		  type: 'POST',
		  data: 'stat=edit_field&field=rating&id='+id+'&value='+val,
		  success: function(data){
		  }
	});
	
	
	
}

function fileBrowse() {
    var browseField = document.getElementById("add_img_input");
    browseField.click();
}



function uploadFile(file, url,img, li) {
	  var name = new Date().getTime()+'.jpg';
	  var reader = new FileReader();
	  reader.onload = function() {    
	    var xhr = new XMLHttpRequest();    
	    
	    xhr.open("POST", url);
	    var boundary = "xxxxxxxxx";    
	    // Устанавливаем заголовки
	    xhr.setRequestHeader("Content-Type", "multipart/form-data, boundary="+boundary);
	    xhr.setRequestHeader("Cache-Control", "no-cache");    
	    // Формируем тело запроса
	    var body = "--" + boundary + "\r\n";
	    body += "Content-Disposition: form-data; name='myFile'; filename='" + name + "''\r\n";
	    body += "Content-Type: application/octet-stream\r\n\r\n";
	    body += reader.result + "\r\n"; 
	    body += "--" + boundary + "--\r\n";
	    if(xhr.sendAsBinary) {
	    
	      // только для firefox
	      xhr.sendAsBinary(body);
	    } else {
	      // chrome (так гласит спецификация W3C)
	    	// chrome (так гласит спецификация W3C)
	    	var ui8a = new Uint8Array(body.length);
	        for (var i = 0; i < body.length; i++) {
	                  ui8a[i] = (body.charCodeAt(i) & 0xff);
	        }
	        xhr.send(ui8a.buffer);
	    }
	    
	   xhr.onreadystatechange = function () {
		   		
		      if (this.readyState == 4) {
		        if(this.status == 200) {
		         
		        	var img_src = this.responseText;
		        	
		        	if( img.attr('src', '/uploads/81x84/'+img_src)  && img.load() && img.show() && img.removeClass('loading')){      	
	        	    	
		        		img.parent('.one_preview_div_img').parent('.one_preview_img_product').mouseover(function(){
							$(this).find(".del").css("display", "block");
						})
						img.parent('.one_preview_div_img').parent('.one_preview_img_product').mouseout(function(){
							$(this).find(".del").css("display", "none");
						})
				          
						img.parent('.one_preview_div_img').parent('.one_preview_img_product').find('.del').click(function(){
							$(this).parent(".one_preview_img_product").fadeOut(function(){
								$(this).remove();
								 AutoSaveImages(line_preview);
							});
						})
				        var line_preview = $('.product_img_block');
				       if(line_preview.find('.one_preview_img_product div .loading').length == 0){ 
				    	   AutoSaveImages(line_preview); 
				       }
				    
	        	   }
		        } else {
		        	 li.remove()
		        }
		        	
		      }
		  };
	  };
	  // Читаем файл
	  reader.readAsBinaryString(file); 
}


function  setOtherProduct() {
	
	$('.one_preview_other_img_products').each(function() {
			 var selectId = $(this).attr('id').split('other_')[1]
			 $('.popup_right #'+selectId).addClass('product_select');
	});
	
	var img = '';
	$('.popup_one_products').click(function() {		
		if($(this).hasClass('product_select')){
			$(this).removeClass('product_select');
			var id = $(this).attr('id');
			$('#other_'+id).remove();
			AutoSaveOtherProducts($('.product_others_block'));
				
		}else {
			$(this).addClass('product_select')
			var id = $(this).attr('id');
			var img_src = $(this).find('img').attr('src');
			var li = $('<div id ="other_'+id+'" class="one_preview_other_img_products" />').appendTo($('.product_others_block'));
		    var div = $('<div class="one_preview_div_img" />').appendTo(li);
			var img = $('<img  width="81"/>').appendTo(div);
		    var del = $('<span id ="del_'+id+'" class="del"></span>').appendTo(li);
		    del.hide();
		    regex = /\/[^/]+\/[^/]+\.\w{3,4}/ ;
		    img.attr('src', '/uploads/81x84/'+regex.exec(img_src));
		    img_w = img.width();
			    
			li.mouseover(function(){
				var id = $(this).attr('id');
				var count_id = id.split('other_')[1];
				$('#del_'+count_id).css('display','block');
			});
			li.mouseout(function(){
			   	var id = $(this).attr('id');
				var count_id = id.split('other_')[1];
				$('#del_'+count_id).css('display','none');
			});
				
			del.click(function(){
				var id = $(this).attr('id');
				var count_id = id.split('del_')[1];
				$('#other_'+count_id).remove();
				AutoSaveOtherProducts($('.product_others_block'));
			});
			
			AutoSaveOtherProducts($('.product_others_block'));
		}
			
			 
			 
	});
	  
}


function AutoSaveImages(line_preview){
	
	var id = $('h1').attr('id').split('product_')[1];	
	var line_img = '';
	line_preview.find('.one_preview_img_product').each(function() {			
        	$(this).find('img').each(function() {
    			var img_src = $(this).attr('src')
    			regex = /\/[^/]+\/[^/]+\.\w{3,4}/ ;
    			line_img = line_img+'|'+ regex.exec(img_src);
    		});
	});
	
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=img&value='+line_img+'&id='+id+'&f=products',	    
		  success: function(data){
		  }
	});
}


function AutoSaveOtherProducts(line_preview){
	
	var id = $('h1').attr('id').split('product_')[1];		
	var line_img_other = '';
	line_preview.find('.one_preview_other_img_products ').each(function() {			
        if (!$(this).hasClass('delete')){
        	$(this).each(function() {
    			var other_id = $(this).attr('id').split('other_')[1];			
    			var other_img_src = $(this).find('img').attr('src');
    			line_img_other = line_img_other+'|'+other_id+':'+other_img_src;
    		});
        }
	});
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=others&value='+line_img_other+'&id='+id+'&f=others_products',	    
		  success: function(data){
		  }
	});
}

function updateRating(val) {
	
	var id = $('h1').attr('id').split('product_')[1];	

	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=rating&id='+id+'&value='+val+'&f=products',
		  success: function(data){
		  }
	})
}