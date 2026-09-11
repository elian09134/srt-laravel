<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class FileUploadService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Store applicant document securely in private storage (disk: 'local' -> storage/app/private).
     * Images are re-encoded to strip EXIF and polyglots. Filenames are pure UUID v4.
     */
    public function storeApplicantDocument(UploadedFile $file, string $directory): string
    {
        $clientExt = strtolower($file->getClientOriginalExtension());
        $guessedExt = strtolower($file->guessExtension() ?? '');

        $isImage = in_array($clientExt, ['jpg', 'jpeg', 'png'], true) || in_array($guessedExt, ['jpg', 'jpeg', 'png'], true);
        $uuid = Str::uuid()->toString();

        if ($isImage) {
            $isPng = ($clientExt === 'png' || $guessedExt === 'png');
            $extension = $isPng ? 'png' : 'jpg';
            $filename = "{$uuid}.{$extension}";
            $path = "{$directory}/{$filename}";

            // Re-encode image via Intervention Image to neutralize EXIF / polyglot payloads
            $image = $this->imageManager->read($file->getRealPath());
            $encoded = $isPng ? $image->toPng() : $image->toJpeg(85);

            Storage::disk('local')->put($path, (string) $encoded);

            return $path;
        }

        // PDF document
        $filename = "{$uuid}.pdf";
        $path = "{$directory}/{$filename}";
        Storage::disk('local')->putFileAs($directory, $file, $filename);

        return $path;
    }

    /**
     * Store a public image (e.g. Job banner) with re-encoding and pure UUID v4 filename.
     */
    public function storePublicImage(UploadedFile $file, string $directory): string
    {
        $clientExt = strtolower($file->getClientOriginalExtension());
        $guessedExt = strtolower($file->guessExtension() ?? '');
        $isPng = ($clientExt === 'png' || $guessedExt === 'png');
        $extension = $isPng ? 'png' : 'jpg';

        $uuid = Str::uuid()->toString();
        $filename = "{$uuid}.{$extension}";
        $path = "{$directory}/{$filename}";

        $image = $this->imageManager->read($file->getRealPath());
        $encoded = $isPng ? $image->toPng() : $image->toJpeg(85);

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete an existing file safely from specified storage disks.
     */
    public function deleteFile(?string $path, array $disks = ['local', 'public']): void
    {
        if (empty($path)) {
            return;
        }

        foreach ($disks as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
