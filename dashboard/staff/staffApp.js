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
    let editPassReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "EDIT_PASS"}
    }

    let generateRandomPassword = function () {
        let alphabets = ("abcdefghijklmnopqrstuvwxyz").split("");
        let numbers = ("1234567890").split("");
        let ran = "";
        for (let i = 0; i < 4; i++) {
            ran = ran + alphabets[Math.ceil(Math.random() * 26)];
        }
        for (let i = 0; i < 2; i++) {
            ran = ran + numbers[Math.ceil(Math.random() * 10)];
        }
        return ran;
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
            addReq.data.permission = $scope.newStaff.permission;

            $http(addReq).then(function (result) {
                if (result.data.success) {

                    sweetAlert("User Added");
                    initialize();
                    $('#add-staff-modal').modal('hide');
                    $('#add-staff-form').trigger("reset");

                } else {
                    alert(result.data.error_msg);
                }

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

    $scope.refreshStaffTable = function () {
        initialize();
    }

    $scope.deleteStaff = function (username) {

        swal({
                title: "Are you sure you want to delete?",
                text: "You are about to delete a User\nUsername: " + username + "\n\nThis action cannot be undone",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                deleteReq.data.username = username;
                $http(deleteReq).then(function (result) {
                    if (result.data.success) {
                        swal("Deleted!", "User has been deleted.", "success")
                    } else {
                        alert(result.data.error_msg);
                    }
                    initialize();


                });

            });
    };

    $scope.resetPassword = function (username) {
        swal({
                title: "Are you sure you want to Reset?",
                text: "You are about to rest the password of <h3>Username: <lead>" + username + "</lead></h3>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#03d034",
                confirmButtonText: "Yes, Reset it!",
                closeOnConfirm: false,
                html: true
            },
            function () {
                let newPassword = generateRandomPassword();
                editPassReq.data.username = username;
                editPassReq.data.password = newPassword;
                $http(editPassReq).then(function (result) {
                    if (result.data.success) {
                        swal({
                            title: "Password has been Reset",
                            text: "New Password <h3>" + newPassword + "</h3> Please make a note of it",
                            html: true
                        });
                    } else {
                        swal(result.data.error_msg);
                    }
                    initialize();


                });

            });
    }
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