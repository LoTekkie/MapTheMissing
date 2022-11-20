<?php

//phpcs:disable VariableAnalysis
// There are "undefined" variables here because they're defined in the code that includes this file as a template.

?>
<div class="mapthemissing-enter-api-key-box centered">
  <!--  <a href="#"><?php /*esc_html_e( 'Manually enter an API key', 'mapthemissing' ); */?></a>-->
  <div class="enter-api-key">
    <form action="<?php echo esc_url( MapTheMissing_Admin::get_page_url() ); ?>" method="post">
        <?php wp_nonce_field( MapTheMissing_Admin::NONCE ) ?>
      <input type="hidden" name="action" value="enter-key">
      <div style="display:flex;flex-flow: row nowrap;justify-content:space-between;align-items:center;padding:0 15px">
        <input id="key" name="key" type="text" size="15" value="<?php MapTheMissing::get_api_key() ?? '' ?>" placeholder="<?php esc_attr_e( 'Enter your API Key' , 'mapthemissing' ); ?>" class="regular-text code" style="flex-grow: 1; margin-right: 1rem;">
        <input type="submit" name="submit" id="submit" class="mapthemissing-button"  value="<?php esc_attr_e( 'Use this key', 'mapthemissing' );?>">
      </div>
    </form>
  </div>
</div>
