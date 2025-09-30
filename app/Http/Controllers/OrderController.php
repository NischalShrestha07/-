<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with search and pagination.
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->active();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('id', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%");
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $orders = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items.product.category', 'items.product.brand', 'user', 'coupon', 'address');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        // Prevent updating a cancelled order
        if ($order->status === 'cancelled') {
            return back()->withErrors(['status' => 'Cannot update a cancelled order.']);
        }

        // Update delivered_at or cancelled_at based on status
        if ($validated['status'] === 'delivered') {
            $validated['delivered_at'] = now();
            $validated['cancelled_at'] = null;
        } elseif ($validated['status'] === 'cancelled') {
            $validated['cancelled_at'] = now();
            $validated['delivered_at'] = null;
        } else {
            $validated['delivered_at'] = null;
            $validated['cancelled_at'] = null;
        }

        $order->update($validated);

        // Send email notification to user
        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}
