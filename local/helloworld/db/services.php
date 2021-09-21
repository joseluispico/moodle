<?php
$functions = array(
    'local_helloworld_delete_message' => array(         //web service function name
        'classname'   => 'local_helloworld_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'delete_message',          //external function name
        'classpath'   => 'local/helloworld/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Delete a message.',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
//        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)    // Optional, only available for Moodle 3.1 onwards. List of built-in services (by shortname) where the function will be included.  Services created manually via the Moodle interface are not supported.
        'capabilities' => '' // comma separated list of capabilities used by the function.
    )
);