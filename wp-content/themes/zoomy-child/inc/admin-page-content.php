<?php
function bkash_options_page_content()
{
    $options = array(
        'test' => 'Sandbox (test mode)',
        'live' => 'Live Mode'
    );
?>
    <style>
        input[type=text],
        input[type=email],
        input[type=password] {
            display: block;
            width: 100%;
        }
    </style>
    <div class="wrap">
        <h1>bKash Payment Gateway Options</h1>
        <form method="post" action="options.php">
            <?php settings_fields('bkash_payment_options_group'); ?>
            <?php do_settings_sections('bkash-options'); ?>

            <!-- payment mode -->
            <div style="margin-bottom:20px">
                <h4 style="margin-bottom:8px">bKash Payment Gateway Mode:</h4>
                <?php
                $selected = get_option('bkash_payment_mode');
                foreach ($options as $key => $label) {
                    echo '<label style="margin-right:25px">';
                    echo '<input type="radio" name="bkash_payment_mode" value="' . esc_attr($key) . '" ' . checked($selected, $key, false) . ' />';
                    echo $label;
                    echo '</label>';
                }
                ?>
            </div>

            <!-- app key - test -->
            <div style="margin-bottom:20px">
                <label for="app-key-test" style="display:inline-block; margin-bottom:8px;"><strong>App Key - test: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="app-key-test" name="app_key_test" value="<?php echo esc_attr(get_option('app_key_test')); ?>">
                </div>
            </div>

            <!-- secret key - test -->
            <div style="margin-bottom:20px">
                <label for="secret-key-test" style="display:inline-block; margin-bottom:8px;"><strong>Secret Key - test: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="secret-key-test" name="secret_key_test" value="<?php echo esc_attr(get_option('secret_key_test')); ?>">
                </div>
            </div>

            <hr />

            <!-- base url test -->
            <div style="margin-bottom:20px">
                <label for="base-url-test" style="display:inline-block; margin-bottom:8px;"><strong>Base URL - test: </strong></label>
                <div style="max-width:420px">
                    <input type="text" id="base-url-test" name="base_url_test" value="<?php echo esc_attr(get_option('base_url_test')); ?>">
                </div>
            </div>

            <hr />

            <!-- username - test -->
            <div style="margin-bottom:20px">
                <label for="username-test" style="display:inline-block; margin-bottom:8px;"><strong>Username - test: </strong></label>
                <div style="max-width:420px">
                    <input type="text" id="username-test" name="username_test" value="<?php echo esc_attr(get_option('username_test')); ?>">
                </div>
            </div>

            <!-- password - test -->
            <div style="margin-bottom:20px">
                <label for="password-test" style="display:inline-block; margin-bottom:8px;"><strong>Password - test: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="password-test" name="password_test" value="<?php echo esc_attr(get_option('password_test')); ?>">
                </div>
            </div>

            <!-- app key -->
            <div style="margin-bottom:20px">
                <label for="app-key" style="display:inline-block; margin-bottom:8px;"><strong>App Key: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="app-key" name="app_key_live" value="<?php echo esc_attr(get_option('app_key_live')); ?>">
                </div>
            </div>

            <!-- secret key -->
            <div style="margin-bottom:20px">
                <label for="secret-key" style="display:inline-block; margin-bottom:8px;"><strong>Secret Key: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="secret-key" name="secret_key_live" value="<?php echo esc_attr(get_option('secret_key_live')); ?>">
                </div>
            </div>

            <hr />

            <!-- base url live -->
            <div style="margin-bottom:20px">
                <label for="base-url-live" style="display:inline-block; margin-bottom:8px;"><strong>Base URL: </strong></label>
                <div style="max-width:420px">
                    <input type="text" id="base-url-live" name="base_url_live" value="<?php echo esc_attr(get_option('base_url_live')); ?>">
                </div>
            </div>

            <hr />

            <!-- username -->
            <div style="margin-bottom:20px">
                <label for="username" style="display:inline-block; margin-bottom:8px;"><strong>Username : </strong></label>
                <div style="max-width:420px">
                    <input type="text" id="username-test" name="username" value="<?php echo esc_attr(get_option('username')); ?>">
                </div>
            </div>

            <!-- password -->
            <div style="margin-bottom:20px">
                <label for="password-test" style="display:inline-block; margin-bottom:8px;"><strong>Password: </strong></label>
                <div style="max-width:420px">
                    <input type="password" id="password" name="password" value="<?php echo esc_attr(get_option('password')); ?>">
                </div>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Register the settings for directory options page
function setting_option_registry()
{
    register_setting('bkash_payment_options_group', 'bkash_payment_mode');
    register_setting('bkash_payment_options_group', 'app_key_test');
    register_setting('bkash_payment_options_group', 'secret_key_test');
    register_setting('bkash_payment_options_group', 'app_key_live');
    register_setting('bkash_payment_options_group', 'secret_key_live');
    register_setting('bkash_payment_options_group', 'base_url_test');
    register_setting('bkash_payment_options_group', 'base_url_live');
    register_setting('bkash_payment_options_group', 'username_test');
    register_setting('bkash_payment_options_group', 'password_test');
    register_setting('bkash_payment_options_group', 'username');
    register_setting('bkash_payment_options_group', 'password');
}

add_action('admin_init', 'setting_option_registry');
