<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>

<div class="editProfile container">
    <div class="mainBlock col-md-9">
        <h3>Twoje aplikacje korzystające z API</h3>
        <?php echo $this->Html->link('Nowa aplikacja', array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>
        <div class="apiApps">
            <?php foreach ($apiApps as $apiApp): ?>
                <div class="key col-xs-12" data-keyid="<?php echo h($apiApp['ApiApp']['id']); ?>">
                    <!--<div class="col-xs-1 apiLogo">
                    </div>-->
                    <div class="col-xs-9 apiInfo">
                        <h4 class="title"><?php echo h($apiApp['ApiApp']['name']); ?></h4>
                        <a href="<?= h($apiApp['ApiApp']['home_link']); ?>"><?php echo h($apiApp['ApiApp']['home_link']); ?></a>

                        <?php if ($apiApp['ApiApp']['domains']) { ?>
                            <br/><span>Domeny: <?= $apiApp['ApiApp']['domains'] ?></span>
                        <? } ?>

                        <div class="description"><?php echo h($apiApp['ApiApp']['description']); ?></div>

                        <div class="apiGeneratedKey">
                            <span class="apiKeyValue" data-key="<?php echo h($apiApp['ApiApp']['api_key']); ?>">***</span>
                            <a class="btn btn-link btn-sm" onclick="javascript: var th=$(this).siblings('.apiKeyValue'); th.text(th.data('key')); setTimeout(function(){th.text('***');}, 4000);">Pokaż</a>
                            <?php echo $this->Form->postLink('Zresetuj', array('action' => 'reset_api_key', $apiApp['ApiApp']['id']), array('class' => 'btn btn-link btn-sm'), 'Czy na pewno chcesz zresetować klucz API? Konieczne będzie jego podmienienie we wszystkich klientach, które z niego korzystają.'); ?>
                        </div>
                    </div>
                    <div class="col-xs-3 apiActionBtn optionsBtn">
                        <div class="pull-left">
                            <?php echo $this->Html->link('Edytuj', array('action' => 'edit', $apiApp['ApiApp']['id']), array('class' => 'btn btn-primary editBtn')); ?>
                            <?php echo $this->Form->postLink('Skasuj', array('action' => 'delete', $apiApp['ApiApp']['id']), array('class' => 'btn btn-danger deleteBtn'), __('Are you sure you want to delete # %s?', $apiApp['ApiApp']['id'])); ?>
                        </div>
                        <? if (isset($apiApp['User'])) {
                            // ustawione jeżeli ogląda to admin
                            echo '<p>Autor: <a href="mailto:' . $apiApp['User']['email'] . '">' . $apiApp['User']['username'] . '</a></p>';
                        } ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center">
                <ul class="pagination pagination-sm">
                    <li>
                        <? echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')); ?>
                    </li>
                    <li>
                        <? echo $this->Paginator->numbers(array('separator' => '</li><li>')); ?>
                    </li>
                    <li>
                        <? echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')); ?>
                    </li>
                </ul>
                <div class="counter col-xs-12">
                    <small>
                        <?php echo $this->Paginator->counter(array(
                            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                        )); ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>