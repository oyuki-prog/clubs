<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2><a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a></h2>

            <table class="table-fixed border w-full bg-blue-200 my-40">
                <thead class="w-full">
                    <tr>
                        <th colspan="7" class="h-8">
                            <div class="flex justify-between">
                                <div><a href="
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
                                <div><a href="
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
                            @if ($plan->check(Auth::id()) == false)
                                <p class="inline-block w-full m-0">予定あり</p>
                            @else
                            <a href="{{ route('clubs.plans.show', [$club, $plan]) }}">
                                <p class="inline-block w-full m-0">{{ $plan->name }}</p>
                            </a>
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
