<div class="form-signin">
	 <h3 class="mb20">パスワードの再発行</h3>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('User', array(         
		'inputDefaults' => array(
			'div' => false,
			'label' => false,
			'wrapInput' => false,
			'class' => 'form-control'
			)
		)
		).PHP_EOL; ?>
		<div class="mb20">
			<?php echo $this->Form->input('password',array('placeholder'=>'新しいパスワード','class'=>'first form-control' )).PHP_EOL; ?>
			<?php echo $this->Form->input('password2',array('type'=>'password',"required"=>"required",'placeholder'=>'もう一度入力','class'=>'last form-control')).PHP_EOL; ?>
		</div>
	<?php echo $this->Form->submit('パスワードを変更',array('class'=>'btn btn-block btn-lg btn-success')); ?>
	<?php echo $this->Form->end().PHP_EOL; ?>
</div>