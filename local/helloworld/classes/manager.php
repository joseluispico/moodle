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
 * @package    local_helloworld
 * @author     JOse
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_helloworld;

use dml_exception;
use stdClass;

class manager
{

    /**
     * @param string $message
     * @param int $time
     * @return bool true if successful
     */

    public function create_message(string $message, int $userid): bool
    {
        global $DB;
        //Insert the data into the database
        $record_to_insert = new stdClass();
        $record_to_insert->message = $message;
        $record_to_insert->userid = $userid;
        $record_to_insert->timecreated = time();

        try {
            return $DB->insert_record('local_helloworld', $record_to_insert,false);
        } catch (dml_exception $e) {
            return false;
        }
    }
    /** Delete a message
     * @param $messageid
     * @return bool|void
     * @throws \dml_transaction_exception
     * @throws dml_exception
     */
    public function delete_message($messageid)
    {
        global $DB;

        $transaction = $DB->start_delegated_transaction();
        //$personalcontext = context_system::instance();
        //require_capability('local/helloworld:deleteanymessages', $personalcontext);
        //if (has_capability('local/helloworld:postanymessages', $personalcontext)) {

        $deleteMessage = $DB->delete_records('local_helloworld', ['id' => $messageid]);
        //}
        if ($deleteMessage){

            $DB->commit_delegated_transaction($transaction);
        }

        return $deleteMessage;

    }
}