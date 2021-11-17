<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="inline-block text-3xl"><a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a></h2>
            <a href="{{ route('clubs.plans.create', $club) }}" class="inline-block pl-auto">＋</a>

            <table class="table-fixed border w-full bg-blue-200 h-full">
                <thead class="w-full">
                    <tr>
                        <th colspan="7" class="h-8">
                            <div class="flex justify-between">
                                <div class="pl-4"><a href="
                                     @if ($month !=1)
                                        {{ route('clubs.plans.index', [$club, $year, $month - 1]) }}
                                    @else
                                        {{ route('clubs.plans.index', [$club, $year - 1, 12]) }}
                                        @endif
                                        "><</a>
                                </div>
                                <div>
                                    {{ $year . '年  ' . $month . '月' }}
                                </div>
                                <div class="pr-4"><a href="
                                     @if ($month !=12)
                                        {{ route('clubs.plans.index', [$club, $year, $month + 1]) }}
                                    @else
                                        {{ route('clubs.plans.index', [$club, $year + 1, 1]) }}
                                        @endif
                                        ">></a></div>
                            </div>
                        </th>
                    </tr>
                    <tr class="w-full h-8">
                        @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                            <th class="border w-1/7">{{ $dayOfWeek }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dates as $date)
                        @if ($date->dayOfWeek == 0)
                            <tr class="h-20">
                        @endif
                        <td @if ($date->month != Date('Y'))
                            class="bg-white border align-top"
                    @endif
                    >
                    {{ $date->day }}
                    @foreach ($plans as $plan)
                        @if ($plan->day() == $date->day)
                            @if ($plan->check(Auth::id()) == true || $club->isAdmin(Auth::id()) == true)
                            <a href="{{ route('clubs.plans.show', [$club, $plan]) }}">
                                <p class="inline-block px-1 m-1 w-full bg-blue-200 truncate">{{ $plan->name }}</p>
                            </a>
                            @else
                            <p class="inline-block px-1 m-1 w-full bg-gray-200">予定あり</p>
                            @endif
                        @endif
                    @endforeach
                    </td>
                    @if ($date->dayOfWeek == 6)
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
