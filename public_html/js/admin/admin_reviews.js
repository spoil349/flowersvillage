
$(function(){
			
	$('.review_field').change(function(){
		var id = $('h1').attr('id').split('reviews_')[1];
		var field =  $(this).attr('id').split('__')[0];
		var value = $(this).val();
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=reviews',
			  success: function(data){}
		});
	});
	
	
	$('.add_img').click(function(){
		fileBrowse();
	});
	

	$('#img_input').change(function() {
		      displayFiles(this.files);
	});
	
	
	$('.delete_show_product_block .delete_product').click(function(){
		
		var id = $('h1').attr('id').split('reviews_')[1];	
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=reviews',
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/reviews/list/"},500)
	})
//		
	$('.delete_show_product_block .show_product').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('reviews_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=reviews',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть отзыв').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('reviews_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=reviews',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать отзыв').addClass('no_visibly');
		}
		
	})
	
});	

function fileBrowse() {
    var browseField = document.getElementById("img_input");
    browseField.click();
}

function uploadFile(file, url) {
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
		        	if( $(".img_block img").attr('src', '/uploads/100x100/'+img_src)  && $(".img_block img").load() && $(".img_block img").show()){      		        			
		        		var id = $('h1').attr('id').split('reviews_')[1];
		        		$.ajax({
		      			  url: '/admin/update',
		      			  type: 'POST',
		      			  data: 'stat=editfield&field=img&id='+id+'&value='+img_src+'&f=reviews',
		      			  success: function(data){
		        				$(".add_img").html('Изменить');
		      			  }
		        		});
				    }
				    
		        } 		        	
		      }
		  };
	  };
	  // Читаем файл
	  reader.readAsBinaryString(file); 
}

function displayFiles(files) {	
    $.each(files, function(i, file) {
    	var reg = /\.(?:png|gif|jpe?g)$/i;
    	if (!reg.test(file.name)) {
    		//return true;
    	} else {
    		$(".img_block").css('background', 'url(/img/ajax-loader.gif) no-repeat center center')
        	$(".img_block").css('background-size', '20px 20px')
        	$(".img_block img").attr('src', '');
	        uploadFile(file, '/post_file.php?f=reviews&flag=reviews');
    	}
    });	  	
} 