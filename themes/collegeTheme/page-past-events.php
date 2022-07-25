<?php echo get_header();
pageBanner(array(
  "title" => "Past Events",
  "subtitle" => "A recap of our past events.",
))
?>


    <div class="container container--narrow page-section">
        <?php   
       $today = date("Ymd");

       $pastEvents = new WP_Query(array(
        "paged"=> get_query_var("paged", 1),
         "post_type" => "event",
         "meta_key" => "event_date",
         "orderby" => "meta_value_num",
         "order" => "ASC",
         "meta_query" => array(
           array(
             "key" => "event_date",
             "compare" => "<",
             "value" => $today,
             "type" => "numeric",
           )
         )
       ));

        while($pastEvents->have_posts()) { 
            $pastEvents->the_post();

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
            echo paginate_links(array(
                "total" => $pastEvents->max_num_pages
            ));
            ?>

            <hr class="section-break">
      
      <p>Want to attend put events.  <a href="<?php echo get_post_type_archive_link("event") ?>">Check up our upcoming events.</a></p>
    </div>


<?php echo get_footer() ?>