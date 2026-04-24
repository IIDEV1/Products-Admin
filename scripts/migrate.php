<?php
/**
 * Migration script for PostgreSQL (Supabase)
 * Run once to add multilingual columns if they don't exist.
 * 
 * Usage: php scripts/migrate.php
 */

require_once __DIR__ . '/../config.php';

echo "OrbitalStore Migration\n";
echo "======================\n\n";

$migrations = [
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS title_ru VARCHAR(255)",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS title_en VARCHAR(255)",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS description_ru TEXT",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS description_en TEXT",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS category_id INTEGER",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS stock INTEGER DEFAULT 0",
    "CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status)",
    "CREATE INDEX IF NOT EXISTS idx_orders_created ON orders(created_at DESC)",
    "CREATE INDEX IF NOT EXISTS idx_order_items_order ON order_items(order_id)",
    "CREATE INDEX IF NOT EXISTS idx_products_created ON products(created_at DESC)",
];

$success = 0;
$skipped = 0;

foreach ($migrations as $sql) {
    try {
        $pdo->exec($sql);
        echo "  ✓ " . substr($sql, 0, 60) . "...\n";
        $success++;
    } catch (PDOException $e) {
        echo "  ⊘ Skipped: " . $e->getMessage() . "\n";
        $skipped++;
    }
}

echo "\n";
echo "Done: {$success} applied, {$skipped} skipped.\n";
