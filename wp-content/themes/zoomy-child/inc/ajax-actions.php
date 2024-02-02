<?php
// Pay with bkash action
add_action("wp_ajax_pay_with_bkash", "pay_with_bkash");
add_action("wp_ajax_nopriv_pay_with_bkash", "pay_with_bkash");
