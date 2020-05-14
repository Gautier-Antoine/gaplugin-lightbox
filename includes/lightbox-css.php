<?php
header("Content-type: text/css");
require_once('../../../../wp-config.php');

if (get_option('lightbox-icon-arrow')){
  ?>
    .lightbox__prev, .lightbox__next {
      background: url(<?= esc_url(get_option('lightbox-icon-arrow')); ?>);
      background-size: auto;
      background-repeat: no-repeat;
      background-position: center center;
    }
  <?php
}
if (get_option('lightbox-icon-cross')){
  ?>
    .lightbox__close {
      background: url(<?= esc_url(get_option('lightbox-icon-cross')); ?>);
      background-size: auto;
      background-repeat: no-repeat;
      background-position: center center;
    }
  <?php
}
