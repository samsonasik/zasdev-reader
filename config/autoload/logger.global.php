<?php
return array(

    'EddieJaoude\Zf2Logger' => array(
        'writers' => array(
            'standard-file' => array(
                'adapter'  => '\Zend\Log\Writer\Stream',
                'options'  => array(
                    'output' => 'data/logs/application.log',
                ),
                'filter' => \Zend\Log\Logger::INFO,
                'enabled' => true
            ),
        )
    )

);
