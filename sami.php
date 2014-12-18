<?php

require 'vendor/autoload.php';

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('**.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->exclude('vendor')
    ->exclude('build')
    ->in(__DIR__)
;

$versions = GitVersionCollection::create(__DIR__)
    ->addFromTags('v1.0.*')
    ->add('master', 'master branch')
;

return new Sami($iterator, array(
    'title'                => 'GeoLocation Bundle',
    'versions'             => $versions,
    'build_dir'            => __DIR__.'/build/doc/%version%',
    'cache_dir'            => __DIR__.'/cache/doc/%version%',
    'default_opened_level' => 3,
));