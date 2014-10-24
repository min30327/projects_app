<div class="container">
	<div class="row mb20">
		<div class="col-md-4">
			<div class="pull-left mr10">
				<?php echo $this->Html->link('ユーザーを新規追加','/users/add/',array('class'=>'btn btn-primary'));?>
			</div>			
			<div class="dropdown pull-left">
			  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
			    並び替え
			    <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			    <li role="presentation"><?php echo $this->Paginator->sort('id','ID').PHP_EOL; ?></li>
			    <li role="presentation"><?php echo $this->Paginator->sort('name','ユーザー名').PHP_EOL; ?></li>
			    <li role="presentation"><?php echo $this->Paginator->sort('username','メールアドレス').PHP_EOL; ?></li>
			    <li role="presentation" class="divider"></li>
			    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
			  </ul>
			</div>
		</div>		
	</div>
	<div class="row">
	<?php foreach ($users as $user): echo PHP_EOL;?>
		<div class="col-md-4">
			<div class="panel panel-default panel-member height-el">
				<div class="panel-heading pos-r">
				<span class="avatar w80">
				<?php if(!empty($user['User']['avatar_file_name'])) :?>
					<?php echo $this->Upload->uploadImage($user, 'User.avatar', array('style' => 'thumb'),array("class"=>"img-circle")) ?>
				<?php else:?>
					<img src="<?php echo $this->Html->url('/img/user-dummy.png');?>" alt="avator" class="img-circle">
				<?php endif;?>	
				</span>
					<?php echo h($user['User']['name']).PHP_EOL; ?>
				</div>
				<div class="panel-body">
				</div>
			</div>
		</div>
		<?php endforeach; echo PHP_EOL; ?>
	</div>
	<?php echo $this->element('pager');?>
</div>
