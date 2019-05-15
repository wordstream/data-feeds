<?php
/**
 * Copyright 2019 WordStream, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
/**
 * Class WordStream_Services_Model_Version_ApiTest.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Version_ApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tested object.
     *
     * @return void
     */
    protected $versionApi;

    /**
     * Get the tested object.
     *
     * @return void
     */
    public function setUp()
    {
       $this->versionApi = Mage::getModel('wordstream_services/version_api');
    }

    /**
     * Testing of the class.
     *
     * @return void
     */
    public function testVersionApiClass()
    {
        $this->assertInstanceOf(
            WordStream_Services_Model_Version_Api::class,
            $this->versionApi
        );
    }

    /**
     * Checking equal the result of the function and the version of the extension from "config.xml" file.
     *
     * @return void
     */
    public function testVersion()
    {
       $this->assertEquals($this->versionApi->version(), $this->getConfigVersion());
    }

    /**
     * Get config version of the module.
     *
     * @return void
     */
    private function getConfigVersion()
    {
        return (string) Mage::getConfig()->getNode()->modules->WordStream_Services->version;
    }
}
