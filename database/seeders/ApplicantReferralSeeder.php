<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Job;
use App\Models\TalentPool;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicantReferralSeeder extends Seeder
{
    private array $statusSequence = [
        'Baru' => ['Baru'],
        'Lamaran Dilihat' => ['Baru', 'Lamaran Dilihat'],
        'Psikotest' => ['Baru', 'Lamaran Dilihat', 'Psikotest'],
        'Wawancara HR' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR'],
        'Wawancara User' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR', 'Wawancara User'],
        'Offering Letter' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR', 'Wawancara User', 'Offering Letter'],
        'Diterima' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR', 'Wawancara User', 'Offering Letter', 'Diterima'],
        'Ditolak (Berkas)' => ['Baru', 'Tidak Lanjut'],
        'Ditolak (Psikotes)' => ['Baru', 'Lamaran Dilihat', 'Tidak Lanjut'],
        'Ditolak (HR)' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Tidak Lanjut'],
        'Ditolak (User)' => ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR', 'Tidak Lanjut'],
    ];

    private array $ditolakStageMap = [
        'Ditolak (Berkas)' => 'Berkas lamaran tidak lengkap dan tidak sesuai dengan kualifikasi minimal yang dibutuhkan.',
        'Ditolak (HR)' => 'Hasil wawancara HR tidak memenuhi standar komunikasi dan budaya perusahaan.',
        'Ditolak (User)' => 'Kandidat tidak memenuhi ekspektasi teknis dari user department pada saat wawancara.',
        'Ditolak (Psikotes)' => 'Hasil psikotes tidak mencapai nilai minimum yang ditetapkan untuk posisi ini.',
    ];

    private array $m28AcceptedCounts = [];

    private ?\Illuminate\Support\Collection $m28Targets = null;

    private array $applicants = [];

    private array $profiles = [
        // ===== JANUARI 2026 =====
        // Senior Frontend Developer
        ['name' => 'Ahmad Fauzi', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Senior Frontend Developer', 'status' => 'Diterima', 'month' => 1, 'day' => 5, 'education_level' => 'S1 Teknik Informatika', 'institution' => 'Institut Teknologi Bandung', 'last_company' => 'PT GoTo Gojek Tokopedia Tbk', 'last_position' => 'Frontend Engineer', 'skills' => 'React, Vue.js, TypeScript, JavaScript, Tailwind CSS'],
        ['name' => 'Dimas Ardianto', 'source' => 'Lainnya', 'referralSource' => 'LinkedIn', 'job_title' => 'Senior Frontend Developer', 'status' => 'Offering Letter', 'month' => 1, 'day' => 8, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Universitas Telkom', 'last_company' => 'PT Bukalapak.com Tbk', 'last_position' => 'Frontend Developer', 'skills' => 'Vue.js, Nuxt.js, JavaScript, SCSS, Webpack'],

        // Human Capital Manager
        ['name' => 'Rina Wulandari', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Human Capital Manager', 'status' => 'Diterima', 'month' => 1, 'day' => 3, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Bank Mandiri (Persero) Tbk', 'last_position' => 'HRBP', 'skills' => 'Recruitment, Performance Management, Organization Development, Industrial Relations'],
        ['name' => 'Sari Dewi', 'source' => 'Lainnya', 'referralSource' => 'LinkedIn', 'job_title' => 'Human Capital Manager', 'status' => 'Diterima', 'month' => 1, 'day' => 10, 'education_level' => 'S1 Hukum', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT Unilever Indonesia Tbk', 'last_position' => 'Legal & HR Compliance', 'skills' => 'Employment Law, Contract Management, Labor Relations, Compliance'],

        // Finance Staff
        ['name' => 'Fitri Handayani', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Finance Staff', 'status' => 'Diterima', 'month' => 1, 'day' => 6, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Padjadjaran', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'Finance Staff', 'skills' => 'Financial Reporting, SAP, Excel, Tax Calculation, Budgeting'],
        ['name' => 'Nurul Hidayah', 'source' => 'Sosial Media', 'referralSource' => 'Sosial Media', 'job_title' => 'Finance Staff', 'status' => 'Offering Letter', 'month' => 1, 'day' => 12, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Pertamina (Persero)', 'last_position' => 'Finance Analyst', 'skills' => 'Financial Analysis, SAP, Audit, Taxation, Budget Control'],

        // IT Support Specialist
        ['name' => 'Gilang Permana', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'IT Support Specialist', 'status' => 'Diterima', 'month' => 1, 'day' => 4, 'education_level' => 'D3 Teknik Informatika', 'institution' => 'Universitas Gunadarma', 'last_company' => 'PT Pertamina (Persero)', 'last_position' => 'IT Support', 'skills' => 'Network Troubleshooting, Windows Server, MikroTik, Active Directory, Helpdesk'],
        ['name' => 'Hendra Gunawan', 'source' => 'Lainnya', 'referralSource' => 'Instagram', 'job_title' => 'IT Support Specialist', 'status' => 'Wawancara User', 'month' => 1, 'day' => 9, 'education_level' => 'S1 Ilmu Komputer', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT Telkom Indonesia Tbk', 'last_position' => 'Network Engineer', 'skills' => 'Cisco, Routing, Switching, Firewall, Network Security'],

        // Sosial Media / Other (Jan)
        ['name' => 'Mentari Ayu', 'source' => 'Sosial Media', 'referralSource' => 'Sosial Media', 'job_title' => 'Finance Staff', 'status' => 'Diterima', 'month' => 1, 'day' => 15, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'Junior Accountant', 'skills' => 'Excel, MYOB, Taxation, Financial Statement'],
        ['name' => 'Bagas Prakoso', 'source' => 'Lainnya', 'referralSource' => 'Email Marketing', 'job_title' => 'Senior Frontend Developer', 'status' => 'Ditolak (Berkas)', 'month' => 1, 'day' => 18, 'education_level' => 'S1 Teknik Informatika', 'institution' => 'Universitas Telkom', 'last_company' => 'PT GoTo Gojek Tokopedia Tbk', 'last_position' => 'Junior Frontend Developer', 'skills' => 'HTML, CSS, JavaScript, React Basic'],

        // ===== FEBRUARI 2026 =====
        // Senior Frontend Developer
        ['name' => 'Bayu Pratama', 'source' => 'Lainnya', 'referralSource' => 'JobStreet', 'job_title' => 'Senior Frontend Developer', 'status' => 'Psikotest', 'month' => 2, 'day' => 3, 'education_level' => 'D3 Teknik Komputer', 'institution' => 'Politeknik Negeri Jakarta', 'last_company' => 'PT Bukalapak.com Tbk', 'last_position' => 'Frontend Developer', 'skills' => 'React, Redux, JavaScript, HTML5, CSS3'],
        ['name' => 'Eka Prasetya', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Senior Frontend Developer', 'status' => 'Wawancara User', 'month' => 2, 'day' => 7, 'education_level' => 'S1 Teknik Informatika', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'last_company' => 'PT Bank Mandiri (Persero) Tbk', 'last_position' => 'Frontend Engineer', 'skills' => 'Angular, TypeScript, RxJS, NgRx, Jest'],

        // Human Capital Manager
        ['name' => 'Mega Utami', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Human Capital Manager', 'status' => 'Offering Letter', 'month' => 2, 'day' => 5, 'education_level' => 'S1 Manajemen', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Astra International Tbk', 'last_position' => 'HCBP', 'skills' => 'Talent Acquisition, People Development, Compensation & Benefit, HR Analytics'],
        ['name' => 'Dian Permatasari', 'source' => 'Lainnya', 'referralSource' => 'Instagram', 'job_title' => 'Human Capital Manager', 'status' => 'Wawancara User', 'month' => 2, 'day' => 11, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Padjadjaran', 'last_company' => 'PT Telkom Indonesia Tbk', 'last_position' => 'HR Recruitment', 'skills' => 'Interviewing, Assessment, Employer Branding, Recruitment Marketing'],

        // Finance Staff
        ['name' => 'Lilis Karlina', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Finance Staff', 'status' => 'Wawancara User', 'month' => 2, 'day' => 6, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Brawijaya', 'last_company' => 'PT Perusahaan Listrik Negara (Persero)', 'last_position' => 'Finance Staff', 'skills' => 'SAP FICO, Budgeting, Financial Reporting, Cost Control'],
        ['name' => 'Fanny Oktaviani', 'source' => 'Lainnya', 'referralSource' => 'LinkedIn', 'job_title' => 'Finance Staff', 'status' => 'Psikotest', 'month' => 2, 'day' => 14, 'education_level' => 'S1 Manajemen Keuangan', 'institution' => 'Institut Teknologi Bandung', 'last_company' => 'PT Bank Negara Indonesia Tbk', 'last_position' => 'Financial Analyst', 'skills' => 'Financial Modeling, Valuation, Risk Analysis, Excel VBA'],

        // IT Support Specialist
        ['name' => 'Reza Firmansyah', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'IT Support Specialist', 'status' => 'Psikotest', 'month' => 2, 'day' => 4, 'education_level' => 'D3 Teknik Elektro', 'institution' => 'Politeknik Negeri Jakarta', 'last_company' => 'PT Perusahaan Listrik Negara (Persero)', 'last_position' => 'IT Support', 'skills' => 'Hardware Repair, LAN, CCTV, Operating System, Office 365'],
        ['name' => 'Aditya Saputra', 'source' => 'Lainnya', 'referralSource' => 'LinkedIn', 'job_title' => 'IT Support Specialist', 'status' => 'Offering Letter', 'month' => 2, 'day' => 10, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'last_company' => 'PT Bukalapak.com Tbk', 'last_position' => 'IT Support Specialist', 'skills' => 'Linux, Docker, AWS, Database Administration, ITIL'],

        // Sosial Media / Other (Feb)
        ['name' => 'Rizky Ramadhan', 'source' => 'Lainnya', 'referralSource' => 'Teman', 'job_title' => 'IT Support Specialist', 'status' => 'Wawancara User', 'month' => 2, 'day' => 16, 'education_level' => 'D3 Teknik Komputer', 'institution' => 'Universitas Bina Nusantara', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'Helpdesk IT', 'skills' => 'IT Helpdesk, Ticketing System, Desktop Support, Basic Networking'],
        ['name' => 'Cindy Permata', 'source' => 'Lainnya', 'referralSource' => 'TikTok', 'job_title' => 'Senior Frontend Developer', 'status' => 'Lamaran Dilihat', 'month' => 2, 'day' => 20, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Universitas Bina Nusantara', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'Frontend Developer', 'skills' => 'React, Next.js, TypeScript, Tailwind, Git'],

        // ===== MARET 2026 =====
        // Senior Frontend Developer
        ['name' => 'Fajar Nugroho', 'source' => 'Lainnya', 'referralSource' => 'Instagram', 'job_title' => 'Senior Frontend Developer', 'status' => 'Wawancara HR', 'month' => 3, 'day' => 2, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT GoTo Gojek Tokopedia Tbk', 'last_position' => 'Senior Frontend Developer', 'skills' => 'React, GraphQL, Micro Frontend, Storybook, Cypress'],
        ['name' => 'Hadi Sucipto', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Senior Frontend Developer', 'status' => 'Ditolak (Berkas)', 'month' => 3, 'day' => 6, 'education_level' => 'S1 Ilmu Komputer', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'IT Programmer', 'skills' => 'Java, Spring Boot, Oracle, Basic JavaScript'],

        // Human Capital Manager
        ['name' => 'Tari Kusuma', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Human Capital Manager', 'status' => 'Wawancara HR', 'month' => 3, 'day' => 5, 'education_level' => 'S1 Manajemen', 'institution' => 'Universitas Diponegoro', 'last_company' => 'PT Kalbe Farma Tbk', 'last_position' => 'HR Generalist', 'skills' => 'Payroll, BPJS, Employee Relations, Training & Development'],
        ['name' => 'Intan Nurhaliza', 'source' => 'Lainnya', 'referralSource' => 'JobStreet', 'job_title' => 'Human Capital Manager', 'status' => 'Ditolak (HR)', 'month' => 3, 'day' => 9, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Airlangga', 'last_company' => 'PT Bank Rakyat Indonesia Tbk', 'last_position' => 'HR Staff', 'skills' => 'Psychometric Test, Assessment Center, Data Analysis, MS Office'],

        // Finance Staff
        ['name' => 'Gita Puspita', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Finance Staff', 'status' => 'Lamaran Dilihat', 'month' => 3, 'day' => 4, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Hasanuddin', 'last_company' => 'PT Indofood Sukses Makmur Tbk', 'last_position' => 'Finance Staff', 'skills' => 'Accurate, Excel, Tax Reporting, Account Payable'],
        ['name' => 'Yuni Astuti', 'source' => 'Sosial Media', 'referralSource' => 'Sosial Media', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (Berkas)', 'month' => 3, 'day' => 13, 'education_level' => 'D3 Akuntansi', 'institution' => 'Politeknik Negeri Jakarta', 'last_company' => 'PT Semen Indonesia Tbk', 'last_position' => 'Junior Accountant', 'skills' => 'Bookkeeping, Zahir, Pajak PPH, Bank Reconciliation'],

        // IT Support Specialist
        ['name' => 'Andre Syahputra', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'IT Support Specialist', 'status' => 'Ditolak (Berkas)', 'month' => 3, 'day' => 3, 'education_level' => 'D3 Teknik Informatika', 'institution' => 'Universitas Dian Nuswantoro', 'last_company' => 'PT Bank Mandiri (Persero) Tbk', 'last_position' => 'IT Support', 'skills' => 'Desktop, Printer, Network, Windows, Basic Linux'],
        ['name' => 'Doni Lesmana', 'source' => 'Lainnya', 'referralSource' => 'Facebook', 'job_title' => 'IT Support Specialist', 'status' => 'Ditolak (Psikotes)', 'month' => 3, 'day' => 8, 'education_level' => 'S1 Teknik Elektro', 'institution' => 'Universitas Diponegoro', 'last_company' => 'PT Telkom Indonesia Tbk', 'last_position' => 'IT Support', 'skills' => 'Fiber Optic, OSP, Survey, AutoCAD, Microsoft Visio'],
        ['name' => 'Teguh Wirawan', 'source' => 'Lainnya', 'referralSource' => 'Google', 'job_title' => 'IT Support Specialist', 'status' => 'Wawancara HR', 'month' => 3, 'day' => 12, 'education_level' => 'D3 Teknik Komputer', 'institution' => 'Politeknik Negeri Bandung', 'last_company' => 'PT Bank Central Asia Tbk', 'last_position' => 'IT Support', 'skills' => 'LAN, WLAN, VPN, Server Administration, CCTV'],

        // Sosial Media / Other (Mar)
        ['name' => 'Desi Ratnasari', 'source' => 'Lainnya', 'referralSource' => 'Keluarga', 'job_title' => 'Human Capital Manager', 'status' => 'Baru', 'month' => 3, 'day' => 17, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Islam Negeri', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'Public Speaking, Teamwork, Microsoft Office, Basic Counseling'],
        ['name' => 'Rina Marlina', 'source' => 'Lainnya', 'referralSource' => 'Facebook', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (Berkas)', 'month' => 3, 'day' => 21, 'education_level' => 'D3 Akuntansi', 'institution' => 'Politeknik Negeri Bandung', 'last_company' => 'PT Bank Mandiri (Persero) Tbk', 'last_position' => 'Teller', 'skills' => 'Cash Management, Customer Service, Basic Accounting'],

        // ===== APRIL 2026 =====
        // Senior Frontend Developer
        ['name' => 'Irfan Maulana', 'source' => 'Lainnya', 'referralSource' => 'Facebook', 'job_title' => 'Senior Frontend Developer', 'status' => 'Baru', 'month' => 4, 'day' => 1, 'education_level' => 'S1 Teknik Informatika', 'institution' => 'Universitas Brawijaya', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'HTML, CSS, JavaScript, React Dasar, Git'],
        ['name' => 'Joko Susilo', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Senior Frontend Developer', 'status' => 'Lamaran Dilihat', 'month' => 4, 'day' => 5, 'education_level' => 'D3 Manajemen Informatika', 'institution' => 'Universitas Gunadarma', 'last_company' => 'PT Indosat Tbk', 'last_position' => 'IT Support', 'skills' => 'PHP, MySQL, HTML, CSS, Basic JavaScript'],

        // Human Capital Manager
        ['name' => 'Putri Ayuningtyas', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Human Capital Manager', 'status' => 'Psikotest', 'month' => 4, 'day' => 3, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT Mayora Indah Tbk', 'last_position' => 'HR Recruitment Staff', 'skills' => 'Screening, Interview, Psikotes, Employer Branding, MS Office'],
        ['name' => 'Karina Putri', 'source' => 'Lainnya', 'referralSource' => 'Facebook', 'job_title' => 'Human Capital Manager', 'status' => 'Ditolak (Berkas)', 'month' => 4, 'day' => 8, 'education_level' => 'S1 Hukum', 'institution' => 'Universitas Pelita Harapan', 'last_company' => 'PT Sinar Mas Group', 'last_position' => 'Legal Staff', 'skills' => 'Legal Drafting, Corporate Law, Perizinan, Notary'],

        // Finance Staff
        ['name' => 'Sri Wahyuni', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Finance Staff', 'status' => 'Wawancara HR', 'month' => 4, 'day' => 4, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Andalas', 'last_company' => 'PT Bank Mandiri (Persero) Tbk', 'last_position' => 'Account Payable Staff', 'skills' => 'AP Processing, SAP, reconciliation, PPH 23, Audit Trail'],
        ['name' => 'Winda Sari', 'source' => 'Lainnya', 'referralSource' => 'Facebook', 'job_title' => 'Finance Staff', 'status' => 'Baru', 'month' => 4, 'day' => 11, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Negeri Surabaya', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'MYOB, Accurate, Excel, Basic Taxation'],
        ['name' => 'Nadia Rahmawati', 'source' => 'Lainnya', 'referralSource' => 'JobStreet', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (HR)', 'month' => 4, 'day' => 15, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT Bank Rakyat Indonesia Tbk', 'last_position' => 'Finance Officer', 'skills' => 'Financial Analysis, SAP, Budgeting, Audit, Taxation'],

        // IT Support Specialist
        ['name' => 'Bambang Santoso', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'IT Support Specialist', 'status' => 'Baru', 'month' => 4, 'day' => 2, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Universitas Pembangunan Nasional', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'Networking Dasar, Windows, Linux, Database SQL, MS Office'],
        ['name' => 'Agung Laksono', 'source' => 'Sosial Media', 'referralSource' => 'Sosial Media', 'job_title' => 'IT Support Specialist', 'status' => 'Lamaran Dilihat', 'month' => 4, 'day' => 7, 'education_level' => 'D3 Teknik Informatika', 'institution' => 'AMIK BSI', 'last_company' => 'PT Bank Rakyat Indonesia Tbk', 'last_position' => 'IT Support', 'skills' => 'Hardware, Software Installation, Networking, Printer, CCTV'],
        ['name' => 'Cahyo Nugroho', 'source' => 'Lainnya', 'referralSource' => 'JobStreet', 'job_title' => 'IT Support Specialist', 'status' => 'Wawancara HR', 'month' => 4, 'day' => 10, 'education_level' => 'D3 Teknik Elektro', 'institution' => 'Politeknik Negeri Bandung', 'last_company' => 'PT Telkom Akses', 'last_position' => 'Teknisi IT', 'skills' => 'Fiber Optic, ODN, GPON, Troubleshooting, Microsoft Office'],

        // Sosial Media / Other (Apr)
        ['name' => 'Agus Wijaya', 'source' => 'Lainnya', 'referralSource' => 'Instagram', 'job_title' => 'IT Support Specialist', 'status' => 'Psikotest', 'month' => 4, 'day' => 18, 'education_level' => 'D3 Teknik Elektro', 'institution' => 'Politeknik Negeri Semarang', 'last_company' => 'PT Telkom Indonesia Tbk', 'last_position' => 'Teknisi Jaringan', 'skills' => 'Router, Switch, Mikrotik, Cabling, ISP'],
        ['name' => 'Ratna Dewi', 'source' => 'Lainnya', 'referralSource' => 'LinkedIn', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (HR)', 'month' => 4, 'day' => 22, 'education_level' => 'S1 Akuntansi', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Pertamina (Persero)', 'last_position' => 'Finance Supervisor', 'skills' => 'Consolidation, PSAK, IFRS, Tax Planning, Internal Audit'],

        // ===== MEI 2026 =====
        // Senior Frontend Developer
        ['name' => 'Rangga Wiraguna', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Senior Frontend Developer', 'status' => 'Ditolak (Psikotes)', 'month' => 5, 'day' => 3, 'education_level' => 'S1 Sistem Informasi', 'institution' => 'Universitas Pasundan', 'last_company' => 'PT Pertamina (Persero)', 'last_position' => 'IT Developer', 'skills' => 'PHP, Laravel, jQuery, Bootstrap, MySQL'],

        // Human Capital Manager
        ['name' => 'Dewi Sartika', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Human Capital Manager', 'status' => 'Baru', 'month' => 5, 'day' => 2, 'education_level' => 'S1 Psikologi', 'institution' => 'Universitas Muhammadiyah Surakarta', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'Psikologi Industri, Komunikasi, MS Office, Public Speaking'],
        ['name' => 'Nia Kurniawati', 'source' => 'Lainnya', 'referralSource' => 'Twitter/X', 'job_title' => 'Human Capital Manager', 'status' => 'Ditolak (Berkas)', 'month' => 5, 'day' => 6, 'education_level' => 'S1 Manajemen', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT GoTo Gojek Tokopedia Tbk', 'last_position' => 'People Operations', 'skills' => 'HRIS, Employee Data Management, Onboarding, Offboarding'],

        // Finance Staff
        ['name' => 'Tri Wahyuni', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (User)', 'month' => 5, 'day' => 4, 'education_level' => 'S1 Manajemen', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Astra International Tbk', 'last_position' => 'Finance Staff', 'skills' => 'SAP, Budget Control, Financial Report, Costing'],
        ['name' => 'Ratna Sari', 'source' => 'Sosial Media', 'referralSource' => 'Sosial Media', 'job_title' => 'Finance Staff', 'status' => 'Ditolak (Psikotes)', 'month' => 5, 'day' => 9, 'education_level' => 'D3 Akuntansi', 'institution' => 'Politeknik Keuangan Negara', 'last_company' => 'PT Wijaya Karya Tbk', 'last_position' => 'Junior Accountant', 'skills' => 'Taxation, Budgeting, Excel, SAP Basic'],

        // IT Support Specialist
        ['name' => 'Wawan Setiawan', 'source' => 'M28', 'referralSource' => 'M28', 'job_title' => 'IT Support Specialist', 'status' => 'Ditolak (Berkas)', 'month' => 5, 'day' => 1, 'education_level' => 'S1 Ilmu Komputer', 'institution' => 'Universitas Indonesia', 'last_company' => 'PT Pertamina (Persero)', 'last_position' => 'IT Support', 'skills' => 'Network Security, Firewall, IDS/IPS, SIEM, Python'],
        ['name' => 'Arif Budiman', 'source' => 'Lainnya', 'referralSource' => 'Twitter/X', 'job_title' => 'IT Support Specialist', 'status' => 'Baru', 'month' => 5, 'day' => 5, 'education_level' => 'D3 Sistem Informasi', 'institution' => 'Universitas Gunadarma', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'Instalasi PC, Jaringan Dasar, Windows, Linux, Office'],

        // Sosial Media / Other (May)
        ['name' => 'Indah Lestari', 'source' => 'Lainnya', 'referralSource' => 'Email Marketing', 'job_title' => 'Senior Frontend Developer', 'status' => 'Baru', 'month' => 5, 'day' => 12, 'education_level' => 'S1 Desain Komunikasi Visual', 'institution' => 'Institut Teknologi Bandung', 'last_company' => '', 'last_position' => 'Fresh Graduate', 'skills' => 'Figma, Adobe XD, UI Design, HTML, CSS Dasar'],
        ['name' => 'Dwi Handayani', 'source' => 'Lainnya', 'referralSource' => 'Teman', 'job_title' => 'Human Capital Manager', 'status' => 'Ditolak (Berkas)', 'month' => 5, 'day' => 16, 'education_level' => 'S1 Manajemen', 'institution' => 'Universitas Gadjah Mada', 'last_company' => 'PT Perusahaan Listrik Negara (Persero)', 'last_position' => 'Admin HR', 'skills' => 'Payroll, BPJS, HR Administration, MS Office, Employee Database'],
    ];

    private array $jobDescMap = [
        'Senior Frontend Developer' => [
            'Merancang dan mengimplementasikan arsitektur frontend untuk aplikasi web perusahaan menggunakan React dan TypeScript.',
            'Mengoptimalkan performa aplikasi web melalui code splitting, lazy loading, dan caching strategy.',
            'Memimpin code review dan mentoring untuk anggota tim frontend junior.',
            'Berkolaborasi dengan tim backend dan UI/UX untuk memastikan konsistensi implementasi desain.',
        ],
        'Human Capital Manager' => [
            'Mengelola proses rekrutmen end-to-end mulai dari sourcing hingga offering untuk posisi-posisi kunci.',
            'Merancang dan melaksanakan program pengembangan karyawan serta talent management.',
            'Menangani hubungan industrial, mediasi, dan kepatuhan terhadap peraturan ketenagakerjaan.',
            'Mengembangkan kebijakan SDM yang sejalan dengan strategi bisnis perusahaan.',
        ],
        'Finance Staff' => [
            'Melakukan pencatatan dan pelaporan transaksi keuangan harian sesuai dengan PSAK yang berlaku.',
            'Menyusun laporan keuangan bulanan, termasuk laba rugi, neraca, dan arus kas.',
            'Menangani rekonsiliasi bank, piutang, hutang, dan persediaan secara periodik.',
            'Mengelola administrasi perpajakan perusahaan termasuk PPH 21, PPN, dan PPH Badan.',
        ],
        'IT Support Specialist' => [
            'Memberikan dukungan teknis level 1 dan 2 untuk seluruh pengguna internal perusahaan.',
            'Melakukan instalasi, konfigurasi, dan maintenance perangkat keras dan lunak kantor.',
            'Memantau dan menjaga ketersediaan infrastruktur jaringan serta server internal.',
            'Membuat dokumentasi teknis dan prosedur troubleshooting untuk pengetahuan tim.',
        ],
    ];

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TalentPool::truncate();
        ApplicationStatusHistory::truncate();
        Application::truncate();
        WorkExperience::truncate();
        UserProfile::whereIn('user_id', User::where('role', 'applicant')->pluck('id'))->delete();
        User::where('role', 'applicant')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if (Job::count() === 0) {
            $this->call(JobSeeder::class);
        }

        $admin = User::whereIn('role', ['admin', 'superadmin'])->first();
        $changedBy = $admin?->id ?? 1;
        $jobs = Job::all();

        $this->loadM28Targets();

        $totalCreated = 0;
        foreach ($this->profiles as $data) {
            $totalCreated += $this->createApplicant($data, $jobs, $changedBy) ? 1 : 0;
        }

        $this->command->info("$totalCreated applicants seeded (Januari 2026 – Mei 2026).");
    }

    private function loadM28Targets(): void
    {
        $m28User = DB::table('users')->where('email', 'm28@partner.com')->first();
        if (! $m28User) {
            return;
        }

        $this->m28Targets = DB::table('partner_targets')
            ->where('user_id', $m28User->id)
            ->where('year', 2026)
            ->get()
            ->keyBy(fn ($t) => $t->year.'-'.str_pad((string) $t->month, 2, '0', STR_PAD_LEFT));
    }

    private function getM28PositionTarget(int $year, int $month, string $position): int
    {
        if ($this->m28Targets === null) {
            return 0;
        }

        $key = $year.'-'.str_pad((string) $month, 2, '0', STR_PAD_LEFT);
        $target = $this->m28Targets->get($key);
        if (! $target) {
            return 0;
        }

        $posTarget = DB::table('partner_target_positions')
            ->where('partner_target_id', $target->id)
            ->where('position', $position)
            ->value('target_count');

        return (int) ($posTarget ?? 0);
    }

    private function createApplicant(array $data, $jobs, int $changedBy): bool
    {
        $name = $data['name'];
        $referralSource = $data['referralSource'];
        $rawStatus = $data['status'];
        $month = $data['month'];
        $day = $data['day'];
        $jobTitle = $data['job_title'];

        $baseDate = now()->setDate(2026, $month, 1);
        $createdAt = $baseDate->copy()->addDays($day - 1);

        $slug = Str::slug($name);
        $email = strtolower($slug.'@example.com');

        if (User::where('email', $email)->exists()) {
            $email = strtolower($slug.'.'.uniqid().'@example.com');
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'referral_source' => $referralSource,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        $hasProfile = $data['last_company'] !== '' || rand(1, 10) > 2;

        if ($hasProfile) {
            $phone = '08'.rand(11, 13).str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $dob = now()->subYears(rand(22, 40))->subDays(rand(1, 365));

            UserProfile::create([
                'user_id' => $user->id,
                'phone_number' => $phone,
                'date_of_birth' => $dob,
                'education_level' => $data['education_level'],
                'institution' => $data['institution'],
                'last_company' => $data['last_company'] ?: null,
                'last_position' => $data['last_position'],
                'skills' => $data['skills'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            if ($data['last_company']) {
                $jobDescs = $this->jobDescMap[$jobTitle] ?? ['Melaksanakan tugas sesuai dengan job description yang ditetapkan.'];
                WorkExperience::create([
                    'user_id' => $user->id,
                    'company_name' => $data['last_company'],
                    'duration' => rand(1, 6).' Tahun',
                    'job_description' => $jobDescs[array_rand($jobDescs)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        $job = $jobs->firstWhere('title', $jobTitle) ?? $jobs->first();
        $quotaExceeded = false;

        if ($referralSource === 'M28' && $rawStatus === 'Diterima') {
            $year = (int) $createdAt->format('Y');
            $monthNum = (int) $createdAt->format('m');
            $maxTarget = $this->getM28PositionTarget($year, $monthNum, $job->title);

            $countKey = $year.'-'.$monthNum.'-'.$job->title;
            $currentCount = $this->m28AcceptedCounts[$countKey] ?? 0;

            if ($currentCount >= $maxTarget) {
                $rawStatus = 'Ditolak (Berkas)';
                $quotaExceeded = true;
            } else {
                $this->m28AcceptedCounts[$countKey] = $currentCount + 1;
            }
        }

        $finalStatus = in_array($rawStatus, ['Ditolak (Berkas)', 'Ditolak (HR)', 'Ditolak (User)', 'Ditolak (Psikotes)']) ? 'Tidak Lanjut' : $rawStatus;

        $phone = '08'.rand(11, 13).str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $lastPosition = $data['last_position'];
        $edu = $data['education_level'];

        $application = Application::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => $finalStatus,
            'applicant_name' => $name,
            'applicant_email' => $email,
            'applicant_phone' => $phone,
            'applicant_last_position' => $lastPosition,
            'applicant_last_education' => $edu,
            'cover_letter' => "Dengan hormat,\n\n"
                ."Saya yang bertanda tangan di bawah ini:\n\n"
                ."Nama: $name\n"
                ."Pendidikan: $edu\n"
                ."Domisili: {$job->location} dan sekitarnya\n\n"
                ."Bersama dengan surat ini, saya mengajukan lamaran pekerjaan untuk posisi {$job->title} di SRT Corp. "
                ."Informasi lowongan ini saya peroleh dari $referralSource.\n\n"
                .($data['last_company']
                    ? "Saat ini saya memiliki pengalaman sebagai {$data['last_position']} di {$data['last_company']}. "
                      ."Saya yakin pengalaman dan keterampilan yang saya miliki dapat berkontribusi secara positif bagi perusahaan.\n\n"
                    : "Saya adalah seorang fresh graduate yang antusias dan siap untuk belajar serta berkembang di lingkungan profesional.\n\n")
                ."Besar harapan saya untuk dapat mengikuti tahapan seleksi selanjutnya.\n\n"
                ."Atas perhatian Bapak/Ibu, saya ucapkan terima kasih.\n\n"
                ."Hormat saya,\n$name",
            'snapshot_data' => json_encode([
                'profile' => ['name' => $name, 'email' => $email],
                'referral' => $referralSource,
            ]),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        $sequence = $this->statusSequence[$rawStatus] ?? $this->statusSequence['Ditolak (Berkas)'];

        foreach ($sequence as $seqIndex => $seqStatus) {
            $historyCreatedAt = $createdAt->copy()->addDays($seqIndex * rand(2, 5));
            if ($historyCreatedAt->isFuture()) {
                $historyCreatedAt = now();
            }

            $note = match (true) {
                $seqStatus === 'Baru' => 'Pendaftaran online melalui website. (Referal '.$referralSource.')',
                $seqStatus === 'Diterima' => 'Kandidat dinyatakan lulus seluruh proses rekrutmen dan diterima.',
                $seqStatus === 'Tidak Lanjut' && $quotaExceeded => 'Lamaran ditolak karena kuota M28 untuk posisi ini sudah terpenuhi.',
                $seqStatus === 'Tidak Lanjut' => $this->ditolakStageMap[$rawStatus] ?? 'Kandidat tidak memenuhi kualifikasi yang dibutuhkan.',
                $seqStatus === 'Lamaran Dilihat' => 'Berkas lengkap dan sesuai kualifikasi, lanjut ke tahap wawancara HR.',
                $seqStatus === 'Wawancara HR' => 'Kandidat memiliki komunikasi yang baik dan sesuai dengan budaya perusahaan.',
                $seqStatus === 'Wawancara User' => 'Kandidat memenuhi ekspektasi teknis dari user department.',
                $seqStatus === 'Psikotest' => 'Hasil psikotes menunjukkan potensi yang baik untuk posisi yang dilamar.',
                $seqStatus === 'Offering Letter' => 'Offering letter telah dikirimkan dan menunggu konfirmasi kandidat.',
                default => 'Kandidat tidak memenuhi kualifikasi yang dibutuhkan.',
            };

            ApplicationStatusHistory::create([
                'application_id' => $application->id,
                'status' => $seqStatus,
                'note' => $note,
                'changed_by' => $changedBy,
                'created_at' => $historyCreatedAt,
                'updated_at' => $historyCreatedAt,
            ]);
        }

        if (in_array($finalStatus, ['Diterima', 'Offering Letter'])) {
            TalentPool::create([
                'user_id' => $user->id,
                'status' => 'Shortlist',
                'job_preferences' => $job->title,
                'created_at' => $createdAt->copy()->addDays(rand(1, 3)),
                'updated_at' => $createdAt->copy()->addDays(rand(1, 3)),
            ]);
        }

        return true;
    }
}
