<?php
namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrdersControllers extends Controller
{
    public function index()
    {
        // Ambil semua order
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        // Ambil semua produk untuk ditampilkan di form
        $products = Product::all();
        return view('admin.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Buat order baru
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;
        $products = [];

        foreach ($validated['products'] as $product) {
            $productModel = Product::find($product['id']);
            $quantity = $product['quantity'];
            $price = $productModel->price * $quantity;

            $products[] = [
                'id' => $productModel->id,
                'name' => $productModel->name,
                'quantity' => $quantity,
                'price' => $price
            ];

            $total += $price;
        }

        // Simpan detail produk dalam kolom JSON
        $order->update([
            'products' => $products,
            'total_price' => $total
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        // Ambil detail order dengan produk terkait dari JSON
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        // Ambil order dan produk untuk ditampilkan di form edit
        $order = Order::findOrFail($id);
        $products = Product::all();
        return view('admin.orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);

        $total = 0;
        $products = [];

        foreach ($validated['products'] as $product) {
            $productModel = Product::find($product['id']);
            $quantity = $product['quantity'];
            $price = $productModel->price * $quantity;

            $products[] = [
                'id' => $productModel->id,
                'name' => $productModel->name,
                'quantity' => $quantity,
                'price' => $price
            ];

            $total += $price;
        }

        // Update detail produk dalam kolom JSON
        $order->update([
            'products' => $products,
            'total_price' => $total
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
