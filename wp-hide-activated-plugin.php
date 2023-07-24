<?php
/**
 * Plugin Name: WP Plugin Filter
 * Description: This plugin allows you to hide selected plugins from the plugins list.
 * Version: 1.0.0
 * Author: Mike Kipruto
 * Author URI: https://kipmyk.co.ke/
 * Text Domain: wp-plugin-filter
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MK_WP_Plugin_Filter
{

    /**
     * Initialize the plugin
     */
    public function __construct()
    {
        add_filter('plugins_list', array($this, 'filter_plugins_list'));
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));

        // Add the settings link to the plugin page
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
        add_action( 'init', array($this, 'languages') );
    }
 
   //  handle translation
   function languages(){
     load_plugin_textdomain( 'wp-plugin-filter', false, dirname(plugin_basename( __FILE__ )).'/languages');
   }
    /**
     * Filter the plugins list to hide selected plugins
     *
     * @param array $plugins The list of plugins
     * @return array The modified list of plugins
     */
    public function filter_plugins_list($plugins)
    {
        $plugins_to_hide = get_option('plugins_to_hide', array());

        if (!empty($plugins_to_hide)) {
            foreach ($plugins_to_hide as $plugin_file) {
                // Loop through each context in the $plugins array
                foreach ($plugins as $context => $context_plugins) {
                    if (isset($plugins[$context][$plugin_file])) {
                        unset($plugins[$context][$plugin_file]);
                    }
                }
            }
        }

        return $plugins;
    }

    /**
     * Add the settings page to the admin menu
     */
    public function add_settings_page()
    {
        add_options_page(
            esc_html__('WP Hide Selected Settings', 'wp-plugin-filter'),
            esc_html__('WP Plugin Filter', 'wp-plugin-filter'),
            'manage_options',
            'wp-plugin-filter',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register the plugin settings
     */
    public function register_settings()
    {
        register_setting(
            'custom_plugin_filter_group',
            'plugins_to_hide',
            array(
                'type'              => 'array',
                'sanitize_callback' => array($this, 'sanitize_plugins'),
                'default'           => array(),
            )
        );
    }

    /**
     * Sanitize the selected plugins
     *
     * @param array $plugins The selected plugins
     * @return array The sanitized plugins
     */
    public function sanitize_plugins($plugins)
    {
        if (!is_array($plugins)) {
            return array();
        }

        $all_plugins = get_plugins();
        $allowed_plugins = array_keys($all_plugins);

        $selected_plugins = array();
        foreach ($plugins as $plugin_file) {
            if (in_array($plugin_file, $allowed_plugins)) {
                $selected_plugins[] = sanitize_text_field($plugin_file);
            }
        }

        return $selected_plugins;
    }

    /**
     * Render the settings page
     */
    public function render_settings_page()
    {
        $plugins = get_plugins();
        $plugins_to_hide = get_option('plugins_to_hide', array());

        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('WP Hide Selected Plugins Settings', 'wp-plugin-filter'); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields('custom_plugin_filter_group'); ?>
                <?php wp_nonce_field('custom_plugin_filter_nonce', 'custom_plugin_filter_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php echo esc_html__('Select Plugins to Hide', 'wp-plugin-filter'); ?></th>
                        <td>
                            <button type="button" id="toggle_select_all" class="button"><?php echo esc_html__('Toggle to select all', 'wp-plugin-filter'); ?></button>
                            <br><br>
                            <?php foreach ($plugins as $plugin_file => $plugin_data) : ?>
                                <label>
                                    <input type="checkbox" name="plugins_to_hide[]" value="<?php echo esc_attr($plugin_file); ?>" <?php echo in_array($plugin_file, $plugins_to_hide) ? 'checked' : ''; ?>>
                                    <?php echo esc_html($plugin_data['Name']); ?>
                                </label>
                                <br>
                            <?php endforeach; ?>
                            <p class="description"><?php echo esc_html__('Please select the plugins you want to hide from the plugins list.', 'wp-plugin-filter'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(esc_html__('Save Settings', 'wp-plugin-filter')); ?>
            </form>
        </div>
        <style>
            .button {
                margin-right: 10px;
            }
        </style>
        <script>
            (function() {
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleSelectAll = document.getElementById('toggle_select_all');
                    const checkboxes = document.querySelectorAll('input[name="plugins_to_hide[]"]');

                    let isSelectAll = false;

                    toggleSelectAll.addEventListener('click', function() {
                        isSelectAll = !isSelectAll;

                        checkboxes.forEach((checkbox) => {
                            checkbox.checked = isSelectAll;
                        });

                        toggleSelectAll.textContent = isSelectAll ? '<?php echo esc_html__('Toggle to unselect all', 'wp-plugin-filter'); ?>' : '<?php echo esc_html__('Toggle to select all', 'wp-plugin-filter'); ?>';
                    });
                });
            })();
        </script>
        <?php
    }

    /**
     * Add the settings link on the plugin page
     *
     * @param array $links The existing links
     * @return array The modified links
     */
    public function plugin_action_links($links)
    {
        $settings_page = is_multisite() ? 'settings.php' : 'options-general.php';
        $link = '<a href="' . esc_url(admin_url($settings_page) . '?page=wp-plugin-filter') . '">' . esc_html__('Settings', 'wp-plugin-filter') . '</a>';
        array_unshift($links, $link);
        return $links;
    }
}

new MK_WP_Plugin_Filter();
