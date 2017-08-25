<?php

namespace VCR\Example;

use Exception;
use org\bovigo\vfs\vfsStream;
use VCR\VCR;

/**
 * Converts temperature units from webservicex
 *
 * @link http://www.dneonline.com/calculator.asmx
 */
class RecordCalculatorSoapClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Configure virtual filesystem.
        vfsStream::setup('testDir');
        VCR::configure()->setCassettePath('../');
        VCR::configure()->setMode(VCR::MODE_NEW_EPISODES);
        VCR::turnOn();
        VCR::insertCassette('test-cassette.yml');
    }

    public function tearDown()
    {
        VCR::turnOff();
    }

    public function testCallDirectly() {
        $actual = $this->callSoap();
        $this->assertInternalType('integer', $actual);
    }

    public function testCallIntercepted() {
        $actual = $this->callSoapIntercepted();
        $this->assertInternalType('integer', $actual);
    }

    public function testCallDirectlyEqualsIntercepted() {
        $this->assertEquals($this->callSoap(), $this->callSoapIntercepted());
    }

    public function testCallInterceptedWithErrorResponse() {
        $this->expectException(Exception::class);
        $this->callSoapInterceptedWithErrorResponse();
    }

    protected function callSoap()
    {
        $soapClient = new ExampleSoapClient();
        return $soapClient->call(100, 200); // somewhere in New York
    }

    protected function callSoapIntercepted()
    {

        $result = $this->callSoap();

        return $result;
    }

    protected function callSoapInterceptedWithErrorResponse()
    {
        $result = $this->callInvalidSoap();

        return $result;
    }

    private function callInvalidSoap()
    {
        $soapClient = new ExampleSoapClient();
        $result = $soapClient->invalidCall(5, 0);

        return $result;
    }

}
