<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section
 *
 * @link     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php
        wp_body_open();
        ?>
        <div class="test">
            <header class="header">
                <div class="user-title">
                    <div class="container">
                        <?php
                        if ( is_user_logged_in() ) :
                            $user = wp_get_current_user();
                            $test_user_name = $user->display_name;
                            echo '<p>';
                            echo esc_html__( 'Hi', 'test' ) . ', '  . esc_html( $test_user_name );
                            echo '</p>';
                            echo '<a href="' . wp_logout_url( esc_url( home_url('/') ) ) . '" class="footer-login__status">' . esc_html__( 'Logout', 'test' ) . '</a>';
                        endif;
                        ?>
                    </div>
                </div>
                <nav class="navbar navbar-default">
                  <div class="container">
                    <?php if ( function_exists( 'wp_nav_menu' ) && has_nav_menu( 'primary_nav' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'primary_nav',
                            'container' => 'ul',
                            'menu_class' => 'nav nav-pills nav-justified',
                            'depth' => 1
                        ) );
                    } ?>
                  </div>
                </nav>
            </header>
