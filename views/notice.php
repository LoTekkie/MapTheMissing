<?php

//phpcs:disable VariableAnalysis
// There are "undefined" variables here because they're defined in the code that includes this file as a template.

?>
<?php if ( $type == 'plugin' ) : ?>
  <div class="updated" id="mapthemissing_setup_prompt">
    <form name="mapthemissing_activate" action="<?php echo esc_url( MapTheMissing_Admin::get_page_url() ); ?>" method="POST">
      <div class="mapthemissing_activate">
        <div class="aa_button_container">
          <div class="">
            <input type="submit" class="mapthemissing-button" value="<?php esc_attr_e( 'Configure MapTheMissing', 'mapthemissing' ); ?>" />
          </div>
        </div>
        <div class="aa_description"><?php _e('<strong>Almost done</strong> - Configure MapTheMissing!', 'mapthemissing');?></div>
      </div>
    </form>
  </div>
<?php elseif ( $type == 'notice' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status failed"><?php echo $notice_header; ?></h3>
    <p class="mapthemissing-description">
        <?php echo $notice_text; ?>
    </p>
  </div>
<?php elseif ( $type == 'missing-functions' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status failed"><?php esc_html_e('Network functions are disabled.', 'mapthemissing'); ?></h3>
    <p class="mapthemissing-description"><?php printf( __('Your web host or server administrator has disabled PHP&#8217;s <code>gethostbynamel</code> function.  <strong>MapTheMissing cannot work correctly until this is fixed.</strong>  Please contact your web host or firewall administrator and give them <a href="%s" target="_blank">this information about mapthemissing&#8217;s system requirements</a>.', 'mapthemissing'), 'https://blog.mapthemissing.com/mapthemissing-hosting-faq/'); ?></p>
  </div>
<?php elseif ( $type == 'servers-be-down' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status failed"><?php esc_html_e("Your site can&#8217;t connect to the mapthemissing servers.", 'mapthemissing'); ?></h3>
    <p class="mapthemissing-description"><?php printf( __('Your firewall may be blocking MapTheMissing from connecting to its API. Please contact your host and refer to <a href="%s" target="_blank">our guide about firewalls</a>.', 'mapthemissing'), 'https://blog.mapthemissing.com/mapthemissing-hosting-faq/'); ?></p>
  </div>
<?php elseif ( $type == 'missing' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status failed"><?php esc_html_e( 'There is a problem with your API key.', 'mapthemissing'); ?></h3>
    <p class="mapthemissing-description"><?php printf( __('Please contact <a href="%s" target="_blank">MapTheMissing.com support</a> for assistance.', 'mapthemissing'), 'https://mapthemissing.com/contact/'); ?></p>
  </div>
<?php elseif ( $type == 'new-key-valid' ) : ?>
  <div class="mapthemissing-alert mapthemissing-active">
    <h3 class="mapthemissing-key-status"><?php esc_html_e( 'MapTheMissing is now ready. Scroll down to see how to get started.', 'mapthemissing' ); ?></h3>
  </div>
<?php elseif ( $type == 'new-key-invalid' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status"><?php esc_html_e( 'The key you entered is invalid. Please double-check it.' , 'mapthemissing'); ?></h3>
  </div>
<?php elseif ( $type == 'existing-key-invalid' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status"><?php echo esc_html( __( 'Your API key is no longer valid.', 'mapthemissing' ) ); ?></h3>
    <p class="mapthemissing-description">
        <?php

        echo wp_kses(
            sprintf(
            /* translators: The placeholder is a URL. */
                __( 'Please enter a new key or <a href="%s" target="_blank">Contact MapTheMissing.com support</a>.', 'mapthemissing' ),
                constant('MAPTHEMISSING_EMAIL_SUPPORT')
            ),
            array(
                'a' => array(
                    'href' => true,
                    'target' => true,
                ),
            )
        );

        ?>
    </p>
  </div>
<?php elseif ( $type == 'new-key-failed' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status"><?php esc_html_e( 'The API key you entered could not be verified.' , 'mapthemissing'); ?></h3>
    <p class="mapthemissing-description">
        <?php

        echo wp_kses(
            sprintf(
            /* translators: The placeholder is a URL. */
                __( 'The connection to mapthemissing.com could not be established. Please refer to <a href="%s" target="_blank">our guide about firewalls</a> and check your server configuration.', 'mapthemissing' ),
                'https://blog.mapthemissing.com/mapthemissing-hosting-faq/'
            ),
            array(
                'a' => array(
                    'href' => true,
                    'target' => true,
                ),
            )
        );

        ?>
    </p>
  </div>
<?php elseif ( $type == 'account-details-failed' ) : ?>
  <div class="mapthemissing-alert mapthemissing-critical">
    <h3 class="mapthemissing-key-status"><?php esc_html_e( 'Unable to fetch account details. Please double-check your API Key and ensure the service is available.' , 'mapthemissing'); ?></h3>
  </div>
<?php endif; ?>
