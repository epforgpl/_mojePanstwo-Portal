<div class="api-page bdl">
    Bank danych lokalnych jest skomplikowaną strukturą danych, jednak dostęp do niej można podzielić na cztery proste
    kroki:
    <dl>
        <dt>Wybór wskaźnika [metric_id]</dt>
        <dd>
            <p>Skorzystaj z wyszukiwarki <em>/search</em>, aby znaleźć interesujący cię wskaźnik. Wskaźniki pogrupowane są
            w grupy oraz kategorie.
            </p><p>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/search?q=bezrobotni">Wyszukaj statystyki dotyczące bezrobotnych</a>
                Interesuje nas wskaźnik "Bezrobotni zarejestrowani wg poziomu wykształcenia i płci",
                którego szczegóły możemy zobaczyć <a href="http://api-v2.mojepanstwo.pl/dane/bdl_wskazniki/762">pod tym adresem</a> wskazanym przez pole <em>url</em>.
            </p>
        </dd>

        <dt>Wybór przekroju [slice]</dt>
        <dd>
            <p>Każdy wskaźnik składa się z n-wymiarowego hipersześcianu opisanego przez warstwę <em>dimensions</em> (<a
                    href="http://api-server.dev/dane/bdl_wskazniki/762?layers=dimennsions">przykład</a>).
                Konkretny przekrój to zbiór n-identyfikatorów z każdego wymiaru. Zapytanie <em>series</em> zwraca szeregi
                czasowe dla każdego przekroju, o który pytamy (dla wszystkich jeżeli brak przekroju podanego).
            </p>
            <p>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762">Wszystkie przekroje</a>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]">Bezrobotni mężczyźni z wyższym wykształceniem</a>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,*]">Bezrobotni mężczyźni i kobiety z wyższym wykształceniem</a>
            </p>
        </dd>

        <dt>Wybór szczegółowości danych wg. rejonu [wojewodztwo_id,powiat_id,gmina_id]</dt>
        <dd>
            <p>Podaj <em>id</em> konkretnego regionu lub <em>*</em>, aby otrzymać dane ze wszystkich regionów na danym
            poziomie. Pomiń parametry, aby zwrócić dane na poziomie kraju. W pojedynczym zapytaniu można zwrócić dane tylko na jednym poziomie.
                Szczegółowość danych dla danego wskaźnika określona jest przez parametry <em>bdl_wskazniki.poziom_id</em> i <em>bdl_wskazniki.poziom_str"</em>.
            </p><p>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]">Dane na poziomie kraju</a>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&wojewodztwo_id=*">Dane dla wszystkich województw</a>
                Przykład: <a href="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&powiat_id=2">Powiat augustowski</a>
            </p>
        </dd>

        <dt>Wybór okresu czasu [time_range]</dt>
        <dd>
            <p>Na razie udostępniamy wyłącznie dane roczne. Każdy zwracany szereg czasowy może zostać obcięty do określonego
            przedziału poprzez podanie parametru <em>time_range=rok_poczatkowy:rok_koncowy</em>
            </p>
            <p>
                Przykład: <a hreg="http://api-v2.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&time_range=2001:2002">Bezrobotni w latach 2001:2002</a>
            </p>
        </dd>
    </dl>

    Użyj powyższych parametrów na endpoint <em>/series</em>, aby zwrócić dane.
</div>