<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('api_apps', array('plugin' => 'Paszport'))) ?>
<?= $this->element('Start.pageBegin'); ?>

<div class="row">
    <div class="col-md-12">

        <h1>Twoje aplikacje korzystające z API</h1>

        <?php echo $this->Html->link('Nowa aplikacja', array('action' => 'add'), array('class' => 'addAppBtn btn btn-primary btn-sm pull-right')); ?>
        <div class="apiApps">
            <?php foreach ($apiApps as $apiApp): ?>
                <div class="key col-xs-12" data-keyid="<?php echo h($apiApp['ApiApp']['id']); ?>">
                    <? /* <div class="col-xs-1 apiLogo"></div> */ ?>
                    <div class="col-xs-9 apiInfo">
                        <h4 class="title"><?php echo h($apiApp['ApiApp']['name']); ?></h4>
                        <table class="table table-striped">
                            <?php if ($apiApp['ApiApp']['home_link']) { ?>
                                <tr>
                                    <td width="120">Strona główna</td>
                                    <td colspan="2"><a class="home_link"
                                                       href="<?= h($apiApp['ApiApp']['home_link']); ?>"><?php echo h($apiApp['ApiApp']['home_link']); ?></a>
                                    </td>
                                </tr>
                            <? } ?>
                            <?php if ($apiApp['ApiApp']['domains']) { ?>
                                <tr>
                                    <td width="120">Domeny</td>
                                    <td colspan="2"><?= $apiApp['ApiApp']['domains'] ?></td>
                                </tr>
                            <? } ?>
                            <tr>
                                <td>Opis</td>
                                <td colspan="2"><?php echo h($apiApp['ApiApp']['description']); ?></td>
                            </tr>
                            <tr>
                                <td width="120">Klucz API</td>
                                <td>
                                    <span class="apiKeyValue"
                                          data-key="<?php echo h($apiApp['ApiApp']['api_key']); ?>">*****</span>
                                </td>
                                <td width="140">
                                    <a class="btn btn-link btn-sm"
                                       onclick="var th=$(this).parents('tr').find('.apiKeyValue'); th.text(th.data('key')); setTimeout(function(){th.text('*****');}, 4000);">Pokaż</a>
                                    <?php echo $this->Form->postLink('Zresetuj', array('action' => 'reset_api_key', $apiApp['ApiApp']['id']), array('class' => 'btn btn-link btn-sm'), 'Czy na pewno chcesz zresetować klucz API? Konieczne będzie jego podmienienie we wszystkich klientach, które z niego korzystają.'); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-3 apiActionBtn optionsBtn">
                        <div class="pull-left">
                            <?php echo $this->Html->link('Edytuj', array('action' => 'edit', $apiApp['ApiApp']['id']), array('class' => 'btn btn-primary editBtn')); ?>
                            <?php echo $this->Form->postLink('Skasuj', array('action' => 'delete', $apiApp['ApiApp']['id']), array('class' => 'btn btn-danger deleteBtn'), __('Czy na pewno chcesz skasować aplikację "%s"?', $apiApp['ApiApp']['name'])); ?>
                            <? if (isset($apiApp['User'])) {
                                echo '<div class="author">Autor:<br /><a href="mailto:' . $apiApp['User']['email'] . '">' . $apiApp['User']['username'] . '</a></div>';
                            } ?>
                        </div>
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

<?= $this->element('Start.pageEnd'); ?>
