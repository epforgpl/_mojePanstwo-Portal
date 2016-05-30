<?php
$this->Combinator->add_libs('js', 'Dane.modal-dataobject-observe');

$subscription = @$object->getLayer('subscription');
$userSubscription = @$subscription['SubscriptionChannel'];
$userSubscriptionList = empty($userSubscription) ? array() : array_column($userSubscription, 'channel');
$channels = $object->getLayer('channels');
$dataset = $object->getDataset();
$object_id = $object->getId();
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
                <div class="modal-body">
                    <p class="header">Otrzymuj powiadomienia o nowych danych dla: <span><a
                                href="/dane/<?= $dataset ?>/<?= $object_id ?>,<?= $object->slug() ?>"><?= $object->getTitle(); ?></a></span>
                    </p>

                    <div class="alert alert-danger" role="alert">
                        <p>Prosze zaznaczyć przynajmniej jeden kanał do obserwowania</p>
                    </div>
                    <input type="hidden" name="dataset" value="<?= $dataset ?>"/>
                    <input type="hidden" name="object_id" value="<?= $object_id ?>"/>

                    <div class="optionsBlock">
                        <? if (isset($channels) && !empty($channels)) {
                            if (isset($userSubscription)) { ?>
                                <div class="checkbox first">
                                    <input type="checkbox" id="checkbox_all" name="channel[]"
                                           value=""<? if (empty($userSubscription)) echo ' checked'; ?>>
                                    <label for="checkbox_all">Wszystkie dane</label>
                                </div>
                                <? foreach ($channels as $ch) {
                                    ?>
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               id="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"
                                               name="channel[]" value="<?= $ch['DatasetChannel']['channel'] ?>"
                                            <? if (empty($userSubscription) || in_array($ch['DatasetChannel']['channel'], $userSubscriptionList)) echo ' checked'; ?>
                                            <? if (empty($userSubscription)) echo ' disabled'; ?>>
                                        <label
                                            for="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"><?= $ch['DatasetChannel']['title'] ?></label>
                                    </div>
                                    <?
                                }
                            } else { ?>
                                <div class="checkbox first">
                                    <input type="checkbox" id="checkbox_all" name="channel[]" value="" checked>
                                    <label for="checkbox_all">Wszystkie dane</label>
                                </div>

                                <? foreach ($channels as $ch) {
                                    ?>
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               id="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"
                                               name="channel[]" value="<?= $ch['DatasetChannel']['channel'] ?>"
                                               checked
                                               disabled
                                            />
                                        <label
                                            for="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"><?= $ch['DatasetChannel']['title'] ?></label>
                                    </div>
                                    <?
                                }
                            }
                        } ?>
                    </div>
                    
                    <?
	                    $qs = array();
	                    if( $_qs = @$subscription['SubscriptionQuery'] ) {
		                    foreach( $_qs as $_q ) {
			                    $qs[] = $_q['q'];
		                    }
	                    }
                    ?>
                    
                    <div class="keywordsBlock" data-qs="<?= htmlspecialchars(json_encode($qs), ENT_QUOTES, 'UTF-8') ?>">
	                    	                    
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
                        <? if (isset($subscription) && !empty($subscription['Subscription']['id'])) { ?>
                            <a href="#" class="btn btn-link unobserve"
                               data-subscription-id="<?= $subscription['Subscription']['id'] ?>">Przestań obserwować</a>
                        <? } ?>
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
