-- Datenbanktabelle für Todos
CREATE TABLE Todo (
    id VARCHAR(30) PRIMARY KEY,
    bezeichnung VARCHAR(255) NOT NULL, 
    faelligkeit DATE NOT NULL,
    status INT(1) NOt NULL 
);
