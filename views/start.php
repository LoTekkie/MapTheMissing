<div id="mapthemissing-plugin-container">
    <?php if ( ! empty( $notices ) ) { ?>
        <?php foreach ( $notices as $notice ) { ?>
            <?php MapTheMissing::view( 'notice', ['type' => $notice ] ); ?>
        <?php } ?>
    <?php } ?>
  <div class="mapthemissing-masthead">
    <div class="mapthemissing-masthead__inside-container">
      <div class="mapthemissing-masthead__logo-container">
        <p><a id="mapthemissing-logo-text" href="<?php echo mapthemissing_url(); ?>" target="_blank">MapTheMissing.com</a></p>
      </div>
    </div>
  </div>
  <div class="mapthemissing-lower">
    <div class="mapthemissing-boxes">
        <?php
        MapTheMissing::view( 'activate' );
        ?>
    </div>
  </div>
</div>