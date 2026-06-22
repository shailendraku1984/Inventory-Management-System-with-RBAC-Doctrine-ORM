<?php

namespace App\Controllers;

class BranchController extends AbstractNamedResourceController
{
    protected function serviceName(): string { return 'branchService'; }
    protected function viewPath(): string { return 'admin/branches'; }
    protected function routePrefix(): string { return 'branches'; }
    protected function title(): string { return 'Branches'; }
    protected function hasAddress(): bool { return true; }
}
