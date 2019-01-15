<?php
/**
* Developed by: Alessandro Pericolo
* Date: 15/01/2019
* Time: 09:23
* Version: 0.1
**/

require_once 'AbstractModel.php';

class TestoModel extends AbstractModel {

/** @var integer PrimaryKey */
protected $id;
/** @var string */
protected $codice_categoria;
/** @var string */
protected $codice_sottocategoria;
/** @var string */
protected $autore;
/** @var string */
protected $titolo;
/** @var integer */
protected $numero_copie;
/** @var DateTime */
protected $anno_pubblicazione;
/** @var string */
protected $editore;

/* CONSTRUCTOR ------------------------------------------------------------------------------------------------------ */

//constructor
function __construct($pdo){
	parent::__construct($pdo);
	$this->tableName = "testo";
}

/* FUNCTIONS -------------------------------------------------------------------------------------------------------- */

/** 
* find by PrimaryKey: 
* @return Testo|array|string|null
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
* @return Testo[]|array|string
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
	if (isset($this->codice_sottocategoria)) $keyArray["codice_sottocategoria"] = $this->codice_sottocategoria;
	if (isset($this->autore)) $keyArray["autore"] = $this->autore;
	if (isset($this->titolo)) $keyArray["titolo"] = $this->titolo;
	if (isset($this->numero_copie)) $keyArray["numero_copie"] = $this->numero_copie;
	if (isset($this->anno_pubblicazione)) $keyArray["anno_pubblicazione"] = $this->anno_pubblicazione;
	if (isset($this->editore)) $keyArray["editore"] = $this->editore;
	return $keyArray;
}

/** 
* trasform the KeyArray into a Object 
* @param array $keyArray
**/
public function createObjKeyArray(array $keyArray){
	if (isset($keyArray["id"])) $this->id = $keyArray["id"];
	if (isset($keyArray["codice_categoria"])) $this->codice_categoria = $keyArray["codice_categoria"];
	if (isset($keyArray["codice_sottocategoria"])) $this->codice_sottocategoria = $keyArray["codice_sottocategoria"];
	if (isset($keyArray["autore"])) $this->autore = $keyArray["autore"];
	if (isset($keyArray["titolo"])) $this->titolo = $keyArray["titolo"];
	if (isset($keyArray["numero_copie"])) $this->numero_copie = $keyArray["numero_copie"];
	if (isset($keyArray["anno_pubblicazione"]) && $keyArray["anno_pubblicazione"] != "") $this->anno_pubblicazione = date("Ymd", strtotime($keyArray["anno_pubblicazione"]));
	if (isset($keyArray["editore"])) $this->editore = $keyArray["editore"];
}

/** 
* return the Object as an empty KeyArray 
* @return array
**/
public function getEmptyKeyArray(){
	$emptyKeyArray = array();
	$emptyKeyArray["id"] = "";
	$emptyKeyArray["codice_categoria"] = "";
	$emptyKeyArray["codice_sottocategoria"] = "";
	$emptyKeyArray["autore"] = "";
	$emptyKeyArray["titolo"] = "";
	$emptyKeyArray["numero_copie"] = "";
	$emptyKeyArray["anno_pubblicazione"] = "";
	$emptyKeyArray["editore"] = "";
	return $emptyKeyArray;
}

/** 
* return columns' list as string 
* @return string
**/
public function getListColumns(){
	return "id, codice_categoria, codice_sottocategoria, autore, titolo, numero_copie, anno_pubblicazione, editore";
}

/* CREATE TABLE ----------------------------------------------------------------------------------------------------- */

/** 
* DDL create table query 
**/
public function createTable(){
return $this->pdo->exec(
"CREATE TABLE `testo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codice_categoria` varchar(3) NOT NULL,
  `codice_sottocategoria` varchar(3) NOT NULL,
  `autore` varchar(45) DEFAULT NULL,
  `titolo` varchar(45) DEFAULT NULL,
  `numero_copie` int(11) DEFAULT NULL,
  `anno_pubblicazione` datetime DEFAULT NULL,
  `editore` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
public function getCodiceSottocategoria(){
	 return $this->codice_sottocategoria;
}

/** 
* @param string $codice_sottocategoria
* @param int $encodeType
 **/
public function setCodiceSottocategoria($codice_sottocategoria, $encodeType = self::STR_DEFAULT){
	 $this->codice_sottocategoria = $this->decodeString($codice_sottocategoria, $encodeType);
}

/** 
* @return string
**/
public function getAutore(){
	 return $this->autore;
}

/** 
* @param string $autore
* @param int $encodeType
 **/
public function setAutore($autore, $encodeType = self::STR_DEFAULT){
	 $this->autore = $this->decodeString($autore, $encodeType);
}

/** 
* @return string
**/
public function getTitolo(){
	 return $this->titolo;
}

/** 
* @param string $titolo
* @param int $encodeType
 **/
public function setTitolo($titolo, $encodeType = self::STR_DEFAULT){
	 $this->titolo = $this->decodeString($titolo, $encodeType);
}

/** 
* @return integer
**/
public function getNumeroCopie(){
	 return $this->numero_copie;
}

/** 
* @param integer $numero_copie
**/
public function setNumeroCopie($numero_copie){
	 $this->numero_copie = $numero_copie;
}

/** 
* @return DateTime
**/
public function getAnnoPubblicazione(){
	 return $this->anno_pubblicazione;
}

/** 
* @param DateTime $anno_pubblicazione
**/
public function setAnnoPubblicazione($anno_pubblicazione){
	 $this->anno_pubblicazione = $anno_pubblicazione;
}

/** 
* @return string
**/
public function getEditore(){
	 return $this->editore;
}

/** 
* @param string $editore
* @param int $encodeType
 **/
public function setEditore($editore, $encodeType = self::STR_DEFAULT){
	 $this->editore = $this->decodeString($editore, $encodeType);
}


} //close Class TestoModel