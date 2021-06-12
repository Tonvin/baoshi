<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'url' => '链接',
    'title' => '标题',
    'tags' => '标签',
    'add_link' => '添加书签',
    'link_list' => '书签列表',
    'edit_link' => '修改书签',
    'add' => '添加',
    'edit' => '修改',
    'login' => '登录',
    'tags_exploded_by_vertical_bar' => '标签，以 | 分割，最多5个。',
    'single_tag_length_limit' => '单个标签限制长度最大10',
    'too_many_tags' => '标签最多5个',
    'url_length_illegal' => '链接地址长度不合法，不能超过2048个字符',
    'title_length_illegal' => '标题长度不合法，不能超过30个字符',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'url' => [
            'required' => '链接地址不能为空',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
