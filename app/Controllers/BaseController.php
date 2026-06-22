<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Entities\Sidemenu;
use Doctrine\ORM\EntityManager;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
	
    protected EntityManager $entityManager;	

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->entityManager = service('doctrine')->getEntityManager();
		// Initialize default empty permissions
        $userPermissions = [];
        $routeName = null;
        $hasAccessToCurrentRoute = false;
		
		
		// Check if the user is logged in
        if (session()->get('isLoggedIn')) {
            $userId = session()->get('auth_user_id');
            
            // Fetch permissions from database
            $sql = "SELECT p.name AS permission_name
                    FROM users u
                    JOIN role_user ru ON ru.user_id = u.id
                    JOIN role r ON r.id = ru.role_id
                    JOIN permission_role pr ON pr.role_id = r.id
                    JOIN permissions p ON p.id = pr.permission_id
                    WHERE u.id = ?";
            
            $query = $this->entityManager->getConnection()->fetchAllAssociative($sql, [$userId]);
            $userPermissions = array_column($query, 'permission_name');
            
            // Add default global permissions
            $userPermissions[] = "admin.dashboard";
			$userPermissions[]="admin.profile.picture";
            $userPermissions[] = "admin.profile";
            $userPermissions[] = "auth.logout";
            $userPermissions[] = "logout";

            // Get the current route name
            $router = service('router');
            $routeOptions = $router->getMatchedRouteOptions();
            $routeName = $routeOptions['as'] ?? null;
             
				// Check if user has access to the current page route
				if ($routeName && in_array($routeName, $userPermissions, true)) {
					$hasAccessToCurrentRoute = true;
				}
			}
			
			
			
			// Share these variables globally across ALL views
			$this->globalData['userPermissions'] = $userPermissions;
			$this->globalData['currentRouteName'] = $routeName;
			
			$this->globalData['hasAccessToCurrentRoute'] = $hasAccessToCurrentRoute;
			
			$this->globalData['menuSelection'] = $this->getMenuComponents($routeName);
			service('renderer')->setData($this->globalData);
			 
    }
	
    
    protected function getMenuComponents(?string $routeAction = null): array
    {
		//echo $routeAction;exit;
        // 1. Initial check for empty parameter
        if (empty($routeAction)) {
            return [
                'tabname' => 'Settings',
                'action'  => 'admin.dashboard'
            ];
        }


        // 2. Fetch all valid sidebar rows from the database
        $menus = $this->entityManager->getRepository(Sidemenu::class)->findBy([
            'deletedAt' => null
        ]);
         
        // 3. Loop through database rows and cleanly explode their actions strings
        foreach ($menus as $menu) {
            // Explode comma-separated database string into a clean array
            $allowedActions = array_map('trim', explode(',', $menu->getActions()));
             
            // Strict matching inside the array elements
            if (in_array($routeAction, $allowedActions, true)) {
                return [
                    'tabname' => $menu->getTab(), // e.g., 'settings'
                    'action'  => $routeAction      // e.g., 'profile'
                ];
            }
        }

        // 4. Fallback structure if the route name isn't mapped in your DB table
        $fallbackTab = 'Settings';
        return [
            'tabname' => $fallbackTab,
            'action'  => 'admin.dashboard'
        ];
 		
    }
 	

}
