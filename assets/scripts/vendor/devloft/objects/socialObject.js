(function ($, win, doc) {
    DevLoft.Objects.SocialObject = DevLoft.Objects.BaseObject.extend({
        share: function (network, options) {
            switch(network.toLowerCase()) {
                case "facebook":
                    return this.shareFacebook(options);
                case "twitter":
                    return this.shareTwitter(options);
                case "pinterest":
                    return this.sharePinterest(options);
                case "googleplus":
                    return this.shareGooglePlus(options);
            }
        },
        shareFacebook: function (options) {
            FB.ui({
                method: 'feed',
                name: $("title").text(),
                description: $("meta[property='og:description']").attr("content"),
                link: $("meta[property='og:url']").attr("content"),
                picture: $("meta[property='og:image']").attr("content")
               },
               options.callback || function(resp) {
                   console.log(resp);
               }
            );
        },
        shareTwitter: function (shareObj) {               
            window.open("http://twitter.com/intent/tweet?url=" + encodeURIComponent(location.href) + "&text=" + encodeURIComponent("Tweet about us!"), $("title").text(), "width=500, height=300, left=" + (App.$w.width()/2 - 250) + ", top=" + (App.$w.height()/2 - 150), false);
        },
        sharePinterest: function () {
            var url = 'http://pinterest.com/pin/create/button/?'+
            'url='+encodeURIComponent(location.href) +
            '&media='+encodeURIComponent($("meta[property='og:image']").attr("content")) +
            '&description='+encodeURIComponent($("meta[property='og:description']").attr("content"));
            window.open(url, $("title").text(), "width=800, height=300, left=" + (App.$w.width()/2 - 400) + ", top=" + (App.$w.height()/2 - 150), false);
        },
        shareGooglePlus: function () {
            
        }
    });

    DevLoft.Social = new DevLoft.Objects.SocialObject();
})(jQuery, window, document);