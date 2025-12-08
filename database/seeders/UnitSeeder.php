<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
       

       
        Unit::create([
            'name_en' => 'Computer Science Department', 
            'name_am' => 'የኮምፒውተር ሳይንስ ክፍል', 
            'code' => 'CS',
            'email' => 'cs.dept@example.com'
        ]);
        Unit::create([
            'name_en' => 'Electrical Engineering Department', 
            'name_am' => 'የኤሌክትሪካል ምህንድስና ክፍል', 
            'code' => 'EE',
            'email' => 'ee.dept@example.com'
        ]);
        
        
        Unit::create([
            'name_en' => 'Registrar Office', 
            'name_am' => 'ሬጅስትራር ጽ/ቤት', 
            'code' => 'RG',
            'email' => 'registrar@example.com'
        ]);
        Unit::create([
            'name_en' => 'Library Services', 
            'name_am' => 'የቤተ-መጽሐፍት አገልግሎት', 
            'code' => 'LIB',
            'email' => 'library@example.com'
        ]);
        Unit::create([
            'name_en' => 'Cafeteria Services', 
            'name_am' => 'የካፌቴሪያ አገልግሎት', 
            'code' => 'CAFE',
            'email' => 'cafeteria@example.com'
        ]);
        
        
        Unit::create([
            'name_en' => 'Technology College Dean Office', 
            'name_am' => 'የቴክኖሎጂ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'TC-DEAN',
            'email' => 'dean.tech@example.com'
        ]);
        Unit::create([
            'name_en' => 'Business and Economics College Dean Office', 
            'name_am' => 'የቢዝነስና ኢኮኖሚክስ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'FB-DEAN',
            'email' => 'dean.biz@example.com'
        ]);
        Unit::create([
            'name_en' => 'Natural and Computational Sciences College Dean Office', 
            'name_am' => 'የተፈጥሮና የሒሳብ ሳይንስ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'NC-DEAN',
            'email' => 'dean.natsci@example.com'
        ]);
        Unit::create([
            'name_en' => 'Student President Office', 
            'name_am' => 'የተማሪዎች ፕሬዝደንት ጽ/ቤት', 
            'code' => 'ST-PRES',
            'email' => 'st.president@example.com'
        ]);
        
    }
}