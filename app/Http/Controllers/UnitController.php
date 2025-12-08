<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Rule class for unique validation

class UnitController extends Controller
{
    // Authorization is handled by middleware 'can:manage-units' in web.php
    
    /**
     * Display a listing of the resource (Index).
     */
    public function index()
    {
        // ሁሉንም ዩኒቶች ያመጣል
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource (Create).
     */
    public function create()
    {
        return view('units.create'); 
    }

    /**
     * Store a newly created resource in storage (Store).
     */
    public function store(Request $request)
    {
        // ዩኒክ የሆኑ (Unique) መስኮችን ጨምሮ መረጃውን ያረጋግጣል
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_am' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:units,code',
            'email' => 'required|email|max:255|unique:units,email',
        ]);
        
        Unit::create($validatedData);

        // ወደ ዝርዝር ገጹ ይመልሳል
        return redirect()->route('units.index')
                         ->with('success', 'New unit registered successfully!');
    }

    /**
     * Show the form for editing the specified resource (Edit).
     * Uses Route Model Binding (Unit $unit).
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource (Update) in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        // Validation rules: አሁን ካለው ዩኒት ውጭ ዩኒክ መሆኑን እንዲያረጋግጥ Rule::unique() እንጠቀማለን
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_am' => 'required|string|max:255',
            'code' => [
                'required', 
                'string', 
                'max:10', 
                // የራሱን ID ችላ በማለት ኮዱ ዩኒክ መሆኑን ያረጋግጣል
                Rule::unique('units')->ignore($unit->id),
            ],
            'email' => [
                'required', 
                'email', 
                'max:255', 
                // የራሱን ID ችላ በማለት ኢሜይሉ ዩኒክ መሆኑን ያረጋግጣል
                Rule::unique('units')->ignore($unit->id),
            ],
        ]);
        
        $unit->update($validatedData);

        return redirect()->route('units.index')
                         ->with('success', 'Unit details updated successfully!');
    }

    /**
     * Remove the specified resource (Destroy) from storage.
     */
    public function destroy(Unit $unit)
    {
        try {
            // Note: Cascade deletion of associated users is assumed via foreign key settings in the migration.
            $unit->delete();
            return redirect()->route('units.index')
                             ->with('success', 'Unit deleted successfully!');
        } catch (\Exception $e) {
            // ዩኒቱ ሊሰረዝ የማይችልበት ችግር ከተፈጠረ (ለምሳሌ ያልተጠበቀ Foreign Key Constraint)
            Log::error('Unit Deletion Error: ' . $e->getMessage());
            return redirect()->route('units.index')
                             ->with('error', 'Error deleting unit. Please check if there are dependencies.');
        }
    }
    
    // show method is excluded as per the route definition in web.php
}