<div class="apiApps index">
	<h2><?php echo __('Api Apps'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('description'); ?></th>
							<th><?php echo $this->Paginator->sort('home_link'); ?></th>
							<th><?php echo $this->Paginator->sort('type'); ?></th>
							<th><?php echo $this->Paginator->sort('api_key'); ?></th>
							<th><?php echo $this->Paginator->sort('domains'); ?></th>
							<th><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($apiApps as $apiApp): ?>
	<tr>
		<td><?php echo h($apiApp['ApiApp']['id']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['name']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['description']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['home_link']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['type']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['api_key']); ?>&nbsp;</td>
		<td><?php echo h($apiApp['ApiApp']['domains']); ?>&nbsp;</td>
		<td>
			<? if (isset($apiApp['User'])) {
				// ustawione jeżeli ogląda to admin
				echo '<a href="mailto:' . $apiApp['User']['email'] .'">'. $apiApp['User']['username'] . '</a>';
			} ?>

		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $apiApp['ApiApp']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $apiApp['ApiApp']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $apiApp['ApiApp']['id']), null, __('Are you sure you want to delete # %s?', $apiApp['ApiApp']['id'])); ?>
			<?php echo $this->Form->postLink('Zresetuj klucz API', array('action' => 'reset_api_key', $apiApp['ApiApp']['id']), null, 'Czy na pewno chcesz zresetować klucz API? Konieczne będzie jego podmienienie we wszystkich klientach, które z niego korzystają.'); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
		<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
		<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Api App'), array('action' => 'add')); ?></li>
			</ul>
</div>
