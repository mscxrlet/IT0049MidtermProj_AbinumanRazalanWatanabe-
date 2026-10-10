namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    // Task 7: Sales History Page
    public function index()
    {
        $saleModel = new SaleModel();
        $data['sales'] = $saleModel->getSalesHistory();

        return view('sales/index', $data);
    }

    // Task 6: Show Record Sale Form
    plat public function create()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

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

        $productId = $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');

        $product = $productModel->find($productId);

        if (!$product) {
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

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Transaction failed. Please try again.');
        }

        return redirect()->to('/sales')->with('success', 'Sale recorded successfully!');
    }
}