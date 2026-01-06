<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('settings') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_settings') ?></h1>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <form action="<?= site_url('donate/admin/settings') ?>" method="post">
          <?= csrf_field() ?>
          
          <div class="uk-margin">
            <label>
              <input class="uk-checkbox" type="checkbox" name="donate_enabled" value="1" <?= config_item('donate_enabled') == '1' ? 'checked' : '' ?>>
              <?= lang('donate_enabled') ?>
            </label>
            <div class="uk-text-small uk-text-muted">Enable or disable the donation system</div>
          </div>

          <div class="uk-grid-small uk-margin-top" uk-grid>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('donate_currency') ?></label>
              <select class="uk-select" name="donate_currency">
                <option value="USD" <?= config_item('donate_currency') == 'USD' ? 'selected' : '' ?>>USD - US Dollar</option>
                <option value="EUR" <?= config_item('donate_currency') == 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
                <option value="GBP" <?= config_item('donate_currency') == 'GBP' ? 'selected' : '' ?>>GBP - British Pound</option>
                <option value="BRL" <?= config_item('donate_currency') == 'BRL' ? 'selected' : '' ?>>BRL - Brazilian Real</option>
                <option value="CAD" <?= config_item('donate_currency') == 'CAD' ? 'selected' : '' ?>>CAD - Canadian Dollar</option>
                <option value="AUD" <?= config_item('donate_currency') == 'AUD' ? 'selected' : '' ?>>AUD - Australian Dollar</option>
              </select>
            </div>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('donate_min_amount') ?></label>
              <input class="uk-input" type="number" step="0.01" min="0" name="donate_min_amount" value="<?= config_item('donate_min_amount') ?>">
            </div>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('donate_max_amount') ?></label>
              <input class="uk-input" type="number" step="0.01" min="0" name="donate_max_amount" value="<?= config_item('donate_max_amount') ?>">
            </div>
          </div>

          <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
