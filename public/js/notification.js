;(function($, settings) {

shanhaijing.Notification = function() {
    this.checkRuning = false;
    this.checkDelay = 60 * 5 * 1000;
    //this.checkDelay = 2000;
    this.timestamp = null;
    this.timeoutID = null;
};
shanhaijing.Notification.browserPermission = function() {
    if (window.Notification && window.Notification.permission) {
        return window.Notification.permission;
    }
    else if (window.webkitNotifications) {
        var permissions = ['granted', 'default', 'denied'];
        return permissions[window.webkitNotifications.checkPermission()];
    }
    else {
        return null;
    }
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
        if (shanhaijing.Notification.browserPermission() == 'granted') {
            var notifiy = new window.Notification(title, {
                iconUrl: shanhaijing.url('images/logo.png'),
                body: body
            });
            notifiy.onshow = function() {
                var self = this;
                setTimeout(function() {
                    self.close();
                }, 10000);
            };

            notifiy.onclick = function() {
                window.focus();
            };
        }
    }
};


$(function() {

// request browser desktop notification permission.
if (shanhaijing.Notification.browserPermission() == 'default') {
    var permissionRequest = $('#notification-permission-request');
    permissionRequest.show()
        .find('button.enable').click(function() {
            Notification.requestPermission(function() { 
                permissionRequest.hide();
                new Notification(settings.sitename, {
                    iconUrl: shanhaijing.url('images/logo.png'),
                    body: 'This is a notification example, thanks.',
                    onshow: function() { setTimeout(notification.close(), 5000); }
                });
            });
        });
}

// start checking
new shanhaijing.Notification().startChecking();

});



})(jQuery, shanhaijing.settings);
