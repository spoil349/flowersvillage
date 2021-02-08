$(function(){
	
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
            dateFormat: 'yy-mm-dd', firstDay: 1,
            isRTL: false};
   

	$('.calendar_date').datepicker( $.datepicker.regional['ru'],{ dateFormat: "dd-mm-yy" });
	$('.date_bg').click(function(){$('.calendar_date').datepicker( "show" ); })
	
	$('input, textarea, select').click(function(){
	if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
		$(this).addClass('input_selected_click');
	})
	
	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});


	
	
	if ($('#actions_ts_checkbox').hasClass('available_checkbox')) {
		$('.datetime_action').hide();
	}
	
	$('#actions_ts_checkbox').click(function(){
		if ($(this).hasClass('available_checkbox')) {
			$(this).removeClass('available_checkbox');
			$('.datetime_action').slideDown(200);
		} else {
			$(this).addClass('available_checkbox');
			$('.datetime_action').slideUp(200);
			var id = $('h1').attr('id').split('action_')[1];
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=datetime&value=0&id='+id+'&f=banners',
				  success: function(data){
				  }
			});
		}
	})
	
	$('.one_type input').change(function(){
		
		var id = $('h1').attr('id').split('action_')[1];
		var value = $(this).val();
		
		 $.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&f=banners&field=type&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
		
	})
	
	
	
	$('h1 input').change(function(){
		var id = $('h1').attr('id').split('action_')[1];
		var value = $(this).val();
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&f=banners&field=name&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
	})
	
	
	$('#actions_categories').change(function(){
		var id = $('h1').attr('id').split('action_')[1];
		var value = $(this).val();
		var type = $('input[name="chose_type_feature"]:checked').val();
		//alert('stat=edit_actions_categories&field=categories&value='+value+'&id='+id+'&type='+type);
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=edit_actions_categories&field=categories&value='+value+'&id='+id+'&type='+type,
			  success: function(data){
			  }
		});
	})
	
	$('#actions_value_disc').change(function(){
		var id = $('h1').attr('id').split('action_')[1];
		var value = $(this).val();
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&field=value&value='+value+'&id='+id+'&f=banners',
			  success: function(data){
			  }
		});
	})
	
	
	$('.datetime_action input').change(function(){
		var YMD = $('#actions_ts_date').val();
		var hourse = $('#actions_ts_hourse').val();
		var min = $('#actions_ts_min').val();
		if (YMD != '' && hourse != '' && min != ''){
			var id = $('h1').attr('id').split('action_')[1];
			
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=datetime&value='+YMD+' '+hourse+':'+min+'&id='+id+'&f=banners',
				  success: function(data){
				  }
			});
		}
	})
	
	$('.delete_feature_block .delete_action').click(function(){
		
		var id = $('h1').attr('id').split('action_')[1];	
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=actions',
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/actions/list/"},500)
	})
//		
	$('.delete_feature_block .show_action').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('action_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=banners',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть свойство').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('action_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=banners',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать свойство').addClass('no_visibly');
		}
		
	})
	
	$('.action_preview_border').click(function(){
		 var browseField = document.getElementById("preview_img");
		 browseField.click();
	})	
	
	$('#preview_img').change(function() {
		var block_img = $('.action_preview')
		var width = block_img.attr('data-size').split('x')[0]
		var height =block_img.attr('data-size').split('x')[1]
	    displayFiles(this.files, width, height, block_img);
	});
	
	
	$('html').bind({
	    
	    dragover: function(e) {
	    	e.stopPropagation();
		    e.preventDefault();
		    $('.action_preview_border').addClass('drag')
		    
	    	 
	      return false;
	    },
	    drop: function(e) {
	    	e.stopPropagation();
		    e.preventDefault();
	    	var dt = e.originalEvent.dataTransfer;
	    	if (dt.files.length > 0){
	    		var block_img = $('.action_preview')
	    		var width = block_img.attr('data-size').split('x')[0]
	    		var height =block_img.attr('data-size').split('x')[1]
	    		displayFiles(dt.files, width, height, block_img);
	    	}
	    	$('.action_preview_border').removeClass('drag')
	    	
	    	
	      return false;
	    }
	});
	$('html').bind({	
		dragleave: function(e) {
		    e.stopPropagation();
		    e.preventDefault();
		    console.log('leave');
		    $('.action_preview_border').removeClass('drag')
		}
	});
	
	$('.action_img_border').click(function(){
		 var browseField = document.getElementById("action_img");
		 browseField.click();
	})	
	
	$('#action_img').change(function() {
		var block_img = $('.action_img')
		var width = block_img.attr('data-size').split('x')[0]
		var height =block_img.attr('data-size').split('x')[1]
	    displayFilesImg(this.files, width, height, block_img);
	});
	
	$('#action_hot_checkbox').change(function(){
		var id = $('h1').attr('id').split('action_')[1];
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
			  data: 'stat=editfield&f=banners&field=hot&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
	})
	
	$('.action_field').change(function(){
		ChachgeField($(this));
	});


	$(".one_preview_img_product , .one_preview_other_img_products ").mouseover(function(){
		$(this).find(".del").css("display", "block");
	})
	$(".one_preview_img_product , .one_preview_other_img_products ").mouseout(function(){
		$(this).find(".del").css("display", "none");
	})
	
	$('.one_preview_img_product ').find('.del').click(function(){
		$(this).parent(".one_preview_img_product").fadeOut(function(){
			$(this).remove();
			 AutoSaveImages($('.action_preview'));

		});
	})

