<x-filament-panels::page>
    @if ($classSession)
    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-2 dark:text-white">Class Session Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Session ID:</p>
                <p class="font-medium dark:text-white">{{ $classSession->id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Course:</p>
                <p class="font-medium dark:text-white">{{ $classSession->course->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-300">Date:</p>
                <p class="font-medium dark:text-white">
                    {{ $classSession->session_date ? $classSession->session_date->format('d F Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h3 class="text-lg font-medium dark:text-white">Student Assessments</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300">Enter grades and notes for each student below.</p>
    </div>

    <div class="dark:text-gray-100">
        {{ $this->table }}
    </div>
@else
    <div class="p-4 bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200 rounded-lg">
        <p class="font-medium">No valid session ID provided. Please select a class session.</p>
    </div>
@endif
</x-filament-panels::page>
