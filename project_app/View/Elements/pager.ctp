	<!-- pager -->
	<div class="clearfix">
		<ul class="pagination">
		<?php 
			echo ($this->Paginator->hasPrev()) ? $this->Paginator->prev('&lt;', array('escape' => false,"tag"=>"li"), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')) :'' ;
			echo $this->Paginator->numbers(array("separator"=>false));
			echo ($this->Paginator->hasNext()) ?  $this->Paginator->next('&gt;', array('escape' => false,"tag"=>"li"), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')) :'' ;
		?></ul>
	</div>
