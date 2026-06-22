<?php

namespace App\Controllers;

class CategoryController extends AbstractNamedResourceController
{
    protected function serviceName(): string { return 'categoryService'; }
    protected function viewPath(): string { return 'admin/categories'; }
    protected function routePrefix(): string { return 'categories'; }
    protected function title(): string { return 'Categories'; }
}
