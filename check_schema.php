<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$cols = Illuminate\Support\Facades\Schema::getColumnListing('products');
echo implode("\n", $cols);
