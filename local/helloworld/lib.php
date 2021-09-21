<?php
/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_helloworld_extend_navigation_frontpage(navigation_node $frontpage) {

    function has_config(){
        return true;
    }
    if (!isloggedin() or isguestuser()) {
        return;
    }

    $showinnavigation = get_config('local_helloworld', 'showinnavigation');
//    var_dump($showinnavigation);
//    die();

    if ($showinnavigation){
        $frontpage->add(
            get_string('pluginname', 'local_helloworld'),
            new moodle_url('/local/helloworld/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            null,
            new pix_icon('t/message', '')
        );

    }





}

/**
 * Add link to index.php into navigation drawer.
 *      
 * @param global_navigation $root Node representing the global navigation tree.
 */
function local_helloworld_extend_navigation(global_navigation $root) {

    if (!isloggedin() or isguestuser()) {
        return;
    }
    $showinnavigation = get_config('local_helloworld', 'showinnavigation');

    $node = navigation_node::create(
        get_string('sayhello', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
    );
    $node->showinflatnavigation = true;

    if ($showinnavigation){
        $root->add_node($node);

    }
}


function local_helloworld_extend_navigation_course(navigation_node $root){
    if (!isloggedin() or isguestuser()) {
        return;
    }
    $node = navigation_node::create(
        get_string('pluginname', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php')
    );
    $root->add_node($node);
}
