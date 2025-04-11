# Comment créé la base de données

## Étape 1 :

Créé le fichier db.php dans www/controller/

## Étape 2 :

Remplire le fichier avec ca 👇.

```php
<?php
$host = ''; # ip du site 
$db   = ''; # Nom de la bdd
$user = ''; # User name du compte admin de la bdd
$pass = ''; # Mots de passe du compte admin de la bdd
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
```

## Étape 3 :

Créez une base de données en important le fichier SQL situé dans Doc/bouge-ton-paname.sql.

## Étape 4 :

Ouvrez le fichier controller/import_api.php dans votre navigateur pour importer les données de l’API dans la base de données.


### Voilà, la base de données Bouge-ton-Paname est installé !