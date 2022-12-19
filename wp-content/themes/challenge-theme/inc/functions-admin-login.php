<?php
################### CUSTOM LOGIN ADMIN
add_action( 'login_enqueue_scripts', 'customize_admin_login' );
function customize_admin_login() { ?>

<style>
  a, a:hover, a:focus, h1, h1:focus, div, *, *:focus {outline: none !important;text-decoration: none !important}
  body { background-color: #e5e6e0 !important }
  .wp-core-ui .button-primary {background: #303030 !important;border-color: #303030 !important;color: #fff !important;}
  /* labels name and password */
  body.login div#login form#loginform p label { color: #000; }
  /* Wordpress Logo */
  .login h1 {background-color:transparent !important;padding: 10px !important;border-radius: 10px !important;}
  .login h1 a {opacity: 1 !important;background-image: url('<?php echo get_template_directory_uri(); ?>/src/images/logo-admin.svg') !important; background-size: contain !important; width: 100% !important;height: 74px !important; background-position: center !important; opacity: 0.5; margin: 0px auto !important;box-shadow: unset;} 
  .login .message, .login #login_error {margin: 20px 0px !important;}
  /* Return to site anchor */
  body.login div#login p#backtoblog a {color: #66bc29;}
  body.login #backtoblog a, .login #nav a {color: #303030 !important}
  body.login form {border-radius: 5px; background-color: rgba(255, 255, 255, 0.7);}
</style>

<?php }
################### CUSTOM LOGO URL
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
  return home_url();
}
?>