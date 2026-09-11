<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class SecureFileUploadRule implements ValidationRule
{
    /**
     * Whitelist of allowed extensions (e.g. ['pdf', 'jpg', 'jpeg', 'png']).
     */
    protected array $allowedTypes;

    /**
     * Maximum file size in kilobytes (defaults to 2048 KB / 2MB).
     */
    protected int $maxKilobytes;

    public function __construct(array $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'], int $maxKilobytes = 2048)
    {
        $this->allowedTypes = array_map('strtolower', $allowedTypes);
        $this->maxKilobytes = $maxKilobytes;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('Berkas yang diunggah tidak valid.');
            return;
        }

        if (! $value->isValid()) {
            $fail('Unggahan berkas gagal diproses.');
            return;
        }

        // 1. File size check
        if (($value->getSize() / 1024) > $this->maxKilobytes) {
            $fail("Ukuran berkas tidak boleh melebihi {$this->maxKilobytes} KB.");
            return;
        }

        $originalName = $value->getClientOriginalName();

        // 2. Strict double-extension check: only exactly one dot is permitted
        if (substr_count($originalName, '.') > 1) {
            $fail('Nama berkas tidak boleh mengandung ekstensi ganda.');
            return;
        }

        // 3. Absolute ban on script or executable extensions anywhere in original name
        $dangerousPattern = '/\.(php[0-9]?|phtml|phar|sh|bash|exe|bin|cgi|pl|py|html?|js|jsp|asp[x]?)(\.|\/|$)/i';
        if (preg_match($dangerousPattern, $originalName)) {
            $fail('Berkas mengandung ekstensi script berbahaya yang dilarang.');
            return;
        }

        // Also check if filename contains null byte
        if (str_contains($originalName, "\0")) {
            $fail('Nama berkas mengandung karakter tidak valid.');
            return;
        }

        // 4. Check client extension and guessed extension against whitelist
        $clientExt = strtolower($value->getClientOriginalExtension());
        $guessedExt = strtolower($value->guessExtension() ?? '');

        // Normalize jpg/jpeg
        $normClient = ($clientExt === 'jpeg') ? 'jpg' : $clientExt;
        $normGuessed = ($guessedExt === 'jpeg') ? 'jpg' : $guessedExt;

        $allowedNorm = array_map(fn($ext) => ($ext === 'jpeg' ? 'jpg' : $ext), $this->allowedTypes);

        if (! in_array($normClient, $allowedNorm, true) || ! in_array($normGuessed, $allowedNorm, true)) {
            $allowedString = implode(', ', array_unique($this->allowedTypes));
            $fail("Format berkas tidak diizinkan. Format yang diperbolehkan hanya: {$allowedString}.");
            return;
        }

        $realPath = $value->getRealPath();
        if (! $realPath || ! file_exists($realPath)) {
            $fail('Berkas fisik tidak ditemukan di server.');
            return;
        }

        // 5. Deep content inspection: check for PHP tags or embedded scripts
        $content = file_get_contents($realPath);
        if ($content === false) {
            $fail('Gagal membaca konten berkas.');
            return;
        }

        if (preg_match('/<\?(?:php|=)/i', $content) || preg_match('/<script[\s>]/i', $content)) {
            $fail('Berkas terdeteksi mengandung kode script berbahaya (anti-webshell protection).');
            return;
        }

        // 6. Magic bytes and MIME verification
        $mime = $value->getMimeType();

        if ($normClient === 'pdf') {
            if ($mime !== 'application/pdf') {
                $fail('MIME berkas PDF tidak valid.');
                return;
            }

            // PDF magic bytes check (%PDF-)
            $handle = fopen($realPath, 'rb');
            $header = fread($handle, 5);
            fclose($handle);

            if ($header !== '%PDF-') {
                $fail('Header signature berkas PDF tidak valid.');
                return;
            }
        } elseif ($normClient === 'jpg' || $normClient === 'png') {
            $imageInfo = @getimagesize($realPath);
            if ($imageInfo === false) {
                $fail('Berkas gambar rusak atau tidak valid.');
                return;
            }

            if ($normClient === 'jpg') {
                if (! in_array($mime, ['image/jpeg', 'image/pjpeg'], true) || $imageInfo[2] !== IMAGETYPE_JPEG) {
                    $fail('Header berkas JPG/JPEG tidak sesuai.');
                    return;
                }

                // Check JPEG magic bytes: \xFF\xD8\xFF
                $handle = fopen($realPath, 'rb');
                $bytes = fread($handle, 3);
                fclose($handle);
                if ($bytes !== "\xFF\xD8\xFF") {
                    $fail('Signature binary berkas JPEG tidak valid.');
                    return;
                }
            } elseif ($normClient === 'png') {
                if ($mime !== 'image/png' || $imageInfo[2] !== IMAGETYPE_PNG) {
                    $fail('Header berkas PNG tidak sesuai.');
                    return;
                }

                // Check PNG magic bytes: \x89PNG\r\n\x1a\n
                $handle = fopen($realPath, 'rb');
                $bytes = fread($handle, 8);
                fclose($handle);
                if ($bytes !== "\x89PNG\r\n\x1a\n") {
                    $fail('Signature binary berkas PNG tidak valid.');
                    return;
                }
            }
        }
    }
}
