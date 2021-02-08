$(function(){
//	

	$("select").chosen();
	$('input, textarea, select').click(function(){
		$(this).addClass('input_selected_click');
	})
	
	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});
	
	$('input, textarea, select').click(function(){
		$(this).addClass('input_selected_click');
	})
	
	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});
	
	
	
	$('#sections tbody').sortable({
		revert: 100,
		update: function(){
				var sort = 1;
		  		var sort_line = '';
				 $( "#sections tbody tr" ).each(function(){
					 var id = $(this).attr('id').split('_')[1];
					 sort_line = sort_line+'|'+id+'-'+sort;
					 sort++;
				 })
				 $.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=sort&sort_line='+sort_line+'&f=sections',
					  success: function(data){
					  }
				});				
		}
	});
	
	$('#sections tbody tr').disableSelection();
	
	
	$('.delete_section').click(function(){
		var id = $('h1').attr('id').split('section_')[1]
		if ($(this).hasClass('used_section')){
			apprise('В этой секции находиться '+ $(this).attr('id').split('count_')[1]+' категорий! Все равно удалить секцию вместе с товарами?', {'verify':true, 'textYes':'Да, все равно', 'textNo': 'Нет'}, function(r) {
				if(r) { 
					$.ajax({
						  url: '/admin/update',
						  type: 'POST',
						  data: 'stat=delete&id='+id+'&f=sections',
						  success: function(data){	 
						  }
					      
					});
					setTimeout(function(){window.location = "/admin/sections/list/"},500)
					
				} else { 					
					
				}
			});
		} else {
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=delete&id='+id+'&f=sections',
				  success: function(data){
				  }
					
			});
			setTimeout(function(){window.location = "/admin/sections/list/"},500)
		}
		
		
	})
	
	$('.show_section').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('section_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=sections',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть секцию').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('section_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=sections',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать секцию').addClass('no_visibly');
		}
		
	})
	
	$('.section_field').change(function(){
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
				  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=sections',
				  success: function(data){}
			});
	}
}