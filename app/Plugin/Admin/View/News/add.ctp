<?php

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Admin.news-form');

?>

<?= $this->element('Admin.header'); ?>

<h2>Dodaj aktualność</h2>

<form style="padding: 10px;" action="/admin/news/add/<?= isset($crawlerPage) ? $crawlerPage['CrawlerPage']['id'] : '' ?>" method="POST">
    <? if (isset($crawlerPage)) { ?>
        <input type="hidden" name="crawler_page_id" value="<?= $crawlerPage['CrawlerPage']['id'] ?>"/>
    <? } ?>
    <input type="hidden" name="user_id" value="<?= AuthComponent::user('id') ?>"/>
    <div class="form-group">
        <label>Nazwa</label>
        <input type="text" name="name" class="form-control" placeholder="Nazwa"/>
    </div>
    <div class="form-group">
        <label>Opis</label>
        <textarea name="description" class="form-control" rows="3" title="Opis" placeholder="Opis"></textarea>
    </div>
    <div class="form-group">
        <label>Treść</label>
        <textarea name="content" class="form-control tinymceField" rows="8" title="Treść"
                  placeholder="Treść"></textarea>
    </div>
    <div class="form-group">
        <label>Promuj</label><br/>
        <label>
            <input type="radio" name="is_promoted" value="1" checked>
            Tak
        </label>&nbsp;
        <label>
            <input type="radio" name="is_promoted" value="0">
            Nie
        </label>
    </div>
    <button type="submit" class="btn btn-default">Zapisz</button>
</form>

<? if (isset($crawlerPage)) { ?>
    <iframe style="border: none; width: 100%; height: 500px;" src="<?= $crawlerPage['CrawlerPage']['url'] ?>"></iframe>
    <a href="<?= $crawlerPage['CrawlerPage']['url'] ?>" target="_blank" class="btn btn-link">Otwórz stronę w nowej
        karcie</a>
<? } ?>

<?= $this->element('Admin.footer'); ?>

