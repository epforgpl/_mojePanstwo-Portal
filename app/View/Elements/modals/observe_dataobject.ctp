<?php
$this->Combinator->add_libs('js', 'Dane.modal-dataobject-observe');

$subscription = $object->getLayer('subscription');
$userSubscription = $object->getLayer('subscription')['SubscriptionChannel'];
$channels = $object->getLayer('channels');
$dataset = $object->getDataset();
$object_id = $object->getId();
?>

<div class="col-md-2">
    <div data-toggle="modal" data-target="#observeModal"
         class="observeButton btn btn-icon <? if (isset($subscription) && !empty($subscription)) {
             echo 'btn-success';
         } else {
             echo 'btn-primary';
         } ?>">
        <i class="icon" data-icon-applications="&#xe60a;"></i><? if (isset($subscription) && !empty($subscription)) {
            echo 'Obserwujesz...';
        } else {
            echo 'Obserwuj...';
        } ?>
    </div>

    <div class="modal fade" id="observeModal" tabindex="-1" role="dialog" aria-labelledby="observeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Obserwuj dane o "<?= $object->getTitle() ?>"</h4>
                </div>
                <form action="/dane/subscriptions" method="post">
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            <p>Prosze zaznaczyć przynajmniej jeden kanał do obserwowania</p>
                        </div>
                        <input type="hidden" name="dataset" value="<?= $dataset ?>"/>
                        <input type="hidden" name="object_id" value="<?= $object_id ?>"/>

                        <div class="checkbox">
                            <input type="checkbox" id="checkbox_all" name="channel[]" value="" checked>
                            <label for="checkbox_all">Wszystkie dane
                                <small>*</small>
                            </label>
                        </div>
                        <? if (isset($channels) && !empty($channels)) {
                            if (isset($userSubscription)) {
                                debug($userSubscription);
                            } else {
                                foreach ($channels as $ch) {
                                    ?>
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               id="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"
                                               name="channel[]" value="<?= $ch['DatasetChannel']['channel'] ?>"
                                               checked
                                               disabled>
                                        <label
                                            for="checkbox_<?= $ch['DatasetChannel']['subject_dataset'] . '_' . $ch['DatasetChannel']['channel'] ?>"><?= $ch['DatasetChannel']['title'] ?></label>
                                    </div>
                                <?
                                }
                            }
                        } ?>
                        <p class="info">
                            <small>* Zaznaczenie opcji "wszystkich danych" włączy obserwowanie aktualnych oraz
                                przyszłościowych kanałów powiązanych z danym elementem.
                            </small>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <?php if ($this->Session->read('Auth.User.id')) { ?>
                            <a href="#" class="submit">Zapisz</a>
                        <?php } else { ?>
                            <a href="/login" class="_specialCaseLoginButton" data-dismiss="modal">Zaloguj się, aby
                                korzystać z funkcji
                                obserwowania
                            </a>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>