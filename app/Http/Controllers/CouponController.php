<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons with search and pagination.
     */
    public function index(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('code', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
        }

        $coupons = $query->paginate(10)->appends($request->query());

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:20',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
            'max_discount' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Convert code to uppercase for consistency
        $validated['code'] = strtoupper($validated['code']);
        $validated['used_count'] = 0; // Initialize used count

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id . '|max:20',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
            'max_discount' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Convert code to uppercase
        $validated['code'] = strtoupper($validated['code']);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        // Prevent deletion if coupon is used in orders (implement if orders relation exists)
        // if ($coupon->orders()->count() > 0) {
        //     return back()->withErrors(['error' => 'Cannot delete coupon used in orders.']);
        // }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
