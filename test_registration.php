<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create(
        '/register', 'POST',
        [
            'name' => 'Test User',
            'email' => 'test_register_' . time() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nickname' => 'Tester',
            'phone_number' => '081234567890',
            'date_of_birth' => '1995-01-01',
            'about_me' => 'I am a tester.',
            'education_level' => 'S1',
            'institution' => 'Universitas Indonesia',
            'major' => 'Computer Science',
            'referral_source' => 'Sosial Media',
            'currently_employed' => 0,
            'expected_salary' => 5000000,
        ],
        [],
        [
            'cv' => new \Illuminate\Http\UploadedFile(__DIR__.'/composer.json', 'cv.pdf', 'application/pdf', null, true),
            'formal_photo' => new \Illuminate\Http\UploadedFile(__DIR__.'/composer.json', 'photo.jpg', 'image/jpeg', null, true),
            'ktp' => new \Illuminate\Http\UploadedFile(__DIR__.'/composer.json', 'ktp.jpg', 'image/jpeg', null, true),
            'kk' => new \Illuminate\Http\UploadedFile(__DIR__.'/composer.json', 'kk.jpg', 'image/jpeg', null, true),
            'ijazah' => new \Illuminate\Http\UploadedFile(__DIR__.'/composer.json', 'ijazah.pdf', 'application/pdf', null, true),
        ]
    )
);

echo "Status Code: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() === 302) {
    echo "Redirect Location: " . $response->headers->get('Location') . "\n";
    $session = $request->session();
    if ($session) {
        $errors = $session->get('errors');
        if ($errors) {
            echo "Validation Errors:\n";
            print_r($errors->all());
        }
        $error = $session->get('error');
        if ($error) {
            echo "Session Error:\n";
            echo $error . "\n";
        }
    }
} else {
    echo $response->getContent();
}
