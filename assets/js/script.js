/* ==========================================================================
   App JS (safe, idempotent, WP/Autoptimize向け)
   - 再宣言防止: IIFE + window 名前空間
   - ライブラリ未読込でも落ちないガード
   - リサイズ: デバウンス
   - ドキュメント未配置要素: nullガード
   - ScrollTrigger: 1回だけ登録
   ========================================================================== */
(() => {
  'use strict';

  // -------------------------
  // Utils
  // -------------------------
  const qs  = (s, el = document) => el.querySelector(s);
  const qsa = (s, el = document) => Array.from(el.querySelectorAll(s));
  const on  = (el, ev, fn, opt) => el && el.addEventListener(ev, fn, opt);
  const debounce = (fn, delay = 200) => {
    let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), delay); };
  };
  const supportsTouch = 'ontouchstart' in window;
  const clickTouchEvent = supportsTouch ? 'touchstart' : 'click';

  // 安全に GSAP / ScrollTrigger を取得
  const hasGSAP = typeof window.gsap !== 'undefined';
  const gsap = hasGSAP ? window.gsap : null;
  const hasScrollTrigger = hasGSAP && typeof window.ScrollTrigger !== 'undefined';
  if (hasGSAP && !hasScrollTrigger && typeof window.ScrollTrigger !== 'undefined') {
    // nothing
  }
  if (hasGSAP && typeof window.ScrollTrigger !== 'undefined') {
    // 登録は(ほぼ)冪等
    window.gsap.registerPlugin(window.ScrollTrigger);
  }

  // -------------------------
  // 1) c-more ボタンのマウストラッキング
  // -------------------------
  const initMoreButtonHover = () => {
    on(document, 'DOMContentLoaded', () => {
      const btn = qs('.c-more__btn--link');
      if (!btn) return;
      on(btn, 'mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        btn.style.setProperty('--x', `${x}px`);
        btn.style.setProperty('--y', `${y}px`);
      });
    });
  };

  // -------------------------
  // 2) WORK FRONT SWIPER（可変方向 & 再初期化対応）
  // -------------------------
  const initFrontWorkSwiper = () => {
    if (typeof window.Swiper === 'undefined') return; // Swiper 未読込ならスキップ
    // グローバル1回だけ保持（再宣言防止）
    if (!('frontWorkSwiper' in window)) window.frontWorkSwiper = null;

    const isMobile = window.innerWidth <= 767;

    if (window.frontWorkSwiper && window.frontWorkSwiper.destroy) {
      window.frontWorkSwiper.destroy(true, true);
    }

    const el = qs('.js-frontWorkSwiper');
    if (!el) { window.frontWorkSwiper = null; return; }

    window.frontWorkSwiper = new window.Swiper('.js-frontWorkSwiper', {
      direction: isMobile ? 'horizontal' : 'vertical',
      slidesPerView: isMobile ? 1.5 : 1.6,
      centeredSlides: true,
      slideToClickedSlide: !isMobile,
      spaceBetween: isMobile ? 16 : '2vw',
      loop: false,
      autoHeight: true,
      speed: 1000,
      loopAdditionalSlides: 1,
      mousewheel: !isMobile ? { releaseOnEdges: true, forceToAxis: true, sensitivity: 1 } : false,
      keyboard: { enabled: true },
    });
  };

  // -------------------------
  // 3) WORK SINGLE SWIPER（再実行でもOKに）
  // -------------------------
  const initSingleWorkSwiper = () => {
    if (typeof window.Swiper === 'undefined') return;
    if (!('singleWorkSwiper' in window)) window.singleWorkSwiper = null;

    const el = qs('.js-singleWorkSwiper');
    if (!el) { window.singleWorkSwiper = null; return; }

    // すでに存在するなら一旦破棄
    if (window.singleWorkSwiper && window.singleWorkSwiper.destroy) {
      window.singleWorkSwiper.destroy(true, true);
    }

    window.singleWorkSwiper = new window.Swiper('.js-singleWorkSwiper', {
      loop: true,
      pagination: { el: '.swiper-pagination', clickable: true },
      navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
      scrollbar: { el: '.swiper-scrollbar' },
    });
  };

  // -------------------------
  // 4) ドロワーメニュー（GSAPタイムライン）
  // -------------------------
  const initDrawer = () => {
    if (!hasGSAP) return;

    const CONTENTS = {
      MAIN: qs('#main'),
      FOOTER: qs('#footer')
    };
    const NAV         = qs('#nav');
    const MENU        = qs('#menu');
    const TOGGLE      = qs('#toggle');
    const OVERLAYPATH = qs('#overlayPath');
    if (!NAV || !MENU || !TOGGLE || !OVERLAYPATH) return;

    let isAnimating = false;

    const menuOpen = () => {
      if (isAnimating) return;
      isAnimating = true;
      gsap.timeline({
        onStart: () => {
          NAV.setAttribute('aria-hidden', 'false');
          TOGGLE.setAttribute('aria-label', 'メニューを閉じる');
          gsap.to(TOGGLE, { autoAlpha: 0, scale: 0, duration: 0.1 });
          gsap.set(MENU, { y: -100, autoAlpha: 0 });
        },
        onComplete: () => { isAnimating = false; }
      })
      .set(OVERLAYPATH, { attr: { d: 'M 0 0 V 0 Q 50 0 100 0 V 0 z' } })
      .to(OVERLAYPATH, { attr: { d: 'M 0 0 V 50 Q 50 100 100 50 V 0 z' }, ease: 'power4.in', duration: 0.5 }, 0)
      .to(OVERLAYPATH, { attr: { d: 'M 0 0 V 100 Q 50 100 100 100 V 0 z' }, ease: 'power2', duration: 0.3 })
      .to([CONTENTS.MAIN, CONTENTS.FOOTER], { y: 100, opacity: 0, duration: 0.3, ease: 'power3.in' }, 0.1)
      .set(OVERLAYPATH, { attr: { d: 'M 0 100 V 0 Q 50 0 100 0 V 100 z' } })
      .to(OVERLAYPATH, { attr: { d: 'M 0 100 V 50 Q 50 100 100 50 V 100 z' }, duration: 0.3, ease: 'power2.in' })
      .to(OVERLAYPATH, { attr: { d: 'M 0 100 V 100 Q 50 100 100 100 V 100 z' }, duration: 0.3, ease: 'power4' })
      .to(MENU, {
        y: 0, autoAlpha: 1, duration: 0.5, ease: 'power4',
        onStart: () => {
          TOGGLE.setAttribute('aria-expanded', 'true');
          gsap.to(TOGGLE, { autoAlpha: 1, scale: 1, duration: 0.1 });
        }
      }, '>-=.5');
    };

    const menuClose = () => {
      if (isAnimating) return;
      isAnimating = true;
      gsap.timeline({
        onStart: () => { TOGGLE.setAttribute('aria-label', 'メニューを開く'); },
        onComplete: () => { NAV.setAttribute('aria-hidden', 'true'); isAnimating = false; }
      })
      .set(OVERLAYPATH, { attr: { d: 'M 0 100 V 100 Q 50 100 100 100 V 100 z' } })
      .to(OVERLAYPATH, { duration: 0.5, ease: 'power4.in', attr: { d: 'M 0 100 V 50 Q 50 0 100 50 V 100 z' } }, 0)
      .to(OVERLAYPATH, { duration: 0.3, ease: 'power2', attr: { d: 'M 0 100 V 0 Q 50 0 100 0 V 100 z' } })
      .to(MENU, { duration: 0.5, ease: 'power3.in', y: -100, onStart: () => { gsap.to(TOGGLE, { autoAlpha: 0, duration: 0.1 }); } }, 0.1)
      .set(OVERLAYPATH, { attr: { d: 'M 0 0 V 100 Q 50 100 100 100 V 0 z' } })
      .set(MENU, { opacity: 0 }, '<')
      .to(OVERLAYPATH, { duration: 0.3, ease: 'power2.in', attr: { d: 'M 0 0 V 50 Q 50 0 100 50 V 0 z' } })
      .to(OVERLAYPATH, { duration: 0.3, ease: 'power4', attr: { d: 'M 0 0 V 0 Q 50 0 100 0 V 0 z' } })
      .to([qs('#main'), qs('#footer')], {
        duration: 0.5, ease: 'power4', y: 0, opacity: 1,
        onStart: () => {
          TOGGLE.setAttribute('aria-expanded', 'false');
          gsap.to(TOGGLE, { autoAlpha: 1, duration: 0.1 });
        }
      }, '>-=.4');
    };

    on(TOGGLE, clickTouchEvent, () => {
      (TOGGLE.getAttribute('aria-expanded') === 'true') ? menuClose() : menuOpen();
    });

    // Drawer hover morph（PC）
    const contactButtons = qsa('.js-drawerButton');
    const mm = hasGSAP ? gsap.matchMedia() : null;
    if (mm && contactButtons.length) {
      mm.add('(hover:hover) and (pointer:fine)', () => {
        contactButtons.forEach(($btn) => {
          on($btn, 'mousemove', (e) => {
            const rect = e.currentTarget.getBoundingClientRect();
            const posX = e.clientX - rect.left;
            const interpolatePosX = gsap.utils.interpolate(-rect.height / 2, rect.height / 2, posX / rect.width);
            const calcPercent = rect.height / rect.width * 100;
            gsap.to(e.currentTarget, {
              '--width': `${calcPercent}%`,
              '--translateX': `${posX - rect.height / 2}px`,
              x: interpolatePosX, duration: 0.3, ease: 'sine.out'
            });
          });
          on($btn, 'mouseleave', (e) => {
            gsap.to(e.currentTarget, { '--width': '100%', '--translateX': '0', x: 0, duration: 0.3, ease: 'sine.out' });
          });
        });
      });
    }

    // Drawer内リンクで閉じる
    qsa('#menu a, .js-drawerButton').forEach(link => {
      on(link, clickTouchEvent, () => {
        if (TOGGLE.getAttribute('aria-expanded') === 'true') {
          // menuCloseのisAnimatingフラグに任せる
          const evt = new Event(clickTouchEvent);
          TOGGLE.dispatchEvent(evt);
        }
      });
    });
  };

  // -------------------------
  // 5) MVタイトルのリニア移動 + フォントサイズ変更
  // -------------------------
  const initMvTitle = () => {
    if (!hasGSAP || !hasScrollTrigger) return;
    on(window, 'DOMContentLoaded', () => {
      const container = qs('.p-mv__title--container');
      if (!container) return;

      const rect = container.getBoundingClientRect();
      const currentTop = rect.top + window.scrollY;
      const currentLeft = rect.left + window.scrollX;

      const offsetY = window.innerWidth <= 767 ? 8 - currentTop : 20 - currentTop;
      const offsetX = window.innerWidth <= 767 ? 16 - currentLeft : 32 - currentLeft;

      gsap.to(container, {
        x: offsetX, y: offsetY,
        scrollTrigger: { trigger: '.p-mv__title', start: 'top top', end: 'bottom top', scrub: true }
      });

      gsap.to('.p-mv__title--container h1', {
        fontSize: '14px',
        scrollTrigger: { trigger: '.p-mv__title', start: 'top top', end: 'bottom top', scrub: true }
      });
    });
  };

  // -------------------------
  // 6) MVタイトルの矩形→テキストのリビール
  // -------------------------
