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

    public function getSummary(): array {
        return [
            'name'    => "Hi, My name is " . $this->getFullName(),
            'phone'   => "Phone Number : " . $this->phone,
            'address' => "Address : " . $this->address,
        ];
    }
}

// === Logic: Process POST ===
$person = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname']  ?? '';
    $phone     = $_POST['phone']     ?? '';
    $address   = $_POST['address']   ?? '';

    if (!empty($firstname) && !empty($lastname) && !empty($phone) && !empty($address)) {
        $person = new Person($firstname, $lastname, $phone, $address);
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            padding: 80px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        input[type="text"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 15px;
            font-family: Arial, sans-serif;
            color: #333;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        textarea:focus {
            border-color: #aaaaaa;
        }

        input::placeholder,
        textarea::placeholder {
            color: #aaaaaa;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-wrap {
            text-align: center;
            margin-top: 4px;
            margin-bottom: 20px;
        }

        button[type="submit"] {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #1558b0;
        }

        /* Result */
        .result {
            margin-top: 10px;
        }

        .result p {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 4px;
            color: #000;
        }

        .result a {
            color: #000;
            font-size: 14px;
            text-decoration: none;
        }

        .result a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">

    <form method="POST" action="">
        <input
            type="text"
            name="firstname"
            placeholder="Firstname"
            value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
        />
        <input
            type="text"
            name="lastname"
            placeholder="Lastname"
            value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
        />
        <input
            type="tel"
            name="phone"
            placeholder="Phone Number"
            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
        />
        <textarea
            name="address"
            placeholder="Address"
        ><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>

        <div class="btn-wrap">
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>

    <?php if ($person): ?>
    <div class="result">
        <?php $summary = $person->getSummary(); ?>
        <p><?= $summary['name'] ?></p>
        <p><?= $summary['phone'] ?></p>
        <p><?= $summary['address'] ?></p>
        <a href="<?= $_SERVER['PHP_SELF'] ?>">Reset</a>
    </div>
    <?php endif; ?>

</div>
</body>
</html>
