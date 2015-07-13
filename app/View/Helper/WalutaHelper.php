<?php

class WalutaHelper extends AppHelper
{

    private $liczebniki = array(
        1 => array('tysiąc', 'tysiące', 'tysięcy'),
        2 => array('milion', 'miliony', 'milionów'),
        3 => array('miliard', 'miliardy', 'miliardów'),
    );

    public function slownie($input)
    {

        $parts = explode('.', $input);
        $parts_count = count($parts);

        $zl = 0;
        $gr = 0;

        if ($parts_count == 0) {

        } elseif ($parts_count == 1) {

            $zl = $parts[0];

        } elseif ($parts_count == 2) {

            $zl = $parts[0];
            $gr = $parts[1];

        }

        $data = array();

        $chunks = array_chunk(str_split(strrev($zl)), 3);
        foreach ($chunks as $i => $chunk) {

            $chunk = array_reverse($chunk);
            $number = (int)implode('', $chunk);

            if ($i) {
                $data[] = pl_dopelniacz($number, $this->liczebniki[$i][0], $this->liczebniki[$i][1], $this->liczebniki[$i][2]);
            } else {
                $data[] = pl_dopelniacz($number, 'złoty', 'złote', 'złotych');
            }

        }

        $data = array_reverse($data);

        return '<span>' . implode('</span> <span>', $data) . '</span>';

    }

}