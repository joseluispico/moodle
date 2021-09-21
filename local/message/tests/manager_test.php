<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    local_message
 * @category   phpunit
 * @author     JOse
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_message\manager;

global $CFG;
require_once($CFG->dirroot . '/local/message/lib.php');

class local_message_manager_test extends advanced_testcase
{
    /*
     * test that we can create a message
     */

    public function test_create_message()
    {
        $this->resetAfterTest();
        $this->setUser(2);
        $manager = new manager();
        $messages = $manager->get_messages(2);
        $this->assertEmpty($messages);

        // Unit 1: Test insertion
        $type = \core\output\notification::NOTIFY_SUCCESS;
        $result = $manager->create_message('Hello world, this is a new', $type);
        $this->assertTrue($result);

        // Unit 2: Test data recorded
        $messages = $manager->get_messages(2);
        $this->assertNotEmpty($messages);

        // Unit 3: Test number of records
        $this->assertCount(1, $messages);
        $message = array_pop($messages);

        // Unit 4-5: Test data type
        $this->assertEquals('Hello world, this is a new', $message->messagetext);
        $this->assertEquals($type, $message->messagetype);

    }

    public function test_get_messages() {
        global $DB;
        $this->resetAfterTest();
        $this->setUser(2);
        $manager = new manager();

        // Unit 1: Test insertion
        $type = \core\output\notification::NOTIFY_SUCCESS;
        $manager->create_message('Test message1', $type);
        $manager->create_message('Test message2', $type);
        $manager->create_message('Test message3', $type);
        $manager->create_message('Test message4', $type);
        $messages = $DB->get_records('local_message');

        foreach ($messages as $id => $message) {
            $manager->mark_message_read($id, 1);
        }

        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(4, $messagesAdmin);

        foreach ($messages as $id => $message) {
            $manager->mark_message_read($id, 2);
        }
        $messagesAdmin = $manager->get_messages(2);
        $this->assertCount(0, $messagesAdmin);

    }


}


