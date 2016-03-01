<!DOCTYPE html>
<html lang="en">
<head>

    <title><?= htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $title_for_layout))) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php if (isset($_META) && !empty($_META)) {
        foreach ($_META as $key => $val)
            echo $this->Html->meta(array('property' => $key, 'content' => $val));
    } ?>

    <link rel="icon" type="image/svg+xml" href="/img/favicon/favicon-new.svg">

    <? /*
    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png"/>
    <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png"/>
    <link rel="manifest" href="/img/favicon/manifest.json"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png"/>
    */ ?>
    <meta name="theme-color" content="#ffffff"/>


    <?php
    echo $this->Html->meta(array('property' => 'og:url', 'content' => Router::url($this->here, true)));
    echo $this->Html->meta(array('property' => 'og:type', 'content' => 'website'));
    echo $this->Html->meta(array('property' => 'og:title', 'content' => strip_tags($title_for_layout)));
    echo $this->Html->meta(array(
        'property' => 'og:description',
        'content' => (isset($_META) && array_key_exists('description', $_META)) ? strip_tags($_META['description']) : strip_tags(__('LC_MAINHEADER_TEXT'))
    ));
    echo $this->Html->meta(array(
        'property' => 'og:image',
        'content' => (isset($_META) && array_key_exists('image', $_META)) ? FULL_BASE_URL . $_META['image'] : FULL_BASE_URL . '/img/favicon/facebook.png',
    ));
    echo $this->Html->meta(array('property' => 'fb:admins', 'content' => '616010705')); /*Daniel Macyszyn*/
    echo $this->Html->meta(array('property' => 'fb:admins', 'content' => '100000234760647')); /*Mariusz Konrad Machuta-Rakowski*/
    echo $this->Html->meta(array('property' => 'fb:app_id', 'content' => FACEBOOK_appId));

    echo $this->Html->css('../libs/jqueryui/themes/cupertino/jquery-ui.theme.min.css');

    if (isset($header_vote) && is_array($header_vote))
        $this->Combinator->add_libs('css', $this->Less->css('header-vote', array('plugin' => 'Dane')));

    $this->Combinator->add_libs('css', $this->Less->css('jquery/jquery-ui-customize'), false);
    $this->Combinator->add_libs('css', $this->Less->css('structure'), false);
    $this->Combinator->add_libs('css', $this->Less->css('portal'), false);
    $this->Combinator->add_libs('css', $this->Less->css('main'), false);
    $this->Combinator->add_libs('css', $this->Less->css('themes'), false);
    $this->Combinator->add_libs('css', $this->Less->css('icon-applications'));
    $this->Combinator->add_libs('css', $this->Less->css('icon-datasets'));
    $this->Combinator->add_libs('css', $this->Less->css('bootstrap-checkboxes'));
    $this->Combinator->add_libs('css', $this->Less->css('suggester'));
    $this->Combinator->add_libs('css', $this->Less->css('appheader'));

    /* GLOBAL CSS FOR LOGIN FORM FOR PASZPORT PLUGIN*/
    $this->Combinator->add_libs('css', $this->Less->css('loginForm', array('plugin' => 'Paszport')), false);

    /* CSS FOR OBSERVE BUTTON MODAL FOR DANE PLUGIN AND OTHER MODALS */
    $this->Combinator->add_libs('css', $this->Less->css('modal-dataobject', array('plugin' => 'Dane')));

    /*BOOTSTRAP SELECT LOOKS LIKE BOOTSTRAP BUTTONS*/
    echo $this->Html->css('../plugins/bootstrap-select/dist/css/bootstrap-select.min.css');

    /*BOOTSTRAP CHECKBOX LOOKS SWITCH BUTTONS*/
    echo $this->Html->css('../plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css');

    /* SOCIAL BUTTONS */
    echo $this->Html->css('../libs/font-awesome/4.4.0/css/font-awesome.min.css');
    $this->Combinator->add_libs('css', $this->Less->css('social-buttons'), false);

    /* OBJECT "PAGE" ICONS */
    if (isset($object) && $object->getPage())
        $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow')));

    if (isset($object_editable) && !empty($object_editable)) {
        $this->Combinator->add_libs('css', $this->Less->css('dataobjects-editable', array('plugin' => 'Dane')));
    }

    /* SPECIAL THEME FOR PRZEJRZYSTY KRAKOW */
    if ($domainMode == 'PK')
        $this->Combinator->add_libs('css', $this->Less->css('przejrzysty-krakow-theme', array('plugin' => 'PrzejrzystyKrakow')));

    /* HAD TO BE EXCLUDED CAUSE ERRORS AT BOOTSTRAP */
    echo $this->Html->css('../libs/bootstrap/3.3.4/css/bootstrap.min.css');
    echo $this->Combinator->scripts('css');

    /* BLOCK FOR SPECIAL STYLES THAT CANNOT BE MERGE TO ONE FILE*/
    echo $this->fetch('cssBlock');

    /* ENHANCE SCRIPTS */
    echo $this->Html->script('enhance');

    /* VIEW SPECIFIC HEAD */
    echo $scripts_for_layout;
    ?>

    <!--[if lt IE 9]>
    <?php echo $this->Html->script('ie/html5shiv.js'); ?>
    <?php echo $this->Html->script('ie/respond.js'); ?>
    <![endif]-->
