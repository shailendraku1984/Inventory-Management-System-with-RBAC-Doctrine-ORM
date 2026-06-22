<?php

namespace App\Controllers;

class WarehouseController extends AbstractNamedResourceController
{
    protected function serviceName(): string { return 'warehouseService'; }
    protected function viewPath(): string { return 'admin/warehouses'; }
    protected function routePrefix(): string { return 'warehouses'; }
    protected function title(): string { return 'Stores'; }
    protected function hasAddress(): bool { return true; }
}
