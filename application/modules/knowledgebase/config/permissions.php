<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

return [
    'knowledgebase.view' => [
        'name'        => 'View Knowledge Base',
        'description' => 'Allow users to view the knowledge base articles',
        'group'       => 'Knowledge Base'
    ],
    'knowledgebase.comment' => [
        'name'        => 'Comment on Articles',
        'description' => 'Allow users to comment on knowledge base articles',
        'group'       => 'Knowledge Base'
    ],
    'knowledgebase.manage_articles' => [
        'name'        => 'Manage Articles',
        'description' => 'Create, edit, and delete knowledge base articles',
        'group'       => 'Knowledge Base Admin'
    ],
    'knowledgebase.manage_categories' => [
        'name'        => 'Manage Categories',
        'description' => 'Create, edit, and delete knowledge base categories',
        'group'       => 'Knowledge Base Admin'
    ],
    'knowledgebase.manage_tags' => [
        'name'        => 'Manage Tags',
        'description' => 'Create, edit, and delete knowledge base tags',
        'group'       => 'Knowledge Base Admin'
    ],
    'knowledgebase.manage_comments' => [
        'name'        => 'Manage Comments',
        'description' => 'Approve and delete knowledge base comments',
        'group'       => 'Knowledge Base Admin'
    ],
    'knowledgebase.admin' => [
        'name'        => 'Knowledge Base Admin',
        'description' => 'Full access to knowledge base administration',
        'group'       => 'Knowledge Base Admin'
    ]
];
