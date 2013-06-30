var shanhaijing = shanhaijing || { 'settings': {} };

(function($) {

shanhaijing.url = function(path) {
    return shanhaijing.settings.base_url + '/' + path;
};

})(jQuery);