const initWordReveal = () => {
  if (!hasGSAP) return;
  on(window, 'DOMContentLoaded', () => {
    const tl = gsap.timeline({ repeat: 0 });

    qsa('.c-word').forEach((word) => {
      const rect = qs('.c-word__rect', word);
      const text = qs('.c-word__text', word);
      if (!rect || !text) return;

      const child = gsap.timeline();
      child.set(rect, { x: '-100%', opacity: 1 });
      child.set(text, { opacity: 0 });
      child.to(rect, { x: '0%', duration: 0.4, ease: 'power2.out' });
      child.to(rect, { x: '105%', opacity: 0, duration: 0.6, ease: 'power2.inOut' });
      child.to(text, { opacity: 1, duration: 0.5, ease: 'power2.out' }, '-=0.4');

      tl.add(child, '-=40%');
    });

    // ★ ここを追加：テキストすべての演出が完了したらフラグ＋イベント発火
    tl.eventCallback('onComplete', () => {
      window.__wordRevealDone = true;
      window.dispatchEvent(new Event('wordReveal:done'));
      // 画像の初期非表示を解除（必要なら）
      gsap.to('.p-mv__image a', { autoAlpha: 1, duration: 0 }); 
    });
  });
};

    // -------------------------
  // 7) MV画像（PC）中央寄せのパララックス寄与
  // -------------------------
