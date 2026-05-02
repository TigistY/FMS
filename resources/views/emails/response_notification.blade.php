<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; border: 1px solid #eee; border-radius: 10px; overflow: hidden;">
    <div style="background-color: #1e3a5f; padding: 20px; text-align: center; color: white;">
        <h2 style="margin: 0;">Injibara University</h2>
        <small>Feedback Management System (FMS)</small>
    </div>

    <div style="padding: 30px;">
        <h3 style="color: #1e3a5f;">Hello {{ $content->is_anonymous ? 'Guest' : ($content->user->name ?? $content->guest->name) }},</h3>
        <p>A response has been provided regarding your submission. / ባስገቡት ጉዳይ ላይ ምላሽ ተሰጥቷል፡</p>

        <div style="background: #f9f9f9; padding: 20px; border-left: 5px solid #ffc107; margin: 25px 0;">
            <div style="margin-bottom: 15px;">
                <strong style="color: #1e3a5f;">Subject / ጉዳዩ፦</strong><br>
                <span style="font-size: 1.1em;">{{ $content->subject }}</span>
            </div>
            <div>
                <strong style="color: #1e3a5f;">Response / የተሰጠ ምላሽ፦</strong><br>
                <div style="white-space: pre-line;">{{ $responseText }}</div>
            </div>
        </div>
@if(!$content->is_anonymous && $content->user_id)
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ url('/login') }}" style="background-color: #1e3a5f; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login to System</a>
    </div>
@else
    <p style="text-align: center; color: #777; font-size: 0.9em; margin-top: 20px;">
        Thank you for using our system. / ሲስተማችንን ስለተጠቀሙ እናመሰግናለን።
    </p>
@endif
    </div>

    <div style="background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 0.85em; color: #777;">
        <p>&copy; {{ date('Y') }} Injibara University. All Rights Reserved.</p>
    </div>
</div>