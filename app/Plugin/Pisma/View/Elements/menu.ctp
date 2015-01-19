<?
if (!isset($selected))
    $selected = false;
?>
<div id="shortcuts">
    <ul>
        <li<? if ($selected == 'nowe') { ?> class="active"<? } ?>><a href="/pisma/nowe">Nowe pismo</a>
        <li<? if ($selected == 'moje') { ?> class="active"<? } ?>><a href="/pisma/moje">Moje pisma</a></li>
        </li>
    </ul>
</div>