<?php
/**
 * Copyright 2004-2017 Facebook. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Fabrizio Branca <mail@fabrizio-branca.de>
 */

namespace WebDriver\Service;

use WebDriver\Exception as WebDriverException;

/**
 * WebDriver\Service\CurlService class
 *
 * @package WebDriver
 */
class CurlService implements CurlServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute($requestMethod, $url, $parameters = null, $extraOptions = array())
    {
        $customHeaders = array(
            'Content-Type: application/json;charset=UTF-8',
            'Accept: application/json;charset=UTF-8',
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        switch ($requestMethod) {
            case 'GET':
                break;

            case 'POST':
                // Workaround for bug https://bugs.chromium.org/p/chromedriver/issues/detail?id=2943 in Chrome 75.
                // Chromedriver now erroneously does not allow POST body to be empty even for the JsonWire protocol.
                // If the command POST is empty, here we send some dummy data as a workaround.
                // Fix 'borrowed' from https://github.com/facebook/php-webdriver/commit/0f3933c41606fd076d79ff064bc0def2b774e67d#diff-1ee156e0c33356b17f4dc2b3faec69ee.
                if (empty($parameters)) {
                    $parameters = ['_' => '_'];
                }
                if ($parameters && is_array($parameters)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
                } else {
                    $customHeaders[] = 'Content-Length: 0';
                }

                // Suppress "Expect: 100-continue" header automatically added by cURL that
                // causes a 1 second delay if the remote server does not support Expect.
                $customHeaders[] = 'Expect:';

                curl_setopt($curl, CURLOPT_POST, true);
                break;

            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            case 'PUT':
                if ($parameters && is_array($parameters)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
                } else {
                    $customHeaders[] = 'Content-Length: 0';
                }

                // Suppress "Expect: 100-continue" header automatically added by cURL that
                // causes a 1 second delay if the remote server does not support Expect.
                $customHeaders[] = 'Expect:';

                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
        }

        foreach ($extraOptions as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $customHeaders);

        $rawResult = trim(curl_exec($curl));

        $info = curl_getinfo($curl);
        $info['request_method'] = $requestMethod;

        if (array_key_exists(CURLOPT_FAILONERROR, $extraOptions) &&
            $extraOptions[CURLOPT_FAILONERROR] &&
            CURLE_GOT_NOTHING !== ($errno = curl_errno($curl)) &&
            $error = curl_error($curl)
        ) {
            curl_close($curl);

            throw WebDriverException::factory(
                WebDriverException::CURL_EXEC,
                sprintf(
                    "Curl error thrown for http %s to %s%s\n\n%s",
                    $requestMethod,
                    $url,
                    $parameters && is_array($parameters) ? ' with params: ' . json_encode($parameters) : '',
                    $error
                ),
                $errno,
                null,
                $info
            );
        }

        curl_close($curl);

        return array($rawResult, $info);
    }
}
