<?php get_header(); ?>
<main id="main" class="l-main">
<section class="p-works__archive">
<?php get_template_part( 'template-parts/other-head' ); ?>
    <div class="p-works__contents">
        <div class="l-inner p-works__inner">
            <?php get_template_part( 'template-parts/works-category' ); ?>
            <div class="c-works__items">
                <?php
                if(have_posts()):
                while(have_posts()):the_post();
                ?>
                <a href="<?php the_permalink();?>" class="c-work__item">
                        <div class="c-work__item--img">
                            <?php the_post_thumbnail()?>
                        </div>
                        <div class="c-work__item--tags">
                            <ul>
                            <?php
                                $terms = get_the_terms( get_the_ID(), 'works-category' ); // 'event_taxonomy'には実際に使用しているタクソノミーの名前を入れてください。
                                    if ( $terms && ! is_wp_error( $terms ) ) {
                                    $exclude_terms = array(''); // 除外したいタームのスラッグをここに追加します。
                                    $term_list = '';
                                    foreach ( $terms as $term ) {
                                        if ( !in_array( $term->slug, $exclude_terms ) ) { // スラッグが除外リストになければタームを追加します。
                                        $term_list .= '<li>' . esc_html( $term->name ) . '</li> ';
                                        }
                                    }
                                    echo $term_list;
                                    }
                                ?>
                            </ul>
                        </div> <p class="c-work__item--ttl "><?php the_title();?></p>
                    </a>
            <?php endwhile;?>
            <?php else:?>
                <p>現在投稿がありません</p>
            <?php endif;?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>