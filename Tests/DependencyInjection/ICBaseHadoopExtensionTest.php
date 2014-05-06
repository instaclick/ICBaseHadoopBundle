<?php
/**
 * @copyright 2013 Instaclick Inc.
 */

namespace IC\Bundle\Base\HadoopBundle\Tests\DependencyInjection;

use IC\Bundle\Base\HadoopBundle\DependencyInjection\ICBaseHadoopExtension;
use IC\Bundle\Base\TestBundle\Test\DependencyInjection\ExtensionTestCase;

/**
 * Test for ICBaseHadoopExtension
 *
 * @group ICBaseHadoopBundle
 * @group Unit
 * @group DependencyInjection
 *
 * @author Eldar Gafurov <eldarg@nationalfibre.net>
 */
class ICBaseHadoopExtensionTest extends ExtensionTestCase
{
    /**
     * Test valid data
     *
     * @param array $config
     *
     * @dataProvider provideValidData
     */
    public function testValidData($config)
    {
        $loader = new ICBaseHadoopExtension();

        $this->load($loader, $config);

        $this->assertParameter('hadoop.host', 'ic_base_hadoop.hdfs.host');
        $this->assertParameter('hadoop.port', 'ic_base_hadoop.hdfs.port');
        $this->assertParameter('hadoop.path', 'ic_base_hadoop.hdfs.path');
    }

    /**
     * Provide valid data
     *
     * @return array
     */
    public function provideValidData()
    {
        return array(
            array(
                array(
                    'hadoop' => array(
                        'host' => 'hadoop.host',
                        'port' => 'hadoop.port',
                        'path' => 'hadoop.path',
                    ),
                ),
            ),
        );
    }
}
