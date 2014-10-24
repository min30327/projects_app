<div class="form-signin">
	<h3 class="mb20">パスワードの確認</h3>
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
			<?php echo $this->Form->input('mail',array('placeholder'=>'メールアドレス','required' ,'autofocus')).PHP_EOL;?>
		</div>
	<?php echo $this->Form->submit('メールを送信',array('class'=>'btn btn-block btn-primary')).PHP_EOL; ?>
	<?php echo $this->Form->end().PHP_EOL; ?>
</div>