<?php
/*
Plugin Name: WpPdfJs
Plugin URI: https://sdo.sh/
Description: Embed PDFs with the gorgeous PDF.js viewer (based on PDF.js Viewer by Ben Lawson)
Version: 1.4
Author: Rene Schmidt (https://sdo.sh), Ben Lawson (http://byterevel.com/)
Author URI: https://sdo.sh/
License: GPLv2
*/


//==== Shortcode ====

//tell wordpress to register the pdf-embed shortcode
add_shortcode("pdf-embed", function ($incoming_from_post) {
    //set defaults
    $incoming_from_post = shortcode_atts([
        'url'           => 'bad-url.pdf',
        'viewer_height' => '1360px',
        'viewer_width'  => '100%',
        'fullscreen'    => 'true',
        'download'      => 'true',
        'print'         => 'true',
        'openfile'      => 'false'
    ], $incoming_from_post);

    $viewer_base_url = plugins_url('pdfjs/web/viewer.php', __FILE__);

    $print = $incoming_from_post["print"] != 'true' ? 'false' : 'true';
    $openfile = $incoming_from_post["openfile"] != 'true' ? 'false' : 'true';
    $download = $incoming_from_post["download"] != 'true' ? 'false' : 'true';
    $file_name = $incoming_from_post["url"];
    $fullscreen = $incoming_from_post["fullscreen"];
    $viewer_width = (int)$incoming_from_post["viewer_width"];
    $viewer_height = (int)$incoming_from_post["viewer_height"];

    $final_url = $viewer_base_url . "?file=" . $file_name . "&download=" . $download . "&print=" . $print . "&openfile=" . $openfile;
    $fullscreen_link = '';

    if ($fullscreen == 'true') {
        $fullscreen_link = '<a href="' . $final_url . '">View Fullscreen</a><br>';
    }

    $iframe_code = '<iframe width="' . $viewer_width . '" height="' . $viewer_height . '" src="' . $final_url . '"></iframe> ';

    //send back text to replace shortcode in post
    return $fullscreen_link . $iframe_code;
});

//==== Media Button ====

//priority is 12 since default button is 10
add_action('media_buttons', function () {
    echo '<a href="#" id="insert-pdfjs" class="button">Add PDF</a>';
}, 12);


add_action('wp_enqueue_media', function () {
    wp_enqueue_script('media_button', plugins_url('pdfjs-media-button.js', __FILE__), ['jquery'], '1.0', true);
});
