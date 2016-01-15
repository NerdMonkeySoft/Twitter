const INTERVAL = 60000;

$(function () {

    // Initialize and render single tweet view.
    _SingleTweetView = Backbone.View.extend({

        initialize: function () {
            _.bindAll(this, 'render');
        },

        render: function () {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        },

        tagName: "li",
        template: _.template($('#SingleTweetView').html())
    });

    // Initialize and render nothing found view, when no search results found.
    _NothingFound = Backbone.View.extend({

        initialize: function () {
            _.bindAll(this, 'render');
        },

        render: function () {
            this.$el.html(this.template());
            return this;
        },

        tagName: 'li',
        template: _.template($('#NothingFound').html())
    });

    // Initialize interval and render current tweets. Filter if any input value given.
    TweetCollectionView = Backbone.View.extend({

        el: $("#searchScope"),

        events: {
            "keyup #filterCollection": "filterCollection"
        },

        initialize: function () {

            _.bindAll(this, 'addTweet', 'render', 'filterCollection');

            this.input = this.$("#filterCollection");

            this.updateNotification = this.$(".updateNotification");

            this.tweetsCollection = new TweetsCollection();
            this.tweetsCollection.bind('update', this.render);

            this.tweetsCollection.fetch();

            that = this;

            setInterval(function () {

                that.updateNotification.show();
                that.tweetsCollection.fetch();
            }, INTERVAL);

        },

        addTweet: function (tweet) {

            var view = new _SingleTweetView({
                model: tweet
            });

            this.$('#tweeter-timeline').append(view.render().el);
        },

        render: function () {

            this.updateNotification.hide();
            this.$('#tweeter-timeline').empty();

            that = this;

            this.tweetsCollection.each(function (tweet) {
                that.addTweet(tweet);
            });
        },

        filterCollection: function (event) {

            if (!this.input.val()) {
                return;
            }

            var needle = this.input.val();
            var filteredCollection = this.tweetsCollection.filterTweetsCollection(needle.toLowerCase());

            this.$("#tweeter-timeline").empty();

            that = this;

            if (filteredCollection.length > 0) {
                _(filteredCollection).each(function (tweet) {
                    that.addTweet(tweet);
                });
            }
            else {
                var view = new _NothingFound();
                this.$('#tweeter-timeline').append(view.render().el);
            }

        }
    });

    new TweetCollectionView;

});