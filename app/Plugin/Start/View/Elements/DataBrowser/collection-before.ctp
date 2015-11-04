<div>
<ul class="buttons">
    
    <li>
    	<form method="post" action="/moje-kolekcje/<?= $innerParams['collection']['id'] ?>/<?= $object->getGlobalId() ?>.json">
	        <input type="hidden" name="_action" value="edit" />
	        <input type="hidden" name="note" value="Testowa notatka <?= uniqid() ?>" />
	        <button
	            data-tooltip="true"
	            data-original-title="Dodaj notatkę"
	            data-placement="bottom"
	            class="btn btn-default btn"
	            type="submit">
	            <i class="glyphicon glyphicon-edit" title="Dodaj notatkę" aria-hidden="true"></i>
	        </button>
    	</form>
    </li>
    
    <li>
        <input type="hidden" name="delete"/>
        <button
            data-tooltip="true"
            data-original-title="Usuń dokument z kolekcji"
            data-placement="bottom"
            class="btn btn-default btnRemove btn"
            type="submit">
            <i class="glyphicon glyphicon-trash" title="Usuń dokument z kolekcji" aria-hidden="true"></i>
        </button>
    </li>
    
</ul>