</head>
<body
    class="theme-<?php echo $_layout['body']['theme'];
    if (empty($app_chapters['items'])) {
        echo ' app-sidebar-oneline';
    } ?>">

<?php /*PHP DATA FOR JS */ ?>
<script type="text/javascript">
    var mPHeart = {
        constant: {
            ajax: {
                api: "<?php echo @API_url; ?>"
            }
        },
        user_id: '<?= AuthComponent::user('id'); ?>',
        username: '<?= AuthComponent::user('username'); ?>',
        language: {
            twoDig: "<?php switch (Configure::read('Config.language')) {
                case 'pol':
                    echo "pl";
                    break;
                case 'eng':
                    echo "en";
                    break;
            }  ?>",
            threeDig: "<?php echo Configure::read('Config.language'); ?>",
            twoPerThreeDig: "<?php switch (Configure::read('Config.language')) {
                case 'pol':
                    echo "pl-PL";
                    break;
                case 'eng':
                    echo "en-EN";
                    break;
            }  ?>"
        },
        social: {
            facebook: {
                id: "<?php echo @FACEBOOK_appId; ?>",
                key: "<?php echo @FACEBOOK_apiKey; ?>"
            }
        },
        suggester: {
            phrase: '<?php echo @htmlspecialchars($q) ?>',
            placeholder: 'Szukaj w danych publicznych...',
            fullSearch: 'Pełne wyszukiwanie'
        },
        translation: JSON.parse('<?php echo json_encode($translation); ?>')

    }
</script>

<div id="_wrapper">
    <?php echo $this->Element('flash'); ?>
    <?php // echo $this->Element('cockpit'); ?>
    <div id="_main">
        
        <?php
        if ($domainMode == 'PK')
            echo $this->Element('PrzejrzystyKrakow.pkrk-header');

        if (isset($_layout['header']) && !empty($_layout['header'])) {
            echo $this->Element('headers/' . $_layout['header']['element']);
        } ?>

        <?php echo $content_for_layout; ?>

    </div>
    <?php if (isset($_layout['footer']) && !empty($_layout['footer']))
        echo $this->Element('footers/' . $_layout['footer']['element']);
    echo $this->Element('footers/cookie'); ?>
</div>

<?
if ($domainMode == "MP") {
    if (isset($_COOKIE["mojePanstwo"])) {
        $mojePanstwo = json_decode($_COOKIE["mojePanstwo"]);

        if (!isset($mojePanstwo->survey->ankieta2->complete)) {
            echo $this->Element('survey/ankieta2');
        }
    } else {
        echo $this->Element('survey/ankieta2');
    }
}
?>

<?php /* GOOGLE ANALYTIC */ ?>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-37679118-4', 'mojepanstwo.pl');
    ga('send', 'pageview');
</script>

<?php
echo $this->Html->script('../libs/jquery/2.1.4/jquery-2.1.4.min.js');
echo $this->Html->script('jquery.sticky.js');

if (isset($object_editable) && !empty($object_editable))
    echo $this->Html->script('../js/jquery.autocomplete.min');

echo $this->Html->script('../libs/jqueryui/1.11.4/jquery-ui.min.js');
echo $this->Html->script('../libs/jqueryui/i18n/jquery-ui-i18n.min.js');

echo $this->Html->script('../libs/bootstrap/3.3.4/js/bootstrap.min.js');

/* PACKAGES FROM VENDOR */
echo $this->Html->script('../plugins/history.js/scripts/bundled/html4+html5/jquery.history.js');
echo $this->Html->script('../plugins/js-cookie/src/js.cookie.js');
echo $this->Html->script('../plugins/bootstrap-select/dist/js/bootstrap-select.min.js');
echo $this->Html->script('../plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'); ?>

<?php
$this->Combinator->add_libs('js', 'enhance', false);
$this->Combinator->add_libs('js', 'structure', false);
$this->Combinator->add_libs('js', 'mpbase', false);
$this->Combinator->add_libs('js', 'portal', false);
$this->Combinator->add_libs('js', 'suggester');
$this->Combinator->add_libs('js', 'appheader');

/* BLOCK FOR SPECIAL SCRIPTS LIKE PROTOTYPE THAT CANNOT BE MERGE TO ONE FILE*/
echo $this->fetch('scriptBlock');
?>

<?php echo $this->Combinator->scripts('js'); ?>

</body>
</html>
