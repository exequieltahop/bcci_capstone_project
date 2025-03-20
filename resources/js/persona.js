import { FingerprintReader, SampleFormat } from '@digitalpersona/devices';

export default class FingerprintSigninControl {
    constructor(debugOutput, resultMessage, operation = null, field = null) {
        this.sdk = null;
        this.acquisitionStarted = false;
        this.debugOutput = debugOutput;
        this.resultMessage = resultMessage;
        this.operation = operation;
        this.fingerprints = [];
        this.currentSample = null;
        this.field = field;
    }

    async initialize() {
        try {
            this.sdk = new FingerprintReader();

            this.sdk.on("DeviceConnected", this.onDeviceConnected);
            this.sdk.on("DeviceDisconnected", this.onDeviceDisconnected);
            this.sdk.on("QualityReported", this.onQualityReported);
            this.sdk.on("SamplesAcquired", this.onSamplesAcquired);
            this.sdk.on("ErrorOccurred", this.onReaderError);

            await this.sdk.startAcquisition(SampleFormat.Intermediate);

        } catch (initError) {
            this.logError(`Initialization Error: ${initError.message}`);
            return false;
        }
    }

    async stopCapture() {
        await this.sdk.stopAcquisition();
    }

    onDeviceConnected = (event) => {
        this.updateResultMessage('Device Connected. Place finger on scanner.', 'green');
    }

    onDeviceDisconnected = (event) => {
        this.updateResultMessage('Device Disconnected', 'red');
    };

    onQualityReported = (event) => {
        // Log or handle quality of the fingerprint sample
        const quality = event.quality;

        if (quality === 0) {
            console.warn('Fingerprint scan quality is too low. Please check your device.');
            // Prompt user to try again, or adjust finger
        } else if (quality < 60) {
            console.warn('Fingerprint quality is suboptimal. You may want to try again for better results.');
        } else {
            console.log('Fingerprint quality is good.');
        }
    };

    onSamplesAcquired = (event) => {
        console.log(window.location.pathname)
        const samples = event.samples[0].Data;
        if(samples && this.field.value) {

            if(window.location.pathname === '/') {
                this.updateResultMessage('Retrieving Employee Information')
                document.getElementById('employee-name').textContent = ''
                document.getElementById('time-in-text').textContent = ''
                document.getElementById('time-out-text').textContent = ''

                fetch('/entries/biometric/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({employee_code: this.field.value})
                }).then(res => res.json())
                .then(result => {
                    if(!result.success) {
                        this.updateResultMessage(result.message, 'red')
                        return
                    }
                    this.updateResultMessage('Employee Information Retrieved!')
                    document.getElementById('employee-name').textContent = `Name: ${result.entry.name}`
                    document.getElementById('time-in-text').textContent = `Clock In: ${result.entry.clock_in}`
                    document.getElementById('time-out-text').textContent = `Clock Out: ${result.entry.clock_out}`
                }).catch(err => {
                    this.updateResultMessage('Unable to retrieve employee information', 'red')
                })
            } else if (window.location.pathname === '/employees') {
                this.updateResultMessage('Registering Employee Fingerprint')
                fetch('/employee/biometric/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({employee_code: this.field.value, fingerprint: samples})
                }).then(res => res.json())
                .then(result => {
                    if(!result.success) {
                        this.updateResultMessage(result.message, 'red')
                        return
                    }
                    this.updateResultMessage('Employee Fingerprint Registered!', 'green')

                }).catch(err => {
                    console.error(err.message)
                    this.updateResultMessage('Unable to register fingerprint', 'red')
                })
            }
        } else {
            this.updateResultMessage('Employee does not exists!', 'red')
        }
    };

    compareSamples = (sample1, sample2) => {
        // Implement your sample comparison logic here
        // This is a placeholder - you'll need to use the SDK's matching method
        // For example, you might use something like:
        // return this.sdk.compareFingerprints(sample1, sample2);

        // For now, just a simple length comparison as an example
        // return sample1 && sample2 && sample1 === sample2;
        return this.fingerprints.includes(sample1)
    }

    onReaderError = (event) => {
        this.logError(`Capture Error: ${event.error}`);
    };

    updateResultMessage(message, color) {
        if (this.resultMessage) {
            this.resultMessage.textContent = message;
            this.resultMessage.className = `text-center text-${color}-600`;
        }
    }

    logError(message) {
        log(message, 'error', this.debugOutput);
        this.updateResultMessage(message, 'red');
    }
}

function log(message, type = 'info', debugOutput = null) {
    const timestamp = new Date().toISOString();
    const logMessage = `[${timestamp}] ${type.toUpperCase()}: ${message}`;
    console.log(logMessage);
    if (debugOutput) {
        debugOutput.textContent += logMessage + '\n';
        debugOutput.scrollTop = debugOutput.scrollHeight;
    }
}
