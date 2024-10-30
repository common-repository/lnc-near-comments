export class PaymentProcessor {
    constructor(
        contract,
        ajaxurl,
    ) {
        this.contract = contract;
        this.ajaxurl = ajaxurl;
    }

    async setInitialData() {
    }

    getUserAccount() {
        return window?.mainWallet?.accountId;
    }

    async signIn() {
        await window?.mainWallet?.signIn();
    }

    async init() {
        await this.setInitialData();
    }
}

