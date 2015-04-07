<?php $this->Combinator->add_libs('css', $this->Less->css('report_bug')) ?>

<div id="reportBug" class="container">
    <div class="row">
        <div class="content col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <h2><?= __('LC_REPORTBUG_HEADLINE') ?></h2>
            <?php echo $this->Html->link('<i class="fa fa-github"></i>' . __('LC_REPORTBUG_VIA_GITHUB'), 'https://github.com/epforgpl/_mojePanstwo-Portal/issues?state=open', array(
                'class' => 'btn btn-social btn-github btn-lg',
                'target' => '_blank',
                'escape' => false
            )); ?>

            <? /*
            <div class="separator col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <span><?= __('LC_REPORTBUG_OR') ?></span></div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= __('LC_REPORTBUG_EMAIL_HEADLINE') ?></h3>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="reportBugLink"
                                   class="col-sm-2 control-label"><?= __('LC_REPORTBUG_EMAIL_LINK') ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="reportBugLink"
                                       placeholder="<?= __('LC_REPORTBUG_EMAIL_LINK_PLACEHOLDER') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reportBugDescription"
                                   class="col-sm-2 control-label"><?= __('LC_REPORTBUG_EMAIL_DESC') ?></label>

                            <div class="col-sm-10">
                                <textarea class="form-control" id="reportBugDescription"
                                          placeholder="<?= __('LC_REPORTBUG_EMAIL_DESC_PLACEHOLDER') ?>"
                                          rows="8"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit"
                                        class="btn btn-success pull-right"><?= __('LC_REPORTBUG_EMAIL_SUBMIT') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            */
            ?>
        </div>
    </div>
</div>