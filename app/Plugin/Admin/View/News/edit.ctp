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

    <form style="padding: 10px;" action="/admin/news/edit/<?= $news['News']['id'] ?>" method="POST">
        <? if(isset($crawlerPage)) { ?>
            <input type="hidden" name="crawler_page_id" value="<?= $crawlerPage['CrawlerPage']['id'] ?>"/>
        <? } ?>
        <input type="hidden" name="user_id" value="<?= AuthComponent::user('id') ?>"/>
        <input type="hidden" name="id" value="<?= $news['News']['id'] ?>"/>
        <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>"/>
        <div class="form-group">
            <label>Tytuł</label>
            <input value="<?= $news['News']['name'] ?>" type="text" name="name" class="form-control" placeholder="Tytuł"/>
        </div>
        <div class="form-group">
            <label>Opis</label>
            <textarea name="description" class="form-control" rows="3" title="Opis" placeholder="Opis"><?= $news['News']['description'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Treść</label>
            <textarea name="content" class="form-control tinymceField" rows="8" title="Treść" placeholder="Treść"><?= $news['News']['content'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Źródło</label>
            <input value="<?= $news['News']['source_url'] ?>" type="text" name="source_url" class="form-control" placeholder="Źródło http://...."/>
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
                    <input type="text" name="date" value="<?= $news['News']['date'] ?>" class="form-control" placeholder="Tytuł"/>
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="text" name="deadline" value="<?= $news['News']['deadline'] ?>" class="form-control" placeholder="Deadline"/>
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
                        <input
                            type="text"
                            class="form-control tagit"
                            name="tags"
                            <? if(isset($tags)) printf('data-value="%s"', htmlspecialchars(json_encode($tags), ENT_QUOTES, 'UTF-8')); ?>
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label>Obszar działania</label>
                <div class="margin-top-10">
                    <? foreach($areas as $i => $area) { ?>
                        <div class="checkbox margin-top-0">
                            <input id="area_<?= ($i + 1) ?>" name="areas[]" type="checkbox" value="<?= ($i + 1) ?>" <?= in_array($i + 1, $newsAreas) ? 'checked': '' ?>/>
                            <label for="area_<?= ($i + 1) ?>"><?= ucfirst($area) ?></label>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-default margin-top-10">Zapisz</button>
    </form>

    <form style="padding: 10px;" enctype="multipart/form-data" action="/admin/news/edit/<?= $news['News']['id'] ?>" method="POST">
        <div class="row margin-top-10">
            <div class="col-md-6">
                <? if($news['News']['is_image'] == '1') { ?>
                    <label>Obrazek</label>
                    <div class="margin-top-5">
                        <a href="http://sds.tiktalik.com/portal/ngo_konkursy/<?= $news['News']['id'] ?>_0.jpg" target="_blank">
                            <img src="http://sds.tiktalik.com/portal/ngo_konkursy/<?= $news['News']['id'] ?>_1.jpg"/>
                        </a>
                    </div>
                    <div class="checkbox margin-top-5">
                        <input id="removeImageCheckbox" name="remove_image" type="checkbox" value="1" />
                        <label for="removeImageCheckbox">Usuń obrazek</label>
                    </div>
                <? } else { ?>
                    <label>Obrazek</label>
                    <input type="file" name="image"/>
                    <p class="help-block">
                        Tylko pliki graficzne *.jpg, *.jpeg, *.png.
                        Zalecane jest aby nie były mniejsze niż 900x576 px.
                    </p>
                <? } ?>
            </div>
            <div class="col-md-6">
                <label>Źródło obrazka</label>
                <input type="text" name="image_source" value="<?= $news['News']['image_source'] ?>" class="form-control" placeholder="Źródło http://...."/>
            </div>
        </div>
        <button type="submit" class="btn btn-default margin-top-10">Zmień obrazek</button>
    </form>

<? if(isset($crawlerPage)) { ?>
    <iframe style="border: none; width: 100%; height: 500px;" src="/admin/news/iframe/<?= $crawlerPage['CrawlerPage']['id'] ?>"></iframe>
    <a href="<?= $crawlerPage['CrawlerPage']['url'] ?>" target="_blank" class="btn btn-link">Otwórz stronę w nowej karcie</a>
<? } ?>

<?= $this->element('Admin.footer'); ?>