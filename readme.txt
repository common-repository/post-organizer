=== Post Organizer ===
Author: TechStudio
Contributors: 
Donate link: http://techstudio.co/wordpress/plugins/post-organizer
Tags: custom post type, taxonomy
Requires at least: 2.0.2
Tested up to: 3.3.1
Stable tag: 1.1.6

Post Organizer is a management interface for WordPress Custom Post Types and Taxonomies.

== Description ==


Post Organizer is a manager for WordPress Custom Post Types and Taxonomies. The plugin allows users to create as many custom post types as they choose through the use of the plugin's interface. Taxonomies can then be created to allow for further organization of the custom post types the plugin is in control of. Knowledge of the WordPress loop is required to craft loops which call upon the information contained in custom posts.


== Installation ==

1. Download the plugin and extract it
2. Upload the '/post-organizer/' directory to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

Q: How do I set custom permalink structure for my custom post types?
A: There are limits on what you can do here for the time being. If you create a custom post type the permalink won't be pretty at first. It will look something like this: http://youblog.com/?post_type=ml-customposttype. But if you go into the Post Organizer settings and set up a custom slug for your post type, things will look a little prettier for the posts in that type, like so: http://yourblog.com/custom-post-type/article-title We'll improve upon this soon.

Q: Why can't I see the custom post types on my WordPress site?
A: You may need to review the Q/A above to figure out direct links to archives for your custom post types. Archives for custom post types were only just added at WordPress version 3.1. If you set a custom slug for a custom post type, you will then see a pretty link for it so you can create links to its archive. You may also want to familiarize yourself with wp_query to use the full power of custom post types.

Q: If I delete a custom post type what happens to the posts?
A: Deleting a custom post type does not remove the posts themselves from the database. If you wish to fully remove a custom post type, empty it of posts before deleting the type.


== Screenshots ==


== Changelog ==

= 1.1.6 =
* Fixed bug with labels for new post types.

= 1.1.5 =
* Added the ability to adjust individual labels for items in post types/collections
* Added table version tracking to allow for proper updating of tables when upgrading

= 1.1.4 =
* Fixed a bug on plugin update.

= 1.1.3 =
* Bug fixes and feature tweaks.

= 1.1.2 =
* Fixed a bug which could cause problems with searching.

= 1.1.1 =
* Fixed a PHP error which could cause problems on install.

= 1.1.0 =
* When creating and editing Custom Post Types, you can now specify supported options for custom post types.

= 1.0.3 =
* Fixed a styling issue related to the release of WordPress 3.3
* Removed functions deprecated in WordPress 3.3

= 1.0.2 =
* Misc bug fixes

= 1.0.1 =
* Administration page simplified and condensed into one page

= 1.0.0 =
* Initial release


== Upgrade Notice ==

