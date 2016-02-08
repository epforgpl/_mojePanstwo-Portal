<?php

$this->Combinator->add_libs('css', $this->Less->css('news-form', array('plugin' => 'Admin')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Admin.news-form');

/* tag-it */
echo $this->Html->script('../plugins/tag-it/js/tag-it.min', array('block' => 'scriptBlock'));
echo $this->Html->css('../plugins/tag-it/css/jquery.tagit.css');
echo $this->Html->css('../plugins/tag-it/css/tagit.ui-zendesk.css');

?>

<?= $this->element('Admin.header'); ?>

<h2>Dodaj aktualność</h2>

<form enctype="multipart/form-data" action="/admin/news/add/<?= isset($crawlerPage) ? $crawlerPage['CrawlerPage']['id'] : '' ?>" method="POST">
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
            <div class="form-group">
                <label>Data dodania</label>
                <input type="text" name="date" value="<?= date('Y-m-d', isset($crawlerPage) ? strtotime($crawlerPage['CrawlerPage']['cts']) : time()) ?>" class="form-control" placeholder="Tytuł"/>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="text" name="deadline" value="YYYY-MM-DD" class="form-control" placeholder="Deadline"/>
            </div>
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
            <div class="row tags margin-top-10">
                <div class="col-md-12">
                    <label>Słowa kluczowe</label>
                    <input type="text" class="form-control tagit" name="tags"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label>Obszar działania</label>
            <div class="margin-top-10">
                <? foreach($areas as $i => $area) { ?>
                    <div class="checkbox margin-top-0">
                        <input id="area_<?= ($i + 1) ?>" name="areas[]" type="checkbox" value="<?= ($i + 1) ?>"/>
                        <label for="area_<?= ($i + 1) ?>"><?= ucfirst($area) ?></label>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>

    <div class="row margin-top-10">
        <div class="col-md-6">
            <label>Obrazek</label>
            <input type="file" name="image"/>
            <p class="help-block">
                Tylko pliki graficzne *.jpg, *.jpeg, *.png.
                Zalecane jest aby nie były mniejsze niż 900x576 px.
            </p>
        </div>
        <div class="col-md-6">
            <label>Źródło</label>
            <input type="text" name="image_source" value="" class="form-control" placeholder="Źródło http://...."/>
        </div>
    </div>

    <button type="submit" class="btn btn-default margin-top-10">Zapisz</button>
</form>

<? if (isset($crawlerPage)) { ?>
    <iframe style="border: none; width: 100%; height: 500px;" src="/admin/news/iframe/<?= $crawlerPage['CrawlerPage']['id'] ?>"></iframe>
    <a href="<?= $crawlerPage['CrawlerPage']['url'] ?>" target="_blank" class="btn btn-link">Otwórz stronę w nowej karcie</a>
<? } ?>

<?= $this->element('Admin.footer'); ?>

