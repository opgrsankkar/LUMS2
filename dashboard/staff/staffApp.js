/**
 * Created by Sankkara Narayanan on 01-Aug-17.
 */

let app = angular.module('staffApp', ['ngAnimate']);
app.controller('staffController', function ($scope, $http) {
    $scope.staffTable = {};
    $scope.usernameExists = false;

    let staffApiURL = 'staffapi.php';

    let initReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "GET_ALL_STAFF"}
    };

    let addReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "ADD_STAFF"}
    };

    let editReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "EDIT_STAFF"}
    };

    let deleteReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "DELETE_STAFF"}
    };

    /**
     * 'initialize' - function to run for each ajax request
     *                to refresh the news list
     */
    let initialize = function () {
        $http(initReq).then(function (result) {
            $scope.staffTable.data = result.data;
        });
    };

    /* call 'initialize' function once while loading */
    initialize();

    $scope.checkUsernameExists = function () {
        initialize();
        let username = $scope.newStaff.username;
        let usernameFlag = false;
        for (let i = 0; i < $scope.staffTable.data.length; i++) {
            if (username === $scope.staffTable.data[i].username) {
                usernameFlag = true;
            }
        }
        $scope.usernameExists = usernameFlag;
        if (usernameFlag) {
            $("input#username").parent().addClass('has-error');
        } else {
            $("input#username").parent().removeClass('has-error');
        }
    };

    $scope.addStaff = function () {

        if ($scope.newStaff.username === null || $scope.newStaff.username === "" ||
            $scope.newStaff.fullName === null || $scope.newStaff.fullName === "" ||
            $scope.newStaff.password === null || $scope.newStaff.password === "" ||
            $scope.newStaff.permission === null || $scope.newStaff.permission === "") {
            sweetAlert("Please Ensure all fields are filled appropriately");
        } else {
            $scope.checkUsernameExists();

            addReq.data.username = $scope.newStaff.username;
            addReq.data.name = $scope.newStaff.fullName;
            addReq.data.password = $scope.newStaff.password;
            /* TODO use bcrypt to encrypt passwords */
            addReq.data.permission = $scope.newStaff.permission;

            $http(addReq).then(function (result) {
                if (result.data.success) {
                    $('#add-staff-modal').modal('hide');
                    sweetAlert("User Added");
                } else {
                    alert(result.data.error_msg);
                }
                initialize();
            });
        }

    };

    $scope.editStaffFunction = function () {
        editReq.data.username = $scope.editStaff.username;
        editReq.data.name = $scope.editStaff.fullName;
        editReq.data.permission = $scope.editStaff.permission;

        $http(editReq).then(function (result) {
            if (result.data.success) {
                $('#edit-staff-modal').modal('hide');
                sweetAlert("User Details Updated");
            } else {
                alert(result.data.error_msg);
            }
            initialize();
        });
    };

    $scope.editStaffFillModal = function (username, name, permission) {
        $scope.editStaff.username = username;
        $scope.editStaff.fullName = name;
        $scope.editStaff.permission = permission;
    };

    $scope.deleteStaff = function (username) {

        if (confirm('You are about to delete a User\nUsername: ' + username + "\n\nThis action cannot be undone\nAre you sure you want to delete?")) {
            deleteReq.data.username = username;
            $http(deleteReq).then(function (result) {
                if (result.data.success) {
                    sweetAlert("User Deleted");
                } else {
                    alert(result.data.error_msg);
                }
            });
        } else {
            // TODO User cancelled delete operation
        }

        initialize();
    };
});

app.filter('userPermissionsFilter', function () {
    return function (input) {
        if (isNaN(input) || input < 1) {
            // If the data is not a number or is less than one (thus not having a cardinal value) return it unmodified.
            return input;
        } else {

            if (input == 1) {
                return "Full";
            } else if (input == 2) {
                return "Full except staff list editing";
            } else if (input == 3) {
                return "Main Entrance";
            } else if (input == 4) {
                return "Digital Library Entrance";
            } else {
                return "UNKNOWN_PERMISSION_CODE"
            }

        }
    }
});