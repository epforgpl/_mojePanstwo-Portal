<?php $this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api'))) ?>

<?php

$this->Html->css(array(
    '/api/swagger/css/typography',
    '/api/swagger/css/reset',
    '/api/swagger/css/screen',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'screen'));

$this->Html->css(array(
    '/api/swagger/css/reset',
    '/api/swagger/css/print',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'print'));

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

$this->Html->scriptBlock('window.swaggerUi = new SwaggerUi({url: "http://api-v2.mojepanstwo.pl/swagger.json", uiRoot: "/api/",docExpansion: "list"});window.swaggerUi.load();',
    array('inline' => 'false', 'block' => 'scriptBlock'));
?>

<div id="api" class="newLayout">
    <div class="container">
        <div class="details">
            <? echo $this->element($slug); ?>
        </div>

        <div class="swagger-section row">
            <div id="message-bar" class="swagger-ui-wrap col-md-12">&nbsp;</div>
            <div id="swagger_ui" class="swagger-ui-wrap col-md-12"></div>
        </div>

        <p>Interaktywna dokumentacja zbudowana przy użyciu
            <a href="https://github.com/swagger-api/swagger-ui/" target="_blank">Swagger UI</a>
        </p>
    </div>
</div>