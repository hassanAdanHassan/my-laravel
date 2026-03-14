<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Delivery::with(['customer', 'creator']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return datatables()->of($query)
                ->addIndexColumn()
                ->make(true);
        }

        return view('delivery.index');
    }

    public function create()
    {
        $customers = Customer::all();
        $products = products::all();

        return view('delivery.create', compact('customers', 'products'));
    }

    public function store(StoreDeliveryRequest $request)
    {
        $delivery = Delivery::create([
            'customer_id' => $request->customer_id,
            'creater_id'  => auth()->id(),
            'destination' => $request->destination,
            'status'      => 'pending',
        ]);

        foreach ($request->items as $item) {
            $delivery->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => products::find($item['product_id'])->price,
            ]);
        }

        return redirect()->route('delivery.index')->with('success', 'Delivery created successfully.');
    }

    public function show(string $id)
    {
        $delivery = Delivery::with(['items.product', 'customer', 'creator'])->findOrFail($id);

        return view('delivery.show', compact('delivery'));
    }

    public function edit(string $id)
    {
        $delivery = Delivery::findOrFail($id);

        if (!$delivery->isEditable()) {
            abort(403, 'Only pending deliveries can be edited.');
        }

        $customers = Customer::all();
        $products = products::all();

        return view('delivery.edit', compact('delivery', 'customers', 'products'));
    }

    public function update(UpdateDeliveryRequest $request, string $id)
    {
        $delivery = Delivery::findOrFail($id);

        if (!$delivery->isEditable()) {
            abort(403, 'Only pending deliveries can be edited.');
        }

        $delivery->update([
            'customer_id' => $request->customer_id,
            'destination' => $request->destination,
        ]);

        $delivery->items()->delete();

        foreach ($request->items as $item) {
            $delivery->items()->create([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => products::find($item['product_id'])->price,
            ]);
        }

        return redirect()->route('delivery.show', $id)->with('success', 'Delivery updated successfully.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $delivery = Delivery::findOrFail($id);

        if ($delivery->isFinal()) {
            return redirect()->back()->with('error', 'Cannot update a delivery that is already delivered or cancelled.');
        }

        $newStatus = $request->status;

        if ($newStatus === 'in_transit') {
            $delivery->update([
                'status'        => 'in_transit',
                'in_transit_at' => now(),
            ]);
        } elseif ($newStatus === 'delivered') {
            $delivery->load('items');

            try {
                DB::transaction(function () use ($delivery) {
                    foreach ($delivery->items as $item) {
                        $product = products::lockForUpdate()->find($item->product_id);
                        if ($product->amount < $item->quantity) {
                            throw new \Exception("Insufficient stock for {$product->name}");
                        }
                        $product->decrement('amount', $item->quantity);
                    }
                    $delivery->update([
                        'status'       => 'delivered',
                        'delivered_at' => now(),
                    ]);
                });
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } elseif ($newStatus === 'cancelled') {
            $delivery->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Delivery status updated successfully.');
    }

    public function destroy(string $id)
    {
        $delivery = Delivery::findOrFail($id);

        if ($delivery->isFinal()) {
            abort(403, 'Cannot cancel a delivery that is already delivered or cancelled.');
        }

        $delivery->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('delivery.index')->with('success', 'Delivery cancelled successfully.');
    }
}
