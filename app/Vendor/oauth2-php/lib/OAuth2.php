<?php
require 'OAuth2ServerException.php';
require 'OAuth2AuthenticateException.php';
require 'OAuth2RedirectException.php';

/**
 * @mainpage
 * OAuth 2.0 server in PHP, originally written for
 * <a href="http://www.opendining.net/"> Open Dining</a>. Supports
 * <a href="http://tools.ietf.org/html/draft-ietf-oauth-v2-20">IETF draft v20</a>.
 *
 * Source repo has sample servers implementations for
 * <a href="http://php.net/manual/en/book.pdo.php"> PHP Data Objects</a> and
 * <a href="http://www.mongodb.org/">MongoDB</a>. Easily adaptable to other
 * storage engines.
 *
 * PHP Data Objects supports a variety of databases, including MySQL,
 * Microsoft SQL Server, SQLite, and Oracle, so you can try out the sample
 * to see how it all works.
 *
 * We're expanding the wiki to include more helpful documentation, but for
 * now, your best bet is to view the oauth.php source - it has lots of
 * comments.
 *
 * @author Tim Ridgely <tim.ridgely@gmail.com>
 * @author Aaron Parecki <aaron@parecki.com>
 * @author Edison Wong <hswong3i@pantarei-design.com>
 * @author David Rochwerger <catch.dave@gmail.com>
 *
 * @see http://code.google.com/p/oauth2-php/
 * @see https://github.com/quizlet/oauth2-php
 */

/**
 * OAuth2.0 draft v20 server-side implementation.
 *
 * @todo Add support for Message Authentication Code (MAC) token type.
 *
 * @author Originally written by Tim Ridgely <tim.ridgely@gmail.com>.
 * @author Updated to draft v10 by Aaron Parecki <aaron@parecki.com>.
 * @author Debug, coding style clean up and documented by Edison Wong <hswong3i@pantarei-design.com>.
 * @author Refactored (including separating from raw POST/GET) and updated to draft v20 by David Rochwerger <catch.dave@gmail.com>.
 */
class OAuth2 {

	/**
	 * Default values for configuration options.
	 *
	 * @var int
	 * @see OAuth2::setDefaultOptions()
	 */
	const DEFAULT_ACCESS_TOKEN_LIFETIME = 3600;
	const DEFAULT_REFRESH_TOKEN_LIFETIME = 1209600;
	const DEFAULT_AUTH_CODE_LIFETIME = 30;
	const DEFAULT_WWW_REALM = 'Service';
	/**
	 * Configurable options.
	 *
	 * @var string
	 */
	const CONFIG_ACCESS_LIFETIME = 'access_token_lifetime';
	const CONFIG_REFRESH_LIFETIME = 'refresh_token_lifetime';
	const CONFIG_AUTH_LIFETIME = 'auth_code_lifetime';
	const CONFIG_SUPPORTED_SCOPES = 'supported_scopes'; // The lifetime of access token in seconds.
	const CONFIG_TOKEN_TYPE = 'token_type'; // The lifetime of refresh token in seconds.
	const CONFIG_WWW_REALM = 'realm'; // The lifetime of auth code in seconds.
	const CONFIG_ENFORCE_INPUT_REDIRECT = 'enforce_redirect'; // Array of scopes you want to support
	const CONFIG_ENFORCE_STATE = 'enforce_state'; // Token type to respond with. Currently only "Bearer" supported.
	/**
	 * Regex to filter out the client identifier (described in Section 2 of IETF draft).
	 *
	 * IETF draft does not prescribe a format for these, however I've arbitrarily
	 * chosen alphanumeric strings with hyphens and underscores, 3-32 characters
	 * long.
	 *
	 * Feel free to change.
	 */
	const CLIENT_ID_REGEXP = '/^[a-z0-9-_]{3,32}$/i';
	/**
	 * Used to define the name of the OAuth access token parameter
	 * (POST & GET). This is for the "bearer" token type.
	 * Other token types may use different methods and names.
	 *
	 * IETF Draft section 2 specifies that it should be called "access_token"
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-06#section-2.2
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-06#section-2.3
	 */
	const TOKEN_PARAM_NAME = 'access_token'; // Set to true to enforce redirect_uri on input for both authorize and token steps.
	/**
	 * When using the bearer token type, there is a specifc Authorization header
	 * required: "Bearer"
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-04#section-2.1
	 */
	const TOKEN_BEARER_HEADER_NAME = 'Bearer'; // Set to true to enforce state to be passed in authorization (see http://tools.ietf.org/html/draft-ietf-oauth-v2-21#section-10.12)
	/**
	 * List of possible authentication response types.
	 * The "authorization_code" mechanism exclusively supports 'code'
	 * and the "implicit" mechanism exclusively supports 'token'.
	 *
	 * @var string
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.1
	 */
	const RESPONSE_TYPE_AUTH_CODE = 'code';

