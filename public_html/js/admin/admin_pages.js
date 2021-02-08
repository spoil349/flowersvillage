$(function(){
//	
	
/// ///////////////////////////////// -----------PAGES ONe --------------------------------------------------	
	
	$('.show_seo').click(function(){
		
		$('.seo_input_block').toggleClass('show');
	})
	
	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});

	
	$(function(){
		$(".page_text").redactor({ 
			air: false,
			buttons:["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", "unorderedlist", "orderedlist", "outdent", "indent", "|", "fontcolor", "backcolor", '|', 'image'],
			formattingTags: ['h1', 'h2', 'h3', 'h4', 'h5'],
			imageUpload: "/admin/pages/saveimg", 
			uploadCrossDomain: false,
			lang: "ru",
			interval: 3,
			convertDivs: false,
			minHeight: 500
		});	
		
	});

	$(".page_text").focusout(function(){
		var id = $('h1').attr('id').split('page_')[1]
		var text = $(this).getCode();
		var field = $(this).attr('id').split('_')[0];
		 var sendInfo = { stat: 'editfield',
				 value: text,
				 field: field,
				 id:id,
				 f: 'pages'
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
	
	$('.page_field').change(function(){
		var id = $('h1').attr('id').split('page_')[1];
		var field =  $(this).attr('id').split('__')[0];
		var value = $(this).val();
		
		var sendInfo = { stat: 'editfield',
				 value: value,
				 field: field,
				 id:id,
				 f: 'pages'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){}
		});
	});
	
});