<?php
$this->Combinator->add_libs('js', 'Dane.modal-dataobject-observe');

/*
$subscription = @$object->getLayer('subscription');
$userSubscription = @$subscription['SubscriptionChannel'];
$userSubscriptionList = empty($userSubscription) ? array() : array_column($userSubscription, 'channel');
$channels = $object->getLayer('channels');
$dataset = $object->getDataset();
$object_id = $object->getId();
*/
?>

<div class="modal fade" id="observeModal" tabindex="-1" role="dialog" aria-labelledby="observeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="observeModalLabel">Obserwuj</h4>
            </div>
            <form action="/dane/subscriptions" method="post">
	            <div class="modal-body modal-body-loading">
		            <div class="spinner grey">
			            <div class="bounce1"></div>
			            <div class="bounce2"></div>
			            <div class="bounce3"></div>
			        </div>
	            </div>
                <div class="modal-body modal-body-main">
                    <p class="header">Otrzymuj powiadomienia o nowych danych dla: <span class="dataobject-title"></span>
                    </p>

                    <div class="alert alert-danger" role="alert">
                        <p>Prosze zaznaczyć przynajmniej jeden kanał do obserwowania</p>
                    </div>
                    <input type="hidden" name="dataset" value="" />
                    <input type="hidden" name="object_id" value="" />

                    <div class="optionsBlock"></div>
                    
                    <? /*
                    <?
	                    $qs = array();
	                    if( $_qs = @$subscription['SubscriptionQuery'] ) {
		                    foreach( $_qs as $_q ) {
			                    $qs[] = $_q['q'];
		                    }
	                    }
                    ?>
                    */ ?>
                    
                    <div class="keywordsBlock">
	                    	                    
	                    <p>Powiadamiaj mnie tylko o danych zawierających określone słowa lub frazy:</p>
	                    
	                    <div class="input-group">
							<input name="keyword" value="" type="text" class="form-control input-keyword" placeholder="Dodaj słowo lub frazę...">
							<span class="input-group-btn">
								<button class="btn btn-default btn-add" type="button"><span class="glyphicon glyphicon-plus"></span></button>
							</span>
						</div>
						
						<ul class="keywords_list">
							
						</ul>
	                    
                    </div>
                    
                </div>
                <div class="modal-footer<?php if (!$this->Session->read('Auth.User.id')) {
                    echo ' backgroundBlue';
                } ?>">
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <a href="#" class="btn btn-primary btn-icon submit">
                            <span class="icon" data-icon="&#xe604;"></span>Zapisz</a>
                        <a href="#" class="btn btn-link unobserve">Przestań obserwować</a>
                    <?php } else { ?>
                        <a href="/login" class="_specialCaseLoginButton" data-dismiss="modal">Zaloguj się, aby
                            korzystać z funkcji obserwowania
                        </a>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
