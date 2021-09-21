<?php
// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();
// The name of the second tab in the theme settings.
$string['pluginname'] = 'Manage Messages';
$string['label'] = 'Message Text';
$string['info'] = \core\output\notification::NOTIFY_INFO;
$string['warning'] = \core\output\notification::NOTIFY_WARNING;
$string['success'] = \core\output\notification::NOTIFY_SUCCESS;
$string['error'] = \core\output\notification::NOTIFY_ERROR;
$string['messagetype'] = 'Message Type';
$string['messagetype_help'] = 'Message Help, you should select something here';
$string['canceled'] = 'You cancelled the message form request';
$string['messagecreated'] = 'You created a message successfully';
$string['update_form'] = 'You updated a message successfully';
$string['manage_message'] = 'Manage Message';
$string['delete_message'] = 'Delete Message';
$string['delete_message_confirm'] = 'Are you sure you want to change the message';
$string['manage'] = 'Message Management Page';
$string['setting_enable_description'] = 'Disable to stop the display of the setting.';
$string['setting_enable'] = 'Enable setting messages';
