<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    /**
     * Whitelist mapping of document types to UserProfile columns.
     */
    protected array $documentTypeMap = [
        'cv' => 'cv_path',
        'photo' => 'photo_path',
        'formal_photo' => 'formal_photo_path',
        'ktp' => 'ktp_path',
        'kk' => 'kk_path',
        'npwp' => 'npwp_path',
        'ijazah' => 'ijazah_path',
        'certificate' => 'certificate_path',
    ];

    /**
     * Serve an applicant user's document with strict authentication and role checking.
     */
    public function showUserDocument(Request $request, User $user, string $type): Response
    {
        $currentUser = Auth::user();

        // Access check: only the owner or an admin/superadmin may access the file
        if (! $currentUser || ($currentUser->id !== $user->id && ! in_array($currentUser->role, ['admin', 'superadmin'], true))) {
            abort(403, 'Akses ke dokumen ditolak.');
        }

        if (! isset($this->documentTypeMap[$type])) {
            abort(404, 'Tipe dokumen tidak dikenali.');
        }

        $column = $this->documentTypeMap[$type];
        $path = $user->profile?->{$column};

        if (empty($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // Check local/private disk first, then public disk as legacy fallback
        $disk = null;
        if (Storage::disk('local')->exists($path)) {
            $disk = 'local';
        } elseif (Storage::disk('public')->exists($path)) {
            $disk = 'public';
        }

        if (! $disk) {
            abort(404, 'Berkas fisik tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk($disk)->response($path);
    }

    /**
     * Serve an application's CV with strict authentication and role checking.
     */
    public function applicationCv(Request $request, Application $application): Response
    {
        $currentUser = Auth::user();

        if (! $currentUser || ($currentUser->id !== $application->user_id && ! in_array($currentUser->role, ['admin', 'superadmin'], true))) {
            abort(403, 'Akses ke berkas lamaran ditolak.');
        }

        $snapshot = is_string($application->snapshot_data)
            ? json_decode($application->snapshot_data, true)
            : $application->snapshot_data;

        $path = $snapshot['cv_path'] ?? $application->user?->profile?->cv_path;

        if (empty($path)) {
            abort(404, 'CV lamaran tidak ditemukan.');
        }

        $disk = null;
        if (Storage::disk('local')->exists($path)) {
            $disk = 'local';
        } elseif (Storage::disk('public')->exists($path)) {
            $disk = 'public';
        }

        if (! $disk) {
            abort(404, 'Berkas CV tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk($disk)->response($path);
    }
}
