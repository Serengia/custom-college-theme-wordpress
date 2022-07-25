<?php

require get_theme_file_path("/includes/search-routes.php");

function loadFiles()
{
  wp_enqueue_script("googleMap", '//maps.googleapis.com/maps/api/js?key=YOUR_API_KEY', NULL, 1.0, true);
  wp_enqueue_script("university-main-js", get_theme_file_uri("/build/index.js"), array("jquery"), 1.0, true);
  wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
  wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
  wp_enqueue_style("university-main-styles", get_theme_file_uri("/build/style-index.css"));
  wp_enqueue_style("university-additional-styles", get_theme_file_uri("/build/index.css"));

  // Avail some data to Javascript
  wp_localize_script("university-main-js", "universityData", array(
    "root_url" => get_site_url(),
    "nonce" => wp_create_nonce("wp_rest")
  ));
}

add_action("wp_enqueue_scripts", "loadFiles");

function universityThemeFeatures()
{
  add_theme_support("title-tag");
  add_theme_support("post-thumbnails");
  add_image_size("themeLandscapeImg", 650, 400, true);
  add_image_size("themePortraitImg", 500, 600, true);
  add_image_size("pageBannerImg", 1200, 400, true);

  register_nav_menu("mainHeaderLocation", "Main Header Menu Location");
  register_nav_menu("footerLocationOne", "Footer Location One");
  register_nav_menu("footerLocationTwo", "Footer Location Two");
}

add_action("after_setup_theme", "universityThemeFeatures");


// Middleware - Ensures all campuses are displayed on the map
function adjustCampusArchiveQuery($query)
{
  if (!is_admin() and is_post_type_archive("campus") and $query->is_main_query()) {
    $query->set("posts_per_page", -1);
  }
}

// Middleware - To adjust programs query
function adjustProgramArchiveQuery($query)
{
  if (!is_admin() and is_post_type_archive("program") and $query->is_main_query()) {
    $query->set("posts_per_page", -1);
    $query->set("orderby", "title");
    $query->set("order", "ASC");
  }
}

add_action("pre_get_posts", "adjustProgramArchiveQuery");


function universityMapKey($api)
{
  $api["key"] = "GOOGLE_MAPS_API_KEY_HERE";
  return $api;
}

add_filter("acf/fields/google_map/api", "universityMapKey");


// Page banner
function pageBanner($args = NULL)
{

  if (!$args['title']) {
    $args['title'] = get_the_title();
  }

  if (!$args['subtitle']) {
    $args['subtitle'] = get_field("page_banner_subtitle");
  }

  if (!$args['photo']) {
    if (get_field("page_banner_image")  and !is_archive() and !is_home()) {
      $args['photo'] = get_field("page_banner_image")["sizes"]["pageBannerImg"];
    } else {
      $args['photo'] = get_theme_file_uri("/images/ocean.jpg");
    }
  }
?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args["photo"] ?>)">

    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args["title"] ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args["subtitle"] ?></p>
      </div>
    </div>
  </div>
<?php } ?>

<?php

// Customizing WORDPRESS REST api

function universityCustomRest()
{
  register_rest_field("post", "authorName", array(
    "get_callback" => function () {
      return get_the_author();
    }
  ));

  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function () {
      return count_user_posts(get_current_user_id(), 'note');
    }
  ));
}

add_action("rest_api_init", "universityCustomRest");



// Redirect subscribers to the frontend on login
function redirectSubsOnLogin()
{
  $currentUser = wp_get_current_user();

  if (count($currentUser->roles) === 1 and $currentUser->roles[0] === "subscriber") {
    wp_redirect(site_url("/"));
    exit;
  }
}

add_action("admin_init", "redirectSubsOnLogin");



// Hide adminbar for subscribers
function hideAdminBarForSubs()
{
  $currentUser = wp_get_current_user();

  if (count($currentUser->roles) === 1 and $currentUser->roles[0] === "subscriber") {
    show_admin_bar(false);
  }
}

add_action("wp_loaded", "hideAdminBarForSubs");


// Customize wp login screen
function changeLoginScreenUrl()
{
  return esc_url(site_url("/"));
}

add_filter("login_headerurl", "changeLoginScreenUrl");

// Customize login header title
function customizeLoginHeader()
{
  return get_bloginfo("name");
}

add_filter("login_headertitle", "customizeLoginHeader");

// Load css to the login page to customize it

function loadOurCSStoLoginPage()
{
  wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
  wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
  wp_enqueue_style("university-main-styles", get_theme_file_uri("/build/style-index.css"));
  wp_enqueue_style("university-additional-styles", get_theme_file_uri("/build/index.css"));
}

add_action("login_enqueue_scripts", "loadOurCSStoLoginPage");


// Force post data to be private

function modifyNoteDataMiddleware($data, $postarr)
{
  if ($data["post_type"] == "note") {

    if (count_user_posts(get_current_user_id(), 'note') > 4 and !$postarr['ID']) {
      die(0);
    }


    $data["post_title"] = sanitize_text_field($data["post_title"]);
    $data["post_content"] = sanitize_textarea_field($data["post_content"]);
  }

  if ($data["post_type"] == "note" and $data["post_status"] != "trash") {
    $data["post_status"] = "private";
  }

  return $data;
}

add_filter("wp_insert_post_data", "modifyNoteDataMiddleware", 10, 2)
?>