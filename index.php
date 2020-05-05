<?php 
/*
Plugin Name: ALT Lab Gender, Sexuality, & Women's Studies
Plugin URI:  https://github.com/
Description: For the OER site
Version:     1.0
Author:      ALT Lab
Author URI:  http://altlab.vcu.edu
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_enqueue_scripts', 'gsws_load_scripts');

function gsws_load_scripts() {                           
    $deps = array('jquery');
    $version= '1.0'; 
    $in_footer = true;    
    wp_enqueue_script('altlab-gsws-main-js', plugin_dir_url( __FILE__) . 'js/altlab-gsws-main.js', $deps, $version, $in_footer); 
    wp_enqueue_style( 'altlab-gsws-main-css', plugin_dir_url( __FILE__) . 'css/altlab-gsws-main.css');
}

add_action( 'admin_init', 'gsws_enqueue_admin_script' );

function gsws_enqueue_admin_script( $hook ) {  
  wp_enqueue_style( 'altlab-gsws-admin-css', plugin_dir_url( __FILE__ ) . 'css/altlab-gsws-admin.css' );
}



//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");



function gsws_resource_display_add($content){
  global $post;
  $post_id = $post->ID;
  $resources = '';
  if( have_rows('resources', $post_id) ):
    $resources .= '<div class="resources"><h2>Resources</h2>';
  // loop through the rows of data
    while ( have_rows('resources', $post_id) ) : the_row();
        // display a sub field value
         $resource_title = get_sub_field('resource_title', $post_id);
         $resource_description = get_sub_field('resource_description', $post_id);
         $resource_link = get_sub_field('url', $post_id);
         $resources .= '<div class="single-resource">';
         if($resource_title){
            $resources .= '<a href="' . $resource_link . '"><h3 class="resource-title">'.$resource_title.'</h3></a>';
         }
         if($resource_description){
            $resources .= '<div class="resource-description">'.$resource_description.'</div>';
         }
         $resources .= '</div>';
    endwhile;
    $resources .= '</div>';
    return $content . $resources;

    else :
      return $content;
        // no rows found

    endif;
}
add_filter( 'the_content', 'gsws_resource_display_add' );



if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
  'key' => 'group_5ea7151ad62c3',
  'title' => 'Resources Guide',
  'fields' => array(
    array(
      'key' => 'field_5ea7152888f46',
      'label' => 'Resources',
      'name' => 'resources',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'collapsed' => '',
      'min' => 0,
      'max' => 0,
      'layout' => 'block',
      'button_label' => '',
      'sub_fields' => array(
        array(
          'key' => 'field_5ea7181688f47',
          'label' => 'Title',
          'name' => 'resource_title',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '50',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
        array(
          'key' => 'field_5ea71a4388f49',
          'label' => 'URL',
          'name' => 'url',
          'type' => 'url',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '50',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
        ),
        array(
          'key' => 'field_5eb15884de96a',
          'label' => 'Resource Description',
          'name' => 'resource_description',
          'type' => 'wysiwyg',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '100',
            'class' => '',
            'id' => 'description-wysiwyg',
          ),
          'default_value' => '',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 1,
          'delay' => 0,
        ),
        array(
          'key' => 'field_5eb158a4de96b',
          'label' => 'Citation',
          'name' => 'citation',
          'type' => 'wysiwyg',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '100',
            'class' => 'short-wysiwyg',
            'id' => 'citation-wysiwyg',
          ),
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 1,
          'default_value' => '',
          'delay' => 0,
        ),
      ),
    ),
  ),
  'location' => array(
    array(
      array(
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'page',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
  'active' => true,
  'description' => '',
));

endif;
