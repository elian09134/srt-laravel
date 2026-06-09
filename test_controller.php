<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

$request = Request::create('/register', 'POST', [
    'name' => 'Test User',
    'email' => 'test_' . time() . '@example.com',
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
], [], [
    'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
    'formal_photo' => UploadedFile::fake()->image('formal.jpg'),
    'ktp' => UploadedFile::fake()->image('ktp.jpg'),
    'kk' => UploadedFile::fake()->image('kk.jpg'),
    'ijazah' => UploadedFile::fake()->create('ijazah.pdf', 100, 'application/pdf'),
]);

// Since validation uses the current request instance in some places, we bind it
app()->instance('request', $request);

$controller = new RegisteredUserController();
try {
    $response = $controller->store($request);
    echo "Success!\n";
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        $session = $request->session();
        if ($session) {
            print_r($session->all());
        }
    }
} catch (\Illuminate\Validation\ValidationException $e) {
    echo "Validation failed:\n";
    print_r($e->errors());
} catch (\Exception $e) {
    echo "Exception:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
