<?php echo get_header();
pageBanner(array(
 "title" => get_the_archive_title(),
 "subtitle" => get_the_archive_description(),
))
?>

    <div class="container container--narrow page-section">
        <?php   
        while(have_posts()) { 
            the_post();

            $inputDate = new DateTime(get_field("event_date"));
            $month = $inputDate->format("M");
            $day = $inputDate->format("d");
            ?>

             <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
              <span class="event-summary__month"><?php echo $month ?></span>
              <span class="event-summary__day"><?php echo $day ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
              <p><?php 
              if(has_excerpt()){
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              
              ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>

            <?php } 
            echo paginate_links();
            ?>

<hr class="section-break">
<p>See a recap of <a href="<?php echo site_url("/past-events")?>"> our past events.</a></p>

    </div>


<?php echo get_footer() ?>