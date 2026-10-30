<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant POS</title>
    <style>
      :root {
        --bg: #0f172a;
        --panel: rgba(15, 23, 42, 0.92);
        --border: rgba(148, 163, 184, 0.2);
        --primary: #8b5cf6;
        --text: #f8fafc;
        --muted: #cbd5e1;
      }

      html, body {
        margin: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top, #11213d, var(--bg));
        color: var(--text);
        font-family: Tahoma, Arial, sans-serif;
      }

      body {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .card {
        width: min(720px, 80vw);
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 22px;
        padding: 30px 32px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
      }

      .badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(139, 92, 246, 0.16);
        border: 1px solid rgba(139, 92, 246, 0.4);
        color: #d8ccff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
      }

      h1 {
        margin: 18px 0 14px;
        font-size: clamp(28px, 4vw, 52px);
        font-weight: 800;
      }

      p {
        margin: 12px 0;
        color: var(--muted);
        font-size: 18px;
        line-height: 1.7;
      }
    </style>
  </head>
  <body>
    <div class="card">
      <div class="badge">Restaurant POS</div>
      <h1>Starting the application</h1>
      <p>Loading backend and frontend services in the background.</p>
      <p>Please wait while the desktop application initializes the restaurant dashboard.</p>
    </div>
  </body>
</html>
