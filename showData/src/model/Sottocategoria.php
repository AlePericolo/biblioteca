<?php
/**
* Developed by: Alessandro Pericolo
* Date: 15/01/2019
* Time: 09:23
* Version: 0.1
**/

require_once 'SottocategoriaModel.php';

class Sottocategoria extends SottocategoriaModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    public function findSottocategorie($typeResult = self::FETCH_OBJ)
    {
        $query = "select codice_categoria, codice, concat(codice,' - ',descrizione) as descrizione from biblioteca.sottocategoria";

        return $this->createResultArray($query, null, $typeResult);
    }

} //close Class Sottocategoria