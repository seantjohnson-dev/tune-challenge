(function ($, win, doc) {
    DevLoft.Behaviors.FullscreenBehavior = DevLoft.Behaviors.BaseBehavior.extend({
        exitFullscreen: function () {
            if(doc.exitFullscreen) {
                doc.exitFullscreen();
            } else if(doc.mozCancelFullScreen) {
                doc.mozCancelFullScreen();
            } else if(doc.webkitExitFullscreen) {
                doc.webkitExitFullscreen();
            } else if (doc.msExitFullscreen) {
                doc.msExitFullscreen();
            }
        },
        requestFullscreen: function (elem) {
            elem = (elem || doc);
            if(elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if(elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if(elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        }
    });
})(jQuery, window, document);