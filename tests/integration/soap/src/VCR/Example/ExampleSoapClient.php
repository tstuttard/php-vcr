<?php
namespace VCR\Example;

/**
 * Converts temperature units from webservicex
 *
 * @link http://www.dneonline.com/calculator.asmx
 */
class ExampleSoapClient
{
    const EXAMPLE_WSDL = 'http://www.dneonline.com/calculator.asmx?WSDL';

    public function call($intA, $intB)
    {
        $client = new \SoapClient(self::EXAMPLE_WSDL, array('soap_version' => SOAP_1_2));
        $response = $client->Add(array('intA' => $intA, 'intB' => $intB));

        return (int) $response->AddResult;
    }

    public function invalidCall($intA, $intB)
    {
        $client = new \SoapClient(self::EXAMPLE_WSDL, array('soap_version' => SOAP_1_2));
        $response = $client->Divide(array('intA' => $intA, 'intB' => $intB));

        return (int) $response->AddResult;
    }
}
