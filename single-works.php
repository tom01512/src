<?php get_header(); ?>
<main id="main" class="l-main">
<?php get_template_part( 'template-parts/other-head' ); ?>
    <div class="p-work__single">
        <div class="p-work__single--fv">
            <h1>
                <?php $value = get_post_meta($post->ID, 'work_img_fv', true);?>
                <?php if(empty($value)):?>
                <?php else: ?>
                    <img src="<?php the_field('work_img_fv'); ?>" loading="lazy"  alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
            </h1>
        </div>
        <div class="p-work__single--head">
            <div class="p-work__single--title">
                <h2><?php the_title();?></h2>
            </div>
            <div class="p-work__single--tag">
                <ul>
                    <?php
                        $terms = get_the_terms( get_the_ID(), 'works-category' ); // 'event_taxonomy'には実際に使用しているタクソノミーの名前を入れてください。
                            if ( $terms && ! is_wp_error( $terms ) ) {
                            $exclude_terms = array(''); // 除外したいタームのスラッグをここに追加します。
                            $term_list = '';
                            foreach ( $terms as $term ) {
                                if ( !in_array( $term->slug, $exclude_terms ) ) { // スラッグが除外リストになければタームを追加します。
                                $term_list .= '<li><a class="" href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li> ';
                                }
                        }
                        echo $term_list;
                        }
                    ?>
                </ul>
            </div>

            <div class="p-work__single--body">
                <div class="swiper p-single__work--swiper  js-singleWorkSwiper">
                    <div class="swiper-wrapper">
                        <?php $value = get_post_meta($post->ID, 'work_img01', true);?>
                                    <?php if(empty($value)):?>
                        <?php else: ?>
                            <div class="swiper-slide"><div><img src="<?php the_field('work_img01'); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>"></div></div>
                        <?php endif; ?>

                        <?php $value = get_post_meta($post->ID, 'work_img02', true);?>
                                    <?php if(empty($value)):?>
                        <?php else: ?>
                            <div class="swiper-slide"><div><img src="<?php the_field('work_img02'); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>"></div></div>
                        <?php endif; ?>

                        <?php $value = get_post_meta($post->ID, 'work_img03', true);?>
                                    <?php if(empty($value)):?>
                        <?php else: ?>
                            <div class="swiper-slide"><div><img src="<?php the_field('work_img03'); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>"></div></div>
                        <?php endif; ?>

                        <?php $value = get_post_meta($post->ID, 'work_img04', true);?>
                                    <?php if(empty($value)):?>
                        <?php else: ?>
                            <div class="swiper-slide"><div><img src="<?php the_field('work_img04'); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>"></div></div>
                        <?php endif; ?>

                        <?php $value = get_post_meta($post->ID, 'work_img05', true);?>
                                    <?php if(empty($value)):?>
                        <?php else: ?>
                            <div class="swiper-slide"><div><img src="<?php the_field('work_img05'); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>"></div></div>
                        <?php endif; ?>
                    </div>
                    <!-- 前後の矢印 -->
                    <div class="swiper-button-prev"><span></span></div>
                    <div class="swiper-button-next"><span></span></div>
                    <!-- スクロールバー -->
                    <div class="swiper-scrollbar"></div>
                </div>

                <div class="p-work__single--text">
                    <div class="p-work__single--list ">
                        <ul>
                            <li>
                                <p class="p-work__single--listTtl">CLIENT</p>
                                <p class="p-work__single--listText"><?php the_field('client'); ?></p>
                            </li>
                            <li>
                                <p class="p-work__single--listTtl">LINK</p>
                                <p class="p-work__single--listText">
                                <?php
                                    $link = get_field('link');
                                    if( $link ):
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="p-works-datalist-link"  href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                    <?php endif; ?>
                                </p>
                            </li>
                            <li>
                                <p class="p-work__single--listTtl">担当範囲</p>
                                <p class="p-work__single--listText"><?php the_field('pic'); ?></p>
                            </li>
                            <li>
                                <p class="p-work__single--listTtl">制作期間(目安)</p>
                                <p class="p-work__single--listText"><?php the_field('period'); ?></p>
                            </li>
                            <li>
                                <p class="p-work__single--listTtl">制作費用(目安)</p>
                                <p class="p-work__single--listText"><?php the_field('price'); ?></p>
                            </li>
                            <li>
                                <p class="p-work__single--listTtl">DESCRIPTION</p>
                                <div class="p-work__single--listTextarea"><?php the_content(); ?></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="c-more__btn">
                    <a href="<?php echo esc_url( home_url( '/works' ) ); ?>" class="c-more__btn--link">
                        <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/common/more-arrow.png" alt="制作実績一覧を見る"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>