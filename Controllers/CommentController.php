<?php

namespace LNCNearComments\Controllers;

use LNCNearComments\Model\Constructor\Constructor;

class CommentController
{

    public function __construct()
    {
        $this->setupActions();
    }

    public function setupActions()
    {
        add_action('template_redirect', [$this, 'provideComment']);
        add_action('wp_ajax_getNCommentsVariables', [$this, 'getNCommentsVariables']);
        add_filter('comment_form_submit_button', [$this, 'replaceCommentButton']);

    }

    public function replaceCommentButton($commentButton)
    {
        $currentUserId = get_current_user_id();
        if (!$currentUserId) {
            $commentButtonText = __('Login with near to leave a comment', 'lnc-n-comments');
            return "<button class='submit submit-btn login-with-near-link'>{$commentButtonText}</button>";
        }
        return $commentButton;
    }

    public function provideComment(): void
    {
        $options = Constructor::$options;
        $selector = isset($options['comment_form_selector'])
            ? preg_replace("/[^a-zA-Z0-9\s]/", '', $options['comment_form_selector'])
            : '';
        $commentCookie = "{$selector}_user_data";
        $currentUser = get_user_by('id', get_current_user_id());
        if (
            $currentUser &&
            isset($_COOKIE[$commentCookie]) &&
            isset($_GET['transactionHashes']) &&
            $_GET['transactionHashes'] &&
            $_COOKIE[$commentCookie]
        ) {
            $hashedComment = json_decode(wp_unslash(sanitize_text_field($_COOKIE[$commentCookie])));
            if ($hashedComment) {
                wp_insert_comment([
                    'comment_content' => sanitize_text_field($hashedComment->comment),
                    'comment_approved' => 1,
                    'comment_post_ID' => $hashedComment->comment_post_ID,
                    'user_id' => $currentUser->ID,
                    'comment_author' => $currentUser->user_login,
                    'comment_author_email' => sanitize_text_field($currentUser->user_email),
                    'comment_author_url' => sanitize_text_field($currentUser->user_url),
                ]);
            }
            unset($_COOKIE[$commentCookie]);
            setcookie($commentCookie, '', time() - 3600, '/');
        }
    }

    public function getNCommentsVariables()
    {
        $options = Constructor::$options;
        $variables = [
            'site_owner' => $options['site_owner'] ?? '',
            'price' => $options['reward_value'] ?? ''
        ];
        return wp_send_json_success($variables);
    }
}