# Shop Module Payment Gateway Setup Guide

Complete guide for configuring PayPal and Stripe payment gateways in the Shop module.

---

## Overview

The Shop module now supports:
- **PayPal Express Checkout** - Redirect-based payment
- **Stripe Payment Links** - Hosted checkout
- **Item Delivery** - Automatic mailbox delivery
- **Character Services** - Rename, race change, level boost, etc.
- **Subscription Management** - Recurring billing with gateway cancellation

---

## PayPal Express Checkout Setup

### Step 1: Create PayPal Business Account

1. Go to [PayPal Developer](https://developer.paypal.com)
2. Sign up or login
3. Create a **Business Account** (if not already done)

### Step 2: Create PayPal Application

1. In Developer Dashboard, go to **Apps & Credentials**
2. Make sure you're in **Sandbox** mode (for testing)
3. Click **Create App** under REST API apps
4. Enter app name (e.g., "BlizzCMS Shop")
5. Click **Create App**

### Step 3: Get PayPal Credentials

1. In your app, go to **Sandbox** credentials
2. Copy:
   - **Client ID** (under Signature)
   - **Secret** (under Signature)

### Step 4: Configure in BlizzCMS

Edit `/application/config/config.php` and add:

```php
// PayPal Configuration
$config['paypal_mode'] = 'sandbox';  // Use 'production' for live
$config['paypal_client_id'] = 'YOUR_PAYPAL_CLIENT_ID';
$config['paypal_secret'] = 'YOUR_PAYPAL_SECRET';
```

### Step 5: Configure in Admin Panel

1. Admin Panel > **Shop > Settings**
2. Fill in:
   - **PayPal Mode:** sandbox or production
   - **PayPal Client ID:** Your Client ID
   - **PayPal Secret:** Your Secret
   - **Enable PayPal:** Toggle ON

### Step 6: Test PayPal Payment

1. Add item to cart
2. Proceed to checkout
3. Select **PayPal** as payment method
4. Click **Pay with PayPal**
5. You should be redirected to PayPal sandbox
6. Complete test payment

**Test Credentials (Sandbox):**
- **Buyer Email:** sb-xxxxx@personal.example.com
- **Password:** Use test account password from PayPal dashboard

---

## Stripe Payment Setup

### Step 1: Create Stripe Account

1. Go to [Stripe Dashboard](https://dashboard.stripe.com)
2. Sign up or login
3. Verify email

### Step 2: Get Stripe API Keys

1. In Stripe Dashboard, go to **Developers > API Keys**
2. Make sure you're in **Test Mode** (toggle in top right)
3. Copy:
   - **Publishable Key** (starts with `pk_test_`)
   - **Secret Key** (starts with `sk_test_`)

### Step 3: Configure in BlizzCMS

Edit `/application/config/config.php` and add:

```php
// Stripe Configuration
$config['stripe_public_key'] = 'pk_test_YOUR_PUBLISHABLE_KEY';
$config['stripe_secret_key'] = 'sk_test_YOUR_SECRET_KEY';
```

### Step 4: Configure in Admin Panel

1. Admin Panel > **Shop > Settings**
2. Fill in:
   - **Stripe Public Key:** Your Publishable Key
   - **Stripe Secret Key:** Your Secret Key
   - **Enable Stripe:** Toggle ON

### Step 5: Test Stripe Payment

1. Add item to cart
2. Proceed to checkout
3. Select **Stripe** as payment method
4. Click **Pay with Stripe**
5. You should see Stripe checkout form
6. Use test card: `4242 4242 4242 4242`
7. Any future expiry date and any CVC

**Test Cards:**
- **Visa:** 4242 4242 4242 4242
- **Mastercard:** 5555 5555 5555 4444
- **Amex:** 3782 822463 10005
- **Any CVC:** 123
- **Any Expiry:** 12/25 (future date)

---

## Item Delivery Configuration

Items are automatically delivered to character mailboxes upon successful payment.

### How It Works

1. Player purchases item
2. Payment processed successfully
3. Item automatically sent to character mailbox
4. Mail expires in 30 days
5. Player receives in-game notification

### Configuration

Edit `/application/config/config.php`:

```php
// Item Delivery Settings
$config['shop_mail_sender_id'] = 61;  // System sender ID (usually 61)
$config['shop_mail_expiry_days'] = 30;  // Mail expiry time
$config['shop_auto_deliver'] = true;  // Enable auto-delivery
```

### Troubleshooting Item Delivery

**Items not appearing in mailbox:**
- Verify character database connection
- Check `mail` and `mail_items` tables exist
- Ensure character ID is correct
- Check logs for delivery errors

**Mail expires too quickly:**
- Adjust `shop_mail_expiry_days` in config
- Default is 30 days

---

## Character Service Configuration

Services like rename, race change, level boost are automatically applied.

### Supported Services

| Service | Effect | Value |
|---------|--------|-------|
| rename | Sets rename flag | N/A |
| race_change | Sets race change flag | N/A |
| faction_change | Sets faction change flag | N/A |
| customize | Sets customization flag | N/A |
| level_boost | Sets character level | Level (default 70) |
| profession_boost | Boosts profession skill | Skill level (default 300) |
| gold | Adds gold to character | Gold amount (in gold, not copper) |
| custom | Custom service | Custom value |

### Configuration

Edit `/application/config/config.php`:

```php
// Service Configuration
$config['shop_service_level_boost_default'] = 70;
$config['shop_service_profession_default'] = 300;
$config['shop_service_gold_default'] = 1000;
```

### Adding Custom Services

1. Admin Panel > **Shop > Services**
2. Click **Add Service**
3. Fill in:
   - **Name:** Service name
   - **Category:** Service category
   - **Service Type:** Choose from list or "custom"
   - **Service Value:** Value for service (level, gold amount, etc.)
   - **Price:** Cost in DP/VP/Money
4. Click **Save**

---

## Subscription Management

Subscriptions with recurring billing are fully supported.

### How Subscriptions Work

1. Player purchases subscription
2. Payment processed
3. Subscription activated with billing date
4. On renewal date, player is charged automatically
5. Player can cancel anytime

### Gateway Cancellation

When a player cancels a subscription:
- Local subscription marked as cancelled
- PayPal/Stripe subscription also cancelled
- No further charges occur

### Configuration

Edit `/application/config/config.php`:

```php
// Subscription Configuration
$config['shop_subscription_auto_renew'] = true;
$config['shop_subscription_grace_period'] = 3;  // Days before renewal
```

### Creating Subscriptions

1. Admin Panel > **Shop > Subscriptions**
2. Click **Add Subscription**
3. Fill in:
   - **Name:** Subscription name
   - **Description:** What's included
   - **Price:** Monthly/yearly cost
   - **Interval:** Billing frequency (monthly, yearly)
   - **Features:** What benefits included
4. Click **Save**

---

## Payment Processing Flow

### PayPal Flow

```
1. Customer adds items to cart
2. Clicks "Checkout"
3. Selects PayPal payment
4. Redirected to PayPal
5. Logs in and approves payment
6. Redirected back to shop
7. Order created and marked paid
8. Items delivered automatically
```

### Stripe Flow

```
1. Customer adds items to cart
2. Clicks "Checkout"
3. Selects Stripe payment
4. Sees Stripe checkout form
5. Enters card details
6. Clicks "Pay"
7. Payment processed
8. Order created and marked paid
9. Items delivered automatically
```

---

## Testing Checklist

### PayPal Testing
- [ ] Sandbox credentials configured
- [ ] Can add items to cart
- [ ] Checkout redirects to PayPal
- [ ] Can complete test payment
- [ ] Order created after payment
- [ ] Items delivered to mailbox

### Stripe Testing
- [ ] Test API keys configured
- [ ] Can add items to cart
- [ ] Checkout shows Stripe form
- [ ] Can complete test payment with test card
- [ ] Order created after payment
- [ ] Items delivered to mailbox

### Services Testing
- [ ] Can purchase service
- [ ] Service applied to character
- [ ] Character receives in-game effect

### Subscriptions Testing
- [ ] Can purchase subscription
- [ ] Subscription activated
- [ ] Renewal date set correctly
- [ ] Can cancel subscription
- [ ] Gateway subscription also cancelled

---

## Troubleshooting

### PayPal Payment Fails
- **Issue:** "PayPal not configured"
- **Fix:** Verify Client ID and Secret in config
- **Issue:** Redirect to PayPal fails
- **Fix:** Check API credentials and sandbox mode

### Stripe Payment Fails
- **Issue:** "Stripe not configured"
- **Fix:** Verify API keys in config
- **Issue:** Test card declined
- **Fix:** Use correct test card from list above

### Items Not Delivered
- **Issue:** Items marked delivered but not in mailbox
- **Fix:** Check character database connection and mail tables
- **Issue:** Wrong character receives item
- **Fix:** Verify character ID in order

### Subscription Cancellation Fails
- **Issue:** Local cancellation works but gateway not cancelled
- **Fix:** Verify gateway credentials and external subscription ID

---

## Security Considerations

1. **Never commit API keys** to version control
2. **Use environment variables** for sensitive data
3. **Enable HTTPS** for all payment pages
4. **Validate all payments** server-side
5. **Log all transactions** for audit trail
6. **Use sandbox mode** for testing
7. **Monitor for fraud** patterns

---

## Production Deployment

### Before Going Live

1. Switch PayPal mode from `sandbox` to `production`
2. Switch Stripe keys from test to live keys
3. Update redirect URLs to production domain
4. Test full payment flow with real payment
5. Enable fraud detection
6. Setup email notifications
7. Configure backup payment methods
8. Test refund process

### Production Configuration

```php
// Production Settings
$config['paypal_mode'] = 'production';
$config['paypal_client_id'] = 'YOUR_LIVE_CLIENT_ID';
$config['paypal_secret'] = 'YOUR_LIVE_SECRET';

$config['stripe_public_key'] = 'pk_live_YOUR_LIVE_KEY';
$config['stripe_secret_key'] = 'sk_live_YOUR_LIVE_KEY';
```

---

## Support & Documentation

- [PayPal Developer Docs](https://developer.paypal.com/docs)
- [Stripe Documentation](https://stripe.com/docs)
- [BlizzCMS Shop Module](./application/modules/shop)

---

*Last Updated: January 11, 2026*
