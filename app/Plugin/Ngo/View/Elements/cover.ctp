<?php $this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo'))) ?>

<div class="col-md-8"></div>
<div class="col-md-4">
    <div class="panel panel-primary col-xs-12">
        <div class="panel-body" data-toggle="modal" data-target="#ngoPartnerModal">
            /asd
        </div>
    </div>
    <?php echo $this->element('Ngo.ngo_partner_modal') ?>
</div>