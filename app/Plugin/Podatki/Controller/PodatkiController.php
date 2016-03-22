<?php

App::uses('ApplicationsController', 'Controller');

class PodatkiController extends ApplicationsController
{
    public $components = array('RequestHandler');

    public $_layout = array(
        'header' => false,
        'body' => array(
            'theme' => 'simply',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );
    

    public $settings = array(
        'id' => 'podatki',
        'title' => 'Jak są wydawane moje podatki?',
    );
    
    public function stat()
    {	
	    $data = $this->Podatki->getDataSource()->request('podatki/stat', array(
            'method' => 'POST',
            'data' => $this->request->data,
        ));
	    $this->set('data', $data);
	    $this->set('_serialize', 'data');
    }

    public function view()
    {
        $result = false;
        if ($this->request->is("POST")) {

            if (isset($this->request->data['_action']) && ($this->request->data['_action'] == 'send')) {

                // SEND DATA

                $status = $this->Podatki->sendData( $this->request->data );
                $status = true;

                $this->set('status', (boolean)$status);
                $this->set('_serialize', array('status'));
                return true;

            } elseif (!empty($this->request->data)) {
                if (
                    (count(array_filter(array_unique(array_map("floatval", $this->request->data['umowa_o_prace'])))))
                    || (count(array_filter(array_unique(array_map("floatval", $this->request->data['umowa_zlecenie'])))))
                    || (count(array_filter(array_unique(array_map("floatval", $this->request->data['umowa_o_dzielo'])))))
                    || (count(array_filter(array_unique(array_map("floatval", $this->request->data['dzialalnosc_gospodarcza'])))))
                ) {

                    $result = $this->result_sum();

                    $this->loadModel('Finanse.Finanse');
                    //$this->set('wydatki', $this->Finanse->getSpendings(2014));
                    $this->set('wydatki', array(
                        'suma' => 699177.50,
                        'dzialy' => array(
                            array(
                                'id' => 100,
                                'nazwa' => 'Ubezpieczenia społeczne',
                                'kwota' => 220434.30,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'emerytury z ZUS',
                                        'kwota' => 118709.47,
                                    ),
                                    array(
                                        'nazwa' => 'renty z ZUS',
                                        'kwota' => 39911.47,
                                    ),
                                    array(
                                        'nazwa' => 'inne świadczenia z ZUS (m.in.: dodatki do emerytur i rent, zasiłki chorobowe, macierzyńskie, pogrzebowe)',
                                        'kwota' => 21734.91,
                                    ),
                                    array(
                                        'nazwa' => 'emerytury i renty z funduszu emerytalno-rentowego rolników',
                                        'kwota' => 14494.25,
                                    ),
                                    array(
                                        'nazwa' => 'emerytury i renty służb mundurowych, sędziów i prokuratorów',
                                        'kwota' => 15683.04,
                                    ),
                                    array(
                                        'nazwa' => 'utrzymanie ZUS',
                                        'kwota' => 4079.66,
                                    ),
                                    array(
                                        'nazwa' => 'inne świadczenia z ubezpieczeń społecznych (m.in. świadczenia dla kombatantów i inwalidów wojennych, dodatki energetyczne dla emerytów, deputaty węglowe dla byłych kolejarzy)',
                                        'kwota' => 5821.50,
                                    )
                                )
                            ),
                            array(
                                'id' => 101,
                                'nazwa' => 'Nauka i edukacja',
                                'kwota' => 84209.70,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'przedszkola',
                                        'kwota' => 9063.70,
                                    ),
                                    array(
                                        'nazwa' => 'szkoły podstawowe',
                                        'kwota' => 19944.46,
                                    ),
                                    array(
                                        'nazwa' => 'gimnazja',
                                        'kwota' => 10645.20,
                                    ),
                                    array(
                                        'nazwa' => 'licea, technika, szkoły zawodowe i artystyczne',
                                        'kwota' => 12534.93,
                                    ),
                                    array(
                                        'nazwa' => 'szkolnictwo wyższe',
                                        'kwota' => 21514.90,
                                    ),
                                    array(
                                        'nazwa' => 'nauka, działalność badawczo-rozwojowa',
                                        'kwota' => 5483.20,
                                    ),
                                    array(
                                        'nazwa' => 'edukacyjna opieka wychowawcza (m.in.: świetlice szkolne, ośrodki wychowawcze, poradnie psychologiczno-pedagogiczne)',
                                        'kwota' => 4514.60,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na naukę i edukację',
                                        'kwota' => 508, 70,
                                    )
                                )
                            ),
                            array(
                                'id' => 102,
                                'nazwa' => 'Ochrona zdrowia',
                                'kwota' => 75323.00,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'wydatki NFZ na leczenie szpitalne',
                                        'kwota' => 30558.91,
                                    ),
                                    array(
                                        'nazwa' => 'wydatki NFZ na podstawową opiekę zdrowotną (tzw. pierwszego kontaktu)',
                                        'kwota' => 7638.41,
                                    ),
                                    array(
                                        'nazwa' => 'wydatki NFZ na opiekę specjalistyczną',
                                        'kwota' => 5250.94,
                                    ),
                                    array(
                                        'nazwa' => 'wydatki NFZ na inne świadczenia (m.in.: psychiatria, stomatologia, rehabilitacja)',
                                        'kwota' => 11445.95,
                                    ),
                                    array(
                                        'nazwa' => 'refundacja cen leków',
                                        'kwota' => 7183.77,
                                    ),
                                    array(
                                        'nazwa' => 'wydatki samorządów na ochronę zdrowia (m.in. dotacje na działalność i inwestycje Samodzielnych Publicznych Zakładów Opieki Zdrowotnej)',
                                        'kwota' => 3853.98,
                                    ),
                                    array(
                                        'nazwa' => 'inspekcja sanitarna i programy polityki zdrowotnej (programy polityki zdrowotnej obejmują głównie profilaktykę i promocję zdrowia)',
                                        'kwota' => 1806.64,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki w ramach ochrony zdrowia (m.in.: wydatki administracyjne NFZ, finansowanie jednostek utrzymywanych bezpośrednio przez budżet państwa, wydatki SP Zakładów Opieki Zdrowotnej finansowane z przychodów własnych - np. z odpłatności za niektóre świadczenia)',
                                        'kwota' => 7584.40,
                                    ),
                                )
                            ),
                            array(
                                'id' => 103,
                                'nazwa' => 'Drogi i transport publiczny',
                                'kwota' => 46968.20,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'drogi lokalne i wojewódzkie',
                                        'kwota' => 18067.07,
                                    ),
                                    array(
                                        'nazwa' => 'drogi krajowe (głównie autostrady i drogi ekspresowe)',
                                        'kwota' => 11725.00,
                                    ),
                                    array(
                                        'nazwa' => 'transport publiczny',
                                        'kwota' => 11213.76,
                                    ),
                                    array(
                                        'nazwa' => 'infrastruktura kolejowa',
                                        'kwota' => 3329.00,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na drogi i transport',
                                        'kwota' => 2633.37,
                                    ),
                                )
                            ),
                            array(
                                'id' => 104,
                                'nazwa' => 'Odsetki od długu publicznego',
                                'kwota' => 45376.90,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'odsetki od długu krajowego',
                                        'kwota' => 32352.18,
                                    ),
                                    array(
                                        'nazwa' => 'odsetki od długu zagranicznego',
                                        'kwota' => 10119.42,
                                    ),
                                    array(
                                        'nazwa' => 'odsetki od długu samorządów',
                                        'kwota' => 2905.31,
                                    ),
                                )
                            ),
                            array(
                                'id' => 105,
                                'nazwa' => 'Bezpieczeństwo i porządek publiczny',
                                'kwota' => 44237.40,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'obrona narodowa',
                                        'kwota' => 19117.40,
                                    ),
                                    array(
                                        'nazwa' => 'wymiar sprawiedliwości',
                                        'kwota' => 10039.40,
                                    ),
                                    array(
                                        'nazwa' => 'policja',
                                        'kwota' => 8744.64,
                                    ),
                                    array(
                                        'nazwa' => 'straż pożarna',
                                        'kwota' => 3149.11,
                                    ),
                                    array(
                                        'nazwa' => 'CBA, ABW, Agencja Wywiadu, BOR, straż graniczna',
                                        'kwota' => 2322.69,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe (m.in. straż miejska i gminna)',
                                        'kwota' => 864.17,
                                    ),
                                )
                            ),
                            array(
                                'id' => 106,
                                'nazwa' => 'Pomoc społeczna',
                                'kwota' => 41894.40,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'świadczenia rodzinne, świadczenia z funduszu alimentacyjnego, zasiłki socjalne, dodatki mieszkaniowe',
                                        'kwota' => 13195.66,
                                    ),
                                    array(
                                        'nazwa' => 'utrzymanie domów i ośrodków pomocy społecznej oraz placówek opiekuńczo-wychowawczych',
                                        'kwota' => 7160.05,
                                    ),
                                    array(
                                        'nazwa' => 'aktywne formy przeciwdziałania bezrobociu oraz utrzymanie urzędów pracy (aktywne formy przeciwdziałania bezrobociu obejmują m.in. szkolenia, stypendia, dofinansowania dla pracodawców zatrudniających osoby bezrobotne)',
                                        'kwota' => 5934.20,
                                    ),
                                    array(
                                        'nazwa' => 'zasiłki i dodatki aktywizacyjne dla bezrobotnych',
                                        'kwota' => 3809.28,
                                    ),
                                    array(
                                        'nazwa' => 'dofinansowanie do wynagrodzeń pracowników niepełnosprawnych',
                                        'kwota' => 3225.08,
                                    ),
                                    array(
                                        'nazwa' => 'opieka nad osobami niesamodzielnymi i renty socjalne (renty socjalne to świadczenia dla osób które utraciły zdolność do pracy zanim weszły na rynek pracy)',
                                        'kwota' => 2720.42,
                                    ),
                                    array(
                                        'nazwa' => 'zasiłki i świadczenia przedemerytalne',
                                        'kwota' => 2134.48,
                                    ),
                                    array(
                                        'nazwa' => 'rodziny zastępcze, centra pomocy rodzinie oraz żłobki',
                                        'kwota' => 1822.24,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki w ramach pomocy społecznej',
                                        'kwota' => 1892.98,
                                    ),

                                )
                            ),
                            array(
                                'id' => 107,
                                'nazwa' => 'Rolnictwo',
                                'kwota' => 34182.60,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'płatności obszarowe (dopłaty do gruntów dla osób prowadzących działalność rolniczą)',
                                        'kwota' => 14866.68,
                                    ),
                                    array(
                                        'nazwa' => 'dotacje w ramach Programu Rozwoju Obszarów Wiejskich',
                                        'kwota' => 9941.13,
                                    ),
                                    array(
                                        'nazwa' => 'wydatki samorządów na rolnictwo (głównie na infrastrukturę wodociągową i melioracje wodne)',
                                        'kwota' => 4240.10,
                                    ),
                                    array(
                                        'nazwa' => 'pomoc finansowa dla producentów owoców i warzyw',
                                        'kwota' => 1791.21,
                                    ),
                                    array(
                                        'nazwa' => 'koszty funkcjonowania Agencji Restrukturyzacji i Modernizacji Rolnictwa',
                                        'kwota' => 1131.60,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na rolnictwo',
                                        'kwota' => 2211.87,
                                    ),
                                )
                            ),
                            array(
                                'id' => 108,
                                'nazwa' => 'Administracja publiczna',
                                'kwota' => 29595.00,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'urzędy oraz rady gmin i miast',
                                        'kwota' => 10573.18,
                                    ),
                                    array(
                                        'nazwa' => 'starostwa i rady powiatów',
                                        'kwota' => 2414.13,
                                    ),
                                    array(
                                        'nazwa' => 'urzędy marszałkowskie i wojewódzkie oraz sejmiki województw',
                                        'kwota' => 3119.84,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na utrzymanie samorządów',
                                        'kwota' => 1786.39,
                                    ),
                                    array(
                                        'nazwa' => 'urzędy skarbowe i celne',
                                        'kwota' => 5350.75,
                                    ),
                                    array(
                                        'nazwa' => 'sprawy zagraniczne, w tym utrzymanie placówek zagranicznych',
                                        'kwota' => 1825.33,
                                    ),
                                    array(
                                        'nazwa' => 'NIK, GUS, IPN oraz Państwowa Inspekcja Pracy',
                                        'kwota' => 1160.73,
                                    ),
                                    array(
                                        'nazwa' => 'kancelarie sejmu, senatu, prezydenta, premiera oraz dotacje dla partii politycznych',
                                        'kwota' => 814.63,
                                    ), array(
                                        'nazwa' => 'utrzymanie pozostałych instytucji publicznych',
                                        'kwota' => 2550.02,
                                    ),
                                )
                            ),
                            array(
                                'id' => 109,
                                'nazwa' => 'Gospodarka mieszkaniowa, komunalna i ochrona środowiska',
                                'kwota' => 26941.80,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'wydatki samorządów na zapewnienie porządku i czystości (gospodarka ściekami, ochrona wód, oczyszczanie miast i wsi, utrzymanie zieleni, oświetlenie ulic, itd.)',
                                        'kwota' => 11675.81,
                                    ),
                                    array(
                                        'nazwa' => 'Parki Narodowe i inne obszary chronionej przyrody oraz NFOŚiGW (Narodowy Fundusz Ochrony Środowiska i Gospodarki Wodnej)',
                                        'kwota' => 2613.83,
                                    ),
                                    array(
                                        'nazwa' => 'zakłady gospodarki mieszkaniowej i inne jednostki obsługi gospodarki mieszkaniowej samorządów',
                                        'kwota' => 3907.22,
                                    ),
                                    array(
                                        'nazwa' => 'gospodarowanie gruntami i nieruchomościami w samorządach (m.in. prowadzenie ewidencji, zarządzanie pozwoleniami i wpisami, sprzedaż, dzierżawa, najem gruntów i nieruchomości)',
                                        'kwota' => 3641.07,
                                    ),
                                    array(
                                        'nazwa' => 'dopłaty do kredytów mieszkaniowych i premie od oszczędności na książeczkach mieszkaniowych',
                                        'kwota' => 1495.55,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe',
                                        'kwota' => 3608.32,
                                    ),
                                )
                            ),
                            array(
                                'id' => 110,
                                'nazwa' => 'Składka do Unii Europejskiej',
                                'kwota' => 18129.20,
                            ),
                            array(
                                'id' => 111,
                                'nazwa' => 'Kultura i sport',
                                'kwota' => 14899.00,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'wydatki budżetu państwa i samorządów na biblioteki, muzea, teatry i filharmonie',
                                        'kwota' => 3827.35,
                                    ),
                                    array(
                                        'nazwa' => 'utrzymanie domów, ośrodków i centrów kultury, świetlic, klubów',
                                        'kwota' => 2454.86,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na kulturę',
                                        'kwota' => 3879.28,
                                    ),
                                    array(
                                        'nazwa' => 'utrzymanie samorządowych obiektów sportowych i instytucji kultury fizycznej',
                                        'kwota' => 2593.01,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki na sport',
                                        'kwota' => 2144.49,
                                    ),
                                )
                            ),
                            array(
                                'id' => 112,
                                'nazwa' => 'Pozostałe',
                                'kwota' => 16985.98,
                                'subdzialy' => array(
                                    array(
                                        'nazwa' => 'przetwórstwo przemysłowe (finansowanie rozwoju przedsiębiorczości, koszty działalności Polskiej Agencji Rozwoju Przedsiębiorczości, dopłaty do kredytów eksportowych)',
                                        'kwota' => 8290.20,
                                    ),
                                    array(
                                        'nazwa' => 'działalność usługowa (m.in. cmentarze, nadzór budowlany, ośrodki dokumentacji geodezyjnej i kartograficznej)',
                                        'kwota' => 2852.50,
                                    ),
                                    array(
                                        'nazwa' => 'handel (m.in. Agencja Rynku Rolnego, promocja eksportu, Inspekcja Handlowa)',
                                        'kwota' => 1296.80,
                                    ),
                                    array(
                                        'nazwa' => 'pozostałe wydatki publiczne',
                                        'kwota' => 4546.48,
                                    ),
                                )
                            )
                        )
                    ));
                } else {
                    $this->redirect('/podatki');
                }
            } else {
                $this->redirect('/podatki');
            }
        }

        $this->set('post', $this->request->data);
        $this->set('result', $result);
    }

    private function result_sum()
    {
        $warunki_preferencyjne = $this->request->data('warunki_preferencyjne');

        $ETAT_BRUTTO = array_sum($this->request->data('umowa_o_prace')); /*przychody z umowy o pracę*/
        $ZLECENIE_BRUTTO = array_sum($this->request->data('umowa_zlecenie')); /*przychody z umowy zlecenie*/
        $DZIELO_BRUTTO = array_sum($this->request->data('umowa_o_dzielo')); /*Przychody z umowy o dzieło*/
        $DZIAL_GOSP_BRUTTO = array_sum($this->request->data('dzialalnosc_gospodarcza')); /*przychody z działalności gospodarczej*/
        $DZIAL_PREF = $warunki_preferencyjne[0] == 'Y' ? 1 : 0;
        $DZIAL_KOSZT = array_sum($this->request->data('dzialalnosc_gospodarcza_koszt')); /*koszty z działalności gospodarczej*/

        $EMERYT1 = 0.0976; /*składka na ubezpieczenie emerytalne płacona przez podatnika*/
        $RENT1 = 0.015; /*składka na ubezpieczenie rentowe płacona przez podatnika*/
        $CHOR = 0.0245; /*składka na ubezpieczenie chorobowe*/
        $NFZ = 0.09; /*składka na ubezpieczenie zdrowotne*/
        $EMERYT2 = 0.0976; /*składka na ubezpieczenie emerytalne płacona przez płatnika*/
        $RENT2 = 0.065; /*składka na ubezpieczenie rentowe płacona przez płatnika*/
        $WYPAD = 0.0193; /*ubezpieczenie wypadkowe*/
        $FP = 0.0245; /*składka na Fundusz Pracy*/
        $FGSP = 0.001; /*składka na Fundusz Gwarantowanych Świadczeń Pracowniczych*/
        $ORG_SKLADKI = 9365; /*miesięczna kwota ograniczenia podstawy składki na ub. społeczne*/
        $PROG = 7127.3333; /*próg podatkowy; wynosi 85528 zł w skali roku*/
        $POD1 = 0.18; /*stopa podatku w pierwszym progu podatkowym*/
        $POD2 = 0.32; /*stopa podatku w drugim progu podatkowym*/
        $KOSZT_U_P = 111.25; /*koszty uzyskania przychodu w przypadku pracy w jednym miejscu pracy*/
        $KW_Z_P = 46.34; /*kwota zmniejszająca podatek, 556.02 zł rocznie*/
        $PLACA_MIN = 1680; /*płaca minimalna brutto*/
        $PODST_ZDR = 3004.48; /*podstawa składki na ubezpieczenie zdrowotne; liczona jest jako 75% przeciętnego miesięcznego wynagrodzenia za IV kwartał poprzedniego roku*/

        $WARIANT = 0;
        $SKLADKI1 = 0;
        $SKLADKI2 = 0;
        $SKLADKI3 = 0;
        $PIT = 0;

        if ($DZIAL_PREF == 1) {
            $MIN_PODST_SPOL = 504; /*minimalna podstawa ubezpieczenia społecznego na preferencyjnych zasadach; liczona jest jako 30% minimalnego wynagrodzenia za pracę*/
        } else {
            $MIN_PODST_SPOL = 2247.60; /*minimalna podstawa ubezpieczenia społecznego; liczona jest jako 60% prognozowanego przeciętnego wynagrodzenia ogłoszonego na dany rok kalendarzowy*/
        }

        if ($ETAT_BRUTTO > 0 && $ZLECENIE_BRUTTO == 0 && $DZIAL_GOSP_BRUTTO == 0) {
            $WARIANT = 1;
        } else if ($ETAT_BRUTTO > 0 && $ZLECENIE_BRUTTO > 0 && $DZIAL_GOSP_BRUTTO == 0) {
            $WARIANT = 2;
        } else if ($ETAT_BRUTTO > 0 && $ZLECENIE_BRUTTO == 0 && $DZIAL_GOSP_BRUTTO > 0) {
            $WARIANT = 3;
        } else if ($ETAT_BRUTTO > 0 && $ZLECENIE_BRUTTO > 0 && $DZIAL_GOSP_BRUTTO > 0) {
            $WARIANT = 4;
        } else if ($ETAT_BRUTTO == 0 && $ZLECENIE_BRUTTO > 0 && $DZIAL_GOSP_BRUTTO == 0) {
            $WARIANT = 5;
        } else if ($ETAT_BRUTTO == 0 && $ZLECENIE_BRUTTO > 0 && $DZIAL_GOSP_BRUTTO > 0) {
            $WARIANT = 6;
        } else if ($ETAT_BRUTTO == 0 && $ZLECENIE_BRUTTO == 0 && $DZIAL_GOSP_BRUTTO > 0) {
            $WARIANT = 7;
        } else if ($ETAT_BRUTTO == 0 && $ZLECENIE_BRUTTO == 0 && $DZIAL_GOSP_BRUTTO == 0 && $DZIELO_BRUTTO > 0) {
            $WARIANT = 8;
        }

        if ($WARIANT == 1) {
            $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR);
            $ODL_SK_SPOL = $SKLADKI1;
            $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            $SKLADKI3 = ($ETAT_BRUTTO - $ODL_SK_SPOL) * $NFZ;
            $ODL_SK_ZDROW = ($ETAT_BRUTTO - $ODL_SK_SPOL) * 0.0775;
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $KOSZT_U_P - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 2) {
            if ($ETAT_BRUTTO >= $PLACA_MIN) {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR);
                $ODL_SK_SPOL = $SKLADKI1;
                $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            } else {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $ZLECENIE_BRUTTO * ($EMERYT1 + $RENT1);
                $ODL_SK_SPOL = $SKLADKI1;
                $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP) + $ZLECENIE_BRUTTO * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            }
            $SKLADKI3 = ($ETAT_BRUTTO + $ZLECENIE_BRUTTO - $ODL_SK_SPOL) * $NFZ;
            $ODL_SK_ZDROW = ($ETAT_BRUTTO + $ZLECENIE_BRUTTO - $ODL_SK_SPOL) * 0.0775;
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $ZLECENIE_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $ZLECENIE_BRUTTO * 0.2 - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 3) {
            if ($ETAT_BRUTTO >= $PLACA_MIN) {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR);
                $ODL_SK_SPOL = $SKLADKI1;
            } else {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD + $FP);
                $ODL_SK_SPOL = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            }
            $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            $SKLADKI3 = ($ETAT_BRUTTO - min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR)) * $NFZ + $PODST_ZDR * $NFZ;
            $ODL_SK_ZDROW = ($ETAT_BRUTTO - min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR)) * 0.0775 + $PODST_ZDR * 0.0775;
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $DZIAL_GOSP_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $KOSZT_U_P - $DZIAL_KOSZT - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 4) {
            $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD + $FP);
            $ODL_SK_SPOL = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            $SKLADKI3 = ($ETAT_BRUTTO - min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR)) * $NFZ + $PODST_ZDR * $NFZ;
            $ODL_SK_ZDROW = ($ETAT_BRUTTO - min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR)) * 0.0775 + $ZLECENIE_BRUTTO * 0.0775 + $PODST_ZDR * 0.0775;
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $DZIAL_GOSP_BRUTTO + $ZLECENIE_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $KOSZT_U_P - $ZLECENIE_BRUTTO * 0.2 - $DZIAL_KOSZT - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 5) {
            $SKLADKI1 = min($ZLECENIE_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1);
            $ODL_SK_SPOL = $SKLADKI1;
            $SKLADKI2 = min($ZLECENIE_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            $SKLADKI3 = ($ZLECENIE_BRUTTO - $ODL_SK_SPOL) * $NFZ;
            $ODL_SK_ZDROW = ($ZLECENIE_BRUTTO - $ODL_SK_SPOL) * 0.0775;

            $PODSTAWA_PODATKU = ceil(($ZLECENIE_BRUTTO - $ODL_SK_SPOL) + $DZIELO_BRUTTO - ($ZLECENIE_BRUTTO - $ODL_SK_SPOL) * 0.2 - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 6) {
            $SKLADKI1 = $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD + $FP);
            $ODL_SK_SPOL = $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            $SKLADKI2 = 0;
            $SKLADKI3 = $PODST_ZDR * $NFZ;
            $ODL_SK_ZDROW = $PODST_ZDR * 0.0775;
            $PODSTAWA_PODATKU = ceil($ZLECENIE_BRUTTO + $DZIAL_GOSP_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $ZLECENIE_BRUTTO * 0.2 - $DZIAL_KOSZT - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 7) {
            $SKLADKI1 = $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD + $FP);
            $ODL_SK_SPOL = $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            $SKLADKI2 = 0;
            $SKLADKI3 = $PODST_ZDR * $NFZ;
            $ODL_SK_ZDROW = $PODST_ZDR * 0.0775;
            $PODSTAWA_PODATKU = ceil($DZIAL_GOSP_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $DZIAL_KOSZT - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 8) {
            $SKLADKI1 = 0;
            $SKLADKI2 = 0;
            $SKLADKI3 = 0;
            $PODSTAWA_PODATKU = ceil($DZIELO_BRUTTO - $DZIELO_BRUTTO * 0.2);

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2);
            }
        }

        /*TODO: Przekazać wariant do Admin Panel*/

        $DOCHODY_BRUTTO = $ETAT_BRUTTO + $ZLECENIE_BRUTTO + $DZIAL_GOSP_BRUTTO + $DZIELO_BRUTTO;
        $DOCHODY_NETTO = $DOCHODY_BRUTTO - $SKLADKI1 - $SKLADKI3 - $PIT;

        $VAT_RATE = 0.0683;
        if ($DOCHODY_NETTO >= 6000 && $DOCHODY_NETTO < 9000) $VAT_RATE = 0.0739;
        if ($DOCHODY_NETTO >= 3500 && $DOCHODY_NETTO < 6000) $VAT_RATE = 0.0905;
        if ($DOCHODY_NETTO >= 2750 && $DOCHODY_NETTO < 3500) $VAT_RATE = 0.0942;
        if ($DOCHODY_NETTO >= 2250 && $DOCHODY_NETTO < 2750) $VAT_RATE = 0.0966;
        if ($DOCHODY_NETTO >= 1750 && $DOCHODY_NETTO < 2250) $VAT_RATE = 0.1003;
        if ($DOCHODY_NETTO >= 1350 && $DOCHODY_NETTO < 1750) $VAT_RATE = 0.1076;
        if ($DOCHODY_NETTO >= 900 && $DOCHODY_NETTO < 1350) $VAT_RATE = 0.1162;
        if ($DOCHODY_NETTO >= 0 && $DOCHODY_NETTO < 900) $VAT_RATE = 0.1655;

        $VAT = $DOCHODY_NETTO * $VAT_RATE;
        $AKCYZA = 0.5 * $VAT;

        $RESULT_SUM = array(
            'brutto' => number_format($DOCHODY_BRUTTO, 2, ',', ''),
            'netto' => number_format($DOCHODY_NETTO, 2, ',', ''),
            'zus_pracodawca' => number_format($SKLADKI2, 2, ',', ''),
            'zus_pracodawca_color' => '#91e8e1',
            'zus' => number_format($SKLADKI1, 2, ',', ''),
            'zus_color' => '#90ED7D',
            'zdrow' => number_format($SKLADKI3, 2, ',', ''),
            'zdrow_color' => '#F7A35C',
            'pit' => number_format($PIT, 2, ',', ''),
            'pit_color' => '#8085E9',
            'vat' => number_format($VAT, 2, ',', ''),
            'vat_color' => '#2b908f',
            'akcyza' => number_format($AKCYZA, 2, ',', ''),
            'akcyza_color' => '#7cb5ec',
        );

        return $RESULT_SUM;
    }

    public function metodologia()
    {

    }
    
    public function getChapters()
    {
	    return array();
    }
}
