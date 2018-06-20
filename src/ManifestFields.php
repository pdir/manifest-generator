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

class ManifestFields implements \IteratorAggregate
{
    /**
     * @var string
     */
    private $backgroundColor;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $dir;

    private $dirValues = [
        'ltr',
        'rtl',
        'auto',
    ];

    /**
     * @var string
     */
    private $display;

    private $displayValues = [
        'standalone',
        'fullscreen',
        'minimal-ui',
        'browser'
    ];

    /**
     * @var string
     */
    private $icons = [];

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $orientation;

    private $orientationValues = [
        'any',
        'natural',
        'landscape',
        'landscape-primary',
        'landscape-secondary',
        'portrait',
        'portrait-primary',
        'portrait-secondary'
    ];

    /**
     * @var string
     */
    private $preferRelatedApplications = 'false';

    /**
     * @var string[]
     */
    private $relatedApplications = [];

    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @var string
     */
    private $startUrl;

    /**
     * @var string
     */
    private $themeColor;

    /**
     * @var array
     */
    private $setFields = [];

    /**
     * @param iterable $fields See the setter methods for available fields
     */
    public function __construct(iterable $fields = [])
    {
        foreach ($fields as $field => $value) {
            $this->assertFieldsName($field);
            $this->{'set'.ucfirst($field)}($value);
        }
    }

    /**
     * Get an iterator for all fields that have been explicitly set.
     *
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        $fields = [];
        foreach ($this->setFields as $field => $value) {
            $fields[$field] = $this->{'get'.ucfirst($field)}();
        }
        return new \ArrayIterator($fields);
    }

    /**
     * @param string $fields
     *
     * @throws \InvalidArgumentException If it’s an invalid field name
     */
    private function assertFieldsName(string $field): void
    {
        static $validFields = [
            'backgroundColor',
            'description',
            'dir',
            'display',
            'icons',
            'lang',
            'name',
            'orientation',
            'preferRelatedApplications',
            'relatedApplications',
            'scope',
            'shortName',
            'startUrl',
            'themeColor',
        ];
        if (!in_array($field, $validFields, true)) {
            throw new \InvalidArgumentException(sprintf('Unknown field "%s"', $field));
        }
    }

    /**
     * Get default values and merge existing fields with and return a new fields object.
     *
     * @param iterable $fields ManifestFields object or fields array
     *
     * @return static
     */
    public function getDefaultValues(iterable $fields): self
    {
        $merged = clone $this;

        foreach ($fields as $field => $value) {
            $this->assertFieldsName( $this->matchToUpper($field) );
            $merged->{'set'.ucfirst($this->matchToUpper($field))}($value);
        }

        return $merged;
    }

    /**
     * Check the fields with default values and return a new fields object.
     *
     * @param iterable $fields ManifestFields object or fields array
     *
     * @return static
     */
    public function check(iterable $fields): self
    {
        $check = clone $this;

        foreach ($fields as $field => $value) {
            $this->assertFieldsName( $this->matchToUpper($field) );
            $check->{'set'.ucfirst($this->matchToUpper($field))}($value);
        }

        return $check;
    }

    /**
     * Capitalize each word that follows an underscore
     *
     * @param string $str Field name
     *
     * @return string
     */
    public function matchToUpper($str): string
    {
        $str = implode('', array_map(ucfirst, explode('_', $str)));
        return lcfirst($str);
    }

    /**
     * Get all fields.
     *
     * @return array Array of fields
     */
    public function getFields(): array
    {
        return (array) $this;
    }

