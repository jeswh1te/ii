<?php
function generatePassword($length, $useLower, $useUpper, $useDigits, $useSpecial) {
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $digits = '0123456789';
    $special = '!@#$%^&*()-_=+[]{};:,.<>?/|';

    $available = '';
    $required = [];

    if ($useLower) {
        $available .= $lower;
        $required[] = $lower[random_int(0, strlen($lower) - 1)];
    }
    if ($useUpper) {
        $available .= $upper;
        $required[] = $upper[random_int(0, strlen($upper) - 1)];
    }
    if ($useDigits) {
        $available .= $digits;
        $required[] = $digits[random_int(0, strlen($digits) - 1)];
    }
    if ($useSpecial) {
        $available .= $special;
        $required[] = $special[random_int(0, strlen($special) - 1)];
    }

    if (empty($available)) return 'Оберіть хоча б один тип символів.';

    $password = $required;

    while (count($password) < $length) {
        $password[] = $available[random_int(0, strlen($available) - 1)];
    }

    shuffle($password);
    return implode('', $password);
}

$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length = max(4, min(64, (int)($_POST['length'] ?? 12))); // межі
    $useLower = isset($_POST['lower']);
    $useUpper = isset($_POST['upper']);
    $useDigits = isset($_POST['digits']);
    $useSpecial = isset($_POST['special']);

    $password = generatePassword($length, $useLower, $useUpper, $useDigits, $useSpecial);
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Генератор паролів</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Генератор безпечних паролів</h2>
<form method="post">
    <label for="length">Довжина пароля: <output id="rangeOutput"><?= htmlspecialchars($_POST['length'] ?? 12) ?></output></label>
    <input type="range" id="length" name="length" min="4" max="64" value="<?= htmlspecialchars($_POST['length'] ?? 12) ?>" oninput="updateLength(this.value)">

    <label><input type="checkbox" name="lower" <?= isset($_POST['lower']) ? 'checked' : '' ?>> Малі літери (a-z)</label>
    <label><input type="checkbox" name="upper" <?= isset($_POST['upper']) ? 'checked' : '' ?>> Великі літери (A-Z)</label>
    <label><input type="checkbox" name="digits" <?= isset($_POST['digits']) ? 'checked' : '' ?>> Цифри (0-9)</label>
    <label><input type="checkbox" name="special" <?= isset($_POST['special']) ? 'checked' : '' ?>> Спецсимволи (!@#$...)</label>

    <div id="strengthBar">Складність: <span id="strengthLabel">-</span></div>

    <button class="btn" type="submit">Згенерувати пароль</button>
</form>

<?php if ($password): ?>
    <div class="output">
        Згенерований пароль: <input type="text" id="password" value="<?= htmlspecialchars($password) ?>" readonly>
        <button class="btn" onclick="copyPassword()">Скопіювати</button>
    </div>
<?php endif; ?>

<script src="script.js"></script>
</body>
</html>
