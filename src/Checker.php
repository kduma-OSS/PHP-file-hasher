<?php

namespace KDuma\FileHasher;

use Exception;
use MessagePack\MessagePack;

/**
 * Class Checker.
 */
class Checker
{
    /**
     * @param string $hash_file
     * @return bool
     * @throws Exception
     */
    public static function file(string $hash_file): bool
    {
        $path_info = pathinfo($hash_file);

        if ($path_info['extension'] != 'ph') {
            throw new Exception('Unsupported hash file!');
        }

        $hash_file = realpath($path_info['dirname'].'/'.$path_info['basename']);
        $real_file = realpath($path_info['dirname'].'/'.$path_info['filename']);

        if (! $hash_file) {
            throw new Exception('Hash file doesn\'t exist!');
        }

        if (! $real_file) {
            throw new Exception('Hashed file doesn\'t exist!');
        }

        $hashes = MessagePack::unpack(file_get_contents($hash_file));

        $sha1 = sha1_file($real_file);
        $md5 = md5_file($real_file);

        if ($sha1 != $hashes['sha1'] || $md5 != $hashes['md5']) {
            return false;
        }

        return true;
    }

    /**
     * @param $stream
     * @param $checksums_string
     * @return bool
     */
    public static function stream($stream, $checksums_string): bool
    {
        $sha1 = hash_init('sha1');
        $md5 = hash_init('md5');

        while ($buffer = fread($stream, 1024)) {
            hash_update($sha1, $buffer);
            hash_update($md5, $buffer);
        }

        $sha1 = hash_final($sha1);
        $md5 = hash_final($md5);

        $hashes = MessagePack::unpack($checksums_string);

        if ($sha1 != $hashes['sha1'] || $md5 != $hashes['md5']) {
            return false;
        }

        return true;
    }

    /**
     * @param string $content
     * @param string $checksums_string
     *
     * @return bool
     */
    public static function string(string $content, string $checksums_string): bool
    {
        $sha1 = sha1($content);
        $md5 = md5($content);

        $hashes = MessagePack::unpack($checksums_string);

        if ($sha1 != $hashes['sha1'] || $md5 != $hashes['md5']) {
            return false;
        }

        return true;
    }
}
