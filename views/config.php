<?php

//phpcs:disable VariableAnalysis
// There are "undefined" variables here because they're defined in the code that includes this file as a template.

?>
<div id="mapthemissing-plugin-container">
    <div class="mapthemissing-masthead">
        <div class="mapthemissing-masthead__inside-container">
            <div class="mapthemissing-masthead__logo-container">
                <p><a id="mapthemissing-logo-text" href="<?php echo mapthemissing_url(); ?>" target="_blank">MapTheMissing.com</a></p>
            </div>
        </div>
    </div>
    <div class="mapthemissing-lower">
        <?php if ( MapTheMissing::get_api_key() ) { ?>
        <?php } ?>
        <?php if ( ! empty( $notices ) ) { ?>
            <?php foreach ( $notices as $notice ) { ?>
                <?php MapTheMissing::view( 'notice', ['type' => $notice] ); ?>
            <?php } ?>
        <?php } ?>

        <div class="mapthemissing-card">
            <div class="mapthemissing-section-header">
                <div class="mapthemissing-section-header__label">
                    <span><?php esc_html_e( 'Settings' , 'mapthemissing'); ?></span>
                </div>
            </div>

            <div class="inside">
                <form action="<?php echo esc_url( MapTheMissing_Admin::get_page_url() ); ?>" method="POST">
                    <table cellspacing="0" class="mapthemissing-settings" style="margin:0;width:100%;">
                        <tbody>
                        <?php if ( ! MapTheMissing::predefined_api_key() ) { ?>
                            <tr class="mapthemissing-api-key">
                                <td align="left">
                                    <span for="key" style="font-size:1.2em;position:relative;bottom:10px;"><?php esc_html_e('MapTheMissing API Key', 'mapthemissing');?></span>
                                    <span class="api-key full-max-width" style="margin-top:10px;"><input id="key" name="key" type="text" size="15" value="<?php echo esc_attr( get_option('mapthemissing_api_key') ); ?>" style="width:100%;"></span>
                                </td>
                            </tr>

                        <?php } else { ?>
                            <tr class="mapthemissing-api-key">
                                <td align="left">
                                    <span for="key" style="font-size:1.2em;position:relative;bottom:10px;"><?php esc_html_e('MapTheMissing API Key', 'mapthemissing');?></span>
                                    <span class="api-key full-max-width" style="margin-top:10px;"><input readonly id="key" name="key" type="text" size="15" value="<?php echo esc_attr( constant('MAPTHEMISSING_API_KEY') ); ?>" style="width:100%;"></span>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="mapthemissing-card-actions">
                        <?php if ( ! MapTheMissing::predefined_api_key() ) { ?>
                            <div id="delete-action">
                                <a class="submitdelete deletion" href="<?php echo esc_url( MapTheMissing_Admin::get_page_url( 'delete_key' ) ); ?>"><?php esc_html_e('Delete this API Key', 'mapthemissing'); ?></a>
                            </div>
                        <?php } ?>
                        <?php wp_nonce_field(MapTheMissing_Admin::NONCE) ?>
                        <?php if ( ! MapTheMissing::predefined_api_key() ) { ?>
                            <div id="publishing-action">
                                <input type="hidden" name="action" value="enter-key">
                                <input type="submit" name="submit" id="submit" class="mapthemissing-button mapthemissing-could-be-primary" value="<?php esc_attr_e('Save Changes', 'mapthemissing');?>">
                            </div>
                        <?php } ?>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>
        </div>

        <br>
        <div class="mapthemissing-card">
            <div class="mapthemissing-section-header">
                <div class="mapthemissing-section-header__label">
                    <span><?php esc_html_e( 'Account Details' , 'mapthemissing'); ?></span>
                </div>
            </div>
            <div class="inside">
                <div class="mapthemissing-account-details">
                    <?php if ( isset($details['username']) ) { ?>
                        <p><?php esc_html_e( 'Username' , 'mapthemissing'); ?>: <?php echo $details['username'] ?></p>
                    <?php } ?>
                    <?php if ( isset($details['balance']) ) { ?>
                        <p><?php esc_html_e( 'Balance' , 'mapthemissing'); ?>: <?php echo number_format($details['balance']) ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <br>
        <div class="mapthemissing-card">
            <div class="mapthemissing-section-header">
                <div class="mapthemissing-section-header__label">
                    <span><?php esc_html_e( 'Getting Started' , 'mapthemissing'); ?></span>
                </div>
            </div>
            <div class="inside">
                <!--<div class="mapthemissing-examples">
                    <div class="mapthemissing-example">
                        <ul style="margin-top:0;">
                            <li>Select "Posts" from the left side nav menu.</li>
                            <li>Choose to create a new post or edit an existing one.</li>
                        </ul>
                        <?php /*printf('<img src="%s" class="mapthemissing-example-image">', plugins_url( '../_inc/img/example_1.png', __FILE__ )); */?>
                    </div>
                    <hr>
                    <div class="mapthemissing-example">
                        <ul>
                            <li>While editing a post, ensure the settings are visible by clicking the gear icon in the top right.</li>
                            <li>Select Post settings and scroll down until you see the MapTheMissing section.</li>
                        </ul>
                        <?php /*printf('<img src="%s" class="mapthemissing-example-image">', plugins_url( '../_inc/img/example_2.png', __FILE__ )); */?>
                    </div>
                    <hr>
                    <div class="mapthemissing-example">
                        <ul>
                            <li>Ensure you have at least one paragraph or code block in the post body.</li>
                            <li>Enter some text in the block.</li>
                            <li>Choose your MapTheMissing settings and click the submit button.</li>
                        </ul>
                        <?php /*printf('<img src="%s" class="mapthemissing-example-image">', plugins_url( '../_inc/img/example_3.png', __FILE__ )); */?>
                    </div>
                    <hr>
                    <div class="mapthemissing-example">
                        <ul>
                            <li>Copy the output to your clipboard and paste it into your post.</li>
                            <li>Scroll down in the settings to view the cost, input, and output of the last run job.</li>
                            <li>Enjoy your auto-completed content!</li>
                        </ul>
                        <?php /*printf('<img src="%s" class="mapthemissing-example-image">', plugins_url( '../_inc/img/example_4.png', __FILE__ )); */?>
                    </div>
                </div>-->
            </div>
        </div>

    </div>
</div>
