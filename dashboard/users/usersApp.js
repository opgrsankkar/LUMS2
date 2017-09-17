/**
 * Created by Sankkara Narayanan on 17-Jul-17.
 */
if (window.File && window.FileReader && window.FileList && window.Blob) {
    // Great success! All the File APIs are supported.
} else {
    alert('The File APIs are not fully supported in this browser.');
}
let content = {};

let handleFileSelect = function (event) {
    $("#load-data-btn").html("Wait...");
    let file = event.target.files[0];
    if (!file) {
        alert("Failed to load file");
    } else {
        let reader = new FileReader();
        reader.onload = function () {

            //source : https://sheetjs.gitbooks.io/docs
            let workbook = XLSX.read(reader.result, {type: 'binary'});
            content = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
            $("#load-data-btn").html("Load File");
            $("#load-data-btn").prop("disabled", false);
        };
        reader.readAsBinaryString(file);

    }
};

angular.module('usersApp', ['ngAnimate'])
    .controller('userAddController', function ($scope, $http) {

        $scope.uploading = false;
        $scope.usersTable = {};
        $scope.single = {};
        $scope.single.uploading = false;
        $scope.single.uploaded = false;

        let usersApiURL = '/scripts/usersapi.php';
        let updateReq = {
            method: 'POST',
            url: usersApiURL,
            data: {"query": "UPDATE_USERS"}
        };

        let deleteReq = {
            method: 'POST',
            url: usersApiURL,
            data: {"query": "DELETE_USERS"}
        };

        let addReq = {
            method: 'POST',
            url: usersApiURL,
            data: {"query": "ADD_USERS"}
        };

        $scope.loadData = function (event) {
            let objectKeysToLowerCase = function (origObj) {
                return Object.keys(origObj).reduce(function (newObj, key) {
                    let val = origObj[key];
                    newObj[key.toLowerCase()] = (typeof val === 'object') ? objectKeysToLowerCase(val) : val;
                    return newObj;
                }, {});
            };

            content = objectKeysToLowerCase(content);
            $scope.usersTable.data = content;
            let keys = Object.keys(content[0]);
            if (keys.length === 4 && keys[0] === "id" && keys[1] === "name" && keys[2] === "batch" && keys[3] === "designation") {
                $scope.usersTable.keys = keys;
                $scope.usersTable.numberOfRecords = Object.keys($scope.usersTable.data).length;
            } else {
                alert("Invalid File Format\nPlease check if your file matches the format specified in the example.xls file");
            }
            $('#load-data-btn').prop("disabled", true);
            $('#upload-data-btn').prop("disabled", false);
        };


        $scope.uploadData = function () {
            $scope.uploadComplete = false;
            $scope.uploading = true;
            addReq.data.users = $scope.usersTable.data;
            $http(addReq).then(function (result) {
                if (result.data.success) {
                    $scope.usersTable = {};
                    $scope.uploading = false;
                    $scope.uploadComplete = true;
                    $("#upload-data-btn").prop("disabled", true);
                } else {
                    alert("ERROR\n" + result.data.error_msg);
                }
            });
        };

        $scope.single.addUser = function () {
            let id = $scope.single.id;
            let name = $scope.single.fullName;
            let batch = $scope.single.batch;
            let designation = $scope.single.designation;

            if (id === "" || id === null || name === "" || name === null || batch === null || designation === null) {
                sweetAlert("Please ensure if all fields are filled appropriately");
            } else {
                $scope.single.uploading = true;
                $scope.single.uploaded = false;

                addReq.data.users = [{
                    id: id,
                    name: name,
                    batch: batch,
                    designation: designation
                }];
                $http(addReq).then(function (result) {
                    $scope.single.uploading = false;
                    if (result.data.success) {
                        $scope.single.uploaded = true;
                        $("form#single-user-add")[0].reset();
                        $("input#id-card-number").focus();
                    } else {
                        alert("ERROR\n" + result.data.error_msg);
                    }
                });
            }

        };
    });
