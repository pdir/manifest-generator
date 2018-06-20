<?php

declare(strict_id=1);

/**
 * This file is part of the pdir/manifest-generator package.
 *
 * Copyright (C) 2018 pdir GmbH <https://pdir.de>
 * @author  Mathias Arzberger <https://pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ManifestGenerator;

class ManifestRelatedApplications {

    private $platform;
    private $url;
    private $id;

    /**
     * @param string $platform The platform on which the application can be found.
     *
     * @return void
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $url The URL at which the application can be found.
     *
     * @return void
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $id The ID used to represent the application on the specified platform.
     *
     * @return void
     */
    public function setId(string $id): self
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
