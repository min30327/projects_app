<div class="clearfix">
<ul class="pagination">

	<?php echo (!empty($prev)) ? '<li>'.$this->Html->link('<i class="fa fa-chevron-left"></i>　' . ((!empty($prevtext)) ? $prevtext : '' ), $prev,array('escape'=>false)).'</li>': '';?>
	<?php echo (!empty($back)) ? '<li>'.$this->Html->link(__('一覧'), $back) .'</li>': '';?>
	<?php echo (!empty($next)) ? '<li>'.$this->Html->link( ((!empty($nexttext)) ? $nexttext : '' ). '　<i class="fa fa-chevron-right"></i>', $next,array('escape'=>false)).'</li>': '';?>
</ul>
</div>