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
 * My Moodle -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
 * @package    moodlecore
 * @subpackage my
 * @copyright  2010 Remote-Learner.net
 * @author     Hubert Chathi <hubert@remote-learner.net>
 * @author     Olav Jordan <olav.jordan@remote-learner.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_helloworld\form\add;
use local_helloworld\manager;
//global $CFG;

//require_once($CFG->libdir.'/adminlib.php');
require_once(__DIR__ . '/../../config.php');
require_once ($CFG->dirroot . '/local/helloworld/classes/form/add.php');

global $DB, $USER;

// This line is tp setup the page.
$title = get_string('pluginname','local_helloworld');
$pagetitle = $title;
$url = new moodle_url('/local/helloworld/index.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_url($url);
$PAGE->requires->js_call_amd('local_helloworld/confirm');
require_login();


if (isguestuser()) {
    print_error('guestnoeditmessage', 'message');
}

$PAGE->set_title($title);
//$PAGE->set_pagelayout('standard');
$PAGE->set_heading($title);

$mform = new add();
$userid = $USER->id;

 if ($fromform = $mform->get_data()) {

    $manager = new manager();

    $personalcontext = context_system::instance();

    require_capability('local/helloworld:postanymessages', $personalcontext);
    // Insert only if user has capability - second layer security
        $manager->create_message($fromform->message, $userid);
     //Go back to index
     redirect($CFG->wwwroot . '/local/helloworld/index.php', get_string('messagecreated', 'local_message'));

}
//$userfields = get_all_user_name_fields(true, 'u');

 $sql = "SELECT ul.id, ul.message, u.firstname, u.lastname, ul.timecreated 
         FROM {user} u 
         INNER JOIN {local_helloworld} ul
         ON u.id = ul.userid
         ORDER BY ul.timecreated DESC";

 $records = $DB->get_records_sql($sql);

 foreach ($records as $record=>$ui){

     $ui->fullname = $ui->firstname. ' ' .$ui->lastname;
     $ui->message = $ui->message;
     $ui->timecreated = date_format_string($ui->timecreated, '%Y-%m-%d');
     $records[$record] = $ui;
 }
//var_dump($records);
//die();
 //$messages = $DB->get_records('local_helloworld', null, 'id');


echo $OUTPUT->header();

//$previewnode = $PAGE->navigation->add(get_string('pluginname', 'local_helloworld'), new moodle_url('/local/helloworld/index.php'), navigation_node::TYPE_CONTAINER);
//$thingnode = $previewnode->add(get_string('pluginname', 'local_helloworld'), new moodle_url('/local/helloworld/index.php'));
//$thingnode->make_active();

$context = context_system::instance();
//var_dump(has_capability('local/helloworld:postanymessages', $context));
//die();
if (has_capability('local/helloworld:postanymessages', $context)){

    // Display the form
    echo html_writer::start_tag('div', [
        'class' => 'card mt-2 mb-2'
    ]);
    echo html_writer::start_tag('div', [
        'class' => 'card-body'
    ]);
    $mform->display();
    echo html_writer::end_tag('div');
    echo html_writer::end_tag('div');

}

if(has_capability('local/helloworld:viewanymessages', $context)) {
    // Display the messages card
    $templatecontext = (object)[
        'messages' => array_values($records),
        'fullname' => array_values($records),
        'timecreated' => array_values($records)
    ];

    echo $OUTPUT->render_from_template('local_helloworld/hello', $templatecontext);
}
//if (has_capability('local/helloworld:deleteanymessages', $context)) {
//    // Display Delete button
//
//}

echo $OUTPUT->footer();

