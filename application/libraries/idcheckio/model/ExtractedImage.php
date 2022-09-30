<?php
/**
 * ExtractedImage
 *
 * PHP version 5
 *
 * @category Class
 * @package  idcheckio
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * IdCheck.IO API
 *
 * Check identity documents
 *
 * OpenAPI spec version: 0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace idcheckio\model;

use \ArrayAccess;

/**
 * ExtractedImage Class Doc Comment
 *
 * @category    Class
 * @package     idcheckio
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ExtractedImage implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'ExtractedImage';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'type' => 'string',
        'image_dl' => 'string',
        'image_ir' => 'string',
        'image_uv' => 'string',
        'page' => 'int',
        'indicators' => '\idcheckio\model\ImageIndicator[]'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'type' => 'type',
        'image_dl' => 'imageDL',
        'image_ir' => 'imageIR',
        'image_uv' => 'imageUV',
        'page' => 'page',
        'indicators' => 'indicators'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'type' => 'setType',
        'image_dl' => 'setImageDl',
        'image_ir' => 'setImageIr',
        'image_uv' => 'setImageUv',
        'page' => 'setPage',
        'indicators' => 'setIndicators'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'type' => 'getType',
        'image_dl' => 'getImageDl',
        'image_ir' => 'getImageIr',
        'image_uv' => 'getImageUv',
        'page' => 'getPage',
        'indicators' => 'getIndicators'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    const TYPE_RECTO = 'CROPPED_RECTO';
    const TYPE_VERSO = 'CROPPED_VERSO';
    const TYPE_FACE = 'CROPPED_FACE';
    const TYPE_SIGNATURE = 'CROPPED_SIGNATURE';
    const TYPE_EMITTER_SIGNATURE = 'CROPPED_EMITTER_SIGNATURE';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_RECTO,
            self::TYPE_VERSO,
            self::TYPE_FACE,
            self::TYPE_SIGNATURE,
            self::TYPE_EMITTER_SIGNATURE,
        ];
    }
    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['type'] = isset($data['type']) ? $data['type'] : null;
        $this->container['image_dl'] = isset($data['image_dl']) ? $data['image_dl'] : null;
        $this->container['image_ir'] = isset($data['image_ir']) ? $data['image_ir'] : null;
        $this->container['image_uv'] = isset($data['image_uv']) ? $data['image_uv'] : null;
        $this->container['page'] = isset($data['page']) ? $data['page'] : null;
        $this->container['indicators'] = isset($data['indicators']) ? $data['indicators'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if ($this->container['type'] === null) {
            $invalid_properties[] = "'type' can't be null";
        }
        $allowed_values = ["CROPPED_RECTO", "CROPPED_VERSO", "CROPPED_FACE", "CROPPED_SIGNATURE", "CROPPED_EMITTER_SIGNATURE"];
        if (!in_array($this->container['type'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'type', must be one of 'CROPPED_RECTO', 'CROPPED_VERSO', 'CROPPED_FACE', 'CROPPED_SIGNATURE', 'CROPPED_EMITTER_SIGNATURE'.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if ($this->container['type'] === null) {
            return false;
        }
        $allowed_values = ["CROPPED_RECTO", "CROPPED_VERSO", "CROPPED_FACE", "CROPPED_SIGNATURE", "CROPPED_EMITTER_SIGNATURE"];
        if (!in_array($this->container['type'], $allowed_values)) {
            return false;
        }
        return true;
    }


    /**
     * Gets type
     * @return string
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $allowed_values = array('CROPPED_RECTO', 'CROPPED_VERSO', 'CROPPED_FACE', 'CROPPED_SIGNATURE', 'CROPPED_EMITTER_SIGNATURE');
        if ((!in_array($type, $allowed_values))) {
            throw new \InvalidArgumentException("Invalid value for 'type', must be one of 'CROPPED_RECTO', 'CROPPED_VERSO', 'CROPPED_FACE', 'CROPPED_SIGNATURE', 'CROPPED_EMITTER_SIGNATURE'");
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets image_dl
     * @return string
     */
    public function getImageDl()
    {
        return $this->container['image_dl'];
    }

    /**
     * Sets image_dl
     * @param string $image_dl
     * @return $this
     */
    public function setImageDl($image_dl)
    {
        $this->container['image_dl'] = $image_dl;

        return $this;
    }

    /**
     * Gets image_ir
     * @return string
     */
    public function getImageIr()
    {
        return $this->container['image_ir'];
    }

    /**
     * Sets image_ir
     * @param string $image_ir
     * @return $this
     */
    public function setImageIr($image_ir)
    {
        $this->container['image_ir'] = $image_ir;

        return $this;
    }

    /**
     * Gets image_uv
     * @return string
     */
    public function getImageUv()
    {
        return $this->container['image_uv'];
    }

    /**
     * Sets image_uv
     * @param string $image_uv
     * @return $this
     */
    public function setImageUv($image_uv)
    {
        $this->container['image_uv'] = $image_uv;

        return $this;
    }

    /**
     * Gets page
     * @return int
     */
    public function getPage()
    {
        return $this->container['page'];
    }

    /**
     * Sets page
     * @param int $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->container['page'] = $page;

        return $this;
    }

    /**
     * Gets indicators
     * @return \idcheckio\model\ImageIndicator[]
     */
    public function getIndicators()
    {
        return $this->container['indicators'];
    }

    /**
     * Sets indicators
     * @param \idcheckio\model\ImageIndicator[] $indicators
     * @return $this
     */
    public function setIndicators($indicators)
    {
        $this->container['indicators'] = $indicators;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\idcheckio\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\idcheckio\ObjectSerializer::sanitizeForSerialization($this));
    }
}


