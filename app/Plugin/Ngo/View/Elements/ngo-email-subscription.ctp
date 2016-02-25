<?
$this->Combinator->add_libs('js', 'Ngo.ngo-email-subscription');
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('ngo-email-subscription', array('plugin' => 'Ngo')));
?>

<div class="banner ngoEmailSubscription block margin-top-10">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array(
        'width' => '64',
        'alt' => 'Newsletter',
        'class' => 'pull-left'
    )); ?>
    <p><strong>Zapisz się</strong> do newslettera</p>
    <a href="#" data-toggle="modal" data-target="#ngoEmailSubscriptionModal" class="btn btn-sm btn-primary">Zapisz się</a>
</div>

<div class="modal fade" id="ngoEmailSubscriptionModal" tabindex="-1" role="dialog"
     aria-labelledby="ngoEmailSubscriptionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dołącz do newslettera</h4>
            </div>
            <form class="form-horizontal" action="/ngo/newsletter" method="post">
                <div class="modal-body margin-sides-20">
                    <!--<p class="text-center">Lorem ipsum</p>-->
                    <div class="form-cont">
                        <div class="form-group">
                            <label for="inputEmail">Adres e-mail</label>
                            <input id="inputEmail" required="required" autocomplete="off" type="email" class="form-control" name="email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary btn-icon width-auto">
                        <span class="icon" data-icon="&#xe604;"></span>Dołącz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

