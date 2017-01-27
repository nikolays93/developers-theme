<?php

class themeCustomizer {
  public $viewport = 1200;
  public $w_paddings = 15;

  public static $fonts_exist = array(
    '' => 'Использовать шрифт ОС',
    'OpenSans'  => 'Open Sans',
    'Arial'     => 'Arial',
    'Courier'   => 'Courier New',
    'Roboto'  => 'Roboto',
    'RobotoSlab'  => 'Roboto Slab',
    'PTSerif' =>  'PT Serif',
    'PTSans'  => 'PT Sans',
    'Cuprum'  => 'Cuprum',
    'Tahoma'  => 'Tahoma',
    'Ubuntu' => 'Ubuntu',
    'Garamond' => 'Garamond',
    'Lobster'   =>  'Lobster',
    );

  function __construct()
  {
    add_action( 'customize_register', array($this, 'print_settings') );
    add_action( 'wp_head', array($this, 'set_dp_format') );
    add_action( 'wp_head', array($this, 'set_custom_font') );
    if (get_theme_mod( 'allow_click', false ))
      add_action( 'wp_head', array($this, 'allow_dropdown_click') );
  }
  function print_settings( $wp_customize ) {
    $wp_customize->add_section(
      'display_options',
      array(
        'title'     => 'Настройки отображения',
        'priority'  => 50,
        'description' => 'Настройте внешний вид вашего сайта'
      )
    );
    $wp_customize->add_setting('site-format', array('default'   => 'static'));
    $wp_customize->add_control(
      'site-format',
      array(
        'section'  => 'display_options',
        'label'    => 'Формат сайта',
        'description' => 'Будьте внимательны! Адаптивные сайты часто не поддерживают статичость и наоборот.',
        'type'     => 'select',
        'choices'  => array(
          'static'  =>  'Статичный',
          'adaptive' => 'Адаптивный',
          )
      )
    );
    $wp_customize->add_setting('use_scss', array('default'   => ''));
    $wp_customize->add_control(
      'use_scss',
      array(
        'section'  => 'display_options',
        'label'    => 'Использовать Scss предпроцессор (Только от имени админ-а)',
        'description' => 'После изменения стилей обновите страницу, чтобы предпроцессор скомпилировал стили. Прежде отключения удалите style.css, а assets/style.css переместите вместо него.',
        'type'     => 'checkbox',
      )
    );

    $wp_customize->add_setting('allow_click', array('default'   => ''));
    $wp_customize->add_control(
      'allow_click',
      array(
        'section'  => 'display_options',
        'label'    => 'Разрешить переход по ссылке выпадающего меню',
        'description' => '',
        'type'     => 'checkbox',
      )
    );
    // Шрифт
    $wp_customize->add_setting('custom_body_font', array('default'   => ''));
    $wp_customize->add_control(
      'custom_body_font',
      array(
        'section'  => 'display_options',
        'label'    => 'Шрифт',
        'type'     => 'select',
        'choices'  => self::$fonts_exist
      )
    );

    $wp_customize->add_setting('custom_headlines_font', array('default'   => ''));
    $wp_customize->add_control(
      'custom_headlines_font',
      array(
        'section'  => 'display_options',
        'label'    => 'Шрифт заголовков',
        'type'     => 'select',
        'choices'  => self::$fonts_exist
      )
    );

    $wp_customize->add_section('company_options', array(
        'title'     => 'Информация о компании',
        'priority'  => 60,
        'description' => 'Добавьте информации о своей организации'
      )
    );
    
    // Адресс
      $wp_customize->add_setting('company_address');
      $wp_customize->add_control('company_address',
        array(
          'type'     => 'textarea',
          'label'    => 'Адрес',
          'section'  => 'company_options',
        )
      );

      $wp_customize->add_setting('filter_company_address', array('default' => ''));
      $wp_customize->add_control('filter_company_address',
        array(
          'type' => 'checkbox',
          'label' => 'Не использовать content фильтр',
          'section'  => 'company_options',
          )
        );

    // Номера (контактных телефонов)
      $wp_customize->add_setting('company_numbers');
      $wp_customize->add_control('company_numbers',
        array(
          'type'     => 'textarea',
          'label'    => 'Номера телефонов',
          'section'  => 'company_options',
        )
      );

      $wp_customize->add_setting('filter_company_numbers', array('default' => ''));
      $wp_customize->add_control('filter_company_numbers',
        array(
          'type' => 'checkbox',
          'label' => 'Не использовать content фильтр',
          'section'  => 'company_options',
          )
        );

      $wp_customize->add_setting('company_work_time');
      $wp_customize->add_control('company_work_time',
        array(
          'type'     => 'textarea',
          'label'    => 'Режим работы',
          'section'  => 'company_options',
        )
      );
      
      $wp_customize->add_setting('filter_company_work_time', array('default' => ''));
      $wp_customize->add_control('filter_company_work_time',
        array(
          'type' => 'checkbox',
          'label' => 'Не использовать content фильтр',
          'section'  => 'company_options',
          )
        );

      $wp_customize->add_setting('company_email');
      $wp_customize->add_control('company_email',
        array(
          'type'     => 'text',
          'label'    => 'Email адрес',
          'section'  => 'company_options',
        )
      );
  }

