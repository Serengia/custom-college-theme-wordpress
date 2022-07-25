<?php echo get_header();
pageBanner(array(
    "title" => "Welcome to our blog.",
    "subtitle" => "Stay updated with our latest news."
))
?>


<div class="container container--narrow page-section">
    <?php while (have_posts()) {
        the_post();
    ?>
        <div class="post-item">

            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            <div class="metabox">
                Posted by <?php echo get_the_author_posts_link() ?> on <?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?> under <?php echo get_the_category_list(", ") ?>.
            </div>
            <div class="generic-content">
                <?php the_excerpt(); ?>

                <p><a href="<?php the_permalink() ?>" class="btn btn--blue">Continue reading &rarr;</a></p>
            </div>
        </div>

    <?php }
    echo paginate_links()
    ?>


</div>


<?php echo get_footer() ?>