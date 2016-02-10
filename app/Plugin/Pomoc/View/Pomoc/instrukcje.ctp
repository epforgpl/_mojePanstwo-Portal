<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('pomoc', array('plugin' => 'Pomoc')));

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
	<div class="objectsPage">
	    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
	
	        <div class="container">
	            <div class="dataBrowserContent">
	
	                <div class="col-xs-12 col-sm-8 col-md-4-5">

                        <div class="appBanner">
                            <h1 class="appTitle">Pomoc</h1>

                            <p class="appSubtitle">Instrukcje</p>
                        </div>
                        <div class="epfPosts whiteBlocks block col-xs-12">
                            <ul class="item-list">
                                <?
                                foreach ($epfRSSFeed as $post) { ?>
                                    <li class="item list">
                                        <a href="<?= $post['link'] ?>" target="_blank">
                                            <h3 class="title"><?= str_replace(' & ', ' &amp; ', $post['title']); ?></h3>
                                        </a>
                                        <time class="date"><?= date('d M Y', strtotime($post['date'])); ?></time>
                                        <p class="desc"><?= $post['desc']; ?></p>
                                        <a class="btn btn-primary btn-link btn-sm" href="<?= $post['link'] ?>"
                                           target="_blank">Dowiedz
                                            się więcej</a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                            <div class="col-xs-12 text-center margin-bottom-20">
                                <a class="btn btn-primary"
                                   href="http://epf.org.pl/pl/category/moje-panstwo/"
                                   target="_blank">Zobacz więcej instrukcji</a>
                            </div>
                        </div>

	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>