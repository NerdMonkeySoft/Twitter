$(function () {
    TweetsCollection = Backbone.Collection.extend({
        model: Tweet,
        url: 'feeds.php',

        filterTweetsCollection: function (needle) {
            return this.filter(function (tweet) {
                return tweet.get('tweet_content').toLowerCase().indexOf(needle) != -1;
            });
        }
    });
});
