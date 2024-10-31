<?php

/*
Plugin Name: Post Organizer
Plugin URI: http://techstudio.co/wordpress/plugins/post-organizer
Description: Post Organizer is a manager for WordPress Custom Post Types and Taxonomies. 
Version: 1.0.0
Author: TechStudio
Author URI: http://techstudio.co
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  
Copyright 2011 TECH STUDIO, INC (FLORIDA, USA)  | ( email: ryan@techstudio.co )
This program is free software; you can redistribute it and/or modify it under the terms
of the GNU General Public License, version 2, as published by the Free Software Foundation.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details. You should have received a copy of
the GNU General Public License along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
 
error_reporting(E_ALL ^ E_NOTICE);
register_activation_hook( __FILE__, 'ml_installer' );
add_action('admin_menu', 'ml_menu');
add_filter('posts_where','atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');
add_action( 'init', 'register_post', 0 );
add_action( 'init', 'register_tax', 0 );
add_action( 'admin_init', 'delete_library' );
add_action( 'admin_init', 'create_library' );
add_action( 'admin_init', 'save_library' );

add_action( 'admin_init', 'save_section' );
add_action( 'admin_init', 'delete_section' );
add_action( 'admin_init', 'create_section' );

function create_section(){
if (isset($_GET['create_section'])){
	global $wpdb;
	$section_table = $wpdb->prefix . "ml_sections";
	$nicename = $_GET['section_name'];
	$owner = $_GET['section_owner'];
	$owner = preg_replace('/\s+/', '', $owner);
	$name = $owner.'-'.strtolower($nicename);
	$name = preg_replace('/\s+/', '', $name);
	
	
		if ($wpdb->get_results("SELECT * FROM $section_table WHERE ml_name='$name'"))
		{
				$redirect = $_SERVER[HTTP_REFERER];
				wp_redirect($redirect.'&section=Duplicate');
		}else{	
		$insert = "INSERT INTO " . $section_table . " (
		ml_nicename,
		ml_name,
		ml_owner
		) VALUES (
		'" . $wpdb->escape($nicename) . "',
		'" . $wpdb->escape($name) . "',
		'" . $wpdb->escape($owner) . "'
		)";
		$results = $wpdb->query( $insert );
		$redirect = $_SERVER[HTTP_REFERER];
		wp_redirect($redirect.'&section=Added');
		}
	}
}


function create_library(){
if (isset($_GET['create_library'])){
	global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$nicename = $_GET['type_name'];
	$name = "ml-".strtolower($nicename);
	$name = preg_replace('/\s+/', '', $name);
	$description = $_GET['type_description'];
	$slug = strtolower($_GET['type_slug']);
	$slug = preg_replace('/\s+/', '', $slug);		
	
	
		if ($wpdb->get_results("SELECT * FROM $libraries_table WHERE ml_name='$name'"))
		{
				$redirect = $_SERVER[HTTP_REFERER];
				wp_redirect($redirect.'&library=Duplicate');
		}else{	
		$insert = "INSERT INTO " . $libraries_table . " (
		ml_nicename,
		ml_name,
		ml_description,
		ml_rewrite
		) VALUES (
		'" . $wpdb->escape($nicename) . "',
		'" . $wpdb->escape($name) . "',
		'" . $wpdb->escape($description) . "',
		'" . $wpdb->escape($slug) . "'
		)";
		$results = $wpdb->query( $insert );
		$redirect = $_SERVER[HTTP_REFERER];
		wp_redirect($redirect.'&library=Added');
		}
	}
}

function save_library(){
if (isset($_GET['edit_library'])){
	global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$type_id = $_GET['type_id'];
	$nicename = $_GET['type_name'];
	$description = $_GET['type_description'];
	$codename = strtolower($_GET['type_codename']);
	$codename = preg_replace('/\s+/', '', $codename);	
	$slug = strtolower($_GET['type_slug']);
	$slug = preg_replace('/\s+/', '', $slug);		
	$results = $wpdb->query("UPDATE $libraries_table SET ml_nicename='$nicename', ml_name='$codename', ml_description='$description', ml_rewrite='$slug' WHERE id=$type_id");
	$redirect = $_SERVER[HTTP_REFERER];
	wp_redirect($redirect.'&library=Saved');
 }
}

function save_section(){
if (isset($_GET['edit_section'])){
	global $wpdb;
	$sections_table = $wpdb->prefix . "ml_sections";
	$section_id = $_GET['section_id'];
	$nicename = $_GET['section_name'];
	$owner = $_GET['section_owner'];
	$codename = $_GET['section_codename'];
	$results = $wpdb->query("UPDATE $sections_table SET ml_nicename='$nicename', ml_name='$codename', ml_owner='$owner' WHERE id=$section_id");
	$redirect = $_SERVER[HTTP_REFERER];
	wp_redirect($redirect.'&section=Saved');
 }
}

function delete_section(){
	if (isset($_GET['delete_section'])){
global $wpdb;
	$sections_table = $wpdb->prefix . "ml_sections";
	$section_id = $_GET['section_id'];
	$getname = $wpdb->get_results("DELETE FROM $sections_table WHERE id=$section_id");
	$redirect = $_SERVER[HTTP_REFERER];
	wp_redirect($redirect.'&section=Deleted');
	}
}


function delete_library(){
	if (isset($_GET['delete_it'])){
global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$type_id = $_GET['type_id'];
	$getname = $wpdb->get_results("DELETE FROM $libraries_table WHERE id=$type_id");
	$redirect = $_SERVER[HTTP_REFERER];
	wp_redirect($redirect.'&library=Deleted');
	}
}

function register_post(){
	global $wpdb;
	$table_name = $wpdb->prefix . "ml_libraries";
	$getname = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($getname as $option){
	
						 $labels = array(
						'name' => _x($option->ml_nicename, 'post type general name'),
						'singular_name' => _x($option->ml_nicename, 'post type singular name'),
						'add_new' => _x('Add New', $option->ml_name),
						'add_new_item' => __('Add New '.$option->ml_nicename),
						'edit_item' => __('Edit '.$option->ml_nicename),
						'new_item' => __('New '.$option->ml_nicename),
						'all_items' => __('All '.$option->ml_nicename),
						'view_item' => __('View '.$option->ml_nicename),
						'search_items' => __('Search '.$option->ml_nicename),
						'not_found' =>  __('No '.$option->ml_nicename.' found'),
						'not_found_in_trash' => __('No '.$option->ml_nicename.' found in Trash'), 
						'parent_item_colon' => '',
						'menu_name' => $option->ml_nicename
						);
	
		$args = array();
		$args['labels'] = $labels;
	
		if ($option->ml_public == 1 || $option->ml_public == ''){
			$args['public'] = true;
			}else{
			$args['public'] = false;
			}
		if ($option->ml_publicquery == 1 || $option->ml_publicquery == ''){
			$args['publicly_queryable'] = true;
			}else{
			$args['publicly_queryable'] = false;
			}
		if ($option->ml_ui == 1 || $option->ml_ui == ''){
			$args['show_ui'] = true;
			}else{
			$args['show_ui'] = false;
			}
		if ($option->ml_inmenu == 1 || $option->ml_inmenu == ''){
			$args['show_in_menu'] = true;
			}else{
			$args['show_in_menu'] = false;
			}
		if ($option->ml_queryvar == 1  || $option->ml_queryvar == ''){
			$args['query_var'] = true;
			}else{
			$args['query_var'] = false;
			}			
		if (!empty($option->ml_rewrite)){
			$args['rewrite'] = array('slug'=>$option->ml_rewrite,'with_front'=>false);
			}else{
			$args['rewrite'] = false;
			}
		if (!empty($option->ml_capability)){
			$args['capability_type'] = $option->ml_capability;
			}else{
			$args['capability_type'] = 'post';
			}			
		if ($option->ml_archive == 1 || $option->ml_archive == ''){
			$args['has_archive'] = true;
			}else{
			$args['has_archive'] = false;
			}				
		if ($option->ml_tree == 1){
			$args['hierarchical'] = true;
			}else{
			$args['hierarchical'] = false;
			}	
		if (!empty($option->ml_position)){
			$args['menu_position'] = $option->ml_position;
			}else{
			$args['menu_position'] = null;
			}
		if (!empty($option->ml_supports)){
			$args['supports'] = explode_trim($option->ml_supports);
			}else{
			$args['supports'] = array('title','editor','author','thumbnail','excerpt','comments','custom-fields');
			}

//print_r($args);
					  


		register_post_type($option->ml_name,$args);	

	}
		flush_rewrite_rules();
	
}

function register_tax(){
	global $wpdb;
	$table_name = $wpdb->prefix . "ml_sections";
	$getname = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($getname as $name){
		if (!empty($name->ml_labels)){
			//0-10 are the fields in numerical order per array
			$array_labels = explode_trim($name->ml_labels);
				$single = $array_labels[0];
				$plural = $array_labels[1];
			
						$labels = array(
						'name' => _x( $single, 'taxonomy general name' ),
						'singular_name' => _x( $single, 'taxonomy singular name' ),
						'search_items' =>  __( 'Search '.$plural),
						'popular_items' => __( 'Popular '.$plural ),
						'all_items' => __( 'All '.$plural ),
						'parent_item' => null,
						'parent_item_colon' => null,
						'edit_item' => __( 'Edit '.$single ), 
						'update_item' => __( 'Update '.$single ),
						'add_new_item' => __( 'Add New '.$single ),
						'new_item_name' => __( 'New '.$single.' Name' ),
						'separate_items_with_commas' => __( 'Separate '.$plural.' with commas' ),
						'add_or_remove_items' => __( 'Add or remove '.$plural ),
						'choose_from_most_used' => __( 'Choose from the most used '.$plural ),
						'menu_name' => __( $single ),
						);
		}else{
	 
						 $labels = array(
							'name' => _x( $name->ml_nicename, 'taxonomy general name' ),
							'singular_name' => _x( $name->ml_nicename, 'taxonomy singular name' ),
							'search_items' =>  __( 'Search '.$name->ml_nicename.'' ),
							'popular_items' => __( 'Popular '.$name->ml_nicename.'' ),
							'all_items' => __( 'All '.$name->ml_nicename.'' ),
							'parent_item' => null,
							'parent_item_colon' => null,
							'edit_item' => __( 'Edit '.$name->ml_nicename.'' ), 
							'update_item' => __( 'Update '.$name->ml_nicename.'' ),
							'add_new_item' => __( 'Add New '.$name->ml_nicename.'' ),
							'new_item_name' => __( 'New '.$name->ml_nicename.' Name' ),
							'separate_items_with_commas' => __( 'Separate '.$name->ml_nicename.' with commas' ),
							'add_or_remove_items' => __( 'Add or remove '.$name->ml_nicename.'' ),
							'choose_from_most_used' => __( 'Choose from the most used '.$name->ml_nicename.'' ),
							'menu_name' => __( $name->ml_nicename ),
						);
  }

  register_taxonomy($name->ml_name,$name->ml_owner,array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => $name->ml_name ),
  ));	

	}
		flush_rewrite_rules();
	
}

 function ml_menu(){
	add_menu_page('Post Organizer', 'Post Organizer', 'administrator', 'ml_main', 'ml_main');
	add_submenu_page('ml_main', 'Add New', 'Custom Post Types', 'administrator', 'ml_page_libraries', 'ml_libraries');
	add_submenu_page('ml_main', 'Add New', 'Taxonomies', 'administrator', 'ml_page_sections', 'ml_sections');
 }
 
 function ml_header(){
 	include('functions/header.php');
 }

 function ml_main(){
	include('functions/main.php');
 }
 
 function ml_libraries(){
 	include('functions/libraries.php');
 }
 
 function ml_sections(){
 	include('functions/sections.php');
 }
 
 function ml_installer(){
	include('functions/installer.php');
 }

// add stylesheet to admin
function ml_stylesheet() {
    $prepath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
    echo '<link rel="stylesheet" type="text/css" href="' . $prepath . '/techstudio/techstudio.css" />' . "\n";
    echo '<script type="text/javascript" src="' . $prepath . '/techstudio/techstudio.jquery.js"></script>' . "\n";
    echo '<script type="text/javascript" src="http://techstud.io/js/masonry/masonry.jquery.min.js"></script>';
}
add_action('admin_head', 'ml_stylesheet');
 
function atom_search_where($where){
  global $wpdb;
  if (is_search())
    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
  return $where;
}

function atom_search_join($join){
  global $wpdb;
  if (is_search())
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}

function explode_trim($str, $delimiter = ',') { 
    if ( is_string($delimiter) ) { 
        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str)); 
        return explode($delimiter, $str); 
    } 
    return $str; 
} 

?>