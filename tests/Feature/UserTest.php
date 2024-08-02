<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\User;
use App\Models\UserLeave;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_has_department(): void
    {
        $department=Department::factory()->create();
       $user=User::factory()->create(['department_id'=>$department->id]);
       $response= $user->department->is($department);

       $this->assertTrue($response);
    }

    public function test_department_has_many_users(){
        $department=Department::factory()->create();
        $users=User::factory()->count(3)->create(['department_id'=> $department->id]);

        $this->assertCount(3, $department->users);
        $this->assertTrue($department->users->contains($users[0]));
        $this->assertTrue($department->users->contains($users[1]));
        $this->assertTrue($department->users->contains($users[2]));
    }


    public function test_user_is_head_of_department(): void
    {
        $department=Department::factory()->create();
       $user=User::factory()->create(['department_id'=>$department->id]);
       $departmenthead=Department::factory()->create(['department_head_id'=>$user->id]);
       $response= $user->headedDepartment->is($departmenthead);

       $this->assertTrue($response);
    }

    public function test_user_has_many_attendance(){
        $department=Department::factory()->create();
        $user=User::factory()->create(['department_id'=>$department->id]);
        $departmenthead=Department::factory()->create(['department_head_id'=>$user->id]);
        $attendance= Attendance::factory()->create(['user_id'=>$user->id]);
        $this->assertTrue($user->attendance->contains($attendance));

    }

    public function test_attendance_belongs_to_user(){
        $department=Department::factory()->create();
        $user=User::factory()->create(['department_id'=>$department->id]);
       $attendance=Attendance::factory()->create(['user_id'=>$user->id]);
       $this->assertTrue($attendance->user->is($user));
    }

    public function test_leave_belongs_to_user(){
        $department=Department::factory()->create();
        $user=User::factory()->create(['department_id'=>$department->id]);
       $attendance=Attendance::factory()->create(['user_id'=>$user->id]);
       $leave= UserLeave::factory()->create(['user_id'=>$user->id]);
       $this->assertTrue($leave->user->is($user));
    }

    public function test_user_has_many_payrolls()
    {
        // Create a Department instance
        $department = Department::factory()->create();

        // Create a User instance associated with the Department
        $user = User::factory()->create(['department_id' => $department->id]);

        // Create multiple Payroll instances associated with the User
        Payroll::factory()->count(4)->create(['user_id' => $user->id]);

        // Refresh the user instance to reload the relationship
        $user->refresh();

        // Assert that the user has the correct number of payroll records
        $this->assertCount(4, $user->payrolls);

        // Optionally, you can also assert that each payroll record is associated with the correct user
        foreach ($user->payrolls as $payroll) {
            $this->assertEquals($user->id, $payroll->user_id);
        }
    }
}
