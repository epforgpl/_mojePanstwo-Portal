<?
$this->Combinator->add_libs('js', 'Ngo.ngo-email-subscription');
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('ngo-email-subscription', array('plugin' => 'Ngo')));
?>

<div class="banner block margin-top-0">
    <div>
        <div class="img-cog pull-left">
            <span class="object-icon icon-datasets-miejsca"></span>
        </div>
        <p class="headline margin-top-20"><strong>Zapisz się</strong> <br/> do newslettera</p>
    </div>
    <div class="description margin-top-10">			
        <p class="min-height">Otrzymuj na adres e-mail najnowsze informacje z sektora organizacji pozarządowych.</p>
        <div class="text-left"><a href="#" data-toggle="modal" data-target="#ngoEmailSubscriptionModal">Dołącz do newslettera &raquo;</a></div>
    </div>
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

