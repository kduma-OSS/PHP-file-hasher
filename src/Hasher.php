<?php

namespace KDuma\FileHasher;

use MessagePack\Packer;

/**
 * Class Hasher.
 */
class Hasher
{
    /**
     * @param $real_file
     * @return bool
     * @throws \Exception
     */
    public static function file($real_file)
    {
        $path_info = pathinfo($real_file);

        $real_file = realpath($path_info['dirname'].'/'.$path_info['basename']);
        $hash_file = $real_file.'.ph';

        if (! $real_file) {
            throw new \Exception('Hashed file doesn\'t exist!');
        }

        $sha1 = sha1_file($real_file);
        $md5 = md5_file($real_file);

        file_put_contents($hash_file, (new Packer())->pack(['sha1' => $sha1, 'md5' => $md5]));

        return true;
    }
}
