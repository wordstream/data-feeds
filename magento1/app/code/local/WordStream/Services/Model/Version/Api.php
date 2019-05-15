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
 * Class WordStream_Services_Model_Version_Api retrieve the version of the module.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Version_Api
{
    /**
     * Get version of module.
     *
     * @return string
     */
	public function version()
	{
		return (string) Mage::getConfig()->getNode()->modules->WordStream_Services->version;
	}
}
