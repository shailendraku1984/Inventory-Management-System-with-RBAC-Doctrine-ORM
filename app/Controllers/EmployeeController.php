<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;

class EmployeeController extends BaseController
{
     
    public function index(): string
    {
        return view('admin/employee/index', [
            'title' => 'Employee',
            'items' => service('employeeService')->list(),
            'profiles' => $this->profileMap(),
        ]);
    }

    public function create(): string
    {
        return view('admin/employee/form', [
            'title' => 'Add Employee',
            'item' => null,
            'profile' => null,
            'options' => service('employeeService')->formOptions(),
        ]);
    }

    public function store(): RedirectResponse
    {
        return $this->persist();
		
    }

    public function edit(int $id): string|RedirectResponse
    {
        $item = service('employeeService')->find($id);

        if ($item === null) {
            return redirect()->to(url_to('employee.index'))->with('error', 'Employee not found.');
        }

        return view('admin/employee/form', [
            'title' => 'Edit Employee',
            'item' => $item,
            'profile' => service('employeeService')->profileFor($id),
            'options' => service('employeeService')->formOptions(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        return $this->persist($id);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            service('employeeService')->delete($id);

            return redirect()->to(url_to('employee.index'))->with('success', 'Employee deleted.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    private function persist(?int $id = null): RedirectResponse
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'email' => 'required|valid_email|max_length[180]',
            'role' => 'required|in_list[1,2,3,4]',
            'is_active' => 'permit_empty|in_list[0,1]',
            'branch_id' => 'permit_empty|is_natural_no_zero',
            'salary' => 'permit_empty|numeric',
            'address' => 'permit_empty|max_length[255]',
            'emp_code' => 'permit_empty|max_length[50]',
            'picture' => 'permit_empty|is_image[picture]|max_size[picture,2048]|mime_in[picture,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
        ];

        if ($id === null || (string) $this->request->getPost('password') !== '') {
            $rules['password'] = 'required|min_length[8]|max_length[255]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        try {
            service('employeeService')->saveWithProfile(
                $this->request->getPost(),
                $this->request->getFile('picture'),
                $id
            );
			 
            return redirect()->to(url_to('employee.index'))->with('success', 'Employee saved.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }
    }

    private function profileMap(): array
    {
        $profiles = [];

        foreach (service('employeeService')->list() as $item) {
            $profiles[(int) $item->getId()] = service('employeeService')->profileFor((int) $item->getId());
        }

        return $profiles;
    }
}
