<?php
################### CUSTOM OPTIONS PAGE
// Menu
add_action('admin_menu', 'podcasts_options_page_menu');
function podcasts_options_page_menu() {
    add_menu_page('Global options', 'Global options', 'administrator', 'podcasts_options', 'podcasts_options_page_cb', 'dashicons-admin-site-alt3', 4);
}

// Field values
add_action( 'admin_init', 'podcasts_options_page_settings' );
function podcasts_options_page_settings() {
  register_setting( 'podcasts_options_page_settings_group', 'options_force_json' );
}

// Callback
function podcasts_options_page_cb(){ 
$loopPages = get_pages();

// Success Message
if(
  isset( $_GET[ 'page' ] ) 
  && 'podcasts_options' == $_GET[ 'page' ]
  && isset( $_GET[ 'settings-updated' ] ) 
  && true == $_GET[ 'settings-updated' ]
) {
?>
<div class="notice notice-success is-dismissible"><p><strong>Settings saved.</strong></p></div>
<?php } ?>

    <div class="wrap">
        <h2>Global options</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'podcasts_options_page_settings_group' ); ?>
            <?php do_settings_sections( 'podcasts_options_page_settings_group' ); ?>
            <table class="form-table">
              <tr valign="top">
                <th scope="row">Synchronization</th>
                <td>
                  <select name="options_force_json">
                    <option value="yes" <?php selected(get_option('options_force_json'), 'yes'); ?>>I'd like to force podcasts from the JSON</option>
                    <option value="no" <?php selected(get_option('options_force_json'), 'no'); ?>>I'd like to be able to delete them permanently</option>
                  </select>
                  <p class="description">By default, whenever a podcast is permanently deleted from the trash, it is re-added.</p>
                </td>                
              </tr>                
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php } ?>