<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class EmployeeProfileController extends BaseController
{
    public function show(int $userId): string|RedirectResponse
    {
        $user = service('employeeService')->find($userId);

        if ($user === null) {
            return redirect()->to(url_to('employee.index'))->with('error', 'Employee not found.');
        }

        return view('admin/employee/profile', [
            'title' => 'Employee Profile',
            'item' => $user,
            'profile' => service('employeeService')->profileFor($userId),
        ]);
    }
}
