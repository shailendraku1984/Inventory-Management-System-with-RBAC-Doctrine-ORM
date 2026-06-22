<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;

class ProductController extends BaseController
{
    public function index(): string
    {
        return view('admin/products/index', [
            'title' => 'Products',
            'products' => service('productService')->list(),
            'options' => service('productService')->formOptions(),
        ]);
    }

    public function create(): string
    {
        return view('admin/products/form', [
            'title' => 'Add Product',
            'product' => null,
            'options' => service('productService')->formOptions(),
        ]);
    }

    public function store(): RedirectResponse
    {
        return $this->persist();
    }

    public function edit(int $id): string|RedirectResponse
    {
        $product = service('productService')->find($id);

        if ($product === null) {
            return redirect()->to(url_to('products.index'))->with('error', 'Product not found.');
        }

        return view('admin/products/form', [
            'title' => 'Edit Product',
            'product' => $product,
            'options' => service('productService')->formOptions(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        return $this->persist($id);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            service('productService')->delete($id);

            return redirect()->to(url_to('products.index'))->with('success', 'Product deleted.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    private function persist(?int $id = null): RedirectResponse
    {
        $rules = [
            'type' => 'required|in_list[kg,litre,qty]',
            'name' => 'required|min_length[2]|max_length[180]',
            'sku' => 'required|min_length[2]|max_length[80]',
            'categoryId' => 'required|is_natural_no_zero',
            'branchId' => 'required|is_natural_no_zero',
            'warehouseId' => 'required|is_natural_no_zero',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'tax_rate_id' => 'required|is_natural_no_zero',
            'for_sale' => 'required|in_list[For sale,Not for sale]',
            'for_purchase' => 'required|in_list[For purchase,Not for purchase]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        try {
            service('productService')->saveWithImage(
                $this->request->getPost(),
                $this->request->getFile('image'),
                $id
            );

            return redirect()->to(url_to('products.index'))->with('success', 'Product saved.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }
    }
}
