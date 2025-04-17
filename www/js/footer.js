
const passwordInput = document.getElementById("password");
const strengthBar = document.getElementById("password-strength-bar");
const strengthText = document.getElementById("password-strength-text");

passwordInput.addEventListener("input", () => {
    const value = passwordInput.value;
    let strength = 0;

    if (value.length >= 6) strength++;
    if (/[A-Z]/.test(value)) strength++;
    if (/[0-9]/.test(value)) strength++;
    if (/[^A-Za-z0-9]/.test(value)) strength++;

    // Reset classes
    strengthBar.className = "h-2 rounded-xl transition-all duration-300 ease-in-out";

    if (strength <= 1) {
        strengthBar.classList.add("w-1/3", "bg-red-500");
        strengthText.textContent = "Faible";
        strengthText.className = "text-sm mt-1 font-medium text-red-600";
    } else if (strength === 2 || strength === 3) {
        strengthBar.classList.add("w-2/3", "bg-yellow-400");
        strengthText.textContent = "Moyen";
        strengthText.className = "text-sm mt-1 font-medium text-yellow-500";
    } else if (strength >= 4) {
        strengthBar.classList.add("w-full", "bg-green-500");
        strengthText.textContent = "Fort";
        strengthText.className = "text-sm mt-1 font-medium text-green-600";
    }
});