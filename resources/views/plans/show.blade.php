<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>{{ $plan->name }}</p>
            <p>{{ $plan->meeting_time }}</p>
            <p>{{ $plan->dissolution_time }}</p>
            <p>{{ $plan->place }}</p>
            <p>{{ $plan->remarks }}</p>
        </div>
    </div>
</x-app-layout>
