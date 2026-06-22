<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Libraries\Doctrine;
use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\Warehouse;
use App\Interfaces\Repository\BranchRepositoryInterface;
use App\Interfaces\Repository\EmployeeRepositoryInterface;
use App\Interfaces\Repository\CategoryRepositoryInterface;
use App\Interfaces\Repository\PermissionRepositoryInterface;
use App\Interfaces\Repository\ProductRepositoryInterface;
use App\Interfaces\Repository\ProductUpdateHistoryRepositoryInterface;
use App\Interfaces\Repository\RoleRepositoryInterface;
use App\Interfaces\Repository\RoleUserRepositoryInterface;
use App\Interfaces\Repository\TaxRateRepositoryInterface;
use App\Interfaces\Repository\UserRepositoryInterface;
use App\Interfaces\Repository\UserProfileRepositoryInterface;
use App\Interfaces\Repository\WarehouseRepositoryInterface;
use App\Interfaces\Service\AuthServiceInterface;
use App\Interfaces\Service\CrudServiceInterface;
use App\Interfaces\Service\EmployeeServiceInterface;
use App\Interfaces\Service\ProductServiceInterface;
use App\Interfaces\Service\ProfileServiceInterface;
use App\Interfaces\Service\RoleServiceInterface;
use App\Repositories\BranchRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductUpdateHistoryRepository;
use App\Repositories\RoleRepository;
use App\Repositories\RoleUserRepository;
use App\Repositories\TaxRateRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserProfileRepository;
use App\Repositories\WarehouseRepository;
use App\Services\AuthService;
use App\Services\EmployeeService;
use App\Services\NamedEntityService;
use App\Services\ProductService;
use App\Services\ProfilePictureStorage;
use App\Services\ProfileService;
use App\Services\RoleService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    public static function doctrine($getShared = true): Doctrine
    {
        if ($getShared) {
            return static::getSharedInstance('doctrine');
        }

        return new Doctrine();
    }
	
	public static function expenseService($getShared = true)
	{
		if ($getShared) {
			return static::getSharedInstance('expenseService');
		}

		$em = static::doctrine()->getEntityManager();
		return new \App\Services\ExpenseService($em);
	}


    public static function userRepository($getShared = true): UserRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('userRepository');
        }

        return new UserRepository(static::doctrine()->getEntityManager());
    }

    public static function authService($getShared = true): AuthServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('authService');
        }

        return new AuthService(static::userRepository());
    }

    public static function profileService($getShared = true): ProfileServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('profileService');
        }

        return new ProfileService(
            static::userProfileRepository(),
            new ProfilePictureStorage()
        );
    }

    public static function categoryRepository($getShared = true): CategoryRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('categoryRepository');
        }

        return new CategoryRepository(static::doctrine()->getEntityManager());
    }

    public static function branchRepository($getShared = true): BranchRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('branchRepository');
        }

        return new BranchRepository(static::doctrine()->getEntityManager());
    }
	
	public static function employeeRepository($getShared = true): EmployeeRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('employeeRepository');
        }

        return new EmployeeRepository(static::doctrine()->getEntityManager());
    }

    public static function roleRepository($getShared = true): RoleRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('roleRepository');
        }

        return new RoleRepository(static::doctrine()->getEntityManager());
    }

    public static function permissionRepository($getShared = true): PermissionRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('permissionRepository');
        }

        return new PermissionRepository(static::doctrine()->getEntityManager());
    }

    public static function roleUserRepository($getShared = true): RoleUserRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('roleUserRepository');
        }

        return new RoleUserRepository(static::doctrine()->getEntityManager());
    }

    public static function roleService($getShared = true): RoleServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('roleService');
        }

        $entityManager = static::doctrine()->getEntityManager();

        return new RoleService(
            static::roleRepository(),
            static::permissionRepository(),
            static::roleUserRepository(),
            $entityManager
        );
    }

    public static function userProfileRepository($getShared = true): UserProfileRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('userProfileRepository');
        }

        return new UserProfileRepository(static::doctrine()->getEntityManager());
    }
	

    public static function warehouseRepository($getShared = true): WarehouseRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('warehouseRepository');
        }

        return new WarehouseRepository(static::doctrine()->getEntityManager());
    }

    public static function taxRateRepository($getShared = true): TaxRateRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('taxRateRepository');
        }

        return new TaxRateRepository(static::doctrine()->getEntityManager());
    }

    public static function productRepository($getShared = true): ProductRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('productRepository');
        }

        return new ProductRepository(static::doctrine()->getEntityManager());
    }

    public static function productUpdateHistoryRepository($getShared = true): ProductUpdateHistoryRepositoryInterface
    {
        if ($getShared) {
            return static::getSharedInstance('productUpdateHistoryRepository');
        }

        return new ProductUpdateHistoryRepository(static::doctrine()->getEntityManager());
    }

    public static function categoryService($getShared = true): CrudServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('categoryService');
        }

        return new NamedEntityService(static::categoryRepository(), Category::class);
    }

    public static function branchService($getShared = true): CrudServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('branchService');
        }

        return new NamedEntityService(static::branchRepository(), Branch::class, true);
    }
	
	public static function employeeService($getShared = true): EmployeeServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('employeeService');
        }

        return new EmployeeService(
            static::employeeRepository(),
            static::userProfileRepository(),
            static::roleRepository(),
            static::branchRepository()
        );
    }
	

    public static function warehouseService($getShared = true): CrudServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('warehouseService');
        }

        return new NamedEntityService(static::warehouseRepository(), Warehouse::class, true);
    }

    public static function productService($getShared = true): ProductServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('productService');
        }

        return new ProductService(
            static::productRepository(),
            static::categoryRepository(),
            static::branchRepository(),
            static::warehouseRepository(),
            static::taxRateRepository(),
            static::productUpdateHistoryRepository()
        );
    }

}
