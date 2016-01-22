<?
	
	echo $this->Html->css(array('http://fonts.googleapis.com/css?family=Lato:300,400&subset=latin-ext'), array('block' => 'cssBlock'));
	echo $this->Html->script('RaportyDostepDoInformacjiPublicznej.raphael', array('block' => 'scriptBlock'));
	
	$this->Combinator->add_libs('css', $this->Less->css('raporty_dostep_do_informacji_publicznej', array('plugin' => 'RaportyDostepDoInformacjiPublicznej')));
	$this->Combinator->add_libs('js', 'RaportyDostepDoInformacjiPublicznej.raporty_dostep_do_informacji_publicznej.js');
	
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');

?>

<div id="infoGraph">
    <div class="infoGraphContent"></div>
</div>