<?php
namespace ZasDev\Common\Util;

/**
 * Utility class to work with Universal User IDs
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class UUID
{

    const V3 = "v3";
    const V4 = "v4";
    const V5 = "v5";

    /**
     * @var array
     */
    private static $versions;

    public static function generate($version, array $options = array())
    {
        if (!self::isValidVersion($version)) {
            throw new \InvalidArgumentException(
                sprintf("Provided version %s is not valid. Value should be one of [%s]", $version, implode(", ", self::getValidVersions()))
            );
        }

        if ($version == self::V4) {
            return self::generateV4();
        } else {
            if (!array_key_exists('namespace', $options) || !array_key_exists('name', $options)) {
                throw new \InvalidArgumentException(
                    sprintf("You must provide a 'namespace' and a 'name' to generate a %s UUID", $version)
                );
            }

            if ($version == self::V3) {
                return self::generateV3($options['namespace'], $options['name']);
            } else {
                return self::generateV5($options['namespace'], $options['name']);
            }
        }
    }

    private static function getValidVersions()
    {
        if (!isset(static::$versions)) {
            $r = new \ReflectionClass(__CLASS__);
            $versions = $r->getConstants();
            static::$versions = array_values($versions);
        }

        return static::$versions;
    }
    private static function isValidVersion($version)
    {
        return in_array($version, self::getValidVersions());
    }

    /**
     * Generates a v3 UUID
     * @param $namespace
     * @param $name
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function generateV3($namespace, $name)
    {
        if (!self::isNamespaceValid($namespace)) {
            throw new \InvalidArgumentException(sprintf("Provided namespace '%s' is not valid", $namespace));
        }

        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-','{','}'), '', $namespace);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for ($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }

        // Calculate hash value
        $hash = md5($nstr . $name);

        return sprintf('%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),

            // 16 bits for "time_mid"
            substr($hash, 8, 4),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 3
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    /**
     * Generates a v4 UUID
     * @return string
     */
    public static function generateV4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Generates a v5 UUID
     * @param $namespace
     * @param $name
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function generateV5($namespace, $name)
    {
        if (!self::isNamespaceValid($namespace)) {
            throw new \InvalidArgumentException(sprintf("Provided namespace '%s' is not valid", $namespace));
        }

        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-','{','}'), '', $namespace);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for ($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }

        // Calculate hash value
        $hash = sha1($nstr . $name);

        return sprintf('%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),

            // 16 bits for "time_mid"
            substr($hash, 8, 4),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 5
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    /**
     * Validates a namespace for v3 and v5 UUIDs
     * @param $namespace
     * @return bool
     */
    private static function isNamespaceValid($namespace)
    {
        return
            preg_match(
                '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i',
                $namespace
            ) === 1;
    }

} 