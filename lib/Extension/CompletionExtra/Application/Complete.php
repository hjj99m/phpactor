<?php

namespace Phpactor\Extension\CompletionExtra\Application;

use Phpactor\Completion\Core\Suggestion;
use Phpactor\Completion\Core\TypedCompletorRegistry;

class Complete
{
    /**
     * @var TypedCompletorRegistry
     */
    private $registry;

    public function __construct(TypedCompletorRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function complete(string $source, int $offset, string $type = 'php'): array
    {
        $completor = $this->registry->completorForType($type);
        $suggestions = $completor->complete($source, $offset);
        $suggestions = iterator_to_array($suggestions);
        $suggestions = array_map(function (Suggestion $suggestion) {
            return $suggestion->toArray();
        }, $suggestions);

        return [
            'suggestions' => $suggestions,

            // deprecated
            'issues' => [],
        ];
    }
}
