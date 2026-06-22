<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Entities\Expense;
use App\Interfaces\ExpenseServiceInterface;
use Exception;

class ExpenseController extends BaseController
{
	
    protected ExpenseServiceInterface $expenseService;

    public function __construct()
    {
        // Inject the unified business service layer interface
        $this->expenseService = \Config\Services::expenseService();
    }
	
    public function index(): string
    {
        return view('admin/expenses/index', [
            'title' => 'Expenses',
            'items' => $this->expenseService->getActiveExpenses(),
        ]);
    }
	
    public function create(): string
    {
        return view('admin/expenses/form', [
            'title'   => 'Add Expense',
            'item'    => null,
            'options' => $this->expenseService->getHeads(),
            'depart'  => $this->expenseService->getDepartments(),
            'account' => $this->expenseService->getAccounts(),
        ]);
    }
	
    public function edit(int $id): string|RedirectResponse
    {
        $expense = $this->expenseService->findExpense($id);
		 
        if ($expense === null) {
            return redirect()->to(url_to('expenses/index'))->with('error', 'Expense not found.');
        }

        return view('admin/expenses/form', [
            'title'   => 'Update Expense',
            'item'    => $expense,
            'options' => $this->expenseService->getHeads(),
            'depart'  => $this->expenseService->getDepartments(),
            'account' => $this->expenseService->getAccounts(),
        ]);
    }
	
    public function store()
    {
        $expense = new Expense();
        return $this->handleSave($expense, 'Expense created successfully!');
    }
	
    public function update($id)
    {
        $expense = $this->expenseService->findExpense((int)$id);

        if (! $expense) {
            return redirect()->to('expenses/index')->with('error', 'Expense not found.');
        }

        return $this->handleSave($expense, 'Expense updated successfully!');
    }
	
    private function handleSave(Expense $expense, string $successMessage)
    {
        $rules = [
            'value_date'   => 'required|valid_date[Y-m-d]',
            'label'        => 'required|min_length[2]|max_length[180]',
            'accountId'    => 'required|is_natural_no_zero',
            'headId'       => 'required|is_natural_no_zero',
            'departmentId' => 'required|is_natural_no_zero',
            'price'        => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        try {
            // Hand off the work to the service layer smoothly
            $this->expenseService->saveExpense($expense, $this->request);
            return redirect()->to('expenses/index')->with('success', $successMessage);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Process Error: ' . $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        $expense = $this->expenseService->findExpense($id);

        if ($expense === null) {
            return redirect()->to('expenses/index')->with('error', 'Expense not found.');
        }

        try {
            $this->expenseService->softDeleteExpense($expense);
            return redirect()->to('expenses/index')->with('success', 'Expense deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Process Error: ' . $e->getMessage());
        }
    }
}
