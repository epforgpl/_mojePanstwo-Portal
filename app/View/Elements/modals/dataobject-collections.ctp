<?php

$this->Combinator->add_libs('js', 'Dane.modal-dataobject-collections');

$dataset = $object->getDataset();
$object_id = $object->getId();

?>
<div
    data-tooltip="true"
    data-original-title="Dodaj do kolekcji"
    data-placement="bottom"
    data-toggle="modal"
    data-target="#collectionsModal"
    class="btn optionBtn btn-primary off">
    <span class="icon"
          data-icon-applications="&#xe618;"></span>
</div>

<div class="modal fade" id="collectionsModal" tabindex="-1" role="dialog" aria-labelledby="collectionsModalLabel"
     aria-hidden="true" data-object-title="<?= $object->getTitle(); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="collectionsModalLabel">Dodaj do kolekcji</h4>
            </div>
            <form action="/dane/subscriptions" method="post">
                <div class="modal-body">

                    <?php if ($this->Session->read('Auth.User.id')) { ?>

                        <div class="form-cont">

                            <div class="form-group">
                                <input type="text" class="form-control" id="collectionName" autocomplete="off" placeholder="Znajdź lub dodaj kolekcję...">
                            </div>

                            <div class="list-group"></div>

                            <div class="form-group margin-top-10">
                                <label for="collectionObjectNote">Notatka</label>
                                <textarea id="collectionObjectNote" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="ManageAsComponent margin-top-10"></div>

                        </div>

                    <? } ?>

                    <input type="hidden" name="dataset" value="<?= $dataset ?>"/>
                    <input type="hidden" name="object_id" value="<?= $object_id ?>"/>
                </div>
                <div class="modal-footer<?php if (!$this->Session->read('Auth.User.id')) {
                    echo ' backgroundBlue';
                } ?>">
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <a href="#" class="btn btn-primary btn-icon submit" data-dismiss="modal">
                            <span class="icon" data-icon="&#xe604;"></span>Gotowe
                        </a>
                    <?php } else { ?>
                        <a href="/login" class="_specialCaseLoginButton" data-dismiss="modal">Zaloguj się, aby
                            korzystać z kolekcji
                        </a>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
