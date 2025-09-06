<?php get_header();?>

    <main id="main" class="l-main">
        <section id="mv" class="l-mv js-mv">
            <div class="l-mv__inner">
                <div class="p-mv__title js-mv__title">
                    <div class="p-mv__title--container">
                        <a href="">
                            <h1 class="c-word">
                                <span class="c-word__rect"></span>
                                <span class="c-word__text">TOM'S</span>
                            </h1><br>
                            <h1 class="c-word">
                                <span class="c-word__rect"></span>
                                <span class="c-word__text">PORTFOLIO</span>
                            </h1>
                        </a>
                    </div>
                </div>
                <div class="p-mv__images p-mv__images--md">
                    <div class="p-mv__images--grid">
                        <div class="p-mv__image p-mv__image01"><a href="https://toms-portfolio.com/works/works01/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product-image/product-image01.png" alt="自動車販売会社　コーポレートサイト" fetchpriority="high"></a></div>
                        <div class="p-mv__image p-mv__image02"><a href="https://toms-portfolio.com/works/works05/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product-image/product-image02.png" alt="リクルートサイト" fetchpriority="high"></a></div>
                        <div class="p-mv__image p-mv__image03"><a href="https://toms-portfolio.com/works/works02/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product-image/product-image03.png" alt="美容クリニック　コーポレートサイト" fetchpriority="high"></a></div>
                        <div class="p-mv__image p-mv__image04"><a href="https://toms-portfolio.com/works/works06/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product-image/product-image04.png" alt="映像制作会社　コーポレートサイト" fetchpriority="high"></a></div>
                        <div class="p-mv__image p-mv__image05"><a href="https://toms-portfolio.com/works/works04/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product-image/product-image05.png" alt=" 法律事務所　コーポレートサイト" fetchpriority="high"></a></div>
                    </div>
                </div>

                <div class="p-mv__images p-mv__images--sm">
                    <div class="p-mv__images--wrap">
                        <?php
                            $args = array(
                                'post_type' => 'works',
                                'post__in' => array(317, 349, 262),
                                'orderby' => 'post__in', // 指定した順に出力
                            );

                            $the_query = new WP_Query($args);
                            if ($the_query->have_posts()) :
                                $index = 1; // クラス名用のカウント
                                while ($the_query->have_posts()) : $the_query->the_post();
                                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $permalink = get_permalink();
                                    // クラス名を2桁にする（例：01, 02, 03）
                                    $class_suffix = str_pad($index, 2, '0', STR_PAD_LEFT);//str_pad(文字列, 最終的な長さ, 埋める文字, 埋める方向)
                            ?>
                            <div class="p-mv__image p-mv__image<?php echo $class_suffix; ?>">
                                <a href="<?php echo esc_url($permalink); ?>" class="js-parallax">
                                    <img src="<?php echo esc_url($image_url); ?>" fetchpriority="high" alt="<?php the_title_attribute(); ?>">
                                </a>
                            </div>
                                <?php
                                $index++;
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section id="about" class="l-about">
            <div class="p-about">
                <div class="p-about__ttl">
                    <h2 class="p-about__ttlItem p-about__ttlItem--top">YOUR WEB TEAM</h2><br>
                    <h2 class="p-about__ttlItem p-about__ttlItem--bottom">REPRESENTATIVE</h2>
                </div>
                <div class="p-about__text">
                    あなたのチームのWEB制作担当として全力で課題解決に向けてサポートさせていただきます。
                </div>
            </div>
        </section>
        <section id="work" class="l-work">
            <div class="p-work__header">
                    <div class="p-work__ttl c-section__ttl">
                        <h2>WORK</h2>
                    </div>
                    <div class="p-work__text">
                        <a class="p-work__text--link" href="<?php echo esc_url( home_url( '/works' ) ); ?>"><span>ALL</span></a>
                        <?php
                        $terms = get_terms('works-category');
                        foreach ( $terms as $term ) {
                        echo'<a class="p-work__text--link" href="'.get_term_link($term).'"><span>'.strtoupper($term->name).'</span></a>';
                    }
                    ?>
                    </div>
                </div>
                <div class="p-work__swiper p-work__swiper--pc">
                    <div class="swiper js-frontWorkSwiper">
                        <div class="swiper-wrapper">
                            <?php
                            $args = array(
                                'post_type' => 'works',
                                'post__in' => array(317, 349, 262),
                                'orderby' => 'post__in', // 指定した順に出力
                            );

                            $the_query = new WP_Query($args);
                            if ($the_query->have_posts()) :
                                while ($the_query->have_posts()) : $the_query->the_post();
                                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    $permalink = get_permalink();
                            ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo esc_url($permalink); ?>">
                                            <img src="<?php echo esc_url($image_url); ?>" loading="lazy" alt="<?php the_title_attribute(); ?>">
                                        </a>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="u-work__btn c-more__btn c-more__btn--works">
                    <a href="<?php echo esc_url( home_url( '/works' ) ); ?>" class="c-more__btn--link">
                        <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/common/more-arrow.png" alt="制作実績一覧を見る"></span>
                    </a>
                </div>
        </section>
        <section id="service" class="l-service">
            <div class="p-service">
                <div class="p-service__header">
                    <div class="p-service__ttl c-section__ttl">
                        <h2>SERVICE</h2>
                    </div>
                </div>
                <div class="p-service__body">
                    <div class="p-service__items">
                        <div class="js-serviceItemSticky">
                            <div id="service--code" class="c-service__item c-service__item--coding">
                                <h3>CORDING</h3>
                                <div class="c-service__item--icons">
                                    <div class="c-service__icon c-service__icon--html">HTML</div>
                                    <div class="c-service__icon c-service__icon--css">CSS</div>
                                    <div class="c-service__icon c-service__icon--js">JS</div>
                                </div>
                                <div class="c-service__item--text">
                                HTML / CSS / JavaScript をベースに、洗練されたフロントエンドを構築。
    デザインカンプの忠実な再現はもちろん、アニメーションやインタラクションを取り入れることで、ユーザー体験を高めるモダンなUIをご提案します。
    視覚的な美しさと操作性の両立を重視し、あらゆるデバイスで快適に閲覧できるレスポンシブな設計にも対応しています。
                                </div>
                            </div>
                        </div>
                        <div class="js-serviceItemSticky">
                            <div class="c-service__item c-service__item--wp">
                                <h3>SYSTEM</h3>
                                <div class="c-service__item--icons">
                                    <div class="c-service__icon c-service__icon--php">PHP</div>
                                    <div class="c-service__icon c-service__icon--wp">WP</div>
                                    <div class="c-service__icon c-service__icon--laravel">LARAVEL</div>
                                </div>
                                <div class="c-service__item--text">
                                    PHPをベースに、WORDPRESSなどを使って、更新しやすく運用性に優れたWebサイトを構築します。
ニュース記事やブログ投稿などの情報発信機能、お問い合わせページの設置に対応。
オリジナルのテーマ制作により、独自のデザインや要件にも柔軟にお応え可能です。
クライアント様の目的に合わせた機能追加も承ります。
                                </div>
                            </div>
                        </div>
                        <div class="js-serviceItemSticky">
                            <div class="c-service__item c-service__item--ec">
                                <h3>EC SITE</h3>
                                <div class="c-service__item--icons">
                                    <div class="c-service__icon c-service__icon--ec">SHOPIFY</div>
                                </div>
                                <div class="c-service__item--text">
                                Shopifyの機能性を最大限に活かし、ユーザー体験に優れたECサイトを設計・構築いたします。
テーマカスタマイズやアプリ連携による機能拡張、売上向上を意識した導線設計にも対応。
スモールスタートから本格運用まで、フェーズに合わせた柔軟なご提案が可能です。
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php get_footer();?>