	/**
	 * @defgroup oauth2_section_5 Accessing a Protected Resource
	 * @{
	 *
	 * Clients access protected resources by presenting an access token to
	 * the resource server. Access tokens act as bearer tokens, where the
	 * token string acts as a shared symmetric secret. This requires
	 * treating the access token with the same care as other secrets (e.g.
	 * end-user passwords). Access tokens SHOULD NOT be sent in the clear
	 * over an insecure channel.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-7
	 */
	const RESPONSE_TYPE_ACCESS_TOKEN = 'token';
	/**
	 * Grant types support by draft 20
	 */
	const GRANT_TYPE_AUTH_CODE = 'authorization_code';

	/**
	 * @}
	 */

	/**
	 * @defgroup oauth2_section_4 Obtaining Authorization
	 * @{
	 *
	 * When the client interacts with an end-user, the end-user MUST first
	 * grant the client authorization to access its protected resources.
	 * Once obtained, the end-user authorization grant is expressed as an
	 * authorization code which the client uses to obtain an access token.
	 * To obtain an end-user authorization, the client sends the end-user to
	 * the end-user authorization endpoint.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4
	 */
	const GRANT_TYPE_IMPLICIT = 'token';
	const GRANT_TYPE_USER_CREDENTIALS = 'password';

	/**
	 * @}
	 */

	/**
	 * @defgroup oauth2_section_5 Obtaining an Access Token
	 * @{
	 *
	 * The client obtains an access token by authenticating with the
	 * authorization server and presenting its authorization grant (in the form of
	 * an authorization code, resource owner credentials, an assertion, or a
	 * refresh token).
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4
	 */
	const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';
	const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';
	const GRANT_TYPE_EXTENSIONS = 'extensions';
	/**
	 * Regex to filter out the grant type.
	 * NB: For extensibility, the grant type can be a URI
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.5
	 */
	const GRANT_TYPE_REGEXP = '#^(authorization_code|token|password|client_credentials|refresh_token|http://.*)$#';
	/**
	 * Possible token types as defined by draft 20.
	 *
	 * TODO: Add support for mac (and maybe other types?)
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-7.1
	 */
	const TOKEN_TYPE_BEARER = 'bearer';
	const TOKEN_TYPE_MAC = 'mac';
	/**
	 * HTTP status codes for successful and error states as specified by draft 20.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const HTTP_FOUND = '302 Found';

	/**
	 * @}
	 */
	const HTTP_BAD_REQUEST = '400 Bad Request';
	const HTTP_UNAUTHORIZED = '401 Unauthorized'; // Currently unsupported


	/**
	 * @defgroup self::HTTP_status HTTP status code
	 * @{
	 */
	const HTTP_FORBIDDEN = '403 Forbidden';
	const HTTP_UNAVAILABLE = '503 Service Unavailable';
	/**
	 * The request is missing a required parameter, includes an unsupported
	 * parameter or parameter value, or is otherwise malformed.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_INVALID_REQUEST = 'invalid_request';
	/**
	 * The client identifier provided is invalid.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_INVALID_CLIENT = 'invalid_client';
	/**
	 * The client is not authorized to use the requested response type.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_UNAUTHORIZED_CLIENT = 'unauthorized_client';

	/**
	 * @}
	 */

	/**
	 * @defgroup oauth2_error Error handling
	 * @{
	 *
	 * @todo Extend for i18n.
	 * @todo Consider moving all error related functionality into a separate class.
	 */
	/**
	 * The redirection URI provided does not match a pre-registered value.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-3.1.2.4
	 */
	const ERROR_REDIRECT_URI_MISMATCH = 'redirect_uri_mismatch';
	/**
	 * The end-user or authorization server denied the request.
	 * This could be returned, for example, if the resource owner decides to reject
	 * access to the client at a later point.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 */
	const ERROR_USER_DENIED = 'access_denied';
	/**
	 * The requested response type is not supported by the authorization server.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 */
	const ERROR_UNSUPPORTED_RESPONSE_TYPE = 'unsupported_response_type';
	/**
	 * The requested scope is invalid, unknown, or malformed.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 */
	const ERROR_INVALID_SCOPE = 'invalid_scope';
	/**
	 * The provided authorization grant is invalid, expired,
	 * revoked, does not match the redirection URI used in the
	 * authorization request, or was issued to another client.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_INVALID_GRANT = 'invalid_grant';
	/**
	 * The authorization grant is not supported by the authorization server.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_UNSUPPORTED_GRANT_TYPE = 'unsupported_grant_type';
	/**
	 * The request requires higher privileges than provided by the access token.
	 * The resource server SHOULD respond with the HTTP 403 (Forbidden) status
	 * code and MAY include the "scope" attribute with the scope necessary to
	 * access the protected resource.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 */
	const ERROR_INSUFFICIENT_SCOPE = 'invalid_scope';
	/**
	 * Array of persistent variables stored.
	 */
	protected $conf = array();
	/**
	 * Storage engine for authentication server
	 *
	 * @var IOAuth2Storage
	 */
	protected $storage;
	/**
	 * Keep track of the old refresh token. So we can unset
	 * the old refresh tokens when a new one is issued.
	 *
	 * @var string
	 */
	protected $oldRefreshToken;

	/**
	 * @}
	 */

