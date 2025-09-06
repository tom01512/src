<div class="p-other-head">
    <?php if ( is_singular('works') ) : ?>
        <h1>WORK</h1>
    <?php elseif ( is_page() ) : ?>
        <h1><?php the_title(); ?></h1>
    <?php else : ?>
        <h1><?php the_archive_title(); ?></h1>
    <?php endif; ?>

    <div class="p-other-head-list ">
        <ul class="p-other-head-list1">
            <li>Tom's</li>
            <li>Portfolio</li>
            <li>Web</li>
            <li>Front</li>
            <li>end</li>
            <li>Development</li>
            <li>&</li>
            <li>Design.</li>
        </ul>
        <ul class="p-other-head-list2">
            <li>Tom's</li>
            <li>Portfolio</li>
            <li>Web</li>
            <li>Front</li>
            <li>end</li>
            <li>Development</li>
            <li>&</li>
            <li>Design.</li>
        </ul>
    </div>
</div>
<div class="p-breadcrumb">
    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
    <?php if(function_exists('bcn_display'))
        {
            bcn_display();
        }?>
    </div>
</div>