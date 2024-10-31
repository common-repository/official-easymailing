<?php return array(
    'root' => array(
        'name' => 'easymailing/wordpress-plugin',
        'pretty_version' => 'v1.1.0',
        'version' => '1.1.0.0',
        'reference' => '5cc296c4afe2182e61b079693d41966199ac1b2f',
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => false,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '98b34f8ab3558bee5caa7c07efbab3f5bd7663ab',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(
                0 => '1.x-dev',
            ),
            'dev_requirement' => false,
        ),
        'easymailing/wordpress-plugin' => array(
            'pretty_version' => 'v1.1.0',
            'version' => '1.1.0.0',
            'reference' => '5cc296c4afe2182e61b079693d41966199ac1b2f',
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roundcube/plugin-installer' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
    ),
);
