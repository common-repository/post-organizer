<?php



ml_header();



error_reporting(E_ALL ^ E_NOTICE);
global $wpdb;


 
 
if (isset($_GET['section'])){
	$section = $_GET['section'];
	switch ($section){
		case 'Added':
		echo "Section Added";
		break;
		
		case 'Saved':
		echo "Section Saved";
		break;
		
		case 'Deleted':
		echo "Section Removed - Records will stay in the Database but will not be shown unless this Library is created again";
		break;
		
		case 'Duplicate':
		echo "You have already created a Section with that name. Please choose a different name.";
		break;
	}

}
function show_sections(){
	global $wpdb;
	$table_name = $wpdb->prefix . "ml_sections";
	$getname = $wpdb->get_results("SELECT * FROM $table_name");
?>
<h3>Taxonomies</h3>
<p>You can assign taxonomies which will be available to their respective custom post types. For example, if you wish to create categories for a custom post type, 'categories' would be a taxonomy. Once the 'categories' taxonomy is created you can populate it with category options. Create as many taxonomies as you need.</p>
<?php
	foreach ($getname as $name){
		$ugly = $name->ml_owner;
		$library_name = $wpdb->prefix . "ml_libraries";
		if ($nicename = $wpdb->get_results("SELECT ml_nicename FROM $library_name WHERE ml_name = '$ugly'")){
			foreach ($nicename as $newname){
				$thename = $newname->ml_nicename;
			}
		}else{
				$thename = '<b>Not Assigned</b>';
		}
?>
Section Name: <?php echo $name->ml_nicename ?><br/>
Assigned to: <?php echo $thename ?><br/>
<form method="POST"><input type="hidden" name="section_id" value="<?php echo $name->id ?>"><input type="submit" name="edit_section" value="Edit"></form>
<form method="GET"><input type="hidden" name="section_id" value="<?php echo $name->id ?>"><input type="submit" name="delete_section" value="Delete"></form><br/>
<?php
	}//end foreach
}
show_sections();
if (isset($_POST['edit_section'])){
global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_sections";
	$section_id = $_POST['section_id'];
	$getinfo = $wpdb->get_results("SELECT * FROM $libraries_table WHERE id=$section_id");
		foreach ($getinfo as $info){}
	$name = $info->ml_nicename;
	$owner = $info->ml_owner;
	$codename = $info->ml_name;
?>
<h3>Edit Taxonomies</h3>
<form method="GET">
Taxonomy Name: <input type="text" name="section_name" value="<?php echo $name ?>"><br/>
e.g. Publisher<br/><br/>
Which custom post type does this taxonomy apply to?: <select name="section_owner">
<?php
global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$getinfo = $wpdb->get_results("SELECT * FROM $libraries_table");
		foreach ($getinfo as $info){ ?>
		<option value="<?php echo $info->ml_name ?>"><?php echo $info->ml_nicename ?></option>
		<?php } ?>
		</select><br/>	
Code Name: <input type="text" name="section_codename" value="<?php echo $codename ?>"><br/>
NOTE: This setting is the internal id used within your site and database - Please do not adjust this if you are not sure what it does.<br/><br/>
<input type="hidden" name="section_id" value="<?php echo $_POST['section_id'] ?>">
<input type="submit" name="edit_section" value="Save Changes">
</form>
<?php }else{ ?>
<h3>Add A New Taxonomy</h3>
<form method="GET">
Name: <input type="text" name="section_name" value=""><br/>
e.g. Authors<br/><br/>
Which custom post type does this taxonomy apply to?: <select name="section_owner">
<?php
global $wpdb;
	$libraries_table = $wpdb->prefix . "ml_libraries";
	$getinfo = $wpdb->get_results("SELECT * FROM $libraries_table");
		foreach ($getinfo as $info){ ?>
		<option value="<?php echo $info->ml_name ?>"><?php echo $info->ml_nicename ?></option>
		<?php } ?>
		</select><br/>	
<input type="submit" name="create_section" value="Add Section">
</form>
<?php } ?>