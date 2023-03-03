<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultpwd = '12345678';
        $createMultipleUsers = [
            ['name' => 'AIZUDIN BIN ALI YEON', 'email' => 'aizudin@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MOHD REDZWAN BIN DAUD', 'email' => 'redzwan@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD AZHAR BIN ABDUL WAHID', 'email' => 'azhar@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'ABDUL \'AZIM BIN NORAZMI', 'email' => 'azim@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MOGANAKUMARAN A/L SELVAKUMARAN', 'email' => 'mogan@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD HAZWAN BIN ABDUL HARIS', 'email' => 'hazwan@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD FIRDAUS BIN MOHD JAIS', 'email' => 'firdaus@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD ASYRAF BIN ZABIDI', 'email' => 'asyraf.zabidi@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD SALAHUDDIN BIN MOHD AMIR', 'email' => 'salahuddin@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'FAUZIAH BINTI SULAIMAN', 'email' => 'fauziah@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MUHAMMAD ROSLIFIKRY BIN SUHEIMI', 'email' => 'roslifikry@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'NUR AISYAH BINTI ABDUL AZIZ', 'email' => 'aisyah@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
            ['name' => 'MOHD IDHAM BIN ANUR', 'email' => 'idham@zpeed.com.my', 'password' => bcrypt($defaultpwd) ],
        ];

        $defaultImage = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
        $createMultipleStaffs = [
            ['user_id' => '1', 'email' => 'aizudin@zpeed.com.my', 'name' => 'AIZUDIN BIN ALI YEON', 'staff_id' => '001', 'picture' => $defaultImage, 'phone' => '012-5127960', 'nric' => '831228715123', 'address' => 'not set','epf' => '17062264', 'role' => '1', 'supervisor' => null, 'university' => 'Multimedia Universiti', 'year' => '2005', 'bank_name' => 'Maybank/Maybank Islamic', 'bank_acc' => '162143046257', 'income_tax' => 'SG 20469643070', 'start_date' => '2016-10-19', 'marrital_status' => '2', 'child' => '4', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Managing Director'],
            ['user_id' => '2', 'email' => 'redzwan@zpeed.com.my', 'name' => 'MOHD REDZWAN BIN DAUD', 'staff_id' => '002', 'picture' => $defaultImage, 'phone' => '019-9177890', 'nric' => '790712145865', 'address' => 'not set','epf' => '14629805', 'role' => '2', 'supervisor' => 'AIZUDIN BIN ALI YEON', 'university' => 'Universiti Tun Abdul Razak', 'year' => '2011', 'bank_name' => 'Maybank/Maybank Islamic', 'bank_acc' => '164557110825', 'income_tax' => 'SG 11112228070', 'start_date' => '2016-10-19', 'marrital_status' => '2', 'child' => '2', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Regional Director'],
            ['user_id' => '3', 'email' => 'azhar@zpeed.com.my', 'name' => 'MUHAMMAD AZHAR BIN ABDUL WAHID', 'staff_id' => '003', 'picture' => $defaultImage, 'phone' => '012-2126096', 'nric' => '880921566315', 'address' => 'not set','epf' => '18018255', 'role' => '3', 'supervisor' => 'MOHD REDZWAN BIN DAUD', 'university' => 'Universiti Kuala Lumpur', 'year' => '2012', 'bank_name' => 'Public Bank', 'bank_acc' => '6894932235', 'income_tax' => '-', 'start_date' => '2016-10-19', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Resident Engineer'],
            ['user_id' => '4', 'email' => 'azim@zpeed.com.my', 'name' => 'ABDUL \'AZIM BIN NORAZMI', 'staff_id' => '004', 'picture' => $defaultImage, 'phone' => '013-7066607', 'nric' => '871214035131', 'address' => 'not set','epf' => '18564041', 'role' => '2', 'supervisor' => 'AIZUDIN BIN ALI YEON', 'university' => 'University Technology MARA', 'year' => '2009', 'bank_name' => 'Public Bank', 'bank_acc' => '6441838425', 'income_tax' => 'SG 21004290070', 'start_date' => '2016-10-19', 'marrital_status' => '2', 'child' => '2', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Technical Manager'],
            ['user_id' => '5', 'email' => 'mogan@zpeed.com.my', 'name' => 'MOGANAKUMARAN A/L SELVAKUMARAN', 'staff_id' => '005', 'picture' => $defaultImage, 'phone' => '011-26475091', 'nric' => '961010085283', 'address' => 'not set','epf' => '20453815', 'role' => '3', 'supervisor' => 'ABDUL \'AZIM BIN NORAZMI', 'university' => 'Politeknik Tuanku Syed Sirajuddin', 'year' => '2017', 'bank_name' => 'Public Bank', 'bank_acc' => '6806576829', 'income_tax' => '-', 'start_date' => '2016-10-19', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Resident Technician'],
            ['user_id' => '6', 'email' => 'hazwan@zpeed.com.my', 'name' => 'MUHAMMAD HAZWAN BIN ABDUL HARIS', 'staff_id' => '006', 'picture' => $defaultImage, 'phone' => '011-62135357', 'nric' => '940526055381', 'address' => 'not set','epf' => '22892985', 'role' => '2', 'supervisor' => 'AIZUDIN BIN ALI YEON', 'university' =>'University Malaysia Pahang', 'year' => '2019', 'bank_name' => 'Public Bank', 'bank_acc' => '6918897401', 'income_tax' => '-', 'start_date' => '2016-10-19', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'System Engineer'],
            ['user_id' => '7', 'email' => 'firdaus@zpeed.com.my', 'name' => 'MUHAMMAD FIRDAUS BIN MOHD JAIS', 'staff_id' => '007', 'picture' => $defaultImage, 'phone' => '010-2461687', 'nric' => '930224106041', 'address' => 'not set','epf' => '19154182', 'role' => '1', 'supervisor' => null, 'university' =>'Politeknik Sultan Idris Shah', 'year' => '2015', 'bank_name' => 'Public Bank', 'bank_acc' => '6945126118', 'income_tax' => '-', 'start_date' => '2016-10-19', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Account Executive'],
            ['user_id' => '8', 'email' => 'asyraf.zabidi@zpeed.com.my', 'name' => 'MUHAMMAD ASYRAF BIN ZABIDI', 'staff_id' => '008', 'picture' => $defaultImage, 'phone' => '011-12381114', 'nric' => '960918085211', 'address' => 'not set','epf' => '23596185', 'role' => '3', 'supervisor' => 'MOHD REDZWAN BIN DAUD', 'university' =>'-', 'year' => '-', 'bank_name' => 'Bank Islam Malaysia', 'bank_acc' => '0808022102629', 'income_tax' => '-', 'start_date' => '2021-04-12', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Resident Technician'],
            ['user_id' => '9', 'email' => 'salahuddin@zpeed.com.my', 'name' => 'MUHAMMAD SALAHUDDIN BIN MOHD AMIR', 'staff_id' => '009', 'picture' => $defaultImage, 'phone' => '011-64019624', 'nric' => '001106080163', 'address' => 'not set','epf' => '23726184', 'role' => '3', 'supervisor' => 'MOHD REDZWAN BIN DAUD', 'university' =>'-', 'year' => '-', 'bank_name' => 'Bank Islam Malaysia', 'bank_acc' => '8086022183369', 'income_tax' => '-', 'start_date' => '2021-09-16', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Resident Engineer'],
            ['user_id' => '10', 'email' => 'fauziah@zpeed.com.my', 'name' => 'FAUZIAH BINTI SULAIMAN', 'staff_id' => '010', 'picture' => $defaultImage, 'phone' => '018-9855913', 'nric' => '901201085548', 'address' => 'not set','epf' => '19136930', 'role' => '3', 'supervisor' => 'ABDUL \'AZIM BIN NORAZMI', 'university' =>'-', 'year' => '-', 'bank_name' => 'Public Bank', 'bank_acc' => '4918282020', 'income_tax' => '-', 'start_date' => '2022-05-23', 'marrital_status' => '2', 'child' => '2', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Technical Associate'],
            ['user_id' => '11', 'email' => 'roslifikry@zpeed.com.my', 'name' => 'MUHAMMAD ROSLIFIKRY BIN SUHEIMI', 'staff_id' => '011', 'picture' => $defaultImage, 'phone' => '017-5968363', 'nric' => '010310100269', 'address' => 'not set','epf' => '21934733', 'role' => '3', 'supervisor' => 'ABDUL \'AZIM BIN NORAZMI', 'university' =>'-', 'year' => '-', 'bank_name' => 'Public Bank', 'bank_acc' => '4918282214', 'income_tax' => '-', 'start_date' => '2022-05-01', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Pre Sales Executive'],
            ['user_id' => '12', 'email' => 'aisyah@zpeed.com.my', 'name' => 'NUR AISYAH BINTI ABDUL AZIZ', 'staff_id' => '012', 'picture' => $defaultImage, 'phone' => '013-7316002', 'nric' => '941124015306', 'address' => 'not set','epf' => 'NOT SET', 'role' => '1', 'supervisor' => null, 'university' => 'University Technology MARA', 'year' => '2015', 'bank_name' => 'Public Bank', 'bank_acc' => 'NOT SET', 'income_tax' => '-', 'start_date' => '2022-12-01', 'marrital_status' => '2', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Administrative Assistant'],
            ['user_id' => '13', 'email' => 'idham@zpeed.com.my', 'name' => 'MOHD IDHAM BIN ANUR', 'staff_id' => '013', 'picture' => $defaultImage, 'phone' => '018-7673729', 'nric' => '000729120809', 'address' => 'not set','epf' => 'NOT SET', 'role' => '1', 'supervisor' => null, 'university' =>'Universiti Teknologi Malaysia', 'year' => '2023', 'bank_name' => 'Maybank/Maybank Islamic', 'bank_acc' => '151240470359', 'income_tax' => '-', 'start_date' => '2022-10-03', 'marrital_status' => '1', 'child' => '0', 'ent_al' => '14',  'ent_ml' => '14', 'designation' => 'Intern'],
        ];
        
        User::insert($createMultipleUsers);
        Staff::insert($createMultipleStaffs);
    }
}
