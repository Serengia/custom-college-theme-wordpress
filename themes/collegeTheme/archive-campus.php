<?php echo get_header();
pageBanner(array(
    "title" => "Our Campuses",
    "subtitle" => "All our campuses have great learning environment."
))
?>


<div class="container container--narrow page-section">

    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            the_post();

        ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>

        <?php

        } ?>

    </ul>
</div>

<?php

echo '<div class="container container--narrow page-section">';
echo '<div class="acf-map">';

while (have_posts()) {
    the_post();
    $mapPoint = get_field("map_location");
?>
    <div class="marker" data-lat="<?php echo $mapPoint['lat'] ?>" data-lng="<?php echo $mapPoint["lng"] ?>">
        <h3> <a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
        <p><?php echo $mapPoint["address"] ?></p>
    </div>

<?php
}

echo '</div>';

echo "</div>";

?>


<?php echo get_footer() ?>