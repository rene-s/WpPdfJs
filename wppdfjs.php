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
add_shortcode("pdf-embed", function ($shortCodeAttributes) {
    //set defaults
    $shortCodeAttributes = shortcode_atts([
        'url'           => 'bad-url.pdf',
        'viewer_height' => '1360px',
        'viewer_width'  => '100%',
        'fullscreen'    => 'true',
        'download'      => 'true',
        'print'         => 'true',
        'openfile'      => 'false'
    ], $shortCodeAttributes);

    // @fixme values need to be sanitized
    $viewerBaseUrl = plugins_url('pdfjs/web/viewer.php', __FILE__);

    $print = $shortCodeAttributes["print"] != 'true' ? 'false' : 'true';
    $openFile = $shortCodeAttributes["openfile"] != 'true' ? 'false' : 'true';
    $download = $shortCodeAttributes["download"] != 'true' ? 'false' : 'true';
    $fileName = $shortCodeAttributes["url"];
    $fullscreen = $shortCodeAttributes["fullscreen"];
    $viewerWidth = $shortCodeAttributes["viewer_width"];
    $viewerHeight = $shortCodeAttributes["viewer_height"];

    $url = $viewerBaseUrl . "?file=" . $fileName . "&download=" . $download . "&print=" . $print . "&openfile=" . $openFile;
    $fullscreenLink = '';

    if ($fullscreen == 'true') {
        $fullscreenLink = '<a href="' . $url . '">View Fullscreen</a><br>';
    }

    $iframe = '<iframe width="' . $viewerWidth . '" height="' . $viewerHeight . '" src="' . $url . '"></iframe> ';

    //send back text to replace shortcode in post
    return $fullscreenLink . $iframe;
});

//==== Media Button ====

//priority is 12 since default button is 10
add_action('media_buttons', function () {
    echo '<a href="#" id="insert-pdfjs" class="button">Add PDF</a>';
}, 12);

add_action('wp_enqueue_media', function () {
    wp_enqueue_script('media_button', plugins_url('wppdfjs.js', __FILE__), ['jquery'], '1.0', true);
});
