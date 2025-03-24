<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class SalaryReportController extends Controller
{
    public function getEmployeeSalary(Request $request)
    {
        $id = $request->query('id');
        if (!$id) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }
        $employee = Employee::with(['allowances', 'deductions', 'commissions', 'attendances'])->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $basicSalary = $employee->basic_salary;
        // Calculate allowances by Anurag
        $allowance = $employee->allowances->first();
        $hra = $allowance->hra ?? 0;
        $da = $allowance->da ?? 0;
        $ta = $allowance->ta ?? 0;
        $additional = $allowance->additional_allowance ?? 0;
        $totalAllowances = $hra + $da + $ta + $additional;

        // Calculate Deductions by Anurag
        $deduction = $employee->deductions->first();
        $pf = $deduction->pf ?? 0;
        $healthInsurance = $deduction->health_insurance ?? 0;
        $otherDeductions = $deduction->other_deductions ?? 0;
        $totalDeductions = $pf + $healthInsurance + $otherDeductions;
        
        // Calculate Commission by Anurag
        $commission = $employee->commissions->sum('commission_amount');

        // Attendance Check by Anurag
        $presentDays = $employee->attendances->where('status', 'present')->count();
        $leaveDays = $employee->attendances->where('status', 'leave')->count();
        $weekendDays = $employee->attendances->where('status', 'weekend')->count();

        // Final Salary Calculation by Anurag
        $totalSalary = $basicSalary + $totalAllowances + $commission - $totalDeductions;

        // Deduct leave days if any
        if ($leaveDays > 0) {
            $dailySalary = $basicSalary / 30; // Assume 30 days in a month  
            $totalSalary -= ($leaveDays * $dailySalary);
        }

        // Return Final Salary Data
        return response()->json([
            'employee' => $employee->name,
            'basic_salary' => number_format($basicSalary, 2),
            'commission' => (float) $commission,
            'allowances' => [
                'hra' => number_format($hra, 2),
                'da' => number_format($da, 2),
                'ta' => number_format($ta, 2),
                'additional_allowance' => number_format($additional, 2),
            ],
            'total_allowances' => (float) $totalAllowances, 
            'deductions' => [
                'pf' => number_format($pf, 2),
                'health_insurance' => number_format($healthInsurance, 2),
                'other_deductions' => number_format($otherDeductions, 2),
            ],
            'total_deductions' => (float) $totalDeductions,
            'present_days' => $presentDays,
            'leave_days' => $leaveDays,
            'weekend_days' => $weekendDays,
            'total_salary' => round($totalSalary, 2),
        ]);
        
    }
}
