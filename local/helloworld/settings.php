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
 * Settings for the Test block
 *
 * @copyright 2012 Aaron Barnes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   block_html
 */

defined('MOODLE_INTERNAL') || die;


if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category('local_helloworld_settings', get_string('pluginname', 'local_helloworld')));
    $settingspage = new admin_settingpage('managelocalhelloworld', get_string('manage', 'local_helloworld'));

    if ($ADMIN->fulltree) {
        $settingspage->add(new admin_setting_configcheckbox(
            'local_helloworld/showinnavigation',
            get_string('showinnav', 'local_helloworld'),
            get_string('showinnav_desc', 'local_helloworld'),
            0
        ));
    }

    $ADMIN->add('localplugins', $settingspage);
}