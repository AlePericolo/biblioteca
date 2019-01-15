
var app = angular.module('biblioApp', []);

app.controller('bibliotecaController', ['$scope', '$http', function ($scope, $http) {

    var url = window.location.href;
    var handler = url.split("biblioteca.html");

    $scope.showFilters = false;

    //first function
    $scope.init = function(){
        $scope.caricaDati();
    };

    $scope.caricaDati = function () {
        $http.post(handler[0] + "/controller/bibliotecaHandler.php",
            {'function': 'caricaDati'}
        ).then(function (data) {
            console.log(data.data);
            $scope.categorie = data.data.categorie;
            $scope.sottocategorie = data.data.sottocategorie;
            $scope.testi = data.data.testi;
        });
    };

    $scope.getDettagliTesto = function (idTesto) {
        console.log(idTesto);
    }

}]);