  function set_dp_format(){
    $format = get_theme_mod( 'site-format' );
    if($format == 'adaptive'){
      $meta = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    } else {
      $w_container = $this->viewport - ( $this->w_paddings * 2 );
      $meta = '<meta name="viewport" content="width='.$this->viewport.'">
      ';
      $meta.='<style>.container {max-width: '.$w_container.'px !important;width: '.$w_container.'px !important;}</style>';
    }
    echo $meta;
  }
  function allow_dropdown_click(){
    echo '<style>.navbar-default .navbar-nav .nav-item:hover > .dropdown-menu { display: block; }</style>';
  }

  function set_custom_font(){
    $font_code = array();
      // Загружаем основной шрифт
    $fonts = array( get_theme_mod( 'custom_body_font' ),
    get_theme_mod( 'custom_headlines_font' ), );
        
    foreach ($fonts as $key => $font):
      $family = false;
      switch ($font) {
        case 'OpenSans':
          $font_code[] = "https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=cyrillic";
          $family = "'Open Sans', sans-serif";
          break;
        case 'Ubuntu':
          $font_code[] = "https://fonts.googleapis.com/css?family=Ubuntu:400,700&subset=latin,cyrillic";
          $family = "'Ubuntu', sans-serif";
          break;
        case 'Garamond':
          $font_code[] = "https://fonts.googleapis.com/css?family=EB+Garamond:400,700&subset=latin,cyrillic";
          $family = "'EB Garamond', serif";
          break;
        case 'PTSans':
          $font_code[] = "https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic";
          $family = "'PT Sans', sans-serif";
          break;
        case 'Cuprum':
          $font_code[] = "https://fonts.googleapis.com/css?family=Cuprum:400,700&subset=latin,cyrillic";
          $family = "'Cuprum', sans-serif";
          break;
        case 'Roboto':
          $font_code[] = "https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic";
          $family = "'Roboto', sans-serif";
          break;
        case 'RobotoSlab':
          $font_code[] = "https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin,cyrillic";
          $family = "'Roboto Slab', serif";
          break;
        case 'PTSerif':
          $font_code[] = "https://fonts.googleapis.com/css?family=PT+Serif:400,700&subset=latin,cyrillic";
          $family = "'PT Serif', serif";
          break;
        case 'Lobster':
          $font_code[] = "https://fonts.googleapis.com/css?family=Lobster:400,700&subset=latin,cyrillic";
          $family = "'Lobster', cursive";
          break;
        case 'Arial':
          $family = "Arial, Helvetica, sans-serif";
          break;
        case 'Courier':
          $family = "'Courier New', Courier";
          break;
        case 'Tahoma':
          $family = "Tahoma, Arial, Helvetica, sans-serif;";
          break;
      }

      if($family && $key == '0')
        echo "<style> body { font-family:", $family, "; } </style>";

      if($family && $key == '1')
        echo "<style> h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6,h1 a,.h1 a,h2 a,.h2 a,h3 a,.h3 a,h4 a,.h4 a,h5 a,.h5 a,h6 a,.h6 a { font-family:", $family, "; } </style>";

    endforeach;

    if($fonts['0']!=$fonts['1']){
      if(!empty($font_code['0'])) echo "<link href='". $font_code['0']. "' rel='stylesheet' type='text/css'>";
      if(!empty($font_code['1'])) echo "<link href='". $font_code['1']. "' rel='stylesheet' type='text/css'>";
    } elseif(!empty($font_code['0'])) {
      echo "<link href='", $font_code['0'], "' rel='stylesheet' type='text/css'>";
    } elseif(!empty($font_code['1'])) {
      echo "<link href='", $font_code['1'], "' rel='stylesheet' type='text/css'>";
    }
  }
// end class
}
new themeCustomizer();