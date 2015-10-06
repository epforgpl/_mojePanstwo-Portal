<?= $this->element('map'); ?>
	
<script type="text/javascript">
	var _place = <?= json_encode( $place ) ?>;
	var _autostart = true;
	var _sendloadevent = true;
</script>