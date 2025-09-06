<?php

//アーカイブタイトル
function my_archive_title($title)
{

  if (is_category()) { // カテゴリーアーカイブの場合
    $title = single_cat_title('', false);
  } elseif (is_tag()) { // タグアーカイブの場合
    $title = single_tag_title('', false);
  } elseif (is_post_type_archive()) { // 投稿タイプのアーカイブの場合
    $title = post_type_archive_title('', false);
  } elseif (is_tax()) { // タームアーカイブの場合
    $title = single_term_title('', false);
  } elseif (is_author()) { // 作者アーカイブの場合
    $title = get_the_author();
  } elseif (is_date()) { // 日付アーカイブの場合
    $title = '';
    if (get_query_var('year')) {
        $title .= get_query_var('year') . '年';
    }
    if (get_query_var('monthnum')) {
        $title .= get_query_var('monthnum') . '月';
    }
    if (get_query_var('day')) {
        $title .= get_query_var('day') . '日';
    }
}
return $title;
};
add_filter('get_the_archive_title', 'my_archive_title');


//CSSとJSを自動CACHE

function my_enqueue_assets() {
  // CSS
  wp_enqueue_style(
    'my-style',
    get_template_directory_uri() . '/assets/css/style.css',
    [],
    filemtime(get_template_directory() . '/assets/css/style.css')
  );

  // JS
  wp_enqueue_script(
    'my-script',
    get_template_directory_uri() . '/assets/js/script.js',
    [],
    filemtime(get_template_directory() . '/assets/js/script.js'),
    true // フッター読み込み
  );
}
add_action('wp_enqueue_scripts', 'my_enqueue_assets');


//存在しないページはトップページ
function redirect_404_to_home() {
  if ( is_404() ) {
    wp_redirect( home_url(), 301 );
    exit;
  }
}
add_action( 'template_redirect', 'redirect_404_to_home' );


//リキャプチャロゴをコンタクトフォームの場所のみ表示
function custom_load_recaptcha_only_on_contact() {
  // 固定ページ「contact」のスラッグに合わせて条件分岐
  if (is_page('contact')) {
    // reCAPTCHA スクリプトが自動で読み込まれるのを許可
    return true;
  }

  // それ以外のページでは無効化
  wp_deregister_script('google-recaptcha');
}
add_action('wp_enqueue_scripts', 'custom_load_recaptcha_only_on_contact', 20);

// defer属性を付与する例
function add_defer_to_scripts($tag, $handle, $src) {
  if (!is_admin() && $handle === 'my-script-handle') {
    return '<script src="' . $src . '" defer></script>';
  }
  return $tag;
}
add_filter('script_loader_tag', 'add_defer_to_scripts', 10, 3);


//font-display: swap
function custom_enqueue_fonts() {
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap', false);
}
add_action('wp_enqueue_scripts', 'custom_enqueue_fonts');