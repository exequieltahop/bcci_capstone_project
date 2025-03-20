import FingerprintSigninControl from './persona.js';

document.addEventListener('DOMContentLoaded', async () => {
    const scannerStatus = document.getElementById('scanner-status');
    const debugOutput = document.getElementById('debug-output');
    const employeeCodeField = document.getElementById('employee_code');

    const fingerprintCapture = new FingerprintSigninControl(debugOutput, scannerStatus, null, employeeCodeField);


    // register toggle-btn event
    document.querySelectorAll('#toggle-btn').forEach(element => {
        element.addEventListener('click', async (event) => {
            const modal = document.getElementById("tailwind-modal");
            console.log(modal.classList.contains("hidden"))

            if (modal.classList.contains("hidden")) {
                modal.classList.remove("hidden");
                modal.classList.add("pointer-events-auto");
                await fingerprintCapture.initialize()
            } else {
                modal.classList.add("hidden");
                modal.classList.remove("pointer-events-auto");
                await fingerprintCapture.stopCapture();
            }
        });
    });
});



