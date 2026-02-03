# BlizzCMS SEO Setup Guide - Quick Start

## 🚀 Getting Started (5 Minutes)

This guide walks you through setting up analytics and verification for your BlizzCMS site to start tracking organic traffic and search performance.

---

## Step 1: Google Analytics 4 Setup (2 minutes)

### 1.1 Create Google Analytics Account
1. Go to [Google Analytics](https://analytics.google.com/)
2. Click "Start measuring"
3. Enter your account name: "BlizzCMS" or your site name
4. Click "Create"

### 1.2 Set Up Property
1. Property name: "oldmanwarcraft.com" (or your domain)
2. Reporting timezone: Select your timezone
3. Currency: USD (or your currency)
4. Click "Create property"

### 1.3 Get Your Tracking ID
1. In the left menu, go to **Admin** → **Property** → **Data Streams**
2. Click on your web stream
3. Copy the **Measurement ID** (format: G-XXXXXXXXXX)

### 1.4 Add to BlizzCMS
1. Edit `/application/config/seo.php`
2. Find line 49: `$config['google_analytics_id'] = '';`
3. Replace with: `$config['google_analytics_id'] = 'G-XXXXXXXXXX';` (use your ID)
4. Save the file

---

## Step 2: Google Search Console Setup (2 minutes)

### 2.1 Add Property
1. Go to [Google Search Console](https://search.google.com/search-console)
2. Click "Add property"
3. Enter your domain: `oldmanwarcraft.com`
4. Click "Continue"

### 2.2 Verify Ownership
1. Google will show verification options
2. Select **HTML tag** method
3. Copy the content value from the meta tag
   - Example: `<meta name="google-site-verification" content="xxxxx" />`
   - Copy just the `xxxxx` part

### 2.3 Add to BlizzCMS
1. Edit `/application/config/seo.php`
2. Find line 50: `$config['google_search_console_verification'] = '';`
3. Replace with: `$config['google_search_console_verification'] = 'xxxxx';`
4. Save the file

### 2.4 Verify in Google Search Console
1. Go back to Google Search Console
2. Click "Verify"
3. Wait for confirmation (usually instant)

### 2.5 Submit Sitemap
1. In Google Search Console, go to **Sitemaps**
2. Enter: `sitemap.xml` (or full URL: `https://oldmanwarcraft.com/sitemap.xml`)
3. Click "Submit"

---

## Step 3: Bing Webmaster Tools Setup (1 minute)

### 3.1 Add Site
1. Go to [Bing Webmaster Tools](https://www.bing.com/webmasters)
2. Click "Add a site"
3. Enter your domain: `oldmanwarcraft.com`
4. Click "Add"

### 3.2 Verify Ownership
1. Bing will show verification options
2. Select **Meta tag** method
3. Copy the content value
   - Example: `<meta name="msvalidate.01" content="xxxxx" />`
   - Copy just the `xxxxx` part

### 3.3 Add to BlizzCMS
1. Edit `/application/config/seo.php`
2. Find line 51: `$config['bing_webmaster_verification'] = '';`
3. Replace with: `$config['bing_webmaster_verification'] = 'xxxxx';`
4. Save the file

### 3.4 Verify in Bing Webmaster Tools
1. Go back to Bing Webmaster Tools
2. Click "Verify"
3. Wait for confirmation

### 3.5 Submit Sitemap
1. In Bing Webmaster Tools, go to **Sitemaps**
2. Click "Submit sitemap"
3. Enter: `https://oldmanwarcraft.com/sitemap.xml`
4. Click "Submit"

---

## Step 4: Facebook Pixel Setup (Optional - 1 minute)

If you want to track conversions on Facebook:

### 4.1 Create Facebook Pixel
1. Go to [Facebook Business Manager](https://business.facebook.com/)
2. Go to **Events Manager**
3. Click "Create" → "Pixel"
4. Enter your website URL
5. Copy your **Pixel ID**

### 4.2 Add to BlizzCMS
1. Edit `/application/config/seo.php`
2. Find line 52: `$config['facebook_pixel_id'] = '';`
3. Replace with: `$config['facebook_pixel_id'] = 'your_pixel_id';`
4. Save the file

---

## Step 5: Verify Everything is Working

### 5.1 Check Robots.txt
1. Visit: `https://oldmanwarcraft.com/robots.txt`
2. You should see the robots.txt content with proper directives

### 5.2 Check Sitemap
1. Visit: `https://oldmanwarcraft.com/sitemap.xml`
2. You should see XML with all your pages and articles

### 5.3 Check Meta Tags
1. Visit your homepage: `https://oldmanwarcraft.com/`
2. Right-click → "View Page Source"
3. Search for `<meta name="description"` - should be present
4. Search for `<meta name="google-site-verification"` - should be present if you added it
5. Search for `gtag` - should be present if Google Analytics ID is set

### 5.4 Test in Google Search Console
1. Go to Google Search Console
2. Go to **URL Inspection**
3. Enter your homepage URL
4. Click "Inspect"
5. Click "Test live URL"
6. Wait for results (may take a few seconds)

---

## 📊 What Gets Tracked

### Google Analytics Tracks:
- ✅ Page views
- ✅ User sessions
- ✅ Traffic sources (organic, direct, referral)
- ✅ User behavior (time on page, bounce rate)
- ✅ Device types (mobile, desktop, tablet)
- ✅ Geographic location
- ✅ Browser and OS information

### Google Search Console Shows:
- ✅ Search queries that bring users to your site
- ✅ Click-through rates (CTR)
- ✅ Average position in search results
- ✅ Crawl errors and issues
- ✅ Mobile usability issues
- ✅ Security issues

### Bing Webmaster Tools Shows:
- ✅ Search traffic data
- ✅ Keyword performance
- ✅ Crawl statistics
- ✅ Inbound links
- ✅ Site issues

---

## 🔍 Monitoring Your SEO

### Daily Tasks
- Check for critical errors in Google Search Console

### Weekly Tasks
- Review top search queries in Google Search Console
- Check for new crawl errors
- Monitor website uptime

### Monthly Tasks
- Analyze traffic in Google Analytics
- Review top performing pages
- Check keyword rankings
- Identify broken links

### Quarterly Tasks
- Full SEO audit
- Keyword research and analysis
- Competitor analysis
- Content gap analysis

---

## 🛠️ Configuration File Reference

**File**: `/application/config/seo.php`

```php
// Analytics IDs (CRITICAL - Add these!)
$config['google_analytics_id'] = 'G-XXXXXXXXXX';
$config['google_search_console_verification'] = 'xxxxx';
$config['bing_webmaster_verification'] = 'xxxxx';
$config['facebook_pixel_id'] = 'xxxxx';

// Matomo Analytics (Already configured)
$config['matomo_enabled'] = true;
$config['matomo_container_id'] = 'kgENxDDG';
$config['matomo_site_url'] = 'https://analytics.thecorehosting.net';

// SEO Features (All enabled by default)
$config['seo_tags'] = true;
$config['seo_og_tags'] = true;
$config['seo_enable_twitter_cards'] = true;
$config['seo_enable_schema_markup'] = true;
$config['seo_enable_canonical_tags'] = true;
$config['seo_enable_hreflang_tags'] = true;

// Performance (All enabled by default)
$config['enable_gzip_compression'] = true;
$config['enable_browser_caching'] = true;
$config['image_lazy_loading'] = true;
```

---

## ⚠️ Common Issues & Solutions

### Issue: Analytics not showing data
**Solution**: 
- Wait 24 hours for data to appear
- Check that your tracking ID is correct
- Verify you're not using an ad blocker
- Check Google Analytics settings for filters

### Issue: Sitemap not found
**Solution**:
- Verify `/application/controllers/Sitemap.php` exists
- Check database connection
- Ensure news and page models are loaded
- Check file permissions

### Issue: Verification meta tags not showing
**Solution**:
- Verify `/application/views/layouts/seo_head.php` is included in your layout
- Check that verification codes are in `/application/config/seo.php`
- Clear browser cache and view page source again

### Issue: Robots.txt showing errors
**Solution**:
- Verify `/application/controllers/Robots.php` exists
- Check that routes are configured correctly
- Ensure the controller is accessible

---

## 📞 Support Resources

- [Google Analytics Help](https://support.google.com/analytics)
- [Google Search Console Help](https://support.google.com/webmasters)
- [Bing Webmaster Tools Help](https://www.bing.com/webmasters/help)
- [Schema.org Documentation](https://schema.org)
- [Google Search Central](https://developers.google.com/search)

---

## ✅ Setup Checklist

- [ ] Google Analytics ID added to config
- [ ] Google Search Console verified
- [ ] Google Search Console sitemap submitted
- [ ] Bing Webmaster Tools verified
- [ ] Bing Webmaster Tools sitemap submitted
- [ ] Facebook Pixel ID added (optional)
- [ ] Robots.txt tested and working
- [ ] Sitemap.xml tested and working
- [ ] Meta tags verified in page source
- [ ] Verification tags confirmed in Google Search Console
- [ ] Verification tags confirmed in Bing Webmaster Tools

---

**Setup Time**: ~5-10 minutes
**Ongoing Maintenance**: 30 minutes/month
**Expected Results**: Improved organic traffic within 2-4 weeks

