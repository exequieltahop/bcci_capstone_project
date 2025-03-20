document.addEventListener('alpine:init', () => {
    Alpine.data('data', () => ({
        dark: false,

        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },

        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },

        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },

        closeSideMenu() {
            this.isSideMenuOpen = false
        },

        isMultiLevelMenuOpen: false,
        toggleMultiLevelMenu() {
            this.isMultiLevelMenuOpen = !this.isMultiLevelMenuOpen
        },

        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen
        },

        // Dashboard
        confirmAction: false,

        async registerAuth(employeeCode = null) {
            const modal = document.getElementById("tailwind-modal");

            if (modal.classList.contains("hidden")) {
                modal.classList.remove("hidden");
                modal.classList.add("pointer-events-auto");
            } else {
                modal.classList.add("hidden");
                modal.classList.remove("pointer-events-auto");
            }
            // if (Webpass.isUnsupported()) {
            //     alert("Your browser doesn't support WebAuthn.")
            // }

            // const { success } = await Webpass.attest({path: "/webauthn/register/options", body: {email: userEmail}}, "/webauthn/register")

            // if (success) {
            //     window.alert('User fingerprint successfully registered!')
            // }
        },

        async verifyAuth() {
            const { success }= await Webpass.assert("/webauthn/login/options", "/webauthn/login")

            if(success) {
             const recordResponse = await fetch('/entries/check-user-record')
             const {state} = await recordResponse.json()

             const clockInOutResponse = state == 'clock in' ? await fetch('/entries/clock-in/api', {method: 'POST'}) : await fetch('/entries/clock-out/api', {method: 'POST'})
             const {entry} = await clockInOutResponse.json()
             document.getElementById('time-in-text').textContent = `Time In: ${entry.clock_in}`;
             document.getElementById('time-out-text').textContent = `Time Out: ${entry.clock_out}`;
            }
        },
    }))
})
