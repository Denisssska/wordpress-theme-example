<!DOCTYPE HTML>
<html>
<head>
    <title>Halcyonic by HTML5 UP</title>
    <!--    подключили кодировку для вордпреса-->
    <meta charset="<?php bloginfo(); ?>">
    <?php wp_head();?>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
</head>
<body>
<div id="page-wrapper">

    <!-- Header -->
    <section id="header">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <!-- Logo -->
                    <h1>
                        <a href="/" id="logo">ELKIN-LES</a>
<!--                        --><?php
//                        if (has_custom_logo()) {
//                            echo get_custom_logo();
//                        }
//                        ?>
                    </h1>

                    <!-- Nav -->

                    <nav id="nav">
                        <?php wp_nav_menu([
                            'theme_location' => 'header_menu',
                            'container' => false,
                            'menu_class' => 'navbar-nav',
                            'menu_id' => false,
                            'echo' => true,
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        ]); ?>
                    </nav>

                </div>
            </div>
        </div>
