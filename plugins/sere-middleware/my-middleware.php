<?php
/**
 * Plugin Name:       Sere Post Middleware Plugin
 * Plugin URI:        https://jamesserengia.com/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            James Serengia
 * Author URI:        https://jamesserengia.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


// Pre get posts middleware
function modifyPostQuery($query){
  $today = date("Ymd");

  if(!is_admin() AND is_post_type_archive("event") AND $query-> is_main_query()){
    $query->set("meta_key", "event_date");
    $query->set("orderby", "meta_value_num");
    $query->set("order", "ASC");
    $query->set("meta_query", array(
      array(
        "key" => "event_date",
        "compare" => ">=",
        "value" => $today,
        "type" => "numeric",
      )
    ));
  }
}

add_action("pre_get_posts", "modifyPostQuery");