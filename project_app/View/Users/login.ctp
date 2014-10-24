<div class="form-signin">
	<h2 class="text-center">Login</h2>
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
		<?php echo $this->Form->input('username',array('placeholder'=>'メールアドレス','required' ,'autofocus','class'=>'first form-control')).PHP_EOL;?>
		<?php echo $this->Form->input('password',array('placeholder'=>'パスワード','required','class'=>'last form-control' )).PHP_EOL;?>
		<p>
			<label>
				<input type="checkbox" name="data[User][rememberme]" value="1"> パスワードを記憶する
			</label>
		</p>
	<div class="mb5">
		<?php echo $this->Form->submit('ログイン',array('class'=>'btn btn-block btn-primary')).PHP_EOL; ?>
	</div>
	<?php echo $this->Form->end().PHP_EOL; ?>
	<p class="text-right"><?php echo $this->Html->link('パスワードを忘れた方はこちら →','/users/identify/')?></p>
</div>