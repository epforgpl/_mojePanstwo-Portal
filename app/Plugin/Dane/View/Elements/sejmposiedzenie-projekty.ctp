<?
if (!empty($projekty)) {
    ?>
    <ul>
        <?
        foreach ($projekty as $projekt) {
            ?>
            <li>

                <p class="title"><a href="/dane/prawo_projekty/<?= $projekt['id'] ?>"><?= $projekt['tytul'] ?></a></p>

                <div class="author"><?= $projekt['autorzy_html'] ?></div>
                <div class="desc"><?= $this->Text->truncate($projekt['opis'], 200) ?></div>
                <div class="button">
                    <a class="btn btn-default btn-sm" href="/dane/sejm_posiedzenia_punkty/<?= $projekt['punkt_id'] ?>">Więcej &raquo;</a>
                </div>

            </li>
        <?
        }
        ?>
    </ul>
<?
}
?>