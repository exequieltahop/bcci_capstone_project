import { log } from './logger.js';

export class FingerprintCapture {
    constructor(debugOutput, resultMessage, operation) {
        this.sdk = null;
        this.acquisitionStarted = false;
        this.debugOutput = debugOutput;
        this.resultMessage = resultMessage;
        this.operation = operation;
        this.fingerprints = [];
    }

    initialize() {
        try {
            // log('Checking SDK Availability', 'debug', this.debugOutput);
            if (typeof Fingerprint === 'undefined') {
                throw new Error('Fingerprint global object is undefined');
            }

            if (!Fingerprint.WebApi) {
                throw new Error('Fingerprint.WebApi is not loaded');
            }

            this.sdk = new Fingerprint.WebApi();

            this.sdk.onDeviceConnected = (e) => {
                // log('Fingerprint device connected', 'info', this.debugOutput);
                this.resultMessage.textContent = 'Device Connected. Place finger on scanner.';
                this.resultMessage.className = 'text-center text-green-600';
            };

            this.sdk.onDeviceDisconnected = (e) => {
                // log('Fingerprint device disconnected', 'info', this.debugOutput);
                this.resultMessage.textContent = 'Device Disconnected';
                this.resultMessage.className = 'text-center text-red-600';
            };

            this.sdk.onSamplesAcquired = (s) => {
                // log('Samples Acquired Event Triggered', 'debug', this.debugOutput);
                this.processSamples(s);
            };

            this.sdk.onError = (error) => {
                // log(`SDK Error: ${error.message}`, 'error', this.debugOutput);
                this.resultMessage.textContent = `Capture Error: ${error.message}`;
                this.resultMessage.className = 'text-center text-red-600';
            };

            return true;
        } catch (initError) {
            log(`Initialization Error: ${initError.message}`, 'error', this.debugOutput);
            this.resultMessage.textContent = `Init Error: ${initError.message}`;
            this.resultMessage.className = 'text-center text-red-600';
            return false;
        }
    }

    startCapture() {
        if (this.acquisitionStarted) {
            log('Acquisition already in progress', 'warning', this.debugOutput);
            return;
        }

        log('Starting fingerprint capture...', 'info', this.debugOutput);
        const currentFormat = Fingerprint.SampleFormat ? Fingerprint.SampleFormat.Intermediate : "Intermediate";
        this.sdk.startAcquisition(currentFormat, "").then(
            () => {
                this.acquisitionStarted = true;
                log('Acquisition started successfully', 'info', this.debugOutput);
                this.resultMessage.textContent = 'Place finger on scanner';
                this.resultMessage.className = 'text-center text-blue-600';
            },
            (error) => {
                log(`Acquisition Start Error: ${error.message}`, 'error', this.debugOutput);
                this.resultMessage.textContent = `Start Error: ${error.message}`;
                this.resultMessage.className = 'text-center text-red-600';
            }
        );
    }

    stopCapture() {
        if (!this.acquisitionStarted) return;

        this.sdk.stopAcquisition().then(
            () => {
                this.acquisitionStarted = false;
                log('Acquisition stopped', 'info', this.debugOutput);
                this.resultMessage.textContent = 'Capture Stopped';
                this.resultMessage.className = 'text-center text-gray-600';
            },
            (error) => {
                log(`Stop Acquisition Error: ${error.message}`, 'error', this.debugOutput);
            }
        );
    }

    async processSamples(samples) {
        try {
            const parsedSamples = JSON.parse(samples.samples || '{}');
            const sampleArray = Array.isArray(parsedSamples) ? parsedSamples : [parsedSamples];

            sampleArray.forEach((sample, index) => {
                var sampleData = Fingerprint.b64UrlTo64(sample.Data);
                if(this.fingerprints.includes(sampleData)) {
                    console.log(this.fingerprints.indexOf(sampleData))
                }

                this.fingerprints.push(sampleData)

                this.fingerprints.forEach(fingerprint => {
                    this.sdk.verify(fingerprint, sample).then(
                        (isMatch) => {
                            if (isMatch) {
                                console.log("Fingerprints match!");
                            }
                        },
                        (error) => {
                            log(`Verification Error: ${error.message}`, 'error', this.debugOutput);
                        }
                    );
                })
            });

            console.log(this.fingerprints)

            // if(this.operation === 'reading') {
            //     const response = await (await fetch('/entries/biometric/login', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json', // Specify that you're sending JSON
            //         },
            //         body: JSON.stringify({ 'fingerprint': fingerprint })
            //     })).json();

            //     console.log(response)
            //     // .then(res => res.json()).then(resp => { result = resp }).catch(e => console.error(e.message))
            // }


            this.resultMessage.textContent = 'Fingerprint Captured Successfully';
            this.resultMessage.className = 'text-center text-green-600';
        } catch (error) {
            log(`Sample Processing Error: ${error.message}`, 'error', this.debugOutput);
            this.resultMessage.textContent = 'Error Processing Fingerprint Data';
            this.resultMessage.className = 'text-center text-red-600';
        }
    }
}
