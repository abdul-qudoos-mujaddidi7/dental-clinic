<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role as ModelsRole;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::create([
            'name' => 'Admin',
            'description' => 'Do Anything'
        ]);

        // Define permissions
        $permissions = [
            'viewExpense',
            'addExpense',
            'updateExpense',
            'deleteExpense',
            
            'viewDashboard',
            
            'viewAppointment',
            'addAppointment',
            'updateAppointment',
            'deleteAppointment',
            
            'viewDentist',
            'addDentist',
            'updateDentist',
            'deleteDentist',
            
            'viewUser',
            'addUser',
            'updateUser',
            'deleteUser',
            
            'viewPatient',
            'addPatient',
            'updatePatient',
            'deletePatient',
            
            'viewLead',
            'addLead',
            'updateLead',
            'deleteLead',
            
            'viewStage',
            'addStage',
            'updateStage',
            'deleteStage',
            
            'viewSetting',
            'addSetting',
            'updateSetting',
            'deleteSetting',
            
            'viewCategory',
            'addCategory',
            'updateCategory',
            'deleteCategory',
            
            'viewProduct',
            'addProduct',
            'updateProduct',
            'deleteProduct',
            
            'viewSupplier',
            'addSupplier',
            'updateSupplier',
            'deleteSupplier',
            
            'viewHrmOwner',
            'addHrmOwner',
            'updateHrmOwner',
            'deleteHrmOwner',
            
            'viewHrmPickup',
            'addHrmPickup',
            'updateHrmPickup',
            'deleteHrmPickup',
            
            'viewRolePermission',
            'addRolePermission',
            'updateRolePermission',
            'deleteRolePermission',
            
            'viewPayment',
            'addPayment',
            'updatePayment',
            'deletePayment',
            
            'viewService',
            'addService',
            'updateService',
            'deleteService',
            
            'viewServiceGroup',
            'addServiceGroup',
            'updateServiceGroup',
            'deleteServiceGroup',
            
            'viewExpenseCategory',
            'addExpenseCategory',
            'updateExpenseCategory',
            'deleteExpenseCategory',
            
            'viewCurePayment',
            'addCurePayment',
            'updateCurePayment',
            'deleteCurePayment',
            
            'viewCureDetails',
            'addCureDetails',
            'updateCureDetails',
            'deleteCureDetails',
            
            'viewCureCycle',
            'addCureCycle',
            'updateCureCycle',
            'deleteCureCycle',
            
            'viewCure',
            'addCure',
            'updateCure',
            'deleteCure',
            
            'viewBillExpense',
            'addBillExpense',
            'updateBillExpense',
            'deleteBillExpense',
        ];
        
        // Create permissions and assign them to the Admin role
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        // Create Admin User
        User::create([
            'first_name' => "Jawad", 
            'last_name' => "Mujaddidi",   
            'phone' => "0784801901",    
            'email' => "jawad@gmail.com", 
            'image' => "img.jpeg",       
            'status' => true,         
            'password' => bcrypt('12345678'),      
        ])->assignRole($adminRole); // Assign the Admin role to the user
    }
}
