<?php

App::uses('NumberHelper', 'View/Helper');

class NumberPlusHelper extends NumberHelper
{
    /**
     * @param null $num
     * @param int $decimals
     *
     * @return float|null|string
     *
     * @see http://bakery.cakephp.org/articles/xsaint/2011/05/12/number_plus_helper
     */
    function toReadableQuantity($num = null, $decimals = 0, $percents = false)
    {

        if ($percents) {
            return $num;
        }
        if ($num) {
            switch (true) {
                case ($num < 1000000):
                    return $this->format($this->precision($this->precision($num, 0), $decimals), array(
                        'thousands' => ' ',
                        'before' => '',
                        'places' => 0
                    ));
                case ($num >= 1000000 && $num < 1000000000):
                    return $this->precision($this->precision($num, 0) / 1000000, $decimals) . ' mln ';
                case ($num >= 1000000000):
                    return $this->precision($this->precision($num, 0) / 1000000000, $decimals) . ' mld ';
                default:
                    return $num;
            }
        }

        return $num;
    }
} 