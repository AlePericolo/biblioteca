<?php
/**
* Developed by: Alessandro Pericolo
* Date: 14/01/2019
* Time: 17:34
* Version: 0.1
**/

require_once 'CategoriaModel.php';

class Categoria extends CategoriaModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

} //close Class Categoria