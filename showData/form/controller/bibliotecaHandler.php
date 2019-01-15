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

    //error_log('caricaDati');
    $result = array();

    $pdo = connettiPdo();
    $categoria =  new Categoria($pdo);
    $sottocategoria =  new Sottocategoria($pdo);
    $testo =  new Testo($pdo);

    $result['categorie'] = $categoria->findCategorie(Categoria::FETCH_KEYARRAY);
    $result['sottocategorie'] = $sottocategoria->findSottocategorie(Sottocategoria::FETCH_KEYARRAY);
    $result['testi'] = $testo->findAlldescCatSott(Testo::FETCH_KEYARRAY);

    return json_encode($result);
}

function getDettagliTesto($request){

    //error_log('getDettagliTesto');
    $result = array();

    $pdo = connettiPdo();

    $testo =  new Testo($pdo);
    if($request->idTesto != -1)
        $result['testo'] = $testo->findByPk($request->idTesto, Testo::FETCH_KEYARRAY);
    else
        $result['testo'] = $testo->getEmptyKeyArray();

    return json_encode($result);
}

function salvaTesto($request){

    //error_log('salvaTesto');
    $result = array();

    $pdo = connettiPdo();

    try{
        $pdo->beginTransaction();
        $testo = new Testo($pdo);
        $testo->creaObjJson($request->testo, true);
        $testo->saveOrUpdate();
        $pdo->commit();
        $result['response'] = 'OK';
    }catch (PDOException $e){
        $pdo->rollBack();
        $result['response'] = 'KO';
        $result['message'] = $e->getMessage();
    }

    return json_encode($result);
}

function eliminaTesto($request){

    //error_log('eliminaTesto');
    $result = array();

    $pdo = connettiPdo();

    try{
        $pdo->beginTransaction();
        $testo = new Testo($pdo);
        $testo->deleteByPk($request->idTesto);
        $testo->saveOrUpdate();
        $pdo->commit();
        $result['response'] = 'OK';
    }catch (PDOException $e){
        $pdo->rollBack();
        $result['response'] = 'KO';
        $result['message'] = $e->getMessage();
    }

    return json_encode($result);
}

ob_start();
session_start();
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$function = $request->function;
$r = $function($request);
echo $r;