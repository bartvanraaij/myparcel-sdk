<?php

/**
 * Test create one concept
 *
 * LICENSE: This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 *
 * If you want to add improvements, please create a fork in our GitHub:
 * https://github.com/myparcelnl
 *
 * @author      Reindert Vetter <reindert@myparcel.nl>
 * @copyright   2010-2016 MyParcel
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US  CC BY-NC-ND 3.0 NL
 * @link        https://github.com/myparcelnl/sdk
 * @since       File available since Release 0.1.0
 */
namespace myparcelnl\sdk\tests\SendConsignments\
SendOneConsignmentTest;

use myparcelnl\sdk\Helper\MyParcelAPI;
use myparcelnl\sdk\Model\Repository\MyParcelConsignmentRepository;


/**
 * Class SendOneConsignmentTest
 * @package myparcelnl\sdk\tests\SendOneConsignmentTest
 */
class SendOneConsignmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test one shipment with createConcepts()
     */
    public function testSendOneConsignment()
    {
        foreach ($this->additionProvider() as $consignmentTest) {

            $myParcelAPI = new MyParcelAPI();

            $consignment = new MyParcelConsignmentRepository();
            $consignment
                ->setApiKey($consignmentTest['api_key'])
                ->setCountry($consignmentTest['cc'])
                ->setPerson($consignmentTest['person'])
                ->setCompany($consignmentTest['company'])
                ->setFullStreet($consignmentTest['full_street_test'])
                ->setPostalCode($consignmentTest['postal_code'])
                ->setPackageType(1)
                ->setCity($consignmentTest['city'])
                ->setEmail('reindert@myparcel.nl')
                ->setPhone($consignmentTest['phone']);

            if (key_exists('package_type', $consignmentTest))
                $consignment->setPackageType($consignmentTest['package_type']);

            if (key_exists('large_format', $consignmentTest))
                $consignment->setLargeFormat($consignmentTest['large_format']);

            if (key_exists('only_recipient', $consignmentTest))
                $consignment->setOnlyRecipient($consignmentTest['only_recipient']);

            if (key_exists('signature', $consignmentTest))
                $consignment->setSignature($consignmentTest['signature']);

            if (key_exists('return', $consignmentTest))
                $consignment->setReturn($consignmentTest['return']);

            if (key_exists('insurance', $consignmentTest))
                $consignment->setInsurance($consignmentTest['insurance']);

            if (key_exists('label_description', $consignmentTest))
                $consignment->setLabelDescription($consignmentTest['label_description']);

            $myParcelAPI->addConsignment($consignment);
            /**
             * Create concept
             */
            $myParcelAPI->createConcepts();

            $this->assertEquals(true, $consignment->getMyParcelId() > 1, 'No id found');
            $this->assertEquals($consignmentTest['api_key'], $consignment->getApiKey(), 'getApiKey()');
            $this->assertEquals($consignmentTest['cc'], $consignment->getCountry(), 'getCountry()');
            $this->assertEquals($consignmentTest['person'], $consignment->getPerson(), 'getPerson()');
            $this->assertEquals($consignmentTest['company'], $consignment->getCompany(), 'getCompany()');
            $this->assertEquals($consignmentTest['full_street'], $consignment->getFullStreet(), 'getFullStreet()');
            $this->assertEquals($consignmentTest['number'], $consignment->getNumber(), 'getNumber()');
            $this->assertEquals($consignmentTest['number_suffix'], $consignment->getNumberSuffix(), 'getNumberSuffix()');
            $this->assertEquals($consignmentTest['postal_code'], $consignment->getPostalCode(), 'getPostalCode()');
            $this->assertEquals($consignmentTest['city'], $consignment->getCity(), 'getCity()');
            $this->assertEquals($consignmentTest['phone'], $consignment->getPhone(), 'getPhone()');

            if (key_exists('package_type', $consignmentTest))
                $this->assertEquals($consignmentTest['package_type'], $consignment->getPackageType(), 'getPackageType()');

            if (key_exists('large_format', $consignmentTest))
                $this->assertEquals($consignmentTest['large_format'], $consignment->isLargeFormat(), 'isLargeFormat()');

            if (key_exists('only_recipient', $consignmentTest))
                $this->assertEquals($consignmentTest['only_recipient'], $consignment->isOnlyRecipient(), 'isOnlyRecipient()');

            if (key_exists('signature', $consignmentTest))
                $this->assertEquals($consignmentTest['signature'], $consignment->isSignature(), 'isSignature()');

            if (key_exists('return', $consignmentTest))
                $this->assertEquals($consignmentTest['return'], $consignment->isReturn(), 'isReturn()');

            if (key_exists('label_description', $consignmentTest))
                $this->assertEquals($consignmentTest['label_description'], $consignment->getLabelDescription(), 'getLabelDescription()');

            if (key_exists('insurance', $consignmentTest))
                $this->assertEquals($consignmentTest['insurance'], $consignment->getInsurance(), 'getInsurance()');

            /**
             * Get label
             */
            $myParcelAPI
                ->getLinkOfLabels();

            $this->assertEquals(true, preg_match("#^https://api.myparcel.nl/pdfs#", $myParcelAPI->getLabelLink()), 'Can\'t get link of PDF');

        }
    }

    /**
     * Data for the test
     *
     * @return array
     */
    public function additionProvider()
    {
        return [
            [
                'api_key' => 'MYSNIzQWqNrYaDeFxJtVrujS9YEuF9kiykBxf8Sj',
                'cc' => 'NL',
                'person' => 'Reindert',
                'company' => 'Big Sale BV',
                'full_street_test' => 'Plein 1940-45 3b',
                'full_street' => 'Plein 1940-45 3 b',
                'street' => 'Plein 1940-45',
                'number' => 3,
                'number_suffix' => 'b',
                'postal_code' => '2231JE',
                'city' => 'Rijnsburg',
                'phone' => '123456',
            ],
            [
                'api_key' => 'a5cbbf2a81e3a7fe51752f51cedb157acffe6f1f',
                'cc' => 'NL',
                'person' => 'Piet',
                'company' => 'Mega Store',
                'full_street_test' => 'Koestraat 55',
                'full_street' => 'Koestraat 55',
                'street' => 'Koestraat',
                'number' => 55,
                'number_suffix' => '',
                'postal_code' => '2231JE',
                'city' => 'Katwijk',
                'phone' => '123-45-235-435',
                'package_type' => 1,
                'large_format' => false,
                'only_recipient' => false,
                'signature' => false,
                'return' => false,
                'label_description' => 'Label description',
            ],
            [
                'api_key' => 'a5cbbf2a81e3a7fe51752f51cedb157acffe6f1f',
                'cc' => 'NL',
                'person' => 'The insurance man',
                'company' => 'Mega Store',
                'full_street_test' => 'Koestraat 55',
                'full_street' => 'Koestraat 55',
                'street' => 'Koestraat',
                'number' => 55,
                'number_suffix' => '',
                'postal_code' => '2231JE',
                'city' => 'Katwijk',
                'phone' => '123-45-235-435',
                'package_type' => 1,
                'large_format' => true,
                'only_recipient' => true,
                'signature' => true,
                'return' => true,
                'label_description' => 1234,
                'insurance' => 250,
            ]
        ];
    }
}