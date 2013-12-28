<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'phpSettings' => array(
        'display_startup_errors' => true,
        'display_errors' => true,
        'date.timezone' => 'Europe/Paris',
        'intl.default_locale' => 'fr_FR'
    ),
    'doctrine' => array(
        'entitymanager' => array(
            'orm_default' => array(
                'connection'    => 'orm_default',
                'configuration' => 'orm_default'
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'proxy_dir' => __DIR__ . '/../../data/orm/proxies',
                'proxy_namespace' => 'Orm\Resource\Proxy',
                'generate_proxies' => false,
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'driver'            => 'orm_default',
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function($identity, $credential)
                {
                    $bCrypt = new \Zend\Crypt\Password\Bcrypt();
                    return $bCrypt->verify($credential, $identity->getPassword());
                }
            )
        )
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../../language',
                'pattern' => '%s.php'
            )
        )
    ),
);
