/**
 * Created by Sankkara Narayanan on 01-Aug-17.
 */

let app = angular.module('staffApp', ['ngAnimate']);
app.controller('staffController', function ($scope, $http) {
    $scope.staffTable = {};

    let staffApiURL = '../../scripts/staffapi.php';

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
    let resetPassReq = {
        method: 'POST',
        url: staffApiURL,
        data: {"query": "RESET_PASS"}
    };

    /**
     * create a random password string with the format [\a]{4}[\d]{2}
     * @returns {string}
     */
    let generateRandomPassword = function () {
        let alphabets = ("abcdefghijklmnopqrstuvwxyz").split("");
        let numbers = ("1234567890").split("");
        let randomString = "";
        for (let i = 0; i < 4; i++) {
            randomString = randomString + alphabets[Math.ceil(Math.random() * 26)];
        }
        for (let i = 0; i < 2; i++) {
            randomString = randomString + numbers[Math.ceil(Math.random() * 10)];
        }
        return randomString;
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

    /**
     * checks if the newly input username is already in the database and
     *  - notifies the user through help-block
     *  - disables the submit button
     */
    $scope.checkUsernameExists = function () {
        initialize();
        let username = $scope.newStaff.username;
        let usernameFlag = false;
        let usernameInput = $("input#username");
        let addStaffSubmitButton = $("#add-staff-submit-button");
        for (let i = 0; i < $scope.staffTable.data.length; i++) {
            if (username === $scope.staffTable.data[i].username) {
                usernameFlag = true;
            }
        }
        if (usernameFlag) {
            usernameInput.parent().addClass('has-error');
            usernameInput.siblings(".help-block").removeClass('hidden');
            addStaffSubmitButton.prop("disabled", true);
        } else {
            usernameInput.parent().removeClass('has-error');
            usernameInput.siblings(".help-block").addClass('hidden');
            addStaffSubmitButton.prop("disabled", false);
        }
    };

    /**
     * check if all required input fields are filled.
     * if yes then send ajax request to server
     */
    $scope.addStaff = function () {
        if ($scope.newStaff.username === null || $scope.newStaff.username === "" ||
            $scope.newStaff.fullName === null || $scope.newStaff.fullName === "" ||
            $scope.newStaff.password === null || $scope.newStaff.password === "" ||
            $scope.newStaff.permission === null || $scope.newStaff.permission === "") {
            swal("Error", "Please Ensure all fields are filled appropriately", "error");
        } else {
            $scope.checkUsernameExists();

            addReq.data.username = $scope.newStaff.username;
            addReq.data.name = $scope.newStaff.fullName;
            addReq.data.password = $scope.newStaff.password;
            addReq.data.permission = $scope.newStaff.permission;

            $http(addReq).then(function (result) {
                console.log(result);
                /*
                if (result.data.success) {
                    initialize();
                    $('#add-staff-modal').modal('hide');
                    $('#add-staff-form').trigger("reset");
                    swal("User Added", "", "success");
                } else {
                    swal("Error", "Please Report to the Development Team", "error");
                    console.log("err1 add error");
                }
                */

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
                swal("Error", "Please Report to the Development Team", "error");
                console.log("err2 edit");
            }
            initialize();
        });
    };
    /**
     * Fill the input fields for the edit user form
     * @param username
     * @param name
     * @param permission
     */
    $scope.editStaffFillModal = function (username, name, permission) {
        $scope.editStaff.username = username;
        $scope.editStaff.fullName = name;
        $scope.editStaff.permission = permission;
    };

    $scope.refreshStaffTable = function () {
        initialize();
    };

    $scope.deleteStaff = function (username) {
        swal({
                title: "Are you sure you want to delete?",
                // language=HTML
                text: `You are about to delete a User<h3>Username: ${username}</h3>This action cannot be undone`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: true
            },
            function () {
                deleteReq.data.username = username;
                $http(deleteReq).then(function (result) {
                    if (result.data.success) {
                        swal("Deleted!", "User has been deleted.", "success")
                    } else {
                        swal("Error", "Please Report to the Development Team", "error");
                        console.log("err3 delete");
                    }
                    initialize();
                });

            }
        );
    };

    $scope.resetPassword = function (username) {
        swal({
                title: "Are you sure you want to Reset?",
                // language=HTML
                text: `You are about to rest the password of <h3>Username: <lead>${username}</lead></h3>`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#03d034",
                confirmButtonText: "Yes, Reset it!",
                closeOnConfirm: false,
                html: true
            },
            function () {
                let newPassword = generateRandomPassword();
                resetPassReq.data.username = username;
                resetPassReq.data.password = newPassword;
                $http(resetPassReq).then(function (result) {
                    if (result.data.success) {
                        swal({
                            title: "Password has been Reset",
                            text: "New Password <h3>" + newPassword + "</h3> Please make a note of it",
                            html: true
                        });
                    } else {
                        swal("Error", "Please Report to the Development Team", "error");
                        console.log("err4 pass reset error");
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

            if (input === '1') {
                return "Full";
            } else if (input === '2') {
                return "Full except staff list editing";
            } else if (input === '3') {
                return "Main Entrance";
            } else if (input === '4') {
                return "Digital Library Entrance";
            } else {
                return "UNKNOWN_PERMISSION_CODE"
            }

        }
    }
});