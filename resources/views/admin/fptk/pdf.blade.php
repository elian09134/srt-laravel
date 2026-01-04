<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FPTK #{{ $fptk->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 7pt;
            line-height: 1.2;
            color: #333;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid #2563eb;
        }
        .header h1 {
            font-size: 11pt;
            color: #1e40af;
            margin-bottom: 2px;
        }
        .header .subtitle {
            font-size: 7pt;
            color: #666;
        }
        .meta-info {
            background: #f3f4f6;
            padding: 4px;
            margin-bottom: 6px;
            border-radius: 2px;
        }
        .meta-info table {
            width: 100%;
        }
        .meta-info td {
            padding: 1px 3px;
            font-size: 7pt;
        }
        .meta-info .label {
            font-weight: bold;
            width: 22%;
            color: #555;
        }
        .section {
            margin-bottom: 6px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #2563eb;
            color: white;
            padding: 3px 6px;
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 4px;
            border-radius: 2px;
        }
        .field-group {
            margin-bottom: 3px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
            font-size: 7pt;
            margin-bottom: 1px;
        }
        .field-value {
            color: #333;
            font-size: 7pt;
            padding-left: 5px;
        }
        .grid-2 {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        .grid-col {
            display: table-cell;
            width: 50%;
            padding: 2px;
        }
        ul {
            margin-left: 12px;
            margin-top: 2px;
        }
        ul li {
            margin-bottom: 1px;
            font-size: 7pt;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 6pt;
            font-weight: bold;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        .notes-box {
            background: #fef3c7;
            border-left: 2px solid #f59e0b;
            padding: 4px;
            margin-top: 3px;
            font-size: 7pt;
        }
        .footer {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1px solid #e5e7eb;
            font-size: 6pt;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    @php
        $das = $notes['dasar_permintaan'] ?? null;
        $dasList = is_array($das) ? $das : [];
        $k = $notes['keterampilan'] ?? null;
        $kList = $k ? array_filter(array_map('trim', explode(',', $k))) : [];
    @endphp

    <div class="header">
        <h1>FORM PERMINTAAN TENAGA KERJA (FPTK)</h1>
        <div class="subtitle">Nomor: #{{ $fptk->id }}</div>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Pengaju:</td>
                <td>{{ $fptk->user->name }} ({{ $fptk->user->email }})</td>
                <td class="label">Tanggal:</td>
                <td>{{ $fptk->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td>
                    @if($fptk->status === 'pending')
                        <span class="status-badge status-pending">Pending</span>
                    @elseif($fptk->status === 'approved')
                        <span class="status-badge status-approved">Disetujui</span>
                    @else
                        <span class="status-badge status-rejected">Ditolak</span>
                    @endif
                </td>
                <td class="label">Waktu:</td>
                <td>{{ $fptk->created_at->format('H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI POSISI</div>
        
        <div class="grid-2">
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Posisi yang Dibutuhkan:</div>
                    <div class="field-value">{{ $fptk->position }}</div>
                </div>
            </div>
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Divisi:</div>
                    <div class="field-value">{{ $notes['division'] ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Lokasi Penempatan:</div>
                    <div class="field-value">{{ $fptk->locations }}</div>
                </div>
            </div>
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Tanggal Kebutuhan:</div>
                    <div class="field-value">{{ $notes['date_needed'] ? date('d F Y', strtotime($notes['date_needed'])) : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="field-group">
            <div class="field-label">Jumlah Kebutuhan:</div>
            <div class="field-value">
                Pria: {{ $notes['qty_male'] ?? 0 }} orang &nbsp;|&nbsp; 
                Wanita: {{ $notes['qty_female'] ?? 0 }} orang &nbsp;|&nbsp; 
                <strong>Total: {{ $fptk->qty }} orang</strong>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">DASAR PERMINTAAN</div>
        @if(count($dasList))
            <ul>
                @foreach($dasList as $d)
                    <li>{{ $d }}</li>
                @endforeach
            </ul>
        @else
            <div class="field-value">Tidak ada data</div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">SPESIFIKASI JABATAN</div>
        
        <div class="grid-2">
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Golongan / Status:</div>
                    <div class="field-value">{{ $notes['golongan_gaji'] ?? '-' }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Gaji:</div>
                    <div class="field-value">{{ isset($notes['gaji']) ? 'Rp ' . number_format($notes['gaji'],0,',','.') : '-' }}</div>
                </div>
            </div>
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Penempatan:</div>
                    <div class="field-value">{{ $notes['penempatan'] ?? '-' }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Usia:</div>
                    <div class="field-value">{{ $notes['usia'] ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Pendidikan:</div>
                    <div class="field-value">{{ $notes['pendidikan'] ?? '-' }}</div>
                </div>
            </div>
            <div class="grid-col">
                <div class="field-group">
                    <div class="field-label">Pengalaman:</div>
                    <div class="field-value">{{ $notes['pengalaman'] ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">KUALIFIKASI & KETERAMPILAN</div>
        @if(count($kList))
            <ul>
                @foreach($kList as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <div class="field-value">Tidak ada data</div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">URAIAN TUGAS</div>
        <div class="field-value" style="white-space: pre-line;">{{ $notes['uraian'] ?? 'Tidak ada uraian' }}</div>
    </div>

    @if(!empty($notes['notes_text']) || $fptk->admin_note)
    <div class="section">
        <div class="section-title">CATATAN</div>
        
        @if(!empty($notes['notes_text']))
        <div class="field-group">
            <div class="field-label">Catatan Pengaju:</div>
            <div class="notes-box">{{ $notes['notes_text'] }}</div>
        </div>
        @endif

        @if($fptk->admin_note)
        <div class="field-group">
            <div class="field-label">Catatan Admin:</div>
            <div class="notes-box" style="border-color: #2563eb; background: #dbeafe;">{{ $fptk->admin_note }}</div>
        </div>
        @endif
    </div>
    @endif

    <!-- Signature Section -->
    <div class="section" style="margin-top: 8px; page-break-inside: avoid;">
        <div class="section-title">PERSETUJUAN</div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 4px;">
            <thead>
                <tr style="background: #f3f4f6;">
                    <th style="border: 1px solid #ddd; padding: 3px; font-size: 7pt; text-align: center; width: 25%;">DIMINTA Oleh</th>
                    <th style="border: 1px solid #ddd; padding: 3px; font-size: 7pt; text-align: center; width: 25%;" colspan="2">Disetujui/Ditolak oleh</th>
                    <th style="border: 1px solid #ddd; padding: 3px; font-size: 7pt; text-align: center; width: 25%;">Diterima Oleh</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Diminta Oleh (Operasional) -->
                    <td style="border: 1px solid #ddd; padding: 4px; vertical-align: top; height: 60px;">
                        @if(isset($signatureData))
                        <div style="text-align: center;">
                            <img src="{{ $signatureData['signature'] }}" style="max-width: 80px; max-height: 30px; display: block; margin: 0 auto;">
                            <div style="margin-top: 2px; padding-top: 2px; border-top: 1px solid #333; font-size: 6pt;">
                                <strong>{{ $signatureData['name'] }}</strong><br>
                                <span style="font-size: 5pt; color: #666;">Supervisor Divisi</span>
                            </div>
                        </div>
                        @else
                        <div style="text-align: center; color: #999; font-size: 6pt; padding-top: 20px;">
                            Belum ditandatangani
                        </div>
                        @endif
                    </td>
                    
                    <!-- Manager Divisi -->
                    <td style="border: 1px solid #ddd; padding: 4px; vertical-align: bottom; text-align: center; height: 60px;">
                        <div style="margin-top: 30px; padding-top: 2px; border-top: 1px solid #333; font-size: 6pt;">
                            <strong>____________</strong><br>
                            <span style="font-size: 5pt; color: #666;">Manager Divisi</span>
                        </div>
                    </td>
                    
                    <!-- Direktur -->
                    <td style="border: 1px solid #ddd; padding: 4px; vertical-align: bottom; text-align: center; height: 60px;">
                        <div style="margin-top: 30px; padding-top: 2px; border-top: 1px solid #333; font-size: 6pt;">
                            <strong>____________</strong><br>
                            <span style="font-size: 5pt; color: #666;">Direktur</span>
                        </div>
                    </td>
                    
                    <!-- HR Manager -->
                    <td style="border: 1px solid #ddd; padding: 4px; vertical-align: bottom; text-align: center; height: 60px;">
                        <div style="margin-top: 30px; padding-top: 2px; border-top: 1px solid #333; font-size: 6pt;">
                            <strong>____________</strong><br>
                            <span style="font-size: 5pt; color: #666;">HR Manager</span>
                        </div>
                    </td>
                </tr>
                <tr style="background: #f9fafb;">
                    <td style="border: 1px solid #ddd; padding: 2px; text-align: center; font-size: 6pt;">
                        Tanggal: <strong>{{ $signatureData['date'] ?? '_______' }}</strong>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 2px; text-align: center; font-size: 6pt;">
                        Tanggal: _______
                    </td>
                    <td style="border: 1px solid #ddd; padding: 2px; text-align: center; font-size: 6pt;">
                        Tanggal: _______
                    </td>
                    <td style="border: 1px solid #ddd; padding: 2px; text-align: center; font-size: 6pt;">
                        Tanggal: _______
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d F Y, H:i') }} WIB
    </div>
</body>
</html>
