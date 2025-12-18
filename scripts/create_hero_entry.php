<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\SiteContent;
SiteContent::updateOrCreate(
    ['section_name' => 'hero', 'content_key' => 'image'],
    ['content_value' => 'images/hero_sample.ico']
);
echo "SiteContent hero image set to images/hero_sample.ico\n";
