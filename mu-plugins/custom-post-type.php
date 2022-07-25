<?php

function customPostTypesHandler()
{

  // Events post type
  register_post_type("campus", array(
    "capability_type" => "campus",
    "map_meta_cap" => true,
    "rewrite" => array("slug" => "campuses"),
    "has_archive" => true,
    "supports" => array("title", "editor", "excerpt"),
    "public" => true,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Campuses",
      "singular_name" => "Campus",
      "new_item" => "New Campus",
      "add_new_item" => "Add New Campus",
      "edit_item" => "Edit Campus",
      "all_items" => "All Campuses",

    ),
    "menu_icon" => "dashicons-location-alt"
  ));

  // Events post type
  register_post_type("event", array(
    "capability_type" => "event",
    "map_meta_cap" => true,
    "rewrite" => array("slug" => "events"),
    "has_archive" => true,
    "supports" => array("title", "editor", "excerpt"),
    "public" => true,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Events",
      "singular_name" => "Event",
      "new_item" => "New Event",
      "add_new_item" => "Add New Event",
      "edit_item" => "Edit Event",
      "all_items" => "All Events",

    ),
    "menu_icon" => "dashicons-calendar"
  ));


  // Programs post type
  register_post_type("program", array(
    "rewrite" => array("slug" => "programs"),
    "has_archive" => true,
    "supports" => array("title"),
    "public" => true,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Programs",
      "singular_name" => "Program",
      "new_item" => "New Program",
      "add_new_item" => "Add New Program",
      "edit_item" => "Edit Program",
      "all_items" => "All Programs",

    ),
    "menu_icon" => "dashicons-awards"
  ));


  // Professor post type
  register_post_type("professor", array(
    "show_in_rest" => true,
    "supports" => array("title", "editor", "thumbnail"),
    "public" => true,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Professors",
      "singular_name" => "Professor",
      "new_item" => "New Professor",
      "add_new_item" => "Add New Professor",
      "edit_item" => "Edit Professor",
      "all_items" => "All Professors",

    ),
    "menu_icon" => "dashicons-welcome-learn-more"
  ));

  // My Notes post type
  register_post_type("note", array(
    "capability_type" => "note",
    "map_meta_cap" => true,
    "show_in_rest" => true,
    "supports" => array("title", "editor"),
    "public" => false,
    "show_ui" => true,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Notes",
      "singular_name" => "Note",
      "new_item" => "New Note",
      "add_new_item" => "Add New Note",
      "edit_item" => "Edit Note",
      "all_items" => "All Notes",

    ),
    "menu_icon" => "dashicons-welcome-write-blog"
  ));

  // Like post type
  register_post_type("like", array(

    "supports" => array("title"),
    "public" => false,
    "show_in_rest" => true,
    "labels" => array(
      "name" => "Likes",
      "singular_name" => "Like",
      "new_item" => "New Like",
      "add_new_item" => "Add New Like",
      "edit_item" => "Edit Like",
      "all_items" => "All Likes",

    ),
    "menu_icon" => "dashicons-heart"
  ));
}

add_action("init", "customPostTypesHandler");
