<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Purchase, PurchaseItem, Product, Customer};
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->customer = $this->user->customer;
            return $next($request);
        });
    }

    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view_purchases')) {
            abort(403);
        }

        $purchases = Purchase::where('customer_id', Auth::user()->customer->id)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    public function purchase(Request $request, Product $product)
    {
        if (!Auth::user()->hasPermissionTo('make_purchase')) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Get the customer and ensure it exists
        $user = Auth::user();
        $customer = $user->customer;

        if (!$customer) {
            // Create customer record if it doesn't exist
            $customer = Customer::create([
                'user_id' => $user->id,
                'credit' => 0.00
            ]);
        }

        // Explicitly convert to float and integer to ensure proper comparison
        $price = (float) $product->price;
        $quantity = (int) $request->quantity;
        $total = $price * $quantity;
        $creditBalance = (float) $customer->credit;

        // Check if customer has enough credit (with float comparison)
        if ($creditBalance < $total) {
            return redirect()->back()->with('error', "Insufficient credit! You need \${$total} but your balance is \${$creditBalance}");
        }

        // Check if enough stock is available
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        DB::beginTransaction();

        try {
            // Create purchase
            $purchase = Purchase::create([
                'customer_id' => $customer->id,
                'total' => $total
            ]);

            // Create purchase item
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price
            ]);

            // Update customer credit
            $customer->credit = $creditBalance - $total;
            $customer->save();

            // Update stock
            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Purchase completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred during purchase: ' . $e->getMessage());
        }
    }
}
