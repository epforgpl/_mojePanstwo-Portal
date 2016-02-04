<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('js', 'app');

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<div class="app-content-wrap">

    <?= $this->Element('Paszport.modal_login_inpage'); ?>

</div>
