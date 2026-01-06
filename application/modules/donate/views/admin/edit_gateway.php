<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><a href="<?= site_url('donate/admin/gateways') ?>"><?= lang('donate_gateways') ?></a></li>
          <li><span><?= html_escape($gateway->display_name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="<?= $gateway->icon ?>"></i> <?= html_escape($gateway->display_name) ?>
        </h1>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <form action="<?= site_url('donate/admin/gateways/edit/' . $gateway->name) ?>" method="post">
          <?= csrf_field() ?>
          
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('name') ?></label>
              <input class="uk-input" type="text" name="display_name" value="<?= set_value('display_name', $gateway->display_name) ?>" required>
            </div>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('position') ?></label>
              <input class="uk-input" type="number" min="0" name="sort_order" value="<?= set_value('sort_order', $gateway->sort_order) ?>">
            </div>
          </div>

          <div class="uk-margin-top">
            <label class="uk-form-label"><?= lang('description') ?></label>
            <textarea class="uk-textarea" name="description" rows="2"><?= set_value('description', $gateway->description) ?></textarea>
          </div>

          <hr class="uk-divider-small">

          <h4 class="uk-margin-top"><?= lang('donate_gateway_config') ?></h4>

          <?php if ($gateway->name === 'paypal'): ?>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('donate_paypal_client_id') ?></label>
            <input class="uk-input" type="text" name="client_id" value="<?= set_value('client_id', $config['client_id'] ?? '') ?>">
            <span class="uk-text-small uk-text-muted">For simple integration, use your PayPal email address</span>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('donate_paypal_client_secret') ?></label>
            <input class="uk-input" type="password" name="client_secret" value="<?= set_value('client_secret', $config['client_secret'] ?? '') ?>">
            <span class="uk-text-small uk-text-muted">Required for PayPal REST API (optional for simple integration)</span>
          </div>
          <?php elseif ($gateway->name === 'stripe'): ?>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('donate_stripe_publishable_key') ?></label>
            <input class="uk-input" type="text" name="publishable_key" value="<?= set_value('publishable_key', $config['publishable_key'] ?? '') ?>">
          </div>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('donate_stripe_secret_key') ?></label>
            <input class="uk-input" type="password" name="secret_key" value="<?= set_value('secret_key', $config['secret_key'] ?? '') ?>">
          </div>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('donate_stripe_webhook_secret') ?></label>
            <input class="uk-input" type="password" name="webhook_secret" value="<?= set_value('webhook_secret', $config['webhook_secret'] ?? '') ?>">
            <span class="uk-text-small uk-text-muted">Required to verify webhook signatures</span>
          </div>
          <?php endif; ?>

          <hr class="uk-divider-small">

          <div class="uk-grid-small uk-margin-top" uk-grid>
            <div class="uk-width-auto">
              <label>
                <input class="uk-checkbox" type="checkbox" name="is_sandbox" value="1" <?= set_checkbox('is_sandbox', '1', $gateway->is_sandbox == 1) ?>>
                <?= lang('donate_sandbox_mode') ?>
              </label>
              <div class="uk-text-small uk-text-muted">Enable for testing, disable for live payments</div>
            </div>
            <div class="uk-width-auto">
              <label>
                <input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', $gateway->is_active == 1) ?>>
                <?= lang('active') ?>
              </label>
            </div>
          </div>

          <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
            <a href="<?= site_url('donate/admin/gateways') ?>" class="uk-button uk-button-default">
              <?= lang('cancel') ?>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
