@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Tambah Diskon</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.discount.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Promo</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="promo_code" class="form-label">Kode Promo</label>
                <input type="text" class="form-control @error('promo_code') is-invalid @enderror" id="promo_code"
                    name="promo_code" value="{{ old('promo_code') }}" readonly="readonly" required>
                @error('promo_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipe Diskon</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="global" {{ old('type') == 'global' ? 'selected' : '' }}>Global</option>
                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount_type" class="form-label">Jenis Diskon</label>
                <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type"
                    name="discount_type" required>
                    <option value="">-- Pilih Jenis Diskon --</option>
                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Persentase (%)
                    </option>
                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Tetap (Rp)</option>
                </select>
                @error('discount_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="discount_amount" class="form-label">Jumlah Diskon</label>
                <input type="number" class="form-control @error('discount_amount') is-invalid @enderror"
                    id="discount_amount" name="discount_amount" value="{{ old('discount_amount') }}" required>
                @error('discount_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                        id="start_date" name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label for="end_date" class="form-label">Tanggal Berakhir</label>
                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                        name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Public" {{ old('status') == 'Public' ? 'selected' : '' }}>Public</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Diskon</button>
            <a href="{{ route('admin.discount.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const promoCodeInput = document.getElementById('promo_code');

            // Fungsi untuk menghasilkan kode promo
            function generatePromoCode(name) {
                if (!name) return '';
                const baseCode = name.replace(/\s+/g, '').toUpperCase();
                const randomSuffix = Math.floor(1000 + Math.random() * 9000);
                return baseCode + randomSuffix;
            }

            // Ganti event dari input ke keydown dan cek apakah tombol Enter ditekan
            nameInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Hindari form submit saat Enter
                    const generatedPromoCode = generatePromoCode(this.value);
                    promoCodeInput.value = generatedPromoCode;
                }
            });

            // Supaya promo_code selalu uppercase walau diedit manual
            promoCodeInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@endsection
