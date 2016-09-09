<?
	echo $this->Element('dataobject/pageBegin');
	
	$data = $object->getLayer('data');

	$html = preg_replace('/([0-9]{11})/', 'XXX', $data['text']);
	$html = str_replace("\n", '</p><p>', $html);
	if( $html )
		$html = '<p>' . $html . '</p>';
		
?>


    <div class="row">

	    <div class="object col-md-9">
	        
	        <div class="block margin-top-20">
		        <section class="content text-typo">
			        
			        <?= $html ?>
			        
		        </section>
	        </div>
	       
	        
	    </div><div class="col-md-3">
	
	        <ul class="dataHighlights overflow-auto margin-top-10">    		
		        		        
		        <div class="objectRender readed objclass msig">
		            <div class="main_content">
	                    <div class="content">
	                        <span class="object-icon icon-datasets-msig"></span>
	                        <div class="object-icon-side  ">
		                        <p class="title margin-top-5">
	                                <a href="/dane/msig/<?= $object->getData('wydanie_id') ?>">MSiG <?= $object->getData('msig.nr') ?>/<?= $object->getData('msig.rocznik') ?></a>
	                            </p>
	                            <p class="meta meta-desc"><?= dataSlownie($object->getData('msig.data'), array('relative' => false)) ?></p>
	                        </div>
	                    </div>
		            </div>
				</div>
		        		        
		        <? if( @$data['sad'] ) {?>
	    		<li class="dataHighlight col-xs-12">
		            <p class="_label">Sąd</p>
		            <p class="_value"><?= $data['sad'] ?></p>
		        </li>
		        <? } ?>
		        
		        <? if( @$data['symbol'] ) {?>
		        <li class="dataHighlight col-xs-12">
		            <p class="_label">Symbol sprawy</p>
		            <p class="_value"><?= $data['symbol'] ?></p>
		        </li>
		        <? } ?>
			    		    
	        </ul>
	        
	        
	        
	        
	    </div>
	        
	</div>


<?= $this->Element('dataobject/pageEnd'); ?>
