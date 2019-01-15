
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
        $http.post(handler[0] + "/controller/bibliotecaHandler.php",
            {'function': 'getDettagliTesto','idTesto': idTesto}
        ).then(function (data) {
            console.log(data.data);
            $scope.testo = data.data.testo;
        });
    };

    $scope.salvaTesto = function () {
        console.log($scope.testo);

        if($scope.testo.numero_copie === ''){
            $scope.testo.numero_copie = 1;
        }

        $http.post(handler[0] + "/controller/bibliotecaHandler.php",
            {'function': 'salvaTesto','testo': $scope.testo}
        ).then(function (data) {
            console.log(data.data);
            if(data.data.response === "OK"){
                swal({
                        title: "Testo salvato correttamente!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: "OK"
                    },
                    function(isConfirm){
                        if (isConfirm){
                            $scope.aggiornaElencoTesti();
                        }
                    });
            }else{
                swal({
                        title: "Errore salvataggio!",
                        text: data.data.message,
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "OK"
                    },
                    function(isConfirm){
                        if (isConfirm){
                            $scope.aggiornaElencoTesti();
                        }
                    });
            }
        });
    };

    $scope.eliminaTesto = function (idTesto) {
        console.log(idTesto);
        swal({
                title: "Sei sicuro di eliminare il testo?",
                text: "Non sarà più presente nella biblioteca",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No, annulla",
                confirmButtonText: "Si, cancella"
            },
            function(isConfirm){
                if (isConfirm){
                    $http.post(handler[0] + "/controller/bibliotecaHandler.php",
                        {'function': 'eliminaTesto','idTesto': idTesto}
                    ).then(function (data) {
                        console.log(data.data);
                        if(data.data.response === "OK"){
                            $scope.aggiornaElencoTesti();
                        }else{
                            swal("Errore eliminazione!", data.data.message, "warning");
                        }
                    });
                }
            });
    };

    $scope.aggiornaElencoTesti = function () {
        $http.post(handler[0] + "/controller/bibliotecaHandler.php",
            {'function': 'aggiornaElencoTesti'}
        ).then(function (data) {
            console.log(data.data);
            $scope.testi = data.data.testi;
        });
    };

    $scope.scaricaPDF = function (testi) {
        console.log("aaa");
        console.log(testi);
    }

}]);