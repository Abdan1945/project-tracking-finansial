@extends('layouts.dashboard')

@section('content')
<h1>Edit Transaksi</h1>

<form action="{{ route('dashboard.transaksi.update', $transaksi->id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="{{ $transaksi->tanggal }}">
    </p>

    <p>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah" value="{{ $transaksi->jumlah }}">
    </p>

    <p>
        <label>Keterangan</label><br>
        <textarea name="keterangan">{{ $transaksi->keterangan }}</textarea>
    </p>

    <button type="submit">Update</button>
</form>
@endsection
