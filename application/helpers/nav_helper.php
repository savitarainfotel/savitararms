<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('activeNavigation')) {
    function activeNavigation($controller, $action = array(), $section = '') {
        $CI =& get_instance();
        $currentController = $CI->router->fetch_class();
        $currentAction = $CI->router->fetch_method();

        if($section == 'expanded'){
            if((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller){
                return 'true';
            } else {
                return 'false';
            }
        } else if($section == 'menu_li'){
            if((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller){
                return 'active';
            } else {
                return '';
            }
        } else if($section == 'dropdown'){
            if((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller){
                return 'show';
            } else {
                return '';
            }
        } else if($section == 'child_nav'){
            if(((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller) && in_array($currentAction, $action)){
                return 'active';
            } else {
                return '';
            }
        } else if($section == 'sub_expanded'){
            if(((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller) && in_array($currentAction, $action)){
                return 'true';
            } else {
                return 'false';
            }
        } else if($section == 'sub_dropdown'){
            if(((is_array($controller) && in_array($currentController, $controller)) || $currentController == $controller) && in_array($currentAction, $action)){
                return 'show';
            } else {
                return '';
            }
        }
    }
}

if ( ! function_exists('user_privilege_register')) {
    function user_privilege_register($module, $action = 'view') {
        $CI =& get_instance();

		if($CI->user->is_super_admin == 1) return true;

        $CI->load->model('Permissions_model');

		if($CI->Permissions_model->user_privilege_register($module, $action, $CI->user->type, $CI->user->team_type))
			return true;

		return $CI->Permissions_model->user_privilege_register($module, $action, $CI->user->type);
    }
}

if ( ! function_exists('check_current_permissions')) {
	function check_current_permissions($module, $action, $userType, $userTeamType = 0) {
		$CI =& get_instance();
		return $CI->Permissions_model->user_privilege_register($module, $action, $userType, $userTeamType);
	}
}

if ( ! function_exists('checkAccess')) {
    function checkAccess($module, $action='view')
    {
        if(is_array($module)) {
            foreach ($module as $m) {
                $check = user_privilege_register($m, $action);
                if($check === true) break;
            }
        } else 
            $check = user_privilege_register($module, $action);

        if(empty($check)) {
            if(get_instance()->input->is_ajax_request()) {
                responseMsg(false, 'You do not have access for this operation!');
            } else {
                flashMsg('You do not have access for this operation!', 'dashboard');
            }
        }
    }
}