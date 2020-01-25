<?php
global $wpdb;

$table_name = $wpdb->prefix . "ImportProductPromoBox2";
if($wpdb->get_var("SHOW TABLES LIKE " . $table_name) != $table_name){
	$sql = " CREATE TABLE ". $table_name. "(
	id INTEGER(10) UNSIGNED AUTO_INCREMENT,
	productId BIGINT(20),
	PRIMARY KEY  (id))";
	
	require_once(ABSPATH .  "wp-admin/includes/upgrade.php");
	
	dbDelta($sql);
}