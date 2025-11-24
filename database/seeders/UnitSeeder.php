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
        // General Unit for Unspecified Complaints
        Unit::create([
            'name-en' => 'General Complaint Receiver', 
            'name-am' => 'ጠቅላላ የቅሬታ ተቀባይ', 
            'code' => 'GENERAL',
            'email' => 'general@example.com' // Added required email
        ]);
        
        // Department Heads (ክፍል ኃላፊዎች)
        Unit::create([
            'name-en' => 'Computer Science Department', 
            'name-am' => 'የኮምፒውተር ሳይንስ ክፍል', 
            'code' => 'CS',
            'email' => 'cs.dept@example.com'
        ]);
        Unit::create([
            'name-en' => 'Electrical Engineering Department', 
            'name-am' => 'የኤሌክትሪካል ምህንድስና ክፍል', 
            'code' => 'EE',
            'email' => 'ee.dept@example.com'
        ]);
        
        // Service Units (አገልግሎት ሰጪ ክፍሎች)
        Unit::create([
            'name-en' => 'Registrar Office', 
            'name-am' => 'ሬጅስትራር ጽ/ቤት', 
            'code' => 'RG',
            'email' => 'registrar@example.com'
        ]);
        Unit::create([
            'name-en' => 'Library Services', 
            'name-am' => 'የቤተ-መጽሐፍት አገልግሎት', 
            'code' => 'LIB',
            'email' => 'library@example.com'
        ]);
        Unit::create([
            'name-en' => 'Cafeteria Services', 
            'name-am' => 'የካፌቴሪያ አገልግሎት', 
            'code' => 'CAFE',
            'email' => 'cafeteria@example.com'
        ]);
        
        // College and Administration Offices (የኮሌጅና አስተዳደር ጽ/ቤቶች)
        Unit::create([
            'name-en' => 'Technology College Dean Office', 
            'name-am' => 'የቴክኖሎጂ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'TC-DEAN',
            'email' => 'dean.tech@example.com'
        ]);
        Unit::create([
            'name-en' => 'Business and Economics College Dean Office', 
            'name-am' => 'የቢዝነስና ኢኮኖሚክስ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'FB-DEAN',
            'email' => 'dean.biz@example.com'
        ]);
        Unit::create([
            'name-en' => 'Natural and Computational Sciences College Dean Office', 
            'name-am' => 'የተፈጥሮና የሒሳብ ሳይንስ ኮሌጅ ዲን ጽ/ቤት', 
            'code' => 'NC-DEAN',
            'email' => 'dean.natsci@example.com'
        ]);
        Unit::create([
            'name-en' => 'Student President Office', 
            'name-am' => 'የተማሪዎች ፕሬዝደንት ጽ/ቤት', 
            'code' => 'ST-PRES',
            'email' => 'st.president@example.com'
        ]);
        Unit::create([
            'name-en' => 'General Administration', 
            'name-am' => 'ጠቅላላ አስተዳደር', 
            'code' => 'ADMIN',
            'email' => 'admin.office@example.com'
        ]);
    }
}