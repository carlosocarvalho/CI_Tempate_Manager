<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of ci_template
 * @author Carlos
 */

class ci_template {

    public $_title = 'Template::CI';
    //put your code here
    private $ci;
    private $_config;
    private $data = array();
    private $js_all = array('top' => array(), 'footer' => array());
    private $css_all = array('top' => array(), 'footer' => array());
    private $_navbar = array();
    private $_template = array();
    
    /**
     * ci_template::__construct()
     * 
     * @return
     */
    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper(array('url', 'template'));
        $this->ci->config->load('ci_template', TRUE);
        $this->_config = $this->ci->config->item('ci_template');

        $this->js_all['top'] = array_merge($this->js_all['top'], (array) $this->_config['load_js_top']);
        $this->js_all['footer'] = array_merge($this->js_all['footer'], (array) $this->_config['load_js_footer']);
        $this->css_all['top'] = array_merge($this->css_all['top'], (array) $this->_config['load_css']);
    }

    /**
     * ci_template::load()
     * 
     * @param mixed $view
     * @param mixed $data
     * @return
     */
    function load($view, array $data = array()) {
        $this->_template['_views'][] = $view;
        $this->_template[$view] = $data;
    }
    /**
     * ci_template::part()
     * 
     * @param mixed $view
     * @param mixed $data
     * @return
     */
    function part($view,$data =  array()){
        return $this->ci->load->view($view,$data,TRUE);
    }
    /**
     * ci_template::render()
     * 
     * @return
     */
    function render() {
        ob_start();
        foreach ($this->_template['_views'] as $view) {
            $this->ci->load->view($view, $this->_template[$view]);
        }
        $this->data['content'] = ob_get_clean();
        $this->data['js_top'] = $this->show_js('top');
        $this->data['js_footer'] = $this->show_js();
        $this->data['css_top'] = $this->show_css('top');
        $this->data['css_footer'] = $this->show_css();
        $this->build_template();
    }

    /**
     * ci_template::build_template()
     * 
     * @return
     */
    function build_template() {
       // $this->_navbar();
        $this->_title();
        $this->ci->load->library('parser');
        $tpl = 'templates/' . $this->_config['layout'] . '.tpl';
        $this->ci->parser->parse($tpl, $this->data);
    }

    /**
     * ci_template::set()
     * 
     * @param mixed $name
     * @param mixed $value
     * @return
     */
    function set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * ci_template::add_js()
     * 
     * @param mixed $js
     * @param string $position
     * @return
     */
    public function add_js($js/* name string */, $position = 'footer' /* top|footer */) {
        //insert js in array if not exists
        if (isset($this->js_all[$position]) && !in_array($js, $this->js_all[$position])) {
            $this->js_all[$position][] = $js;
        } else {
            // 0 scripts in array
            $this->js_all[$position][] = $js;
        }
    }

    /**
     * ci_template::add_css()
     * 
     * @param mixed $css
     * @param string $position
     * @return
     */
    public function add_css($css, $position = 'footer' /* top|footer */) {

        //insert css in array if not exists
        if (isset($this->css_all[$position]) && !in_array($css, $this->css_all[$position])) {
            $this->css_all[$position][] = $css;
        } else {
            $this->css_all[$position][] = $css;
        }
    }

    /**
     * ci_template::show_js()
     * 
     * @param string $position
     * @return
     */
    private function show_js($position = 'footer' /* top|footer */) {

        $common = '';
        $plugins = '';
        $libray = '';
        $urlbase = ($position == 'top') ? '<script type="text/javascript"> var url_base = "' . site_url() . '";</script>' . "\n" : '';
        $cache = (ENVIRONMENT == 'production' ? '' : 'nocache');
        if (isset($this->js_all[$position]) && count($this->js_all[$position]) > 0):
            foreach ($this->js_all[$position] as $script) {
                $script = str_replace('.js', '', $script);
                if (preg_match('/library/', $script)) {
                    $libray.= '<script type="text/javascript" src="' . base_url() . $this->_config['folder_web'] . '/js/' . $script . '.js"></script>' . "\n";
                }
                if (preg_match('/plugins/', $script)) {
                    $plugins .= '<script type="text/javascript" src="' . base_url() . $this->_config['folder_web'] . '/js/' . $script . '.js"></script>' . "\n";
                }
                if (preg_match('/common/', $script)) {
                    $common .= '<script type="text/javascript" src="' . base_url() . $this->_config['folder_web'] . '/js/' . $script . '.js"></script>' . "\n";
                }
            }
        endif;

        return $urlbase . $libray . $plugins . $common;
    }

    /**
     * ci_template::show_css()
     * 
     * @param string $position
     * @return
     */
    private function show_css($position = 'footer' /* top|footer */) {
        $common = '';
        $plugins = '';
        $libray = '';
        // $template = '<link rel="stylesheet" type="text/css" href="' . site_url() . $this->_config['folder_web'] . '/css/templates/' . $this->template . '/' . $this->template . '.css" media="all"/>' . "\n";
        $cache = (ENVIRONMENT == 'production' ? '' : 'nocache');

        if (isset($this->css_all[$position]) && count($this->css_all[$position]) > 0):
            foreach ($this->css_all[$position] as $style) {
                if (!empty($style)):
                    $style = preg_replace('/\.css/', '', $style);
                    if (preg_match('/library/', $style)) {

                        $libray .= '<link rel="stylesheet" type="text/css" href="' . base_url() . $this->_config['folder_web'] . '/css/' . $style . '.css" media="all"/>' . "\n";
                    }
                    if (preg_match('/plugins/', $style)) {

                        $plugins .= '<link rel="stylesheet" type="text/css" href="' . base_url() . $this->_config['folder_web'] . '/css/' . $style . '.css" media="all" />' . "\n";
                    }

                    if (preg_match('/commom/', $style)) {
                        $common .= '<link rel="stylesheet" type="text/css" href="' . base_url() . $this->_config['folder_web'] . '/css/' . $style . '.css"  media="all" />' . "\n";
                    }
                endif;
            }
        endif;

        return $libray . $plugins . $common;
    }

    /**
     * ci_template::navbar()
     * 
     * @param mixed $data
     * @param string $name
     * @return
     */
    function navbar($data = null , $name = 'navbar') {
        $this->data[$name] = $data;
    }

    /**
     * ci_template::title()
     * 
     * @param mixed $title
     * @return
     */
    function title($title) {
        return $this->_title = $this->_title;
    }

    /**
     * ci_template::_title()
     * 
     * @return
     */
    function _title() {
        $this->data['title'] = $this->_title;
    }

}

?>
