=== WP Plugin Filter ===
Contributors: mikekipruto
Tags: plugin, filter, hide, admin, management
Requires at least: 6.3
Tested up to: 6.3
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WP Plugin Filter is a simple and lightweight WordPress plugin that allows you to hide specific plugins from the plugin list in the WordPress admin dashboard. This can be useful if you have plugins that are intended for internal use only or plugins that don't require user interaction.

Once activated, WP Plugin Filter provides an easy-to-use interface where you can select which plugins you want to hide. The selected plugins will no longer appear in the plugin list, making it easier to manage your installed plugins.

== Features ==

- Hide selected plugins from the WordPress plugin list.
- Easy-to-use interface for managing hidden plugins.
- Lightweight and optimized for performance.
- Does not affect the functionality of the hidden plugins, they remain active and functional.

== Installation ==

1. Upload the `wp-plugin-filter` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Once you are logged in, go to Settings > WP PluginFilter. From there, you can select individual plugins to hide or use the "Toggle All" option to select all plugins and then save the changes.

== Frequently Asked Questions ==

= Can I still use the hidden plugins after hiding them? =

Yes, hiding the plugins from the plugin list does not deactivate or uninstall them. The hidden plugins will continue to function as usual; they are just not visible in the plugins list.

= How can I unhide a plugin that I previously hidden? =

To unhide a plugin, go to 'WP Plugin Filter' in the 'Settings' menu, uncheck the corresponding plugin, and click the "Save Changes" button.

= Will this plugin affect the performance of my website? =

No, this plugin is lightweight and designed to have minimal impact on your website's performance. It only hides plugins from the plugin list without interfering with their functionality.

== Screenshots ==

1. Screenshot of WP Plugin Filter in action.
   ![Screenshot](https://example.com/wp-content/plugins/wp-plugin-filter/assets/screenshot.png)

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release of WP Plugin Filter.

== License ==

WP Plugin Filter is licensed under the GPLv2 or later.

License URI: https://www.gnu.org/licenses/gpl-2.0.html
