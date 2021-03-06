
App.factory('Application', function($http, Url, DataLoader) {

    var factory = {};

    factory.loadListData = function() {
        return $http({
            method: 'GET',
            url: Url.get("application/backoffice_list/load"),
            cache: true,
            responseType:'json'
        });
    };
    factory.loadViewData = function() {
        return $http({
            method: 'GET',
            url: Url.get("application/backoffice_view/load"),
            cache: true,
            responseType:'json'
        });
    };

    factory.loadEditData = function() {
        return $http({
            method: 'GET',
            url: Url.get("application/backoffice_view_acl/load"),
            cache: true,
            responseType:'json'
        });
    };

    factory.findAll = function() {
        return new DataLoader().sequencedLoading("application/backoffice_list/findall");
    };

    factory.findByAdmin = function(admin_id) {

        return $http({
            method: 'GET',
            url: Url.get("application/backoffice_list/findbyadmin", {admin_id: admin_id}),
            cache: false,
            responseType:'json'
        });
    };

    factory.find = function(app_id) {

        return $http({
            method: 'GET',
            url: Url.get("application/backoffice_view/find", {app_id: app_id}),
            cache: false,
            responseType:'json'
        });
    };

    factory.saveInfo = function(application) {

        return $http({
            method: 'POST',
            data: application,
            url: Url.get("application/backoffice_view/save"),
            responseType:'json'
        });
    };

    factory.downloadAndroidApk = function(app_id) {

        var link = Url.get("application/backoffice_view/downloadsource", {device_id: 2, app_id: app_id, type: "apk"});

        return $http({
            method: 'GET',
            url: link,
            responseType:'json'
        });
    };

    factory.saveDeviceInfo = function(application) {

        return $http({
            method: 'POST',
            data: application,
            url: Url.get("application/backoffice_view/savedevice"),
            responseType:'json'
        });
    };

    factory.findAdminAccess = function(params) {
        return $http({
            method: 'POST',
            data: params,
            url: Url.get("application/backoffice_view_acl/findaccess"),
            cache: false,
            responseType:'json'
        });
    };

    factory.setCanAddPage = function(params) {
        return $http({
            method: 'POST',
            data: params,
            url: Url.get("application/backoffice_view_acl/setaddpage"),
            cache: false,
            responseType:'json'
        });
    };

    factory.saveAccess = function(params) {
        return $http({
            method: 'POST',
            data: params,
            url: Url.get("application/backoffice_view_acl/saveaccess"),
            cache: false,
            responseType:'json'
        });
    };

    factory.saveBannerInfo = function(application) {

        return $http({
            method: 'POST',
            data: application,
            url: Url.get("application/backoffice_view/savebanner"),
            responseType:'json'
        });
    };

    return factory;
});
