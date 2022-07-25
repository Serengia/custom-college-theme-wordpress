<?php
get_header();

while (have_posts()) {
    the_post();
    pageBanner();
?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("campus") ?>"><i class="fa fa-home" aria-hidden="true"></i> All campuses</a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php
            the_content();
            $mapPoint = get_field("map_location");
            ?>
            <div class="acf-map">
                <div class="marker" data-lat="<?php echo $mapPoint['lat'] ?>" data-lng="<?php echo $mapPoint["lng"] ?>">
                    <h3><?php the_title() ?></h3>
                    <p><?php echo $mapPoint["address"] ?></p>
                </div>
            </div>
        </div>

        <?php

        wp_reset_postdata();

        // Related Programs
        $relatedPrograms = new WP_Query(array(
            "posts_per_page" => -1,
            "post_type" => "program",
            "orderby" => "title",
            "order" => "ASC",
            "meta_query" => array(
                array(
                    "key" => "related_campuses",
                    "compare" => "LIKE",
                    "value" => '"' . get_the_ID() . '"',
                )
            )
        ));


        if ($relatedPrograms->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Programs available at this Campus.</h2>";
        }

        echo "<ul class='min-list link-list'>";
        while ($relatedPrograms->have_posts()) {
            $relatedPrograms->the_post();
        ?>
            <li>
                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
            </li>

        <?php
        }
        echo "</ul>";

        wp_reset_postdata();




        // Related Events

        $today = date("Ymd");

        $relatedEvents = new WP_Query(array(
            "posts_per_page" => 2,
            "post_type" => "event",
            "meta_key" => "event_date",
            "orderby" => "meta_value_num",
            "order" => "ASC",
            "meta_query" => array(
                array(
                    "key" => "event_date",
                    "compare" => ">=",
                    "value" => $today,
                    "type" => "numeric",
                )
            )
        ));

        if ($relatedEvents->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Related " . get_the_title() . " Events</h2>";
        }

        while ($relatedEvents->have_posts()) {
            $relatedEvents->the_post();

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
                        if (has_excerpt()) {
                            echo get_the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 18);
                        }

                        ?> <a href="#" class="nu gray">Learn more</a></p>
                </div>
            </div>

        <?php
        }

        ?>
    </div>

<?php }

get_footer()
?>