Symfony Workflow Bundle
==========================

A symfony bundle that allows define and manage workflows.

## Configuration

Add the bundle:

``` json
{
    "require": {
        "aboutcoders/workflow-bundle": "dev-master"
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
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new Abc\Bundle\WorkflowBundle\AbcWorkflowBundle(),
        // ...
    );
}
```

Configure routing 

``` yaml
# app/config/routing.yml
abc_workflow_tasks:
    resource: "@AbcWorkflowBundle/Resources/config/routing.yml"
    prefix:   /
```

If you like to display workflow GUI you have to import optional routing rules

``` yaml
# app/config/routing.yml
abc_workflow_workflows:
    resource: "@AbcWorkflowBundle/Resources/config/routing_optional.yml"
    prefix:   /
```
 
 
Follow the installation and configuration instructions of the third party bundles:

* [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle/blob/master/Resources/doc/index.md)
* [AbcJobBundleBundle](https://bitbucket.org/hasc/job-bundle)

Configure the bundle

``` yaml
# app/config/config.yml
abc_workflow:
  db_driver: orm
```

## Usage

Display workflow configuration GUI

``` twig
{{ workflow_configuration(workflowEntity) }}
```

Display workflow history GUI

``` twig
{{ workflow_history(workflowEntity) }}
```

Get workflow history via AJAX

``` twig
{{ path('execution_history', { 'id': workflowId }) }}
```