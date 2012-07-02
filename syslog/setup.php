<?php

function plugin_init_syslog() {
	global $plugin_hooks;
	$plugin_hooks['config_arrays']['syslog'] = 'syslog_config_arrays';
	$plugin_hooks['draw_navigation_text']['syslog'] = 'syslog_draw_navigation_text';
	$plugin_hooks['config_settings']['syslog'] = 'syslog_config_settings';
	$plugin_hooks['top_header_tabs']['syslog'] = 'syslog_show_tab';
	$plugin_hooks['top_graph_header_tabs']['syslog'] = 'syslog_show_tab';
        $plugin_hooks['top_graph_refresh']['syslog'] = 'syslog_graph_refresh';
}

function syslog_graph_refresh(){
        return '';
}

function syslog_version () {
	return array( 'name' 	=> 'syslogplugin',
			'version' 	=> '0.1',
			'longname'	=> 'syslogPlugin',
			'author'	=> 'Sergio R Charpinel Junior',
			'homepage'	=> 'http://cactiusers.org',
			'email'	=> 'sergiocharpinel@gmail.com',
			'url'		=> 'http://cactiusers.org/cacti/versions.php'
			);
}

function syslog_config_arrays () {
	global $user_auth_realms, $user_auth_realm_filenames, $menu;

	$user_auth_realms[69]='Syslog Plugin';
	$user_auth_realm_filenames['syslog.php'] = 69;
	$user_auth_realm_filenames['whois.php'] = 69;
	$user_auth_realm_filenames['search.php'] = 69;
	$user_auth_realm_filenames['cancel.php'] = 69;
}
function syslog_draw_navigation_text ($nav) {
	$nav["syslog.php:"] = array("title" => "Syslog Plugin", "mapping" => "index.php:", "url" => "syslog.php", "level" => "1");
	return $nav;
}

function syslog_config_settings () {
	global $settings, $tabs;
	$tabs["syslog"] = "Syslog";
	$temp = array(
		"syslog_database_header" => array(
		"friendly_name" => "Database Options",
		"method" => "spacer",
		),
			"syslog_dbType" => array(
			"friendly_name" => "Database Type",
			"description" => "Database Type. Eg.: mysql, pgsql",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "pgsql"
		),
			"syslog_dbUser" => array(
			"friendly_name" => "Database User",
			"description" => "Database Username",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "syslog"
		),
			"syslog_dbPass" => array(
			"friendly_name" => "Database Password",
			"description" => "Database Password",
			"method" => "textbox_password",
			"max_length" => "255"
		),
			"syslog_dbHost" => array(
			"friendly_name" => "Database Host",
			"description" => "Database Hostname",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "localhost"
		),
			"syslog_dbPort" => array(
			"friendly_name" => "Database Port",
			"description" => "Database Port",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "5432"
		),
			"syslog_dbName" => array(
			"friendly_name" => "Database Name",
			"description" => "Database Name",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "syslog"
		),
		"syslog_header" => array(
		 	"friendly_name" => "Syslog Options",
			"method" => "spacer",
		),
			"syslog_fields" => array(
			"friendly_name" => "Fields",
			"description" => "Name of the Fields to search",
			"method" => "textbox",
			"max_length" => 255,
			"default" => "*"
		),

	);
	if (isset($settings["syslog"]))
		$settings["syslog"] = array_merge($settings["syslog"], $temp);
    	else
 	        $settings["syslog"]=$temp;
}

function syslog_show_tab () {
	global $config, $user_auth_realms, $user_auth_realm_filenames;
	$realm_id2 = 0;
	//make sure user has rights to tab
	if (isset($user_auth_realm_filenames{basename('syslog.php')})) {
		$realm_id2 = $user_auth_realm_filenames{basename('syslog.php')};
	}
	if ((db_fetch_assoc("select user_auth_realm.realm_id from user_auth_realm where user_auth_realm.user_id='" . $_SESSION["sess_user_id"] . "' and user_auth_realm.realm_id='$realm_id2'")) || (empty($realm_id2))) {
		print '<a href="' . $config['url_path'] . 'plugins/syslog/syslog.php"><img src="' . $config['url_path'] . 'plugins/syslog/images/tab_syslog' . ((substr(basename($_SERVER["PHP_SELF"]),0,11) == "syslog.php") ? "_down": "") . '.gif" alt="Syslog" align="absmiddle" border="0"></a>';
	}
}
