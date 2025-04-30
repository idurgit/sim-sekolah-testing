<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow mb-4 p-4">
        <h2 class="text-lg font-bold mb-2 dark:text-white">Class Enrollment Management</h2>

        <div class="dark:text-gray-100">
            {{ $this->form }}
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2 dark:text-white">Available Student</h2>
                <livewire:available-student />
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2 dark:text-white">Enrolled Student</h2>
                <livewire:enrolled-student />
            </div>
        </div>
    </div>
</x-filament-panels::page>
