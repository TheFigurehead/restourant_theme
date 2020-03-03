<header id="header" class="site-header" style="<?php echo nu_get_style_attr( 'header_background' ); ?>">
   <div class="container">
      <div class="row flex-nowrap align-items-center justify-content-between">
          <div class="col-auto">
              <a class="site-header-logo" href="#">
                  <?php echo nu_get_custom_logo( 'header_logo' ); ?>
              </a>
          </div>

          <div class="col-auto">
              <nav class="site-header-nav">
                <div id="header__nav_primary_callback">
                    <?php
                        nu_prime_menu_callback();
                    ?>
                </div>
                <?php wp_nav_menu( array(
                'theme_location'  => 'primary',
                'menu'            => '',
                'container'       => false,
                // 'container_class' => '',
                // 'container_id'    => '',
                'menu_class'      => 'site-header-nav-list',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => false,
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => new \North\App\Nu_Walker_Nav_Menu,
                ) );
                ?>
              </nav>
          </div>

          <div class="col-auto">
              <div class="lang">
                  <span class="lang-current">EN</span>
                  <span class="lang-icon">
		<svg width="8" height="5" viewBox="0 0 8 5" xmlns="http://www.w3.org/2000/svg">
<path d="M1.07784 0.128455C0.98961 0.0455285 0.871965 0 0.747398 0C0.622832 0 0.505186 0.0455285 0.418681 0.128455L0.140137 0.390244C-0.0415221 0.560976 -0.0415221 0.839024 0.140137 1.00813L3.32177 3.99837L0.136677 6.99187C0.0484425 7.07317 0 7.18374 0 7.30081C0 7.41789 0.0484425 7.52846 0.136677 7.60976L0.415221 7.87154C0.503456 7.95447 0.619372 8 0.743938 8C0.868504 8 0.98615 7.95447 1.07265 7.87154L4.86501 4.30894C4.95324 4.22602 5.00169 4.11545 4.99996 3.99837C4.99996 3.8813 4.95151 3.77073 4.86501 3.6878L1.07784 0.128455Z" transform="translate(8) rotate(90)"/>
</svg>
	</span>
                  <div class="lang-dropdown">
                      <ul class="lang-list">
                          <li class="lang-item">
                              <a href="#ru">RU</a>
                          </li>
                          <li class="lang-item">
                              <a href="#gr">GR</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
   </div>
</header>
