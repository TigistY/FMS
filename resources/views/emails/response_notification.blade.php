<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h3>Hello {{ $content->is_anonymous ? 'Guest' : ($content->user->name ?? $content->guest->name) }},</h3>
    <p>A response has been provided regarding your submission:</p>

    <h3 style="margin-top: 20px;">ሰላም {{ $content->is_anonymous ? 'Guest' : ($content->user->name ?? $content->guest->name) }},</h3>
    <p>ባስገቡት ጉዳይ ላይ ምላሽ ተሰጥቷል፡</p>

    <div style="background: #f4f4f4; padding: 20px; border-left: 4px solid #007bff; margin: 20px 0;">
        <div style="margin-bottom: 15px;">
            <strong>Subject / ጉዳዩ፦</strong><br>
            {{ $content->subject }}
        </div>
        <div>
            <strong>Response / የተሰጠ ምላሽ፦</strong><br>
            {{ $responseText }}
        </div>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee;">
    
    <p>
        For more information, please log in to the system.<br>
        ለበለጠ መረጃ ሲስተሙን መመልከት ይችላሉ።
    </p>
    
    <p>
        Thank you! / እናመሰግናለን!<br>
        <strong>Injibara University / እንጅባራ ዩኒቨርሲቲ</strong>
    </p>
</div>