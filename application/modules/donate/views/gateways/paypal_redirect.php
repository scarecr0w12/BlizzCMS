<!DOCTYPE html>
<html>
<head>
    <title><?= lang('donate_redirecting') ?></title>
</head>
<body onload="document.forms['paypal_form'].submit();">
    <div style="text-align: center; padding: 50px;">
        <h2><?= lang('donate_redirecting') ?></h2>
        <p><i class="fa-solid fa-spinner fa-spin fa-2x"></i></p>
        <p>Please wait while we redirect you to PayPal...</p>
    </div>

    <form name="paypal_form" action="<?= $paypal_url ?>" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?= $business ?>">
        <input type="hidden" name="item_name" value="<?= html_escape($item_name) ?>">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="hidden" name="currency_code" value="<?= $currency ?>">
        <input type="hidden" name="custom" value="<?= $custom ?>">
        <input type="hidden" name="return" value="<?= $return_url ?>">
        <input type="hidden" name="cancel_return" value="<?= $cancel_url ?>">
        <input type="hidden" name="notify_url" value="<?= $notify_url ?>">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="no_note" value="1">
        <noscript>
            <p>JavaScript is required. Please click the button below:</p>
            <input type="submit" value="Continue to PayPal">
        </noscript>
    </form>
</body>
</html>
