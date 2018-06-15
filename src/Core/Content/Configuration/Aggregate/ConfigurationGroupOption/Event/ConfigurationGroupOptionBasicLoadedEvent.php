<?php declare(strict_types=1);

namespace Shopware\Core\Content\Configuration\Aggregate\ConfigurationGroupOption\Event;

use Shopware\Core\Content\Configuration\Aggregate\ConfigurationGroupOption\Collection\ConfigurationGroupOptionBasicCollection;
use Shopware\Core\Content\Configuration\Event\ConfigurationGroupBasicLoadedEvent;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\Event\NestedEventCollection;

class ConfigurationGroupOptionBasicLoadedEvent extends NestedEvent
{
    public const NAME = 'configuration_group_option.basic.loaded';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ConfigurationGroupOptionBasicCollection
     */
    protected $configurationGroupOptions;

    public function __construct(ConfigurationGroupOptionBasicCollection $configurationGroupOptions, Context $context)
    {
        $this->context = $context;
        $this->configurationGroupOptions = $configurationGroupOptions;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getConfigurationGroupOptions(): ConfigurationGroupOptionBasicCollection
    {
        return $this->configurationGroupOptions;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configurationGroupOptions->getGroups()->count() > 0) {
            $events[] = new ConfigurationGroupBasicLoadedEvent($this->configurationGroupOptions->getGroups(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}
