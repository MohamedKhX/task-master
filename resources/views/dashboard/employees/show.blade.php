<x-dashboard-layout>
    <div class="mx-auto px-6 max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mx-auto px-22">
            <!-- Breadcrumb Start -->
            <div class="mb-6 flex flex-row gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Employee
                </h2>
                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium" href="index.html">Dashboard /</a>
                        </li>
                        <li class="text-primary">Employee</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Profile Section Start -->
            <div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5">
                    <div class="relative z-1 mx-auto w-full max-w-30 rounded-full mt-10">
                        <div class="flex justify-center relative drop-shadow-2">
                            <img src="{{ asset( $employee->avatar_path )}}" alt="profile">
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="mb-1.5 text-2xl font-medium text-black dark:text-white">
                            {{ $employee->name }}
                        </h3>
                        <p class="font-medium">{{ $employee->job_role }}</p>
                        <div class="mx-auto mt-4.5 mb-5.5 grid max-w-94 grid-cols-2 rounded-md border border-stroke py-2.5 shadow-1 dark:border-strokedark dark:bg-[#37404F]">
                            <div class="flex flex-col items-center justify-center gap-1 border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
                                <span class="font-semibold text-black dark:text-white">({{ $employee->completedTasks() }})</span>
                                <span class="text-sm">Completed Tasks</span>
                            </div>
                            <div class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row">
                                <span class="font-semibold text-black dark:text-white">({{ $employee->unCompletedTasks() }})</span>
                                <span class="text-sm">Tasks Working on</span>
                            </div>
                        </div>

                        <div class="mx-auto max-w-180">
                            <h4 class="font-medium text-black text-xl font-semibold dark:text-white">
                                Bio 🔥
                            </h4>
                            <p class="mt-4.5 text-sm font-medium">
                                {{ $employee->bio }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====== Profile Section End -->
        </div></div>
</x-dashboard-layout>
