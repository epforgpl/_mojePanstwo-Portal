<?php
require __DIR__ . '/../lib/OAuth2.php';
require __DIR__ . '/../lib/IOAuth2Storage.php';
require __DIR__ . '/../lib/IOAuth2GrantCode.php';

/**
 * OAuth2 test cases that invovle capturing output.
 */
class OAuth2OutputTest extends PHPUnit_Extensions_OutputTestCase
{

    /**
     * @var OAuth2
     */
    private $fixture;

    /**
     * Tests OAuth2->grantAccessToken() with successful Auth code grant
     *
     */
    public function testGrantAccessTokenWithGrantAuthCodeSuccess()
    {
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'redirect_uri' => 'http://www.example.com/my/subdir',
            'client_id' => 'my_little_app',
            'client_secret' => 'b',
            'code' => 'foo'
        );
        $storedToken = array(
            'redirect_uri' => 'http://www.example.com',
            'client_id' => 'my_little_app',
            'expires' => time() + 60
        );

        $mockStorage = $this->createBaseMock('IOAuth2GrantCode');
        $mockStorage->expects($this->any())
            ->method('getAuthCode')
            ->will($this->returnValue($storedToken));

        // Successful token grant will return a JSON encoded token:
        $this->expectOutputRegex('/{"access_token":".*","expires_in":\d+,"token_type":"bearer"/');
        $this->fixture = new OAuth2($mockStorage);
        $this->fixture->grantAccessToken($inputData, array());
    }

    /**
     *
     * @param string $interfaceName
     */
    protected function createBaseMock($interfaceName)
    {
        $mockStorage = $this->getMock($interfaceName);
        $mockStorage->expects($this->any())
            ->method('checkClientCredentials')
            ->will($this->returnValue(true)); // Always return true for any combination of user/pass
        $mockStorage->expects($this->any())
            ->method('checkRestrictedGrantType')
            ->will($this->returnValue(true)); // Always return true for any combination of user/pass

        return $mockStorage;
    }

// Utility methods

    /**
     * Tests OAuth2->grantAccessToken() with successful Auth code grant, but without redreict_uri in the input
     */
    public function testGrantAccessTokenWithGrantAuthCodeSuccessWithoutRedirect()
    {
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_id' => 'my_little_app',
            'client_secret' => 'b',
            'code' => 'foo'
        );
        $storedToken = array(
            'redirect_uri' => 'http://www.example.com',
            'client_id' => 'my_little_app',
            'expires' => time() + 60
        );

        $mockStorage = $this->createBaseMock('IOAuth2GrantCode');
        $mockStorage->expects($this->any())
            ->method('getAuthCode')
            ->will($this->returnValue($storedToken));

        // Successful token grant will return a JSON encoded token:
        $this->expectOutputRegex('/{"access_token":".*","expires_in":\d+,"token_type":"bearer"/');
        $this->fixture = new OAuth2($mockStorage);
        $this->fixture->setVariable(OAuth2::CONFIG_ENFORCE_INPUT_REDIRECT, false);
        $this->fixture->grantAccessToken($inputData, array());
    }

}
