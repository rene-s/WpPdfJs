jQuery(function ($) {
    $('#insert-pdfjs').click(function () {
        console.log('pdfjs media button clicked');
        var frame = wp.media({
            title: 'Insert a PDF',
            library: {type: 'application/pdf'},
            multiple: false,
            button: {text: 'Insert'}
        });

        frame.on('select', function () {
            var selectionURL = frame.state().get('selection').first().toJSON().url;
            selectionURL = encodeURIComponent(selectionURL);
            wp.media.editor.insert('[pdf-embed url="' + selectionURL + '" viewer_width=100% viewer_height=1360px fullscreen=true download=true print=true]');
        });

        frame.open();
    });
});