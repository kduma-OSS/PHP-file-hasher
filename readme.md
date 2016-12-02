# PHP file hasher

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]
[![StyleCI](https://styleci.io/repos/75410955/shield?branch=master)](https://styleci.io/repos/75410955)

MD5 and SHA1 file hash calculator and checker

## Install

Via Composer

``` bash
$ composer require kduma/file-hasher
```

## Usage

``` php
use KDuma\FileHasher\Checker;
use KDuma\FileHasher\Hasher;

var_dump(Hasher::file('test.php'));
var_dump(Checker::file('test.php.ph'));
```

## Credits

- [Krystian Duma][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/kduma/file-hasher.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kduma/file-hasher.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/kduma/file-hasher
[link-downloads]: https://packagist.org/packages/kduma/file-hasher
[link-author]: https://github.com/kduma
[link-contributors]: ../../contributors