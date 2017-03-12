# FaceTeacher
Neste exemplo criei um sistema de likes em fotos usando o php e o bancos de dado NoSql Cassandra.

###Modelagem
####Criação do keyspace:
```
CREATE KEYSPACE test WITH REPLICATION = 
{ 'class' : 'SimpleStrategy', 'replication_factor' : 1 };
```
####Criação das ColumnFamily:
```
CREATE TABLE teachers (
    id uuid,
    name text,
    img text,
    PRIMARY KEY (id)
);
```
```
CREATE TABLE like (
    teacher uuid,
    date timestamp,
    PRIMARY KEY (teacher, date)
);
```
```
CREATE TABLE unlike (
    teacher uuid,
    date timestamp,
    PRIMARY KEY (teacher, date)
);
```

##Instalação Cassandara
Não ha muita dificuldade nesse ponto, basta consultar a documentação no site oficial: http://cassandra.apache.org/download/
##DriverPHP
Passo-a-passo para instalação do driver de conexão com o cassandra: https://github.com/datastax/php-driver (existem outros, como o PHPCassa - que foi descontinuado). 
Poderá ter alguns probelmas com a distribuição do SO, sendo necessário complilar o driver.
