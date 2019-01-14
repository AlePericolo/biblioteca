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
        if codice in [0,100,200,300,400,500,600,700,800,900]:
            descrizioneCategoria = getDescrizioneCategoria(l)
            if len(descrizioneCategoria)>0:
                db.writeCategoria(str(codice), descrizioneCategoria)
            if codice > getCategoriaCode():
                updateCategoria(codice)
        if codice not in [0,100,200,300,400,500,600,700,800,900] and codice != -1:
            descrizioneSottocategoria = getDescrizioneSottocategoria(codice, l)
            if len(descrizioneSottocategoria)>0:
                db.writeSottocategoria(str(getCategoriaCode()), str(codice), descrizioneSottocategoria)
            if codice > getSottocategoriaCode():
                updateSottocategoria(codice)
        if codice == -1:
            autore = ""
            titolo = l
            try:
                app = l.split(",",1)
                autore = re.sub(r'[^\x00-\x7F]+',' ', app[0].strip().replace("\n",""))
                titolo = re.sub(r'[^\x00-\x7F]+',' ', app[1].strip().replace("\n",""))
            except Exception:
                pass
            numero_copie = 1
            try:
                numero_copie = int(titolo[titolo.find("(")+1 : titolo.find(")")])
            except Exception:
                pass
            db.writeTesto(str(getCategoriaCode()), str(getSottocategoriaCode()), autore, titolo, str(numero_copie))

def getCode(s):
    code = -1
    try:
        code = int(s.decode('utf-8').strip().replace(" ", "")[1:4])
    except:
        pass
    try:
        code = int(s.decode('utf-8').strip().replace(" ","")[:3])
    except:
        pass
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
