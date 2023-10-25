<?php
if (!defined('ABSPATH')) {
    exit;
}
 if(!function_exists('uacf7_mailchimp_api_status_callback')){
    function uacf7_mailchimp_api_status_callback($status){
        echo $status;
        echo '<p><a href="'.esc_url(admin_url('/admin.php?page=ultimate-addons')).'">'.esc_html__( ' Mailchimp Api Settings Panel', 'ultimate-addons-cf7' ).'</a></p> ';
    }
 }

?>
 