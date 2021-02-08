<?php 
	$url = Yii::app()->request->url;		
?>
	
<div class="header_menu">
	<?php foreach ($Catalog as $catalog) :?>
		<?php if (preg_match('/'.$catalog['uri'].'$/', $url) ) :?>
			<span class="gray select"><?php echo $catalog['name']?></span>
		<?php elseif (preg_match('/'.$catalog['uri'].'.+/', $url)) :?>
			<a class="gray select" href="/catalog/<?php echo $catalog['uri']?>"><?php echo $catalog['name']?></a>
		<?php else : ?>
			<a class="gray" href="/catalog/<?php echo $catalog['uri']?>"><?php echo $catalog['name']?></a>
		<?php endif;?>
	<?php endforeach;?>
	<?php foreach ($pages as $page) { ?>
		<?php if (preg_match('/'.$page['uri'].'/', $url)) { ?>
			<span class="gray select"><?php echo $page['name']?></span>
		<?php } else { ?>
			<a class="gray" href="<?php echo ($page['uri'] != '/' ? '/' : '').$page['uri']?>"><?php echo $page['name']?></a>
		<?php } ?>
	<?php } ?>
</div>

