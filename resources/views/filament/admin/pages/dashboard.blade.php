<div class="p-8 bg-white rounded-lg shadow-lg">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">📢 Announcements</h1>
        <p class="text-lg text-gray-600">
            Stay informed with the latest updates and announcements. This section is dedicated to keeping you up-to-date with important news and platform changes.
        </p>
    </div>

    <div class="mt-8 space-y-6">
        <div class="p-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
            <h2 class="text-xl font-semibold text-blue-700">🔔 Announcement 1</h2>
            {{-- <p class="text-gray-700">
                The platform will undergo maintenance on <strong>June 25, 2025</strong>, from <strong>12:00 AM to 4:00 AM UTC</strong>. During this time, some services may be unavailable.
            </p> --}}
        </div>

        <div class="p-6 bg-green-50 border-l-4 border-green-400 rounded-lg">
            <h2 class="text-xl font-semibold text-green-700">🌟 Feature Update</h2>
            {{-- <p class="text-gray-700">
                We’ve introduced a new dashboard feature that allows you to track your activity and performance. Check it out under the <strong>Dashboard</strong> section!
            </p> --}}
        </div>

        <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
            <h2 class="text-xl font-semibold text-yellow-700">⚠️ Reminder</h2>
            {{-- <p class="text-gray-700">
                Please update your profile information by <strong>July 1, 2025</strong>, to continue enjoying uninterrupted access to your account.
            </p> --}}
        </div>
    </div>

    <div class="p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">🎉 Employee Birthdays</h1>
            <p class="text-lg text-gray-600">
                Celebrate and recognize the special days of our team members! Here's a list of upcoming birthdays this month.
            </p>
        </div>

        <div class="mt-8 space-y-6">
            @if (!empty($birthdays))
            @foreach ($birthdays as $birthday)
            <div class="p-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg flex items-center">
                <div class="flex-shrink-0">
                    <img class="w-16 h-16 rounded-full" src="{{ $birthday['photo'] }}" alt="{{ $birthday['name'] }}">
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-blue-700">{{ $birthday['name'] }}</h2>
                    <p class="text-gray-700">
                        Birthday: <strong>{{ $birthday['date'] }}</strong>
                    </p>
                    <p class="text-gray-500">Position: {{ $birthday['position'] }}</p>
                </div>
            </div>
            @endforeach
            @else
            <div class="p-6 bg-gray-50 border-l-4 border-gray-400 rounded-lg">
                <p class="text-gray-700 text-center">No upcoming birthdays this month.</p>
            </div>
            @endif
        </div>

        <div class="mt-8 text-center text-gray-500">
            <p>Stay tuned for more updates and features coming soon!</p>
        </div>
    </div>

</div>
