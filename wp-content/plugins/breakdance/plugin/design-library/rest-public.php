<?php

namespace Breakdance\DesignLibrary;

use function Breakdance\Data\get_meta;
use function Breakdance\Data\load_global_settings;
use function Breakdance\Themeless\getFootersAsWPPosts;
use function Breakdance\Themeless\getGlobalBlocksAsWpPosts;
use function Breakdance\Themeless\getHeadersAsWPPosts;
use function Breakdance\Themeless\getPopupsAsWPPosts;
use function Breakdance\Themeless\getTemplatesAsWPPosts;
use function Breakdance\Themeless\getTemplateSettingsFromDatabase;

/**
 * NOTE: Always check `isDesignLibraryEnabled()` before doing anything to secure the endpoints
 */
add_action('breakdance_loaded', function () {
    \Breakdance\AJAX\register_handler(
        'breakdance_get_design_set',
        'Breakdance\DesignLibrary\getDesignSetData',
        'none',
        true,
        [
            'remote' => true
        ]

    );

    \Breakdance\AJAX\register_handler(
        'breakdance_get_local_design_set',
        'Breakdance\DesignLibrary\getLocalDesignSetData',
        'full',
        true,
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_get_ids_of_posts_and_pages_to_export',
        '\Breakdance\DesignLibrary\getIdsOfPagesAndPostsToExport',
        'none',
        true,
        [
            'remote' => true
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_get_homepage_id',
        '\Breakdance\DesignLibrary\getHomepageId',
        'none',
        true,
        [
            'remote' => true
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_get_ids_of_templates_to_export',
        '\Breakdance\DesignLibrary\getIdsOfTemplatesToExport',
        'none',
        true,
        [
            'remote' => true
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_get_global_settings_for_design_library',
        '\Breakdance\DesignLibrary\getGlobalSettingsForDesignLibrary',
        'none',
        true,
        [
            'remote' => true
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_get_post_data',
        '\Breakdance\DesignLibrary\getBreakdancePostData',
        'none',
        true,
        [
            'remote' => true,
            'args' => [
                'id' => FILTER_VALIDATE_INT
            ],
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_get_template_data',
        '\Breakdance\DesignLibrary\getTemplateData',
        'none',
        true,
        [
            'remote' => true,
            'args' => [
                'id' => FILTER_VALIDATE_INT
            ],
        ]
    );

    \Breakdance\AJAX\register_handler(
        'breakdance_design_lib_check_password',
        '\Breakdance\DesignLibrary\checkPasswordEndpoint',
        'none',
        true,
        [
            'remote' => true,
            'args' => [
                'password' => FILTER_UNSAFE_RAW
            ],
        ]
    );
});

/**
 * @return DesignSetData
 */
function getDesignSetData()
{
    $isDesignLibraryEnabled = isDesignLibraryEnabled();
    $maybePassword = getPasswordFromRequest();

    if (!$isDesignLibraryEnabled) {
        return [
            'enabled' => false,
            'reliesOnGlobalSettings' => false,
            'requiresPassword' => false,
            'name' => '',
            'posts' => []
        ];
    }

    return [
        'enabled' => true,
        'reliesOnGlobalSettings' => doesDesignLibraryRelyOnGlobalSettings(),
        'name' => get_bloginfo('name'),
        'posts' => getPostsForDesignSet(),
        'requiresPassword' => isPasswordProtected(),
        'passwordValid' => checkPassword($maybePassword)
    ];
}

/**
 * @return DesignSetData
 */
function getLocalDesignSetData()
{
    return [
        'enabled' => true,
        'reliesOnGlobalSettings' => false,
        'name' => get_bloginfo('name'),
        'posts' => getPostsForDesignSet(),
        'requiresPassword' => false,
        'passwordValid' => true
    ];
}

/**
 * @return int[]|array{error: string}
 */
function getIdsOfPagesAndPostsToExport()
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    /** @var int[] $postIds */
    $postIds = get_posts(
        array_merge(
            getArgumentsForDesignSetPostsQuery(false),
            ['fields' => 'ids']
        )
    );

    return $postIds;
}

/**
 * @return array{id: string}|array{error: string}
 */
function getHomepageId(){
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    return ['id' => (string)get_option('page_on_front')];
}

/**
 * @return array
 */
function getIdsOfTemplatesToExport()
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    $fieldIdOnly = ['fields' => 'ids'];

    // getTemplatesAsWPPosts returns WP_POST
    /** @var int[] */
    $templateIds = getTemplatesAsWPPosts(false, $fieldIdOnly);
    /** @var int[] */
    $headersIds = getHeadersAsWPPosts(false, $fieldIdOnly);
    /** @var int[] */
    $footersIds = getFootersAsWPPosts(false, $fieldIdOnly);
    /** @var int[] */
    $popupsIds = getPopupsAsWPPosts(false, $fieldIdOnly);
    /** @var int[] */
    $blocksIds = getGlobalBlocksAsWpPosts(false, $fieldIdOnly);

    return [
        'templateIds' => removeFallbacksFromTemplateIdsList($templateIds),
        'headerIds' => removeFallbacksFromTemplateIdsList($headersIds),
        'footerIds' => removeFallbacksFromTemplateIdsList($footersIds),
        'popupIds' => removeFallbacksFromTemplateIdsList($popupsIds),
        'blockIds' => removeFallbacksFromTemplateIdsList($blocksIds)
    ];
}

/**
 * @return array
 */
function getGlobalSettingsForDesignLibrary()
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    if (!doesDesignLibraryRelyOnGlobalSettings()) {
        return ['error' => "This site design doesn't rely on global settings "];
    }

    return load_global_settings();
}

/**
 * @param int $id
 * @return array
 */
function getBreakdancePostData($id)
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    $post = get_post($id);

    if (!$post) return ['error' => "Couldn't load post with ID of " . $id];

    /** @var \WP_Post $post */
    $post = $post;

    // only send the crucial info to create a duplicate of the post
    // NOTE this won't include meta data like fields
    // nor featured image, since that requires importing the image as an attachment
    $postData = [
        'post_title' => $post->post_title,
        'post_name' => $post->post_name,
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_status' => $post->post_status,
        'post_type' => $post->post_type,
    ];

    return [
        'postData' => $postData,
        'breakdanceData' => get_meta((int)$id, 'breakdance_data')
    ];
}

/**
 * @param int $id
 * @return array
 */
function getTemplateData($id)
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    $template = get_post($id);

    if (!$template) return ['error' => 'Wrong template id: ' . $id];

    $settings = getTemplateSettingsFromDatabase($id);

    if ($settings['fallback'] ?? false) {
        return ['isFallback' => true];
    }

    /** @var \WP_Post $template */
    $template = $template;

    return [
        'title' => $template->post_title,
        'settings' => $settings,
        'postType' => $template->post_type,
        'breakdanceData' => get_meta($id, 'breakdance_data')
    ];
}

/**
 * @param string $password
 * @return array{valid: bool}|array{error: string}
 */
function checkPasswordEndpoint($password)
{
    if (!isDesignLibraryEnabled()) {
        return getDesignLibraryNotEnabledError();
    }

    $valid = checkPassword($password);

    return ['valid' => $valid];
}

/**
 * @return array{error: string}
 */
function getDesignLibraryNotEnabledError() {
    return ['error' => "The design library isn't enabled on this site"];
}
