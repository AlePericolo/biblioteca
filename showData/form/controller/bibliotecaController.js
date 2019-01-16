
var app = angular.module('biblioApp', ['ngSanitize', 'ngCsv']);

app.controller('bibliotecaController', ['$scope', '$http', function ($scope, $http) {

    var url = window.location.href;
    var handler = url.split("biblioteca.html");

    $scope.caricamentoCompletato = false;
    $scope.showFilters = false;
    $scope.fileName = "BiblioteCAT";

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
        }).then(function () {
            $scope.caricamentoCompletato = true;
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
                            $scope.caricamentoCompletato = false;
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
                            $scope.caricamentoCompletato = false;
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
                            $scope.caricamentoCompletato = false;
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
        }).then(function () {
            $scope.caricamentoCompletato = true;
        });
    };

    $scope.scaricaPDF = function (testi) {
        console.log(testi);
        var doc = new jsPDF('L');
        var header = function (data) {
            doc.setFontSize(12);
            doc.text("Biblioteca di Alessandra Salvoldi", 5, 7);
        };
        doc.autoTable({
            head: $scope.getHeaderTable(),
            body: $scope.creaFileDaScaricare(testi),
            pageBreak: 'avoid',
            tableWidth: 290,
            margin:{left: 5, top: 10, right: 5, bottom: 5},
            beforePageContent: header,
            styles: {
                cellPadding: 1,
                fontSize: 10,
                overflow: 'linebreak'
            },
            columnStyles: {
                0: {columnWidth: 'auto'},
                1: {columnWidth: 'auto'},
                2: {columnWidth: 80},
                3: {columnWidth: 60},
                4: {columnWidth: 'auto'},
                5: {columnWidth: 'auto'},
                6: {columnWidth: 'auto'},
                7: {columnWidth: 'auto'}
            }
        });
        doc.save($scope.fileName + '.pdf');
    };

    $scope.getHeaderTable = function () {return [["CAT", "SOTT", "Titolo", "Autore", "Editore", "Anno", "N°copie"]];};

    $scope.creaFileDaScaricare = function(data){
        $scope.fileExport = new Array();
        for(i=0; i<data.length; i++){
            app = new Array();
            app.push(data[i].codice_categoria);
            app.push(data[i].codice_sottocategoria);
            app.push(data[i].titolo);
            app.push(data[i].autore);
            app.push(data[i].editore != null ? data[i].editore : '');
            app.push(data[i].anno_pubblicazione != null ? data[i].anno_pubblicazione : '');
            app.push(data[i].numero_copie);
            $scope.fileExport.push(app);
        }
        return $scope.fileExport;
    };

}]);