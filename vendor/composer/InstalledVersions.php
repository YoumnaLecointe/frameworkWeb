<?php











namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => 'e2dd2730c6a9d2905c3aa0abae7da6715d081964',
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => 'e2dd2730c6a9d2905c3aa0abae7da6715d081964',
    ),
    'frameworks/jquery' => 
    array (
      'pretty_version' => '2.1.4',
      'version' => '2.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ef9c4fe9fcb23914bba6ec6d32c556e4a38a0fd9',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1cb1cde8e8dd0f70cc0fe51354a59acad9302084',
    ),
    'phpmv/php-mv-ui' => 
    array (
      'pretty_version' => '2.3.17',
      'version' => '2.3.17.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e38ed86d7a756be41658229e35a2931710cdf3f2',
    ),
    'phpmv/ubiquity' => 
    array (
      'pretty_version' => '2.4.1',
      'version' => '2.4.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4150d848cc67d5171fb8e033c537d7a849a6d915',
    ),
    'phpmv/ubiquity-attributes' => 
    array (
      'pretty_version' => 'dev-main',
      'version' => 'dev-main',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => 'f7a1c63fd10896ccad768710762975e7b5c166e9',
    ),
    'phpmv/ubiquity-dev' => 
    array (
      'pretty_version' => '0.1.9',
      'version' => '0.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '2266f6a47c3d33a29bdaffcd247bd3a5bfee911b',
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0.0',
      ),
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.22.0',
      'version' => '1.22.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.22.0',
      'version' => '1.22.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f377a3dd1fde44d37b9831d68dc8dea3ffd28e13',
    ),
    'twig/twig' => 
    array (
      'pretty_version' => 'v3.2.1',
      'version' => '3.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f795ca686d38530045859b0350b5352f7d63447d',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
