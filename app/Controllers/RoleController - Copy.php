<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class RoleController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

     	
	public function index(): string
    {
  	
    $routesCollection = service('routes');
	$getRoutes  = $routesCollection->getRoutes('GET');
	$postRoutes = $routesCollection->getRoutes('POST');
	$allRoutes=array_merge($getRoutes,$postRoutes);
 
    $excludedModules = ['Auth', 'Order', 'Profile','TestDoctrine'];
    $db = \Config\Database::connect();
    $builder = $db->table('permissions');

    $insertedCount = 0;
    $updatedCount = 0;

    foreach ($allRoutes as $uri => $handler) {
		
		
        if (!is_string($handler)) {
            continue;
        }
        
		$uri = str_replace('([0-9]+)/', '', $uri);
		$uri = str_replace('/([0-9]+)', '/update', $uri);
		
		$moduleNam=explode("/",$uri);
		$moduleNam=$moduleNam[0];
		$uri= str_replace('/', '.', $uri);
		if($uri===$moduleNam){
			continue;
		}
		
		$handler2 = str_replace('\App\Controllers\\', '', $handler);
		$handler3 = str_replace('Controller', '', $handler2); 
		$handler4 = str_replace('/$1', '', $handler3);
		$parts = explode('::', $handler4);
		$moduleName=$parts[0];
		$actionName=$parts[1];
		$actionName=$moduleName.".".$actionName;
		 
		$actionName=$uri;
		  
        // Skip excluded modules
        if (in_array($moduleName, $excludedModules, true)) {
            continue; 
        }

        // 2. EXTRACT ACTION: Fetch the explicit 'as' alias name configured
        $actionName = $actionName ?? null;

        // Skip if the route doesn't have an action alias configured
        if (empty($actionName)) {
            continue;
        }
		
        // 3. DATABASE SYNC (Stable & Universal)
        $existing = $builder->where('name', $actionName)->get()->getRow();

        if ($existing) {
            // Update module categorization if it has changed
            if ($existing->module !== $moduleName) {
                $builder->where('id', $existing->id)->update([
                    'module' => $moduleName
                ]);
                $updatedCount++;
            }
        } else {
            // Insert fresh action record mapped to its module
            $builder->insert([
                'name'   => $actionName,   // e.g., 'categories.delete'
                'module' => $moduleName    // e.g., 'Category'
            ]);
            $insertedCount++;
        }
    }
    
    // --- Keep the rest of your roles and view rendering code exactly the same ---
    $roles = $this->db->table('roles')->where('id >', 1)->get()->getResultArray();
    $rolesWithPermissions = [];
    
    foreach ($roles as $role) {
        $query = $this->db->table('permission_role pr')
            ->select('p.name')
            ->join('permissions p', 'p.id = pr.permission_id')
            ->where('pr.role_id', $role['id'])
            ->get()
            ->getResultArray();
            
        $permissionNames = array_column($query, 'name');
        
        $badgedPermissions = array_map(function($name) {
            return '<span class="badge text-bg-success me-1 mb-1">' . esc($name) . '</span>';
        }, $permissionNames);
        
        $role['permissions_string'] = implode(' ', $badgedPermissions);
        $rolesWithPermissions[] = $role;
    }

    return view('admin/roles/index', [
        'title' => 'Roles',
        'items' => $rolesWithPermissions
    ]);
}

 

    /**
     * 2. Displays the Edit Role page with checkboxes
     */
    public function edit(int $id): string|RedirectResponse
    {
        $role = $this->db->table('role')->where('id', $id)->get()->getRowArray();
        
        if (!$role) {
            return redirect()->to(base_url('roles/index'))->with('error', 'Role not found.');
        }

        // Fetch all available system permissions
        $allPermissions = $this->db->table('permissions')->get()->getResultArray();

        // Get currently assigned permission IDs for this role
        $currentActive = $this->db->table('permission_role')
            ->where('role_id', $id)
            ->get()
            ->getResultArray();
        $activePermissionIds = array_column($currentActive, 'permission_id');

        return view('admin/roles/edit', [
            'title'               => 'Edit Role Permissions: ' . esc($role['name']),
            'role'                => $role,
            'allPermissions'      => $allPermissions,
            'activePermissionIds' => $activePermissionIds
        ]);
    }

     
	
	public function update(int $id): RedirectResponse
	{
		// Use CodeIgniter's native database connection tool if $this->db isn't set globally
		$db = isset($this->db) ? $this->db : \Config\Database::connect();
		
		$checkedPermissions = $this->request->getPost('permissions') ?? [];

		$db->transStart();

		// Wipe out old permission rules for this role
		$db->table('permission_role')->where('role_id', $id)->delete();

		// Insert fresh rows for checked boxes
		if (!empty($checkedPermissions)) {
			$insertData = [];
			foreach ($checkedPermissions as $perId) {
				$insertData[] = [
					'role_id'       => $id,
					'permission_id' => (int)$perId
				];
			}
			$db->table('permission_role')->insertBatch($insertData);
		}

		$db->transComplete();

		// Check if the transaction failed out completely due to foreign key errors
		if ($db->transStatus() === FALSE) {
			return redirect()->back()->withInput()->with('error', 'Database error: Could not save permissions.');
		}

		return redirect()->to(base_url('roles/index'))->with('success', 'Role permissions updated successfully!');
	}


}
