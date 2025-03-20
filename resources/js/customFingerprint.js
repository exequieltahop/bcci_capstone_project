import FingerprintSigninControl from './persona.js';

document.addEventListener('DOMContentLoaded', async() => {
    const scannerStatus = document.getElementById('scanner-status');
    const debugOutput = document.getElementById('debug-output');
    const employeeCodeField = document.getElementById('employee_code')

    const operation = window.location.pathname === '/' ? 'reading' : 'register';

    const fingerprintCapture = new FingerprintSigninControl(debugOutput, scannerStatus, operation, employeeCodeField);

    await fingerprintCapture.initialize()
});
