<? $this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Bdl'))); ?>

<div class="col-xs-12 col-md-3 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
</div>

<div id="bdl_div" class="col-xs-12 col-md-9">

	<div class="dataWrap">

		<div class="appBanner">
			<h1 class="appTitle">Bank Danych Lokalnych</h1>
			<p class="appSubtitle">Wskaźniki statystyczne dotyczące sytuacji społecznej i gospodarczej Polski.</p>
		</div>
		
		<div class="text-center alert alert-default">
			<p>Aby zacząć, wybierz kategorie wskaźników w menu lub skorzystaj z wyszukiwarki.</p>
		</div>
		
		<p class="bdl_src text-center"><a href="http://stat.gov.pl/bdl/app/strona.html?p_name=indeks" target="_blank">Źródło danych (GUS)</a></p>

		

	</div>

</div>