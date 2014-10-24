	<div class="panel panel-default mb30">
		<div class="panel-heading">
			グループを追加
		</div>
		<div class="panel-body">
			<?php echo $this->Form->create('Role', array(
			'inputDefaults' => array(
				'div' => false,
				'label' => false,
				'wrapInput' => false,
				'class' => 'form-control'
				)
			)
			).PHP_EOL; ?>
			<div class="mb30">
				<?php echo $this->Form->input('name').PHP_EOL;?>
			</div>
			<?php echo $this->Form->submit('権限を追加',array('class'=>'btn btn-primary')).PHP_EOL; ?>
		</div>
	</div>

	<div class="panel panel-default mb20">
		<div class="panel-heading">
			グループ
		</div>
		<table class="table">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr> 
		<?php foreach ($roles as $role): ?>
			<tr>
				<td><?php echo h($role['Role']['id']); ?>&nbsp;</td>
				<td><?php echo h($role['Role']['name']); ?>&nbsp;</td>
				<td class="actions">
					<div class="btn-group">
					<?php echo $this->Html->link(__('編集'), array('action' => 'edit', $role['Role']['id']),array('class'=>'btn btn-default')).PHP_EOL; ?>
					<?php echo $this->Html->link(__('削除'), array('action' => 'delete', $role['Role']['id']),array('class'=>'btn btn-default')).PHP_EOL; ?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php echo $this->element('pager');?>
