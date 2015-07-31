<?php $this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api'))) ?>

<?php $this->Combinator->add_libs('js', 'Api.technical.js'); ?>

<div id="api">
    <div class="container">
        <div class="row">
            <div id="navbar" class="navbar col-md-3 pull-left">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#t-introduction">Wstęp</a></li>
                    <li><a href="#t-versioning">Wersjonowanie</a></li>
                    <li><a href="#t-errors">Obsługa błędów</a></li>
                    <li><a href="#t-swagger">Swagger i API Discovery</a></li>
                    <li><a href="#t-search">Standardowy mechanizm wyszukiwania</a></li>
                    <li><a href="#t-object-ids">Identyfikatory obiektów</a></li>
                    <li><a href="#t-object-layers">Warstwy danych</a></li>
                </ul>
            </div>

            <div id="content" class="col-md-9 pull-right">
                <div class="section">
                    <h1 id="t-introduction">Wstęp</h1>

                    <p>Każde dobre API powinno być samodokumentujące się. Zdarza się jednak, że dążenie do zbyt
                        zwięzłego przekazu,
                        może spowodować że stanie się on niezrozumiały. Stosowanie podejścia
                        convention-over-configuration ma swoje
                        niewątpliwe zalety,
                        jednak w świecie REST API brakuje powszechnie przyjętych standardów. Z tych przyczyn
                        stwierdziliśmy, że opisanie
                        kluczowych
                        elementów naszego API nikomu nie zaszkodzi, a wielu programistom pomoże.</p>
                </div>

                <div class="section">
                    <h1 id="t-versioning">Wersjonowanie</h1>

                    <p>API wersjonujemy liczbami całkowitymi poczynając od 1. Zmiana wersji API wiąże się z utraceniem
                        kompatybilności wstecznej. Może to wiązać się z usunięciem pewnych pól/metod,
                        zmianą znaczenia istniejących lub zmianą istotnych mechanizmów API (sortowania, filtrowania,
                        paginacji, autentykacji).</p>

                    <p>Kolejne wersja API udostępniane są pod adresami o formacie <code>https://api-v%duza_wersja%.mojepanstwo.pl/</code>.
                        Starsze wersje API będą wyłączane po okresie przejściowym, nie krótszym niż 6 miesięcy.
                        Obecna wersja API to <a href="https://api-v3.mojepanstwo.pl/">V3</a>.
                    </p>

                    <p>Zachęcamy użytkowników do zarejestrowania się w serwisie. Pozwoli to nam informować o
                        wprowadzanych zmianach w
                        działaniu serwisu.
                        Będziemy ogłaszać mailowo zarówno wprowadzanie nowych wersji API aplikacji, jak i stopniowe
                        wycofywanie wersji
                        starszych. Docelowo wprowadzimy obowiązkową rejestrację w serwisie.</p>
                </div>

                <div class="section">
                    <h1 id="t-errors">Obsługa błędów</h1>

                    <p>API do obsługi błędów wykorzystuje <a href="https://tools.ietf.org/html/rfc2616#page-65">standardowe</a>
                        i <a
                            href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes">mniej standardowe</a> kody
                        HTTP:
                    </p>
                    <ul>
                        <li><code>400 Bad Request</code> - Błędne żądanie (źle sformatowane wejście, brakujące wymagane
                            parametry)
                        </li>
                        <li><code>401 Unauthorized</code> - Zasób jest dostępny, ale tylko po autentykacji klienta.
                            Należy przejść
                            proces autentykacji.
                        </li>
                        <li><code>404 Not Found</code> - Nie znaleziono zasobu. Podano niepoprawną ścieżkę.</li>
                        <li><code>418 I'm a teapot</code> - Wykonanie żądania zakończyła się oczekiwanym błędem. Błąd
                            zwracany jest w
                            postaci:
                            <pre>
                {“code”: ERROR_CODE_DICTIONARY_ENTRY, // kod błędu, opisany na konkretnym API
                 “params”: { // tablica - parametry błędu (niezależne od języka, specyficzne dla danego kodu błędu)}
                    "param1": "value1",
                 },
                 "error_description": "Długi opis w domyślnym języku, jeżeli Http Accept Language nie został podany, lub jest nieobsługiwany"
                }</pre>
                        </li>
                        <li><code>422 Unprocessable Entity</code> - Błędy wprowadzanych danych w postaci:
                            <pre>
                {"errors": {
                    "fld1": ["validation_err1", "validation_err2", ...],
                    ...
                    }
                }</pre>
                        </li>
                    </ul>
                </div>

                <div class="section">
                    <h1 id="t-swagger">Swagger i API Discovery</h1>

                    <p>Do opisu udostępnianych API zdecydowaliśmy się użyć standardu Swagger. Jest to zdobywający
                        popularność język
                        i zestaw narzędzi służących do dokumentacji API, dosŧępu do nich przez graficzny interfejs,
                        jak i generowania klientów w wielu językach.</p>

                    <p>Swagger-spec w wersji 2.0 dostępny jest pod adresem <a
                            href="https://api-v3.mojepanstwo.pl/swagger.json"><code>https://api-v3.mojepanstwo.pl/swagger.json</code></a>.
                        Propozycje zmian w API przyjmujemy jako pull-requesty ze zmianami <a href="https://github.com/epforgpl/_mojePanstwo-API-Server/blob/master/app/webroot/swagger.json">w tym pliku</a> (do edycji zalecamy użycie <a href="http://editor.swagger.io/">Swagger Editor</a>).
                    </p>

                    <p>Dla ułatwienia przeglądania API prezentujemy je za pomocą przeglądarki <a href="https://github.com/swagger-api/swagger-ui">Swagger-UI</a> na <a href="/api">stronie głównej</a>.
                    </p>
                </div>

                <div class="section">
                    <h1 id="t-search">Standardowy mechanizm wyszukiwania</h1>

                    <p>API Dane oferuje mechanizm wyszukiwania z filtrowaniem pełnotekstowym oraz po konkretnych polach,
                        stronicowaniem oraz sortowaniem.</p>

                    <p>Wszystkie parametry wyszukiwania podaje się w części <em>query</em> zapytania (po ?).
                        Parametry tablicowe podaje się zgodnie z konwencją wykorzystywaną przez CakePHP i Rails:</p>
                    <ul>
                        <li><em>Lista elementów</em> - <code>?layers[]=dataset&layers[]=details</code></li>
                        <li><em>Tablica asocjacyjna</em> -
                            <code>?conditions[imie]=Jan&conditions[nazwisko]=Kowalski</code></li>
                        <li><em>Pojedyczny element tablicy</em> - skrót w postaci <code>?layers=dataset</code></li>
                    </ul>

                    <p>Podczas wyszukiwania w cześci <em>query</em> można użyć następujących pól:</p>
                    <ul>
                        <li><em>conditions</em> - Filtry ograniczające zbiór danych, można filtrować po wszystkich
                            polach zwracanych w tablicy <code>data</code> wybranego obiektu, np. <code>?conditions[imie]=Jan&conditions[nazwisko]=Kowalski</code>
                        </li>
                        <li><em>q</em> - Pełnotekstowe wyszukiwanie (z odmianą) po podstawowych polach, np. <code>?q=epanstwo</code>
                        </li>
                        <!--<li><em>fields</em> - Podzbiór pól do uwzględnienia w odpowiedzi, np.
                            <code>?fields[]=imie&fields[]=nazwisko</code></li>-->
                        <li><em>order</em> - Sortowanie w formacie <em>"pole (desc|asc)"</em>, np. <code>?order=nazwisko
                                asc</code></li>
                        <li><em>page</em> - Numer strony wyników do zwrócenia. Strony numerowane są
                            od 1. Domyślna
                            ilosć wyników na stronie to 50. Przykład: <code>?page=2</code></li>
                        <li><em>limit</em> - Ilość wyników zwróconych na stronie (domyślnie 50)</li>
                    </ul>
                </div>

                <div class="section">
                    <h1 id="t-object-ids">Identyfikatory obiektów</h1>

                    <p>Każdy zasób udostępniany przez serwer jest jednoznacznie identyfikowany poprzez unikalny adres
                        URL (pole
                        <em>url</em>).
                        Taki URL zapewnia także łatwą (potencjalnie automatyczną) nawigację między zasobami.</p>

                    <p>Przykładowo: <code>{"url": "https://api-v3.mojepanstwo.pl/dane/poslowie/1"}</code></p>

                    <p>Aby ułatwić linkowanie do naszego serwisu udostępniamy także dla obiektów link, pod którym
                        wysŧępuje on w
                        serwisie mojePaństwo.</p>

                    <p>Przykładowo: <code>{"mp_url": "https://mojepanstwo.pl/dane/poslowie/1"}</code></p>
                </div>

                <div class="section">
                    <h1 id="t-object-layers">Warstwy danych</h1>

                    <p>Chcąc zapewnić lekką reprezentację obiektów w API i jednocześnie ułatwić dostęp do szczegółów i
                        powiązań z innymi
                        obiektami wprowadziliśmy mechanizm warstw.
                        Warstwy pozwalają na wydzielenie dodatkowych informacji o obiekcie i zostawienie decyzji
                        klientowi API, czy chce
                        te warstwy od razu otrzymać, czy doładować później.
                        Ładowanie warstw jest dostępne wyłącznie podczas zwracania pojedynczego obiektu.</p>

                    <p>
                        Listę dostępnych warstw jest wyświetlana w ramach obiektu:</p>
                        <pre>
                GET: https://api-v3.mojepanstwo.pl/dane/kody_pocztowe/1

                {
                    "id": "864053",
                    "dataset": "kody_pocztowe",
                    "object_id": 17003,
                    "data": {
                        "gminy_str": "Warszawa",
                        "id": "17003",
                        "kod": "00-511",
                        "kod_int": "511",
                        "liczba_gmin": 1,
                        "liczba_miejsc": 2,
                        "liczba_miejscowosci": 1,
                        "liczba_powiatow": 1,
                        "miejscowosci_str": "Warszawa",
                        "wojewodztwo_id": "7"
                    },
                    "score": {
                        "name": "score",
                        "value": 1,
                        "boost": false
                    },
                    "layers": {
                        "obszary": null,
                        "gminy": null,
                        "miejsca": null,
                        "miejscowosci": null,
                        "powiaty": null,
                        "struktura": null,
                        "dataset": null
                    }
                }
                        </pre>

                    <p>Warstwy ładuje sie poprzez podanie w zapytaniu nazw warstw jako tablicy: <a href="https://api-v3.mojepanstwo.pl/dane/kody_pocztowe/1?layers[]=obszary&layers[]=gminy"><code>https://api-v3.mojepanstwo.pl/dane/kody_pocztowe/1?layers[]=obszary&layers[]=gminy</code></a>
                    </p>

                    <p>Istnieje także skrót pozwalający załadować wszystkie warstwy na raz: <a href="https://api-v3.mojepanstwo.pl/dane/kody_pocztowe/1?layers=*"><code>https://api-v3.mojepanstwo.pl/dane/kody_pocztowe/1?layers=*</code></a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <? // TODO ograniczanie dostępu do danych (API Throttling) ?>
    <? // TODO Caching (If-Modified-Since, If-Unmodified-Since,  If-Match, If-None-Match, or If-Range) ?>

</div>