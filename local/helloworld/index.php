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

require(__DIR__ . '../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
// This line is tp setup the page.
$title = get_string('pluginname','local_helloworld');
$pagetitle = $title;
$url = new moodle_url("/local/helloworld/index.php");
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading($title);
//$PAGE->blocks->add_region('content');
//$output = $PAGE->get_renderer('local_helloworld');

echo $OUTPUT->header();
//echo $OUTPUT->heading($pagetitle);
echo html_writer::tag('input', '', [
    'type' => 'text',
    'name' => 'username',
    'placeholder' => get_string('typeyourname', 'local_helloworld'),
]);
echo html_writer::tag('input', '', [
    'type' => 'submit',
    'name' => 'submit',
]);

$previewnode = $PAGE->navigation->add(get_string('pluginname', 'local_helloworld'), new moodle_url('/local/helloworld/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add(get_string('pluginname', 'local_helloworld'), new moodle_url('/local/helloworld/index.php'));
$thingnode->make_active();
// $renderable = new \tool_demo\output\index_page('Some text');
// echo $output->render($renderable);
//echo $OUTPUT->custom_block_region('content');
echo $OUTPUT->footer();
// $userviewurl = "";
// if (isset($_GET['username'])) {
//     $username = required_param('username', PARAM_TEXT);
//     $userviewurl = new moodle_url('../helloworld/index.php', ['username' => $username]);
//     echo get_string('hello', 'local_helloworld'). " " . $_GET['username'] ."<br /><br>";
//     echo "<a href=/moodle/my/>". get_string('question', 'local_helloworld')."</a>";
//     echo "<a href='../helloworld/index.php'>".get_string('backtomain', 'local_helloworld')."</a>";
//     $now = time();
//     echo userdate($now);
//     exit();
// } else {
//     $username = get_string('world', 'local_helloworld');;
//     echo "<h1>". get_string('hello', 'local_helloworld'). " " . $username ."</h1>";
//     echo "<form method='GET' action=".$userviewurl.">";
//     echo get_string('question', 'local_helloworld');
//     echo "<input type='text' name='username' placeholder='Type your name'>";
//     echo "<input type='submit' name='submit'>";
//     echo "</form>";
// }

