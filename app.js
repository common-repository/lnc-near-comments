import { initNCommentsMainThread } from './src';

document.addEventListener('DOMContentLoaded', async () => {
    await (async () => {
        return await new Promise(resolve => {
            const interval = setInterval(() => {
                if (window?.mainWallet?.isLoaded && window?.lnc_near_comments) {
                    (async () => {
                        await initNCommentsMainThread();
                    })()
                    clearInterval(interval);
                }
            }, 600);
        });
    })();
});