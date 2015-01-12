<?php
/**
 *
 * Unit tests or ExpandableBehavior
 */
App::uses('Model', 'Model');
App::uses('AppModel', 'Model');

/**
 * User test Model class class
 */
class User extends AppModel
{
    public $name = 'User';
    public $actsAs = array('Expandable.Expandable' => array('with' => 'UserExpand'), 'Containable');
    public $hasMany = array('Expandable.UserExpand');
    public $recursive = -1;
}

/**
 * ExpandableTest class
 *
 * @package       Cake.Test.Case.Model.Behavior
 */
class ExpandableBehaviorTest extends CakeTestCase
{

    /**
     * Fixtures associated with this test case
     *
     * @var array
     */
    public $fixtures = array(
        'plugin.expandable.user',
        'plugin.expandable.user_expand',
    );

    /**
     * Method executed before each test
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->User = ClassRegistry::init('Expandable.User');
        $this->User->Behaviors->attach('Expandable.Expandable');
    }

    /**
     * Method executed after each test
     *
     */
    public function tearDown()
    {
        unset($this->User);
        parent::tearDown();
    }

    /**
     * testContainments method
     *
     * @return void
     */
    public function testAggregateFunctionality()
    {
        $user = $this->User->find('first');
        $userInit = $user;
        $user['User']['extraField1'] = 'extraValue1';
        $user['User']['extraField2'] = true;
        $user['User']['extraField3'] = false;
        $user['User']['extraField5'] = null;
        $user['User']['extraField6'] = '';
        $this->User->create(false);
        $saved = $this->User->save($user);
        $this->assertFalse(empty($saved));
        // now if we find that record again, it wont have the expands
        // because recursive = -1, and no contains
        $userWithoutExpand = $this->User->find('first');
        $this->assertEqual($userInit, $userWithoutExpand);
        // but if we repeat the find with a contains (or recursive = 1)
        $userWithExpand = $this->User->find('first', array('contain' => 'UserExpand'));
        $this->assertNotEqual($userInit, $userWithExpand);
        // now we can test the values directly on the User model results
        $this->assertEquals('extraValue1', $user['User']['extraField1']);
        $this->assertEquals(true, $user['User']['extraField2']);
        $this->assertEquals(false, $user['User']['extraField3']);
        $this->assertEquals(null, $user['User']['extraField5']);
        $this->assertEquals('', $user['User']['extraField6']);
        // the hasMany relationship is passed through... but we are removing
        // for simpler full-array tesing
        $this->assertFalse(empty($userWithExpand['UserExpand']));
        unset($userWithExpand['UserExpand']);
        $this->assertEqual($user, $userWithExpand);
    }
}
