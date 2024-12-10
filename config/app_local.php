<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => env('DB_HOST', 'localhost'),
            'username' => env('DB_USERNAME', 'my_app'),
            'password' => env('DB_PASSWORD', 'secret'),
            'database' => env('DB_DATABASE', 'my_app'),
            'url' => env('DATABASE_URL', null),
            'driver' => env('DB_DRIVER', 'Mysql'),
            'encoding' => env('DB_ENCODING', 'latin1'),
            'collation' => env('DB_COLLATION', 'latin1_swedish_ci'),
            'flags' => [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_EMULATE_PREPARES => true,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES latin1',
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ],
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => env('DB_HOST', 'localhost'),
            'username' => env('DB_USERNAME', 'my_app'),
            'password' => env('DB_PASSWORD', 'secret'),
            'database' => env('DB_DATABASE', 'my_app'),
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
            'driver' => env('DB_DRIVER', 'Mysql'),
            'encoding' => env('DB_ENCODING', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_general_ci'),
            'flags' => [\PDO::ATTR_PERSISTENT, \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'],
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => env('SMTP_HOST', 'smtp.mailgun.org'),
            'port' => env('SMTP_PORT', 587),
            'timeout' => 30,
            'username' => env('SMTP_USERNAME', 'your-username'),
            'password' => env('SMTP_PASSWORD', 'your-password'),
            'client' => null,
            'tls' => true,
        ],
    ],

    /*
     * Authentication configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Authentication' => [
        'salt' => 'your-salt-here-make-it-long-and-random',
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => ['your-mailgun-sender@yourdomain.com' => 'Your Site Name'],
        ],
    ],
];
