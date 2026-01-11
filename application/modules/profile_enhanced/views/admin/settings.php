<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-cog text-primary"></i> Profile Enhanced Settings
        </h2>
        <a href="<?= site_url('profile_enhanced/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <?= form_open('profile_enhanced/admin/settings') ?>
            
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="mb-3 text-primary">
                        <i class="fas fa-toggle-on"></i> Feature Settings
                    </h5>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_timeline" value="1" 
                                   class="custom-control-input" id="enableTimeline" 
                                   <?= ($settings['enable_timeline'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableTimeline">
                                <strong>Enable Activity Timeline</strong>
                                <br><small class="text-muted">Show user activity history on profiles</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_achievements" value="1" 
                                   class="custom-control-input" id="enableAchievements" 
                                   <?= ($settings['enable_achievements'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableAchievements">
                                <strong>Enable Achievement Showcase</strong>
                                <br><small class="text-muted">Allow users to showcase their achievements</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_character_gallery" value="1" 
                                   class="custom-control-input" id="enableCharacters" 
                                   <?= ($settings['enable_character_gallery'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableCharacters">
                                <strong>Enable Character Gallery</strong>
                                <br><small class="text-muted">Display all user characters on profiles</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_profile_visits" value="1" 
                                   class="custom-control-input" id="enableVisits" 
                                   <?= ($settings['enable_profile_visits'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableVisits">
                                <strong>Enable Profile Visit Tracking</strong>
                                <br><small class="text-muted">Track and display profile view statistics</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_social_links" value="1" 
                                   class="custom-control-input" id="enableSocial" 
                                   <?= ($settings['enable_social_links'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableSocial">
                                <strong>Enable Social Links</strong>
                                <br><small class="text-muted">Allow users to add social media links</small>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enable_profile_themes" value="1" 
                                   class="custom-control-input" id="enableThemes" 
                                   <?= ($settings['enable_profile_themes'] ?? '1') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="enableThemes">
                                <strong>Enable Profile Themes</strong>
                                <br><small class="text-muted">Allow users to customize profile appearance</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5 class="mb-3 text-success">
                        <i class="fas fa-sliders-h"></i> Configuration Settings
                    </h5>

                    <div class="form-group">
                        <label for="maxShowcase">
                            <strong>Max Showcase Achievements</strong>
                        </label>
                        <input type="number" name="max_showcase_achievements" id="maxShowcase" 
                               class="form-control" value="<?= $settings['max_showcase_achievements'] ?? 6 ?>" 
                               min="1" max="20">
                        <small class="form-text text-muted">Maximum achievements a user can showcase (1-20)</small>
                    </div>

                    <div class="form-group">
                        <label for="maxBioLength">
                            <strong>Maximum Biography Length</strong>
                        </label>
                        <input type="number" name="max_bio_length" id="maxBioLength" 
                               class="form-control" value="<?= $settings['max_bio_length'] ?? 500 ?>" 
                               min="100" max="2000">
                        <small class="form-text text-muted">Maximum characters for user biography (100-2000)</small>
                    </div>

                    <div class="form-group">
                        <label for="defaultVisibility">
                            <strong>Default Profile Visibility</strong>
                        </label>
                        <select name="default_profile_visibility" id="defaultVisibility" class="form-control">
                            <option value="public" <?= ($settings['default_profile_visibility'] ?? 'public') == 'public' ? 'selected' : '' ?>>
                                Public - Anyone can view
                            </option>
                            <option value="members" <?= ($settings['default_profile_visibility'] ?? 'public') == 'members' ? 'selected' : '' ?>>
                                Members Only - Registered users only
                            </option>
                            <option value="private" <?= ($settings['default_profile_visibility'] ?? 'public') == 'private' ? 'selected' : '' ?>>
                                Private - Owner only
                            </option>
                        </select>
                        <small class="form-text text-muted">Default visibility for new profiles</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="require_bio_approval" value="1" 
                                   class="custom-control-input" id="requireApproval" 
                                   <?= ($settings['require_bio_approval'] ?? '0') == '1' ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="requireApproval">
                                <strong>Require Biography Approval</strong>
                                <br><small class="text-muted">Admin must approve biography changes</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Save Settings
                </button>
                <a href="<?= site_url('profile_enhanced/admin') ?>" class="btn btn-secondary btn-lg ml-2">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
            
            <?= form_close() ?>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-info-circle"></i> Settings Help
            </h5>
        </div>
        <div class="card-body">
            <h6 class="font-weight-bold">Feature Settings</h6>
            <p class="small text-muted mb-3">
                Control which profile features are available to users. Disabled features will not be visible on user profiles.
            </p>

            <h6 class="font-weight-bold">Achievement Showcase</h6>
            <p class="small text-muted mb-3">
                Users can select their favorite achievements to display prominently on their profile. Set a reasonable limit to prevent clutter.
            </p>

            <h6 class="font-weight-bold">Profile Visibility</h6>
            <p class="small text-muted mb-3">
                Default visibility determines who can view new profiles. Users can change their individual settings later.
            </p>

            <h6 class="font-weight-bold">Biography Approval</h6>
            <p class="small text-muted mb-0">
                Enable this to moderate user biographies and prevent inappropriate content. All biography changes will require admin approval.
            </p>
        </div>
    </div>
</div>

<style>
.custom-switch .custom-control-label::before {
    width: 2.5rem;
    height: 1.5rem;
    border-radius: 3rem;
}
.custom-switch .custom-control-label::after {
    width: calc(1.5rem - 4px);
    height: calc(1.5rem - 4px);
}
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
</style>
