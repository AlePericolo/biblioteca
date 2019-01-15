<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 14/01/19
 * Time: 17.57
 */

require_once '../../conf/conf.php';
require_once '../../src/lib/pdo.php';
require_once '../../src/lib/functions.php';

require_once '../../src/model/Categoria.php';
require_once '../../src/model/Sottocategoria.php';
require_once '../../src/model/Testo.php';

function caricaDati($request){

    $result = array();

    $pdo = connettiPdo();
    $categoria =  new Categoria($pdo);
    $sottocategoria =  new Sottocategoria($pdo);
    $testo =  new Testo($pdo);

    $result['categorie'] = $categoria->findAll(false, Categoria::FETCH_KEYARRAY);
    $result['sottocategorie'] = $sottocategoria->findAll(false, Sottocategoria::FETCH_KEYARRAY);
    $result['testi'] = $testo->findAlldescCatSott(Testo::FETCH_KEYARRAY);

    return json_encode($result);
}

ob_start();
session_start();
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$function = $request->function;
$r = $function($request);
echo $r;