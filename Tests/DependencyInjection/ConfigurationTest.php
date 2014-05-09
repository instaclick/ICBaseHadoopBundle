<?php
/**
 * @copyright 2014 Instaclick Inc.
 */

namespace IC\Bundle\Base\HadoopBundle\Tests\DependencyInjection;

use IC\Bundle\Base\TestBundle\Test\DependencyInjection\ConfigurationTestCase;
use IC\Bundle\Base\HadoopBundle\DependencyInjection\Configuration;

/**
 * Test for Configuration
 *
 * @group ICBaseHadoopBundle
 * @group Unit
 * @group DependencyInjection
 *
 * @author Eldar Gafurov <eldarg@nationalfibre.net>
 */
class ConfigurationTest extends ConfigurationTestCase
{
    /**
     * Test valid data
     */
    public function testValidData()
    {
        $validData     = $this->provideValidData();
        $configuration = $this->processConfiguration(new Configuration(), $validData);

        $this->assertEquals('hadoop.host', $configuration['hadoop']['host']);
        $this->assertEquals('hadoop.port', $configuration['hadoop']['port']);
        $this->assertEquals('hadoop.path', $configuration['hadoop']['path']);
    }

    /**
     * Provide valid data
     *
     * @return array
     */
    private function provideValidData()
    {
        return array(
            array(
                'hadoop' => array(
                    'host' => 'hadoop.host',
                    'port' => 'hadoop.port',
                    'path' => 'hadoop.path',
                ),
            ),
        );
    }
}
