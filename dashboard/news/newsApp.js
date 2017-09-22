/**
 * Created by Sankkara Narayanan on 16-Jul-17.
 */

angular.module("newsApp", ['wysiwyg.module'])
    .controller("newsControl", function ($scope, $http, $sce) {
        $scope.currCheckedOptions = {
            newItem: false,
        };
        /**
         * highlighted news items are assigned
         * 'list-group-item-success'    for giving the default bootstrap green
         * 'unHighlighted'              is assigned as a placeholder for unHighlighted items
         */
        let highlight = {
            highlighted: 'list-group-item-success',
            unHighlighted: 'unHighlighted'
        };

        let newsApiURL = '/scripts/newsapi.php';

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
        let initReq = {
            method: 'POST',
            url: newsApiURL,
            data: {"query": "GET_ALL_NEWS"}
        };

        let updateReq = {
            method: 'POST',
            url: newsApiURL,
            data: {"query": "UPDATE_NEWS"}
        };

        let deleteReq = {
            method: 'POST',
            url: newsApiURL,
            data: {"query": "DELETE_NEWS"}
        };

        let addReq = {
            method: 'POST',
            url: newsApiURL,
            data: {"query": "ADD_NEWS"}
        };

        /**
         * 'prevhighlighted' - for keeping track of which news item
         *                  to highlight between ajax requests
         */
        let prevHighlighted = 0;

        /**
         * 'initialize' - function to run for each ajax request
         *                to refresh the news list
         */
        let initialize = function () {
            $scope.numToAdd = 1;
            $http(initReq).then(function (result) {
                $scope.news = result.data;
                if (prevHighlighted >= $scope.news.length) {
                    prevHighlighted = $scope.news.length - 1;
                }
                if ($scope.news.length) {
                    for (let i = 0; i < $scope.news.length; i++) {
                        $scope.news[i].trustedNews = $sce.trustAsHtml($scope.news[i].news);
                        $scope.news[i].isHighlighted = highlight.unHighlighted;
                        $scope.news[i].isChecked = false;
                    }
                    $scope.news[prevHighlighted].isHighlighted = highlight.highlighted;
                    $scope.currNews = $scope.news[prevHighlighted].news;
                    $scope.currCheckedOptions.newItem = checkNewLabel($scope.currNews);
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
        let getHighlightedNews = function () {
            for (let i = 0; i < $scope.news.length; i++) {
                if ($scope.news[i].isHighlighted === highlight.highlighted) {
                    return $scope.news[i];
                }
            }
        };

        /**
         * getCheckedNewsItems()
         * returns an array of ids of the checked items
         * @returns {Array} - array of ids of checked items
         */
        let getCheckedNewsItems = function () {
            let checkedItems = [];
            for (let i = 0; i < $scope.news.length; i++) {
                if ($scope.news[i].isChecked === true) {
                    checkedItems.push($scope.news[i].id);
                }
            }
            return checkedItems;
        };
        let checkNewLabel = function (str) {
            return (str.search("<new></new>") !== -1);
        };
        let addNewLabel = function (str) {
            if(!checkNewLabel(str)) {
                str = "<new></new>" + str;
            }
            return str;
        };
        let removeNewLabel = function (str) {
            if(checkNewLabel(str)) {
                str = str.replace('<new></new>','');
            }
            return str;
        };
        /**
         * 'highlightNews( newsToHighlight)' - un-highlights the
         * previously highlighted item and highlights the item
         * passed as argument
         * @param n newsToHighlight
         */
        $scope.highlightNews = function (n) {
            let newsObj = getHighlightedNews();
            newsObj.isHighlighted = highlight.unHighlighted;
            n.isHighlighted = highlight.highlighted;
            $scope.currNews = n.news;
            $scope.currCheckedOptions.newItem = checkNewLabel($scope.currNews);
            $('#edit-area').focus();
        };

        /**
         * 'updateNewsItem( stringToUpdateWith )' - updates the
         * content of currently highlighted item with the provided
         * string
         * @param stringToUpdateWith
         */
        $scope.updateNewsItem = function (stringToUpdateWith) {
            let newsObj = getHighlightedNews();
            prevHighlighted = $scope.news.indexOf(newsObj);

            if($scope.currCheckedOptions.newItem) {
                stringToUpdateWith = addNewLabel(stringToUpdateWith);
            } else {
                stringToUpdateWith = removeNewLabel(stringToUpdateWith);
            }

            updateReq.data.id = newsObj.id;
            updateReq.data.newNews = stringToUpdateWith;

            $http(updateReq).then(function (result) {
                if (result.data.success) {
                    initialize();
                } else {
                    sweetAlert("ERROR\n" + result.data.error_msg);
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
                } else {
                    sweetAlert("ERROR\n" + result.data.error_msg);
                }
            });
        };

        /**
         * 'addNews( )' - add a news item with a default prompt string
         * and highlighting the newly added item to facilitate easy edit
         */
        $scope.addNews = function (numberOfItems) {
            /**
             * highlighting the newly added item by setting 'prevHighlighted'
             * to one beyond the last element
             */
            prevHighlighted = $scope.news.length;

            addReq.data.numberOfItems = numberOfItems;

            $http(addReq).then(function (result) {
                if (result.data.success) {
                    initialize();
                } else {
                    sweetAlert("ERROR\n" + result.data.error_msg);
                }
            });
        };
        $scope.customMenu = [
            ['bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript'],
            ['format-block'],
            ['font-size'],
            ['font-color', 'hilite-color'],
            ['remove-format'],
            ['ordered-list', 'unordered-list']
        ];
    });
