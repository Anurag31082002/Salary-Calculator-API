<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Commission;
use App\Models\Attendance;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Anurag Dwivedi',
                'basic_salary' => 50000.00,
            ],
            [
                'name' => 'Ashish Yadav',
                'basic_salary' => 45000.00,
            ],
            [
                'name' => 'Raman Shukla',
                'basic_salary' => 35000.00,
            ],
            [
                'name' => 'Arnav Goswami',
                'basic_salary' => 37500.00,
            ],
        ];
        foreach ($employees as $emp) {
            $employee = Employee::create([
                'name' => $emp['name'],
                'basic_salary' => $emp['basic_salary'],
            ]);

            Allowance::create([
                'employee_id' => $employee->id,
                'hra' => 5000.00,
                'da' => 2000.00,
                'ta' => 1000.00,
                'additional_allowance' => 500.00,
            ]);
            Deduction::create([
                'employee_id' => $employee->id,
                'pf' => 1500.00,
                'health_insurance' => 1000.00,
                'other_deductions' => 1500.00,
            ]);
            Commission::create([
                'employee_id' => $employee->id,
                'commission_amount' => 3000.00,
            ]);
            $this->addAttendance($employee);
    }
}
private function addAttendance($employee)
{
    if (!in_array($employee->id, [1, 2,3,4])) {
        return; 
    }
    $months = [1];//November month
    foreach ($months as $month) {
        for ($day = 1; $day <= 30; $day++) {
            $date = Carbon::create(date('Y'), $month, $day);

            $dayOfWeek = $date->dayOfWeek;

            if ($dayOfWeek === Carbon::SATURDAY || $dayOfWeek === Carbon::SUNDAY) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'status' => 'weekend',
                    'remarks' => 'Weekend',
                ]);
            } 
            elseif (
                ($employee->id === 1 && in_array($day, [5, 20])) ||  
                ($employee->id === 2 && in_array($day, [10])) ||     
                ($employee->id === 3 && in_array($day, [11, 25])) ||
                ($employee->id === 4 && in_array($day, [12, 26]))    
            ) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'status' => 'leave',
                    'remarks' => 'On leave',
                ]);
            } 
            else {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date,
                    'status' => 'present',
                    'remarks' => 'On time',
                ]);
            }
        }
    }
}


}