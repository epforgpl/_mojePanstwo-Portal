<?=	$this->Combinator->add_libs('css', $this->Less->css('culture', array('plugin' => 'Admin'))); ?>
<?= $this->element('Admin.header'); ?>

<ul class="files">
<? foreach( $reports as $report ) {?>
	<li>
		<h2 class="title"><?= $report['data']['name'] ?></h2>
		<ul>
		<? foreach( $report['files'] as $file ) {?>
			<li>
				<p class="title"><?= $file['data']['name'] ?></p>
				<ul>
				<? foreach( $file['tabs'] as $tab ) {?>
					<li<? if( $tab['data']['saved'] ) {?> class="saved"<? } ?>>
						<a href="/admin/kultura/pliki/<?= $tab['data']['id'] ?>"><?= $tab['data']['name'] ?></a>
						<? if( isset($tab['surveys']) ) {?>
						<ul>
							<? foreach($tab['surveys'] as $s) {?>
							<li><a href="/admin/kultura/survey/<?= $s['data']['id'] ?>"><?= $s['data']['title'] ?></a></li>
							<? } ?>
						</ul>
						<? } ?>
					</li>
				<? } ?>
				</ul>
			</li>
		<? } ?>
		</ul>
	</li>
<? } ?>
</ul>

<?= $this->element('Admin.footer'); ?>