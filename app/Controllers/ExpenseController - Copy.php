<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RedirectResponse; // Make sure this is at the top of your file!
use Doctrine\ORM\EntityManagerInterface; 
use App\Entities\Expense;
use App\Entities\Head;
use App\Entities\Department;
use App\Entities\Account;
use DateTime;
use Exception;


class ExpenseController extends BaseController
{
    protected $em;
	
    public function __construct() {
      $this->em = \Config\Services::doctrine()->getEntityManager();
    }
	
	
    public function index(): string
    {
        // 2. Get the Expense table repository
        $repository = $this->em->getRepository(Expense::class);
        $records = $repository->findBy(['deletedAt' => null], ['id' => 'DESC']);
        // 3. Fetch all records as objects
        //$records = $repository->findAll();
		//print_r($records);
		//exit;
        
        // 4. Pass the objects securely to your view file
        return view('admin/expenses/index', [
            'title' => 'Expenses',
            'items' => $records,
        ]);
    }
	
	public function create(): string
    {
        return view('admin/expenses/form', [
            'title' => 'Add Expense',
            'item' => null,
            'options' => $this->getHeads(),
			'depart'=> $this->getDepartment(),
			'account'=> $this->getAccount(),
        ]);
    }
	
	public function edit(int $id): string|RedirectResponse
	{
		// 1. Get the repository
		$repository = $this->em->getRepository(Expense::class);
		
		// 2. Fixed: Use find($id) to fetch a single record by its ID
		$expense = $repository->find($id);
		 
		// 3. Redirect back if the item is missing
		if ($expense === null) {
			return redirect()->to(url_to('expenses.index'))->with('error', 'Expense not found.');
		}

		// 4. Send the record and dropdown arrays to your view form
		return view('admin/expenses/form', [
			'title'   => 'Update Expense',
			'item'    => $expense,
			'options' => $this->getHeads(),
			'depart'  => $this->getDepartment(),
			'account' => $this->getAccount(),
		]);
	}
	
	
	public function store()
    {
        $expense = new Expense();
        return $this->saveExpense($expense, 'Expense created successfully!');
    }
	
	
	public function update($id)
    {
        $expense = $this->em->find(Expense::class, $id);

        if (! $expense) {
            return redirect()->to('/expenses')->with('error', 'Expense not found.');
        }

        return $this->saveExpense($expense, 'Expense updated successfully!');
    }
	
	
	
	private function saveExpense(Expense $expense, string $successMessage)
    {
        // 1. Setup unified validation rules
        $rules = [
            'value_date'   => 'required|valid_date[Y-m-d]',
            'label'        => 'required|min_length[2]|max_length[180]',
            'accountId'    => 'required|is_natural_no_zero',
            'headId'       => 'required|is_natural_no_zero',
            'departmentId' => 'required|is_natural_no_zero',
            'price'        => 'required|numeric',
        ];

        // 2. Run text validation
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        // 3. Handle file upload if a new file is sent
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && ! $img->hasMoved()) {
            
            $imageRules = [
                'image' => [
                    'label' => 'Image File',
                    'rules' => [
                        'is_image[image]',
                        'mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                        'max_size[image,2048]',
                    ],
                ],
            ];

            if (! $this->validate($imageRules)) {
                return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
            }

            // Optional: Delete the old physical file if updating an existing record
            if ($expense->getImage() && file_exists(FCPATH . 'uploads/expenses/' . $expense->getImage())) {
                unlink(FCPATH . 'uploads/expenses/' . $expense->getImage());
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/expenses', $newName);
            
            $expense->setImage($newName);
        }

        // 4. Populate entity data values
        $expense->setLabel($this->request->getPost('label'));
        $expense->setDescription($this->request->getPost('description'));
        $expense->setPrice($this->request->getPost('price'));
        
        $expense->setAccountId((int) $this->request->getPost('accountId'));
        $expense->setHeadId((int) $this->request->getPost('headId'));
        $expense->setDepartmentId((int) $this->request->getPost('departmentId'));

        // Handle date string to DateTime conversion
        $dateString = $this->request->getPost('value_date');
        if ($dateString) {
            $expense->setValueDate(new \DateTime($dateString));
        }

        // Set modification timestamp if it is an update action
        if ($expense->getId() !== null) {
            $expense->setModifyAt(new \DateTime());
        }

        // 5. Database execution block
        try {
            // Only need to run persist on brand new items
            if ($expense->getId() === null) {
                $this->em->persist($expense);
            }
            
            $this->em->flush();
            
            return redirect()->to('/expenses')->with('success', $successMessage);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }
	
	

	public function delete(int $id)
	{
		// 1. Find the existing record by its ID
		$repository = $this->em->getRepository(Expense::class);
		$expense = $repository->find($id);

		// 2. Redirect back with an error if it does not exist
		if ($expense === null) {
			return redirect()->to('/expenses')->with('error', 'Expense not found.');
		}

		// 3. Perform the Soft Delete by setting the current date and time
		$expense->setDeletedAt(new DateTime());

		// 4. Save the update to the database
		try {
			$this->em->flush();
			return redirect()->to('/expenses')->with('success', 'Expense deleted successfully!');
		} catch (Exception $e) {
			return redirect()->back()->with('error', 'Database Error: ' . $e->getMessage());
		}
	}

	
	public function getHeads(): array
    {
         $repository = $this->em->getRepository(Head::class);
        // 3. Fetch all records as objects
        return $records = $repository->findAll();
		//$records = $repository->findAll();
    }
	
	public function getDepartment(): array
    {
         $repository = $this->em->getRepository(Department::class);
        
        // 3. Fetch all records as objects
		
        return $records = $repository->findAll();
		//$records = $repository->findAll();
		 
		
    }
	
	public function getAccount(): array
    {
         $repository = $this->em->getRepository(Account::class);
        
        // 3. Fetch all records as objects
		
        return $records = $repository->findAll();
		//$records = $repository->findAll();
		 
		
    }
	
	
}
	 
 
