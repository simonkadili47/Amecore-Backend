<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    // add new employeee
    public function addemployee(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'national_identity_number' => 'required|string|max:255',
            'age' => 'required|integer',
            'cv' => 'required|file|mimes:pdf|max:2048', 
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);
    
        try {
            // Handle CV file upload
            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('files/cvs', 'public');
                $cvName = basename($cvPath);
            } else {
                throw new \Exception("CV file is required.");
            }
    
            
            $employee = Employee::create([
                'full_name' => $validatedData['full_name'],
                'position' => $validatedData['position'],
                'national_identity_number' => $validatedData['national_identity_number'],
                'age' => $validatedData['age'],
                'cv' => $cvName, 
                'date' => $validatedData['date'],
                'user_id' => $validatedData['user_id'],
            ]);
    
            return response()->json([
                'message' => 'Employee added successfully.',
                'employee' => $employee,
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add employee: ' . $e->getMessage()], 500);
        }
    }
    //view employee

    public function viewemployee()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    //update employee
    public function updateemployee(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'national_identity_number' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer',
            'cv' => 'sometimes|file|mimes:pdf|max:2048', 
            'date' => 'sometimes|date',
            'user_id' => 'sometimes|exists:users,id',
        ]);
    
        try {
            // Handle CV upload if provided
            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('files/cvs', 'public');
                $validatedData['cv'] = basename($cvPath);
            }
    
            
            $employee->update($validatedData);
            return response()->json([
                'message' => 'Employee updated successfully.',
                'employee' => $employee,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update employee: ' . $e->getMessage()], 500);
        }
    }
    public function deleteemployeee($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully.'], 200);
    }

    //payroll
    public function addpayroll(Request $request)
{
    $validatedData = $request->validate([
        'full_name' => 'required|string|max:255',
        'salary' => 'required|numeric|min:0',
        'bonus' => 'nullable|numeric|min:0',
        'month' => 'required|string|max:255',
        'year' => 'required|integer|digits:4',
        'employee_id' => 'required|exists:employees,id',
    ]);

    try {
        $payroll = Payroll::create($validatedData);

        return response()->json([
            'message' => 'Payroll added successfully.',
            'payroll' => $payroll,
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to add payroll: ' . $e->getMessage()], 500);
    }
}

//view payroll
public function viewpayroll()
{
    $payroll = Payroll::all();
    return response()->json($payroll);
}

//update payroll
public function updatepayroll(Request $request, $id)
{
    $payroll = Payroll::find($id);
    if (!$payroll) {
        return response()->json(['message' => 'Payroll not found.'], 404);
    }

    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'month' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $payroll->update($validatedData);
        return response()->json([
            'message' => 'Payroll updated successfully.',
            'payroll' => $payroll,
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to update payroll: ' . $e->getMessage()], 500);
    }
}
public function deletepayroll($id)
    {
        $payroll = Payroll::find($id);

        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found.'], 404);
        }

        $payroll->delete();

        return response()->json(['message' => 'Payroll deleted successfully.'], 200);
    }

    


}

    
    

