<?php
require __DIR__ . '/../lib/OAuth2.php';
require __DIR__ . '/../lib/IOAuth2Storage.php';
require __DIR__ . '/../lib/IOAuth2GrantCode.php';

/**
 * OAuth2 test case.
 */
class OAuth2Test extends PHPUnit_Framework_TestCase
{

    /**
     * @var OAuth2
     */
    private $fixture;

    /**
     * The actual token ID is irrelevant, so choose one:
     * @var string
     */
    private $tokenId = 'my_token';

    /**
     * Tests OAuth2->verifyAccessToken() with a missing token
     */
    public function testVerifyAccessTokenWithNoParam()
    {
        $mockStorage = $this->getMock('IOAuth2Storage');
        $this->fixture = new OAuth2($mockStorage);

        $scope = null;
        $this->setExpectedException('OAuth2AuthenticateException');
        $this->fixture->verifyAccessToken('', $scope);
    }

    /**
     * Tests OAuth2->verifyAccessToken() with a invalid token
     */
    public function testVerifyAccessTokenInvalidToken()
    {

        // Set up the mock storage to say this token does not exist
        $mockStorage = $this->getMock('IOAuth2Storage');
        $mockStorage->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue(false));

        $this->fixture = new OAuth2($mockStorage);

        $scope = null;
        $this->setExpectedException('OAuth2AuthenticateException');
        $this->fixture->verifyAccessToken($this->tokenId, $scope);
    }

    /**
     * Tests OAuth2->verifyAccessToken() with a malformed token
     *
     * @dataProvider generateMalformedTokens
     */
    public function testVerifyAccessTokenMalformedToken($token)
    {

        // Set up the mock storage to say this token does not exist
        $mockStorage = $this->getMock('IOAuth2Storage');
        $mockStorage->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($token));

        $this->fixture = new OAuth2($mockStorage);

        $scope = null;
        $this->setExpectedException('OAuth2AuthenticateException');
        $this->fixture->verifyAccessToken($this->tokenId, $scope);
    }

    /**
     * Tests OAuth2->verifyAccessToken() with different expiry dates
     *
     * @dataProvider generateExpiryTokens
     */
    public function testVerifyAccessTokenCheckExpiry($token, $expectedToPass)
    {

        // Set up the mock storage to say this token does not exist
        $mockStorage = $this->getMock('IOAuth2Storage');
        $mockStorage->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($token));

        $this->fixture = new OAuth2($mockStorage);

        $scope = null;


        // When valid, we just want any sort of token
        if ($expectedToPass) {
            $actual = $this->fixture->verifyAccessToken($this->tokenId, $scope);
            $this->assertNotEmpty($actual, "verifyAccessToken() was expected to PASS, but it failed");
            $this->assertInternalType('array', $actual);
        } else {
            $this->setExpectedException('OAuth2AuthenticateException');
            $this->fixture->verifyAccessToken($this->tokenId, $scope);
        }
    }

    /**
     * Tests OAuth2->verifyAccessToken() with different scopes
     *
     * @dataProvider generateScopes
     */
    public function testVerifyAccessTokenCheckScope($scopeRequired, $token, $expectedToPass)
    {

        // Set up the mock storage to say this token does not exist
        $mockStorage = $this->getMock('IOAuth2Storage');
        $mockStorage->expects($this->once())
            ->method('getAccessToken')
            ->will($this->returnValue($token));

        $this->fixture = new OAuth2($mockStorage);

        // When valid, we just want any sort of token
        if ($expectedToPass) {
            $actual = $this->fixture->verifyAccessToken($this->tokenId, $scopeRequired);
            $this->assertNotEmpty($actual, "verifyAccessToken() was expected to PASS, but it failed");
            $this->assertInternalType('array', $actual);
        } else {
            $this->setExpectedException('OAuth2AuthenticateException');
            $this->fixture->verifyAccessToken($this->tokenId, $scopeRequired);
        }
    }

    /**
     * Tests OAuth2->grantAccessToken() for missing data
     *
     * @dataProvider generateEmptyDataForGrant
     */
    public function testGrantAccessTokenMissingData($inputData, $authHeaders)
    {
        $mockStorage = $this->getMock('IOAuth2Storage');
        $this->fixture = new OAuth2($mockStorage);

        $this->setExpectedException('OAuth2ServerException');
        $this->fixture->grantAccessToken($inputData, $authHeaders);
    }

    /**
     * Tests OAuth2->grantAccessToken()
     *
     * Tests the different ways client credentials can be provided.
     */
    public function testGrantAccessTokenCheckClientCredentials()
    {
        $mockStorage = $this->getMock('IOAuth2Storage');
        $mockStorage->expects($this->any())
            ->method('checkClientCredentials')
            ->will($this->returnValue(true)); // Always return true for any combination of user/pass
        $this->fixture = new OAuth2($mockStorage);

        $inputData = array('grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE);
        $authHeaders = array();

        // First, confirm that an non-client related error is thrown:
        try {
            $this->fixture->grantAccessToken($inputData, $authHeaders);
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_INVALID_CLIENT, $e->getMessage());
        }

        // Confirm Auth header
        $authHeaders = array('PHP_AUTH_USER' => 'dev-abc', 'PHP_AUTH_PW' => 'pass');
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_id' => 'dev-abc'
        ); // When using auth, client_id must match
        try {
            $this->fixture->grantAccessToken($inputData, $authHeaders);
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertNotEquals(OAuth2::ERROR_INVALID_CLIENT, $e->getMessage());
        }

        // Confirm GET/POST
        $authHeaders = array();
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_id' => 'dev-abc',
            'client_secret' => 'foo'
        ); // When using auth, client_id must match
        try {
            $this->fixture->grantAccessToken($inputData, $authHeaders);
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertNotEquals(OAuth2::ERROR_INVALID_CLIENT, $e->getMessage());
        }
    }

    /**
     * Tests OAuth2->grantAccessToken() with Auth code grant
     *
     */
    public function testGrantAccessTokenWithGrantAuthCodeMandatoryParams()
    {
        $mockStorage = $this->createBaseMock('IOAuth2GrantCode');
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_id' => 'a',
            'client_secret' => 'b'
        );
        $fakeAuthCode = array(
            'client_id' => $inputData['client_id'],
            'redirect_uri' => '/foo',
            'expires' => time() + 60
        );
        $fakeAccessToken = array('access_token' => 'abcde');

        // Ensure redirect URI and auth-code is mandatory
        try {
            $this->fixture = new OAuth2($mockStorage);
            $this->fixture->setVariable(OAuth2::CONFIG_ENFORCE_INPUT_REDIRECT, true); // Only required when this is set
            $this->fixture->grantAccessToken($inputData + array('code' => 'foo'), array());
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_INVALID_REQUEST, $e->getMessage());
        }
        try {
            $this->fixture = new OAuth2($mockStorage);
            $this->fixture->grantAccessToken($inputData + array('redirect_uri' => 'foo'), array());
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_INVALID_REQUEST, $e->getMessage());
        }
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

    /**
     * Tests OAuth2->grantAccessToken() with Auth code grant
     *
     */
    public function testGrantAccessTokenWithGrantAuthCodeNoToken()
    {
        $mockStorage = $this->createBaseMock('IOAuth2GrantCode');
        $inputData = array(
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'client_id' => 'a',
            'client_secret' => 'b',
            'redirect_uri' => 'foo',
            'code' => 'foo'
        );

        // Ensure missing auth code raises an error
        try {
            $this->fixture = new OAuth2($mockStorage);
            $this->fixture->grantAccessToken($inputData + array(), array());
            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_INVALID_GRANT, $e->getMessage());
        }
    }

    /**
     * Tests OAuth2->grantAccessToken() with checks the redirect URI
     *
     */
    public function testGrantAccessTokenWithGrantAuthCodeRedirectChecked()
    {
        $inputData = array(
            'redirect_uri' => 'http://www.crossdomain.com/my/subdir',
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

        // Ensure that the redirect_uri is checked
        try {
            $this->fixture = new OAuth2($mockStorage);
            $this->fixture->grantAccessToken($inputData, array());

            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_REDIRECT_URI_MISMATCH, $e->getMessage());
        }
    }

    /**
     * Tests OAuth2->grantAccessToken() with checks the client ID is matched
     *
     */
    public function testGrantAccessTokenWithGrantAuthCodeClientIdChecked()
    {
        $inputData = array(
            'client_id' => 'another_app',
            'grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE,
            'redirect_uri' => 'http://www.example.com/my/subdir',
            'client_secret' => 'b',
            'code' => 'foo'
        );
        $storedToken = array(
            'client_id' => 'my_little_app',
            'redirect_uri' => 'http://www.example.com',
            'expires' => time() + 60
        );

        $mockStorage = $this->createBaseMock('IOAuth2GrantCode');
        $mockStorage->expects($this->any())
            ->method('getAuthCode')
            ->will($this->returnValue($storedToken));

        // Ensure the client ID is checked
        try {
            $this->fixture = new OAuth2($mockStorage);
            $this->fixture->grantAccessToken($inputData, array());

            $this->fail('The expected exception OAuth2ServerException was not thrown');
        } catch (OAuth2ServerException $e) {
            $this->assertEquals(OAuth2::ERROR_INVALID_GRANT, $e->getMessage());
        }
    }

    /**
     * Tests OAuth2->grantAccessToken() with implicit
     *
     */
    public function testGrantAccessTokenWithGrantImplicit()
    {
        $this->markTestIncomplete("grantAccessToken test not implemented");

        $this->fixture->grantAccessToken( /* parameters */);
    }

    /**
     * Tests OAuth2->grantAccessToken() with user credentials
     *
     */
    public function testGrantAccessTokenWithGrantUser()
    {
        $this->markTestIncomplete("grantAccessToken test not implemented");

        $this->fixture->grantAccessToken( /* parameters */);
    }

    /**
     * Tests OAuth2->grantAccessToken() with client credentials
     *
     */
    public function testGrantAccessTokenWithGrantClient()
    {
        $this->markTestIncomplete("grantAccessToken test not implemented");

        $this->fixture->grantAccessToken( /* parameters */);
    }

    /**
     * Tests OAuth2->grantAccessToken() with refresh token
     *
     */
    public function testGrantAccessTokenWithGrantRefresh()
    {
        $this->markTestIncomplete("grantAccessToken test not implemented");

        $this->fixture->grantAccessToken( /* parameters */);
    }

    /**
     * Tests OAuth2->grantAccessToken() with extension
     *
     */
    public function testGrantAccessTokenWithGrantExtension()
    {
        $this->markTestIncomplete("grantAccessToken test not implemented");

        $this->fixture->grantAccessToken( /* parameters */);
    }

    /**
     * Tests OAuth2->getAuthorizeParams()
     */
    public function testGetAuthorizeParams()
    {
        // TODO Auto-generated OAuth2Test->testGetAuthorizeParams()
        $this->markTestIncomplete("getAuthorizeParams test not implemented");

        $this->fixture->getAuthorizeParams( /* parameters */);

    }

    // Utility methods

    /**
     * Tests OAuth2->finishClientAuthorization()
     */
    public function testFinishClientAuthorization()
    {
        // TODO Auto-generated OAuth2Test->testFinishClientAuthorization()
        $this->markTestIncomplete("finishClientAuthorization test not implemented");

        $this->fixture->finishClientAuthorization( /* parameters */);

    }

    // Data Providers below:

    /**
     * Dataprovider for testVerifyAccessTokenMalformedToken().
     *
     * Produces malformed access tokens
     */
    public function generateMalformedTokens()
    {
        return array(
            array(array()), // an empty array as a token
            array(array('expires' => 5)), // missing client_id
            array(array('client_id' => 6)), // missing expires
            array(array('something' => 6)), // missing both 'expires' and 'client_id'
        );
    }

    /**
     * Dataprovider for testVerifyAccessTokenCheckExpiry().
     *
     * Produces malformed access tokens
     */
    public function generateExpiryTokens()
    {
        return array(
            array(array('client_id' => 'blah', 'expires' => time() - 30), false),
            // 30 seconds ago should fail
            array(array('client_id' => 'blah', 'expires' => time() - 1), false),
            // now-ish should fail
            array(array('client_id' => 'blah', 'expires' => 0), false),
            // 1970 should fail
            array(array('client_id' => 'blah', 'expires' => time() + 30), true),
            // 30 seconds in the future should be valid
            array(array('client_id' => 'blah', 'expires' => time() + 86400), true),
            // 1 day in the future should be valid
            array(array('client_id' => 'blah', 'expires' => time() + (365 * 86400)), true),
            // 1 year should be valid
            array(array('client_id' => 'blah', 'expires' => time() + (10 * 365 * 86400)), true),
            // 10 years should be valid
        );
    }

    /**
     * Dataprovider for testVerifyAccessTokenCheckExpiry().
     *
     * Produces malformed access tokens
     */
    public function generateScopes()
    {
        $baseToken = array('client_id' => 'blah', 'expires' => time() + 60);

        return array(
            array(null, $baseToken + array(), true), // missing scope is valif
            array(null, $baseToken + array('scope' => null), true), // null scope is valid
            array('', $baseToken + array('scope' => ''), true), // empty scope is valid
            array('read', $baseToken + array('scope' => 'read'), true), // exact same scope is valid
            array('read', $baseToken + array('scope' => ' read '), true), // exact same scope is valid
            array(' read ', $baseToken + array('scope' => 'read'), true), // exact same scope is valid
            array('read', $baseToken + array('scope' => 'read write delete'), true), // contains scope
            array('read', $baseToken + array('scope' => 'write read delete'), true), // contains scope
            array('read', $baseToken + array('scope' => 'delete write read'), true), // contains scope

            // Invalid combinations
            array('read', $baseToken + array('scope' => 'write'), false),
            array('read', $baseToken + array('scope' => 'apple banana'), false),
            array('read', $baseToken + array('scope' => 'apple read-write'), false),
            array('read', $baseToken + array('scope' => 'apple read,write'), false),
            array('read', $baseToken + array('scope' => null), false),
            array('read', $baseToken + array('scope' => ''), false),
        );
    }

    /**
     * Provider for OAuth2->grantAccessToken()
     */
    public function generateEmptyDataForGrant()
    {
        return array(
            array(
                array(),
                array()
            ),
            array(
                array(),
                array('grant_type' => OAuth2::GRANT_TYPE_AUTH_CODE) // grant_type in auth headers should be ignored
            ),
            array(
                array('not_grant_type' => 5),
                array()
            ),
        );
    }
}

