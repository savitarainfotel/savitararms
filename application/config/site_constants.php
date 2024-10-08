<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('APP_NAME', 'Savitara RMS');
define('ASSET_VERSION', '?v='.($_SERVER['SERVER_NAME'] !== 'localhost' ? '1.0.2' : time()));
define('SERVER_NAME', ltrim($_SERVER['SERVER_NAME'], 'www.'));

/* These constants are for navbar permissions and they are also table names of db */

define('CLIENTS', "users");
define('USERS', "users");
define('USER_TYPES', "user_types");
define('PROPERTIES', "properties");
define('INVITES', "invites");
define('AGENTS', "agents");

define('USERS_TABLE', "users");
define('USER_TYPES_TABLE', "user_types");
define('LOGIN_TOKENS_TABLE', "login_tokens");
define('PERMISSIONS_TABLE', "permissions");
define('SIDEBAR_TABLE', "sidebar");
define('NAVBARS_TABLE', "navbars");
define('EMAIL_LOGS_TABLE', "email_logs");
define('EMAIL_TEMPLATE_TABLE', "email_template");
define('GENERAL_SETTINGS_TABLE', "general_settings");
define('PROPERTIES_TABLE', "properties");
define('RATING_PLATFORMS_TABLE', "rating_platforms");
define('RATING_SETTINGS_TABLE', "rating_settings");
define('INVITES_TABLE', "invites");
define('SEND_INVITES_TABLE', "send_invites");
define('CONTACT_US_TABLE', "contact_us");