<?php
/**
 * Plugin Name: Serfer Utilidades - CARASIR
 * Description: Funciones personalizadas para el blog CARASIR: caja de contacto, año dinámico, ocultación de versión y acceso personalizado.
 * Version: 1.1.0
 * Author: Sergio Ferreira Ruiz
 * Text Domain: serfer-utilidades
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Añadir una caja de contacto al final de cada entrada.
 */
function serfer_anadir_caja_contacto( $contenido ) {

    if (
        ! is_singular( 'post' ) ||
        ! is_main_query() ||
        ! in_the_loop() ||
        is_admin()
    ) {
        return $contenido;
    }

    $pagina_contacto = get_page_by_path( 'contacto' );

    if ( $pagina_contacto ) {
        $url_contacto = get_permalink( $pagina_contacto );
    } else {
        $url_contacto = home_url( '/contacto/' );
    }

    $caja = '<div class="serfer-caja-contacto">';
    $caja .= '<p>¿Te ha gustado? Escríbeme desde ';
    $caja .= '<a href="' . esc_url( $url_contacto ) . '">';
    $caja .= 'Contacto</a></p>';
    $caja .= '</div>';

    return $contenido . $caja;
}

add_filter(
    'the_content',
    'serfer_anadir_caja_contacto'
);

/**
 * Shortcode [anio]: devuelve el año actual.
 */
function serfer_mostrar_anio() {

    return esc_html( wp_date( 'Y' ) );

}

add_shortcode(
    'anio',
    'serfer_mostrar_anio'
);

/**
 * Eliminar la etiqueta generator del HTML.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Hacer que el logotipo enlace a la portada.
 */
function serfer_login_logo_url( $url ) {

    return home_url( '/' );

}

add_filter(
    'login_headerurl',
    'serfer_login_logo_url'
);


/**
 * Personalizar el texto accesible del logotipo.
 */
function serfer_login_logo_texto( $texto ) {

    return 'Ir a la portada de CARASIR';

}

add_filter(
    'login_headertext',
    'serfer_login_logo_texto'
);


/**
 * Mostrar un aviso sobre el formulario de acceso.
 */
function serfer_login_aviso( $mensaje ) {

    $aviso = '<div class="message" role="status">';
    $aviso .= '<p>';
    $aviso .= esc_html(
        'Acceso restringido al equipo de CARASIR'
    );
    $aviso .= '</p>';
    $aviso .= '</div>';

    return $mensaje . $aviso;
}

add_filter(
    'login_message',
    'serfer_login_aviso'
);
