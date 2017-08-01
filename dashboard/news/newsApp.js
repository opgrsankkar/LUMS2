/**
 * Created by Sankkara Narayanan on 16-Jul-17.
 */

angular.module("newsApp", ['ngAnimate'])
    .controller("newsControl", function ($scope, $http) {
        /**
         * highlighted news items are assigned
         * 'list-group-item-success'    for giving the default bootstrap green
         * 'unhighlighted'              is assigned as a placeholder for unhighlighted items
         */
        var highlight= {
            highlighted: 'list-group-item-success',
            unhighlighted: 'unhighlighted'
        };

        var newsApiURL = 'newsapi.php';

        /**
         * 'currNews'
         * keeps track of the content of
         * the highlighted news to display in 'edit-area'
         */
        $scope.currNews = "";

        /**
         * 'initReq'
         * is a request json for getting all news items
         */
        var initReq = {
            method: 'POST',
            url: newsApiURL,
            data: { "query": "GET_ALL_NEWS" }
        };

        var updateReq = {
            method: 'POST',
            url: newsApiURL,
            data: { "query": "UPDATE_NEWS" }
        };

        var deleteReq = {
            method: 'POST',
            url: newsApiURL,
            data: { "query": "DELETE_NEWS" }
        };

        var addReq = {
            method: 'POST',
            url: newsApiURL,
            data: {
                "query": "ADD_NEWS"
            }
        };

        /**
         * 'prevhighlighted' - for keeping track of which news item
         *                  to highlight between ajax requests
         */
        var prevHighlighted = 0;

        /**
         * 'initialize' - function to run for each ajax request
         *                to refresh the news list
         */
        var initialize = function () {
            $scope.numToAdd = 1;
            $http(initReq).then(function (result) {
                $scope.news = result.data;
                if (prevHighlighted >= $scope.news.length) {
                    prevHighlighted = $scope.news.length - 1;
                }
                if($scope.news.length) {
                    for (i = 0; i < $scope.news.length; i++) {
                        $scope.news[i].isHighlighted = highlight.unhighlighted;
                        $scope.news[i].isChecked = false;
                    }
                    $scope.news[prevHighlighted].isHighlighted = highlight.highlighted;
                    $scope.currNews = $scope.news[prevHighlighted].news;
                    $("#edit-area").focus();
                }
            });
        };

        /* call 'initialize' function once while loading */
        initialize();

        /**
         * 'getHighlightedNews()'
         * @return the news item that is Highlighted
         */
        var getHighlightedNews = function () {
            for (i = 0; i < $scope.news.length; i++) {
                if ($scope.news[i].isHighlighted == highlight.highlighted) {
                    return $scope.news[i];
                }
            }
        };

        /**
         * getCheckedNewsItems()
         * returns an array of ids of the checked items
         * @returns {Array} - array of ids of checked items
         */
        var getCheckedNewsItems = function(){
            var checkedItems = [];
            for (i = 0; i < $scope.news.length; i++) {
                if ($scope.news[i].isChecked == true) {
                    checkedItems.push($scope.news[i].id);
                }
            }
            return checkedItems;
        }
        /**
         * 'highlightNews( newsToHighlight)' - unhighlights the
         * previously highlighted item and highlights the item
         * passed as argument
         * @param newsToHighlight
         */
        $scope.highlightNews = function (n) {
            var newsObj = getHighlightedNews();
            newsObj.isHighlighted = highlight.unhighlighted;
            n.isHighlighted = highlight.highlighted;
            $scope.currNews = n.news;
            $('#edit-area').focus();
        };

        /**
         * 'updateNewsItem( stringToUpdateWith )' - updates the
         * content of currently highlighted item with the provided
         * string
         * @param stringToUpdateWith
         */
        $scope.updateNewsItem = function (stringToUpdateWith) {
            var newsObj = getHighlightedNews();
            prevHighlighted = $scope.news.indexOf(newsObj);

            updateReq.data.id = newsObj.id;
            updateReq.data.newNews = stringToUpdateWith;

            $http(updateReq).then(function (result) {
                if (result.data.success) {
                    initialize();
                }
            });
        };

        /**
         * 'deleteNewsItems( )' - deletes all checked news items
         */
        $scope.deleteNewsItems = function () {
            var checkedItems = getCheckedNewsItems();
            prevHighlighted = checkedItems[0];
            deleteReq.data.ids = checkedItems;
            console.log(checkedItems);
            $http(deleteReq).then(function (result) {
                if (result.data.success) {
                    initialize();
                }
            });
        };

        /**
         * 'addNews( )' - add a news item with a default prompt string
         * and highlighting the newly added item to facilitate easy edit
         */
        $scope.addNews = function ( numberOfItems ) {
            /**
             * highlighting the newly added item by setting 'prevHighlighted'
             * to one beyond the last element
             */
            prevHighlighted = $scope.news.length;

            addReq.data.numberOfItems = numberOfItems;

            $http(addReq).then(function (result) {
                if (result.data.success)
                    initialize();
            });
        };
    });
