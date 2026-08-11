<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punjab Saathi - Coming Soon</title>
    <meta name="description" content="Punjab Saathi - Online Government Services in Punjab. Launching soon.">
    <link rel="icon" href="/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <style>
        :root {
            --navy: #0d1b3e;
            --orange: #fc5e28;
            --white: #ffffff;
            --gray: #666666;
            --border: #eaeaea;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--white);
            color: var(--navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 24px;
        }
        .logo {
            max-width: 220px;
            margin-bottom: 28px;
        }
        .tag {
            font-size: 13px;
            letter-spacing: 1.5px;
            color: var(--orange);
            font-weight: 600;
            margin-bottom: 14px;
            text-transform: uppercase;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--orange);
            color: var(--white);
            font-size: clamp(20px, 4.5vw, 34px);
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 14px 36px;
            border-radius: 50px;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(252, 94, 40, 0.35);
        }
        .badge .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--white);
            animation: pulse 1.4s infinite ease-in-out;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.8); }
        }
        h1 {
            font-size: clamp(22px, 4vw, 32px);
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--navy);
        }
        .punjabi {
            font-size: clamp(19px, 4vw, 26px);
            color: var(--orange);
            margin-bottom: 20px;
            font-weight: 600;
        }
        p.subtitle {
            font-size: 16px;
            color: var(--gray);
            max-width: 540px;
            margin-top: 28px;
            margin-bottom: 28px;
            line-height: 1.7;
        }
        .features {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 28px;
        }
        .feature-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff5f0;
            color: var(--navy);
            font-size: 14px;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 50px;
            border: 1px solid #ffd9c4;
        }
        .feature-item i {
            color: var(--orange);
            font-size: 17px;
        }
        p.subtitle-small {
            font-size: 15px;
            color: var(--gray);
            max-width: 500px;
            margin-bottom: 34px;
            line-height: 1.7;
        }
        .actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 36px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary {
            background: var(--orange);
            color: var(--white);
        }
        .btn-outline {
            background: var(--white);
            color: var(--navy);
            border: 1.5px solid var(--navy);
        }
        .contact-info {
            font-size: 14px;
            color: var(--gray);
            border-top: 1px solid var(--border);
            padding-top: 22px;
            width: 100%;
            max-width: 480px;
        }
        .contact-info p {
            margin-bottom: 6px;
        }
        .contact-info a {
            color: var(--navy);
            text-decoration: underline;
        }
        footer {
            margin-top: 40px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>

    <img src="https://punjabsaathi.in/images/punjab_seva_kendra.png" alt="Punjab Saathi" class="logo">

    <div class="tag">Punjab Saathi</div>
    <h1>We're getting things ready for you</h1>
    <div class="punjabi">ਸਰਕਾਰੀ ਸੇਵਾਵਾਂ ਹੁਣ ਔਨਲਾਈਨ — ਜਲਦੀ ਆ ਰਿਹਾ ਹੈ</div>
    <div class="badge"><span class="dot"></span>Coming Soon</div>

    <p class="subtitle">
        Punjab's first one-stop digital platform for all your government paperwork —
        Aadhaar, PAN, Income Certificate, Caste Certificate, Ration Card, Pension Schemes, and 50+ more services,
        all under one roof. No more running between offices, no more standing in queues.
    </p>

    <div class="features">
        <div class="feature-item">
            <i class="ti ti-certificate" aria-hidden="true"></i>
            <span>50+ Government Services</span>
        </div>
        <div class="feature-item">
            <i class="ti ti-shield-check" aria-hidden="true"></i>
            <span>100% Accurate Processing</span>
        </div>
        <div class="feature-item">
            <i class="ti ti-truck-delivery" aria-hidden="true"></i>
            <span>Doorstep Delivery</span>
        </div>
    </div>

    <p class="subtitle-small">
        Whether you're applying for a certificate, tracking a pension, or filling a job form —
        Punjab Saathi will be your trusted digital saathi, every step of the way.
    </p>

    <div class="actions">
        <a href="https://wa.me/917710556330" class="btn btn-primary" target="_blank">
            Chat on WhatsApp
        </a>
        <a href="tel:+917710556330" class="btn btn-outline">
            Call +91 7710556330
        </a>
    </div>

    <div class="contact-info">
        <p>Shop No: 1, Lal Market, Near OHM Omjee Cinema, Grand Trunk Rd, Amritsar - 143001</p>
        <p><a href="mailto:info@punjabsaathi.in">info@punjabsaathi.in</a></p>
    </div>

    <footer>&copy; 2026 Punjab Saathi. All rights reserved.</footer>

</body>
</html>