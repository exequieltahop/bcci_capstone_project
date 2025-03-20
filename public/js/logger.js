export function log(message, type = 'info', debugOutput = null) {
    const timestamp = new Date().toISOString();
    const logMessage = `[${timestamp}] ${type.toUpperCase()}: ${message}`;
    console.log(logMessage);
    if (debugOutput) {
        debugOutput.textContent += logMessage + '\n';
        debugOutput.scrollTop = debugOutput.scrollHeight;
    }
}
