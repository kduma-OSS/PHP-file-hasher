<?php

namespace KDuma\FileHasher;

use MessagePack\Unpacker;

/**
 * Class Checker.
 */
class Checker
{
    /**
     * @param $hash_file
     * @return bool
     * @throws \Exception
     */
    public static function file($hash_file)
    {
        $path_info = pathinfo($hash_file);

        if ($path_info['extension'] != 'ph') {
            throw new \Exception('Unsupported hash file!');
        }

        $hash_file = realpath($path_info['dirname'].'/'.$path_info['basename']);
        $real_file = realpath($path_info['dirname'].'/'.$path_info['filename']);

        if (! $hash_file) {
            throw new \Exception('Hash file doesn\'t exist!');
        }

        if (! $real_file) {
            throw new \Exception('Hashed file doesn\'t exist!');
        }

        $hashes = (new Unpacker())->unpack(file_get_contents($hash_file));

        $sha1 = sha1_file($real_file);
        $md5 = md5_file($real_file);

        if ($sha1 != $hashes['sha1'] || $md5 != $hashes['md5']) {
            return false;
        }

        return true;
    }
}