	/**
	 * Creates an OAuth2.0 server-side instance.
	 *
	 * @param $config - An associative array as below of config options. See CONFIG_* constants.
	 */
	public function __construct( IOAuth2Storage $storage, $config = array() ) {
		$this->storage = $storage;

		// Configuration options
		$this->setDefaultOptions();
		foreach ( $config as $name => $value ) {
			$this->setVariable( $name, $value );
		}
	}

	/**
	 * Default configuration options are specified here.
	 */
	protected function setDefaultOptions() {
		$this->conf = array(
			self::CONFIG_ACCESS_LIFETIME        => self::DEFAULT_ACCESS_TOKEN_LIFETIME,
			self::CONFIG_REFRESH_LIFETIME       => self::DEFAULT_REFRESH_TOKEN_LIFETIME,
			self::CONFIG_AUTH_LIFETIME          => self::DEFAULT_AUTH_CODE_LIFETIME,
			self::CONFIG_WWW_REALM              => self::DEFAULT_WWW_REALM,
			self::CONFIG_TOKEN_TYPE             => self::TOKEN_TYPE_BEARER,
			self::CONFIG_ENFORCE_INPUT_REDIRECT => false,
			self::CONFIG_ENFORCE_STATE          => false,
			self::CONFIG_SUPPORTED_SCOPES       => array()
			// This is expected to be passed in on construction. Scopes can be an aribitrary string.
		);
	}

	/**
	 * Sets a persistent variable.
	 *
	 * @param $name
	 * The name of the variable to set.
	 * @param $value
	 * The value to set.
	 */
	public function setVariable( $name, $value ) {
		$name = strtolower( $name );

		$this->conf[ $name ] = $value;

		return $this;
	}

	/**
	 * Check that a valid access token has been provided.
	 * The token is returned (as an associative array) if valid.
	 *
	 * The scope parameter defines any required scope that the token must have.
	 * If a scope param is provided and the token does not have the required
	 * scope, we bounce the request.
	 *
	 * Some implementations may choose to return a subset of the protected
	 * resource (i.e. "public" data) if the user has not provided an access
	 * token or if the access token is invalid or expired.
	 *
	 * The IETF spec says that we should send a 401 Unauthorized header and
	 * bail immediately so that's what the defaults are set to. You can catch
	 * the exception thrown and behave differently if you like (log errors, allow
	 * public access for missing tokens, etc)
	 *
	 * @param $scope
	 * A space-separated string of required scope(s), if you want to check
	 * for scope.
	 *
	 * @return array
	 * Token
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-7
	 *
	 * @ingroup oauth2_section_7
	 */
	public function verifyAccessToken( $token_param, $scope = null ) {
		$tokenType = $this->getVariable( self::CONFIG_TOKEN_TYPE );
		$realm     = $this->getVariable( self::CONFIG_WWW_REALM );

		if ( ! $token_param ) { // Access token was not provided
			throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'The request is missing a required parameter, includes an unsupported parameter or parameter value, repeats the same parameter, uses more than one method for including an access token, or is otherwise malformed.', $scope );
		}

		// Get the stored token data (from the implementing subclass)
		$token = $this->storage->getAccessToken( $token_param );
		if ( $token === null ) {
			throw new OAuth2AuthenticateException( self::HTTP_UNAUTHORIZED, $tokenType, $realm, self::ERROR_INVALID_GRANT, 'The access token provided is invalid.', $scope );
		}

		// Check we have a well formed token
		if ( ! isset( $token["expires"] ) || ! isset( $token["client_id"] ) ) {
			throw new OAuth2AuthenticateException( self::HTTP_UNAUTHORIZED, $tokenType, $realm, self::ERROR_INVALID_GRANT, 'Malformed token (missing "expires" or "client_id")', $scope );
		}

		// Check token expiration (expires is a mandatory paramter)
		if ( isset( $token["expires"] ) && time() > $token["expires"] ) {
			throw new OAuth2AuthenticateException( self::HTTP_UNAUTHORIZED, $tokenType, $realm, self::ERROR_INVALID_GRANT, 'The access token provided has expired.', $scope );
		}

		// Check scope, if provided
		// If token doesn't have a scope, it's NULL/empty, or it's insufficient, then throw an error
		if ( $scope && ( ! isset( $token["scope"] ) || ! $token["scope"] || ! $this->checkScope( $scope, $token["scope"] ) ) ) {
			throw new OAuth2AuthenticateException( self::HTTP_FORBIDDEN, $tokenType, $realm, self::ERROR_INSUFFICIENT_SCOPE, 'The request requires higher privileges than provided by the access token.', $scope );
		}

