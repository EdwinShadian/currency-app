<div>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Current Rates
    </h1>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Currency
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Code
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Rate to USD
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Last Updated
                    </th>
                </tr>
            <tbody>
                @foreach ($currencies as $currency)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $currency->full_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $currency->short_name }}
                        </td>
                        <td class="font-medium px-6 py-4">
                            {{ $currency->rate_to_usd }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $currency->updated_at_date }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $currencies->links() }}
</div>
