<div class="apiApps form">
	<?php echo $this->Form->create('ApiApp'); ?>
	<fieldset>
		<legend><?php echo __('Add Api App'); ?></legend>
			<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('home_link');
		echo $this->Form->input('type');
		echo $this->Form->input('domains');
	?>
		type = domain lub web, jezeli web to należy wpisać domeny
	</fieldset>
	<span>Dodając aplikację zgadasz się na wykorzystanie podanych informacji w działaniach promocyjnych serwisu Moje Państwo.</span>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>

