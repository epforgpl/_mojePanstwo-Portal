<?php
$cookie = @json_decode(stripslashes($_COOKIE['mojePanstwo']));
if (!isset($cookie->law)) {
    ?>
    <div class="cookieLaw col-xs-10 col-sm-8 col-md-6 col-lg-4">
        <div class="cookieInfo">
            <p>Ta strona używa ciasteczek (cookies), dzięki którym nasz serwis może działać lepiej.<br><a
                    href="/regulamin" target="_self">Dowiedz się więcej</a></p>
            <button class="btn btn-primary">Ok, rozumiem</button>
        </div>
    </div>
<? } ?>
