<?php

class MpAssertions {

    public static function assertArraySameValues($expected, $actual) {
        $extra = array_diff($expected, $actual);
        $missing = array_diff($actual, $expected);
        CakeTestCase::assertSame($extra, $missing,
            "Got extra elements " . PHPUnit_Util_Type::export($extra) .
            " and some are elements missing " . PHPUnit_Util_Type::export($missing));
    }

    public static function assertUrlSamePathAndQuery($expected, $actual) {
        MpAssertions::assertUrlSame($expected, $actual, array('path', 'query'));
    }

    /**
     * @see http://php.net/manual/en/function.parse-url.php
     * @param $expected
     * @param $actual
     * @param $fields
     */
    public static function assertUrlSame($expected, $actual, $fields =
    array('host', 'path', 'query', 'fragment', 'scheme', 'port', 'user', 'pass' )) {
        $expected = parse_url($expected);
        $actual = parse_url($actual);

        foreach($fields as $fld) {
            if ($fld == 'query' and array_key_exists('query', $expected) and array_key_exists('query', $actual)) {
                $a1 = array(); $a2 = array();
                parse_str($expected['query'], $a1);
                parse_str($actual['query'], $a2);

                MpAssertions::assertArraySameValues($a1, $a2);
            } else {
                CakeTestCase::assertSame(@$expected[$fld], @$actual[$fld]);
            }
        }
    }

    public static function assertArrayMatchingKeysSame($expected, $actual) {
        CakeTestCase::assertSame(array_intersect_key($expected, $actual), array_intersect_key($actual, $expected));
    }

    public static function assertArrayMatchingKeysNotSame($expected, $actual) {
        CakeTestCase::assertNotSame(array_intersect_key($expected, $actual), array_intersect_key($actual, $expected));
    }
}