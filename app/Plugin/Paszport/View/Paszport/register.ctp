<?php

$this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport')));
$this->Combinator->add_libs('js', 'Paszport.paszport-register.js');

?>

<div class="objectsPage fullPageHeight">
    <div class="createAccount" id="modalPaszportLoginForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo __d('paszport', 'LC_PASZPORT_FOOTER_REGISTER'); ?></h4>
                </div>
                <div class="modal-body" style="margin-bottom: 0;">
                    <?php echo $this->Form->create('User', array(
                        'id' => 'UserRegisterForm',
                        'url' => $this->Html->url(array(
                            'plugin' => 'paszport',
                            'controller' => 'paszport',
                            'action' => 'register',
                            'full_base' => true
                        ))
                    )); ?>

                    

                    <div class="slide inputForm col-xs-12 hide">
                        <div class="control-group">
                            <label class="control-label" for="AccountType">
                                <?php echo __d('paszport', "LC_PASZPORT_ACCOUNT_TYPE"); ?>
                            </label>

                            <div class="controls" id="AccountType">
                                <div class="btn-group">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                        <?php echo $groups[key($groups)]; ?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($groups as $k => $g) { ?>
                                            <li data-group="<?php echo $k ?>"><a href="#"><?php echo $g ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->Form->hidden('User.group_id'); ?>

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.email', array(
                            'class' => 'input-xlarge form-control',
                            'type' => 'email',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_EMAIL", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_EMAIL_REQUIRED", true),
                            'required' => 'required',
                            'data-validation-email-message' => __d('paszport', "LC_PASZPORT_NOT_A_VALID_EMAIL", true),
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.password', array(
                            'class' => 'input-xlarge form-control',
                            'type' => 'password',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_PASSWORD", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_NEW_PASSWORD_BLANK", true),
                            'required' => 'required',
                            'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                            'minlength' => '6',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>
                    <div class="slide inputForm col-xs-12">
                        <?php echo $this->Form->input('User.repassword', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', 'LC_PASZPORT_CONFIRM_PASSWORD', true),
                            'autocomplete' => 'off',
                            'type' => 'password',
                            'data-validation-match-match' => 'data[User][password]',
                            'data-validation-match-message' => __d('paszport', "LC_PASZPORT_CONFIRM_PASSWORD_NOT_EQUAL", true),
                            'data-validation-minlength-message' => __d('paszport', "LC_PASZPORT_PASSWORD_MIN_6_CHAR", true),
                            'minlength' => '6',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm groupType col-xs-12" rel="1">
                        <?php echo $this->Form->input('User.username', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_USERNAME", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_USERNAME_BLANK", true),
                            'group-required' => 'required',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>
                    <div class="slide inputForm groupType col-xs-12 hidden" rel="2">
                        <?php echo $this->Form->input('User.username', array(
                            'class' => 'input-xlarge form-control',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_INSTITUTION_NAME", true),
                            'autocomplete' => 'off',
                            'data-validation-required-message' => __d('paszport', "LC_PASZPORT_INSTITUTION_NAME_BLANK", true),
                            'group-required' => 'required',
                            'disabled' => 'disabled',
                            'after' => '<span class="help-block"></span>'
                        )); ?>
                    </div>

                    <div class="slide inputForm col-xs-12 hide">
                        <?php echo $this->Form->input('User.language_id', array(
                            'class' => 'selectpicker',
                            'label' => __d('paszport', "LC_PASZPORT_CREATE_LANGUAGE", true)
                        )); ?>
                    </div>

                    <div class="slide inputForm sendForm col-xs-12">
                        <?php echo $this->Form->submit(__d('paszport', 'LC_PASZPORT_REGISTER_BUTTON'), array('class' => 'btn btn-primary sendForm')); ?>
                    </div>

                    <div class="slide or col-xs-12">
                        <?php echo __d('paszport', 'LC_PASZPORT_MODAL_REGISTER_VIA_FACEBOOK') ?>
                    </div>

                    <div class="slide logInVia col-xs-12">
                        <div class="content text-center">
                            <?php echo $this->Html->link('<span class="fa fa-facebook"></span>' . __d('paszport', 'LC_PASZPORT_LOGIN'), array(
                                'plugin' => 'paszport',
                                'controller' => 'users',
                                'action' => 'fblogin'
                            ), array('class' => 'btn btn-social btn-facebook btn-md', 'escape' => false)); ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12" style="border-top: 3px solid #ECEEEF; margin-top: 15px;">
                        <div class="help-block margin-top-20" id="law_confirmation">
	                        <div id="law_confirmation_checkbox_wrapper">
		                        <input type="checkbox" name="law_confirmed" value="1" id="law_confirmation_checkbox" />
	                        </div>
	                        <label for="law_confirmation_checkbox">Potwierdzam, że zapoznałam(em) się z treścią <a href="/regulamin" target="_blank">Regulaminu</a>, w tym <a href="/polityka-prywatnosci" target="_blank">Polityką Prywatności</a> i akceptuję jego postanowienia.</label>
                        </div>                        
                        
                        <div class="" id="registration_law_intro">
							<p>Administratorem Twoich danych osobowych jest Fundacja ePaństwo z siedzibą w Zgorzale przy ul. Pliszki 2B/1 05-500 Mysiadło.
Twoje dane osobowe będą przetwarzane w celu rejestracji i obsługi konta użytkownika w serwisie mojepanstwo.pl, a także w celach statystycznych i analitycznych administratora.<br/>
<a id="registration_law_link_more" href="#">Więcej informacji na temat przetwarzania danych osobowych</a>.</p>	                        
                        </div>
                        
                        <div id="registration_law" style="display: none;">
	                        <ol type="1">
		                        <li>Administratorem Twoich danych osobowych jest Fundacja ePaństwo z siedzibą w Zgorzale przy ul. Pliszki 2B/1 05-500 Mysiadło („Fundacja”).</li>
		                        <li>Kontakt z Fundacją jest możliwy poprzez adres e-mail: biuro@epf.org.pl lub pisemnie na adres: Nowogrodzka 25/37, 00-511 Warszawa.</li>
		                        <li>Twoje dane osobowe podane podczas rejestracji konta będą przetwarzane:
		                        	<ol type="a">
			                        	<li>w celu obsługi konta oraz świadczenia usług dostępnych w serwisie mojepanstwo.pl na zasadach opisanych w regulaminie serwisu – podstawą prawną jest niezbędność przetwarzania do wykonania umowy, której jesteś stroną (art. 6 ust. 1 lit b ogólnego rozporządzenia o ochronie danych osobowych nr 2016/679 (“Rozporządzenie 2016/679”);</li>
			                        	<li>w celu ustalenia lub dochodzenia ewentualnych roszczeń lub obrony przed takimi roszczeniami przez Fundację – podstawą prawną przetwarzania danych jest prawnie uzasadniony interes Fundacji (art. 6 ust. 1 lit f Rozporządzenia 2016/679), prawnie uzasadnionym interesem Fundacji jest umożliwienie ustalenia, dochodzenia lub obrony przed roszczeniami.</li>
		                        	</ol>
		                        </li>
			                    <li>Twoje dane osobowe mogą być przekazywane podmiotom świadczącym usługi na rzecz Fundacji, takim jak dostawcy systemów informatycznych i usług IT.</li>
			                    <li>Twoje dane osobowe będą przetwarzane przez okres świadczenia usług, do czasu usunięcia konta w serwisie mojepanstwo.pl. Okres przetwarzania może zostać każdorazowo przedłużony o okres przedawnienia roszczeń, jeżeli przetwarzanie Twoich danych osobowych będzie niezbędne dla ustalenia lub dochodzenia ewentualnych roszczeń lub obrony przed takimi roszczeniami przez Fundację.</li>
			                    <li>Przysługuje Ci prawo dostępu do Twoich danych oraz prawo żądania ich sprostowania, ich usunięcia lub ograniczenia ich przetwarzania, prawo sprzeciwu względem przetwarzania danych, prawo do przenoszenia danych oraz prawo wniesienia skargi do organu nadzorczego zajmującego się ochroną danych osobowych w państwie członkowskim Twojego zwykłego pobytu, miejsca pracy lub miejsca popełnienia domniemanego naruszenia.</li>
			                    <li>Podanie danych jest wymagane przez Fundację. Brak podania danych w zakresie wymaganym w formularzu uniemożliwi dokonanie rejestracji konta w serwisie.</li>
	                        </ol>
                        </div>
                        
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <div class="modal-footer backgroundBlue">
                    <?php echo $this->Html->link(__d('paszport', 'LC_PASZPORT_MODAL_LOGIN_LOGIN', true), '/login', array('class' => 'register', 'autocomplete' => 'off', 'target' => '_self')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
