<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Breadcrumb {
    private $breadcrumbs = array();
    private $separator = '  ';
    private $start = '<div class="secondary-nav"><div class="breadcrumbs-container" data-page-heading="Analytics"><header class="header navbar navbar-expand-sm"><a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a><div class="d-flex breadcrumb-content"><div class="page-header"><div class="page-title"></div><nav class="breadcrumb-style-one" aria-label="breadcrumb"><ol class="breadcrumb">';
    private $end = '</ol></nav></div></div></header></div></div>';
    
    public function __construct($params = array()) {
        if (count($params) > 0) {
            $this->initialize($params);
        }
    }
    
    private function initialize($params = array()) {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->{'_' . $key})) {
                    $this->{'_' . $key} = $val;
                }
            }
        }
    }
    
    function add($title, $href) {
        if (!$title OR !$href)
            return;

        $this->breadcrumbs[] = array(
            'title' => $title,
            'href' => site_url() === $href ? $href.'dashboard' : $href
        );
    }
    
    function output() {
        if ($this->breadcrumbs) {
            $output = $this->start;
            $arrayKeys = array_keys($this->breadcrumbs);
            foreach ($this->breadcrumbs as $key => $crumb) {
                if ($key) {
                    $output .= $this->separator;
                }
                if (end($arrayKeys) == $key) {
                    $output .= '<li class="breadcrumb-item active"><a href="javscript:void(0);">' . $crumb['title'] . '</a></li>';
                } else {
                    if($crumb['title'] == 'Home'){
                        $output .= '<li class="breadcrumb-item"><a href="' . $crumb['href'] . '">Home</a></li>';
                    } else {
                        $output .= '<li class="breadcrumb-item"><a href="' . $crumb['href'] . '">' . $crumb['title'] . '</a></li>';
                    }
                }
            }
            return $output . $this->end . PHP_EOL;
        }
        return '';
    }
}