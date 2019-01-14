import MySQLdb

class Database:

    def __init__(self):
        self.connection = MySQLdb.connect("127.0.0.1", "root", "Password14!", "biblioteca")
        self.cursor = self.connection.cursor()

    # insert categoria ----------------------------------------------------------------------------------------------------

    def writeCategoria(self, codice, descrizione):

        try:
            query_insert = "insert into categoria (codice, descrizione) values (%s,%s)"

            #inserisco nuova categoria
            self.cursor.execute(query_insert,(codice, descrizione.strip()))
            self.connection.commit()
            return "OK"
        except Exception, e:
            self.connection.rollback()
            return 'Errore Insert Categoria ' + str(e)

    # insert sottocategoria ----------------------------------------------------------------------------------------------------

    def writeSottocategoria(self, codiceCategoria, codice, descrizione):

        try:
            query_insert = "insert into sottocategoria (codice_categoria, codice, descrizione) values (%s,%s,%s)"

            #inserisco nuova sottocategoria
            self.cursor.execute(query_insert,(codiceCategoria, codice, descrizione.strip()))
            self.connection.commit()
            return "OK"
        except Exception, e:
            self.connection.rollback()
            return 'Errore Insert Sottocategoria ' + str(e)

    # insert testo ----------------------------------------------------------------------------------------------------

    def writeTesto(self, codiceCategoria, codiceSottocategoria, autore, titolo, numero_copie):

        try:
            query_insert = "insert into testo (codice_categoria, codice_sottocategoria, autore, titolo, numero_copie) values (%s,%s,%s,%s,%s)"

            #inserisco nuovo testo
            self.cursor.execute(query_insert,(codiceCategoria, codiceSottocategoria, autore, titolo, numero_copie))
            self.connection.commit()
            return "OK"
        except Exception, e:
            self.connection.rollback()
            return 'Error Insert Testo: ' + str(e)

    # truncate table ---------------------------------------------------------------------------------------------------

    def clearTable(self, tableName):
        try:
            query_truncate ="TRUNCATE TABLE %s" %(tableName)
            self.cursor.execute(query_truncate)
            return "Tabella " + tableName + " svuotata"
        except ValueError:
            self.connection.rollback()
            return 'Error Truncate table: ' + tableName

    # count records ----------------------------------------------------------------------------------------------------

    def countRecord(self, tableName):
        try:
            query_count ="SELECT count(id) FROM %s" %(tableName)
            self.cursor.execute(query_count)
            (number_of_rows,) = self.cursor.fetchone()
            return str(number_of_rows) + " Contatti registrati in " + tableName
        except ValueError:
            self.connection.rollback()
            return 'Error query count'

    #-------------------------------------------------------------------------------------------------------------------

    def __del__(self):
        self.connection.close()