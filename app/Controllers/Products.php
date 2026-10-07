<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
{
    $products = $this->productModel->findAll();

    return view('products/index', [
        'products' => $products,
    ]);
}

    public function add()
    {
        return view('products/form', [
            'title' => 'Add Product',
            'product' => null,
        ]);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal',
            'stock_quantity' => 'required|integer',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
        }

        $this->productModel->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/products');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('products/form', [
            'title' => 'Edit Product',
            'product' => $product,
        ]);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal',
            'stock_quantity' => 'required|integer',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
            $data['image'] = $imageName;
        }

        $this->productModel->update($id, $data);

        return redirect()->to('/products');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);

        return redirect()->to('/products');
    }
}