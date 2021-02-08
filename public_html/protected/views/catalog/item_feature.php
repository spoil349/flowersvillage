<?php if ( $feature['value'] != ''):?>

<div class="item_feature">
	<div class="item_feature_label"><?php echo $feature['name']?></div>
	
	<?php if ($feature['type'] == 'textarea' ) :?>
	
		<p><?php echo $text = preg_replace('/(^\r\n|\r|\n)\r\n|\r|\n(^\r\n|\r|\n)/is', '$1<br><br>$2', $feature['value']);?></p>
		
	<?php elseif ($feature['type'] == 'multiselect' && $feature['value'] != '') :?>
		<?php 
			$arrValue = explode('|', $feature['value']);
			foreach($arrValue as $K => $val):
		?>
			<?php if ($feature['tocart'] == 1):?>
					<span class="blue"><?php echo $val?></span><?php if ($K < count($arrValue) - 1)echo ', '?>
			<?php else :?>
					<span class=""><?php echo $val?></span><?php if ($K < count($arrValue) - 1)echo ', '?> 
			<?php endif;?>
			
		<?php endforeach;?>

	<?php endif;?>
	
</div>

<?php endif;?>