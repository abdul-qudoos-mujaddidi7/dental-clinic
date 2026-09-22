<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);


        // Define permissions
        $permissions = [
            'viewExpense',
            'addExpense',
            'updateExpense',
            'deleteExpense',

            'viewPeople',
            'addPeople',
            'updatePeople',
            'deletePeople',

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


        // Create permissions and assign them to Admin role
        foreach ($permissions as $permission) {

            $permissionModel = Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);

            $adminRole->givePermissionTo($permissionModel);
        }


        // Create Admin User
        $user = User::firstOrCreate(
            [
                'email' => '
                ',
            ],
            [
                'first_name' => 'Jawad',
                'last_name' => 'Mujaddidi',
                'phone' => '0784801901',
                'status' => 1,
                'password' => Hash::make('password'),
            ]
        );


        // Assign Admin Role to User
        if (!$user->hasRole('Admin')) {
            $user->assignRole($adminRole);
        }
    }
}