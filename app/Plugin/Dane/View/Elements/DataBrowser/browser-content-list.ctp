<?
$phrases = array('wynik', 'wyniki', 'wyników');

if (@isset($dataBrowser['phrases']['paginator']) && $dataBrowser['phrases']['paginator'])
    $phrases = $dataBrowser['phrases']['paginator'];

if (isset($paginatorPhrases) && $paginatorPhrases)
    $phrases = $paginatorPhrases;
    
$_manage = isset( $manage ) ? $manage: false;

?>

<div class="dataBrowser margin-top-0 lower<? if($_manage) {?> manage<? } ?>">
	
    <? if ($_manage) {?>
	<div class="manage-display" style="display: none;">
		<div class="container">
			
			<form action="/moje-pisma/moje" method="post">
				<div class="inputs">
				</div>
				<p class="display pull-left"></p>
				<ul class="actions pull-right">
					<li class="p">
						<p>Zaznaczone: </p>
					</li>
					<li>
						<input type="submit" class="btn btn-default btn-sm" name="delete" value="Usuń">
					</li>
				</ul>
			</form>

		</div>
	</div>
	<? } ?>
	
	<div class="container container-padding">
		<? if( $params['count'] ) { ?>
		<div class="dataBrowserContent">
						
			<div class="row">
				<div class="col-lg-8 dataBrowser-wrap">
					<div class="<? if ($dataWrap) { ?>dataWrap <? } ?>">	
												
						<div class="row">
							<div class="col-md-12">
												
					            <div class="dataObjects">
					
					                <div class="innerContainer update-objects">
					
					                    <?
					                    if (isset($dataBrowser['hits'])) {
					                        if (!empty($dataBrowser['hits'])) {
					                            ?>
					                            <ul class="list-group list-dataobjects">
					                                <?
					
					                                $params = array(
						                                'manage' => $_manage,
					                                );
					                                if (isset($truncate))
					                                    $params['truncate'] = $truncate;
					
					                                foreach ($dataBrowser['hits'] as $object) {
					
					                                    if (isset($beforeItemElement))
					                                        echo $this->element($beforeItemElement, array(
					                                            'object' => $object,
					                                            'innerParams' => @$innerParams,
					                                        ));
					
					                                    echo $this->Dataobject->render($object, $dataBrowser['renderFile'], $params);
					
					                                    if (isset($afterItemElement))
					                                        echo $this->element($afterItemElement, array(
					                                            'object' => $object,
					                                            'innerParams' => @$innerParams,
					                                        ));
					                                }
					                                ?>
					                            </ul>
					                        <?
					                        }
					                    }
					                    ?>
					
					                </div>
					
					            </div>			
			            
				            </div>
						</div>
												
			        </div>
			
			    </div>
			</div>
			
			
			
		</div>
		<? } else { ?>
						
				<?= $this->element( $dataBrowser['noResultsElement'] ) ?>
			
			<? } ?>
	</div>
		
	
</div>