<?php $this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api'))) ?>

<?php $this->Combinator->add_libs('js', 'Api.technical.js'); ?>

<div id="api" class="newLayout">
    <div class="jumbotron">
        <div class="container">
            <h1>Opis techniczny</h1>

            <p>Chcesz skorzystać z naszego API? Zapoznaj się z wprowadzeniem i informacjami technicznymi wspólnymi dla
                wszystkich API aplikacji</p>
        </div>
    </div>

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
                    <li><a href="#t-object-layers">Identyfikatory obiektów</a></li>
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
                        elementów wszystkich naszych API nikomu nie zaszkodzi, a wielu programistom pomoże.</p>

                    <p>API Mojego Państwa podzielone jest na szereg API przeważnie odpowiadających aplikacjom serwisu.
                        Dzięki temu sam
                        serwis
                        jest niejako dokumentacją do API pokazując jakie dane można uzyskać wraz w informacją o filtrach
                        i
                        sortowaniach.</p>
                </div>

                <div class="section">
                    <h1 id="t-versioning">Wersjonowanie</h1>

                    <p>Każde z API wersjonowane jest osobno. Pozwala to stopniowe wprowadzanie zmian, bez konieczności
                        "podbicia wersji"
                        całego ekosystemu aplikacji.</p>

                    <p>API wersjonujemy liczbami całkowitymi poczynając od 1. Zmiana wersji API wiąże się z utraceniem
                        kompatybilności wstecznej. Może to wiązać się z usunięciem pewnych pól/metod,
                        zmianą znaczenia istniejących lub zmianą istotnych mechanizmów API (sortowania, filtrowania,
                        paginacji, autentykacji).</p>

                    <ul>
                        <li>Bazowym adresem dla wszystkich API jest <code>https://api.mojepanstwo.pl</code></li>
                        <li>Pojedyczne API dostępne jest pod adresem <code>https://api.mojepanstwo.pl/%api_slug%/</code>,
                            który
                            przekierowuje do najbardziej aktualnej wersji API
                            <br/>
                            <strong>Zastosowanie: </strong>Dla użytkowników, którzy chcą być na bieżąco z wprowadzanymi
                            zmianami. Trzeba
                            jednak w porę zareagować na informację o podbiciu wersji API.
                        </li>
                        <li>Każda wersja każdego API udostępniana jest pod niezmiennym adresem <code>https://api.mojepanstwo.pl/%api_slug%_v%duza_wersja$/</code>
                            <br/>
                            <strong>Zastosowanie: </strong>Dla użytkowników potrzebujących więcej stabilności. Starsze
                            wersje API będą
                            wyłączane po okresie przejściowym, nie krótszym niż 6 miesięcy.
                        </li>
                    </ul>

                    <p>Zachęcamy użytkowników do zarejestrowania się w serwisie. Pozwoli to nam informować o
                        wprowadzanych zmianach w
                        działaniu serwisu.
                        Będziemy ogłaszać mailowo zarówno wprowadzanie nowych wersji API aplikacji, jak i stopniowe
                        wycofywanie wersji
                        starszych.</p>
                </div>

                <div class="section">
                    <h1 id="t-errors">Obsługa błędów</h1>

                    <p>API do obsługi błędów wykorzystuje <a href="https://tools.ietf.org/html/rfc2616#page-65">standardowe</a>
                        i <a
                            href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes">mniej standardowe</a> kody
                        HTTP:
                        TODO jak obsługujemy języki?</p>
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

                    <p>Swagger-spec dostępny jest pod adresem <a
                            href="https://api.mojepanstwo.pl/swagger/api-docs"><code>https://api.mojepanstwo.pl/swagger/api-docs</code></a>.
                        Nie chcąc uzależniać się od rozwijającego standardu oferujemy także własne proste API Discovery.
                        Wystarczy
                        wejść na
                        <a href="https://api.mojepanstwo.pl/"><code>https://api.mojepanstwo.pl/</code></a> i skorzystać
                        z
                        wrodzonej
                        intuicji.</p>
                </div>

                <div class="section">
                    <h1 id="t-search">Standardowy mechanizm wyszukiwania</h1>

                    <p>API oferuje standardowy mechanizm wyszukiwania, odpytywania o dostępne pola, możliwości
                        sortowania, itp.</p>

                    <p>Dla każdego adresu oferującego wyszukiwania (np. <a
                            href="https://api.mojepanstwo.pl/kodyPocztowe"><code>https://api.mojepanstwo.pl/kodyPocztowe</code></a>)
                        istnieje kilka adresów opisujących taki zbiór danych i sposoby wyszukiwania:</p>
                    <ul>
                        <li><em><a href="https://api.mojepanstwo.pl/kodyPocztowe/sortings">sortings</a></em> -
                            Sortowania, jakich
                            można użyć podczas wyszukiwania
                        </li>
                        <li><em><a href="https://api.mojepanstwo.pl/kodyPocztowe/filters">filters</a></em> - Dostępne
                            filtry
                        </li>
                        <li><em><a href="https://api.mojepanstwo.pl/kodyPocztowe/switchers">switchers</a></em> -
                            Zagregowana filtry w
                            postaci flag 0/1
                        </li>
                    </ul>

                    <p>Wszystkie parametry wyszukiwania podaje się w części <em>query</em> zapytania (po ?).
                        Parametry tablicowe podaje się zgodnie z konwencją wykorzystywaną przez CakePHP i Rails:</p>
                    <ul>
                        <li><em>Lista elementów</em> - <code>?fields[]=imie&fields[]=nazwisko</code></li>
                        <li><em>Tablica asocjacyjna</em> -
                            <code>?conditions[imie]=Jan&conditions[nazwisko]=Kowalski</code></li>
                        <li><em>Pojedyczny element tablicy</em> - skrót w postaci <code>?fields=imie</code></li>
                    </ul>

                    <p>Podczas wyszukiwania można użyć następujących kluczy w cześci <em>query</em></p>
                    <ul>
                        <li><em>conditions</em> - Filtry ograniczające zbiór danych, można filtrować po wszystkich
                            polach, a także
                            zdefiniowanych <em>switchers</em>, np. <code>?conditions[imie]=Jan&conditions[nazwisko]=Kowalski</code>
                        </li>
                        <li><em>q</em> - Pełnotekstowe wyszukiwanie (z odmianą) po podstawowych polach, np. <code>?q=epanstwo</code>
                        </li>
                        <li><em>fields</em> - Podzbiór pól do uwzględnienia w odpowiedzi, np.
                            <code>?fields[]=imie&fields[]=nazwisko</code></li>
                        <li><em>order</em> - Sortowanie w formacie <em>"pole (desc|asc)"</em>, np. <code>?order=nazwisko
                                asc</code></li>
                        <li><em>offset</em> - Ilość pominiętych rekordów z poczatku zbioru wynikowego. Ma pierwszeństwo
                            nad
                            <em>page</em>. Przykład: druga strona to <code>?offset=10&limit=10</code></li>
                        <li><em>page</em> - Skrót pozwalający na zwracanie kolejnych stron wyników. Strony numerowane są
                            od 1. Domyślna
                            ilosć wyników na stronie to 10. Przykład: <code>?page=2</code></li>
                        <li><em>limit</em> - Ilość wyników zwróconych na stronie (domyślnie 10)</li>
                    </ul>

                    <? // TODO API cursoring - np. https://dev.twitter.com/docs/misc/cursoring ?>
                </div>

                <div class="section">
                    <h1 id="t-object-ids">Identyfikatory obiektów</h1>

                    <p>Każdy zasób udostępniany przez serwer jest jednoznacznie identyfikowany poprzez unikalny adres
                        URL (pole
                        <em>_id</em>).
                        Taki URL zapewnia także łatwą (potencjalnie automatyczną) nawigację między zasobami.</p>

                    <p>Przykładowo: <code>{"_id": "https://api.mojepanstwo.pl/dane/poslowie/1.json"}</code></p>

                    <p>Aby ułatwić linkowanie do naszego serwisu udostępniamy także dla obiektów link, pod którym
                        wysŧępuje on w
                        serwisie mojePaństwo.</p>

                    <p>Przykładowo: <code>{"_mpurl": "http://mojepanstwo.pl/dane/poslowie/1"}</code></p>
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
                GET: https://api.mojepanstwo.pl/kodyPocztowe/00-511

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

                    <p>Warstwy ładuje sie poprzez podanie w zapytaniu nazw warstw jako tablicy: <code>https://api.mojepanstwo.pl/kodyPocztowe/00-511?layers[]=obszary&layers[]=gminy</code>
                    </p>

                    <p>Istnieje także skrót pozwalający załadować wszystkie warstwy na raz: <code>https://api.mojepanstwo.pl/kodyPocztowe/00-511?layers=*</code>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <? // TODO ograniczanie dostępu do danych (API Throttling) ?>
    <? // TODO Caching (If-Modified-Since, If-Unmodified-Since,  If-Match, If-None-Match, or If-Range) ?>

</div>