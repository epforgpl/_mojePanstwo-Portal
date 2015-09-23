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
    class="btn optionBtn btn-primary">
    <i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
</div>

<div class="modal fade" id="collectionsModal" tabindex="-1" role="dialog" aria-labelledby="collectionsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="collectionsModalLabel">Dodaj do kolekcji</h4>
            </div>
            <form action="/dane/subscriptions" method="post">
                <div class="modal-body">
                    <p class="header">Dodaj do danej kolekcji obiekt: <span><a
                                href="/dane/<?= $dataset ?>/<?= $object_id ?>,<?= $object->slug() ?>"><?= $object->getTitle(); ?></a></span>
                    </p>

                    <?php if ($this->Session->read('Auth.User.id')) { ?>

                        <div class="form-cont">

                            <div class="form-group">
                                <input type="text" class="form-control" id="collectionName" autocomplete="off" placeholder="Znajdź lub utwórz kolekcję...">
                            </div>

                            <div class="list-group"></div>

                        </div>

                    <? } ?>

                    <input type="hidden" name="dataset" value="<?= $dataset ?>"/>
                    <input type="hidden" name="object_id" value="<?= $object_id ?>"/>
                </div>
                <div class="modal-footer<?php if (!$this->Session->read('Auth.User.id')) {
                    echo ' backgroundBlue';
                } ?>">
                    <?php if ($this->Session->read('Auth.User.id')) { ?>
                        <a href="#" class="btn btn-primary btn-icon submit">
                            <i class="icon" data-icon="&#xe604;"></i>Zapisz
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
