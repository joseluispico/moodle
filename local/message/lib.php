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

function local_message_before_footer(){

    global $DB, $USER;

    $sql = "SELECT lm.id, lm.messagetext, lm.messagetype  
            FROM {local_message} lm
            LEFT OUTER JOIN {local_message_read} lmr
            ON lm.id = lmr.messageid
            WHERE lmr.userid <> :userid
            OR lmr.userid IS NULL";

    $params = [
        'userid' => $USER->id,
    ];

    $messages = $DB->get_records_sql($sql, $params);

    foreach($messages as $message){

        $type = get_string('info', 'local_message');

        if ($message->messagetype === '0'){
            $type = get_string('warning', 'local_message');
        }
        if ($message->messagetype === '1'){
            $type = get_string('success', 'local_message');
        }
        if ($message->messagetype === '2'){
            $type = get_string('error', 'local_message');
        }

        \core\notification::add($message->messagetext, $type);

        $readrecord = new stdClass();
        $readrecord->messageid = $message->id;
        $readrecord->userid = $USER->id;
        $readrecord->timeread = time();
        $DB->insert_record('local_message_read', $readrecord);



    }
}