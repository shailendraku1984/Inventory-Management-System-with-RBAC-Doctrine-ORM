<?php

namespace App\Interfaces;

use App\Entities\Expense;
use CodeIgniter\HTTP\IncomingRequest;

interface ExpenseServiceInterface
{
    public function getActiveExpenses(): array;
    public function findExpense(int $id): ?Expense;
    public function saveExpense(Expense $expense, IncomingRequest $request): void;
    public function softDeleteExpense(Expense $expense): void;
    public function getHeads(): array;
    public function getDepartments(): array;
    public function getAccounts(): array;
}
