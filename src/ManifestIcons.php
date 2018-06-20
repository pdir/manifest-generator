<?php

declare(strict_types=1);

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

class ManifestIcons {

    private $src;
    private $sizes;
    private $type;

    /**
     * @param string $src The path to the image file. If src is a relative URL, the base URL will be the URL of the manifest.
     *
     * @return void
     */
    public function setSrc(string $src): self
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @param string $sizes A string containing space-separated image dimensions.
     *
     * @return void
     */
    public function setSizes(string $sizes): self
    {
        $this->sizes = $sizes;
    }

    /**
     * @return string
     */
    public function getSizes(): string
    {
        return $this->sizes;
    }

    /**
     * @param string $type
     * A hint as to the media type of the image. The purpose of this member is to allow a user agent to quickly ignore
     * images of media types it does not support.
     *
     * @return void
     */
    public function setType(string $type): self
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
