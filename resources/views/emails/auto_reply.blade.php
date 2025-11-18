<div style="font-family: Arial, sans-serif; background-color: #f7f9fc; padding: 20px;">
    <div
        style="max-width: 700px; margin: auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #0d6efd; color: #ffffff; padding: 20px 25px;">
            <div style="margin: 0; font-size: 1.5rem;">HPS Aviation</div>
        </div>

        <!-- Body -->
        <div style="padding: 25px; line-height: 1.6; color: #333;">
            <p style="font-size: 1rem;">Dear {{ $data['name'] ?? 'HPS Aviation Guest' }},</p>

            <p>
                Thank you for joining the <strong>HPS Aviation</strong> family.  
                Your support accelerates our vision to build safer, more efficient propulsion solutions for aerial platforms.  
                We will share concise updates on project milestones and technical achievements.
            </p>

            <p>
                For more information, you may contact our
                digital assistant on WhatsApp via:
                <a href="https://wa.me/971561574167" target="_blank" style="color: #0d6efd; text-decoration: none;">https://wa.me/971561574167</a>
            </p>

            <p>
                Would you like to schedule a personal meeting with Eng. Ahmed?  
                Please use this link:
                <a href="https://calendly.com/a7medfawzy7amza/30min" target="_blank" style="color: #0d6efd; text-decoration: none;">https://calendly.com/a7medfawzy7amza/30min</a>
            </p>

            <p>
                To finalize our agreement, please reply to
                <a href="mailto:investors@hpsaviation.com" style="color: #0d6efd; text-decoration: none;">investors@hpsaviation.com</a>
                with your confirmation so we can prepare and send the contracts and related agreements for your review and signature.
            </p>

            <p style="margin-top: 25px;">
                With sincere appreciation, <br>
                <strong>Eng. Ahmed Hamza</strong> <br>
                CEO | HPS Aviation LTD <br>
                Masdar City - Abu Dhabi, UAE <br>
                <a href="https://hpsaviation.com" style="color: #0d6efd; text-decoration: none;">hpsaviation.com</a>
            </p>
        </div>

        <!-- Footer -->
        <div
            style="background-color: #f1f3f5; color: #6c757d; padding: 15px 25px; text-align: right; font-size: 0.875rem;">
            Sent on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}
        </div>
    </div>
</div>