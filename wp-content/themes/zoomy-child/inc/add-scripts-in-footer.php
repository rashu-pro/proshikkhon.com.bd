<?php
add_action('wp_footer', 'custom_script');

function custom_script(){
  ?>
  <script>
    jQuery(function ($){
      $(document).on('click', '.btn-pay-with-bkash-js', function (){
        const amount = $('#amount').val();
        const action = $(this).attr('name');
        $.ajax({
          type: 'post',
          url: '<?php echo admin_url('admin-ajax.php') ?>',
          data: {
            action: action,
            amount: amount
          },
          'success': function (response){
            console.log(response);
            const responseObj =JSON.parse($.trim(response));
            console.log(responseObj);
            window.location.href = responseObj.bkashURL;
          }
        })
      })
    })
  </script>
<?php
}
