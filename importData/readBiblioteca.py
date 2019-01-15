import re
from db import Database

currentCatCode = 0
currentSottCode = 10

def getCategoriaCode():
  return currentCatCode

def updateCategoria(c):
  global currentCatCode
  currentCatCode = c
  return currentCatCode

def getSottocategoriaCode():
  return currentSottCode

def updateSottocategoria(s):
  global currentSottCode
  currentSottCode = s
  return currentSottCode

#-----------------------------------------------------------------------------------------------------------------------

def readFile(filename):
    with open(filename) as f:
        lines = f.readlines()
        for l in lines:
            checkLine(l)
        print 'THE END'

def checkLine(l):
    if len(l.decode('utf-8').strip().replace(" ", "")) > 0:
        db = Database.Database()
        codice = getCode(l)
        if codice in ["000","100","200","300","400","500","600","700","800","900"]:
            descrizioneCategoria = getDescrizioneCategoria(l)
            if len(descrizioneCategoria)>0:
                db.writeCategoria(codice, descrizioneCategoria)
            if codice > getCategoriaCode():
                updateCategoria(codice)
        if codice not in ["000","100","200","300","400","500","600","700","800","900"] and codice != None:
            descrizioneSottocategoria = getDescrizioneSottocategoria(codice, l)
            if len(descrizioneSottocategoria)>0:
                db.writeSottocategoria(str(getCategoriaCode()), codice, descrizioneSottocategoria)
            if codice > getSottocategoriaCode():
                updateSottocategoria(codice)
        if codice == None:
            autore = ""
            titolo = l.replace("\n","").decode('utf-8').strip()
            try:
                app = l.split(",",1)
                autore = app[0].strip().decode('utf-8').strip()
                titolo = app[1].strip().replace("\n","").decode('utf-8').strip()
            except Exception:
                pass
            numero_copie = 1
            try:
                numero_copie = int(titolo[titolo.find("(")+1 : titolo.find(")")])
            except Exception:
                pass
            db.writeTesto(str(getCategoriaCode()), str(getSottocategoriaCode()), autore, titolo, str(numero_copie))

def getCode(s):
    code = None
    #recupero il codice (cifre 1-4 o 0-3) e lo formatto a int
    try:
        code = int(s.decode('utf-8').strip().replace(" ", "")[1:4])
    except:
        pass
    try:
        code = int(s.decode('utf-8').strip().replace(" ","")[:3])
    except:
        pass
    #non trovo un codice -> testo
    if code != None:
        #se codice 0 lo trasformo in "OOO" (1 categoria)
        if code == 0:
            return "000"
        #se codice < 10 (10,20,30,40,50,60,70,80,90) trasformo in string concatenando "0" davanti (sottocategorie 1 categoria)
        elif code < 100:
            return "0"+str(code)
        #altrimenti formatto l'int a 3 cifre a stringa (mi serve nel php)
        else:
            return str(code)
    else:
        #ritorno None -> testo
        return code

def getDescrizioneCategoria(l):
    desc = ""
    try:
        app = l.split("-")
        desc = re.sub(r'[^\x00-\x7F]+',' ', app[1].strip().replace("\n",""))
    except Exception:
        pass
    return desc

def getDescrizioneSottocategoria(codice, l):
    desc = ""
    try:
        app = l.split(str(codice))
        desc = re.sub(r'[^\x00-\x7F]+',' ', app[1].strip().replace("\n",""))
    except Exception:
        pass
    return desc


#run--------------------------------------------------------------------------------------------------------------------
readFile('file/biblioteca.txt')
