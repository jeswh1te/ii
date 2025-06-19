function copyPassword() {
    const input = document.getElementById("password");
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Пароль скопійовано в буфер обміну!");
}

function updateLength(value) {
    document.getElementById("rangeOutput").value = value;
    updateStrength(parseInt(value));
}

function updateStrength(length) {
    const label = document.getElementById("strengthLabel");
    if (length < 8) {
        label.textContent = "Слабкий";
        label.className = "strength-weak";
    } else if (length < 16) {
        label.textContent = "Середній";
        label.className = "strength-medium";
    } else {
        label.textContent = "Сильний";
        label.className = "strength-strong";
    }
}

// ініціалізація при завантаженні
document.addEventListener("DOMContentLoaded", () => {
    const length = parseInt(document.getElementById("length").value);
    updateStrength(length);
});
