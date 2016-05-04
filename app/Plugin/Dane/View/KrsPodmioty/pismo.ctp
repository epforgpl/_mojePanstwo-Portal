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

<? $pismo = $pismo->getData();
$href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

<div class="objectsPage" itemtype="http://schema.org/Organization" itemscope="">
	<div class="objectsPageWindow">

		<div class="container">
			
			<div class="objectsPageContent main">
				<div class="pismo">
					
					<div class="row">
						<div class="col-md-12">
						    <header class="margin-top-15 margin-bottom-15"><h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><?= $pismo['name'] ?></h1></header>
						</div>
					</div>
		
				    <div class="row">
				        <div class="col-sm-9">
							
							<div class="block margin-top-0">
								<section class="content">
							
									<div class="text">
			                            <?= $pismo['content_html'] ? $pismo['content_html'] : $pismo['content'] ?>
			                        </div>
			                        
								</section>
							</div>
							
							<? if ($pismo['is_public']) { ?>
			                    <div class="shareList">
			                        <?
			                        $share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['id'];
			
			                        if ($pismo['object_id']) {
			                            $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['id'];
			                        }
			                        ?>
			                        <p>Podziel się pismem:</p>
			                        <ul class="share share-center">
			                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>"
			                                   onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>', 'mywin',
			                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
			                                   class="btn btn-social-icon btn-sm btn-facebook"><span class="fa fa-facebook"></span></a>
			                            </li>
			                            <li><a href="https://twitter.com/home?status=<?= $share_url ?>"
			                                   onclick="window.open('https://twitter.com/home?status=<?= $share_url ?>', 'mywin',
			                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
			                                   class="btn btn-social-icon btn-sm btn-twitter"><span
			                                        class="fa fa-twitter"></span></a></li>
			                            <li><a href="http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>"
			                                   onclick="window.open('http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>', 'mywin',
			                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
			                                   class="btn btn-social-icon btn-sm btn-wykop"></a></li>
			                        </ul>
			                    </div>
			                <? } ?>
			                
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
				                                            <?= $response['Response']['content'] != '' ? nl2br(htmlspecialchars($response['Response']['content'])) : 'Brak treści' ?>
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
							
							<ul class="dataHighlights overflow-auto margin-top--10">
        	                    <li class="dataHighlight col-xs-12">
						            <p class="_label">Do</p>
			
						            <p class="_value"><?= $pismo['to_label'] ?></p>
						        </li>
						    
								<? if($pismo['sent']) { ?>
		                        <li class="dataHighlight col-xs-12">
						            <p class="_label">Data wysłania</p>
			
						            <p class="_value"><?= dataSlownie($pismo['sent_at']) ?></p>
						        </li>
						        <? } ?>						                        
                        	</ul>
							
				            <? if ($pismo['from_user_id'] == AuthComponent::user('id')) { ?>
				                <div class="margin-top-50">
				                    <a class="btn btn-sm width-auto btn-primary btn-icon btn-width-auto"
				                       href="/moje-pisma/<?= $pismo['alphaid'] ?>">
				                        <span class="icon glyphicon glyphicon-pencil"></span>
				                        Zarządzaj pismem
				                    </a>
				                </div>
				            <? } ?>
				
				        </div>
				    </div>
				    
			    </div>
			</div>
				    
		</div>
	
	</div>
</div>