<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Session expired</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
            color: #183047;
            background: #f3f7fa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            place-items: center;
        }

        main {
            width: min(100%, 520px);
            padding: 48px 40px;
            border: 1px solid #e2eaf0;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 16px 48px rgba(24, 48, 71, 0.08);
            text-align: center;
        }

        .icon {
            display: grid;
            width: 64px;
            height: 64px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: #eaf4fb;
            color: #2475a8;
            font-size: 30px;
            font-weight: 700;
            place-items: center;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(26px, 6vw, 34px);
        }

        p {
            margin: 0;
            color: #5a6b79;
            font-size: 16px;
            line-height: 1.6;
        }

        .actions {
            display: grid;
            gap: 12px;
            margin-top: 28px;
        }

        .button {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border: 1px solid #2475a8;
            border-radius: 8px;
            background: #2475a8;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .button:hover,
        .button:focus-visible {
            border-color: #195d89;
            background: #195d89;
        }

        .button-secondary {
            border-color: transparent;
            background: transparent;
            color: #2475a8;
        }

        .button-secondary:hover,
        .button-secondary:focus-visible {
            border-color: transparent;
            background: #f2f7fa;
            color: #195d89;
        }

        @media (max-width: 480px) {
            main {
                padding: 36px 24px;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="icon" aria-hidden="true">!</div>
        <h1>Your session has expired</h1>
        <p>
            For your security, this page or form is no longer active. Go back to the previous page
            and try again.
        </p>
        <div class="actions">
            <a class="button" href="{{ url()->previous() }}" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                Go back and try again
            </a>
            <a class="button button-secondary" href="{{ url()->previous() }}">Go Back</a>
            <a class="button button-secondary" href="{{ url('/') }}">Go to home</a>
        </div>
    </main>
</body>
</html>
