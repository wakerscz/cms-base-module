<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

namespace Wakers\BaseModule\Util;


use Nette\Http\FileUpload;
use Nette\InvalidArgumentException;
use Nette\Utils\DateTime;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Wakers\BaseModule\Util\Exception\ProtectedFileException;


class ProtectedFile
{
    /**
     * Výchozí cesty
     */
    const
        PRIVATE_ABSOLUTE_PATH = __DIR__ . '/../../../../../assets/dynamic/',
        PUBLIC_ABSOLUTE_PATH = __DIR__ . '/../../../../../www/temp/dynamic/',
        PUBLIC_RELATIVE_PATH = '/temp/dynamic/';


    /**
     * Kvalita zmenšovaných obrázků
     */
    const IMAGE_QUALITY = 75;


    /**
     * Typy ořezů
     */
    const CROP_TYPES = [
        Image::FIT => 'fit',
        Image::FILL => 'fill',
        Image::EXACT => 'exact',
        Image::SHRINK_ONLY => 'shrink_only',
        Image::STRETCH => 'stretch'
    ];


    /**
     * Maximální délka nýzvu souboru
     */
    const MAX_FILE_NAME_LENGTH = 100;


    /**
     * Název privátního souboru
     * @var string|NULL
     */
    protected $privateFileName;


    /**
     * Absolutní cesta k privátní složce
     * @var string
     */
    protected $destination;


    /**
     * Atributy souboru
     * @var array
     */
    protected $attr = [];


    /**
     * ProtectedFile constructor.
     * @param string $destination
     * @param string|NULL $fileName
     */
    public function __construct(string $destination, ?string $fileName)
    {
        $this->destination = $destination;
        $this->privateFileName = $fileName;
    }


    /**
     * Nastavuje vlastní atributy
     * @param string $name
     * @param $value mixed
     */
    public function setAttr(string $name, $value) : void
    {
        $this->attr[$name] = $value;
    }


    /**
     * Uloží soubor na disk a vrátí jeho nový název
     * @param FileUpload $file
     * @return string
     * @throws ProtectedFileException
     */
    public function move(FileUpload $file) : ?string
    {
        if ($file->isOk())
        {
            $this->privateFileName = (new DateTime())->getTimestamp() . '-' . $file->getSanitizedName();

            $length = strlen($this->privateFileName);

            if ($length > self::MAX_FILE_NAME_LENGTH)
            {
                $maxLength = self::MAX_FILE_NAME_LENGTH;

                throw new ProtectedFileException("Maximal length of file name is '{$maxLength}' chars. File name: '{$file->getSanitizedName()}' have {$length} chars.");
            }

            $privateFilePath = self::PRIVATE_ABSOLUTE_PATH . $this->destination . $this->privateFileName;

            if (file_exists($privateFilePath))
            {
                throw new ProtectedFileException("File '{$this->privateFileName}' already exists. Maybe anyone upload same file at same time.");
            }

            FileSystem::createDir(self::PRIVATE_ABSOLUTE_PATH . $this->destination);
            $file->move($privateFilePath);
        }

        return $this->privateFileName;
    }


    /**
     * Vrací atribut podle jeho názvu
     * @param string $name
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function getAttr(string $name)
    {
        if (!isset($this->attr[$name]))
        {
            return NULL;
        }

        return $this->attr[$name];
    }


    /**
     * Vrací SplInfo o privátním souboru
     * @return \SplFileInfo|NULL
     */
    public function getPrivateFile() : ?\SplFileInfo
    {
        $path = self::PRIVATE_ABSOLUTE_PATH . $this->destination . $this->privateFileName;

        if (!$this->privateFileName || !file_exists($path))
        {
            return NULL;
        }

        return new \SplFileInfo($path);
    }


    /**
     * Odstraní privátní soubor a jeho veřejné kopie či thumbnaily
     * @return bool
     */
    public function remove() : bool
    {
        $private = self::PRIVATE_ABSOLUTE_PATH . $this->destination . $this->privateFileName;
        $public = self::PUBLIC_ABSOLUTE_PATH . $this->destination;

        if (file_exists($private) || file_exists($public))
        {
            FileSystem::delete($private);
            FileSystem::delete($public);

            return TRUE;
        }

        return FALSE;
    }


    /**
     * Generuje či Vrací kopii souboru
     * @return string|NULL
     */
    public function getPublicFile() : ?string
    {
        $publicDestination = self::PUBLIC_ABSOLUTE_PATH . $this->destination;
        $privateFile = $this->getPrivateFile();

        if (!$this->privateFileName || !file_exists($privateFile->getPathname()))
        {
            return NULL;
        }

        $name = $privateFile->getFilename();

        if (!file_exists($publicDestination . $name))
        {
            FileSystem::copy($privateFile->getPathname(), $publicDestination . $name);
        }

        return self::PUBLIC_RELATIVE_PATH . $this->destination . $name;
    }


    /**
     * Generuje či Vrací kopii zmenšeného obrázku
     * @param string $size
     * @param string $cropType
     * @return string
     * @throws \Nette\Utils\UnknownImageFileException
     */
    public function getPublicImage(string $size, string $cropType) : string
    {
        $size = strtolower($size);
        $cropType = strtolower($cropType);

        list ($width, $height) = explode('x', $size);

        $width = $width === 'null' ? NULL : $width;
        $height = $height === 'null' ? NULL : $height;

        if (!$width && !$height)
        {
            throw new InvalidArgumentException("One of this parameters: 'size-width' or 'size-height' is required.");
        }

        if (!array_search($cropType, self::CROP_TYPES))
        {
            $allowedArguments = implode(', ', self::CROP_TYPES);
            throw new InvalidArgumentException("Argument \$cropType '{$cropType}' is invalid. Allowed arguments are '{$allowedArguments}'");
        }

        $privateFile = $this->getPrivateFile();

        if ($privateFile)
        {
            $name = basename($privateFile->getFilename(), '.' . $privateFile->getExtension());
            $name .= "---{$width}x{$height}-{$cropType}." . $privateFile->getExtension();
        }
        else
        {
            $this->destination = 'no-image/';
            $name = "no-image---{$width}x{$height}-{$cropType}.jpg";
        }

        $publicFilePath = self::PUBLIC_ABSOLUTE_PATH . $this->destination;

        if (!file_exists($publicFilePath . $name))
        {
            if (!is_dir($publicFilePath))
            {
                FileSystem::createDir($publicFilePath);
            }

            if ($privateFile)
            {
                $image = Image::fromFile($privateFile->getPathname());
            }
            else
            {
                $width = (!$width) ? $height / 2 : $width;
                $height = (!$height) ? $width / 2 : $height;
                $image = Image::fromBlank($width, $height, Image::rgb(204,204,204));
            }

            $image->resize($width, $height, array_search($cropType, self::CROP_TYPES));
            $image->save($publicFilePath . $name, self::IMAGE_QUALITY);
        }

        return  self::PUBLIC_RELATIVE_PATH . $this->destination . $name;
    }
}