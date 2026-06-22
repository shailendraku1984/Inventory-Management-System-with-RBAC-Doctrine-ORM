<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class RoleController extends BaseController
{
    public function index(): string
    {
        return view('admin/roles/index', [
            'title' => 'Roles',
            'items' => service('roleService')->listWithPermissions(),
        ]);
    }

    public function edit(int $id): string|RedirectResponse
    {
        $data = service('roleService')->getEditData($id);

        if ($data === null) {
            return redirect()->to(base_url('roles/index'))->with('error', 'Role not found.');
        }

        return view('admin/roles/edit', [
            'title' => 'Edit Role Permissions: ' . esc($data['role']['name']),
            'role' => $data['role'],
            'allPermissions' => $data['allPermissions'],
            'activePermissionIds' => $data['activePermissionIds'],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $checkedPermissions = $this->request->getPost('permissions') ?? [];

        if (! service('roleService')->updatePermissions($id, $checkedPermissions)) {
            return redirect()->back()->withInput()->with('error', 'Database error: Could not save permissions.');
        }

        return redirect()->to(base_url('roles/index'))->with('success', 'Role permissions updated successfully!');
    }
}
