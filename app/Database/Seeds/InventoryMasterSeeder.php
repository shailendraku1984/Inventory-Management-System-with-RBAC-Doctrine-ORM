<?php

namespace App\Database\Seeds;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\TaxRate;
use App\Entities\Warehouse;
use CodeIgniter\Database\Seeder;

class InventoryMasterSeeder extends Seeder
{
    public function run(): void
    {
        $categoryService = service('categoryService');
        $branchService = service('branchService');
        $warehouseService = service('warehouseService');
        $taxRateRepository = service('taxRateRepository');

        if ($categoryService->list() === []) {
            foreach (['General', 'Grocery', 'Beverages'] as $name) {
                $categoryService->save(['name' => $name]);
            }
        }

        if ($branchService->list() === []) {
            $branchService->save(['name' => 'Main Branch', 'address' => 'Main market road']);
        }

        if ($warehouseService->list() === []) {
            $warehouseService->save(['name' => 'Primary Warehouse', 'address' => 'Industrial area']);
        }

        if ($taxRateRepository->allActive() === []) {
            foreach (['0%', '5%', '7%', '18%'] as $label) {
                $taxRate = (new TaxRate())
                    ->setLabel($label)
                    ->setStatus(TaxRate::STATUS_OPEN);

                $taxRateRepository->save($taxRate);
            }
        }
    }
}
