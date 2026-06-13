<?php if (!defined('ABSPATH')) { exit; } ?>

<!-- SEPARABLE TEMPLATE COMPONENTE - Footer HTML5 Semántico -->
<footer id="colophon" class="site-footer" role="contentinfo">
    
    <!-- SEO: Schema.org structured data en footer para rich results Google -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo esc_attr(get_bloginfo('name')); ?>",
        "url": "<?php echo esc_url(home_url('/')); ?>"
    }
    </script>

    <!-- Footer widgets área para contenido relevante SEO -->
    <div class="container footer__inner">
        
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

        <!-- Footer legal y copyright para SEO -->
        <div class="footer-legal">
            
            <!-- Meta tags de copyright y atribución para SEO -->
            <div class="footer-copyright">
                &copy; <?php echo esc_attr(date('Y')); ?> 
                <?php bloginfo('name'); ?>. 
                Todos los derechos reservados.
            </div>

            <!-- Footer credit (SEO: contenido relevante) -->
            <?php if (get_bloginfo('credit')) : ?>
                <p class="footer-credit">
                    <?php echo esc_html(get_bloginfo('credit')); ?>
                </p>
            <?php endif; ?>

        </div>
    </div>

    <!-- CSS Responsive Footer - Mobile/Tablet/PC Adaptive -->
    <style type="text/css" media="screen">
        /* Mobile-first approach - Base styles */
        .site-footer {
            background-color: #f8f9fa;
            padding: 40px 20px;
            border-top: 1px solid #eee;
        }

        .footer__inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 20px;
        }

        /* Tablet breakpoint (768px - 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .footer-widgets {
                display: flex;
                gap: 30px;
                width: 100%;
            }
            
            .footer-widgets > div {
                flex: 1;
                text-align: center;
            }
        }

        /* Desktop breakpoint (1025px+) */
        @media (min-width: 1025px) {
            .site-footer {
                padding: 50px 60px;
            }

            .footer__inner {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }

            .footer-widgets {
                display: flex;
                gap: 40px;
            }

            .footer-widgets > div {
                flex: 1;
            }
        }

        /* SEO: Footer content debe ser relevante para búsqueda */
        footer[role="contentinfo"] {
            font-size: 0.9rem;
            color: #666;
        }

        /* Lazy loading CSS para imágenes en footer (performance) */
        .footer img.lazy-load {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Accessibility: ARIA roles para navegación SEO-friendly */
        footer nav[role="navigation"] {
            list-style: none;
            padding: 0;
            margin: 0;
        }
    </style>

</footer>

<!-- Validación de seguridad antes de renderizar -->
<?php
/**
 * Verificar que no hay código peligroso en footer (anti-inyección)
 */
if (!function_exists('iberisite_footer_validate')) {
    function iberisite_footer_validate() {
        // Validar que no hay eval() dinámico (anti-inyección)
        if (preg_match('/eval\s*\(\s*[\'"]/', file_get_contents(__FILE__))) {
            error_log('[Iberisite Footer] Warning: eval() detectado en footer.php');
        }

        // Validar que no hay consultas SQL sin prepared statements (anti-SQL injection)
        if (preg_match('/mysql_query\(/i', file_get_contents(__FILE__))) {
            error_log('[Iberisite Footer] Warning: mysql_query() sin prepared statements');
        }

        return true;
    }
}

// Ejecutar validación antes de renderizar footer
iberisite_footer_validate();

?>
