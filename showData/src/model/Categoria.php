<?php
/**
* Developed by: Alessandro Pericolo
* Date: 15/01/2019
* Time: 09:23
* Version: 0.1
**/

require_once 'CategoriaModel.php';

class Categoria extends CategoriaModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    public function findCategorie($typeResult = self::FETCH_OBJ)
    {
        $query = "select codice, concat(codice,' - ',descrizione) as descrizione from categoria";

        return $this->createResultArray($query, null, $typeResult);
    }

} //close Class Categoria