<?php

namespace VCR\Example;

use PHPUnit\Framework\TestCase;
use VCR\VCR;

/**
 * Converts temperature units from webservicex
 *
 * @link http://www.dneonline.com/calculator.asmx
 */
class PreRecordedCalculatorUsingTestListenerTest extends TestCase
{
    public function setUp()
    {
        VCR::configure()->setMode(VCR::MODE_NONE);
    }

    /**
     * @vcr test-cassette.yml
     */
    public function testInterceptsWithAnnotations()
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is a annotation test dummy".
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }
}