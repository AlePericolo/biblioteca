<?php
/**
* Developed by: Alessandro Pericolo
* Date: 14/01/2019
* Time: 17:34
* Version: 0.1
**/

require_once 'SottocategoriaModel.php';

class Sottocategoria extends SottocategoriaModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

} //close Class Sottocategoria