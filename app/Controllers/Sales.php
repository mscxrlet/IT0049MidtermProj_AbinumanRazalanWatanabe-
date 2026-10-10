<<<<<<< HEAD
<?php

=======
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
<<<<<<< HEAD
    public function index()
    {
        $saleModel = new SaleModel();

        return view('sales/index', [
            'sales' => $saleModel->getSalesHistory()
        ]);
    }

    public function create()
=======
    // Task 7: Sales History Page
    public function index()
    {
        $saleModel = new SaleModel();
        $data['sales'] = $saleModel->getSalesHistory();

        return view('sales/index', $data);
    }

    // Task 6: Show Record Sale Form
    plat public function create()
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

<<<<<<< HEAD
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
=======
        $data['products'] = $productModel->findAll();
        $data['customers'] = $customerModel->findAll();

        return view('sales/create', $data);
    }

    // Task 6: Process Record Sale & Stock Deduction
    public function store()
    {
        $session = session();
        $saleModel = new SaleModel();
        $productModel = new ProductModel();
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2

        $productId = $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');

        $product = $productModel->find($productId);

        if (!$product) {
<<<<<<< HEAD
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
=======
            return redirect()->back()->with('error', 'Selected product does not exist.');
        }

        // Validate stock availability
        if ($quantity > $product['stock_quantity']) {
            return redirect()->back()->with('error', 'Sale rejected: Requested quantity exceeds available stock (' . $product['stock_quantity'] . ').')->withInput();
        }

        $totalPrice = $product['price'] * $quantity;
        $staffId = $session->get('user_id'); // Assuming staff session stores user ID

        // Use database transactions for data consistency
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Record the sale
        $saleModel->save([
            'product_id'  => $productId,
            'customer_id' => !empty($customerId) ? $customerId : null,
            'sold_by'     => $staffId,
            'quantity'    => $quantity,
            'total_price' => $totalPrice,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // 2. Decrease product stock quantity
        $newStock = $product['stock_quantity'] - $quantity;
        $productModel->update($productId, ['stock_quantity' => $newStock]);
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2

        $db->transComplete();

        if ($db->transStatus() === false) {
<<<<<<< HEAD
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Sale transaction failed.');
        }

        return redirect()
            ->to('/sales')
            ->with('success', 'Sale recorded successfully.');
=======
            return redirect()->back()->with('error', 'Transaction failed. Please try again.');
        }

        return redirect()->to('/sales')->with('success', 'Sale recorded successfully!');
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
    }
}