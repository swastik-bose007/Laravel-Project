<?php

namespace Database\Seeders;

use App\Models\Category;

// Helper


// Model
use App\Models\Status;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\WeightUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUser extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /***** Create Role Start *****/
        // admin role
        $userRole = new UserRoles;
        $userRole->name = 'Admin';
        $userRole->description = 'Admin';
        $userRole->slug = 'admin';
        $userRole->save();

        // developer role
        $userRole = new UserRoles;
        $userRole->name = 'Developer';
        $userRole->description = 'Developer';
        $userRole->slug = 'developer';
        $userRole->save();

        // Role Farmers
        $userRole = new UserRoles;
        $userRole->name = 'Farmers';
        $userRole->description = 'Role One';
        $userRole->slug = 'farmers';
        $userRole->save();

        // FPO
        $userRole = new UserRoles;
        $userRole->name = 'FPO';
        $userRole->description = 'FPO';
        $userRole->slug = 'fpo';
        $userRole->save();

        // Sufal Store
        $userRole = new UserRoles;
        $userRole->name = 'Sufal Store';
        $userRole->description = 'Sufal Store';
        $userRole->slug = 'sufalstore';
        $userRole->save();

        // Administration
        $userRole = new UserRoles;
        $userRole->name = 'Administration';
        $userRole->description = 'Administration';
        $userRole->slug = 'administration';
        $userRole->save();

        // Bazar Mandi
        $userRole = new UserRoles;
        $userRole->name = 'Bazar Mandi';
        $userRole->description = 'Bazar Mandi';
        $userRole->slug = 'bazarmandi';
        $userRole->save();
        /***** Create Role End *****/

        /***** Create Status Start *****/
        // status inactive
        $userRole = new Status;
        $userRole->status_code = 0;
        $userRole->status_name = 'Inactive';
        $userRole->save();

        // status active
        $userRole = new Status;
        $userRole->status_code = 1;
        $userRole->status_name = 'Active';
        $userRole->save();

        // status request
        $userRole = new Status;
        $userRole->status_code = 2;
        $userRole->status_name = 'Request';
        $userRole->save();
        /***** Create Status End *****/

        /***** Create weight_unit Start *****/

        // weight gm
        $userRole = new WeightUnit;
        $userRole->weight_unit_name = 'Gram';
        $userRole->symbol = 'a';
        $userRole->status = 1;
        $userRole->tags  = 'gram';
        $userRole->slug = 'gram';
        $userRole->save();

        // weight kilogram
        $userRole = new WeightUnit;
        $userRole->weight_unit_name = 'Kilogram';
        $userRole->symbol = 'b';
        $userRole->status = 1;
        $userRole->tags  = 'kilogram';
        $userRole->slug = 'kilogram';
        $userRole->save();

        // weight tonne
        $userRole = new WeightUnit;
        $userRole->weight_unit_name = 'Tonne';
        $userRole->symbol = 'c';
        $userRole->status = 1;
        $userRole->tags  = 'tonne';
        $userRole->slug = 'tonne';
        $userRole->save();

        // weight milligram
        $userRole = new WeightUnit;
        $userRole->weight_unit_name = 'Milligram';
        $userRole->symbol = 'd';
        $userRole->status = 1;
        $userRole->tags  = 'milligram';
        $userRole->slug = 'milligram';
        $userRole->save();

        // weight litre
        $userRole = new WeightUnit;
        $userRole->weight_unit_name = 'Litre';
        $userRole->symbol = 'e';
        $userRole->status = 1;
        $userRole->tags  = 'litre';
        $userRole->slug = 'litre';
        $userRole->save();
        /***** Create weight_unit End *****/

        /***** Create User Start *****/
        // create admin
        $user = new User;
        $user->first_name = 'Admin';
        $user->last_name = 'Account';
        $user->adhar_no = 'ADMIN123456';
        $user->pan_no = 'ADMIN1234';
        $user->phone = '9876543209';
        $user->email = 'admin@iencodetech.com';
        $user->slug = 'admin';
        $user->tags = 'admin';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 1;
        $user->status = 1;
        $user->save();

        // create developer
        $user = new User;
        $user->first_name = 'Developer';
        $user->last_name = 'Account';
        $user->email = 'developer@iencodetech.com';
        $user->slug = 'developer';
        $user->tags = 'developer';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 2;
        $user->status = 1;
        $user->save();

        // create default farmers
        $user = new User;
        $user->first_name = 'Default';
        $user->last_name = 'Farmers';
        $user->adhar_no = 'FARMER123456';
        $user->pan_no = 'FARMER1234';
        $user->cin_no = 'FARMER123456789012345';
        $user->acc_no = 'FARMER12345678901234';
        $user->area = 'Kolkata';
        $user->district = 'Kolkata';
        $user->pincode = '700001';
        $user->phone = '9876543210';
        $user->email = 'farmers@iencodetech.com';
        $user->slug = 'farmers';
        $user->tags = 'farmers';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 3;
        $user->status = 1;
        $user->save();

        // create default FPO
        $user = new User;
        $user->first_name = 'Default';
        $user->last_name = 'FPO';
        $user->adhar_no = 'FPO123456789';
        $user->pan_no = 'FPO1234';
        $user->cin_no = 'FPO123456789234567';
        $user->registration_no = 'FPO123456789012345678';
        $user->area = 'Kolkata';
        $user->district = 'Kolkata';
        $user->pincode = '700001';
        $user->phone = '9876543211';
        $user->email = 'fpo@iencodetech.com';
        $user->slug = 'fpo';
        $user->tags = 'fpo';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 4;
        $user->status = 1;
        $user->save();

        // create default Sufal Store
        $user = new User;
        $user->first_name = 'Default';
        $user->last_name = 'Sufal Store';
        $user->sufal_store_type = 'big';
        $user->sufal_store_name = 'Default Sufal store';
        $user->registered_store_attendant_first_name = 'Demo';
        $user->registered_store_attendant_last_name = 'Attendant';
        $user->registered_store_attendant_adhar_no = '987654321000';
        $user->registered_store_attendant_phone = '9876543212';
        $user->area = 'Kolkata';
        $user->district = 'Kolkata';
        $user->pincode = '700001';
        $user->email = 'sufalstore@iencodetech.com';
        $user->slug = 'sufalstore';
        $user->tags = 'sufalstore';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 5;
        $user->status = 1;
        $user->save();

        // create default Administration
        $user = new User;
        $user->first_name = 'Default';
        $user->last_name = 'Administration';
        $user->adhar_no = 'ADMINI123456';
        $user->pan_no = 'ADMINI1234';
        $user->email = 'administration@iencodetech.com';
        $user->phone = '9876543214';
        $user->slug = 'administration';
        $user->tags = 'administration';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 6;
        $user->status = 1;
        $user->save();

        // create default Bazar Mandi
        $user = new User;
        $user->first_name = 'Default';
        $user->last_name = 'Bazar Mandi';
        $user->bazar_mandi_name = 'Default Bazar mandi';
        $user->bazar_mandi_type = 'big';
        $user->registered_store_attendant_first_name = 'Demo';
        $user->registered_store_attendant_last_name = 'Attendant';
        $user->registered_store_attendant_adhar_no = '987654321000';
        $user->registered_store_attendant_phone = '9876543215';
        $user->area = 'Kolkata';
        $user->district = 'Kolkata';
        $user->pincode = '700001';
        $user->email = 'bazarmandi@iencodetech.com';
        $user->slug = 'bazarmandi';
        $user->tags = 'bazarmandi';
        $user->password = Hash::make('P@ss32321');
        $user->user_type = 7;
        $user->status = 1;
        $user->save();
        /***** Create User End *****/
    }

}
