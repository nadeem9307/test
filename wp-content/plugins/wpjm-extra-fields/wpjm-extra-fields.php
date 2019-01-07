<?php

/**
 * Plugin Name: Webcom Addon plugin 
 * Plugin URI: no
 * Description: Adds an extra fields for display listing to according meta value 
 * Version: 1.0.0
 * Author: Mohd Nadeem
 * Author URI: no
 * Text Domain: webcom-extra-fields
 * Domain Path: /languages
 *
 * License:no
 */
/**
 * Prevent direct access data leaks
 * */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_Job_Manager')) {

    add_action('admin_notices', 'webcom_admin_notice__error');
} else {

    add_filter('submit_job_form_fields', 'webcom_frontend_add_extra_field');
//  add_filter( 'submit_job_form_fields', 'gma_wpjmef_frontend_add_important_info_field');

    add_filter('job_manager_job_listing_data_fields', 'webcom_admin_add_extra_field');
//  add_filter( 'job_manager_job_listing_data_fields', 'gma_wpjmef_admin_add_important_info_field' );

    add_action('single_job_listing_meta_end', 'webcom_display_job_extra_data');
//  add_action( 'single_job_listing_meta_end', 'gma_wpjmef_display_important_info_data' );
}

/**
 * Adds a new optional "Extra" text field at the "Submit a Job" form, generated via the [submit_job_form] shortcode
 * */
function webcom_frontend_add_extra_field($fields) {

    $fields['job']['job_extra'] = array(
        'label' => __('Extra', 'webcom-extra-fields'),
        'type' => 'select',
        'required' => false,
        'placeholder' => 'e.g. USD$ 20.000',
        'description' => '',
        'priority' => 7,
    );

    return $fields;
}

/**
 * Adds a text field to the Job Listing wp-admin meta box named extra
 * */
function webcom_admin_add_extra_field($fields) {

    $fields['_job_extra'] = array(
        'label' => __('Extra', 'webcom-extra-fields'),
        'type' => 'select',
        'options' => array('first' => 'First', 'second' => 'Second', 'third' => 'Third', 'fouth' => 'Fouth'),
        'description' => ''
    );

    return $fields;
}

/**
 * Displays "Extra" on the Single Job Page, by checking if meta for "_job_extra" exists and is displayed via do_action( 'single_job_listing_meta_end' ) on the template
 * */
function webcom_display_job_extra_data() {

    global $post;

    $salary = get_post_meta($post->ID, '_job_extra', true);


    if ($salary) {
        echo '<li>' . __('Extra: ') . esc_html($salary) . '</li>';
    }
}

/**
 * Displays "Extra" on the Single Job Page, by checking if meta for "_job_extra" exists and is displayed via do_action( 'single_job_listing_meta_end' ) on the template
 * */
add_shortcode($shortcode, 'webcom_display_job_extra_data_listing');

function webcom_display_job_extra_data_listing() {

    global $post;
    $query_args = array(
        'post_type' => 'job_listing',
        'post_status' => 'publish',
        'orderby' => 'orderby',
        'meta_key' => '_job_extra',
        'meta_value' => 'second',
        'order' => 'order',
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'cache_results' => false,
        'fields' => $args['fields'],
    );
    $data = get_posts($query_args);
    echo '<ul class = "job_listings">';
    foreach ($data as $value) {
        echo '<li class = "post-' . $value->ID . ' job_listing type-job_listing status-publish hentry" data-longitude = "" data-latitude = "" style = "visibility: visible;">
            <a href = "' . $value->guid . '">
                <img class = "company_logo" src = "' . get_the_post_thumbnail_url(get_post_meta($value->ID, '_thumbnail_id', TRUE)) . '" alt = ""> <div class = "position">
                <h3>' . $value->post_title . '</h3>
              <div class = "company">
              ' . get_post_meta($value->ID, '_company_name', TRUE) . '
                        </div>
                 </div>
                    <div class = "location">
                        ' . get_post_meta($value->ID, '_job_location', TRUE) . ' </div>
                <ul class = "meta">
                    <li class = "date"><time datetime = "' . get_the_date('Y  j, F') . '">Posted ' . $value->post_modified . '</time></li>
            </a>
        </li>';
    }
    echo '</ul>';
    $shortcode ="job-list extra=”3”";
}

/**
 * Display an error message notice in the admin if WP Job Manager is not active
 */
function webcom_admin_notice__error() {

    $class = 'notice notice-error';
    $message = __('An error has occurred. WP Job Manager must be installed in order to use this plugin', 'webcom-extra-fields');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}
