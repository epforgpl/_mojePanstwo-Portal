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
	
	<div class="container">
		<div class="dataBrowserContent">
				
			<div class="row">
				<div class="col-xs-8 dataBrowser-wrap">
					<div class="<? if ($dataWrap) { ?>dataWrap <? } ?>">	
												
						<div class="row">
							<div class="col-md-12">
						
								
								<ul class="nav nav-pills dataAggsDropdownList nopadding" role="tablist">
																						
							    <? if (isset($params['count']) && (!isset($nopaging) || !$nopaging)) { ?>
							        <li>
							            <div class="dataCounter">
								            <? if( $params['count'] ) {?>
							                <span><?= pl_dopelniacz($params['count'], $phrases[0], $phrases[1], $phrases[2]) ?></span>
							                <? } else { ?>
							                <span><?= __d('dane', isset($noResultsPhrase) ? $noResultsPhrase : 'LC_DANE_BRAK_WYNIKOW') ?></span>
							                <? } ?>
							            </div>
							        </li>
							    <? } ?>
										
						        <? if (isset($dataBrowser['sort']) && $dataBrowser['sort'] && (!isset($nopaging) || !$nopaging)) { ?>
						            <li role="presentation" class="dropdown dataAggsDropdown splitDropdownMenu pull-right">
						                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
						                   aria-expanded="false">Sortowanie <span class="caret"></span></a>
						                <ul class="dropdown-menu modal-sort">
						                    <?php
						                    $order_key = false;
						                    $order_value = false;
						                    if (isset($this->request->query['order'])) {
						                        $order_query_parts = explode(' ', $this->request->query('order'));
						                        $order_key = $order_query_parts[0];
						                        $order_value = $order_query_parts[1];
						                    } else {
												$order_key = 'score';
												$order_value = 'desc';
						                    }
						
						                    foreach ($dataBrowser['sort'] as $sortKey => $sortValue) {
						                                                
						                        $sort = '<li>';
						                        $sort .= '<span>' . $sortValue['label'] . '</span>';
						                        $sort .= '<ul>';
						
						                        foreach ($sortValue['options'] as $sortOptionsKey => $sortOptionsValue) {
						                            
						                            if( $sortKey=='score' )
							                            $query = array_merge($this->request->query, array(
							                                'order' => null,
							                            ));
							                        else
							                        	$query = array_merge($this->request->query, array(
							                                'order' => $sortKey . ' ' . $sortOptionsKey,
							                            ));
						
						
						                            $sort .= '<li' . (($order_key == $sortKey && $order_value == $sortOptionsKey) ? ' class="active"' : '') . '><a href="/' . $this->request->url . '?' . http_build_query($query) . '">' . $sortOptionsValue . '</a></li>';
						                        }
						
						                        $sort .= '</ul>';
						                        $sort .= '</li>';
																		
						                        echo $sort;
						                    }
						                    ?>
						                </ul>
						            </li>
						        <? } ?>
							
								</ul>
								
						
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
	</div>
		
	
</div>