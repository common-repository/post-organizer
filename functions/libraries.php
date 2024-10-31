<?php


ml_header();

error_reporting(E_ALL ^ E_NOTICE);
global $wpdb;


 
 
if (isset($_GET['library'])){
	$library = $_GET['library'];
	switch ($library){
		case 'Added':
		echo "Library Added";
		break;
		
		case 'Saved':
		echo "Changes Saved";
		break;
		
		case 'Deleted':
		echo "Library Removed - Records will stay in the Database but will not be shown unless this Library is created again";
		break;
		
		case 'Duplicate':
		echo "You have already created a Library with that name. Please choose a different name.";
		break;
	}

}
function show_libraries(){
	global $wpdb;
	$table_name = $wpdb->prefix . "ml_libraries";
	$getname = $wpdb->get_results("SELECT * FROM $table_name");
?>
<h2>Custom Post Types</h2>
<p>You can create, edit or delete custom post types from this page. Note that deleting a custom post type does not remove the posts themselves from the database. If you wish to fully remove a custom post type, empty it of posts before deleting the type.</p>
<?php
	foreach ($getname as $name){
?>
Name: <?php echo $name->ml_nicename ?><br/>
Description: <?php echo $name->ml_description ?><br/>
<form method="POST"><input type="hidden" name="type_id" value="<?php echo $name->id ?>"><input type="submit" name="edit_it" value="Edit"></form>
<form method="GET"><input type="hidden" name="type_id" value="<?php echo $name->id ?>"><input type="submit" name="delete_it" value="Delete" onClick = "javascript: return confirm('NOTE: This will delete the library but will not remove its actual content from your database.\n\nIn order to remove a entire library you must remove its content before removing the actual library.\n\nAre you sure you want to do this?');"></form><br/>
<?php
	}//end foreach
}
show_libraries();
if (isset($_POST['edit_it'])){
global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$type_id = $_POST['type_id'];
	$getinfo = $wpdb->get_results("SELECT * FROM $libraries_table WHERE id=$type_id");
		foreach ($getinfo as $info){}
	$name = $info->ml_nicename;
	$description = $info->ml_description;
	$codename = $info->ml_name;
	$slug = $info->ml_rewrite;
?>
<h3>Edit Custom Post Type</h3>
<form method="GET">
<h4>Basic Options</h4>
Name: <input type="text" name="type_name" value="<?php echo $name ?>"><br/>
e.g. Videos<br/><br/>
Description: <input type="text" name="type_description" value="<?php echo $description ?>"><br/>
e.g. Short description of what this library contains<br/><br/>
Code Name: <input type="text" name="type_codename" value="<?php echo $codename ?>"><br/>
NOTE: This setting is the internal id used within your site and database - Please do not adjust this if you are not sure what it does.<br/><br/>
<h4>Additional Options</h4>
The Slug: <input type="text" name="type_slug" value="<?php echo $slug ?>"><br/>
By default the URL for a custom library contains the internal name of your library AKA the slug. The slug can create unsightly URLS<br/>Example: <?php bloginfo('url') ?>/<b>ml-library</b><br/>You can adjust how the url displays your library name by entering your own slug here.<br/><br/>
<input type="hidden" name="type_id" value="<?php echo $_POST['type_id'] ?>">
<input type="submit" name="edit_library" value="Save Changes">
</form>
<?php }else{ ?>
<h3>Add Custom Post Type</h3>
<form method="GET">
<h4>Basic Information</h4>
Name: <input type="text" name="type_name" value=""><br/>
e.g. Videos<br/><br/>
Description: <input type="text" name="type_description" value=""><br/>
e.g. Short description of what this custom post type contains<br/><br/>
<h4>Additional Options</h4>
The Slug: <input type="text" name="type_slug" value=""><br/>
By default the URL for a custom library contains the internal name of your library AKA the slug. The slug can create unsightly URLS<br/>Example: <?php bloginfo('url') ?>/<b>ml-library</b><br/>You can adjust how the url displays your library name by entering your own slug here.
<br/><br/>
<input type="submit" name="create_library" value="Add Custom Post Type">
</form>
<?php } ?>