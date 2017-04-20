<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

use JsonSerializable;
use ReflectionMethod;
use ReflectionObject;
use ReflectionProperty;

define('TB_JSON_FIELD_STYLE_CAMEL', 1);
define('TB_JSON_FIELD_STYLE_DELIMITED', 2);
define('TB_JSON_FIELD_STYLE_ANY', 3);

/**
 * Description of JsonObject
 *
 * @author JosephT
 */
abstract class JSONSerializableObject implements JsonSerializable {

    /**
     *
     * @var string[] names of fields to ignore
     */
    protected static $jsonIgnoreFields = array();
    public static $JSON_FIELD_STYLE = TB_JSON_FIELD_STYLE_ANY;
    /**
     *
     * @var callable[] callables to pass fields through,
     */
    public static $jsonFieldFilterMap = [];

    
    public static function jsonFilterMap($map) {
        if (!is_array($map)) {
            $map = [$map];
        }

        static::$jsonFieldFilterMap = array_merge(static::$jsonFieldFilterMap, $map);
    }
    
    public static function jsonIgnoreField($fld) {
        if (!is_array($fld)) {
            $fld = [$fld];
        }

        static::$jsonIgnoreFields = array_merge(static::$jsonIgnoreFields, $fld);
    }

    //put your code here
    public function jsonSerialize() {
        //->format(DateTime::ISO8601)
        $reflect = new ReflectionObject($this);

        $propertyFilter = ReflectionProperty::IS_PUBLIC;
        $ignores = static::$jsonIgnoreFields;
        if (method_exists($this, '__ignoredJsonFields')) {
            $ignores = array_merge($ignores, (array) $this->__ignoredJsonFields());
        }

        $data = array();
        foreach ($reflect->getProperties($propertyFilter) as $property) {
            /* @var $property ReflectionProperty */
            if (!$property->isStatic()) {
                $propertyName = $property->getName();
                if (!in_array($propertyName, $ignores)) {
                    $txName = static::jsonGetFieldName($propertyName);
                    $data[$txName] =  $property->getValue($this);
                    if(isset(static::$jsonFieldFilterMap[$propertyName]) && is_callable($fn = static::$jsonFieldFilterMap[$propertyName])){
                        $data[$txName] = $fn($data[$txName]);
                    }
                }
            }
        }

        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            /* @var $method ReflectionMethod */
            $matches = array();
            if (!$method->isStatic() && preg_match('/(is|get)_?(.+)/', $method->getName(), $matches) && ($method->getNumberOfParameters() == 0 || $method->getNumberOfRequiredParameters() == 0)) {
                $varName = lcfirst($matches[2]);
                $varName2 = StrUtils::camelCaseToDelimited($varName);
                if (!in_array($varName, $ignores) && !in_array($varName2, $ignores)) {
                    $data[static::jsonGetFieldName($varName)] = call_user_func(array($this, $method->getName()));
                }
            }
        }

        return $data;
    }

    protected static function jsonGetFieldName($v) {
        if (static::$JSON_FIELD_STYLE === TB_JSON_FIELD_STYLE_CAMEL) {
            return preg_match('/_/', $v) ? StrUtils::delimetedToCamelCased($v) : $v;
        } else if (static::$JSON_FIELD_STYLE === TB_JSON_FIELD_STYLE_DELIMITED) {
            return StrUtils::camelCaseToDelimited($v);
        } else {
            return $v;
        }
    }

}
