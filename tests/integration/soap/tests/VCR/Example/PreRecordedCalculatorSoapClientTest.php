<?php

namespace VCR\Example;


use Exception;
use PHPUnit\Framework\TestCase;
use VCR\VCR;

class PreRecordedCalculatorSoapClientTest extends TestCase
{

    public function setUp()
    {
        // Configure virtual filesystem.
        VCR::configure()->setCassettePath('../../fixtures/');
        VCR::configure()->setMode(VCR::MODE_NONE);
        VCR::turnOn();
        VCR::insertCassette('test-cassette.yml');
    }

    public function tearDown()
    {
        VCR::turnOff();
    }

    public function testCallSoapThatHasBeenRecorded() {
        $actual = $this->callSoapThatHasBeenRecorded();
        $this->assertInternalType('integer', $actual);
        $this->assertEquals(300, $actual);
    }

    public function testCallSoapThatHasNotBeenRecorded() {
        $this->callSoapThatHasNotBeenRecorded();
    }

    public function testCallSoapThatHasBeenRecordedWithErrorResponse() {
        $this->callSoapThatHasBeenRecordedWithErrorResponse();
    }

    protected function callSoapThatHasBeenRecorded()
    {
        $soapClient = new ExampleSoapClient();
        return $soapClient->call(100, 200); // somewhere in New York
    }

    protected function callSoapThatHasNotBeenRecorded()
    {
        $soapClient = new ExampleSoapClient();
        $result = $soapClient->call(1, 5);

        return $result;
    }

    protected function callSoapThatHasBeenRecordedWithErrorResponse()
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
