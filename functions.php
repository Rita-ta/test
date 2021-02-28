<?php

add_action( 'after_setup_theme', 'test_setup' );

if ( ! function_exists( 'test_setup' ) ) :

function test_setup() {

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style( 'assets/css/editor-style.css' );

    //Loading theme textdomain
    load_theme_textdomain( 'test', get_template_directory() . '/languages' );

    // This theme uses post thumbnails
    add_theme_support( 'post-thumbnails' );

    add_image_size( 'test-post-thumb', 1140, 540, true );

    // support title-tag for Wordpress 4.1+
    add_theme_support( 'title-tag' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // custom menu support
    if ( function_exists( 'register_nav_menus' ) ) {
        register_nav_menus( array ( 'primary_nav' => esc_html__( 'Primary Navigation', 'test' ) ) );
    }

    // Set content-width.
    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 1140;
    }

}
endif;// test_setup

add_action( 'wp_enqueue_scripts', 'test_load_styles_scripts' );

if ( ! function_exists( 'test_load_styles_scripts' ) ) :

    function test_load_styles_scripts() {

        $theme_version = wp_get_theme()->get( 'Version' );

        wp_enqueue_style( 'test-style', get_stylesheet_uri(), array(), $theme_version );

        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '3.4.1', 'screen, all' );
        wp_enqueue_style( 'test-main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version, 'screen, all' );

        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ) , NULL, true );
        wp_enqueue_script( 'test-custom', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ) , $theme_version, true );

        wp_localize_script( 'test-custom', 'testAjax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
    }

endif;

if ( ! function_exists( 'test_special_nav_class' ) ) :
    function test_special_nav_class( $classes, $item ) {
         if( in_array( 'current-menu-item', $classes ) ) {
                 $classes[] = 'active ';
         }
         return $classes;
    }
endif;
add_filter( 'nav_menu_css_class' , 'test_special_nav_class' , 10 , 2 );

if ( ! function_exists( 'test_get_post_terms' ) ) :
    function test_get_post_terms( $args = array() ) {

        $html = '';

        $defaults = array(
            'post_id'    => get_the_ID(),
            'taxonomy'   => 'category',
            'text'       => '%s',
            'before'     => '',
            'after'      => '',
            'items_wrap' => '%s',
            'sep'        => ', ',
        );

        $args = wp_parse_args( $args, $defaults );

        $terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

        if ( !empty( $terms ) ) {
            $html .= $args['before'];
            $html .= sprintf( $args['items_wrap'], sprintf( $args['text'], $terms ) );
            $html .= $args['after'];
        }

        return $html;
    }
endif;

add_action( 'add_meta_boxes', 'test_custom_fields_init' );
function test_custom_fields_init() {
        add_meta_box( 'test_post_target', esc_html__( 'Custom fields', 'test' ), 'test_post_target', array( 'post' ), 'side', 'low' );
    }

function test_post_target() {

    $selected_target  = get_post_meta( get_the_ID(), 'test_post_target', true ) == "" ? '' : get_post_meta( get_the_ID(), 'test_post_target', true );
    ?>

    <p><strong><?php echo esc_html__( 'Target audience', 'test' ); ?></strong></p>

    <select name="test_post_target" id="test_post_target">
        <option value="" <?php if ( '' === $selected_target ): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Select', 'test' ); ?></option>
        <option value="man" <?php if ( 'man' === $selected_target ): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Man', 'test' ); ?></option>
        <option value="woman" <?php if ( 'woman' === $selected_target ): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Woman', 'test' ); ?></option>
        <option value="children" <?php if ( 'children' === $selected_target ): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Сhildren', 'test' ); ?></option>
    </select>

<?php }

add_action( 'save_post', 'test_save_post_fields' );
function test_save_post_fields( $post_id ) {
    if ( ! empty( $_POST['extra_fields_nonce'] ) && ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ ) ) return false;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE  ) return false;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return false;

    if ( isset( $_POST['test_post_target'] ) ) {
        if ( get_post_meta( $post_id, 'test_post_target') == "" )
            add_post_meta( $post_id, 'test_post_target', $_POST['test_post_target'], true );
        else
            update_post_meta( $post_id, 'test_post_target', $_POST['test_post_target'] );
    }

}


add_action( 'wp_ajax_add_posts', 'test_add_posts' );
add_action( 'wp_ajax_nopriv_add_posts', 'test_add_posts' );
function test_add_posts() {

    $current_term_id = ( ! empty( $_POST['termid'] ) ) ? esc_attr( $_POST['termid'] ) : 'all';
    $current_target = ( ! empty( $_POST['target'] ) ) ? esc_attr( $_POST['target'] ) : 'all';
    $current_sort= ( ! empty( $_POST['sort'] ) ) ? esc_attr( $_POST['sort'] ) : 'default';

    if ( 'all' === $current_term_id ) :

        $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );

    else :

        $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'id',
                        'terms'    => $current_term_id,
                        'meta_query' => array(
                            array(
                                'key' => 'test_post_target',
                                'value' => $current_target
                            )
                        )
                    )
                )
            );

    endif;

    if ( $current_target != 'all' ) :
        $args['meta_query'] = array(
                array(
                    'key' => 'test_post_target',
                    'value' => $current_target
                )
            );
    endif;

    if ( $current_sort != 'default' ) :
        $args['orderby'] = 'title';
        $args['order'] = $current_sort;
    endif;

    $post_query = new WP_Query( $args );

    if ( $post_query->have_posts() ) :

        while ( $post_query->have_posts() ) :
            $post_query->the_post();

            get_template_part( 'template-parts/post/content' );

        endwhile;

    endif;

    wp_reset_postdata();

    wp_die();
}

function test_get_url_by_template( $template ) {

    $pages = get_pages( array(
        'meta_key'  => '_wp_page_template',
        'meta_value'=> $template,
        'posts_per_page' => 1
    ));


    $url = false;
    if ( isset( $pages[0] ) ) {
        $url = get_page_link( $pages[0]->ID );
    }
    return esc_url( $url );
}

add_action( 'template_redirect', 'test_template_redirect' );
function test_template_redirect() {
    if ( is_home() && ! is_user_logged_in() ) {
        $redirect_url = test_get_url_by_template( 'template-login.php' );
        if ( $redirect_url ) {
            wp_redirect( esc_url( $redirect_url ) );
        }
        exit;
    }
}
