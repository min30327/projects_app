<div class="container">
<?php echo $this->Session->flash(); ?>
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo __('Edit your profile'); ?></div>
		<div class="panel-body">
			<?php echo $this->Form->create('User', array(
				'class' => 'form-horizontal',
				'inputDefaults' => array(
					'div' => false,
					'label' => false,
					'wrapInput' => false,
					'class' => 'form-control'
					)
				)
			).PHP_EOL; ?>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo __('name')?></label>
				<div class="col-md-9">
					<?php echo $this->Form->input('name');?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo __('email')?></label>
				<div class="col-md-9">
					<?php echo $this->Form->input('username');?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo __('Avatar')?></label>
				<div class="col-md-2">
					<span class="get_avatar">
					<?php if(!empty($this->data['User']['avatar_file_name'])) :?>
						<?php echo $this->Upload->uploadImage($this->data, 'User.avatar', array('style' => 'thumb')) ?>
					<?php endif;?>
					</span>
				</div>
				<div class="col-md-4">				
					<div class="target_avatar" data-target="get_avatar"></div>
					<div class="progress" style="display:none;height:3px">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
							<span class="sr-only">0% Complete</span>
						</div>
					</div>
					<div class="error-message"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo __('Cover')?></label>
				<div class="col-md-2">
					<span class="get_cover">
					<?php if(!empty($this->data['User']['cover_file_name'])) :?>
						<?php echo $this->Upload->uploadImage($this->data, 'User.cover', array('style' => 'thumb')) ?>
					<?php endif;?>
					</span>
				</div>
				<div class="col-md-4">				
					<div class="target_cover" data-target="get_cover"></div>
					<div class="progress" style="display:none;height:3px">
						<div class="progress-bar progress-bar-striped active" style="height:3px" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
							<span class="sr-only">0% Complete</span>
						</div>
					</div>						
					<div class="error-message"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"></label>
				<div class="col-md-4">
					<?php echo $this->Form->submit('変更を保存',array('class'=>'btn btn-primary'));?>
				</div>
			</div>
			<?php echo $this->Form->end();?>		
		</div>	
	</div>
</div>
<?php $this->start('css')?>
<?php echo $this->Html->css('jquery.fs.dropper.min').PHP_EOL;?>
<?php $this->end();?>
<?php $this->start('script')?>
<?php echo $this->Html->script('jquery.fs.dropper.min').PHP_EOL;?>
<script>
	$(".target_avatar").dropper({
		action: "<?php echo $this->Html->url('/users/upload/' .$this->data['User']['id']);?>?type=avatar",
		label 	: "ファイルをドロップ",
		postKey	:'data[User][avatar]',
		maxSize: 1048576
	})
	  .on("fileStart.dropper", onFileStart)
	  .on("fileProgress.dropper", onFileProgress)
	  .on("fileComplete.dropper", onFileComplete)
	  .on("fileError.dropper", onFileError);

	$(".target_cover").dropper({
		action: "<?php echo $this->Html->url('/users/upload/' .$this->data['User']['id']);?>?type=cover",
		label 	: "ファイルをドロップ",
		postKey	:'data[User][cover]',
		maxSize: 1048576
	})
	  .on("fileStart.dropper", onFileStart)
	  .on("fileProgress.dropper", onFileProgress)
	  .on("fileComplete.dropper", onFileComplete)
	  .on("fileError.dropper", onFileError);
	
	function onFileStart(e, files) {		
		$(this).next(".progress").fadeIn(400)
	}
	function onFileProgress(e, file, percent) {
		$(this).next(".progress")
						  .find(".progress-bar")
						  .attr('aria-valuenow',percent)
						  .width(percent+ '%')
						  .find('span')
						  .text(percent + "%");
	}
	function onFileComplete(e, file, response) {
		$(this).next(".progress").fadeOut(400);
		var error_el = $(this).next(".progress").next(".error-message");
		if(!response.error){
			var el = $(this).data('target')
			$('.' +el).html(response.img);
		}else{
			error_el
			.show()
			.addClass("error")
			.html("エラー " + response.message);
			setTimeout(function(){
				error_el.stop().fadeOut(400);
			},2000)
		}
	} 
	function onFileError(e, file, error) {
		$(this).next(".progress")
						.next(".error-message")
						.show()
						.addClass("error")
						.html("エラー: " + error);
		setTimeout(function(){
				error_el.stop().fadeOut(400);
			},2000)				
	}
</script>
<?php $this->end();?>