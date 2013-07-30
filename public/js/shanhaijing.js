var shanhaijing = shanhaijing || { 'settings': {} };

(function($) {

shanhaijing.url = function(path) {
    return shanhaijing.settings.base_url + '/' + path;
};


$(function() {

    var forms = $('form');
    if (forms.length > 0) {
        forms.submit(function(event) {
            var $this = $(this);
            if ($this.attr('data-validate') == 'parsley' && !$this.parsley('isValid')) {
                return;
            }
            $this.find('submit, button[type=submit]').button('loading');
        });
    }

});

})(jQuery);
