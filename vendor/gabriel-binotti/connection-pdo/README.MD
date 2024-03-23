# Library to database connection using PDO

This library is for database connection in PHP using PDO.

## Require
* PHP >= 7.0
* Composer installed

## Start
The first you need install the library:
```php
// Version 1.0.0
composer require gabriel-binotti/connection-pdo
```

## Configuration .ini
After downloading, you need set the parameters in the database.ini file with your database connection data. If you prefer, you can create a new .ini file, the file is located in <strong>vendor/gabriel-binotti/database/databaseApplication/config/database.ini</strong>

```php
DB_HOST    = host
DB_NAME    = name
DB_PORT    = port
DB_USER    = username
DB_PASS    = password
DB_TYPE    = type_connection 
```
* DB_HOST => hostname or IP
* DB_NAME => name of database
* DB_PORT => number porto to connection
* DB_USER => username 
* DB_PASS => password
* DB_TYPE => type to batabase coneccetion tha value cad do(mysql, pgsql. srqsrv)


## Import

Include the autoload.php file in the header file 

```php
use GabrielBinottiDatabase\Connection;
require "vendor/autoload.php";
```

## Simple Struct
```php
try{
    Connection::init('database');
        $pdo = Connection::get();    
        // Command SQL
    Connection::close();
    
}catch(Exception $e){
    echo $e->getMessage();
}
```

* <strong>Connection::init('database'): </strong>
This method <strong>init()</strong> is called to initiate  the database connection and your parameter is the file name configured  before <strong>.ini</strong>. 

* <strong>Connection::close(): </strong>
This method should be called every time a database connection is opened.

* <strong>$pdo = Connection::get(): </strong>
The method get() return the same instance of the class every time

All code should be between <strong>try</strong> and <strong>catch</strong>

## Transactions
If you need to ensure that the transaction is successfully executed, you can initiate a transaction with the command <strong>Connection::transaction()</strong>
and after execute SQL command. To finish using the command <strong>Connection::commit()</strong> when the transaction is successfully or <strong>Connection::rollback()</strong> 
to return to the initial state.

```php
try{
    Connection::init('database');
    $pdo = Connection::get(); 
    Connection::transaction();
    // Command SQL

    Connection::commit();
    Connection::close();
    
}catch(Exception $e){
    Connection::rollback();
    echo $e->getMessage();
}
```
## What use PDO?
Above I show like to use PDO in PHP with simple examples:

### Select All
```php
$stmt = $pdo->prepare("SELECT * FROM TABELA");
$stmt->execute();
$return = $stmt->fetchAll();
```

### Select with where
```php
$stmt = $pdo->prepare("SELECT * FROM TABELA WHERE id=:id");
$stmt->bindValue(':id',1);
$stmt->execute();
$return = $stmt->fetch();
```
By default is returned a object, if you need an array you can set parameter <strong>\PDO::FETCH_ASSOC</strong> in method fetchAll() or in method fetch().

### Insert
```php
$stmt = $pdo->prepare("INSERT INTO TABELA(nome, telefone) VALUES(:nome, :telefone) ");
$stmt->bindValue(":nome", "Valor");
$stmt->bindValue(":telefone", "Valor");
$return = $stmt->execute();
```

### Update
```php
$stmt = $pdo->prepare("UPDATE TABELA SET nome=:nome WHERE id=:id");
$stmt->bindValue(":id", "Valor");
$stmt->bindValue(":nome", "Valor");
$return = $stmt->execute();
```

### Delete
```php
$stmt = $pdo->prepare("DELETE FROM TABELA WHERE id=:id");
$stmt->bindValue(":id", "Valor");
$return = $stmt->execute();
```

## bindValue VS bindParam
The simple form <strong>bindParam</strong> receives a variable like argument, not accepting direct values or functions return.
```php
$var = 1;
$stmt->bindParam(':campo', $var);
```

The <strong>bindValue()</strong> accept direct values, variables and functions return.
```php
$stmt->bindValue(':campo', 1);
$stmt->bindValue(':campo', $var);
$stmt->bindValue(':campo', $obj->getValor());
```

## Third parameter bindValue or bindParam
The third parameter is the data type, by default is string, but you can change that accord with value type.
```php
$stmt->bindValue(':campo', getValor(), PDO::PARAM_BOOL);               // reference bool value
$stmt->bindValue(':campo', getValor(), PDO::PARAM_NULL);               // reference null value
$stmt->bindValue(':campo', getValor(), PDO::PARAM_INT);                // reference int value 
$stmt->bindValue(':campo', getValor(), PDO::PARAM_STR);                // reference string value
$stmt->bindValue(':campo', getValor(), PDO::PARAM_LOB);                // reference object value to store large binary data.
```

## SQL Server
To use SQL Server you need to install the driver and configure some lines in php.ini, as shown in the example above:

* Download => https://learn.microsoft.com/pt-br/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver15

* After you need copy the files to directory ext, my example using xampp

![copiando](https://user-images.githubusercontent.com/21115766/208893219-3d91d877-12ad-4fa4-9ae2-ba97dd3d5e71.png)

* To finish edit the file php.ini
```php
// Version X86
extension=php_pdo_sqlsrv_73_ts_x86.dll
extension=php_sqlsrv_73_ts_x86.dll

// Version x64
extension=php_pdo_sqlsrv_73_ts_x64.dll
extension=php_sqlsrv_73_ts_x64.dll
```


