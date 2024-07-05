BFPrgBundle
=============

The BFPrgBundle adds support for masking urls based on PRG-Pattern.

For more information about this pattern please take a closer look to the
following url: [Post/Redirect/Get](https://en.wikipedia.org/wiki/Post/Redirect/Get)

**Note:** This bundle is built for use in a symfony application.


Installation & Setup
--------------------

1. Run ```composer require burdaforward/bf-prg-bundle``` or download teh bundle to you local vendor directory
2. Activate this bundle
   - It should be activated automatically if you have Symfony Flex installed
   - Manually via ```src/Kernel.php``` or ```config/bundles.php```
    ```php
    ...
    
    class Kernel extends BaseKernel
    {
        ... 
        
        public function registerBundles()
        {
            $bundles = array(
                ...
                
                new BurdaForward\BFPrgBundle\BFPrgBundle(),
                
                ...
            );
    
            return $bundles;
        }
    
        ...
    }
    ```

3. Add the bundle to your routing configuration like ```config/routes.yaml```
 
    ```yaml
      prg:
         resource: "@BFPrgBundle/Resources/config/routing.yml"
    ```
    
    This routing.yml enables a required route ```/prg_resolve```.

4. In the last step you need to include the basic template of that bundle into your templates.
  
    (Best position is before closing body tag.)
  
    ```twig
    {% include '@BFPrg/prg_form.html.twig' %}  
    ```
 

Usage & Examples
----------------

The bundle provides a twig function you can call in your templates. 

    Function name: prg_link
    Function parameter:
        url: Destination URL including GET parameter
        title: Label  of the masked link. e.g. <a href="#">TITLE</a>
        options: This is an array the supports the following options.
            class: you can set the css class of the rendered element
            element: the default is "span" but if you want to render a "button", "div" or "a" you can set it with this option
            target: you can define if the link should open in the same window (default value) or in a new one 
                    valid values are
                        - _self (same frame)
                        - _top (same window
                        - _blank (new window)
            only_open_tag: has to be set true or false - the result will only return the opening tag of a prg link 
                           ATTENTION: You have to close the tag by yourself.


Basic example:

    {{ prg_link('http://example.org?q=sample', 'Click me')|raw }}
    
    Result: <span class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl"  data-target="_self">Click me</span>
    
    
Stylesheet example:
    
    {{ prg_link('http://example.org?q=sample', 'Click me', {class: 'my-link'})|raw }}
    
    Result: <span class="prg-link my-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl"  data-target="_self">Click me</span>
    
Target example    

    {{ prg_link('http://example.org?q=sample', 'Click me', {target: '_blank'})|raw }}

    Result: <span class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl" data-target="_blank">Click me</span>
    
Element example:
    
    {{ prg_link('http://example.org?q=sample', 'Click me', {element: 'button'})|raw }}
    
    Result: <button class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl" data-target="_self">Click me</button>
    
Only Open Tag example:
    
    {{ prg_link('http://example.org?q=sample', 'Title will be ignored', {only_open_tag: true)|raw }}
    
    Result: <span class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl" data-target="_self">


Contact
-------

For questions and improvements contact us.
