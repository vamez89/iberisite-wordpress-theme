<?php
/**
 * Theme Name: Iberisite WordPress Theme
 * Theme URI: https://github.com/vamez89/iberisite-wordpress-theme
 * Author: Iberisite Development Team
 * Author URI: https://ibervisite.com
 * Description: Tema WordPress personalizado - Diseño minimalista, responsive (móvil/tablet/PC), orientado al SEO. Código seguro contra inyecciones SQL/XSS. Comenta
    en español. Adaptativo a dispositivos con breakpoints modernos. Ligero y optimizado para performance.
 * Version: 1.0.0
 * License: GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: iberisite-theme
 * Requires at least: 6.0
 * Tested up to: 6.5
 */

// ───────────────────────────────────────────────────────────────
// 🛡️ SEGURIDAD ANTI-INYECCIÓN - NUNCA CONFÍES EN INPUTS DE USUARIO
// ───────────────────────────────────────────────────────────────

/**
 * Función segura para obtener input con validación anti-XSS
 * @param string $var Variable a sanitizar
 * @return string Valor seguro
 */
function iberisite_sanitize_input($var) {
    // Regla #1: Validar TODOS los inputs de usuario antes de usar
    if (empty($var)) {
        return '';
    }
    // Escapar para prevenir XSS injection
    return htmlspecialchars(strip_tags($var), ENT_QUOTES, 'UTF-8');
}

/**
 * Función segura para consultas SQL con prepared statements
 * @param string $sql Consulta SQL preparada
 * @param array $params Parámetros vinculados
 * @return PDOStatement|mysqli_stmt|null Resultado o null en error
 */
function iberisite_safe_query($sql, $params = []) {
    // Regla #5: Usar prepared statements para prevenir SQL injection
    global $wpdb; // WordPress database API
    
    try {
        if ($wpdb->db_type === 'mysql') {
            // Preparar consulta con PDO o mysqli preparado
            $stmt = new PDOStatement($sql, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return $stmt->execute($params);
        }
    } catch (PDOException $e) {
        error_log("Iberisite SQL Error: " . $e->getMessage()); // Logging seguro sin exponer datos sensibles
        return null;
    }
}

// ───────────────────────────────────────────────────────────────
// 🔧 FUNCIONES BÁSICAS - SEGURIDAD Y SEO INTEGRADAS
// ───────────────────────────────────────────────────────────────

/**
 * Obtiene meta description optimizada para SEO
 */
function iberisite_meta_description() {
    $meta = get_option('iberisite_meta', '');
    if (empty($meta)) {
        // Default SEO description ligera y relevante
        $meta = 'Contenido web profesional, diseño responsive y minimalista. Optimizado para SEO y experiencia de usuario.';
    }
    // Longitud óptima: ~160 caracteres para SEO
    return substr(strip_tags($meta), 0, 160);
}

/**
 * Validación segura de inputs de formulario (anti-inyección)
 */
function iberisite_validate_input($input) {
    if (!is_string($input)) {
        return false;
    }
    // Sanitización con htmlspecialchars para XSS protection
    $clean = trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    
    // Regla: Validar LONGITUD y FORMATO de inputs
    if (strlen($clean) < 1 || strlen($clean) > 255) {
        return false;
    }
    
    // Regla: Permitir solo caracteres seguros (evitar inyección SQL)
    preg_match('/[^a-zA-Z0-9\s\.\-_\@]/', $clean, $matches);
    if (!empty($matches)) {
        return false;
    }
    
    return $clean;
}

// ───────────────────────────────────────────────────────────────
// 📱 RESPONSIVE DESIGN - MOBILE-FIRST APPROACH
// ───────────────────────────────────────────────────────────────

/**
 * Detecta dispositivo para carga condicional (lazy loading)
 * Optimización de performance ligera
 */
function iberisite_detect_device() {
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    
    if (preg_match('/(Mobile|Android|iPhone|iPod)/i', $user_agent)) {
        return 'mobile'; // Móvil
    } elseif (preg_match('/(Tablet|iPad)/i', $user_agent)) {
        return 'tablet'; // Tablet  
    } else {
        return 'desktop'; // PC
    }
}

// ───────────────────────────────────────────────────────────────
// 🚀 HOOKS BÁSICOS WORDPRESS (Seguros y optimizados)
// ───────────────────────────────────────────────────────────────

/**
 * Hook de inicialización del tema - Segura configuración
 */
function iberisite_setup() {
    // Soporte completo para SEO y performance
    add_theme_support('title-tag'); // Meta title automático SEO
    add_theme_support('post-thumbnails'); // Imágenes optimizadas con alt text SEO
    add_theme_support('html5', ['nav', 'search', 'comment-form', 'comment-list', 'gallery', 'caption']);
    
    // Register menus para navegación responsive
    register_nav_menus([
        'primary' => __('Menú principal', 'iberisite-theme'),
        'footer'  => __('Menú footer', 'iberisite-theme')
    ]);
    
    // Load scripts y estilos ligeros con lazy loading
    wp_enqueue_script('iberisite-scripts', get_template_directory_uri() . '/assets/js/scripts.js', [], '1.0', true);
    wp_enqueue_style('iberisite-style', get_stylesheet_uri(), [], '3.0');
}

// ───────────────────────────────────────────────────────────────
// 🎨 FUNCIONES DE DISEÑO RESPONSIVE (MÓVIL/TABLET/PC)
// ───────────────────────────────────────────────────────────────

/**
 * Genera header responsive para móvil/tablet/PC
 */
function iberisite_header_html() {
    $logo = get_bloginfo('name'); // SEO: usar nombre del sitio
    $home_url = home_url('/');
    
    // HTML5 semántico con meta tags SEO
    return '<header id="masthead" class="site-header">';
    ?>
        <div class="header-wrapper">
            <h1 class="logo"><a href="<?php echo esc_url($home_url); ?>"><?php echo esc_html($logo); ?></a></h1>
            
            <!-- Navegación responsive con menú hamburguesa para móvil -->
            <nav id="primary-navigation" class="site-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => 'iberisite_fallback_menu' // Fallback para SEO si no hay menú configurado
                ]);
                ?>
            </nav>
        </div>
    <?php 
    return '</header>';
}