function ChachgeField(el) {
	var value = '';
	var id = $('h1').attr('id').split('action_')[1];
	var field = el.attr('id').split('__')[0];
	if (id != '' && id != 'new'){
		value = el.val();
	if (field == 'uri'){
		value = value.toLowerCase();
	}
	if (field == 'plashka' && !el.is(':checked')){
		value = 0;
	}
		
		$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=banners',
				  success: function(data){}
			});
	}
}
var count_img = 1000;
function displayFiles(files, width, height, block_img) {	
    
		file = files[0];
    	var reg = /\.(?:png|gif|jpe?g)$/i;
    	if (!reg.test(file.name)) {
    		alert('Неправельный формат файла возможные форматы (JPG, JPEG, PNG, FIG)')
    	} else {
    		var li = $('<div class="one_preview_img_product float" id="img'+count_img+'" />');
			$('.action_preview_border').before(li);
    		var img_div =  $('<div class="one_preview_div_img preview'+count_img+'"  style="background:url(/img/ajax-loader.gif) no-repeat center center; background-size: 20px 20px; text-align:center;"/>').appendTo(li);
    		var img = $('<img class="loading" style="display:none;" />').appendTo(img_div);
    		var del = $('<span class="del" id="del'+count_img+'"></span>').appendTo(li);

    		var id = $('h1').attr('id').split('action_')[1];	
	        uploadFile(file,img, width, height);
	        
    	} 	
} 
function displayFilesImg(files, width, height, block_img) {	
    
	file = files[0];
	var reg = /\.(?:png|gif|jpe?g)$/i;
	if (!reg.test(file.name)) {
		alert('Неправельный формат файла возможные форматы (JPG, JPEG, PNG, FIG)')
	} else {
		var li = $('<div class="one_preview_img_product float" id="img'+count_img+'" />');
		$('.action_img .one_preview_img_product').remove();
		$('.action_img_border').before(li);
		var img_div =  $('<div class="one_preview_div_img preview'+count_img+'"  style="background:url(/img/ajax-loader.gif) no-repeat center center; background-size: 20px 20px; text-align:center;"/>').appendTo(li);
		var img = $('<img class="loading" style="display:none;" />').appendTo(img_div);
		var del = $('<span class="del" id="del'+count_img+'"></span>').appendTo(li);

		var id = $('h1').attr('id').split('action_')[1];	
		uploadFileImg(file,img, width, height);
        
	} 	
} 

function uploadFile(file, img, width, height) {

	
	  var name = new Date().getTime()+'.jpg';
	  var reader = new FileReader();
	  reader.onload = function() {    
	    var xhr = new XMLHttpRequest();    
	    
	    xhr.open("POST", '/admin/banners/addimg?width='+width+'&height='+height);
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
		        	
		        	if( img.attr('src', '/uploads/'+width+'x'+height+'/'+img_src)  && img.load() && img.show() && img.removeClass('loading')){      		        	    	
		        		 AutoSaveImages($('.action_preview'));

				    	   
				    	   $(".one_preview_img_product , .one_preview_other_img_products ").mouseover(function(){
				    			$(this).find(".del").css("display", "block");
				    		})
				    		$(".one_preview_img_product , .one_preview_other_img_products ").mouseout(function(){
				    			$(this).find(".del").css("display", "none");
				    		})
				    		
				    		$('.one_preview_img_product ').find('.del').click(function(){
				    			$(this).parent(".one_preview_img_product").fadeOut(function(){
				    				$(this).remove();
				    				 AutoSaveImages($('.action_preview'));

				    			});
				    		})

				       }
				    
	        	   } 
		        }	
		  };
	  };
	  // Читаем файл
	  reader.readAsBinaryString(file); 
}

function uploadFileImg(file, img, width, height) {
	
	  var name = new Date().getTime()+'.jpg';
	  var reader = new FileReader();
	  reader.onload = function() {    
	    var xhr = new XMLHttpRequest();    
	    
	    xhr.open("POST", '/admin/banners/addimg?width='+width+'&height='+height);
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
		        	
		        	if( img.attr('src', '/uploads/'+width+'x'+height+'/'+img_src)  && img.load() && img.show() && img.removeClass('loading')){      		        	    	
		        		 AutoSaveImages($('.action_preview'));
	    				 AutoSaveImages($('.action_img'));
				    	   
				    	   $(".one_preview_img_product , .one_preview_other_img_products ").mouseover(function(){
				    			$(this).find(".del").css("display", "block");
				    		})
				    		$(".one_preview_img_product , .one_preview_other_img_products ").mouseout(function(){
				    			$(this).find(".del").css("display", "none");
				    		})
				    		
				    		$('.one_preview_img_product ').find('.del').click(function(){
				    			$(this).parent(".one_preview_img_product").fadeOut(function(){
				    				$(this).remove();
				    				 AutoSaveImages($('.action_preview'));
				    				 AutoSaveImages($('.action_img'));
				    			});
				    		})

				       }
				    
	        	   } 
		        }	
		  };
	  };
	  // Читаем файл
	  reader.readAsBinaryString(file); 
}


});	

function AutoSaveImages(line_preview){
	
	var id = $('h1').attr('id').split('action_')[1];	
	var line_img = '';
	line_preview.find('.one_preview_img_product').each(function() {			
        	$(this).find('img').each(function() {
    			var img_src = $(this).attr('src')
    			regex = /\/[^/]+\/[^/]+\.\w{3,4}/ ;
    			line_img = line_img+'|'+ regex.exec(img_src);
    		});
	});

	if (line_preview.hasClass('action_img'))
		field = 'img';
	if (line_preview.hasClass('action_preview'))
		field = 'preview';
	
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field='+field+'&value='+line_img+'&id='+id+'&f=banners',	    
		  success: function(data){
		  }
	});
}

function fileBrowse() {
    var browseField = document.getElementById("add_img_input");
    browseField.click();
}
