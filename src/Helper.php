<?php
/**
 * JBZoo MermaidPHP
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    MermaidPHP
 * @license    MIT
 * @copyright  Copyright (C) JBZoo.com, All rights reserved.
 * @link       https://github.com/JBZoo/MermaidPHP
 */

namespace JBZoo\MermaidPHP;

/**
 * Class Helper
 * @package JBZoo\MermaidPHP
 */
class Helper
{
    public const DEFAULT_VERSION = '8.4.3';

    /**
     * @param Graph         $graph
     * @param array<String> $params
     * @return string
     */
    public static function renderHtml(Graph $graph, array $params = []): string
    {
        //bool $showCode = false, string $version =
        $version = $params['version'] ?? self::DEFAULT_VERSION;
        $isDebug = $params['debug'] ?? false;
        $title = $params['title'] ?? '';

        $scriptUrl = "https://unpkg.com/mermaid@{$version}/dist/mermaid.js";

        // @see https://mermaid-js.github.io/mermaid/#/mermaidAPI?id=loglevel
        $mermaidParams = \json_encode([
            'startOnLoad'         => true,
            'theme'               => 'forest', // default, forest, dark, neutral
            'themeCSS'            => implode(PHP_EOL, [
                '.edgePath .path:hover{stroke-width: 2px}',
                '.edgeLabel {border-radius: 4px}',
                '.label { font-family: Source Sans Pro,Helvetica Neue,Arial,sans-serif; }',
            ]),
            'loglevel'            => 'debug',
            'securityLevel'       => 'loose',
            'arrowMarkerAbsolute' => true,
            'flowchart'           => [
                'htmlLabels'  => true,
                'useMaxWidth' => true,
                'curve'       => 'basis',
            ],
        ], JSON_PRETTY_PRINT);

        $debugCode = '';
        if ($isDebug) {
            $debugCode .= '<hr>';
            $debugCode .= '<pre><code>' . htmlentities((string)$graph) . '</code></pre>';
            $debugCode .= '<hr>';
            $graphParams = \json_encode($graph->getParams(), JSON_PRETTY_PRINT);
            $debugCode .= "<pre><code>Params = {$graphParams}</code></pre>";
        }

        return implode(PHP_EOL, [
            '<!DOCTYPE html>',
            '<html lang="en">',
            '<head>',
            '    <meta charset="utf-8">',
            '   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>',
            "   <script src=\"{$scriptUrl}\"></script>",
            '</head>',
            '<body>',
            $title ? "<h1>{$title}</h1><hr>" : '',
            '    <div class="mermaid" style="margin-top:20px;">' . $graph . '</div>',
            '    <input type="button" class="btn btn-primary" id="zoom" value="Zoom In">',
            $debugCode,
            "    <script>
                     mermaid.initialize({$mermaidParams});
                     $(function () {
                        $('#zoom').click(() => {
                            $('.mermaid').removeAttr('data-processed');
                            $('.mermaid').width($('.mermaid svg').css('max-width'));
                        });
                     });
                </script>",
            '</body>',
            '</html>',
        ]);
    }

    /**
     * @param string $text
     * @return string
     */
    public static function escape(string $text): string
    {
        $text = trim($text);
        $text = htmlentities($text);

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $text = str_replace(['&', '#lt;', '#gt;'], ['#', '<', '>'], $text);

        return "\"{$text}\"";
    }
}
