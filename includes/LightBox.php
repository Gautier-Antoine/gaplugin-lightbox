<?php
namespace GAPlugin;
/**
* Class LightBox
* manage the gallery
*/
class LightBox extends AdminPage{
    const
      /**
      * @var string name of the page
      */
      PAGE = 'lightbox',
      /**
      * @var string name of the language file
      */
      LANGUAGE = 'lightbox-text',
      /**
      * @var string name for the files
      */
      FILE = 'lightbox',
      /**
      * @var string name for the plugin folder
      */
      FOLDER = 'gaplugin-lightbox';

    public static function getfolder(){
      return plugin_dir_url( __DIR__ );
    }
    /**
    * @var array list of social medias
    */
    public static $list = [
      ['name' => 'icon-arrow'],
      ['name' => 'icon-cross']
    ];

    public static function registerPublicScripts () {
      wp_register_style(static::FILE, static::getFolder() . 'includes/' . static::FILE . '.css');
      wp_enqueue_style(static::FILE);
      wp_register_script(static::FILE . '-js', static::getFolder() . 'includes/' . static::FILE . '.js', [], false, true);
      wp_enqueue_script(static::FILE . '-js');

      if (get_option(static::PAGE . '-icon-arrow')) {
        wp_enqueue_style(static::FILE . '-php', static::getFolder() . 'includes/' . static::FILE . '-css.php' );
        $arrow = esc_url( get_option(static::PAGE . '-icon-arrow') );
        $custom_arrow = ".lightbox__prev, .lightbox__next {
                          background: url($arrow);
                          background-size: auto;
                          background-repeat: no-repeat;
                          background-position: center center;
                        }";
        wp_add_inline_style( static::FILE . '-php', $custom_arrow );
      }
      if (get_option(static::PAGE . '-icon-cross')) {

        wp_enqueue_style(static::FILE . '-php', static::getFolder() . 'includes/' . static::FILE . '-css.php' );
        $cross = esc_url( get_option(static::PAGE . '-icon-cross') );
        $custom_cross = ".lightbox__close {
                          background: url($cross);
                          background-size: auto;
                          background-repeat: no-repeat;
                          background-position: center center;
                        }";
        wp_add_inline_style( static::FILE . '-php', $custom_cross );
      }
    }
    public static function registerAdminScripts() {
    }

      public static function register () {
        add_action( 'wp_enqueue_scripts', [static::class, 'registerPublicScripts']);
        // add_action( 'enqueue_block_assets', [static::class, 'registerPublicScripts']);
          add_action('admin_enqueue_scripts', [static::class, 'AdminScripts']);
          add_action('admin_init', [static::class, 'registerSettings']);
          add_action('admin_menu', [static::class, 'addMenu']);
          load_plugin_textdomain(static::LANGUAGE, false, static::FOLDER . '/languages/' );
      }
    public static function registerSettingsText () {
      printf(
        __( 'The %1$s is activated', static::LANGUAGE) . '<br><br>' .
        __( 'Add the full url to modify the %1$s', static::LANGUAGE) . ' (https://www.example.com/img.svg) <br>' .
        __( 'If empty will show the normal icon', static::LANGUAGE) . '<br><br>'
        , 'LightBox'
      );
    }
    public static function addPageFunction($args) {
        ?>
          <textarea
            name="<?= static::PAGE . '-' . $args['class'] ?>"
            cols="30"
            rows= "1"
            title="<?php printf(__('Put your %1$s URL', static::LANGUAGE), $args['class']) ?>"
          ><?=
              esc_url(get_option(static::PAGE . '-' . $args['class']))
          ?></textarea>
        <?php
    }
}
