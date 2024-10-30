import {
    NCommentsPaymentProcessor,
} from './nCommentsPaymentProcessor';

import {
    commentFormProcessor,
} from './commentFormProcessor';

const getNCommentsVariables = async (ajaxUrl) => {
    let variables = {};
    await jQuery.ajax({
        type: 'POST',
        url: ajaxUrl,
        data: {
            action: 'getNCommentsVariables',
        },
        success: async (result) => {
            if (result.errorMessage) {
                alert(result.errorMessage);
            } else {
                variables = result.data;
            }
        },
        error: (error) => {
            console.log(error);
        },
    });
    return variables;
}

const paymentAction = async (paymentProcessor) => {
    const defaultError = 'Something goes wrong please reload page and try again';
    jQuery('.verify-submit-comment').click(async (event) => {
        event.preventDefault();
        const {price, site_owner} = await getNCommentsVariables(paymentProcessor.ajaxurl);
        if (!price || !site_owner) {
            throw new Error('NComments configured incorrectly please contact site owner');
        }
        const form = jQuery(event.target).closest('form')[0];
        if (!form) {
            throw new Error(defaultError);
        }
        const amount = parseFloat(price);
        if (!amount) {
            throw new Error(defaultError);
        }
        commentFormProcessor.keepFormData(form);
        await paymentProcessor.payForSubmission(price, site_owner);
    })
}

const initNCommentsMainThread = async () => {
    try {
        commentFormProcessor.init();
        const paymentProcessor = new NCommentsPaymentProcessor(
            window.mainWallet.accountId,
            window?.lnc_near_comments.ajax_url
        );
        await paymentProcessor.init()
        const searchParams = new URLSearchParams(window.location.search);

        if (searchParams.has('transactionHashes')) {
            commentFormProcessor.skipTransaction(searchParams.get('transactionHashes'));
        }

        if (!commentFormProcessor.isCommentFormTransactionCookies()) {
            commentFormProcessor.replaceSubmitForm();
        }
        await paymentAction(paymentProcessor)
    } catch (e) {
        console.log(e.message);
    }

}

export { initNCommentsMainThread };
