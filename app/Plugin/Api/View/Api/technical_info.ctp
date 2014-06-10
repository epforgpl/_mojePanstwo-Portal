<!-- TODO add scroll -->
<div id="navbar" class="pull-left">
<ul class="nav nav-pills nav-stacked">
    <li><a href="#t-introduction">Wstęp</a></li>
    <li><a href="#t-versioning">Wersjonowanie</a></li>
    <li><a href="#t-errors">Obsługa błędów</a></li>
    <li><a href="#t-swagger">Swagger i API Discovery</a></li>
    <li><a href="#t-object-ids">Identyfikatory obiektów</a></li>
</ul>
</div>

<div id="content" class="pull-right">

    <h1 id="t-introduction">Wstęp</h1>

    <p>Każde dobre API powinno być samodokumentujące się. Zdarza się jednak, że dążenie do zbyt zwięzłego przekazu,
    może spowodować że stanie się on niezrozumiały. Stosowanie podejścia convention-over-configuration ma swoje niewątpliwe zalety,
    jednak w świecie REST API brakuje powszechnie przyjętych standardów. Z tych przyczyn stwierdziliśmy, że opisanie kluczowych
    elementów wszystkich naszych API nikomu nie zaszkodzi, a wielu programistom pomoże.</p>

    <p>API Mojego Państwa podzielone jest na szereg API przeważnie odpowiadających aplikacjom serwisu. Dzięki temu sam serwis
        jest niejako dokumentacją do API pokazując jakie dane można uzyskać wraz w informacją o filtrach i sortowaniach.</p>



    <h1 id="t-versioning">Wersjonowanie</h1>
    <p>Każde z API wersjonowane jest osobno. Pozwala to stopniowe wprowadzanie zmian, bez konieczności "podbicia wersji" całego ekosystemu aplikacji.</p>
    <p>Wersjonujemy API dwoma zmiennymi poczynając od 1 w formacie <code>duza_wersja.mala_wersja</code>.
        Zwiększenie małej wersji odpowiada wprowadzeniu nowych funkcjonalności, które nie psują kompatybilności wstecznej.
        Może to być dodanie nowych pól, metod, serwowanie nowych formatów danych.
        Zmiana dużej wersji API może wiązać się z usunięciem pewnych pól/metod,
        zmianą znaczenia istniejących lub zmianą istotnych mechanizmów API (sortowania, filtrowania, paginacji, autentykacji).
        Nowe duże wersje API są niekompatybilne wstecznie.</p>

    <ul>
        <li>Bazowym adresem dla wszystkich API jest <code>http://api.mojepanstwo.pl</code></li>
        <li>Pojedyczne API dostępne jest pod adresem <code>http://api.mojepanstwo.pl/%api_slug%/</code>, który przekierowuje do najbardziej aktualnej wersji API
            <br/>
            <strong>Zastosowanie: </strong>Dla użytkowników, którzy chcą być na bieżąco z wprowadzanymi zmianami. Trzeba jednak w porę zareagować na informację o podbiciu wersji API.</li>
        <li>Każda wersja każdego API udostępniana jest pod niezmiennym adresem <code>http://api.mojepanstwo.pl/%api_slug%/%major_version$/</code>
            <br/>
            <strong>Zastosowanie: </strong>Dla użytkowników potrzebujących więcej stabilności. Starsze wersje API będą wyłączane po dłuższym czasie.</li>
    </ul>

    <p>Zachęcamy użytkowników do zarejestrowania się w serwisie. Pozwoli to nam informować o wprowadzanych zmianach w działaniu serwisu.
        Będziemy ogłaszać mailowo zarówno wprowadzanie nowych wersji API aplikacji, jak i stopniowe wycofywanie wersji starszych.</p>



    <h1 id="t-errors">Obsługa błędów</h1>
    <p>API do obsługi błędów wykorzystuje <a href="https://tools.ietf.org/html/rfc2616#page-65">standardowe</a> i <a href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes">mniej standardowe</a> kody HTTP:
        TODO jak obsługujemy języki?</p>
    <ul>
        <li><code>400 Bad Request</code> - Błędne żądanie (źle sformatowane wejście, brakujące wymagane parametry)</li>
        <li><code>401 Unauthorized</code> - Zasób jest dostępny, ale tylko po autentykacji klienta. Należy przejść proces autentykacji.</li>
        <li><code>404 Not Found</code> - Nie znaleziono zasobu. Podano niepoprawną ścieżkę.</li>
        <li><code>418 I'm a teapot</code> - Wykonanie żądania zakończyła się oczekiwanym błędem. Błąd zwracany jest w postaci:
            <pre>
{“code”: ERROR_CODE_DICTIONARY_ENTRY, // kod błędu, opisany na konkretnym API
 “params”: { // tablica - parametry błędu (niezależne od języka, specyficzne dla danego kodu błędu)}
    "param1": "value1",
 },
 “error_description_i18n”: “Długi opis w języku zgodnym z Http Accept Language, jeżeli obsługiwany”,
 "error_description": "Długi opis w domyślnym języku, jeżeli Http Accept Language nie został podany, lub jest nieobsługiwany"
}</pre></li>
        <li><code>422 Unprocessable Entity</code> - Błędy wprowadzanych danych w postaci:
            <pre>
{"errors": {
    "fld1": ["validation_err1", "validation_err2", ...],
    ...
    }
}</pre>
        </li>
    </ul>



    <h1 id="t-swagger">Swagger i API Discovery</h1>
    <p>Do opisu udostępnianych API zdecydowaliśmy się użyć standardu Swagger. Jest to zdobywający popularność język
        i zestaw narzędzi służących do dokumentacji API, dosŧępu do nich przez graficzny interfejs,
        jak i generowania klientów w wielu językach.</p>

    <p>Swagger-spec dostępny jest pod adresem <a href="http://api.mojepanstwo.pl/swagger/api-docs"><code>http://api.mojepanstwo.pl/swagger/api-docs</code></a>.
       Nie chcąc uzależniać się od rozwijającego standardu oferujemy także własne proste API Discovery. Wystarczy wejść na
        <a href="http://api.mojepanstwo.pl/"><code>http://api.mojepanstwo.pl/</code></a> i skorzystać z wrodzonej intuicji.</p>



    <h1 id="t-object-ids">Identyfikatory obiektów</h1>
    <p>Każdy zasób udostępniany przez serwer powinien być jednoznacznie identyfikowany poprzez unikalny adres URL, oprócz posiadania identyfikatora wewnątrz wybranego datasetu.
        URL oprócz bycia unikalnym zapewnia łatwą (potencjalnie automatyczną) nawigację między zasobami.</p>

    <p>Klient może polegać na unikalności następujących pól:</p>
    <ul>
        <li><strong>object_id + dataset</strong> - Nazwa datasetu oraz unikalny identyfikatora obiektu wewnątrz datasetu
            <br/>Przykładowo: <code>{"dataset": "poslowie", "id": "1"}</code></li>
        <li><strong>TODO id</strong> - co to?</li>
        <li><strong>_url</strong> - Adres url jednoznacznie identyfikujący zasób
            <br/>Przykładowo: <code>{"_url": "http://api.mojepanstwo.pl/dane/poslowie/1.json"}</code></li>
    </ul>

    </p>

    <? // TODO ograniczanie dostępu do danych (API Throttling) ?>

    <? // TODO API cursoring ?>

    <? // TODO Caching (If-Modified-Since, If-Unmodified-Since,  If-Match, If-None-Match, or If-Range) ?>

</div>