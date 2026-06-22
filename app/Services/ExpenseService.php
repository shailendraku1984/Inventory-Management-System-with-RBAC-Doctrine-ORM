<?php

namespace App\Services;

use App\Entities\Expense;
use App\Entities\Head;
use App\Entities\Department;
use App\Entities\Account;
use App\Interfaces\ExpenseServiceInterface;
use CodeIgniter\HTTP\IncomingRequest;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class ExpenseService implements ExpenseServiceInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getActiveExpenses(): array
    {
        return $this->em->getRepository(Expense::class)->findBy(['deletedAt' => null], ['id' => 'DESC']);
    }

    public function findExpense(int $id): ?Expense
    {
        return $this->em->getRepository(Expense::class)->find($id);
    }

    public function saveExpense(Expense $expense, IncomingRequest $request): void
    {
        // Handle file upload
        $img = $request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            if ($expense->getImage() && file_exists(FCPATH . 'uploads/expenses/' . $expense->getImage())) {
                unlink(FCPATH . 'uploads/expenses/' . $expense->getImage());
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/expenses', $newName);
            $expense->setImage($newName);
        }

        // Map text fields
        $expense->setLabel($request->getPost('label'));
        $expense->setDescription($request->getPost('description'));
        $expense->setPrice($request->getPost('price'));
        
        // Explicitly cast relationships to integers
        $expense->setAccountId((int) $request->getPost('accountId'));
        $expense->setHeadId((int) $request->getPost('headId'));
        $expense->setDepartmentId((int) $request->getPost('departmentId'));

        // Process strings into native PHP DateTime objects
        $dateString = $request->getPost('value_date');
        if ($dateString) {
            $expense->setValueDate(new DateTime($dateString));
        }

        if ($expense->getId() !== null) {
            $expense->setModifyAt(new DateTime());
        }

        if ($expense->getId() === null) {
            $this->em->persist($expense);
        }
        
        $this->em->flush();
    }

    public function softDeleteExpense(Expense $expense): void
    {
        $expense->setDeletedAt(new DateTime());
        $this->em->flush();
    }

    public function getHeads(): array
    {
        return $this->em->getRepository(Head::class)->findAll();
    }

    public function getDepartments(): array
    {
        return $this->em->getRepository(Department::class)->findAll();
    }

    public function getAccounts(): array
    {
        return $this->em->getRepository(Account::class)->findAll();
    }
}
