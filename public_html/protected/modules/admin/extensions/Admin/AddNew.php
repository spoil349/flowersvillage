
<?php
class AddNew extends CWidget
{
	public $Arrfield = array();
	public $label= '';
	public $table= '';


	public function init()
	{
		$route=$this->getController()->getRoute();
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		echo $this->RenderMenu();
		echo '<script>
				 	$(function(){
							
							$("select.addnew_field").chosen();
							var show = false;
						
							if(checkFormNewItem()) {$(".button_addnew_confirm span").addClass("confirm_button");}
						
							
							$(".addnew_item_button").click(function(){
								if (!show) {
									$(this).css("background","url(\"/img/sort_asc.gif\") no-repeat right center")
									$(".addnew_item_block_form").slideDown(200);
									$(".addnew_item_block_one_input #new_name").focus();
				
									$(".addnew_item_block_one_input #new_name").keydown(function(e) {
										if (e.which == 13 && checkFormNewItem()) {
											setAddNew();
										}
									});
									show = true;
								} else {
									$(this).css("background","url(\"/img/sort_desc.gif\") no-repeat right center")
									$(".addnew_item_block_form").slideUp(200);
									show = false;
								}
							})

							$(".addnew_field").change(function(){
								if (checkFormNewItem()) {
									$(".button_addnew_confirm span").addClass("confirm_button");
									
								} else {
									$(".button_addnew_confirm span").removeClass("confirm_button");
								}
							})
				
							$(".button_addnew_confirm").click(function(){
										if ($(this).find("span").hasClass("confirm_button")) {
											setAddNew();	
										}
							});
				
							function setAddNew() {
									var table = $(".addnew_item_block_form").attr("id").split("table_")[1];
									var  line_post = "&f="+table;
				                    $(".addnew_field").each(function(){
										var value = $(this).val();
										var field = $(this).attr("id").split("new_")[1];
				                        line_post = line_post+"&"+field+"="+value;
				                               
									})
										$.ajax({
										    url: "/admin/update",
											type: "POST",
											data: "stat=addnew"+line_post,
											success: function(data){
												window.location = "/admin/"+table+"/edit/"+data;
											}
										});
							}	
							
							function checkFormNewItem() {
								var check = true;
								$(".addnew_field").each(function(){
									if ($(this).val() == "" ) check =false;
								})
				
								return check;
							}
					});
				</script>
		';
	}

	private function RenderMenu()
	{
		
		$input_line = '';
		foreach ( $this->Arrfield as $V) {
			$input = '';
			
			if ($V['type'] == 'text') {
				$input =  '<input class="addnew_field"  placeholder="'.$V['label'].'" name="'.$V['name'].'" type="text" value="" id="new_'.$V['name'].'">';
			} elseif ($V['type'] == 'select' && isset($V['arrval'])) {
				$option = '';
				foreach($V['arrval'] as $V2){
						
					$option .= '<option  value="'.$V2['id'].'">'.$V2['name'].'</option>';
				}
				
				$input =  '<select class="addnew_field"  data-placeholder="'.$V['label'].'" name="'.$V['name'].'" id="new_'.$V['name'].'">'.$option.'</select>
				';
			} elseif ($V['type'] == 'multiselect' && isset($V['arrval'])) {
				$option = '';
				
				$ARRsection = array();
				foreach ($V['arrval'] as $V2) {
					$ARRsection[$V2['section_id']]['name'] = $V2['section_name'];
					$ARRsection[$V2['section_id']]['options'][] = $V2;
				}
				
				foreach($ARRsection as $V2){
					$option .= '<optgroup label="'.$V2['name'].'">';
					foreach ($V2['options'] as $opt)
						$option .= '<option  value="'.$opt['id'].'">'.$opt['name'].'</option>';
					$option .= '</optgroup>';
				}
				
				$input =  '<select class="addnew_field musliselect" multiple="true"   data-placeholder="'.$V['label'].'" name="'.$V['name'].'" id="new_'.$V['name'].'">'.$option.'</select>
				';
			} 

			$input_line .= '<div class="addnew_item_block_one">
								<div class="addnew_item_block_one_label">'.$V['label'].'</div>
								<div class="addnew_item_block_one_input">'.$input.'</div>
						</div>
			';
		}
		if ($input_line != ''){
			return '<div class="addnew_item_block">
						<span class="addnew_item_button"><span>'.$this->label.'</span></span>
						<div class="addnew_item_block_form" id="table_'.$this->table.'">'.$input_line.'
						<div class="button_addnew_confirm"><span>Добавить</span></div>
						<div class="br"></div>
						</div>		
					</div>
			';
		}
	}
}