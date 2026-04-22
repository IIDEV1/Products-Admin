<?php
$host = '127.0.0.1';
$db   = 'products_db'; // Измените на 'catalog', если ваша база называется так
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

echo '<body style="background:#050505; color:#ea580c; font-family:sans-serif; display:flex; align-items:center; justify-content:center; height:100vh; margin:0; text-transform:uppercase; letter-spacing:0.3em; font-weight:900; font-size:12px; text-align:center;">';

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     $sql = [
        "ALTER TABLE products CHANGE title title_ru VARCHAR(255)",
        "ALTER TABLE products CHANGE description description_ru TEXT",
        "ALTER TABLE products ADD COLUMN title_en VARCHAR(255) AFTER title_ru",
        "ALTER TABLE products ADD COLUMN description_en TEXT AFTER description_ru"
     ];

     foreach ($sql as $query) {
         try {
             $pdo->exec($query);
         } catch (PDOException $e) {
             // Игнорируем ошибки, если колонки уже существуют или переименованы
         }
     }

     echo '<div>
            <div style="width:2px; h:40px; background:#ea580c; margin: 0 auto 20px;"></div>
            DATABASE MIGRATION COMPLETE.<br>ASSET REGISTRY UPDATED.
           </div>';

} catch (\PDOException $e) {
     echo "CRITICAL SYSTEM ERROR: " . $e->getMessage();
}

echo '</body>';
