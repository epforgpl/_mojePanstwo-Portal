<?

App::uses('DaneController', 'Plugin/Dane/Controller');
App::uses('Dataobject', 'Dane.Model');
App::uses('MpAssertions', 'Test');

class DaneControllerTest extends ControllerTestCase {
    //public $fixtures = array('plugin.dane.wojewodztwa3/Dataobjects');

    public function setUp() {
        // generate controller
        $this->generate('Dane.Dane', array( 'components' => array(
            'Dane.DataBrowser' => array('beforeRender')
        )));

        $this->controller->Dataobject = $this->getMock('Dataobject', array('find', 'getDataSource'));
    }


    private function dataobjectExpectsFind($params, $response, $count) {
        $this->controller->Dataobject->expects($this->once())
            ->method('find')->with($this->equalTo('all'), $this->equalTo($params))
            ->will($this->returnValue($response));

        $this->controller->Dataobject->expects($this->any())
            ->method('getDataSource')
            ->will($this->returnValue((object)array(
                'lastResponseStats' => array(
                    'count' => $count,
                    'took_ms' => 123
                )
            )));
    }

    private function dataobjectExpectsFindFirst($params, $response) {
        $this->controller->Dataobject->expects($this->once())
            ->method('find')->with($this->equalTo('first'), $this->equalTo($params))
            ->will($this->returnValue($response));
    }

    public function testViewNoQuery() {
        $this->testAction('/dane');

        // assert redirect to home by checking header Location
        // make sure controller returns from redirects
        MpAssertions::assertUrlSamePathAndQuery('/', $this->headers['Location']);
    }

    public function testViewNoQuery2() {
        $this->testAction('/dane?q');

        MpAssertions::assertUrlSamePathAndQuery('/', $this->headers['Location']);
    }

//    public function testView() {
//        $this->testAction('/dane?q=epanstwo');
//
//
//        // test
//        // vars Get the set view variables.
//        // view Get the rendered view, without a layout.
//        // contents Get the rendered view including the layout.
//        // result Get the return value of the controller action. Useful for testing requestAction methods.
//    }
}