<?php echo get_header();
pageBanner(array(
  "title" => "All programs",
  "subtitle" => "There is something for everyone. Look around."
))
?>


    <div class="container container--narrow page-section">

    <ul class="link-list min-list">
        <?php   
        while(have_posts()) { 
            the_post();

            ?>
             <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>

            <?php } ?>
    </ul>

            <?php echo paginate_links();?>



    </div>


<?php echo get_footer() ?>