<?php

/**
 * This file is part of the pdir/manifest-generator package.
 *
 * Copyright (C) 2018 pdir GmbH <https://pdir.de>
 * @author  Mathias Arzberger <https://pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pdir\ManifestGenerator;

class ManifestGenerator
{
    /**
     * @var Fields
     */
    private $fields;

    /**
     * @param iterable $fields ManifestFields object or fields array
     */
    public function __construct(iterable $fields = [])
    {
        if (!$fields instanceof ManifestFields) {
            $fields = new ManifestFields($fields);
        }
        $this->fields = $fields;
    }

    /**
     * Generate a manifest from the specified fields.
     *
     * @param iterable $fields ManifestFields object or fields array
     *
     * @return array
     */
    public function toJSON(iterable $fields = []): string
    {
        $this->fields = $this->fields->check($fields);
        return json_encode($this->toArray());
    }

    public function getDefaultValues(iterable $fields = []): array
    {
        // $this->fields = $this->fields->getDefaultValues($fields);
        // return;
    }

    public function toArray(): array
    {
        return [
            'background_color' => $this->fields->getBackgroundColor(),
            'description' => $this->fields->getDescription(),
            'dir' => $this->fields->getDir(),
            'display' => $this->fields->getDisplay(),
            'icons' => $this->fields->getIcons(),
            'lang' => $this->fields->getLang(),
            'name' => $this->fields->getName(),
            'orientation' => $this->fields->getOrientation(),
            'prefer_related_applications' => $this->fields->getPreferRelatedApplications(),
            'related_applications' => $this->fields->getRelatedApplications(),
            'scope' => $this->fields->getScope(),
            'short_name' => $this->fields->getShortName(),
            'start_url' => $this->fields->getStartUrl(),
            'theme_color' => $this->fields->getThemeColor(),
        ];
    }
}
