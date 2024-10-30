import * as nearAPI from 'near-api-js';
import { PaymentProcessor } from './PaymentProcessor';

const {
    utils
} = nearAPI;

export class NCommentsPaymentProcessor extends PaymentProcessor {
    async payForSubmission(price, siteOwner) {
        if (window?.mainWallet?.isSignedIn && window?.mainWallet?.accountId) {
            const amount = utils.format.parseNearAmount(`${price}`);
            const transactionResult = await window?.mainWallet?.callMethod({
                contractId: 'v1.ncaptcha.near',
                method: 'add_n_captcha_rating',
                args: {site_owner: siteOwner},
                gas: 300000000000000,
                deposit: amount,
                outcomeData: true
            });
            if (transactionResult && transactionResult?.transaction?.hash) {
                window.location.replace(`${window.location.href}?transactionHashes=${transactionResult.transaction.hash}`)
            }
        }
    }
}
