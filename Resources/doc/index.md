# Getting started with VipxBotDetectBundle

Imagine you want to hide some content of your application from bots like Google or Yahoo. This bundle adds a detector which detects a bot by its agent and/or ip.

It is also possible to add a predefined listener which automatically authenticate a bot when a request is done.

## Installation

### Download using Composer

First you need to add VipxBotDetectBundle to your `composer.json` file:

``` js
{
    "require": {
        "vipx/bot-detect-bundle": "*",
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update vipx/bot-detect-bundle
```

Composer will install the bundle to `vendor/vipx/bot-detect-bundle`.

### Enable the Bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Vipx\BotDetectBundle\VipxBotDetectBundle(),
    );
}
```

## Usage

Using the bundle is easy as using the detector service `vipx_bot_detect.detector`:

``` php
<?php

namespace Acme\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BotController extends Controller
{

    public function indexAction()
    {
        $detector = $this->get('vipx_bot_detect.detector');
        $botMetadata = $detector->detect($this->getRequest());

        if (null === $botMetadata) {
            return new Response('No bot is visiting.');
        }

        return new Response(sprintf('Ah, you are a %s. Hello %s.', $botMetadata->getType(), $botMetadata->getName()));
    }

}
```

## Configuration

### Resource File

The bundle comes shipped with two different metadata files. The `basic.yml` file holds the main known bots. The `extended.yml` also has informations about some spam bots, spiders and crawlers of smaller web services.

__Notice:__ Keep in mind, that the `extended.yml` metadata file is much bigger than the `basic.yml` file. Therefor the detector needs much longer to search threw the given informations.

The bundle is preconfigured to use the `basic.yml` file if needed. To change it, you can simply change the configuration:

``` yaml
vipx_bot_detect:
    resource: "@VipxBotDetectBundle/Resources/metadata/extended.yml"
```

### Cache File

To speed up the detection of bots, the detector caches the metadata configuration resource to an executable cache file. To change that behaviour, you can simply change the `cache_file` to null (turn of the cache) or change it to a value of your choice. E.g.:

``` yaml
vipx_bot_detect:
    cache_file: ~ # or a special file name
```

### Automatically authenticate Bots

The bundle also has a listener, which when turned on authenticates visting bots e.g. to use this information in your controller. To enable the listener you must change `use_listener` to `true`. (Defaults to `false`).

``` yaml
vipx_bot_detect:
    use_listener: true
```

Now the `security.context` service holds a special bot token with informations about the visiting bot. This token also has the `ROLE_BOT` role now, which you can simply use in your controller.

``` php
<?php

namespace Acme\BotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Vipx\BotDetectBundle\Security\BotToken;

class BotController extends Controller
{

    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_BOT')) {
            // The bot is not allowed to access this controller
            throw new AccessDeniedException();
        }

        // or

        $token = $this->get('security.context')->getToken();

        if ($token instanceof BotToken) {
            $botMetadata = $token->getMetadata();

            // Google? No way. Keep out ...
        }

        // ...
    }

}
```