<?php
/* Template Name: bKash Payment Template */
get_header();
?>
  <div style="background-color: #fff; border:1px solid #ddd;border-radius:30px;max-width:550px; margin:150px auto 50px; padding:40px">
    <h2>Become an Instructor</h2>
    <form method="post">
      <label>Amount</label>
      <input type="number" name="amount" id="amount" style="width:100%; height:50px;border: 1px solid #202020;border-radius:5px;padding:0 15px">
      <button type="button" name="pay_with_bkash" class="btn btn-primary btn-pay-with-bkash-js" style="margin-top: 20px">Pay With bKash</button>
    </form>
  </div>
<?php
get_footer();
