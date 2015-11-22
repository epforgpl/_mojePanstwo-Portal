<?php

App::uses('ApiAppsController', 'Controller');

/**
 * ApiAppsController Test Case
 *
 */
class ApiAppsControllerTest extends ControllerTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.paszport.api_app',
        'plugin.paszport.user',
        'plugin.paszport.user_role',
        'plugin.paszport.role',
    );

    public function testIndexStandardUser() {
        $this->testAction('/paszport/api_apps?user_id=2&apiKey='. ROOT_API_KEY);

        $apps = $this->vars['apiApps'];

        $this->assertSame(array(
            array(
                'name' => 'App1',
                'description' => 'Desc1',
                'type' => 'web',
                'api_key' => '123',
                'domain' => 'example1.com',
                'user_id' => 2,
            ),
            array(
                'name' => 'App2',
                'description' => 'Desc2',
                'type' => 'backend',
                'api_key' => '234',
                'user_id' => 2,
            ),
        ), $apps);
    }

    /**
     * Admin should see all apps along with their users
     */
    public function testIndexAdmin() {
        $this->testAction('/paszport/api_apps?user_id=3&apiKey=' . ROOT_API_KEY);

        $apps = $this->vars['apiApps'];

        $this->assertSame(array(
            array(
                'name' => 'App1',
                'description' => 'Desc1',
                'type' => 'web',
                'api_key' => '123',
                'domain' => 'example1.com',
                'user_id' => 2,
                'user' => array(
                    'email' => 'ziomek2@example.com',
                    'username' => 'Ziomek 2',
                )
            ),
            array(
                'name' => 'App2',
                'description' => 'Desc2',
                'type' => 'backend',
                'api_key' => '234',
                'user_id' => 2,
                'user' => array(
                    'email' => 'ziomek2@example.com',
                    'username' => 'Ziomek 2',
                )
            ),
            array(
                'name' => 'App3',
                'description' => 'Desc3',
                'type' => 'web',
                'api_key' => '345',
                'domain' => '*.example2.com',
                'user_id' => 3,
                'user' => array(
                    'email' => 'ziomek3@example.com',
                    'username' => 'Ziomek 3',
                )
            ),
            array(
                'name' => 'App4',
                'description' => 'Desc4',
                'type' => 'backend',
                'api_key' => '456',
                'user_id' => 3,
                'user' => array(
                    'email' => 'ziomek3@example.com',
                    'username' => 'Ziomek 3',
                )
            )
        ), $apps);
    }

    /**
     * testView method
     *
     * @return void
     */
    public function testView() {
    }

    /**
     * testAdd method
     *
     * @return void
     */
    public function testAdd() {
    }

    /**
     * testEdit method
     *
     * @return void
     */
    public function testEdit() {
    }

    /**
     * testDelete method
     *
     * @return void
     */
    public function testDelete() {
    }

}
