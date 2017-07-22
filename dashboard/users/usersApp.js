/**
 * Created by Sankkara Narayanan on 17-Jul-17.
 */
if (window.File && window.FileReader && window.FileList && window.Blob) {
    // Great success! All the File APIs are supported.
} else {
    alert('The File APIs are not fully supported in this browser.');
}
var content = {};

var handleFileSelect = function (event) {
    $("#load-data-btn").html("Wait...");
    var file = event.target.files[0];
    if (!file) {
        alert("Failed to load file");
    } else {
        var reader = new FileReader();
        reader.onload = function () {

            //TODO source : https://sheetjs.gitbooks.io/docs
            // check if the current code is cross browser compatible
            var workbook = XLSX.read(reader.result, {type: 'binary'});
            content = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
            $("#load-data-btn").html("Load File");
            $("#load-data-btn").prop("disabled", false);
        }
        reader.readAsBinaryString(file);

    }
};

var app = angular.module('usersApp', ['ngAnimate']);
app.controller('usersControl', function ($scope, $http) {

    $scope.uploading = false;
    $scope.usersTable = {};

    var usersApiURL = 'usersapi.php';
    var updateReq = {
        method: 'POST',
        url: usersApiURL,
        data: {"query": "UPDATE_USERS"}
    };

    var deleteReq = {
        method: 'POST',
        url: usersApiURL,
        data: {"query": "DELETE_USERS"}
    };

    var addReq = {
        method: 'POST',
        url: usersApiURL,
        data: {"query": "ADD_USERS"}
    };

    $scope.loadData = function (event) {
        let objectKeysToLowerCase = function (origObj) {
            return Object.keys(origObj).reduce(function (newObj, key) {
                let val = origObj[key];
                let newVal = (typeof val === 'object') ? objectKeysToLowerCase(val) : val;
                newObj[key.toLowerCase()] = newVal;
                return newObj;
            }, {});
        };

        content = objectKeysToLowerCase(content);
        $scope.usersTable.data = content;
        var keys = Object.keys(content[0]);
        if (keys.length === 2 && keys[0] === "id" && keys[1] === "name") {
            $scope.usersTable.keys = keys;
            $scope.usersTable.numberOfRecords = Object.keys($scope.usersTable.data).length;
            console.log($scope.usersTable.data);
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
});
