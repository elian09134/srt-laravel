<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Show the form for editing site content.
     */
    public function edit()
    {
        // Ambil semua konten dan ubah menjadi format yang mudah diakses di view
        $content_items = SiteContent::all();
        $content = [];
        foreach ($content_items as $item) {
            $content[$item->section_name][$item->content_key] = $item->content_value;
        }

        return view('admin.content.edit', compact('content'));
    }

    /**
     * Update the site content in storage.
     */
    public function update(Request $request)
    {
        $content_array = $request->input('content', []);

        // Handle hr_department members separately
        if (isset($content_array['hr_department']['members'])) {
            $members = $content_array['hr_department']['members'];
            $membersArray = [];
            
            foreach ($members as $member) {
                if (!empty($member['name'])) {
                    $membersArray[] = array_filter([
                        'name' => $member['name'] ?? '',
                        'role' => $member['role'] ?? '',
                        'photo' => $member['photo'] ?? '',
                        'bio' => $member['bio'] ?? '',
                        'email' => $member['email'] ?? '',
                        'phone' => $member['phone'] ?? '',
                        'social' => array_filter([
                            'linkedin' => $member['linkedin'] ?? '',
                            'instagram' => $member['instagram'] ?? '',
                            'twitter' => $member['twitter'] ?? '',
                        ])
                    ]);
                }
            }
            
            SiteContent::updateOrCreate(
                ['section_name' => 'hr_department', 'content_key' => 'members'],
                ['content_value' => json_encode($membersArray)]
            );
            
            unset($content_array['hr_department']['members']);
        }

        foreach ($content_array as $section_name => $keys) {
            foreach ($keys as $content_key => $content_value) {
                // Perlakuan khusus untuk list yang disimpan sebagai JSON
                if (str_contains($content_key, '_list') || $content_key === 'mission_text') {
                    $content_value = json_encode(array_filter(array_map('trim', explode("\n", $content_value))));
                }

                SiteContent::updateOrCreate(
                    ['section_name' => $section_name, 'content_key' => $content_key],
                    ['content_value' => $content_value]
                );
            }
        }

        return redirect()->route('admin.content.edit')->with('success', 'Konten berhasil diperbarui.');
    }
}
