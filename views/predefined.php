<div class="mapthemissing-box">
  <h2><?php esc_html_e( 'Manual Configuration', 'mapthemissing' ); ?></h2>
  <p>
      <?php
      /* translators: %s is the wp-config.php file */
      echo sprintf( esc_html__( 'An API key has been defined in the %s file for this site.', 'mapthemissing' ), '<code>wp-config.php</code>' );
      ?>
  </p>
</div>