		return $token;
	}

	// Resource protecting (Section 5).

	/**
	 * Returns a persistent variable.
	 *
	 * @param $name
	 * The name of the variable to return.
	 * @param $default
	 * The default value to use if this variable has never been set.
	 *
	 * @return
	 * The value of the variable.
	 */
	public function getVariable( $name, $default = null ) {
		$name = strtolower( $name );

		return isset( $this->conf[ $name ] ) ? $this->conf[ $name ] : $default;
	}

	/**
	 * Check if everything in required scope is contained in available scope.
	 *
	 * @param $required_scope
	 * Required scope to be check with.
	 *
	 * @return
	 * TRUE if everything in required scope is contained in available scope,
	 * and False if it isn't.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-7
	 *
	 * @ingroup oauth2_section_7
	 */
	private function checkScope( $required_scope, $available_scope ) {
		// The required scope should match or be a subset of the available scope
		if ( ! is_array( $required_scope ) ) {
			$required_scope = explode( ' ', trim( $required_scope ) );
		}

		if ( ! is_array( $available_scope ) ) {
			$available_scope = explode( ' ', trim( $available_scope ) );
		}

		return ( count( array_diff( $required_scope, $available_scope ) ) == 0 );
	}

	/** @codeCoverageIgnoreEnd */

	/**
	 * This is a convenience function that can be used to get the token, which can then
	 * be passed to verifyAccessToken(). The constraints specified by the draft are
	 * attempted to be adheared to in this method.
	 *
	 * As per the Bearer spec (draft 8, section 2) - there are three ways for a client
	 * to specify the bearer token, in order of preference: Authorization Header,
	 * POST and GET.
	 *
	 * NB: Resource servers MUST accept tokens via the Authorization scheme
	 * (http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-08#section-2).
	 *
	 * @todo Should we enforce TLS/SSL in this function?
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-08#section-2.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-08#section-2.2
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-bearer-08#section-2.3
	 *
	 * Old Android version bug (at least with version 2.2)
	 * @see http://code.google.com/p/android/issues/detail?id=6684
	 *
	 * We don't want to test this functionality as it relies on superglobals and headers:
	 * @codeCoverageIgnoreStart
	 */
	public function getBearerToken() {
		if ( isset( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
			$headers = trim( $_SERVER["HTTP_AUTHORIZATION"] );
		} elseif ( function_exists( 'apache_request_headers' ) ) {
			$requestHeaders = apache_request_headers();

			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine( array_map( 'ucwords', array_keys( $requestHeaders ) ), array_values( $requestHeaders ) );

			if ( isset( $requestHeaders['Authorization'] ) ) {
				$headers = trim( $requestHeaders['Authorization'] );
			}
		}

		$tokenType = $this->getVariable( self::CONFIG_TOKEN_TYPE );
		$realm     = $this->getVariable( self::CONFIG_WWW_REALM );

		// Check that exactly one method was used
		$methodsUsed = ! empty( $headers ) + isset( $_GET[ self::TOKEN_PARAM_NAME ] ) + isset( $_POST[ self::TOKEN_PARAM_NAME ] );
		if ( $methodsUsed > 1 ) {
			throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'Only one method may be used to authenticate at a time (Auth header, GET or POST).' );
		} elseif ( $methodsUsed == 0 ) {
			throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'The access token was not found.' );
		}

		// HEADER: Get the access token from the header
		if ( ! empty( $headers ) ) {
			if ( ! preg_match( '/' . self::TOKEN_BEARER_HEADER_NAME . '\s(\S+)/', $headers, $matches ) ) {
				throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'Malformed auth header' );
			}

			return $matches[1];
		}

		// POST: Get the token from POST data
		if ( isset( $_POST[ self::TOKEN_PARAM_NAME ] ) ) {
			if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
				throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'When putting the token in the body, the method must be POST.' );
			}

			// IETF specifies content-type. NB: Not all webservers populate this _SERVER variable
			if ( isset( $_SERVER['CONTENT_TYPE'] ) && $_SERVER['CONTENT_TYPE'] != 'application/x-www-form-urlencoded' ) {
				throw new OAuth2AuthenticateException( self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'The content type for POST requests must be "application/x-www-form-urlencoded"' );
			}

			return $_POST[ self::TOKEN_PARAM_NAME ];
		}

		// GET method
		return $_GET[ self::TOKEN_PARAM_NAME ];
	}

	// Access token granting (Section 4).

	/**
	 * Grant or deny a requested access token.
	 * This would be called from the "/token" endpoint as defined in the spec.
	 * Obviously, you can call your endpoint whatever you want.
	 *
	 * @param $inputData - The draft specifies that the parameters should be
	 * retrieved from POST, but you can override to whatever method you like.
	 *
	 * @throws OAuth2ServerException
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-21#section-10.6
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-21#section-4.1.3
	 *
	 * @ingroup oauth2_section_4
	 */
	public function grantAccessToken( array $inputData = null, array $authHeaders = null ) {
		$filters = array(
			"grant_type"    => array(
				"filter"  => FILTER_VALIDATE_REGEXP,
				"options" => array( "regexp" => self::GRANT_TYPE_REGEXP ),
				"flags"   => FILTER_REQUIRE_SCALAR
			),
			"scope"         => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"code"          => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"redirect_uri"  => array( "filter" => FILTER_SANITIZE_URL ),
			"username"      => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"password"      => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"refresh_token" => array( "flags" => FILTER_REQUIRE_SCALAR ),
		);

		// Input data by default can be either POST or GET
		if ( ! isset( $inputData ) ) {
			$inputData = ( $_SERVER['REQUEST_METHOD'] == 'POST' ) ? $_POST : $_GET;
		}

		// Basic authorization header
		$authHeaders = isset( $authHeaders ) ? $authHeaders : $this->getAuthorizationHeader();

		// Filter input data
		$input = filter_var_array( $inputData, $filters );

		// Grant Type must be specified.
		if ( ! $input["grant_type"] ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, 'Invalid grant_type parameter or parameter missing' );
		}

		// Authorize the client
		$client = $this->getClientCredentials( $inputData, $authHeaders );

		if ( $this->storage->checkClientCredentials( $client[0], $client[1] ) === false ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_CLIENT, 'The client credentials are invalid' );
		}

		if ( ! $this->storage->checkRestrictedGrantType( $client[0], $input["grant_type"] ) ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNAUTHORIZED_CLIENT, 'The grant type is unauthorized for this client_id' );
		}

		// Do the granting
		switch ( $input["grant_type"] ) {
			case self::GRANT_TYPE_AUTH_CODE:
				if ( ! ( $this->storage instanceof IOAuth2GrantCode ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}

				if ( ! $input["code"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, 'Missing parameter. "code" is required' );
				}

				if ( $this->getVariable( self::CONFIG_ENFORCE_INPUT_REDIRECT ) && ! $input["redirect_uri"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, "The redirect URI parameter is required." );
				}

				$stored = $this->storage->getAuthCode( $input["code"] );

				// Check the code exists
				if ( $stored === null || $client[0] != $stored["client_id"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT, "Refresh token doesn't exist or is invalid for the client" );
				}

				// Validate the redirect URI. If a redirect URI has been provided on input, it must be validated
				if ( $input["redirect_uri"] && ! $this->validateRedirectUri( $input["redirect_uri"], $stored["redirect_uri"] ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_REDIRECT_URI_MISMATCH, "The redirect URI is missing or do not match" );
				}

				if ( $stored["expires"] < time() ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT, "The authorization code has expired" );
				}
				break;

			case self::GRANT_TYPE_USER_CREDENTIALS:
				if ( ! ( $this->storage instanceof IOAuth2GrantUser ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}

				if ( ! $input["username"] || ! $input["password"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, 'Missing parameters. "username" and "password" required' );
				}

				$stored = $this->storage->checkUserCredentials( $client[0], $input["username"], $input["password"] );

				if ( $stored === false ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT );
				}
				break;

			case self::GRANT_TYPE_CLIENT_CREDENTIALS:
				if ( ! ( $this->storage instanceof IOAuth2GrantClient ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}

				if ( empty( $client[1] ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_CLIENT, 'The client_secret is mandatory for the "client_credentials" grant type' );
				}
				// NB: We don't need to check for $stored==false, because it was checked above already
				$stored = $this->storage->checkClientCredentialsGrant( $client[0], $client[1] );
				break;

			case self::GRANT_TYPE_REFRESH_TOKEN:
				if ( ! ( $this->storage instanceof IOAuth2RefreshTokens ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}

				if ( ! $input["refresh_token"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, 'No "refresh_token" parameter found' );
				}

				$stored = $this->storage->getRefreshToken( $input["refresh_token"] );

				if ( $stored === null || $client[0] != $stored["client_id"] ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT, 'Invalid refresh token' );
				}

				if ( $stored["expires"] < time() ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT, 'Refresh token has expired' );
				}

				// store the refresh token locally so we can delete it when a new refresh token is generated
				$this->oldRefreshToken = $stored["refresh_token"];
				break;

			case self::GRANT_TYPE_IMPLICIT:
				/* TODO: NOT YET IMPLEMENTED */
				throw new OAuth2ServerException( '501 Not Implemented', 'This OAuth2 library is not yet complete. This functionality is not implemented yet.' );
				if ( ! ( $this->storage instanceof IOAuth2GrantImplicit ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}

				break;

			// Extended grant types:
			case filter_var( $input["grant_type"], FILTER_VALIDATE_URL ):
				if ( ! ( $this->storage instanceof IOAuth2GrantExtension ) ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_UNSUPPORTED_GRANT_TYPE );
				}
				$uri    = filter_var( $input["grant_type"], FILTER_VALIDATE_URL );
				$stored = $this->storage->checkGrantExtension( $uri, $inputData, $authHeaders );

				if ( $stored === false ) {
					throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_GRANT );
				}
				break;

			default :
				throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_REQUEST, 'Invalid grant_type parameter or parameter missing' );
		}

		if ( ! isset( $stored["scope"] ) ) {
			$stored["scope"] = null;
		}

		// Check scope, if provided
		if ( $input["scope"] && ( ! is_array( $stored ) || ! isset( $stored["scope"] ) || ! $this->checkScope( $input["scope"], $stored["scope"] ) ) ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_SCOPE, 'An unsupported scope was requested.' );
		}

		$user_id = isset( $stored['user_id'] ) ? $stored['user_id'] : null;
		$token   = $this->createAccessToken( $client[0], $user_id, $stored['scope'] );

		// Send response
		$this->sendJsonHeaders();
		echo json_encode( $token );
	}

	/**
	 * Pull out the Authorization HTTP header and return it.
	 * According to draft 20, standard basic authorization is the only
	 * header variable required (this does not apply to extended grant types).
	 *
	 * Implementing classes may need to override this function if need be.
	 *
	 * @todo We may need to re-implement pulling out apache headers to support extended grant types
	 *
	 * @return
	 * An array of the basic username and password provided.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-2.4.1
	 * @ingroup oauth2_section_2
	 */
	protected function getAuthorizationHeader() {
		return array(
			'PHP_AUTH_USER' => isset( $_SERVER['PHP_AUTH_USER'] ) ? $_SERVER['PHP_AUTH_USER'] : '',
			'PHP_AUTH_PW'   => isset( $_SERVER['PHP_AUTH_PW'] ) ? $_SERVER['PHP_AUTH_PW'] : ''
		);
	}

	// End-user/client Authorization (Section 2 of IETF Draft).

	/**
	 * Internal function used to get the client credentials from HTTP basic
	 * auth or POST data.
	 *
	 * According to the spec (draft 20), the client_id can be provided in
	 * the Basic Authorization header (recommended) or via GET/POST.
	 *
	 * @return
	 * A list containing the client identifier and password, for example
	 * @code
	 * return array(
	 * CLIENT_ID,
	 * CLIENT_SECRET
	 * );
	 * @endcode
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-2.4.1
	 *
	 * @ingroup oauth2_section_2
	 */
	protected function getClientCredentials( array $inputData, array $authHeaders ) {

		// Basic Authentication is used
		if ( ! empty( $authHeaders['PHP_AUTH_USER'] ) ) {
			return array( $authHeaders['PHP_AUTH_USER'], $authHeaders['PHP_AUTH_PW'] );
		} elseif ( empty( $inputData['client_id'] ) ) { // No credentials were specified
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_CLIENT, 'Client id was not found in the headers or body' );
		} else {
			// This method is not recommended, but is supported by specification
			return array( $inputData['client_id'], $inputData['client_secret'] );
		}
	}

	/**
	 * Internal method for validating redirect URI supplied
	 *
	 * @param string $inputUri
	 * @param string $storedUri
	 */
	protected function validateRedirectUri( $inputUri, $storedUri ) {
		if ( ! $inputUri || ! $storedUri ) {
			return false; // if either one is missing, assume INVALID
		}

		return strcasecmp( substr( $inputUri, 0, strlen( $storedUri ) ), $storedUri ) === 0;
	}

	// same params as above

	/**
	 * Handle the creation of access token, also issue refresh token if support.
	 *
	 * This belongs in a separate factory, but to keep it simple, I'm just
	 * keeping it here.
	 *
	 * @param $client_id
	 * Client identifier related to the access token.
	 * @param $scope
	 * (optional) Scopes to be stored in space-separated string.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5
	 * @ingroup oauth2_section_5
	 */
	protected function createAccessToken( $client_id, $user_id, $scope = null ) {

		$token = array(
			"access_token" => $this->genAccessToken(),
			"expires_in"   => $this->getVariable( self::CONFIG_ACCESS_LIFETIME ),
			"token_type"   => $this->getVariable( self::CONFIG_TOKEN_TYPE ),
			"scope"        => $scope
		);

		$this->storage->setAccessToken( $token["access_token"], $client_id, $user_id, time() + $this->getVariable( self::CONFIG_ACCESS_LIFETIME ), $scope );

		// Issue a refresh token also, if we support them
		if ( $this->storage instanceof IOAuth2RefreshTokens ) {
			$token["refresh_token"] = $this->genAccessToken();
			$this->storage->setRefreshToken( $token["refresh_token"], $client_id, $user_id, time() + $this->getVariable( self::CONFIG_REFRESH_LIFETIME ), $scope );

			// If we've granted a new refresh token, expire the old one
			if ( $this->oldRefreshToken ) {
				$this->storage->unsetRefreshToken( $this->oldRefreshToken );
				unset( $this->oldRefreshToken );
			}
		}

		return $token;
	}

	// Other/utility functions.

	/**
	 * Generates an unique access token.
	 *
	 * Implementing classes may want to override this function to implement
	 * other access token generation schemes.
	 *
	 * @return
	 * An unique access token.
	 *
	 * @ingroup oauth2_section_4
	 * @see OAuth2::genAuthCode()
	 */
	protected function genAccessToken() {
		$tokenLen = 40;
		if ( file_exists( '/dev/urandom' ) ) { // Get 100 bytes of random data
			$randomData = file_get_contents( '/dev/urandom', false, null, 0, 100 ) . uniqid( mt_rand(), true );
		} else {
			$randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime( true ) . uniqid( mt_rand(), true );
		}

		return substr( hash( 'sha512', $randomData ), 0, $tokenLen );
	}

	/**
	 * Send out HTTP headers for JSON.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-5.2
	 *
	 * @ingroup oauth2_section_5
	 */
	private function sendJsonHeaders() {
		if ( php_sapi_name() === 'cli' || headers_sent() ) {
			return;
		}

		header( "Content-Type: application/json" );
		header( "Cache-Control: no-store" );
	}

	/**
	 * Redirect the user appropriately after approval.
	 *
	 * After the user has approved or denied the access request the
	 * authorization server should call this function to redirect the user
	 * appropriately.
	 *
	 * @param $is_authorized
	 * TRUE or FALSE depending on whether the user authorized the access.
	 * @param $user_id
	 * Identifier of user who authorized the client
	 * @param $params
	 * An associative array as below:
	 * - response_type: The requested response: an access token, an
	 * authorization code, or both.
	 * - client_id: The client identifier as described in Section 2.
	 * - redirect_uri: An absolute URI to which the authorization server
	 * will redirect the user-agent to when the end-user authorization
	 * step is completed.
	 * - scope: (optional) The scope of the access request expressed as a
	 * list of space-delimited strings.
	 * - state: (optional) An opaque value used by the client to maintain
	 * state between the request and callback.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4
	 *
	 * @ingroup oauth2_section_4
	 */
	public function finishClientAuthorization( $is_authorized, $user_id = null, $params = array() ) {
		list( $redirect_uri, $result ) = $this->getAuthResult( $is_authorized, $user_id, $params );
		$this->doRedirectUriCallback( $redirect_uri, $result );
	}

	public function getAuthResult( $is_authorized, $user_id = null, $params = array() ) {

		// We repeat this, because we need to re-validate. In theory, this could be POSTed
		// by a 3rd-party (because we are not internally enforcing NONCEs, etc)
		$params = $this->getAuthorizeParams( $params );

		$params += array( 'scope' => null, 'state' => null );
		extract( $params );

		if ( $state !== null ) {
			$result["query"]["state"] = $state;
		}

		if ( $is_authorized === false ) {
			throw new OAuth2RedirectException( $redirect_uri, self::ERROR_USER_DENIED, "The user denied access to your application", $state );
		} else {
			if ( $response_type == self::RESPONSE_TYPE_AUTH_CODE ) {
				$result["query"]["code"] = $this->createAuthCode( $client_id, $user_id, $redirect_uri, $scope );
			} elseif ( $response_type == self::RESPONSE_TYPE_ACCESS_TOKEN ) {
				$result["fragment"] = $this->createAccessToken( $client_id, $user_id, $scope );
			}
		}

		return array( $redirect_uri, $result );
	}

	/**
	 * Pull the authorization request data out of the HTTP request.
	 * - The redirect_uri is OPTIONAL as per draft 20. But your implementation can enforce it
	 * by setting CONFIG_ENFORCE_INPUT_REDIRECT to true.
	 * - The state is OPTIONAL but recommended to enforce CSRF. Draft 21 states, however, that
	 * CSRF protection is MANDATORY. You can enforce this by setting the CONFIG_ENFORCE_STATE to true.
	 *
	 * @param $inputData - The draft specifies that the parameters should be
	 * retrieved from GET, but you can override to whatever method you like.
	 *
	 * @return
	 * The authorization parameters so the authorization server can prompt
	 * the user for approval if valid.
	 *
	 * @throws OAuth2ServerException
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.1
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-21#section-10.12
	 *
	 * @ingroup oauth2_section_3
	 */
	public function getAuthorizeParams( array $inputData = null ) {
		$filters = array(
			"client_id"     => array(
				"filter"  => FILTER_VALIDATE_REGEXP,
				"options" => array( "regexp" => self::CLIENT_ID_REGEXP ),
				"flags"   => FILTER_REQUIRE_SCALAR
			),
			"response_type" => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"redirect_uri"  => array( "filter" => FILTER_SANITIZE_URL ),
			"state"         => array( "flags" => FILTER_REQUIRE_SCALAR ),
			"scope"         => array( "flags" => FILTER_REQUIRE_SCALAR )
		);

		if ( ! isset( $inputData ) ) {
			$inputData = $_GET;
		}
		$input = filter_var_array( $inputData, $filters );

		// Make sure a valid client id was supplied (we can not redirect because we were unable to verify the URI)
		if ( ! $input["client_id"] ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_CLIENT, "No client id supplied" ); // We don't have a good URI to use
		}

		// Get client details
		$stored = $this->storage->getClientDetails( $input["client_id"] );
		if ( $stored === false ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_INVALID_CLIENT, "Client id does not exist" );
		}

		// Make sure a valid redirect_uri was supplied. If specified, it must match the stored URI.
		// @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-3.1.2
		// @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
		// @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2.2.1
		if ( ! $input["redirect_uri"] && ! $stored["redirect_uri"] ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_REDIRECT_URI_MISMATCH, 'No redirect URL was supplied or stored.' );
		}
		if ( $this->getVariable( self::CONFIG_ENFORCE_INPUT_REDIRECT ) && ! $input["redirect_uri"] ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_REDIRECT_URI_MISMATCH, 'The redirect URI is mandatory and was not supplied.' );
		}
		// Only need to validate if redirect_uri provided on input and stored.
		if ( $stored["redirect_uri"] && $input["redirect_uri"] && ! $this->validateRedirectUri( $input["redirect_uri"], $stored["redirect_uri"] ) ) {
			throw new OAuth2ServerException( self::HTTP_BAD_REQUEST, self::ERROR_REDIRECT_URI_MISMATCH, 'The redirect URI provided is missing or does not match' );
		}

		// Select the redirect URI
		$input["redirect_uri"] = isset( $input["redirect_uri"] ) ? $input["redirect_uri"] : $stored["redirect_uri"];

		// type and client_id are required
		if ( ! $input["response_type"] ) {
			throw new OAuth2RedirectException( $input["redirect_uri"], self::ERROR_INVALID_REQUEST, 'Invalid or missing response type.', $input["state"] );
		}

		if ( $input['response_type'] != self::RESPONSE_TYPE_AUTH_CODE && $input['response_type'] != self::RESPONSE_TYPE_ACCESS_TOKEN ) {
			throw new OAuth2RedirectException( $input["redirect_uri"], self::ERROR_UNSUPPORTED_RESPONSE_TYPE, null, $input["state"] );
		}

		// Validate that the requested scope is supported
		if ( $input["scope"] && ! $this->checkScope( $input["scope"], $this->getVariable( self::CONFIG_SUPPORTED_SCOPES ) ) ) {
			throw new OAuth2RedirectException( $input["redirect_uri"], self::ERROR_INVALID_SCOPE, 'An unsupported scope was requested.', $input["state"] );
		}

		// Validate state parameter exists (if configured to enforce this)
		if ( $this->getVariable( self::CONFIG_ENFORCE_STATE ) && ! $input["state"] ) {
			throw new OAuth2RedirectException( $input["redirect_uri"], self::ERROR_INVALID_REQUEST, "The state parameter is required." );
		}

		// Return retrieved client details together with input
		return ( $input + $stored );
	}

	/**
	 * Handle the creation of auth code.
	 *
	 * This belongs in a separate factory, but to keep it simple, I'm just
	 * keeping it here.
	 *
	 * @param $client_id
	 * Client identifier related to the access token.
	 * @param $redirect_uri
	 * An absolute URI to which the authorization server will redirect the
	 * user-agent to when the end-user authorization step is completed.
	 * @param $scope
	 * (optional) Scopes to be stored in space-separated string.
	 *
	 * @ingroup oauth2_section_4
	 */
	private function createAuthCode( $client_id, $user_id, $redirect_uri, $scope = null ) {
		$code = $this->genAuthCode();
		$this->storage->setAuthCode( $code, $client_id, $user_id, $redirect_uri, time() + $this->getVariable( self::CONFIG_AUTH_LIFETIME ), $scope );

		return $code;
	}

	/**
	 * Generates an unique auth code.
	 *
	 * Implementing classes may want to override this function to implement
	 * other auth code generation schemes.
	 *
	 * @return
	 * An unique auth code.
	 *
	 * @ingroup oauth2_section_4
	 * @see OAuth2::genAccessToken()
	 */
	protected function genAuthCode() {
		return $this->genAccessToken(); // let's reuse the same scheme for token generation
	}

	/**
	 * Redirect the user agent.
	 *
	 * Handle both redirect for success or error response.
	 *
	 * @param $redirect_uri
	 * An absolute URI to which the authorization server will redirect
	 * the user-agent to when the end-user authorization step is completed.
	 * @param $params
	 * Parameters to be pass though buildUri().
	 *
	 * @ingroup oauth2_section_4
	 */
	private function doRedirectUriCallback( $redirect_uri, $params ) {
		header( "HTTP/1.1 " . self::HTTP_FOUND );
		header( "Location: " . $this->buildUri( $redirect_uri, $params ) );
		exit();
	}

	/**
	 * Build the absolute URI based on supplied URI and parameters.
	 *
	 * @param $uri
	 * An absolute URI.
	 * @param $params
	 * Parameters to be append as GET.
	 *
	 * @return
	 * An absolute URI with supplied parameters.
	 *
	 * @ingroup oauth2_section_4
	 */
	private function buildUri( $uri, $params ) {
		$parse_url = parse_url( $uri );

		// Add our params to the parsed uri
		foreach ( $params as $k => $v ) {
			if ( isset( $parse_url[ $k ] ) ) {
				$parse_url[ $k ] .= "&" . http_build_query( $v );
			} else {
				$parse_url[ $k ] = http_build_query( $v );
			}
		}

		// Put humpty dumpty back together
		return
			( ( isset( $parse_url["scheme"] ) ) ? $parse_url["scheme"] . "://" : "" )
			. ( ( isset( $parse_url["user"] ) ) ? $parse_url["user"]
			                                      . ( ( isset( $parse_url["pass"] ) ) ? ":" . $parse_url["pass"] : "" ) . "@" : "" )
			. ( ( isset( $parse_url["host"] ) ) ? $parse_url["host"] : "" )
			. ( ( isset( $parse_url["port"] ) ) ? ":" . $parse_url["port"] : "" )
			. ( ( isset( $parse_url["path"] ) ) ? $parse_url["path"] : "" )
			. ( ( isset( $parse_url["query"] ) ) ? "?" . $parse_url["query"] : "" )
			. ( ( isset( $parse_url["fragment"] ) ) ? "#" . $parse_url["fragment"] : "" );
	}
}
