<?php

// === OOP: Class Person ===
class Person {
    public string $firstname;
    public string $lastname;
    public string $phone;
    public string $address;

    public function __construct(string $firstname, string $lastname, string $phone, string $address) {
        $this->firstname = htmlspecialchars(trim($firstname));
        $this->lastname  = htmlspecialchars(trim($lastname));
        $this->phone     = htmlspecialchars(trim($phone));
        $this->address   = htmlspecialchars(trim($address));
    }

    public function getFullName(): string {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getSummary(): string {
        return "Hi, my name is {$this->getFullName()}\n"
             . "Phone Number : {$this->phone}\n"
             . "Address : {$this->address}";
    }
}

// === Logic: Process POST ===
$person    = null;
$submitted = false;
$errors    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $submitted = true;

    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname']  ?? '';
    $phone     = $_POST['phone']     ?? '';
    $address   = $_POST['address']   ?? '';

    if (empty($firstname)) $errors[] = 'Firstname is required.';
    if (empty($lastname))  $errors[] = 'Lastname is required.';
    if (empty($phone))     $errors[] = 'Phone Number is required.';
    if (empty($address))   $errors[] = 'Address is required.';

    if (empty($errors)) {
        $person = new Person($firstname, $lastname, $phone, $address);
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Input Form – PBO Project</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
    <style>
        /* ── Reset & Root ─────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f4f1ec;
            --surface:   #ffffff;
            --accent:    #1a3a5c;
            --accent2:   #e8a838;
            --text:      #1c1c1e;
            --muted:     #6b7280;
            --border:    #d4cfc8;
            --radius:    10px;
            --shadow:    0 8px 32px rgba(26,58,92,.10);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 48px 16px 64px;
        }

        /* ── Header ───────────────────────────────────── */
        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header .badge {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 100px;
            margin-bottom: 14px;
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 5vw, 2.6rem);
            color: var(--accent);
            line-height: 1.15;
        }

        header p {
            margin-top: 8px;
            color: var(--muted);
            font-size: .9rem;
        }

        /* ── Card ─────────────────────────────────────── */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 480px;
            padding: 36px 32px;
            border-top: 4px solid var(--accent);
            animation: slideUp .45s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Form ─────────────────────────────────────── */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            color: var(--text);
            background: #faf9f7;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,58,92,.12);
            background: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        /* ── Buttons ──────────────────────────────────── */
        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: var(--radius);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, background .2s;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: #15304d;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26,58,92,.25);
        }

        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 1.5px solid var(--accent);
        }

        .btn-secondary:hover {
            background: var(--accent);
            color: #fff;
        }

        /* ── Errors ───────────────────────────────────── */
        .error-box {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: .88rem;
            color: #b91c1c;
        }

        .error-box ul { padding-left: 18px; }

        /* ── Result Card ──────────────────────────────── */
        .result-card {
            margin-top: 24px;
            background: #eef3f9;
            border-left: 4px solid var(--accent2);
            border-radius: var(--radius);
            padding: 20px 20px 16px;
            animation: fadeIn .4s ease both;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .result-card .result-title {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--accent2);
            margin-bottom: 10px;
        }

        .result-card p {
            font-size: .93rem;
            line-height: 1.7;
            color: var(--text);
            white-space: pre-line;
        }

        /* ── Footer ───────────────────────────────────── */
        footer {
            margin-top: 48px;
            text-align: center;
            font-size: .78rem;
            color: var(--muted);
        }

        footer span { color: var(--accent); font-weight: 600; }
    </style>
</head>
<body>

<header>
    <div class="badge">PBO – Project-based Task</div>
    <h1>Input Form</h1>
    <p>Universitas Brawijaya &mdash; Pemrograman Berorientasi Objek</p>
</header>

<div class="card">

    <?php if (!empty($errors)): ?>
    <div class="error-box">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="">

        <div class="form-group">
            <label for="firstname">Firstname</label>
            <input
                type="text"
                id="firstname"
                name="firstname"
                placeholder="Firstname"
                value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
            />
        </div>

        <div class="form-group">
            <label for="lastname">Lastname</label>
            <input
                type="text"
                id="lastname"
                name="lastname"
                placeholder="Lastname"
                value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
            />
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="Phone Number"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
            />
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea
                id="address"
                name="address"
                placeholder="Address"
            ><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        </div>

        <div class="btn-row">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>

    </form>

    <?php if ($person): ?>
    <div class="result-card">
        <div class="result-title">&#10003; Result</div>
        <p><?= nl2br($person->getSummary()) ?></p>
    </div>
    <?php endif; ?>

</div>

<footer>
    Dibuat untuk tugas <span>PBO – Universitas Brawijaya</span> &nbsp;|&nbsp; Input Form using PHP &amp; OOP
</footer>

</body>
</html>
