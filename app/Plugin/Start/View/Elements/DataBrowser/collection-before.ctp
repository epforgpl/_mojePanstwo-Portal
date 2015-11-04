<div class="collectionObjectNote">
<ul class="buttons">
    
    <li>
        <button
            data-tooltip="true"
            data-original-title="Dodaj notatkę"
            data-placement="bottom"
            data-save-post-action="/moje-kolekcje/<?= $innerParams['collection']['id'] ?>/<?= $object->getGlobalId() ?>.json"
            class="btn btn-default editCollectionNote">
            <i class="glyphicon glyphicon-edit" title="Dodaj notatkę" aria-hidden="true"></i>
        </button>
    </li>
    
    <li>
        <form method="post" action="/moje-kolekcje/<?= $innerParams['collection']['id'] ?>/<?= $object->getGlobalId() ?>.json">
            <input type="hidden" name="_action" value="delete" />
            <button
                data-tooltip="true"
                data-original-title="Usuń dokument z kolekcji"
                data-placement="bottom"
                class="btn btn-default btnRemoveObject btn"
                type="submit">
                <i class="glyphicon glyphicon-trash" title="Usuń dokument z kolekcji" aria-hidden="true"></i>
            </button>
        </form>
    </li>
    
</ul>