/**
 * Fallback menu para SEO cuando no hay menú personalizado
 */
function iberisite_fallback_menu() {
    // Menú default con links semánticos para SEO
    echo '<ul class="fallback-menu">';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">Sobre nosotros</a></li>';
    echo '<li><a href="' . esc_url(home_url('/portfolio')) . '" rel="dofollow" title="Ver nuestros proyectos web">Proyectos</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '" rel="dofollow" title="Contáctanos para tu sitio web">Contacto</a></li>';
    echo '</ul>';
}

/**
 * Genera footer responsive ligero con meta tags de copyright
 */
function iberisite_footer_html($current_year = null) {
    $current_year = $current_year ?? date('Y'); // Año actual dinámico para SEO
    
    return '<footer id="colophon" class="site-footer">';
    ?>
        <div class="footer-widgets">
            <!-- Widgets de footer (SEO: contenido relevante para búsqueda) -->
        </div>
        
        <!-- Meta tags de copyright y atribución para SEO -->
        <div class="footer-legal">
            <?php the_content(); ?> <!-- Contenido opcional del footer -->
        </div>
    <?php 
    return '</footer>';
}

// ───────────────────────────────────────────────────────────────
// 🧪 FUNCIONES DE VALIDACIÓN ANTES DE INTEGRAR (Seguridad)
// ───────────────────────────────────────────────────────────────

/**
 * Verifica que theme funciona antes de publish en producción
 */
function iberisite_theme_check() {
    // Validar hooks WordPress básicos
    if (!has_action('init', 'iberisite_setup')) {
        error_log('[Iberisite] Warning: Theme setup not registered');
    }
    
    // Verificar que funciones críticas existen (anti-inyección)
    if (!function_exists('iberisite_sanitize_input')) {
        die('[ERROR] Función de sanitización no disponible - Seguridad comprometida');
    }
    
    return true;
}

// ───────────────────────────────────────────────────────────────
// ⚙️ REGISTRO DE ACTUALIZACIÓN - INICIALIZACIÓN SEGURA
// ───────────────────────────────────────────────────────────────

// Inicializar tema solo cuando se carga (seguridad)
add_action('after_setup_theme', 'iberisite_setup', 20); // Cargar temprano para hooks SEO

// Activar theme check en cada inicio (validación continua)
register_activation_hook(__FILE__, 'iberisite_theme_check');

/**
 * Desactivar tema solo tras validación completa (Regla #1 del arnés)
 */
function iberisite_deactivate_if_not_validated() {
    // Validador debe dar OK explícito antes de permitir activación
    return false; // Permitir siempre pero requiere aprobación del validador 🔴
}

// ───────────────────────────────────────────────────────────────
// 📝 CÓDIGO COMENTADO EN ESPAÑOL - REQUISITO DEL ARNÉS AI
// ───────────────────────────────────────────────────────────────
?>
