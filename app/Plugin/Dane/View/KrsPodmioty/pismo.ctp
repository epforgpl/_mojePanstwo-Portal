<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))); ?>
<?php

$accessDict = array(
    'prywatna',
    'publiczna'
);

?>

<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $pismo = $pismo->getData(); $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

<div class="container">
	
	<header class="collection-header">

        <div class="overflow-auto margin-top-10">

            <div class="content pull-left">
                <i class="object-icon icon-applications-pisma"></i>

                <div class="object-icon-side">
                    <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><?= $pismo['name'] ?></h1>
                </div>
            </div>

        </div>
    </header>
	
    <div class="row">
        <div class="col-sm-9">
            

            <ul class="collection-meta">
                <li>Pismo <?= $pismo['is_public'] ? 'publiczne' : 'prywatne'; ?></li>
            </ul>

            <div class="letter-table">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Do:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['to_label'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Temat:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['template_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text">
                            <?= $pismo['content_html'] ? $pismo['content_html'] : $pismo['content'] ?>
                        </div>
                    </div>
                </div>
                <? if ($pismo['sent']) { ?>
                    <div class="row sent">
                        <div class="col-sm-12">
                            <p>Wysłane <?= dataSlownie($pismo['sent_at']) ?>.</p>
                        </div>
                    </div>
                <? } ?>
            </div>
            

            <div class="lettersResponses">
                <div class="row margin-top-20">
                    <div class="col-md-12">

                        <ul class="responses">
                            <? if (isset($responses) && is_array($responses) && count($responses)) { ?>
                                <? foreach ($responses as $response) { ?>
                                    <li class="response">
                                        <h2>
                                            <?= $response['Response']['title'] ?>
                                            <span class="date"><?= dataSlownie($response['Response']['date']) ?></span>
                                        </h2>

                                        <div class="content">
                                            <?= $response['Response']['content'] != '' ? htmlspecialchars($response['Response']['content']) : 'Brak treści' ?>
                                        </div>
                                        <? if (count($response['files'])) { ?>
                                            <div class="files">
                                                <? foreach ($response['files'] as $file) { ?>
                                                    <div class="file">
                                                        <a target="_blank"
                                                           href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>/attachment/<?= $file['ResponseFile']['id'] ?>"><span
                                                                class="glyphicon glyphicon-download-alt"></span>
                                                            <?= $file['ResponseFile']['src_filename'] != '' ? $file['ResponseFile']['src_filename'] : 'Brak nazwy' ?>
                                                        </a>
                                                    </div>
                                                <? } ?>
                                            </div>
                                        <? } ?>
                                    </li>
                                <? } ?>
                            <? } ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div><div class="col-sm-3">
	        
	        <? if($pismo['from_user_id'] == AuthComponent::user('id')) { ?>
                <div class="margin-top-50">
                    <a class="btn btn-sm auto-width btn-primary btn-icon btn-auto-width" href="/moje-pisma/<?= $pismo['alphaid'] ?>">
                        <i class="icon glyphicon glyphicon-pencil"></i>
                        Zarządzaj pismem
                    </a>
                </div>
            <? } ?>
	        
        </div>
    </div>
</div>
