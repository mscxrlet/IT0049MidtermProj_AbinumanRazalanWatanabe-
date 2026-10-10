<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    public function index()
    {
        $saleModel = new SaleModel();

        return view('sales/index', [
            'sales' => $saleModel->getSalesHistory()
        ]);
    }

    public function create()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

        return view('sales/create', [
            'products' => $productModel->findAll(),
            'customers' => $customerModel->findAll()
        ]);
    }

    public function store()
    {
        $rules = [
            'product_id' => 'required|integer',
            'customer_id' => 'permit_empty|integer',
            'quantity' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please enter valid sale details.');
        }

        $productModel = new ProductModel();
        $saleModel = new SaleModel();

        $productId = $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');

        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Selected product does not exist.');
        }

        if ($quantity > $product['stock_quantity']) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Sale rejected. Available stock: '
                    . $product['stock_quantity']
                );
        }

        $totalPrice = $product['price'] * $quantity;

        $db = \Config\Database::connect();

        $db->transStart();

        $saleModel->insert([
            'product_id' => $productId,
            'customer_id' => $customerId ?: null,
            'sold_by' => session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $productModel->update($productId, [
            'stock_quantity' => $product['stock_quantity'] - $quantity
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Sale transaction failed.');
        }

        return redirect()
            ->to('/sales')
            ->with('success', 'Sale recorded successfully.');
    }
}