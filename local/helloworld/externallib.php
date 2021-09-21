<?php

/**
 * Version details
 * check website for documentation https://docs.moodle.org/dev/Adding_a_web_service_to_a_plugin
 * @package    local_hellowordl
 * @author     JOse
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use local_helloworld\manager;
require_once($CFG->libdir . "/externallib.php");

class local_helloworld_external extends external_api {

    /**
     * Returns description of method paramenters
     * @return external_function_parameters
     */
    public static function delete_message_parameters() {
        return new external_function_parameters(
            ['messageid' => new external_value(PARAM_INT, 'id of message')],
        );
    }

    /**
     * The function itself
     * @return string welcome message
     */
    public static function delete_message($messageid): string {
        $params = self::validate_parameters(self::delete_message_parameters(), array('messageid'=>$messageid));

        $manager = new manager();
        return $manager->delete_message($messageid);
    }

    /**
     * Returns description of method result value
     *@return external_description
     */
    public static function delete_message_returns() {
        return new external_value(PARAM_BOOL, 'True if the message was successfully delted.');
    }
}


