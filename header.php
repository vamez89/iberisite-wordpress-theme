<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php echo esc_attr(substr(iberisite_meta_description(), 0, 160)); ?>">
    <link rel="canonical" href="<?php echo esc_url(canonical_url()); ?>">
    
    <!-- Preload critical resources for performance (lazy loading) -->
    <link rel="preload" href="/favicon.ico" as="image">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.ico" type="image/x-icon">

    <?php wp_head(); ?>
</head>

<body <?php body_class('minimalist responsive'); ?>>
<div id="page" class="site">

    <!-- HEADER SEPARABLE (Componente reutilizable - Mobile/Tablet/PC adaptive) -->
    <header id="masthead" class="site-header" role="banner">
        <div class="container site-header__inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php the_custom_logo(); ?>
                    </a>
                <?php else : ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <!-- Descripción corta SEO-optimized -->
                <?php if (get_bloginfo('description')) : ?>
                    <p class="site-description">
                        <?php echo esc_html(get_bloginfo('description')); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Navigation responsive con menú hamburguesa para móvil -->
            <nav id="primary-navigation" class="main-navigation site-nav" role="navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu responsive',
                    'container'      => false,
                    'fallback_cb'    => false // Usar fallback menu si no hay menú configurado (SEO)
                ));
                ?>

                <!-- Mobile toggle button visible only on mobile -->
                <button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false">
                    <span>☰</span>
                    <span><?php esc_html_e('Menú', 'iberisite-theme'); ?></span>
                </button>
            </nav>
        </div>

        <!-- CSS Responsive: Media queries (mobile/tablet breakpoints) -->
        <style type="text/css" media="screen">
            /* Mobile-first approach - Base styles for all devices */
            .site-header__inner {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
            }

            .mobile .menu-toggle {
                display: block;
            }

            .tablet .primary-menu ul {
                display: flex;
                flex-direction: row;
            }

            /* Tablet breakpoint (768px - 1024px) */
            @media (min-width: 768px) and (max-width: 1024px) {
                .site-header__inner {
                    padding: 20px;
                }
            }

            /* Desktop breakpoint (1024px+) */
            @media (min-width: 1025px) {
                .main-navigation.site-nav ul {
                    display: flex;
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }

                .main-navigation.site-nav li {
                    margin-right: 30px;
                }
            }

            /* Performance: Lazy loading para imágenes en header */
            img.lazy-load {
                max-width: 100%;
                height: auto;
            }
        </style>
    </header>

</div><!-- /.site -->

<!-- FOOTER SEPARABLE (Componente reutilizable - Mobile/Tablet/PC adaptive) -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container footer__inner">
        
        <!-- Footer widgets área para contenido relevante SEO -->
        <div class="footer-widgets" id="footer-widgets">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="widget-area widget-container">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="widget-area widget-container">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer legal y copyright para SEO -->
        <div class="footer-legal">
            <div class="footer-copyright">
                &copy; <?php echo esc_attr(date('Y')); ?> <?php bloginfo('name'); ?>. 
                Todos los derechos reservados.
            </div>

            <!-- Meta tags de attribution para SEO -->
            <?php if (get_bloginfo('credit')) : ?>
                <p class="footer-credit"><?php echo esc_html(get_bloginfo('credit')); ?></p>
            <?php endif; ?>
        </div>

        <!-- CSS Responsive footer - Mobile/Tablet/PC adaptive -->
        <style type="text/css" media="screen">
            /* Mobile-first approach */
            .footer__inner {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 40px 20px;
                text-align: center;
            }

            /* Tablet breakpoint */
            @media (min-width: 768px) {
                .footer-widgets {
                    display: flex;
                    gap: 30px;
                }
                
                .footer-widgets > div {
                    flex: 1;
                    text-align: center;
                }
            }

            /* Desktop breakpoint */
            @media (min-width: 1025px) {
                .site-footer {
                    background-color: #f8f9fa;
                    border-top: 1px solid #eee;
                }
            }

            /* SEO: Footer content debe ser relevante para búsqueda */
            footer[role="contentinfo"] {
                font-size: 0.9rem;
            }
        </style>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
