<div class="p-works__category">
    <?php
    // 現在表示中のタクソノミータームを取得
    $current_term = get_queried_object();

    // 'works-category' の全タームを取得
    $terms = get_terms('works-category');

    // 現在表示中のタームでない場合のみ表示
    if ( $terms && ! is_wp_error( $terms ) ) {
        echo '<h3>CATEGORY</h3>';
        echo '<ul>';

        // archive-works.php ではない場合のみ "ALL" を表示
        if ( ! is_post_type_archive('works') ) {
            echo '<li><a href="' . esc_url( home_url( '/works' ) ) . '">' . "ALL" . '</a></li>';
        }

        foreach ( $terms as $term ) {
            if ( isset($current_term->term_id) && $term->term_id == $current_term->term_id ) {
                continue; // 現在のタームはスキップ
            }
            echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
        }
        echo '</ul>';
    }
    ?>

</div>