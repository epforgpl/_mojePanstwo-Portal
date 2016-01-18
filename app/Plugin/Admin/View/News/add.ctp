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
        <label>Tytuł</label>
        <input type="text" name="name" class="form-control" placeholder="Tytuł"/>
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
    <? if (isset($crawlerPage)) { ?>
    <div class="form-group">
        <label>Organizator</label>
        <input type="hidden" name="instytucja_id" value="<?= $crawlerPage['CrawlerSite']['instytucja_id'] ?>"/>
        <input type="text" value="<?= $crawlerPage['CrawlerSite']['name'] ?>" class="form-control" disabled/>
    </div>
    <? } ?>
    <div class="row">
        <div class="col-md-6">
            <label>Data dodania</label>
            <input type="text" name="date" value="<?= date('Y-m-d', isset($crawlerPage) ? strtotime($crawlerPage['CrawlerPage']['cts']) : time()) ?>" class="form-control" placeholder="Tytuł"/>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label>Przedział min.</label>
                    <input type="text" name="range_min" value="0.00" class="form-control" placeholder="min."/>
                </div>
                <div class="col-md-6">
                    <label>Przedział max.</label>
                    <input type="text" name="range_max" value="0.00" class="form-control" placeholder="max."/>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default margin-top-10">Zapisz</button>
</form>

<? if (isset($crawlerPage)) { ?>
    <iframe style="border: none; width: 100%; height: 500px;" src="<?= $crawlerPage['CrawlerPage']['url'] ?>"></iframe>
    <a href="<?= $crawlerPage['CrawlerPage']['url'] ?>" target="_blank" class="btn btn-link">Otwórz stronę w nowej karcie</a>
<? } ?>

<?= $this->element('Admin.footer'); ?>

