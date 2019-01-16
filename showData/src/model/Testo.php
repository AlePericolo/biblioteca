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

    public function findAlldescCatSott($typeResult = self::FETCH_OBJ){
        $query = "select testo.*, categoria.descrizione as cat_desc, sottocategoria.descrizione as sott_desc
                    from testo
                    inner join categoria on testo.codice_categoria = categoria.codice
                    inner join sottocategoria on testo.codice_sottocategoria = sottocategoria.codice
                    order by testo.codice_categoria, testo.codice_sottocategoria";

        return $this->createResultArray($query, null, $typeResult);
    }

    public function getNullKeyArray(){
        $emptyKeyArray = array();
        $emptyKeyArray["id"] = null;
        $emptyKeyArray["codice_categoria"] = "";
        $emptyKeyArray["codice_sottocategoria"] = "";
        $emptyKeyArray["autore"] = "";
        $emptyKeyArray["titolo"] = "";
        $emptyKeyArray["numero_copie"] = "";
        $emptyKeyArray["anno_pubblicazione"] = null;
        $emptyKeyArray["editore"] = "";
        return $emptyKeyArray;
    }

    public function getMaxId(){
        $query = "select max(id)+1 from testo";

        return $this->createResultValue($query, null);
    }

    public static function getMaxIdStatic($pdo){
        $app = new self($pdo);

        return $app->getMaxId();
    }

} //close Class Testo