const initMvImagesDesktop = () => {
  if (!hasGSAP || !hasScrollTrigger) return;

  const run = () => {
    if (window.innerWidth <= 1045) return;
    const container = qs('.p-mv__images');
    if (!container) return;

    // 中央は /2 で算出
    const getContainerCenter = () => {
      const r = container.getBoundingClientRect();
      return { x: r.left + r.width / 2, y: r.top + r.height / 2 };
    };

    // refresh 前に一旦座標をフラットにしてから再計算（ドリフト防止）
    const resetXY = () => {
      qsa('.p-mv__image a').forEach(t => gsap.set(t, { x: 0, y: 0 }));
    };
    ScrollTrigger.addEventListener('refreshInit', resetXY);

    qsa('.p-mv__image a').forEach((target, i) => {
      // 初期は非表示（表示は一度だけ）
      gsap.set(target, {
        autoAlpha: 0,
        transformOrigin: 'center center',
        willChange: 'transform',
        x: 0,
        y: 0,
        zIndex: 100 - i // 上下関係が分かるよう任意で層に
      });

      ScrollTrigger.create({
        trigger: '.p-mv__images',
        start: 'top bottom',
        once: true,
        onEnter: () => gsap.set(target, { autoAlpha: 1 })
      });

      // 最新の中心差分を計算（X/Y）
      const computeOffset = () => {
        const c = getContainerCenter();
        const tr = target.getBoundingClientRect();
        const tx = tr.left + tr.width / 2;
        const ty = tr.top + tr.height / 2;
        return { x: c.x - tx, y: c.y - ty };
      };

      gsap.to(target, {
        // X/Y を “関数” で与えて、refresh ごとに再評価
        x: () => computeOffset().x,
        y: () => computeOffset().y,
        // 必要なら最終表示サイズを固定
        scale: 1,
        scrollTrigger: {
          trigger: '.p-mv__images',
          start: 'top center',
          end: 'bottom top',       // スクロール末で完全に重なる
          scrub: true,
          invalidateOnRefresh: true,
          // markers: true
        },
        immediateRender: false,
        lazy: false
      });
    });

    // フォント/リサイズで座標が変わったら再計算
    window.addEventListener('resize', () => ScrollTrigger.refresh(), { passive: true });
    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(() => ScrollTrigger.refresh());
    }
  };

  // テキスト完了待ちを使っているなら維持
  if (window.__wordRevealDone) run();
  else window.addEventListener('wordReveal:done', run, { once: true });
};


  // -------------------------
  // 8) MV画像（SP）左右から入る
  // -------------------------
