import { getCookie } from './commonUtils';

export const commentFormProcessor = {
  payBtn: '<div>' +
    '<button class="verify-submit-comment">Verify with nCaptcha to post comment</button>' +
    '</div>',
  loginBtn: '<div>' + '<button class="login-with-near-link">Login with near to leave a comment</button>' + '</div>',
  commentForm: null,

  isCommentFormTransactionCookies: function () {
    let result = false;
    if (this.commentForm) {
      const userData = getCookie(`${this.commentForm.attr('id')}_user_data`);
      if (userData) {
        const dataObject = JSON.parse(userData);
        if (dataObject['transaction'] && dataObject['transaction'] !== '') {
          result = true;
        }
      }
    }
    return result;
  },

  getPageNCommentForm: function () {
    this.commentForm = jQuery(window.lnc_near_comments.comment_form_selector);
  },

  replaceSubmitForm: function () {
    if (this.commentForm) {
      const submits = this.commentForm.find(':submit');
      if (submits.length > 0) {
        if (window?.mainWallet?.isSignedIn) {
          jQuery(submits[0]).replaceWith(this.payBtn);
        }
      }
    }
  },

  skipTransaction: function (transaction = '') {
    if (this.commentForm) {
      const userData = getCookie(`${this.commentForm.attr('id')}_user_data`);
      if (userData) {
        const dataLabel = `${jQuery(this.commentForm).attr('id')}_user_data`;
        document.cookie = `${dataLabel} = `;
        window.history.replaceState(null, null, window.location.pathname);
      }
    }
    history.pushState("", document.title, window.location.pathname
      + window.location.search);
  },

  keepFormData: function (form) {
    const dataLabel = `${jQuery(form).attr('id')}_user_data`;
    const dataArray = jQuery(form).serialize().split('&');
    const dataForSave = {};
    if (dataArray.length > 0) {
      dataArray.map((item) => {
        const itemData = decodeURI(item).split('=');
        if (itemData[0] && itemData[1]) {
          dataForSave[itemData[0]] = itemData[1];
        }
      });
    }
    dataForSave['transaction'] = '';
    document.cookie = `${dataLabel} = ${JSON.stringify(dataForSave)}`;
  },

  cleanAfterSubmission: function () {
    if (this.commentForm) {
      if (window.location.hash.search(/#comment-[\d]+/) !== -1) {
        const dataLabel = `${jQuery(this.commentForm).attr('id')}_user_data`;
        document.cookie = `${dataLabel} = `;
        history.pushState("", document.title, window.location.pathname
          + window.location.search);
      }
    }
  },

  init: function () {
    this.getPageNCommentForm();
    this.cleanAfterSubmission();
  }
};
