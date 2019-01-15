<?php
/**
* Developed by: Alessandro Pericolo
* Date: 15/01/2019
* Time: 09:23
* Version: 0.1
**/

require_once 'TestoModel.php';

class Testo extends TestoModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

public function findAlldescCatSott($typeResult = self::FETCH_OBJ)
{
    $query = "select testo.*, categoria.descrizione as cat_desc, sottocategoria.descrizione as sott_desc
                from testo
                inner join categoria on testo.codice_categoria = categoria.codice
                inner join sottocategoria on testo.codice_sottocategoria = sottocategoria.codice";

    return $this->createResultArray($query, null, $typeResult);
}

} //close Class Testo