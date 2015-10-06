<?= $this->element('map'); ?>
	
<script type="text/javascript">
	var _autostart = <?= json_encode( !isset($widget) ) ?>;
	var _sendloadevent = false;
</script>