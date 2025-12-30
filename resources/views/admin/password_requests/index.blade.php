@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Permintaan Reset Password</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800">{{ session('status') }}</div>
    @endif

    <table class="w-full bg-white rounded-lg shadow-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3">ID</th>
                <th class="p-3">Email</th>
                <th class="p-3">Status</th>
                <th class="p-3">Dibuat</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
            <tr class="border-b">
                <td class="p-3">{{ $r->id }}</td>
                <td class="p-3">{{ $r->email }}</td>
                <td class="p-3">{{ ucfirst($r->status) }}</td>
                <td class="p-3">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                <td class="p-3">
                    <a href="{{ route('admin.password_requests.show', $r) }}" class="text-blue-600 hover:underline">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $requests->links() }}</div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Permintaan Reset Password</h2>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 text-green-800">{{ session('status') }}</div>
    @endif

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Email</th>
                <th class="p-2 text-left">Status</th>
                <th class="p-2 text-left">Dibuat</th>
                <th class="p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
                <tr class="border-t">
                    <td class="p-2">{{ $r->id }}</td>
                    <td class="p-2">{{ $r->email }}</td>
                    <td class="p-2">{{ ucfirst($r->status) }}</td>
                    <td class="p-2">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-2">
                        <a href="{{ route('admin.password_requests.show', $r) }}" class="px-3 py-1 bg-blue-600 text-white rounded">Lihat</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $requests->links() }}</div>
</div>
@endsection
