<div class="apiApps form">
	<?php echo $this->Form->create('ApiApp'); ?>
	<fieldset>
		<legend><?php echo __('Edit Api App'); ?></legend>
			<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('home_link');;
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

					<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ApiApp.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ApiApp.id'))); ?></li>
				<li><?php echo $this->Html->link(__('List Api Apps'), array('action' => 'index')); ?></li>
			</ul>
</div>
