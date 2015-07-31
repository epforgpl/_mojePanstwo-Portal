<?php
class AllTestsTest extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All tests');
        $suite->addTestDirectoryRecursive(TESTS . 'Case');
        foreach(array('Dane') as $plugin) {
            $suite->addTestDirectoryRecursive(APP . 'Plugin'. DS . $plugin . DS . 'Test' . DS . 'Case');
        }
        return $suite;
    }
}