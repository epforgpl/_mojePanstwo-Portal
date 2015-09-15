<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= htmlspecialchars(strip_tags(str_replace('&nbsp;', ' ', $title_for_layout))) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <?php

        echo $this->Html->css('../libs/jqueryui/themes/cupertino/jquery-ui.theme.min.css');

        $this->Combinator->add_libs('css', $this->Less->css('jquery/jquery-ui-customize'), false);
        $this->Combinator->add_libs('css', $this->Less->css('structure'), false);
        $this->Combinator->add_libs('css', $this->Less->css('main'), false);
        $this->Combinator->add_libs('css', $this->Less->css('themes'), false);
        $this->Combinator->add_libs('css', $this->Less->css('icon-datasets'));
        $this->Combinator->add_libs('css', $this->Less->css('bootstrap-checkboxes'));
        $this->Combinator->add_libs('css', $this->Less->css('suggester'));
        $this->Combinator->add_libs('css', $this->Less->css('appheader'));

        /* GLOBAL CSS FOR LOGIN FORM FOR PASZPORT PLUGIN*/
        $this->Combinator->add_libs('css', $this->Less->css('loginForm', array('plugin' => 'Paszport')), false);

        /* CSS FOR OBSERVE BUTTON MODAL FOR DANE PLUGIN*/
        $this->Combinator->add_libs('css', $this->Less->css('modal-dataobject-observe', array('plugin' => 'Dane')));

        /*BOOTSTRAP SELECT LOOKS LIKE BOOTSTRAP BUTTONS*/
        echo $this->Html->css('../plugins/bootstrap-select/dist/css/bootstrap-select.min.css');

        /*BOOTSTRAP CHECKBOX LOOKS SWITCH BUTTONS*/
        echo $this->Html->css('../plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css');

        /* SOCIAL BUTTONS */
        echo $this->Html->css('../libs/font-awesome/4.4.0/css/font-awesome.min.css');
        $this->Combinator->add_libs('css', $this->Less->css('social-buttons'), false);

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
    <body>

        <?php echo $this->fetch('content'); ?>

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

        echo $this->Html->script('../libs/jqueryui/1.11.4/jquery-ui.min.js');
        echo $this->Html->script('../libs/jqueryui/i18n/jquery-ui-i18n.min.js');

        echo $this->Html->script('../libs/bootstrap/3.3.4/js/bootstrap.min.js');

        /* PACKAGES FROM VENDOR */
        echo $this->Html->script('../plugins/history.js/scripts/bundled/html4+html5/jquery.history.js');
        echo $this->Html->script('../plugins/js-cookie/src/js.cookie.js');
        echo $this->Html->script('../plugins/bootstrap-select/dist/js/bootstrap-select.min.js');
        echo $this->Html->script('../plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js'); ?>

        <?php /*PHP DATA FOR JS */ ?>
        <script type="text/javascript">
            var mPHeart = {
                constant: {
                    ajax: {
                        api: "<?php echo @API_url; ?>"
                    }
                },
                user_id: '<?= AuthComponent::user('id'); ?>',
                language: {
                    twoDig: "<?php switch (Configure::read('Config.language')) { case 'pol': echo "pl"; break; case 'eng': echo "en"; break; }  ?>",
                    threeDig: "<?php echo Configure::read('Config.language'); ?>"
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
                translation: jQuery.parseJSON('<?php echo json_encode($translation); ?>')

            }
        </script>

        <?php

        $this->Combinator->add_libs('js', 'enhance', false);
        $this->Combinator->add_libs('js', 'structure', false);
        $this->Combinator->add_libs('js', 'main', false);
        $this->Combinator->add_libs('js', 'suggester');
        $this->Combinator->add_libs('js', 'appheader');

        /* BLOCK FOR SPECIAL SCRIPTS LIKE PROTOTYPE THAT CANNOT BE MERGE TO ONE FILE*/
        echo $this->fetch('scriptBlock');

        echo $this->Combinator->scripts('js');

        ?>
    </body>
</html>
