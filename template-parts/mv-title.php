<?php if ( is_front_page() ) : ?>
<div class="p-mv__title js-mvTitle">
<?php else : ?>
<div class="p-mv__title p-mv__title--sub js-mv__title ">
<?php endif; ?>
<div class="p-header__occupation p-header__occupation--sub">
    <div class="p-mv__title--container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
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
</div>