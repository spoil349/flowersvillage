$(function(){
//	

	$("select").chosen();
	
	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});
	
	$('.show_seo').click(function(){
		
		$('.seo_input_block').toggleClass('show');
	})
	
	$('#categories tbody').sortable({
		revert: 100,
		update: function(){
				var sort = 1;
		  		var sort_line = '';
				 $( "#categories tbody tr" ).each(function(){
					 var id = $(this).attr('id').split('_')[1];
					 sort_line = sort_line+'|'+id+'-'+sort;
					 sort++;
				 })
				 $.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=sort&sort_line='+sort_line+'&f=categories',
					  success: function(data){
					  }
				});				
		}
	});
	
	$('#products tbody tr').disableSelection();
	
	
	$('.delete_category').click(function(){
		var id = $('h1').attr('id').split('category_')[1]
		if (confirm("Вы дуйствительно хотите удалить эту категорию")) {
			
		} else {
			return true;
		}
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=categories',
			  success: function(data){	 
			  }
		      
		});
		setTimeout(function(){window.location = "/admin/categories/list/"},500)
	})
	
	$(".category_text").redactor({ 
		air: false,
		buttons:["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", "unorderedlist", "orderedlist", "outdent", "indent", "|", "fontcolor", "backcolor", '|'],
		formattingTags: ['h1', 'h2', 'h3', 'h4', 'h5'],
		imageUpload: "/admin/pages/saveimg", 
		uploadCrossDomain: false,
		lang: "ru",
		interval: 3,
		convertDivs: false,
		minHeight: 500
	});	
	
	$(".category_text").focusout(function(){
		var id = $('h1').attr('id').split('category_')[1]
		var text = $(this).getCode();
		var field = $(this).attr('id').split('_')[0];
		 var sendInfo = { stat: 'editfield',
				 value: text,
				 field: field,
				 id:id,
				 f: 'categories'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){

			  }
		});	
	})
	
	
	$('.show_category').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('category_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=categories',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('category_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=categories',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать').addClass('no_visibly');
		}
		
	})
	
	$('#change_section').change(function(){
	var id = $('h1').attr('id').split('category_')[1];	
	value = $(this).val().split('__')[1];
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&id='+id+'&f=categories&value='+value+'&field=section_id',
			  success: function(data){
				  location.reload(); 
			  }
		});
	});	
	
	$('#features_change').change(function(){
		var id = $('h1').attr('id').split('category_')[1];	
		value = $(this).val();
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=addfeatures_tocategory&id='+id+'&value='+value,
			  success: function(data){
			  }
		});
	});	
	
	$('#actions_change').change(function(){
		var id = $('h1').attr('id').split('category_')[1];	
		value = $(this).val();
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=addactions_tocategory&id='+id+'&value='+value,
			  success: function(data){
			  }
		});
	});	
	
	
	$('.category_field').change(function(){
		ChachgeField($(this));
	});

});	


function ChachgeField(el) {
	
	var id = el.attr('id').split('__')[1];
	var field = el.attr('id').split('__')[0];
	if (id != '' && id != 'new'){
		var value = el.val();
	if (field == 'uri'){
		var value = value.toLowerCase();
	}
		
		$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=categories',
				  success: function(data){}
			});
	}
}