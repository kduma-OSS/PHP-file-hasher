<?php

namespace KDuma\FileHasher;

use Exception;
use MessagePack\MessagePack;

/**
 * Class Hasher.
 */
class Hasher
{
    /**
     * @param $real_file
     *                  
     * @return bool
     * @throws Exception
     */
    public static function file($real_file): bool
    {
        $path_info = pathinfo($real_file);

        $real_file = realpath($path_info['dirname'].'/'.$path_info['basename']);
        $hash_file = $real_file.'.ph';

        if (! $real_file) {
            throw new Exception('Hashed file doesn\'t exist!');
        }

        $sha1 = sha1_file($real_file);
        $md5 = md5_file($real_file);

        file_put_contents($hash_file, MessagePack::pack(['sha1' => $sha1, 'md5' => $md5]));

        return true;
    }

    /**
     * @param resource $stream
     *
     * @return string
     */
    public static function stream($stream): string
    {
        $sha1 = hash_init('sha1');
        $md5 = hash_init('md5');

        while ($buffer = fread($stream, 1024)) {
            hash_update($sha1, $buffer);
            hash_update($md5, $buffer);
        }

        $sha1 = hash_final($sha1);
        $md5 = hash_final($md5);

        return MessagePack::pack(['sha1' => $sha1, 'md5' => $md5]);
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public static function string(string $content): string
    {
        $sha1 = sha1($content);
        $md5 = md5($content);

        return MessagePack::pack(['sha1' => $sha1, 'md5' => $md5]);
    }
}
