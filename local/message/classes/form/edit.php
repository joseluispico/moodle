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
 * @author     JOse
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'messagetext', get_string('label','local_message')); // Add elements to your form
        $mform->setType('messagetext', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('messagetext', 'Please enter a message');        //Default value

        $options = array();
        $options[0] = get_string('warning', 'local_message');
        $options[1] = get_string('success', 'local_message');
        $options[2] = get_string('error', 'local_message');
        $options[3] = get_string('info', 'local_message');

        $mform->addElement('select', 'messagetype', get_string('messagetype', 'local_message'), $options);
        $mform->setDefault('messagetype', '3');
        $mform->addHelpButton('messagetype', 'messagetype', 'local_message');

        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}