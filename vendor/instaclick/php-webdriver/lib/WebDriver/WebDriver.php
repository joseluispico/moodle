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
 */

namespace WebDriver;

/**
 * WebDriver class
 *
 * @package WebDriver
 *
 * @method status
 */
class WebDriver extends AbstractWebDriver implements WebDriverInterface
{
    /**
     * {@inheritdoc}
     */
    protected function methods()
    {
        return array(
            'status' => 'GET',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function session($requiredCapabilities = Browser::FIREFOX, $desiredCapabilities = array())
    {
        // for backwards compatibility when the only required capability was browser name
        if (! is_array($requiredCapabilities)) {
            $desiredCapabilities[Capability::BROWSER_NAME] = $requiredCapabilities ?: Browser::FIREFOX;

            $requiredCapabilities = array();
        }

        // required
        $parameters = array(
            'desiredCapabilities' => array_merge($desiredCapabilities, $requiredCapabilities)
        );

        // optional
        if (! empty($requiredCapabilities)) {
            $parameters['requiredCapabilities'] = $requiredCapabilities;
        }

        // Hotfix: W3C WebDriver protocol is not yet supported by php-webdriver, so we must force Chromedriver to
        // not use the W3C protocol by default (which is what Chromedriver does starting with version 75).
        // Fix 'borrowed' from https://github.com/facebook/php-webdriver/commit/0f3933c41606fd076d79ff064bc0def2b774e67d#diff-1ee156e0c33356b17f4dc2b3faec69ee.
        if ($parameters['desiredCapabilities']['browserName'] === Browser::CHROME) {
            $parameters['desiredCapabilities']['chromeOptions']['w3c'] = false;
        }

        $result = $this->curl(
            'POST',
            '/session',
            $parameters,
            array(CURLOPT_FOLLOWLOCATION => true)
        );

        return new Session($result['sessionUrl']);
    }

    /**
     * {@inheritdoc}
     */
    public function sessions()
    {
        $result   = $this->curl('GET', '/sessions');
        $sessions = array();

        foreach ($result['value'] as $session) {
            $sessions[] = new Session($this->url . '/session/' . $session['id']);
        }

        return $sessions;
    }
}
