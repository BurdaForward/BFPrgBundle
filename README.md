CHIPPrgBundle
=============

The CHIPPrgBundle adds support for masking urls based on PRG-Pattern.

For more information about this pattern please take a closer look to the
following url: [Post/Redirect/Get](https://en.wikipedia.org/wiki/Post/Redirect/Get)

**Note:** This bundle is built for use in a symfony application.


Installation & Setup
--------------------

1. Run ```composer require BurdaForward/BFPrgBundle``` or download teh bundle to you local vendor directory
2. Activate this bundle in your ```app/AppKernel.php```

    ```php
    ...
    
    class AppKernel extends Kernel
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

3. Add the bundle to your ```app/config/routing.yml```
 
    ```yaml
      prg:
         resource: "@BFPrgBundle/Resources/config/routing.yml"
    ```
    
    This rounting.yml enables a required route ```/prg_resolve```.

4. In the last step you have incldue the basic template of that bundle into your templates.
  
    (Best position is before closing body tag.)
  
    ```twig
    {% include '@Prg/prg_form.html.twig' %}  
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
          element: the default is "span" but if you want to render a "button" or "div" you can set it with this option


Basic example:

    {{ prg_link('http://example.org?q=sample', 'Click me')|raw }}
    
    Result: <span class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl">Click me</span>
    
    
Stylesheet example:
    
    {{ prg_link('http://example.org?q=sample', 'Click me', {class: 'my-link'})|raw }}
    
    Result: <span class="prg-link my-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl">Click me</span>
    
Element example:
    
    {{ prg_link('http://example.org?q=sample', 'Click me', {element: 'button'})|raw }}
    
    Result: <button class="prg-link" data-submit="aHR0cDovL2V4YW1wbGUub3JnP3E9c2FtcGxl">Click me</button>
