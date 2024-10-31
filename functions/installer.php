<?php
global $wpdb;
   $table_name = $wpdb->prefix . "ml_libraries";

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

	$sql = "CREATE TABLE " . $table_name . " ( 
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	ml_nicename VARCHAR(32) NOT NULL,
	ml_name VARCHAR(32) NOT NULL,
	ml_description VARCHAR(255) NOT NULL,
	ml_supports VARCHAR(255) NOT NULL,
	ml_addnew VARCHAR( 32 ) NOT NULL ,
	ml_addnewitem VARCHAR( 32 ) NOT NULL ,
	ml_edititem VARCHAR( 32 ) NOT NULL ,
	ml_newitem VARCHAR( 32 ) NOT NULL ,
	ml_allitems VARCHAR( 32 ) NOT NULL ,
	ml_viewitem VARCHAR( 32 ) NOT NULL ,
	ml_searchitems VARCHAR( 32 ) NOT NULL ,
	ml_notfound VARCHAR( 32 ) NOT NULL ,
	ml_notintrash VARCHAR( 32 ) NOT NULL ,
	ml_itemcolon VARCHAR( 32 ) NOT NULL ,
	ml_menuname VARCHAR( 32 ) NOT NULL ,
	ml_public VARCHAR( 8 ) NOT NULL ,
	ml_publicquery VARCHAR( 8 ) NOT NULL ,
	ml_ui VARCHAR( 8 ) NOT NULL ,
	ml_inmenu VARCHAR( 8 ) NOT NULL ,
	ml_queryvar VARCHAR( 8 ) NOT NULL ,
	ml_rewrite VARCHAR( 32 ) NOT NULL ,
	ml_capability VARCHAR( 8 ) NOT NULL ,
	ml_archive VARCHAR( 8 ) NOT NULL ,
	ml_tree VARCHAR( 8 ) NOT NULL ,
	ml_position VARCHAR( 8 ) NOT NULL,	
	UNIQUE KEY id (id)
	)";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}


   $table_name2 = $wpdb->prefix . "ml_sections";

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name2'") != $table_name) {

	$sql2 = "CREATE TABLE " . $table_name2 . " ( 
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	ml_nicename varchar(255) NOT NULL,
	ml_name varchar(255) NOT NULL,
	ml_owner text NOT NULL,
	UNIQUE KEY id (id)
	)";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql2);
}

?>