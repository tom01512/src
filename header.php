<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no" />
    <!--  FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/zdw4akt.css">
    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/ress@4.0.0/dist/ress.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
    <?php wp_head(); ?>
</head>
<body>
    <svg class="p-header__overlay" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path id="overlayPath" class="overlayPath" vector-effect="non-scaling-stroke" d="M 0 100 V 100 Q 50 100 100 100 V 100 z" />
    </svg>
    <div class="p-header__drawer js-drawer">
        <button id="toggle" class="p-header__hamburger" type="button" aria-label="メニューを開く" aria-controls="nav" aria-expanded="false"></button>
        <nav id="nav" class="p-header__drawerNav" aria-hidden="true">
            <ul id="menu" class="p-header__drawerMenu">
                <li><a class="js-drawerButton p-drawerButton" href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
                <li><a class="js-drawerButton p-drawerButton" href="<?php echo esc_url( home_url( '/works' ) ); ?>">WORKS</a></li>
                <li><a class="js-drawerButton p-drawerButton" href="<?php echo esc_url( home_url( '/' ) ); ?>#service">SERVICE</a></li>
                <li><a class="js-drawerButton p-drawerButton" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">CONTACT</a></li>
                <li><a class="js-drawerButton p-drawerButton" href="https://x.com/tom_web0512" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-square-x-twitter"></i></a></li>
            </ul>
        </nav>
    </div>
    <header class="header l-header">
        <div class="p-header__inner">
            <?php if ( is_front_page() ) : ?>
            <div class="p-header__occupation js-headerOccupation">
                フリーランスのWEBコーダー
            </div>
            <?php else : ?>

            <div class="p-header__occupation p-header__occupation--sub">
                <a class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <h1>TOM'S<br>PORTFOLIO</h1>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </header>