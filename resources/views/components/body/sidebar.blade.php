<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <x-body.sideitem href="/dashboard" item="Dashboard" icon="bi bi-grid" :collapsed=true />
        @can('view', 'App\\Models\User')
            <x-body.sideitem item="Manage Workers" :collapsed=true icon="bi bi-menu-button-wide" href="#"
                target="workers-nav">

                <x-body.subitems id="workers-nav">
                    <x-body.sidebarlink href="/workers/" item="All Workers" />
                    <x-body.sidebarlink href="/workers/staff" item="All Staff" />
                    <x-body.sidebarlink href="/workers/admin" item="All Admin" />
                    <x-body.sidebarlink href="/workers/register" item="Register New Worker" />
                </x-body.subitems>
            </x-body.sideitem>

            <x-body.sideitem item="Manage Department" :collapsed=true icon="bi bi-speedometer2" href="#"
                target="departments-nav">
                <x-body.subitems id="departments-nav">
                    <x-body.sidebarlink href="/departments/" item="All Department" />
                    <x-body.sidebarlink href="/department/register" item="Create New Department" />
                </x-body.subitems>
            </x-body.sideitem>
        @endcan
        @can('view', 'App\\Models\User')
            <x-body.sideitem item="Manage Attendance" :collapsed=true icon="fa-regular fa-id-card" href="#"
                target="attendance-nav">
                <x-body.subitems id="attendance-nav">
                    <x-body.sidebarlink href="/attendance/mark" item="Mark Attendance" />
                    <x-body.sidebarlink href="/attendance/" item="All Workers Attendance" />
                    <x-body.sidebarlink href="/attendance/history" item="All Workers Attendance History" />
                    <x-body.sidebarlink href="/attendance/staff" item="All Staff Attendance" />
                    <x-body.sidebarlink href="/attendance/admin" item="All Admin Attendance" />
                </x-body.subitems>
            </x-body.sideitem>
        @endcan
        @can('viewstaff', 'App\\Models\User')
            <x-body.sideitem item="Manage Attendance" :collapsed=true icon="bi bi-speedometer2" href="#"
                target="attendance-nav">
                <x-body.subitems id="attendance-nav">
                    <x-body.sidebarlink href="/attendance/mark" item="Mark Attendance" />

                </x-body.subitems>
            </x-body.sideitem>
        @endcan

        <x-body.sideitem item="Manage Leave Request" :collapsed=true icon="bi bi-menu-button-wide" href="#"
            target="leave-nav">

            <x-body.subitems id="leave-nav">
                @can('view', 'App\\Models\User')
                    <x-body.sidebarlink href="/leave" item="All Leave Request Records" />
                @endcan
                <x-body.sidebarlink href="/leave/request" item="Request New Leave" />
            </x-body.subitems>
        </x-body.sideitem>
        <x-body.sideitem item="Manage Salary" :collapsed=true icon="bi bi-menu-button-wide" href="#"
            target="salary-nav">
            <x-body.subitems id="salary-nav">
                @can('view', 'App\\Models\User')
                    <x-body.sidebarlink href="/salary/create" item="Create New Salary" />
                    <x-body.sidebarlink href="/salary" item="View Worker salaries" />
                @endcan
                <x-body.sidebarlink href="/worker/salary/{{ Auth::user()->id }}" item="View My Salary" />
            </x-body.subitems>
        </x-body.sideitem>
        <x-body.sideitem item="Manage Payroll" :collapsed=true icon="bi bi-menu-button-wide" href="#"
            target="payroll-nav">

            <x-body.subitems id="payroll-nav">
                @can('view', 'App\\Models\User')
                    <x-body.sidebarlink href="/payrolls" item="Make Payment" />
                    <x-body.sidebarlink href="/payroll" item="Payroll Records" />
                @endcan
            </x-body.subitems>
        </x-body.sideitem>
        <!-- Other nav items -->
    </ul>
</aside>



<!-- Bootstrap JS Bundle -->
