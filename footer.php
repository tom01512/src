    <footer id="footer" class="l-footer">
        <div class="p-footer">
            <div class="p-footer__contact">
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                    <h2>CONTACT</h2>
                </a>
            </div>
            <div class="p-footer__bottom">
                <a href="https://x.com/tom_web0512" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-square-x-twitter"></i>
                </a>
            </div>
        </div>
    </footer>
    <!-- JS -->



    <script>
    if (window.innerWidth <= 767) {
        document.write('<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"><\/script>');
    } else {
        document.write('<script src="https://unpkg.com/swiper/swiper-bundle.min.js"><\/script>');
    }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script><!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script><!-- ScrollTrigger -->
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.37/bundled/lenis.min.js"></script><!-- Lenis -->
    <script src="https://kit.fontawesome.com/5c48a9a0fb.js" crossorigin="anonymous"></script><!-- fontawsome -->
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/script.js"></script>
    <?php wp_footer(); ?>
</body>
</html>