jQuery(function ($) {
    $('div[id^="featured"]').lightGallery({
        loop: true,
        thumbnail: true,
        exThumbImage: 'data-exthumbimage'
    });
});
