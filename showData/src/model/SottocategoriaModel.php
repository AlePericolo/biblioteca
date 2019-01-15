<?php
/**
* Developed by: Alessandro Pericolo
* Date: 15/01/2019
* Time: 09:23
* Version: 0.1
**/

require_once 'AbstractModel.php';

class SottocategoriaModel extends AbstractModel {

/** @var integer PrimaryKey */
protected $id;
/** @var string */
protected $codice_categoria;
/** @var string */
protected $codice;
/** @var string */
protected $descrizione;

/* CONSTRUCTOR ------------------------------------------------------------------------------------------------------ */

//constructor
function __construct($pdo){
	parent::__construct($pdo);
	$this->tableName = "sottocategoria";
}

/* FUNCTIONS -------------------------------------------------------------------------------------------------------- */

/** 
* find by PrimaryKey: 
* @return Sottocategoria|array|string|null
**/
public function findByPk($id, $typeResult = self::FETCH_OBJ){
	$query = "SELECT * FROM $this->tableName USE INDEX(PRIMARY) WHERE ID=?";
	return $this->createResult($query, array($id), $typeResult);
}

/** 
* delete by PrimaryKey: 
**/
public function deleteByPk($id){
	$query = "DELETE FROM $this->tableName WHERE ID=?";
	return $this->createResultValue($query, array($id));
}

/** 
* find all record of table 
* @return Sottocategoria[]|array|string
**/
public function findAll($distinct = false, $typeResult = self::FETCH_OBJ, $limit = -1, $offset = -1){
	$distinctStr = ($distinct) ? "DISTINCT" : "";
	$query = "SELECT $distinctStr * FROM $this->tableName ";
	if ($this->whereBase) $query .= " WHERE $this->whereBase";
	if ($this->orderBase) $query .= " ORDER BY $this->orderBase";
	$query .= $this->createLimitQuery($limit, $offset);
	return $this->createResultArray($query, null, $typeResult);
}

/** 
* trasform the Object into a KeyArray 
* @return array
**/
public function createKeyArray(){
	$keyArray = array();
	if (isset($this->id)) $keyArray["id"] = $this->id;
	if (isset($this->codice_categoria)) $keyArray["codice_categoria"] = $this->codice_categoria;
	if (isset($this->codice)) $keyArray["codice"] = $this->codice;
	if (isset($this->descrizione)) $keyArray["descrizione"] = $this->descrizione;
	return $keyArray;
}

/** 
* trasform the KeyArray into a Object 
* @param array $keyArray
**/
public function createObjKeyArray(array $keyArray){
	if (isset($keyArray["id"])) $this->id = $keyArray["id"];
	if (isset($keyArray["codice_categoria"])) $this->codice_categoria = $keyArray["codice_categoria"];
	if (isset($keyArray["codice"])) $this->codice = $keyArray["codice"];
	if (isset($keyArray["descrizione"])) $this->descrizione = $keyArray["descrizione"];
}

/** 
* return the Object as an empty KeyArray 
* @return array
**/
public function getEmptyKeyArray(){
	$emptyKeyArray = array();
	$emptyKeyArray["id"] = "";
	$emptyKeyArray["codice_categoria"] = "";
	$emptyKeyArray["codice"] = "";
	$emptyKeyArray["descrizione"] = "";
	return $emptyKeyArray;
}

/** 
* return columns' list as string 
* @return string
**/
public function getListColumns(){
	return "id, codice_categoria, codice, descrizione";
}

/* CREATE TABLE ----------------------------------------------------------------------------------------------------- */

/** 
* DDL create table query 
**/
public function createTable(){
return $this->pdo->exec(
"CREATE TABLE `sottocategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codice_categoria` varchar(3) NOT NULL,
  `codice` varchar(3) NOT NULL,
  `descrizione` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_codice_cat` (`codice_categoria`),
  KEY `index_codice` (`codice`),
  CONSTRAINT `fk_categoriasottocategoria_1` FOREIGN KEY (`codice_categoria`) REFERENCES `categoria` (`codice`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1"
);
}

/* GETTER & SETTER -------------------------------------------------------------------------------------------------- */

/** 
* @return integer
**/
public function getId(){
	 return $this->id;
}

/** 
* @param integer $id
**/
public function setId($id){
	 $this->id = $id;
}

/** 
* @return string
**/
public function getCodiceCategoria(){
	 return $this->codice_categoria;
}

/** 
* @param string $codice_categoria
* @param int $encodeType
 **/
public function setCodiceCategoria($codice_categoria, $encodeType = self::STR_DEFAULT){
	 $this->codice_categoria = $this->decodeString($codice_categoria, $encodeType);
}

/** 
* @return string
**/
public function getCodice(){
	 return $this->codice;
}

/** 
* @param string $codice
* @param int $encodeType
 **/
public function setCodice($codice, $encodeType = self::STR_DEFAULT){
	 $this->codice = $this->decodeString($codice, $encodeType);
}

/** 
* @return string
**/
public function getDescrizione(){
	 return $this->descrizione;
}

/** 
* @param string $descrizione
* @param int $encodeType
 **/
public function setDescrizione($descrizione, $encodeType = self::STR_DEFAULT){
	 $this->descrizione = $this->decodeString($descrizione, $encodeType);
}


} //close Class SottocategoriaModel