<section>
    <?php if ( is_active_sidebar( 'contacts_first_side' ) ) : ?>
        <ul class="link-list"><?php dynamic_sidebar( 'contacts_first_side' ); ?></ul>
    <?php endif; ?>
                </section>
                <section>
                    <?php if ( is_active_sidebar( 'contacts_second_side' ) ) : ?>
                        <ul class="link-list"><?php dynamic_sidebar( 'contacts_second_side' ); ?></ul>
                    <?php endif; ?>
                </section>
