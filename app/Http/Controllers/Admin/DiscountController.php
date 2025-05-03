<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discount.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discount.create');
    }

    public function store(StoreDiscountRequest $request)
    {
        // Validasi input
        $data = $request->validated();

        // Instansiasi model Discount untuk generate promo code
        $discount = new Discount($data);

        // Generate promo code menggunakan method model
        $promoCode = $discount->generatePromoCode();

        // Set promo_code di data
        $data['promo_code'] = $promoCode;

        // Simpan data ke database
        Discount::create($data);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.discount.index')->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discount.edit', compact('discount'));
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->validated());

        return redirect()->route('admin.discount.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('admin.discount.index')->with('success', 'Diskon berhasil dihapus!');
    }
}
