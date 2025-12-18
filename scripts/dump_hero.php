<?php
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    echo "vendor autoload not found\n";
    exit(1);
}
require $autoload;
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\SiteContent;
$rows = SiteContent::where('section_name','hero')->where('content_key','image')->get();
if($rows->isEmpty()){
    echo "NO_ROWS\n";
    exit(0);
}
foreach($rows as $r){
    echo $r->id . '|' . $r->section_name . '|' . $r->content_key . '|' . $r->content_value . PHP_EOL;
}
