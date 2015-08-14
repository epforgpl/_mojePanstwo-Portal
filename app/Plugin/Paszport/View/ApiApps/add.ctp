<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>

<div class="editProfile container">
	<div class="mainBlock col-md-9">
		<h3><?php echo __('Api Apps'); ?></h3>
		<?php echo $this->Html->link(__('New Api App'), array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>
		<div class="apiApps">
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
	</div>
</div>