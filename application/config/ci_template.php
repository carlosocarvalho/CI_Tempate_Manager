<?php

/* ====================================================================================================
 * Configuration CI_Template
 * ====================================================================================================
 */

/*
 * load initial all files of javascript for head
 */
$config['load_js_top']        = array('library/jquery-1.7.2.min','plugins/modernizr-2.6.1.min');
/*
 * load initial all files of javascript for footer
 * 
 */
$config['load_js_footer']     = array('plugins/jquery.mousewheel','plugins/jquery.scrollTo','plugins/bootstrap','plugins/bootmetro','plugins/bootmetro-charms');
/*
 * load initial all files of css for head
 */
$config['load_css']           = array('library/bootstrap','library/bootmetro','library/bootmetro-tiles','library/bootmetro-charms','library/metro-ui-dark','library/icomoon');
/*
 * set default layout
 */
$config['layout']             = 'default';
/*
 * set prefix title page
 */
$config['title_prefix']       = '';
/*
 * set folder web with (js,css,images)
 */
$config['folder_web']         = 'web';

?>
