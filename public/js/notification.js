;(function($, settings) {

shanhaijing.Notification = function() {
    this.checkRuning = false;
    this.checkDelay = 60 * 5 * 1000;
    this.timestamp = null;
    this.timeoutID = null;
};
shanhaijing.Notification.prototype = {
    constructor: shanhaijing.Notification,

    check: function() {
        var self = this;
        var f = function() {
            $.post(shanhaijing.url('notification/updates'), {
                _token: settings.token,
                ts: self.timestamp || ''
            }, function(data) {
                self.timestamp = data.ts;

                if (data.notifications.length > 0) {
                    for (var i in data.notifications) {
                        var notice = data.notifications[i];
                        self.desktopNotify(settings.sitename, notice.msg);
                    }
                }

                if (self.checkRuning) {
                    self.timeoutID = setTimeout(f, self.checkDelay);
                }

            }, 'json');
        };

        f();
    },

    startChecking: function() {
        this.checkRuning = true;
        this.check();
    },

    stopChecking: function() {
        clearTimeout(this.timeoutID);
        this.checkRuning = false;
    },

    desktopNotify: function(title, body) {
        if (window.webkitNotifications && window.webkitNotifications.checkPermission() === 0) {
            var popup = window.webkitNotifications.createNotification(null, title, body);
            popup.show();
        }
        else if (window.Notification && window.Notification.permission) {
            new Notification(title, {
                body: body
            });
        }
    }
};


// request browser desktop notification permission.
if (window.Notification && window.Notification.permission) {
    Notification.requestPermission(function() {  });
}

// start checking
new shanhaijing.Notification().startChecking();


})(jQuery, shanhaijing.settings);