gsap.registerPlugin(ScrollTrigger);

const initMvImagesSp = () => {
  if (!hasGSAP || !hasScrollTrigger) return;

  const mm = gsap.matchMedia();

  mm.add("(max-width: 767px)", () => {
    const targets = [
      ".p-mv__image01",
      ".p-mv__image02",
      ".p-mv__image03"
    ];

    ScrollTrigger.batch(targets, {
      start: "top bottom-=100",
      toggleActions: "play none none reverse",
      onEnter: (batch) => {
        gsap.fromTo(
          batch,
          {
            x: (i) => (i % 2 === 0 ? -1000 : 1000), // 左右交互
            autoAlpha: 0
          },
          {
            x: 0,
            autoAlpha: 1,
            duration: 1.2,
            ease: "power3.out",
            stagger: 0.2
          }
        );
      }
    });
  });
};

  // -------------------------
  // 9) ヘッダーメッセージの表示切替
  // -------------------------
  const initHeaderOccupationToggle = () => {
    if (!hasGSAP || !hasScrollTrigger) return;
    window.ScrollTrigger.create({
      trigger: '.js-headerOccupation',
      start: 'top top+=1',
      onEnter: () => { const el = qs('.js-headerOccupation'); el && el.classList.add('is-active'); },
      onLeaveBack: () => { const el = qs('.js-headerOccupation'); el && el.classList.remove('is-active'); }
    });
  };

  // -------------------------
  // 10) サイドタイトルのスライドイン
  // -------------------------
  const initSideTitleSlide = () => {
    if (!hasGSAP || !hasScrollTrigger) return;
    const side = '.p-about__ttl';
    const item = '.p-about__ttlItem';
    const first = '.p-about__ttlItem--top';
    const second = '.p-about__ttlItem--bottom';

    if (!qs(side)) return;

    gsap.set(first,  { x: '-200%' });
    gsap.set(second, { x: '200%'  });
    gsap.to(item, {
      x: '0%',
      scrollTrigger: { trigger: side, start: 'top center', end: 'bottom center', scrub: true }
    });
  };

  // -------------------------
  // 11) セクション見出し/背景のトグル & WORKボタン
  // -------------------------
  const initSectionToggles = () => {
    if (!hasGSAP || !hasScrollTrigger) return;

    if (qs('#work .c-section__ttl')) {
      window.ScrollTrigger.create({
        trigger: '#work', start: 'top 80%', end: 'bottom top',
        toggleClass: { targets: qs('#work .c-section__ttl'), className: 'js-sectionTtl' }
      });
    }

    if (qs('#service .c-section__ttl')) {
      window.ScrollTrigger.create({
        trigger: '#service', start: 'top 20%', end: 'bottom top',
        toggleClass: { targets: qs('#service .c-section__ttl'), className: 'js-sectionTtl' }
      });
    }

    const workBtn = qs('.u-work__btn');
    if (workBtn) {
      window.ScrollTrigger.create({
        trigger: '#service', start: 'top 90%', end: 'bottom top',
        toggleClass: { targets: workBtn, className: 'js-workBtn' }
      });
    }

    const service = qs('#service');
    if (service) {
      window.ScrollTrigger.create({
        trigger: '#service', start: 'top 20%', end: 'bottom top',
        toggleClass: { targets: service, className: 'js-sectionBg' }
      });
    }
  };

  // -------------------------
  // 12) サービスアイテム・スティッキー & Lenis（存在すれば）
  // -------------------------
  const initServiceSticky = () => {
    if (!hasGSAP || !hasScrollTrigger) return;

    class StickyScroll {
      constructor() {
        this.els = qsa('.js-serviceItemSticky');
        if (!this.els.length) return;
        this.init();
      }
      init() {
        this.initSmoothScrolling();
        this.scroll();
      }
      scroll() {
        this.els.forEach((el, index) => {
          el.style.zIndex = `${100 + index}`;
          gsap.timeline({
            scrollTrigger: { trigger: el, start: 'top center', end: 'bottom center', scrub: true }
          }).to(qs('.c-service__item', el), {
            scale: 1, yPercent: -20, transformOrigin: 'center center', ease: 'none'
          });
        });
      }
      initSmoothScrolling() {
        // Lenis が読み込まれていない環境では無効化（落とさない）
        if (typeof window.Lenis === 'undefined') return;

        const lenis = new window.Lenis({ lerp: 0.1, smoothWheel: true });
        function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
        requestAnimationFrame(raf);
        lenis.on('scroll', window.ScrollTrigger.update);
      }
    }

    // 冪等実行
    if (!('stickyScrollInstance' in window)) window.stickyScrollInstance = null;
    window.stickyScrollInstance = new StickyScroll();
  };


  // -------------------------
  // 起動 & リサイズ
  // -------------------------
  const boot = () => {
    initMoreButtonHover();
    initFrontWorkSwiper();
    initSingleWorkSwiper();
    initDrawer();
    initMvTitle();
    initWordReveal();
    initMvImagesSp();
    initMvImagesDesktop();
    initHeaderOccupationToggle();
    initSideTitleSlide();
    initSectionToggles();
    initServiceSticky();
    initParallax();
  };

  // DOM 準備後に起動
  on(document, 'DOMContentLoaded', boot);

  // リサイズは必要箇所のみ再実行（Swiper系のみでOK）
  on(window, 'resize', debounce(() => {
    initFrontWorkSwiper();
    initSingleWorkSwiper();
  }, 200));

})();
