# JBZoo Mermaid-PHP  [![Latest Stable Version](https://poser.pugx.org/JBZoo/Mermaid-PHP/v/stable)](https://packagist.org/packages/JBZoo/Mermaid-PHP) [![License](https://poser.pugx.org/JBZoo/Mermaid-PHP/license)](https://packagist.org/packages/JBZoo/Mermaid-PHP) [![Build Status](https://travis-ci.org/JBZoo/Mermaid-PHP.svg?branch=master)](https://travis-ci.org/JBZoo/Mermaid-PHP) [![Coverage Status](https://coveralls.io/repos/github/JBZoo/Mermaid-PHP/badge.svg?branch=master)](https://coveralls.io/github/JBZoo/Mermaid-PHP?branch=master)

### Usage

```php
<?php

use JBZoo\MermaidPHP\Graph;
use JBZoo\MermaidPHP\Link;
use JBZoo\MermaidPHP\Node;

require_once './vendor/autoload.php';

$graph = (new Graph(['abc_order' => true]))
    ->addSubGraph($subGraph1 = new Graph(['title' => 'Main workflow']))
    ->addSubGraph($subGraph2 = new Graph(['title' => 'Problematic workflow']))
    ->addStyle('linkStyle default interpolate basis');

$subGraph1
    ->addNode($nodeE = new Node('E', 'Result two', Node::SQUARE))
    ->addNode($nodeB = new Node('B', 'Round edge', Node::ROUND))
    ->addNode($nodeA = new Node('A', 'Hard edge', Node::SQUARE))
    ->addNode($nodeC = new Node('C', 'Decision', Node::CIRCLE))
    ->addNode($nodeD = new Node('D', 'Result one', Node::SQUARE))
    ->addLink(new Link($nodeE, $nodeD))
    ->addLink(new Link($nodeB, $nodeC))
    ->addLink(new Link($nodeC, $nodeD, 'A double quote:"'))
    ->addLink(new Link($nodeC, $nodeE, 'A dec char:♥'))
    ->addLink(new Link($nodeA, $nodeB, ' Link text<br>/\\!@#$%^&*()_+><\' " '));

$subGraph2
    ->addNode($alone = new Node('alone', 'Alone'))
    ->addLink(new Link($alone, $nodeC));

echo $graph; // Get result as string (or $graph->__toString(), or (string)$graph)
$htmlCode = $graph->renderHtml([
    'debug'      => true,
    'version'   => '8.5.1',
    'title'     => 'Example',
    'show-zoom' => true
]); // Get result as HTML code for debugging

echo $graph->getLiveEditorUrl(); // Get link to live editor 
```

### Result
[Open live editor](https://mermaid-js.github.io/mermaid-live-editor/#/edit/eyJjb2RlIjoiZ3JhcGggVEI7XG4gICAgc3ViZ3JhcGggXCJNYWluIHdvcmtmbG93XCJcbiAgICAgICAgRVtcIlJlc3VsdCB0d29cIl07XG4gICAgICAgIEIoXCJSb3VuZCBlZGdlXCIpO1xuICAgICAgICBBW1wiSGFyZCBlZGdlXCJdO1xuICAgICAgICBDKChcIkRlY2lzaW9uXCIpKTtcbiAgICAgICAgRFtcIlJlc3VsdCBvbmVcIl07XG4gICAgICAgIEUtLT5EO1xuICAgICAgICBCLS0+QztcbiAgICAgICAgQy0tPnxcIkEgZG91YmxlIHF1b3RlOiNxdW90O1wifEQ7XG4gICAgICAgIEMtLT58XCJBIGRlYyBjaGFyOiNoZWFydHM7XCJ8RTtcbiAgICAgICAgQS0tPnxcIkxpbmsgdGV4dDxicj5cL1xcIUAjJCVeI2FtcDsqKClfKz48JyAjcXVvdDtcInxCO1xuICAgIGVuZFxuICAgIHN1YmdyYXBoIFwiUHJvYmxlbWF0aWMgd29ya2Zsb3dcIlxuICAgICAgICBhbG9uZShcIkFsb25lXCIpO1xuICAgICAgICBhbG9uZS0tPkM7XG4gICAgZW5kXG5saW5rU3R5bGUgZGVmYXVsdCBpbnRlcnBvbGF0ZSBiYXNpczsiLCJtZXJtYWlkIjp7InRoZW1lIjoiZm9yZXN0In19)

```
graph TB;
    subgraph "Main workflow"
        E["Result two"];
        B("Round edge");
        A["Hard edge"];
        C(("Decision"));
        D["Result one"];
        E-->D;
        B-->C;
        C-->|"A double quote:#quot;"|D;
        C-->|"A dec char:#hearts;"|E;
        A-->|"Link text<br>/\!@#$%^#amp;*()_+><' #quot;"|B;
    end
    subgraph "Problematic workflow"
        alone("Alone");
        alone-->C;
    end
linkStyle default interpolate basis;
```


### See also
 - [Mermaid on GitHub](https://github.com/knsv/mermaid)
 - [Mermaid Documentation](https://mermaidjs.github.io/)


## Unit tests and check code style
```sh
make update
make test-all
```


## License

MIT