    /**
     * @param string $backgroundColor
     * Defines the expected “background color” for the website. This value repeats what is already available in the site’s CSS,
     * but can be used by browsers to draw the background color of a shortcut when the manifest is available before the stylesheet
     * has loaded. This creates a smooth transition between launching the web application and loading the site's content.
     *
     * @return static
     */
    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = strpos($backgroundColor, '#') !== false ? $backgroundColor : '#' . $backgroundColor;
        $this->setFields['backgroundColor'] = null;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $description Provides a general description of what the pinned website does.
     *
     * @return static
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        $this->setFields['description'] = null;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $dir
     * Specifies the primary text direction for the name, short_name, and description members. Together with the lang
     * member, it helps the correct display of right-to-left languages.
     *
     * @return static
     */
    public function setDir(string $dir): self
    {
        $this->dir = $dir;
        $this->setFields['dir'] = null;
        return $this;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $display Defines the developers’ preferred display mode for the website.
     *
     * @return static
     */
    public function setDisplay(string $display): self
    {
        $this->display = $display;
        $this->setFields['display'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getDisplay(): string
    {
        return $this->display;
    }

    /**
     * @param string $icons
     * Specifies an array of image files that can serve as application icons, depending on context. For example, they
     * can be used to represent the web application amongst a list of other applications, or to integrate the web
     * application with an OS's task switcher and/or system preferences.
     *
     * @return static
     */
    public function setIcons(array $icons): self
    {
        $this->icons = $icons;
        $this->setFields['icons'] = null;
        return $this;
    }
    /**
     * @return array
     */
    public function getIcons(): array
    {
        return $this->icons;
    }

    /**
     * @param string $lang
     * Specifies the primary language for the values in the name and short_name members. This value is a string containing
     * a single language tag.
     *
     * @return static
     */
    public function setLang(string $lang): self
    {
        $this->lang = $lang;
        $this->setFields['lang'] = null;
        return $this;
    }
    /**
     * @return array
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $name Provides a human-readable name for the site when displayed to the user.
     *
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setFields['name'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $orientation Defines the default orientation for all the website's top level browsing contexts.
     *
     * @return static
     */
    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;
        $this->setFields['orientation'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    /**
     * @param string $preferRelatedApplications
     * Specifies a boolean value that hints for the user agent to indicate to the user that the specified native
     * applications (see below) are recommended over the website. This should only be used if the related native apps
     * really do offer something that the website can't.
     *
     * @return static
     */
    public function setPreferRelatedApplications(string $preferRelatedApplications): self
    {
        $this->preferRelatedApplications = $preferRelatedApplications;
        $this->setFields['preferRelatedApplications'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getPreferRelatedApplications(): string
    {
        return $this->preferRelatedApplications;
    }

    /**
     * @param string $relatedApplications
     * An array of native applications that are installable by, or accessible to, the underlying platform — for example,
     * a native Android application obtainable through the Google Play Store. Such applications are intended to be
     * alternatives to the website that provides similar/equivalent functionality — like the native app version of the
     * website.
     *
     * @return static
     */
    public function setRelatedApplications(array $relatedApplications): self
    {
        $this->relatedApplications = $relatedApplications;
        $this->setFields['relatedApplications'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getRelatedApplications(): array
    {
        return $this->relatedApplications;
    }

    /**
     * @param string $scope
     * Provides a short human-readable name for the application. This is intended for when there is insufficient space to
     * display the full name of the web application, like device homescreens.
     *
     * @return static
     */
    public function setScope(string $scope): self
    {
        $this->scope = $scope;
        $this->setFields['scope'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope ? $this->scope : '';
    }

    /**
     * @param string $shortName
     * Provides a short human-readable name for the application. This is intended for when there is insufficient space to
     * display the full name of the web application, like device homescreens.
     *
     * @return static
     */
    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;
        $this->setFields['shortName'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $startUrl
     * The URL that loads when a user launches the application (e.g. when added to home screen), typically the index.
     * Note that this has to be a relative URL, relative to the manifest url.
     *
     * @return static
     */
    public function setStartUrl(string $startUrl): self
    {
        $this->startUrl = $startUrl;
        $this->setFields['startUrl'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getStartUrl(): string
    {
        return $this->startUrl;
    }

    /**
     * @param string $themeColor
     * Defines the default theme color for an application. This sometimes affects how the OS displays the site (e.g.,
     * on Android's task switcher, the theme color surrounds the site).
     *
     * @return static
     */
    public function setThemeColor(string $themeColor): self
    {
        $this->themeColor = strpos($themeColor, '#') !== false ? $themeColor : '#' . $themeColor;
        $this->setFields['themeColor'] = null;
        return $this;
    }
    /**
     * @return string
     */
    public function getThemeColor(): string
    {
        return $this->themeColor;
    }
}