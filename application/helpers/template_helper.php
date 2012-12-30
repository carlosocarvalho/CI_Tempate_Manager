<?php

if (!function_exists('add_js')) {

    function add_js($js /* string|array */, $position = 'footer'/* top|footer */) {
        //force $js array
        if (!is_array($js)) {
            $js = array($js);
        }
        //instance CI


        $tpl = & get_instance();
        foreach ($js as $script):
            // add script
            $tpl->ci_template->add_js($script, $position);
        endforeach;
    }

}



if (!function_exists('add_css')) {

    function add_css($css /* string|array */, $position = 'top'/* top|footer */) {
        //force $js array
        if (!is_array($css)) {
            $css = array($css);
        }
        //instance CI

        $tpl = & get_instance();
        foreach ($css as $style):
            // add script
            $tpl->ci_template->add_css($style, $position);
        endforeach;
    }

}

if (!function_exists('navbar_win')) {


    function navbar_win(array $data) {

        $_navbar = '';
        
       
        if (count($data) > 0) {
            foreach ($data as $item) {
               
                $_navbar .= '<a href="'.$item['link'].'" class="win-command">' . $item['label'] . '</a>';
            }
        }
        return $_navbar;
    }

}
