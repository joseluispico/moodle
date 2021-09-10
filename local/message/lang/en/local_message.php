<?php
// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();
// The name of the second tab in the theme settings.
$string['label'] = 'Message Text';
$string['info'] = \core\output\notification::NOTIFY_INFO;
$string['warning'] = \core\output\notification::NOTIFY_WARNING;
$string['success'] = \core\output\notification::NOTIFY_SUCCESS;
$string['error'] = \core\output\notification::NOTIFY_ERROR;
$string['messagetype'] = 'Message Type';
$string['messagetype_help'] = 'Message Help, you should select something here';
$string['canceled'] = 'You cancelled the message form request';
$string['messagecreated'] = 'You created a message successfully';
