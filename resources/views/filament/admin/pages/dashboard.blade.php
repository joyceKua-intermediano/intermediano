@php
$birthdays = app(\App\Filament\Pages\Dashboard::class)->getBirthdays();
@endphp
<div style="padding: 2rem; background-color: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);">
    <div style="text-align: center;">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #2d3748; margin-bottom: 1rem;">📢 Announcements</h1>
        <p style="font-size: 1.125rem; color: #718096;">
            Stay informed with the latest updates and announcements. This section is dedicated to keeping you up-to-date with important news and platform changes.
        </p>
    </div>

    <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="padding: 1.5rem; background-color: #ebf8ff; border-left: 0.25rem solid #63b3ed; border-radius: 0.5rem;">
            <h4 style="font-size: 1.25rem; font-weight: 600; color: #2b6cb0;">🔔 Greetings!</h4>
            <p style="color: #4a5568;">
                Upon accessing the platform, kindly take a screenshot of the sidebar and share it with (Joyce Kua) for verification. Thank you!
            </p>
        </div>
        <div style="padding: 1.5rem; background-color: #f0fff4; border-left: 0.25rem solid #68d391; border-radius: 0.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #2f855a;">🌟 Feature Update</h2>
            <!-- <p style="color: #4a5568;">We’ve introduced a new dashboard feature that allows you to track your activity and performance. Check it out under the <strong>Dashboard</strong> section!</p> -->
        </div>

        <div style="padding: 1.5rem; background-color: #fffff0; border-left: 0.25rem solid #f6e05e; border-radius: 0.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #b7791f;">⚠️ Reminder</h2>
            <!-- <p style="color: #4a5568;">Please update your profile information by <strong>July 1, 2025</strong>, to continue enjoying uninterrupted access to your account.</p> -->
        </div>
    </div>

    <div style="padding: 2rem; background-color: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1); margin-top: 2rem;">
        <div style="text-align: center;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #2d3748; margin-bottom: 1rem;">🎉 Employee Birthdays</h1>
            <p style="font-size: 1.125rem; color: #718096;">
                Celebrate and recognize the special days of our team members! Here's a list of upcoming birthdays this month.
            </p>
        </div>


        <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">

            @if (!empty($birthdaysThisMonth))
            @foreach ($birthdaysThisMonth as $birthday)
            <div style="padding: 1.5rem; background-color: #ebf8ff; border-left: 0.25rem solid #63b3ed; border-radius: 0.5rem; display: flex; align-items: center;">
                <div style="margin-left: 1rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: #2b6cb0;">{{ $birthday['name'] }}</h2>
                    <p style="color: #4a5568;">
                        Birthday: <strong>{{ $birthday['date'] }}</strong>
                    </p>
                    <p style="color: #a0aec0;">Position: {{ $birthday['position'] }}</p>
                </div>
            </div>
            @endforeach
            @else
            <div style="padding: 1.5rem; background-color: #f7fafc; border-left: 0.25rem solid #a0aec0; border-radius: 0.5rem;">
                <p style="color: #4a5568; text-align: center;">No birthdays this month.</p>
            </div>
            @endif
        </div>
        <div style="margin-top: 2rem; text-align: center; color: #a0aec0;">
            <p>Stay tuned for more updates and features coming soon!</p>
        </div>
    </div>
</div>
