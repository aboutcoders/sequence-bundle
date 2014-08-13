Symfony Sequence Bundle
==========================

A symfony bundle that provides abstract sequence implementation

## Configuration

Add the bundle:

``` json
{
    "require": {
        "aboutcoders/sequence-bundle": "dev-master"
    }
}
```

Enable the bundles in the kernel:

``` php
# app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Abc\Bundle\SequenceBundle\AbcSequenceBundle(),
        // ...
    );
}
```

Configure the bundle

``` yaml
# app/config/config.yml
abc_sequence:
  db_driver: orm
```

## Usage

Use Sequence manager to use sequence

``` php
$container->get('abc.sequence.sequence_manager');
```