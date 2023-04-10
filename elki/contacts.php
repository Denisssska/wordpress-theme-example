<?php get_header(); ?>
<?php
/*
Template Name: шаблон страницы contacts
Template Post Type: page
*/
?>
</section>
<!-- Content -->
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-3 col-12-medium">
                <?php get_sidebar(); ?>
            </div>
            <div class="col-9 col-12-medium imp-medium">

                <!-- Main Content -->
                <section>
                    <header>
                        <h2><?php the_field('contacts-main-title'); ?></h2>
                        <h3><?php the_field('contacts-main-second-title'); ?></h3>
                    </header>
                    <p>
                        <?php the_field('contacts-main-description'); ?>
                    </p>
                    <p>
                        <?php the_field('contacts-main-description'); ?>
                    </p>
                    <p>
                        <?php the_field('contacts-main-description'); ?>
                    </p>
                    <p>
                        <?php the_field('contacts-main-description'); ?>
                    </p>

                </section>

            </div>
        </div>
    </div>
</section>

<?php get_footer() ?>

