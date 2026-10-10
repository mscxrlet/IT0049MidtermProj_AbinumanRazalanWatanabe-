<<<<<<< HEAD
<?php

=======
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
<<<<<<< HEAD

    protected $allowedFields = [
        'product_id',
        'customer_id',
        'sold_by',
        'quantity',
        'total_price',
        'created_at'
    ];

    protected $useTimestamps = false;

    public function getSalesHistory()
    {
        return $this
            ->select(
                'sales.*, 
                products.name AS product_name,
                customers.full_name AS customer_name,
                users.full_name AS staff_name'
            )
            ->join('products', 'products.id = sales.product_id')
            ->join(
                'customers',
                'customers.id = sales.customer_id',
                'left'
            )
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.created_at', 'DESC')
            ->findAll();
=======
    protected $allowedFields = ['product_id', 'customer_id', 'sold_by', 'quantity', 'total_price', 'created_at'];

    // Fetches past transactions joined with product, customer, and staff details (Task 7)
    public function getSalesHistory()
    {
        return $this->select('sales.*, products.name as product_name, customers.full_name as customer_name, users.full_name as staff_name')
                    ->join('products', 'products.id = sales.product_id')
                    ->join('customers', 'customers.id = sales.customer_id', 'left') // Customer is optional
                    ->join('users', 'users.id = sales.sold_by')
                    ->orderBy('sales.created_at', 'DESC')
                    ->findAll();
>>>>>>> 8422c52a77def85c6b2943d102f0b7f4ffac23a2
    }
}