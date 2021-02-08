
<div class="wrap_sizes ">
	<div class="wrap_page">
	<div class="action_page  "  style="margin-left:0;margin-right:0; ">
			<div class="block_label" style="margin:0 0 40px 0">Акции</div>
			<?php foreach($actions as $action) :?>
				<div class="one_action aloading">
				<a  class="one_action_img" href="/actions/<?php echo $action['id']?>">
				<?php if ($action['img'] != '' && $action['img'] != '|') :?>
					<img src="/uploads/<?php echo str_replace('|', '', $action['img'])?>">
				<?php endif;?>
				</a>
				<div class="action_desc">
					<div class="action_desc_name"><a  style="display:inline-block; line-height:1em;" class="blue" href="/actions/<?php echo $action['id']?>"><?php echo $action['name']?></a></div>
					<div class="action_desc_title"><?php echo $action['title']?></div>
					
				</div>
				<div class="br"></div>
				</div>
				
			<?php endforeach;?>
	</div>
	
</div>
</div>


