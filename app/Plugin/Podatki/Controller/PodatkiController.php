<?php

App::uses('ApplicationsController', 'Controller');

class PodatkiController extends ApplicationsController
{

    public $_layout = array(
        'header' => array(
            'element' => 'browser',
        ),
        'body' => array(
            'theme' => 'simply',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );

    public $settings = array(
        'id' => 'podatki',
        'title' => 'Podatki',
    );

    public function view()
    {
        $result = false;
        if ($this->request->is("POST")) {
            if (!empty($this->request->data)) {
                $result = true;
                //debug($this->result_sum());
                $this->set('result_sum', $this->result_sum());
            } else {
                $this->redirect('/podatki');
            }
        }
        $this->set('result', $result);
    }

    private function result_sum()
    {
        $ETAT_BRUTTO = array_sum($this->request->data('umowa_o_prace'));
        $ZLECENIE_BRUTTO = array_sum($this->request->data('umowa_zlecenie'));
        $DZIELO_BRUTTO = array_sum($this->request->data('umowa_o_dzielo'));
        $DZIAL_GOSP_BRUTTO = array_sum($this->request->data('dzialalnosc_gospodarcza'));
        $DZIAL_PREF = $this->request->data('warunki_preferencyjne')[0] == 'Y' ? 1 : 0;
        $DZIAL_KOSZT = array_sum($this->request->data('dzialalnosc_gospodarcza_koszt'));

        $EMERYT1 = 0.0976;
        $RENT1 = 0.015;
        $CHOR = 0.0245;
        $NFZ = 0.09;
        $EMERYT2 = 0.0976;
        $RENT2 = 0.065;
        $WYPAD = 0.0193;
        $FP = 0.0245;
        $FGSP = 0.001;
        $ORG_SKLADKI = 9365;
        $PROG = 7127.3333;
        $POD1 = 0.18;
        $POD2 = 0.32;
        $KOSZT_U_P = 111.25;
        $KW_Z_P = 46.34;
        $PLACA_MIN = 1680;
        $PODST_ZDR = 3004.48;

        ($DZIAL_PREF == 1) ? $MIN_PODST_SPOL = 504 : $MIN_PODST_SPOL = 2247.60;

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
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - $KOSZT_U_P - ($DZIELO_BRUTTO * 0.2));

            if ($PODSTAWA_PODATKU <= $PROG) {
                $PIT = max(0, $PODSTAWA_PODATKU * $POD1 - $KW_Z_P - $ODL_SK_ZDROW);
            } else {
                $PIT = max(0, $PROG * $POD1 - $KW_Z_P + ($PODSTAWA_PODATKU - $PROG) * $POD2 - $ODL_SK_ZDROW);
            }
        } elseif ($WARIANT == 2) {
            if ($ETAT_BRUTTO >= $PLACA_MIN) {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR);
                $ODL_SK_SPOL = $SKLADKI1;
            } else {
                $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $ZLECENIE_BRUTTO * ($EMERYT1 + $RENT1);
                $ODL_SK_SPOL = $SKLADKI1;
            }
            if ($ETAT_BRUTTO >= $PLACA_MIN) {
                $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            } else {
                $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP) + $ZLECENIE_BRUTTO * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            }
            $SKLADKI3 = ($ETAT_BRUTTO + $ZLECENIE_BRUTTO - $ODL_SK_SPOL) * $NFZ;
            $ODL_SK_ZDROW = ($ETAT_BRUTTO + $ZLECENIE_BRUTTO - $ODL_SK_SPOL) * 0.0775;
            $PODSTAWA_PODATKU = ceil($ETAT_BRUTTO + $ZLECENIE_BRUTTO + $DZIELO_BRUTTO - $ODL_SK_SPOL - ($ZLECENIE_BRUTTO * 0.2) - ($DZIELO_BRUTTO * 0.2));

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
            $SKLADKI1 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            $ODL_SK_SPOL = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR) + $MIN_PODST_SPOL * ($EMERYT1 + $EMERYT2 + $RENT1 + $RENT2 + $CHOR + $WYPAD);
            $SKLADKI2 = min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT2 + $RENT2 + $WYPAD + $FP + $FGSP);
            $SKLADKI3 = ($ETAT_BRUTTO - min($ETAT_BRUTTO, $ORG_SKLADKI) * ($EMERYT1 + $RENT1 + $CHOR)) * 0.0775 + $PODST_ZDR * 0.0775;
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
            $ODL_SK_ZDROW = ($ETAT_BRUTTO - $ODL_SK_SPOL) * 0.0775;
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

        $DOCHODY_BRUTTO = $ETAT_BRUTTO + $ZLECENIE_BRUTTO + $DZIAL_GOSP_BRUTTO;
        $DOCHODY_NETTO = $DOCHODY_BRUTTO - $SKLADKI1 - $SKLADKI3 - $PIT;

        if ($DOCHODY_NETTO >= 0 && $DOCHODY_NETTO < 900) $VAT_RATE = 0.1655;
        if ($DOCHODY_NETTO >= 900 && $DOCHODY_NETTO < 1350) $VAT_RATE = 0.1162;
        if ($DOCHODY_NETTO >= 1350 && $DOCHODY_NETTO < 1750) $VAT_RATE = 0.1076;
        if ($DOCHODY_NETTO >= 1750 && $DOCHODY_NETTO < 2250) $VAT_RATE = 0.1003;
        if ($DOCHODY_NETTO >= 2250 && $DOCHODY_NETTO < 2750) $VAT_RATE = 0.0966;
        if ($DOCHODY_NETTO >= 2750 && $DOCHODY_NETTO < 3500) $VAT_RATE = 0.0942;
        if ($DOCHODY_NETTO >= 3500 && $DOCHODY_NETTO < 6000) $VAT_RATE = 0.0905;
        if ($DOCHODY_NETTO >= 6000 && $DOCHODY_NETTO < 9000) $VAT_RATE = 0.0739;
        if ($DOCHODY_NETTO >= 9000) $VAT_RATE = 0.0683;

        $VAT = $DOCHODY_NETTO * $VAT_RATE;
        $AKCYZA = 0.5 * $VAT;

        return array(
            'total' => number_format($SKLADKI1, 2, ',', ' ') + number_format($SKLADKI2, 2, ',', ' ') + number_format($SKLADKI3, 2, ',', ' ') + number_format($PIT, 2, ',', ' ') + number_format($VAT, 2, ',', ' ') + number_format($AKCYZA, 2, ',', ' '),
            'brutto' => number_format($DOCHODY_BRUTTO, 2, ',', ' '),
            'netto' => number_format($DOCHODY_NETTO, 2, ',', ' '),
            'us' => number_format($SKLADKI1, 2, ',', ' '),
            'us_pracodawca' => number_format($SKLADKI2, 2, ',', ' '),
            'zus' => number_format($SKLADKI3, 2, ',', ' '),
            'pit' => number_format($PIT, 2, ',', ' '),
            'vat' => number_format($VAT, 2, ',', ' '),
            'akcyza' => number_format($AKCYZA, 2, ',', ' '),
        );
    }
}
