<!DOCTYPE html>
<html lang="en-US">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Creed Interactive | Moacir Sant'anna">

    <?php /* Get meta tags */ get_template_part('inc/functions-meta-tags'); ?>

    <link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/favicon.svg">

    <?php wp_head(); ?>

  </head>

  <body <?php body_class(); ?>>

    <div class="navHeader"> 
      <div class="container">
        <div class="content">
          <div class="hamburguer">
            <div class="wrapper">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <div class="links noTransition">
            <ul>
              <?php
              ##################### MENU HEADER
              function wp_get_menu_array() {
                $array_menu = wp_get_nav_menu_items( 'Main Menu', array( 'order' => 'menu_order' ) );
                $menu = array();
                foreach ($array_menu as $m) {
                    if (empty($m->menu_item_parent)) {
                        $menu[$m->ID] = array();
                        $menu[$m->ID]['ID'] = $m->ID;
                        $menu[$m->ID]['title'] = $m->title;
                        $menu[$m->ID]['objectID'] = $m->object_id;
                        $menu[$m->ID]['url'] = $m->url;
                        $menu[$m->ID]['target'] = $m->target;
                        $menu[$m->ID]['classes'] = $m->classes;
                        $menu[$m->ID]['children'] = array();
                        $menu[$m->ID]['children_ids'] = array();
                    }
                }
                return $menu;
              }

              // If it has links
              if(wp_get_menu_array()) {
              foreach(wp_get_menu_array() as $item) { ?>
              <li class="<?php if($item['classes']) { echo implode(' ',$item['classes']); } ?>"><a target="<?php if($item['target']) { echo $item['target']; } ?>" href="<?php if(empty($item['url']) || $item['url'] == '#') { echo '#'; } else { echo $item['url']; } ?>"><?php echo $item['title']; ?></a></li>
              <?php } // End foreach    
              }
              else {
                echo '<p id="error">No menu item</p>';
              }
              ##################### END MENU HEADER
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="mainContent">