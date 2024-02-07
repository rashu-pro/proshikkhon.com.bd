<?php
function admin_menu_callback(){
    add_options_page(
        'bKash Options',
        'bKash Options',
        'manage_options',
        'bkash-options',
        'bkash_options_page_content'
      );   
}
