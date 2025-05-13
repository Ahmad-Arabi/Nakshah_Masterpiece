<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminCouponsController extends Controller
{
    public function index(Request $request) {
        $query = Coupon::query();

        if ($request->has('search')) {
            $query->where('code', 'LIKE', "%{$request->search}%");
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->has('featured')) {
            $query->where('is_featured', $request->featured);
        }

        $coupons = $query->orderBy('updated_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('admin.coupons.table', compact('coupons'))->render();
        }
    
        return view('admin.coupons.index', compact('coupons'));
    
    }

    public function create() {
        
        return view('admin.coupons.create');

    }


    public function store(Request $request) {

        $validatedData = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:percentage,fixed',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        Coupon::create($validatedData); // Save the coupon
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        if (request()->ajax()) {
            // Render the edit modal view with the order data
            $view = view('admin.coupons.edit', compact('coupon'))->render();
            return response()->json(['html' => $view]);
        }

        // Fallback: Return a full view if the request is not AJAX (optional)
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code' => ['required','string', 'unique:' . Coupon::class . ',code,' . $id], 
            ['code.unique' => 'Coupon code already exists!'],
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:percentage,fixed',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $coupon = Coupon::findOrFail($id);

        $coupon->update($validatedData);
        return redirect()->back()->with('success', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupons = Coupon::findOrFail($id);
        $coupons->delete(); // This sets the 'deleted_at' timestamp

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
    }
}