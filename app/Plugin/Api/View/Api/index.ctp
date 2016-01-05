<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$this->Html->css(array(
    // '/api/swagger/css/typography',
    '/api/swagger/css/reset',
    '/api/swagger/css/screen',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'screen'));

$this->Html->css(array(
    '/api/swagger/css/reset',
    '/api/swagger/css/print',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'print'));

$this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api')));

$this->Html->script(array(
    '/api/swagger/lib/jquery.slideto.min',
    '/api/swagger/lib/jquery.wiggle.min',
    '/api/swagger/lib/handlebars-2.0.0',
    '/api/swagger/lib/underscore-min',
    '/api/swagger/lib/backbone-min',
    '/api/swagger/lib/marked',
    // enabling this will enable oauth2 implicit scope support
    // '/api/swagger/lib/swagger-oauth',
    '/api/swagger/swagger-ui.min',
    // '/api/swagger/lib/highlight.7.3.pack',

), array('inline' => 'false', 'block' => 'scriptBlock'));

$this->Html->scriptBlock('window.swaggerUi = new SwaggerUi({url: "https://api-v3.mojepanstwo.pl/swagger.json", uiRoot: "/api/",docExpansion: "list"});window.swaggerUi.load();',
    array('inline' => 'false', 'block' => 'scriptBlock'));

?>

<div class="objectsPage">
	<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
		
		<div class="searcher-app">
			<div class="container">
			    <?= $this->element('Dane.DataBrowser/browser-searcher', array(
			    	'size' => 'md',
			    )); ?>
			</div>
		</div>
		
		<div class="container">
            <div class="dataBrowserContent">

                <div class="col-xs-12 col-sm-4 col-md-1-5 nopadding dataAggsContainer">
				    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
				
					    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
				
				    </div>
				</div>
				
				
				<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
				
				    <div class="dataWrap">
				        <div class="appBanner bottom-border">
				            <h1 class="appTitle">API</h1>
				
				            <p class="appSubtitle">Buduj aplikacje w oparciu o dane publiczne</p>
				        </div>
				        
				        <div class="block block-simple col-sm-12">
				            <section class="content margin-top-10">
					            Interfejs API portalu MojePaństwo umożliwia dostęp do baz danych publicznych gromadzonych na portalu. Aby zacząć korzystać z API - <a href="/register">zarejestruj swoje konto</a> na portalu i pobierz swój unikalny klucz. Więcej informacji znajdziesz w dziale <a href="/api/info">Informacje ogólne</a>.</section>.
				            </section>
				        </div>
				        
				        <div class="block block-simple col-sm-12">
					        <header class="nopadding">Dokumentacja wywołań API:</header>
					        <section class="content swagger-content">
						        
						        <div class="newLayout">
			                        <div class="swagger-section row">
			                            <div id="message-bar" class="swagger-ui-wrap col-md-12">&nbsp;</div>
			                            <div id="swagger_ui" class="swagger-ui-wrap col-md-12"></div>
			                        </div>
			
			                        <p class="swagger-credits">Zbudowane przy użyciu
			                            <a href="https://github.com/swagger-api/swagger-ui/" target="_blank">Swagger UI</a>
			                        </p>
				                </div>
				                
					        </section>
				        
				    </div>
				
				</div>

		    </div>
		</div>

	</div>
</div>
