<?php
/**
 * Email Settings for Pet Service Form
 */

// Add admin menu for email settings
function petcare_email_settings_menu() {
    add_options_page(
        'Pet Service Email Settings',
        'Pet Service Emails',
        'manage_options',
        'petcare-email-settings',
        'petcare_email_settings_page'
    );
}
add_action('admin_menu', 'petcare_email_settings_menu');

// Register settings
function petcare_register_email_settings() {
    register_setting('petcare_email_settings', 'petcare_smtp_host');
    register_setting('petcare_email_settings', 'petcare_smtp_port');
    register_setting('petcare_email_settings', 'petcare_smtp_username');
    register_setting('petcare_email_settings', 'petcare_smtp_password');
    register_setting('petcare_email_settings', 'petcare_smtp_encryption');
    register_setting('petcare_email_settings', 'petcare_from_email');
    register_setting('petcare_email_settings', 'petcare_from_name');
    register_setting('petcare_email_settings', 'petcare_recipient_email');
}
add_action('admin_init', 'petcare_register_email_settings');

// Settings page content
function petcare_email_settings_page() {
    ?>
    <div class="wrap">
        <h1>Pet Service Email Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('petcare_email_settings'); ?>
            <?php do_settings_sections('petcare_email_settings'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">SMTP Host</th>
                    <td><input type="text" name="petcare_smtp_host" value="<?php echo esc_attr(get_option('petcare_smtp_host', 'smtp.example.com')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">SMTP Port</th>
                    <td><input type="text" name="petcare_smtp_port" value="<?php echo esc_attr(get_option('petcare_smtp_port', '587')); ?>" class="small-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">SMTP Username</th>
                    <td><input type="text" name="petcare_smtp_username" value="<?php echo esc_attr(get_option('petcare_smtp_username', '')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">SMTP Password</th>
                    <td><input type="password" name="petcare_smtp_password" value="<?php echo esc_attr(get_option('petcare_smtp_password', '')); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Encryption</th>
                    <td>
                        <select name="petcare_smtp_encryption">
                            <option value="tls" <?php selected(get_option('petcare_smtp_encryption', 'tls'), 'tls'); ?>>TLS</option>
                            <option value="ssl" <?php selected(get_option('petcare_smtp_encryption', 'tls'), 'ssl'); ?>>SSL</option>
                            <option value="none" <?php selected(get_option('petcare_smtp_encryption', 'tls'), 'none'); ?>>None</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">From Email</th>
                    <td><input type="email" name="petcare_from_email" value="<?php echo esc_attr(get_option('petcare_from_email', get_option('admin_email'))); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">From Name</th>
                    <td><input type="text" name="petcare_from_name" value="<?php echo esc_attr(get_option('petcare_from_name', get_bloginfo('name'))); ?>" class="regular-text" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Recipient Email</th>
                    <td><input type="email" name="petcare_recipient_email" value="<?php echo esc_attr(get_option('petcare_recipient_email', get_option('admin_email'))); ?>" class="regular-text" /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}