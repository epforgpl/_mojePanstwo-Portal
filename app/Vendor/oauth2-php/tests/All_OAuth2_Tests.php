<?php

/**
 * Static test suite.
 */
class All_OAuth2_Tests extends PHPUnit_Framework_TestSuite {

	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName( 'OAuth2Suite' );

		foreach ( glob( __DIR__ . '/*Test.php' ) as $filename ) {
			require $filename;
			$class = basename( $filename, '.php' );
			$this->addTestSuite( $class );
		}
	}

	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ();
	}
}

