<?php get_header(); ?>
<div id="banner">
    <div class="container">
        <div class="row">
            <div class="col-6 col-12-medium">

                <!-- Banner Copy -->
                <p><?php the_field('main-text'); ?></p>
                <a href="#" class="button-large">Go on, click me!</a>

            </div>
            <div class="col-6 col-12-medium imp-medium">

                <!-- Banner Image -->
                <a href="#" class="bordered-feature-image">
                    <img src="<?php the_field('main-image'); ?>" alt=""/></a>

            </div>
        </div>
    </div>
</div>

</section>

<!-- Features -->
<section id="features">
    <div class="container">
        <div class="row">
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => -1,
                'category_name' => 'main-posts',
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
                    ?>
                    <!-- Feature #1 -->
                    <div class="col-3 col-6-medium col-12-small">
                        <section>
                            <a href="#" class="bordered-feature-image"><img
                                        src="<?php the_post_thumbnail_url(
                                            array(262, 110)//размер фото
                                        ); ?>" alt=""/></a>
                            <h2><?php the_title(); ?></h2>
                            <?php echo get_the_content(); ?>
                        </section>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </div>
    </div>
</section>

<!-- Content -->
<section id="content">
    <div class="container">
        <div class="row aln-center">
            <?php
            global $post;
            $myposts = get_posts([
                'numberposts' => -1,
                'category_name' => 'main-posts-Who We Are',
            ]);
            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
                    ?>
                    <div class="col-4 col-12-medium">
                        <!-- Box #1 -->
                        <section>
                            <header>
                                <h2><?php the_title(); ?></h2>
                            </header>
                            <a href="#" class="feature-image"><img src="<?php the_post_thumbnail_url(
                                    array(324, 126)//размер фото
                                ); ?>" alt=""/></a>
                            <?php echo get_the_content(); ?>
                        </section>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
            <?php
            global $post;
            $myposts = get_posts([
                'numberposts' => -1,
                'category_name' => 'main-posts-Who We Do',
            ]);
            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
                    ?>
                    <div class="col-4 col-6-medium col-12-small">

                        <!-- Box #2 -->
                        <section>
                            <header>
                                <h2><?php the_title(); ?></h2>
                            </header>
                            <ul class="check-list">
                                <?php the_content(); ?>
                            </ul>
                        </section>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
            <?php
            global $post;
            $myposts = get_posts([
                'numberposts' => -1,
                'category_name' => 'main-posts-What People Are Saying',

            ]);
            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
                    ?>
                    <div class="col-4 col-6-medium col-12-small">

                        <!-- Box #3 -->
                        <section>
                            <header>
                                <h2><?php the_title(); ?></h2>
                                <h3><?php the_content(); ?></h3>
                            </header>
                            <ul class="quote-list">
                                <?php
                                global $post;
                                $myposts = get_posts([
                                    'numberposts' => -1,
                                    'category_name' => 'People-messages',

                                ]);
                                if ($myposts) {
                                    foreach ($myposts as $post) {
                                        setup_postdata($post);
                                        ?>
                                        <li>
                                            <img src="<?php the_post_thumbnail_url(
                                                array(324, 126)//размер фото
                                            ); ?>" alt=""/>
                                            <?php the_content(); ?>
                                        </li>
                                        <?php
                                    }
                                }
                                wp_reset_postdata(); // Сбрасываем $post
                                ?>
                            </ul>
                        </section>

                    </div>
                    <?php
                }
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
