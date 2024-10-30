<?php

use LNCNearComments\Model\Constructor\Constructor;

ob_start();
?>
<?php if (isset($args) && isset($args->optionsGroup)): ?>
    <?php
    $options = Constructor::$options;
    $commentFormSelector = $options['comment_form_selector'] ?? '';
    $rewardValue = $options['reward_value'] ?? 0.001;
    $siteOwner = $options['site_owner'] ?? '';
    //$showRating = $options['show_rating'] ?? 'no';
    $result = get_settings_errors();
    $noticeClass = 'notice-error';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('LNC Near comments configurations', 'lnc-n-comments'); ?></h1>
        <?php if (isset($result[0]['message']) && isset($result[0]['code'])): ?>
            <?php if ($result[0]['code'] === 'settings_updated') {
                $noticeClass = 'notice-success';
            }
            ?>
            <div class="notice <?php echo esc_html($noticeClass); ?>">
                <p><?php echo esc_html($result[0]['message']); ?></p>
            </div>
        <?php endif; ?>
        <form method="post" action="options.php" class="settings-form">
            <?php settings_fields($args->optionsGroup); ?>
            <div class="form-table">
                <div class="form-group">
                    <label for="comment-form-selector"><?php _e('Comment form selector'); ?></label>
                    <input type="text" id="comment-form-selector"
                           name="<?php echo esc_html("$args->optionsGroup[comment_form_selector]"); ?>"
                           value="<?php echo esc_html($commentFormSelector); ?>" class="regular-text"/>
                </div>
            </div>
            <div class="form-table">
                <div class="form-group">
                    <label for="reward-value"><?php _e('Reward value'); ?></label>
                    <input type="number" id="reward-value" name="<?php echo esc_html("$args->optionsGroup[reward_value]"); ?>"
                           value="<?php echo esc_html($rewardValue); ?>" min="0" step="0.001" class="regular-text"/>
                </div>
            </div>
            <div class="form-table">
                <div class="form-group">
                    <label for="site-owner"><?php _e('Site owner'); ?></label>
                    <input type="text" id="site-owner" name="<?php echo esc_html("$args->optionsGroup[site_owner]"); ?>"
                           value="<?php echo esc_html($siteOwner); ?>" class="regular-text"/>
                </div>
            </div>
            <div class="form-table">
                <div class="form-group">
                    <button type="submit" class="button button-primary button-large"><?php _e('Save', 'lnc-n-comments'); ?></button>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>
<?php return ob_get_clean(); ?>
